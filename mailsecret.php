<?php
session_start();
define('MAILSECRET');
require('config.php');
$mode = 0;  // 0:未認証; 1:失敗; 2:成功
$isOkAuth = false;
if(@$_SESSION['ms_checked'] || $isOkAuth = check()){
    $mode = 2;
}
if(!$isOkAuth){
    $mode = 1;
}

function check(){
    if(empty($_POST['g-recaptcha-response'])){
        return false;
    }
    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $args = array(
        'secret' => SECRET_KEY,
        'response' => $_POST['g-recaptcha-response'],
        'remoteip' => $_SERVER['REMOTE_ADDR'],
    );
    $url = $url . '?' . http_build_query($args);
    $headers = array(
        'Content-Type: application/x-www-form-urlencoded',
    );
    $opts = array('http' =>
        array(
            'method' => 'GET',
            'header'  => implode("\r\n", $headers),
            'ignore_errors' => true
        )
    );
    $apiResponse = file_get_contents($url, false, stream_context_create($opts));
    $jsonData = json_decode($apiResponse, true);
    if($jsonData['success'] !== true){
        return false;
    }
    $_SESSION['ms_checked'] = true;
    return true;
}
?>
<!doctype html>
<html>
    <head>
        <meta name="robots" content="noindex">
        <title>MailSecret</title>
        <script src="https://www.google.com/recaptcha/api.js"></script>
    </head>
    <body>
        <h1><?php if($mode == 0){echo MSG_CAPTCHA;}elseif ($mode == 1) {echo MSG_NG;}else{echo MSG_OK;}?></h1>
        <?php if($mode == 0){ ?>
        <form method="post">
            <div class="g-recaptcha" data-sitekey="<?php echo SITE_KEY;?>"></div>
            <input type="submit" value="表示">
        </form>
        <?php } ?>
        <?php if($mode == 2){ ?>
            <div>
                <span>メールアドレス:</span><a href="mailto:<?php echo MAIL; ?>"><?php echo MAIL; ?></a>
            </div>
        <?php } ?>
    </body>
</html>
