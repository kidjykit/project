<?php

namespace App\Http\Controllers;

class CirclePackingController extends Controller
{
    public function index(){

    	return view('posts.circlepacking');
    }



    public function process(){

        $body = $_POST['text_data'];
        //replace below method by data generator function
        $return_data = json_decode(file_get_contents("data/flare.json"), true);

        return $return_data;
    }


}
