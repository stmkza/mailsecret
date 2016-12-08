<?php
if(!defined('MAILSECRET')){
	exit();
}

// 隠したいメールアドレス
define('MAIL', 'foo@example.com');

// キャプチャ画面のメッセージ
define('MSG_CAPTCHA', '認証してください');

// 成功時のメッセージ
define('MSG_OK', '認証に成功しました');

// 失敗時のメッセージ
define('MSG_NG', '認証に失敗しました');

// サイトキー
define('SITE_KEY', '');

// シークレットキー
define('SECRET_KEY', '');
?>
