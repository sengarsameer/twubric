<?php
 include ('config.php');
 require "twitteroauth/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;
$connection = new TwitterOAuth($CONSUMER_KEY, $CONSUMER_SECRET);
$request_token = $connection->get($OAUTH_CALLBACK);//get Request Token
echo $request_token;
 
if( $request_token) //session on
{
    $token = $request_token['oauth_token'];
    $_SESSION['request_token'] = $token ; //session on
    $_SESSION['request_token_secret'] = $request_token['oauth_token_secret'];
 
    switch ($connection->http_code) 
    {
        case 200:
            $url = $connection->getAuthorizeURL($token);
            //redirect to Twitter .
            header('Location: ' . $url); 
            break;
        default:
            echo "Coonection with twitter Failed";
            break;
    }
 
}
else //error receiving request token
{
    echo "Error Receiving Request Token";
}
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