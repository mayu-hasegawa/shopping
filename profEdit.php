<?php

require('function.php');

debug('「　プロフィール編集ページ　');
debugLogStart();

require('auth.php');

$dbFormData = getUser($_SESSION['user_id']);

debug('取得したユーザー情報：'.print_r($dbFormData,true));

if(!empty($_POST)){
  debug('POST送信があります。');
  debug('POST情報：'.print_r($_POST,true));

  $username = $_POST['username'];
  $tel = $_POST['tel'];
  $zip = (!empty($_POST['zip'])) ? $_POST['zip'] : 0;
  $addr = $_POST['addr'];
  $age = $_POST['age'];
  $email = $_POST['email'];

  if($dbFormData['username'] !== $username){
    validMaxLen($username, 'username');
  }
  if($dbFormData['tel'] !== $tel){
    validTel($tel, 'tel');
  }
  if($dbFormData['addr'] !== $addr){
    validMaxLen($addr, 'addr');
  }
  if( (int)$dbFormData['zip'] !== $zip){
    validZip($zip, 'zip');
  }
  if($dbFormData['age'] !== $age){
    validMaxLen($age, 'age');
    validNumber($age, 'age');
  }
  if($dbFormData['email'] !== $email){
    validMaxLen($email, 'email');
    if(empty($err_msg['email'])){
      validEmailDup($email);
    }
    validEmail($email, 'email');
    validRequired($email, 'email');
  }

  if(empty($err_msg)){
    debug('バリデーションOKです。');
    try {
      $dbh = dbConnect();
      $sql = 'UPDATE users  SET username = :u_name, tel = :tel, zip = :zip, addr = :addr, email = :email WHERE id = :u_id';
      $data = array(':u_name' => $username , ':tel' => $tel, ':zip' => $zip, ':addr' => $addr, ':email' => $email, ':u_id' => $dbFormData['id']);
      $stmt = queryPost($dbh, $sql, $data);

      if($stmt){
        debug('クエリ成功。');
        debug('マイページへ遷移します。');
        header("Location:index.php");
      }else{
        debug('クエリに失敗しました。');
        $err_msg['common'] = MSG08;
      }

    } catch (Exception $e) {
      error_log('エラー発生:' . $e->getMessage());
      $err_msg['common'] = MSG07;
    }
  }
}
debug('画面表示処理終了 <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<');
?>
<?php
$siteTitle = 'プロフィール編集';
require('head.php');
?>

  <body>

    <!-- ヘッダー -->
    <?php
      require('header.php');
    ?>

      <section class="prof_edit input_info" >
        <div class="form_container">
          <form action="" method="post" class="form">
            <h2 class="title">プロフィール編集</h2>
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
            <label class="<?php if(!empty($err_msg['tel'])) echo 'err'; ?>">
              TEL<span style="font-size:12px;margin-left:5px;">※ハイフン無しでご入力ください</span>
              <input type="text" name="tel" value="<?php echo getFormData('tel'); ?>">
            </label>
            <div class="msg_area">
              <?php
              if(!empty($err_msg['tel'])) echo $err_msg['tel'];
              ?>
            </div>
            <label class="<?php if(!empty($err_msg['zip'])) echo 'err'; ?>">
              郵便番号<span style="font-size:12px;margin-left:5px;">※ハイフン無しでご入力ください</span>
              <input type="text" name="zip" value="<?php if( !empty(getFormData('zip')) ){ echo getFormData('zip'); } ?>">
            </label>
            <div class="msg_area">
              <?php
              if(!empty($err_msg['zip'])) echo $err_msg['zip'];
              ?>
            </div>
            <label class="<?php if(!empty($err_msg['addr'])) echo 'err'; ?>">
              住所
              <input type="text" name="addr" value="<?php echo getFormData('addr'); ?>">
            </label>
            <div class="msg_area">
              <?php
              if(!empty($err_msg['addr'])) echo $err_msg['addr'];
              ?>
            </div>
            <label class="<?php if(!empty($err_msg['email'])) echo 'err'; ?>">
              Email
              <input type="text" name="email" value="<?php echo getFormData('email'); ?>">
            </label>
            <div class="msg_area">
              <?php
              if(!empty($err_msg['email'])) echo $err_msg['email'];
              ?>
            </div>

            <div class="btn-container">
              <input type="submit" class="btn btn-mid" value="変更する">
            </div>
          </form>
        </div>
      </section>

    <!-- footer -->
    <?php
    require('footer.php');
    ?>
