<?php

// ログイン認証・自動ログアウト
if( !empty($_SESSION['login_date']) ){
  debug('ログイン済みユーザーです。');

  if( ($_SESSION['login_date'] + $_SESSION['login_limit']) < time()){
    debug('ログイン有効期限オーバーです。');

    session_destroy();
  }else{
    debug('ログイン有効期限以内です。');
    $_SESSION['login_date'] = time();

    if(basename($_SERVER['PHP_SELF']) === 'login.php'){
      debug('マイページへ遷移します。');
      header("Location:index.php");
    }
  }
}
