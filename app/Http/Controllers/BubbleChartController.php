<?php

namespace App\Http\Controllers;

use App\segment;

class BubbleChartController extends Controller
{
    public function index(){

    	return view('posts.bubblechart');
    }

    public function process(){

        $body = array_count_values($_POST['text_data']);
        arsort($body);
        $return_data = array();
        $count=0;
        foreach($body as $key => $value){
          if($count<=30){
            $return_data[] = array("id"=>$key, "value"=> $value);
          $count++;
        }
        }
        //echo implode(' | ', $result);
        return $return_data;
    }

}
