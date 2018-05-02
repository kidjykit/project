<?php

namespace App\Http\Controllers;

class DendrogramController extends Controller
{
    public function index(){

    	return view('posts.dendrogram');
    }


    public function processfile(){

      $topwordlist = $this->selecttopword($_POST['text_data'], 1);
      print_r($topwordlist);

    }

    private function selecttopword($arrayfile, $topN){

      // $allfile = $_POST['text_data'];
      $dfarray = $this->df($arrayfile);
      $topwordfreq = array();
      foreach ($arrayfile as $key) {
          echo $key[0];
        foreach ($key[2] as $keyy => $value) {
          foreach ($dfarray as $xx => $xxvalue) {
            if($xx==$keyy){
              $sumfre = $value*$xxvalue;
              // echo "word : ".$keyy." Frequency = ".$sumfre;

            }

            // code...
          }
          $topwordfreq[$keyy] = $sumfre;
        }
      }
      arsort($topwordfreq);
      $toplist = array_slice($topwordfreq,0,$topN);
      // print_r($topwordfreq);
      return $toplist;
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
}
