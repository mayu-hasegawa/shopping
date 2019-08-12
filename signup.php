<?php

//共通変数・関数ファイルを読込み
require('function.php');

debug('「　ユーザー登録ページ　');
debugLogStart();

if(!empty($_POST)){

  $username = $_POST['username'];
  $email = $_POST['email'];
  $pass = $_POST['pass'];
  $pass_re = $_POST['pass_re'];

  validRequired($username, 'username');
  validRequired($email, 'email');
  validRequired($pass, 'pass');
  validRequired($pass_re, 'pass_re');

  if(empty($err_msg)){

    validEmail($email, 'email');
    validMaxLen($email, 'email');
    validEmailDup($email);

    validHalf($pass, 'pass');
    validMaxLen($pass, 'pass');
    validMinLen($pass, 'pass');

    if(empty($err_msg)){

      validMatch($pass, $pass_re, 'pass_re');

      if(empty($err_msg)){

        try {
          $dbh = dbConnect();
          $sql = 'INSERT INTO users (username,email,password,login_time,create_date) VALUES(:username,:email,:pass,:login_time,:create_date)';
          $data = array(':username' => $username, ':email' => $email, ':pass' => password_hash($pass, PASSWORD_DEFAULT),
                        ':login_time' => date('Y-m-d H:i:s'),
                        ':create_date' => date('Y-m-d H:i:s'));
          $stmt = queryPost($dbh, $sql, $data);

          if($stmt){
            $sesLimit = 60*60;
            $_SESSION['login_date'] = time();
            $_SESSION['login_limit'] = $sesLimit;
            $_SESSION['user_id'] = $dbh->lastInsertId();

            debug('セッション変数の中身：'.print_r($_SESSION,true));

            header("Location:index.php");
          }else{
            error_log('クエリに失敗しました。');
            $err_msg['common'] = MSG07;
          }

        } catch (Exception $e) {
          error_log('エラー発生:' . $e->getMessage());
          $err_msg['common'] = MSG07;
        }

      }
    }
  }
}
?>
<?php
  $siteTitle = 'ユーザー登録';
  require('head.php');
?>

  <body>
  <!-- ヘッダー -->
  <?php
    require('header.php');
  ?>

    <section class="signup input_info" >
      <div class="form_container">
        <form action="" method="post" class="form">
          <h2 class="title">ユーザー登録</h2>
          <div class="msg_area">
            <?php
            if(!empty($err_msg['common'])) echo $err_msg['common'];
            ?>
          </div>
          <label class="<?php if(!empty($err_msg['username'])) echo 'err'; ?>">
           名前
            <input type="text" name="username" value="<?php echo getFormData('username'); ?>">
          </label>
          <div class="msg_area">
            <?php
            if(!empty($err_msg['username'])) echo $err_msg['username'];
            ?>
          </div>
          <label class="<?php if(!empty($err_msg['email'])) echo 'err'; ?>">
            Email
            <input type="text" name="email" value="<?php if(!empty($_POST['email'])) echo $_POST['email']; ?>">
          </label>
          <div class="msg_area">
            <?php
            if(!empty($err_msg['email'])) echo $err_msg['email'];
            ?>
          </div>
          <label class="<?php if(!empty($err_msg['pass'])) echo 'err'; ?>">
            パスワード <span style="font-size:12px">※英数字６文字以上</span>
            <input type="password" name="pass" value="<?php if(!empty($_POST['pass'])) echo $_POST['pass']; ?>">
          </label>
          <div class="msg_area">
            <?php
            if(!empty($err_msg['pass'])) echo $err_msg['pass'];
            ?>
          </div>
          <label class="<?php if(!empty($err_msg['pass_re'])) echo 'err'; ?>">
            パスワード（再入力）
            <input type="password" name="pass_re" value="<?php if(!empty($_POST['pass_re'])) echo $_POST['pass_re']; ?>">
          </label>
          <div class="msg_area">
            <?php
            if(!empty($err_msg['pass_re'])) echo $err_msg['pass_re'];
            ?>
          </div>
          <div class="button">
            <input type="submit" class="btn btn_mid" value="登録する">
          </div>
        </form>
      </div>
    </section>

  <!-- フッター -->
  <?php
    require('footer.php');
  ?>
