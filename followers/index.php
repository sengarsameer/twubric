<?php
require_once '../twitteroauth/autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;
 
session_start();
 
$config = require_once '../config.php';

$oauth_verifier = filter_input(INPUT_GET, 'oauth_verifier');
 
if (!empty($oauth_verifier) ||
    empty($_SESSION['oauth_token']) ||
    empty($_SESSION['oauth_token_secret'])
) {
    // something's missing, go and login again
    header('Location: ' . $config['url_login']);
}

$connection = new TwitterOAuth(
    $config['consumer_key'],
    $config['consumer_secret'],
    $_SESSION['oauth_token'],
    $_SESSION['oauth_token_secret']
);
 
// request user token
$token = $connection->oauth(
    'oauth/access_token', [
        'oauth_verifier' => $oauth_verifier
    ]
);
?>

<html>
    <head>

    </head>
    <body>
        <h1>Hello</h1>
    </body>
</html>