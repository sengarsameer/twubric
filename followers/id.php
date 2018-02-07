<!-- MIT License

Copyright (c) 2018 SAMEER SENGAR
<sengar.sameer@gmail.com>

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE. -->


<?php

    $config = require_once '../config.php';
    include('rubric.php');

    // Feteching data - START
    $id= $_GET['id'];
    $scrn=$_GET['screen_name'];
    $name=$_GET['name'];
    $flc=$_GET['followers_count'];
    $frc=$_GET['friends_count'];
    $lc=$_GET['listed_count'];
    $fvc=$_GET['favourites_count'];
    $stc=$_GET['statuses_count'];
    $created=$_GET['created_at'];
    // Feteching data - END

    // Calculate influence using klout API - START
    $curl = curl_init();
    curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);

    $query = array(
        "key" => $config['klout_key']
    );

    curl_setopt ($curl, CURLOPT_URL, "http://api.klout.com/v2/identity.json/twitter?screenName=".$scrn . "&" . http_build_query($query) );
    $b_result = json_decode(curl_exec($curl),true);
    curl_setopt ($curl, CURLOPT_URL, "http://api.klout.com/v2/user.json/".$b_result['id']."/score" . "?" . http_build_query($query) );
    $influence = json_decode(curl_exec($curl),true);
    curl_close($curl);
    // Calculate influence using klout API - END

    // Calculate Rubric - START
    $xyz=new Rubric($flc,$frc,$stc,$influence['score'],$created);
    $twubric=$xyz->getTwubric();
    // Calculate Rubric - END

    // Modelling Data of users in JSON - START
    //echo '<pre>'; print_r($twubric); echo '</pre>';
    $final_data = array (
        'name' => $name,
        'screen_name' => $scrn,
        'followers_count' => (int)$flc,
        'friends_count'=> (int)$frc,
        'listed_count'=> (int)$lc,
        'favourites_count' => (int)$fvc,
        'statuses_count' => (int)$stc,
        'twubric'=> array (
            'total' => round($twubric['Total'],2),
            'friends'=> round($twubric['Friends'],2),
            'influence'=>round( $twubric['Influence'],2),
            'chirpy' => round($twubric['Chirpy'],2),
        )
    );
    $obj=json_encode($final_data,JSON_FORCE_OBJECT);
    // Modelling Data of users in JSON - END

    // Showing model data - START
    header('Content-type: application/json');
    echo $obj;
    // Showing model data - END
    
    //$uri="/app/follower/".$id."/twubric.json";
    // $uri="/app/follower/twubric.json";
    // $dir = dirname(__FILE__);
    // $files = scandir($dir); ; // get all file names
    // foreach ($files as $file) {
    // if (is_dir($file)) {
    //         rename($dir.'/'.$file, $dir.'/'.$id); // rename folder
            
    //     }
    //     echo $file;        
    // }

    // file_put_contents($dir.'/'.$id.'/twubric.json', $obj);
    // header('Location: ' . $uri, true, 301);
    
?>
