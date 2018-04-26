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

        $body = $_POST['text_data'];
        $text_to_segment = trim($body);
        //echo $text_to_segment;
        $segment = new Segment();
        $result_array = array_values($segment->get_segment_array($text_to_segment));

        return $result_array;
    }

}
