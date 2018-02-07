<?php

    require_once '../vendor/autoload.php';
    use Abraham\TwitterOAuth\TwitterOAuth;

    session_start(); //Starting the session

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

    //echo '<pre>'; print_r($user); echo '</pre>';
    //$status_id=$twitter->get('followers/ids', array('screen_name' => $user->screen_name));
    $status_list=$twitter->get('followers/list', array('screen_name' => $user->screen_name));
    $list= json_decode (json_encode($status_list),true);
    $temp=count($list['users']);
    // echo '<pre>'; print_r($status_list); echo '</pre>';

?>

<!-- HTML ---- START -->


<html>
    <head>

    </head>

    <body>
        <TABLE BORDER="5"    WIDTH="50%"   CELLPADDING="4" CELLSPACING="3" >
            <TR>
                <TH COLSPAN="2"><BR>
                    <H3>TABLE TITLE</H3>
                </TH>
            </TR>

            <TR>
                <TH>NAME</TH>
                <TH>TWITTER HANDLE</TH>
            </TR>

            <!-- FETECHING DATA IN TABLE USING PHP ---- START -->
            <?php
                for($i=0;$i<$temp;$i++) {
                    echo "<TR ALIGN='CENTER'>
                        <TD>".$list['users'][$i]['name']."</TD>
                        <TD>
                            <a href='id.php?id=".$list['users'][$i]['id']."&screen_name=".$list['users'][$i]['screen_name']."&name=".$list['users'][$i]['name']."&followers_count=".$list['users'][$i]['followers_count']."&friends_count=".$list['users'][$i]['friends_count']."&listed_count=".$list['users'][$i]['listed_count']."&favourites_count=".$list['users'][$i]['favourites_count']."&statuses_count=".$list['users'][$i]['statuses_count']."&created_at=".$list['users'][$i]['created_at']."'>".$list['users'][$i]['screen_name']."</a>
                        </TD>
                    </TR>";
                }
            ?>
            <!-- FETECHING DATA IN TABLE USING PHP ---- END-->

        </TABLE>    
    
    </body>

</html>

<!-- HTML ---- END -->