<?php

namespace App\Http\Controllers;

use App\segment;
use App\thcharacter;
use App\unicode;

class SentenceTreeController extends Controller
{
    public function index(){

    	return view('posts.sentencetree');
    }

    public function process(){

        $body = array_values($_POST['text_data']);
        return $body;
    }

    public function processfile(){

        $allfile = ($_POST['text_data']);
        return $allfile;
    }

}
