<?php

    $config = require_once '../config.php';
    include('rubric.php');

    // Feteching data 
    $id= $_GET['id'];
    $scrn=$_GET['screen_name'];
    $name=$_GET['name'];
    $flc=$_GET['followers_count'];
    $frc=$_GET['friends_count'];
    $lc=$_GET['listed_count'];
    $fvc=$_GET['favourites_count'];
    $stc=$_GET['statuses_count'];
    $created=$_GET['created_at'];
    // Feteching data

    // Calculate influence using klout API
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
    // Calculate influence using klout API

    // Calculate Rubric
    //echo $influence['score'];
    $xyz=new Rubric($flc,$frc,$stc,$influence['score'],$created);
    $twubric=$xyz->getTwubric();
    // Calculate Rubric

    // Modelling Data of users in JSON
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
    // Modelling Data of users in JSON

    // Showing model data
    header('Content-type: application/json');
    echo $obj;
    // Showing model data
    
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