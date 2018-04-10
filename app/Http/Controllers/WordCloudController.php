<?php

namespace App\Http\Controllers;

class WordCloudController extends Controller
{
    public function index(){

    	return view('posts.wordcloud');
    }

    
}
