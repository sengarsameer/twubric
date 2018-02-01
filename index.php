<?php
require_once 'twitteroauth/autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;
 
session_start();
 
$config = require_once 'config.php';

// create TwitterOAuth object
$twitteroauth = new TwitterOAuth($config['consumer_key'], $config['consumer_secret']);
 
// request token of application
$request_token = $twitteroauth->oauth(
    'oauth/request_token', [
        'oauth_callback' => $config['url_callback']
    ]
);
echo '<pre>'; print_r($request_token); echo '</pre>';
// throw exception if something gone wrong
if($twitteroauth->getLastHttpCode() != 200) {
    throw new \Exception('There was a problem performing this request');
}
 
// save token of application to session
$_SESSION['oauth_token'] = $request_token['oauth_token'];
$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
 
// generate the URL to make request to authorize our application
$url = $twitteroauth->url(
    'oauth/authorize', [
        'oauth_token' => $request_token['oauth_token']
    ]
);

// and redirect
header('Location: '. $url);
?>


<html>

<head>
    <title>
        Twubric
    </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {
            background-color: #ced4ce;
            margin: 0;
            padding: 0;
        }
        
        h1 {
            color: #000000;
            text-align: center;
            font-family: "SIMPSON";
        }
        
        form {
            width: 300px;
            margin: 0 auto;
            padding-top: 11%;
        }
    </style>

</head>

<body>
    <form action="" method="post">
        <button style="font-size:18px;">Login By Twitter &nbsp;<i class="fa fa-twitter" aria-hidden="true" style="font-size:36px;color:rgb(8, 166, 240)"></i></button>
    </form>
</body>

</html>