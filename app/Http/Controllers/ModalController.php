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

        for($i=0; $i<count($_FILES['textfile']['name']); $i++) {
            $textarray = " ";
            $content = " ";
            $shortname = $_FILES['textfile']['name'][$i];
            //echo $shortname."<br>";
            $content = $file['textfile'][$i]->openFile('r');
            foreach ($content as $linenum => $line) {
                $textarray = $textarray . $line;
            }
             //echo $textarray;
        }

        $body = '';

      }
      return view('posts.visall', compact('textarray'));

    }

    public function makevis(){

      // $this->validate(request(), [
      //     'body' => 'required',
      //     'textfile' => 'required'
      // ]);

      if(!empty($_POST['text_data'])){
        $body = $_POST['text_data'];
        $textarray = '';
         // echo $body,$hiddenfiled;
      }

      if(!empty($_FILES['allfile']['name'])){
        $result = array();
        $file = request()->allFiles();

        for($i=0; $i<count($_FILES['allfile']['name']); $i++) {
            $textarray = " ";
            $content = " ";
            $shortname = $_FILES['allfile']['name'][$i];
            //echo $shortname."<br>";
            $content = $file['allfile'][$i]->openFile('r');
            foreach ($content as $linenum => $line) {
                $textarray = $textarray . $line;
            }
             // echo $textarray,$hiddenfiled;
        }

        $body = '';

      }
      // return view('posts.modal',['data1' => $body, 'data2' => $textarray, 'hiddentype' => $hiddenfiled]);
      return ['data1' => $body,'data2' => $textarray];
    }

}
