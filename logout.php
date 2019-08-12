<?php
//共通変数・関数ファイルを読込み
require('function.php');

debug('「　ログアウトページ　');
debugLogStart();

debug('ログアウトします。');
session_destroy();
debug('ログインページへ遷移します。');
header("Location:login.php");
