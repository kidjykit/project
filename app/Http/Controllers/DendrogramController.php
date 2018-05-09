<?php

namespace App\Http\Controllers;

class DendrogramController extends Controller
{
    public function index(){

    	return view('posts.dendrogram');
    }

    private function recursive_getword($array_files, $amount, &$ignoreWord, &$output){
        if(sizeof($array_files) == 1){
            $topwordlist = $this->selecttopword($array_files, 6, $ignoreWord);
            foreach($topwordlist as $list){
                $output['children'][] = array('name'=>$list['name']);
                //$output['children'][] = array('name'=>$list['name']." ".$list['frequency']." ".implode($list['files'],','));
            }
        }else{
            $topwordlist = $this->selecttopword($array_files, $amount, $ignoreWord);
            foreach($topwordlist as $index => $list){
                $output['children'][] = array('name'=>$list['name']);
                //$output['children'][] = array('name'=>$list['name']." ".$list['frequency']." ".implode($list['files'],','));
                $array_files_local = array();
                foreach($array_files as $file){
                    if (in_array($file[0], $list['files'])) {
                        $array_files_local[] = $file;
                    }
                }
                $this->recursive_getword($array_files_local, $amount, $ignoreWord, $output['children'][$index]);
            }
        }

    }

    public function processfile(){

        $ignoreWord = array();
        $json_result = array('name'=>'flares', 'children'=> array());
        $array_files = $_POST['text_data'];
        $topwordlist = $this->selecttopword($array_files, 6, $ignoreWord);

        foreach($topwordlist as $index => $list){
            if($index == 0){
                $json_result['name'] = $list['name'];
                //$json_result['name'] = $list['name']." ".$list['frequency']." ".implode($list['files'],',');

            }else{
                $json_result['children'][] = array('name'=>$list['name']);
                //$json_result['children'][] = array('name'=>$list['name']." ".$list['frequency']." ".implode($list['files'],','));
                $array_files_local = array();
                foreach($array_files as $file){
                    if (in_array($file[0], $list['files'])) {
                        $array_files_local[] = $file;
                    }
                }
                $this->recursive_getword($array_files_local, 4, $ignoreWord, $json_result['children'][$index-1]);
            }

        }

        /*foreach($json_result['children'] as &$child){
            $array_files_local = array();
            foreach($array_files as $file){

            }
            $this->recursive_getword($array_files, 4, $ignoreWord, $child);

        }*/

        print_r($json_result);
        //print_r(array('$topwordlist'=> $topwordlist ,
        /*print_r(array('$json_result'=> $json_result ,
                      //'$array_files'=> $array_files ,
                      //'$json_result'=> $json_result ,
                      '$ignoreWord'=> $ignoreWord
        ));*/
      //print_r($this->df($_POST['text_data']));

    }

    private function selecttopword($arrayfile, $topN, &$ignoreWord = array()){

        // $allfile = $_POST['text_data'];
        $dfarray = $this->df($arrayfile);
        $topwordfreq = array();
        foreach ($arrayfile as $key) {
            echo $key[0];
            foreach ($key[2] as $keyy => $value) {
                /*foreach ($dfarray as $xx => $xxvalue) {
                    if($xx==$keyy){
                        $sumfre = $value*$xxvalue;
                        // echo "word : ".$keyy." Frequency = ".$sumfre;
                        //echo $key[0];
                    }
                    // code...
                }*/
                $sumfre = $value*$dfarray[$keyy];

                if (!in_array($keyy, $ignoreWord) && !is_numeric($keyy)) {
                    $topwordfreq[$keyy][0] = $sumfre;
                    array_push($topwordfreq[$keyy],$key[0]);
                    // array_push($topwordfreq,$key[0]);
                }
            }
        }

        arsort($topwordfreq);
        //print_r($topwordfreq);
        $topN = sizeof($topwordfreq) < $topN ? sizeof($topwordfreq) : $topN;
        $toplist = array_slice($topwordfreq,0,$topN);
        $result = array();
        foreach($toplist as $key => $values){
            $temp_data = array('name'=>$key);
            foreach($values as $value_key => $value ){
                if($value_key == 0){
                    $temp_data['frequency'] = $value;
                }else{
                    $temp_data['files'][] = $value;
                }
            }

            $result[] = $temp_data;
            $ignoreWord[] = $key."";
        }
        //print_r($toplist);
        return $result;
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



    public function columnchart(){

      $return_data = array();
      foreach($_POST['text_data'] as $key => $value){
          $return_data[] = array("id"=>$key, "value"=> $value);
      }
      //echo implode(' | ', $result);
      return $return_data;

    }
}
