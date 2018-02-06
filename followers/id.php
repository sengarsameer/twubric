<?php
$config = require_once '../config.php';
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
echo $created;

?>