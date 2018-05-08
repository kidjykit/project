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

      $body = $_POST['textarea'];
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
      }
      return view('posts.visall', compact('result'));
    }

}
