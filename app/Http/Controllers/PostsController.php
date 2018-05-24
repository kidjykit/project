<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use App\segment;
use App\thcharacter;
use App\unicode;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Zip;

class PostsController extends Controller
{
    //

    public function index(){

    	return view('posts.index');
    }

    public function show(){

    	return view('posts.show');
    }

    public function create(){

    	return view('posts.create');
    }

    public function login(){

        return view('auth.login');
    }

    public function register(){

        return view('auth.register');
    }

    public function file(){

        return view('posts.file');
    }

    public function apiview(){

        return view('posts.testapi');
    }

    public function apidoc(){

        return view('posts.apidoc');
    }

    public function allvis(){

        return view('posts.allvis');
    }

    public function modal(){

        return view('posts.modal');
    }

    public function segment(request $body){
        $this->validate(request(), [
            'body' => 'required'
        ]);
    	$text_to_segment = trim($body->get('body'));
      //echo $text_to_segment;
        $segment = new Segment();
        $result = $segment->get_segment_array($text_to_segment);
        $result1 = array_count_values($result);

        // sort จำนวนคำที่ค้นเจอ
        arsort($result1);

        //echo implode(' | ', $result);
        return view('posts.resultview', compact('result1'));
    }

    public function segmentfile(request $textfile){
        $this->validate(request(), [
            'textfile' => 'required'
        ]);
        $time_start = microtime(true);

        if(!empty($_FILES['textfile']['name'])){
            $result = array();
            $file = request()->allFiles();
            $segment = new Segment();
            $text_to_segment = "";
            for($i=0; $i<count($_FILES['textfile']['name']); $i++) {
                $textarray = " ";
                $content = " ";
                $shortname = $_FILES['textfile']['name'][$i];
                //echo $shortname."<br>";
                $content = $file['textfile'][$i]->openFile('r');
                foreach ($content as $linenum => $line) {
                    //echo $line;
                    $textarray = $textarray . $line;
                }
                $text_to_segment = trim($textarray);
                $result[$i][0] = $shortname;
                $result[$i][1] = array_values($segment->get_segment_array($text_to_segment));
                $result[$i][2] = array_count_values($result[$i][1]);
                $result[$i][3] = array_count_values(array_unique($result[$i][1]));
                arsort($result[$i][2]);
            }

            //Document Frequency Array.
            $df = $this->df($result);

            //TFIDF Array.
            $tfidf = $this->tfidf($result,$df);

//            $time_end = microtime(true);
//            $time = $time_end - $time_start;
//            echo '<br/><b>ประมวลผลใน: </b> '.round($time,4).' วินาที';
//        print_r($result);
//        dd($result);
        return view('posts.resultviewfile',['result' => $result, 'df' => $df, 'tfidf' => $tfidf]);
        }
    }

    // ใช้คำนวณหา Document Frequency.
    private function df($docArray){

        //print_r($docArray);
        $dfword = array();
        foreach ($docArray as $docIndex){
            //echo $docIndex[0].'<br>';
            foreach ($docIndex[3] as $docValue => $aa){
                //echo $docValue.' : '.$aa.'<br>';
                array_push($dfword,$docValue);
            }
        }
        $dfwordcount = array_count_values($dfword);
        return $dfwordcount;
    }

    // ใช้คำนวณหา Term Frequency Inverse Document Frequency.
    private function tfidf($tf,$idf){
        $tfidfword = array();
        foreach ($tf as $tfdoc){
            //$tfidfword[$tfdoc[0]][] = $tfdoc[0];
            //echo $tfidfword[0]."<br>";  //File Name.
            foreach ($tfdoc[2] as $tfword => $tfvalue){
                foreach ($idf as $idfword => $idfvalue){
                    if ($tfword==$idfword){
                        $tfidfvalue = $tfvalue*log(count($tf)/$idfvalue,10);
                        //  $tfdoc[0] >>> File Name.
                        //  $tfword   >>> Word.
                        //  $tfidfvalue >>> TFIDF of Word.
                        $tfidfword[$tfdoc[0]][$tfword] = $tfidfvalue;
//                        $tfidfword[$tfdoc[0]][1] = $tfidfvalue;
                        //echo "TFIDF OF ".$tfword ." = ".$tfidfvalue."<br>";
                    }
                }
            }
        }
        return $tfidfword;
        //dd($tfidfword);
    }

    //API Controller for Thai Word Segmentation.
    public function segmentapi(){
      //dd($_POST);
        // check api key จาก Database
        $users = DB::table('users')->where('apikey', '=', $_POST['apikey'])->count();
        //$users = 1;
	//echo $users;
        if($users == 1) {
          $time_start = microtime(true);

          if(!empty($_FILES['textword']['name'])){
            $file = request()->allFiles();
            $segment = new Segment();
            $text_to_segment = "";
            for($i=0; $i<count($_FILES['textword']['name']); $i++) {
                $textarray = " ";
                $content = " ";
                $shortname = $_FILES['textword']['name'][$i];
                //echo $shortname."<br>";
                $content = $file['textword'][$i]->openFile('r');
                foreach ($content as $linenum => $line) {
                    //echo $line;
                    $textarray = $textarray . $line;
                }
                $text_to_segment = trim($textarray);
                $result[] = array("Filename"=>$shortname, "Wordsegment"=> array_values($segment->get_segment_array($text_to_segment)));
            }
            $time_end = microtime(true);
            $time = round($time_end - $time_start,4)." ms";
            $result[] = array("Time Process"=>$time);
            return json_encode( $result, JSON_UNESCAPED_UNICODE );
          }
//        $zipfile = new \ZipArchive();
//        $zipfile->ex

            // return json_encode( $result, JSON_UNESCAPED_UNICODE );
        }
        else{
            return 'authen failed';
        }
    }

    public function apizipfile(){


        //dd($_POST);
        // check api key จาก Database
        $users = DB::table('users')->where('apikey', '=', $_POST['apikey'])->count();
        //$users = 1;
        //echo $users;
        if($users == 1) {
            $time_start = microtime(true);
            // print_r($_FILES['textword']);
            if($_FILES['textword']['size'][0] > 0){
                $file = request()->allFiles();
                $segment = new Segment();
                $text_to_segment = "";
                for($i=0; $i<count($_FILES['textword']['name']); $i++) {
                    $textarray = " ";
                    $content = " ";
                    $shortname = $_FILES['textword']['name'][$i];
                    //echo $shortname."<br>";
                    $content = $file['textword'][$i]->openFile('r');
                    foreach ($content as $linenum => $line) {
                        //echo $line;
                        $textarray = $textarray . $line;
                    }
                    $text_to_segment = trim($textarray);
                    $result[] = array("Filename"=>$shortname, "Wordsegment"=> array_values($segment->get_segment_array($text_to_segment)));
                }

                $tmpfilename = array();
                foreach ($result as $item){

                    $filename = "tmp/segment_".$item["Filename"];
                    $file = fopen($filename, 'w');
                    array_push($tmpfilename,$filename);
                    foreach ($item["Wordsegment"] as $word){
                        fwrite($file, $word."\n");
                    }
                    fclose($file);

                }
//                print_r($tmpfilename);
//                $filename = "tmp/".$shortname;
//                $file = fopen($filename, 'w');
//
//                fwrite($file, "5555");
//
                $zipname = 'tmp/file.zip';

                $zip = Zip::create($zipname);
                $zip->add($tmpfilename);
                $zip->close();
//
                if (file_exists($zipname)) {
                    header('Content-Description: File Transfer');
                    header('Content-Type: application/octet-stream');
                    header('Content-Disposition: attachment; filename="'.basename($zipname).'"');
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate');
                    header('Pragma: public');
                    header('Content-Length: ' . filesize($zipname));
                    readfile($zipname);

                    unlink($zipname);
                    exit;
                }

                return "success";
            }
            else {
              return "[]";
            }
//        $zipfile = new \ZipArchive();
//        $zipfile->ex

        }
        else{
            return 'authen failed';
        }
    }
}
