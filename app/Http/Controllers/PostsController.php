<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use App\segment;
use App\thcharacter;
use App\unicode;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

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

    public function file(){

        return view('posts.file');
    }

    public function store(){

    	// $post = new Post;
    	// $post->title = request('title');
    	// $post->body = request('body');
    	// $post->save();

    	$this->validate(request(), [
    		'title' => 'required',
    		'body' => 'required'
    		]);

    	Post::create(request(['title', 'body']));

    	return redirect('/');
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

    public function segmentfile(){
        if(!empty($_FILES['uploader']['name'])){
            $result = array();
            $file = request()->allFiles();
            $segment = new Segment();
            $text_to_segment = "";
            for($i=0; $i<count($_FILES['uploader']['name']); $i++) {
                $textarray = " ";
                $content = " ";
                $shortname = $_FILES['uploader']['name'][$i];
                //echo $shortname."<br>";
                $content = $file['uploader'][$i]->openFile('r');
                foreach ($content as $linenum => $line) {
                    //echo $line;
                    $textarray = $textarray . $line;
                }
                $text_to_segment = trim($textarray);
                $result[$i][0] = $shortname;
                $result[$i][1] = $segment->get_segment_array($text_to_segment);
            }
        //print_r($result);
        //dd($result);
        return view('posts.resultviewfile', compact('result') );
        }
    }



    public function segmentapi(){
      //dd($_POST);
        // check api key จาก Database
        $users = DB::table('users')->where('apikey', '=', $_POST['apikey'])->count();
        //echo $users;
        if($users == 1) {
            $file = request()->file('textword');
            $content = $file->openFile('r');
            $textarray = "";
            foreach ($content as $linenum => $line) {
                //echo $line;
                $textarray = $textarray . $line;
            }
            //print_r($textarray);
            $text_to_segment = trim($textarray);
            $segment = new Segment();
            $result = $segment->get_segment_array($text_to_segment);
//        $zipfile = new \ZipArchive();
//        $zipfile->ex
            return response()->json([
                'word' => $result,
                'wordcount' => count($result)
            ]);
        }
        else{
            return 'authen failed';
        }
    }
}
