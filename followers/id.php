<?php

    $config = require_once '../config.php';
    include('rubric.php');

    $id= $_GET['id'];
    $scrn=$_GET['screen_name'];
    $name=$_GET['name'];
    $flc=$_GET['followers_count'];
    $frc=$_GET['friends_count'];
    $lc=$_GET['listed_count'];
    $fvc=$_GET['favourites_count'];
    $stc=$_GET['statuses_count'];
    $created=$_GET['created_at'];
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
    //echo $influence['score'];
    $xyz=new Rubric($flc,$frc,$stc,$influence['score'],$created);
    $twubric=$xyz->getTwubric();
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
    $uri="/app/follower/".$id."/twubric.json";
    header('Content-type: application/json');
    header('Location: ' . $uri, true, 301);
    echo $obj;
?>