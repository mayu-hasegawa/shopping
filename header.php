<?php
  $userData = getUser($_SESSION['user_id']);
?>
<header class="header_top">
  <div class="header_nav">
    <h1><a href="index.php">SHOPPING MARKET</a></h1>
    <ul class="nav_main">
      <?php
        if(empty($_SESSION['user_id'])){
      ?>
        <li class="local_nav"><a href="signup.php">ユーザー登録</a></li>
        <li class="local_nav"><a href="login.php">ログイン</a></li>
      <?php
        }else{
      ?>
        <li class="local_nav js_local_nav">
          こんにちは<br><?php echo (!empty($userData['username']) ? sanitize($userData['username']) : "ゲスト"); ?>さん
          <ul class="local_menu js_local_menu menu_hidden">
            <li class="nav_link"><a href="index.php">ホーム</a></li>
            <li class="nav_link"><a href="myFavorite.php">お気に入り一覧</a></li>
            <li class="nav_link"><a href="profEdit.php">プロフィールを編集する</a></li>
            <li class="nav_link"><a href="removeUser.php">退会する</a></li>
          </ul>
        </li>
        <li class="local_nav"><a href="logout.php">ログアウト</a></li>
      <?php
        }
      ?>
    </ul>
  </div>
</header>
