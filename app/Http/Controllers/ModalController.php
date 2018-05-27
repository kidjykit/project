<?php

namespace App\Http\Controllers;

use App\segment;
use App\thcharacter;
use App\unicode;

class ModalController extends Controller
{
    public function index(){

    	return view('posts.modal');
    }

    public function process(){

      $this->validate(request(), [
          'textarea' => 'required'
      ]);

      $inputtext = $_POST['textarea'];
      $text_to_segment = trim($inputtext);
      //echo $text_to_segment;
      $segment = new Segment();
      $body = $segment->get_segment_array($text_to_segment);

      return view('posts.visall', compact('body'));

    }

    public function processfile(){
      $this->validate(request(), [
          'textfile' => 'required'
      ]);
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
        $body = '';
        $df = $this->df($result);
        $tfidf = $this->tfidf($result,$df);

        // return view('posts.visall', compact('result'));
        return view('posts.visall',['result' => $result, 'tfidf' => $tfidf]);
      }
    }

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

    private function tfidf($tf,$idf){
        $tfidfword = array();
        foreach ($tf as $tfdoc){
            //$tfidfword[$tfdoc[0]][] = $tfdoc[0];
            $allword_eachdoc = count($tfdoc[1]);
            foreach ($tfdoc[2] as $tfword => $tfvalue){
                foreach ($idf as $idfword => $idfvalue){
                    if ($tfword==$idfword){
                        $tfidfvalue = ($tfvalue/$allword_eachdoc)*log(count($tf)/$idfvalue,10);
                        //  $tfdoc[0] >>> File Name.
                        //  $tfword   >>> Word.
                        //  $tfidfvalue >>> TFIDF of Word.

//                        $tfidfword[$tfdoc[0]][1] = $tfidfvalue;
                        //echo "TFIDF OF ".$tfword ." = ".$tfidfvalue."<br>";
                    }
                }
                $tfidfword[$tfdoc[0]][$tfword] = round($tfidfvalue,2);
            }
            arsort($tfidfword[$tfdoc[0]]);
        }
        return $tfidfword;
        // dd($tfidfword);
    }

}
