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

    require_once 'vendor/autoload.php';
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
