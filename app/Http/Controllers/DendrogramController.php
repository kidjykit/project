<?php

namespace App\Http\Controllers;

class DendrogramController extends Controller
{
    public function index(){

    	return view('posts.dendrogram');
    }

    public function processfile(){

        /*$return_data_test = array(array('id'=>'ก'),
            array('id'=>'ก.ข'),
            array('id'=>'ก.ข.ค'),
            array('id'=>'ก.ข.ค.ง'),
            array('id'=>'ก.ข.อ'),
            array('id'=>'ก.ข.อ.ฮ'),
            array('id'=>'ก.จ'),
            array('id'=>'ก.จ.ฉ'),
            array('id'=>'ก.จ.ฉ.ช'),
            array('id'=>'ก.จ.ฉ.ญ'),
            array('id'=>'ก.ฏ'),
            array('id'=>'ก.ฏ.ฐ'),
            array('id'=>'ก.ฏ.ฐ.ฑ'),
            array('id'=>'ก.ฏ.ฐ.ณ'),
            array('id'=>'ก.ด'),
            array('id'=>'ก.ด.ต'),
            array('id'=>'ก.ด.ต.ถ'),
            array('id'=>'ก.ด.ต.ท'),
            array('id'=>'ก.ด.ต.ธ'),
            array('id'=>'ก.น'),
            array('id'=>'ก.น.บ'),
            array('id'=>'ก.น.บ.ป'),
            array('id'=>'ก.ผ'),
            array('id'=>'ก.ผ.ฟ'),
            array('id'=>'ก.ผ.ฟ.พ'),
            array('id'=>'ก.ผ.ฟ.พ.ภ'),
            array('id'=>'ก.ม')
        );*/

        $return_data = array();
        $ignoreWord = array();
        $array_files = $_POST['text_data'];
        $first_layer_size = sizeof($array_files) <= 4 ? sizeof($array_files) : 4;
        $topwordlist = $this->selecttopword($array_files, $first_layer_size+1, $ignoreWord);
        $string = "";
        foreach($topwordlist as $index => $list){
            if($index == 0){
                $string = $list['name'];
                $return_data[] = array('id'=> $string);

            }else{
                $local_string = $string.".".$list['name'];
                $return_data[] = array('id'=> $local_string);
                $array_files_local = array();
                foreach($array_files as $file){
                    if (in_array($file[0], $list['files'])) {
                        $array_files_local[] = $file;
                    }
                }
                $this->recursive_getword($array_files_local, 3, $ignoreWord, $local_string, $return_data, 2);
            }
        }

        return $return_data;
    }

    private function recursive_getword($array_files, $amount, &$ignore_word, $start_string, &$return_data, $layer = 1){
        if(sizeof($array_files) == 1 || $layer == 3){
            $topwordlist = $this->selecttopword($array_files, 3, $ignore_word);
            foreach($topwordlist as $list){
                $local_string = $start_string.".".$list['name'];
                $return_data[] = array('id'=> $local_string);
            }
        }else{
            $layer += 1;
            $topwordlist = $this->selecttopword($array_files, $amount, $ignore_word);
            foreach($topwordlist as $index => $list){
                $local_string = $start_string.".".$list['name'];
                $return_data[] = array('id'=> $local_string);
                $array_files_local = array();
                foreach($array_files as $file){
                    if (in_array($file[0], $list['files'])) {
                        $array_files_local[] = $file;
                    }
                }
                $this->recursive_getword($array_files_local, $amount, $ignore_word, $local_string, $return_data, $layer);
            }
        }

    }

    private function recursive_getword_old($array_files, $amount, &$ignoreWord, &$output){
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
                $this->recursive_getword_old($array_files_local, $amount, $ignoreWord, $output['children'][$index]);
            }
        }

    }

    public function processfile_old(){

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

                if (!in_array($keyy, $ignoreWord) && !is_numeric($keyy) && !strpos($keyy, '.')) {
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

    public function wordcloud(){

      $return_data = array();
      foreach($_POST['text_data'] as $key => $value){
          $return_data[] = array("id"=>$key, "value"=> $value);
      }
      //echo implode(' | ', $result);
      return $return_data;

    }
}
