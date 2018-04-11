<?php

namespace App\Http\Controllers;

use App\segment;

class BubbleChartController extends Controller
{
    public function index(){

    	return view('posts.bubblechart');
    }

    public function process(){

        $body = $_POST['text_data'];
        $text_to_segment = trim($body);
        //echo $text_to_segment;
        $segment = new Segment();
        $result_array = $segment->get_segment_array($text_to_segment);
        $results = array_count_values($result_array);

        // sort จำนวนคำที่ค้นเจอ
        arsort($results);

        $return_data = array();
        foreach($results as $key => $value){
            $return_data[] = array("id"=>$key, "value"=> $value);
        }
        //echo implode(' | ', $result);
        return $return_data;
    }
    
}
