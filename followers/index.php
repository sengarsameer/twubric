<?php

require_once '../vendor/autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;

session_start();

$config = require_once '../config.php';

// get and filter oauth verifier
$oauth_verifier = filter_input(INPUT_GET, 'oauth_verifier');

// check tokens
if (empty($oauth_verifier) ||
    empty($_SESSION['oauth_token']) ||
    empty($_SESSION['oauth_token_secret'])
) {
    // something's missing, go and login again
    header('Location: ' . $config['url_login']);
}

// connect with application token
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

// connect with user token
$twitter = new TwitterOAuth(
    $config['consumer_key'],
    $config['consumer_secret'],
    $token['oauth_token'],
    $token['oauth_token_secret']
);

$user = $twitter->get('account/verify_credentials');

// if something's wrong, go and log in again
if(isset($user->error)) {
    header('Location: ' . $config['url_login']);
}

// post a tweet
// $status = $twitter->post(
//     "statuses/update", [
//         "status" => "Thank you @nedavayruby, now I know how to authenticate users with Twitter because of this tutorial https://goo.gl/N2Znbb"
//     ]
// );
//echo '<pre>'; print_r($user); echo '</pre>';
//$status_id=$twitter->get('followers/ids', array('screen_name' => $user->screen_name));
$status_list=$twitter->get('followers/list', array('screen_name' => $user->screen_name));
$list= json_decode (json_encode($status_list),true);
$temp=count($list['users']);
echo $temp;
//echo '<pre>'; print_r($status_list); echo '</pre>';
?>
<html>
    <head>

    </head>

    <body>
    <TABLE BORDER="5"    WIDTH="50%"   CELLPADDING="4" CELLSPACING="3">
   <TR>
      <TH COLSPAN="2"><BR><H3>TABLE TITLE</H3>
      </TH>
   </TR>
   <TR>
      <TH>NAME</TH>
      <TH>TWITTER HANDLE</TH>
   </TR>
   <?php
for($i=0;$i<$temp;$i++){
   echo "<TR ALIGN='CENTER'>
      <TD>".$list['users'][$i]['name']."</TD>
      <TD>".$list['users'][$i]['screen_name']."</TD>
   </TR>";
}
   ?>
</TABLE>
    
    
    </body>


</html>