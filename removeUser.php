<?php

require('function.php');

debug('「　退会ページ　');
debugLogStart();

require('auth.php');

if(!empty($_POST)){
  debug('POST送信があります。');
  try {
    $dbh = dbConnect();
    $sql1 = 'UPDATE users SET  delete_flg = 1 WHERE id = :us_id';
    $sql2 = 'UPDATE product SET  delete_flg = 1 WHERE user_id = :us_id';
    $sql3 = 'UPDATE favorite SET  delete_flg = 1 WHERE user_id = :us_id';
    $data = array(':us_id' => $_SESSION['user_id']);
    $stmt1 = queryPost($dbh, $sql1, $data);
    $stmt2 = queryPost($dbh, $sql2, $data);
    $stmt3 = queryPost($dbh, $sql3, $data);

    if($stmt1){
      session_destroy();
      debug('セッション変数の中身：'.print_r($_SESSION,true));
      debug('トップページへ遷移します。');
      header("Location:index.php");
    }else{
      debug('クエリが失敗しました。');
      $err_msg['common'] = MSG07;
    }

  } catch (Exception $e) {
    error_log('エラー発生:' . $e->getMessage());
    $err_msg['common'] = MSG07;
  }
}
debug('画面表示処理終了 <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<');
?>
<?php
$siteTitle = '退会';
require('head.php');
?>

  <body>
    <!-- ヘッダー -->
    <?php
      require('header.php');
    ?>

    <section class="remove_user input_info" >
      <div class="form_container">
        <form action="" method="post" class="form">
          <h2 class="title">退会</h2>
          <div class="msg_area">
            <?php
            if(!empty($err_msg['common'])) echo $err_msg['common'];
            ?>
          </div>
          <div class="button">
            <input type="submit" class="btn btn_mid" value="退会する" name="submit">
          </div>
        </form>
        <a href="index.php" class="back_page">&lt; ホームに戻る</a>
      </div>
    </section>

    <!-- フッター -->
    <?php
      require('footer.php');
    ?>
