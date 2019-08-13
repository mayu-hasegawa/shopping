<?php
//共通変数・関数ファイルを読込み
require('function.php');

debug('「　商品詳細ページ　');
debugLogStart();

$p_id = (!empty($_GET['p_id'])) ? $_GET['p_id'] : '';
$viewData = getProductOne($p_id);
if(empty($viewData)){
  error_log('エラー発生:指定ページに不正な値が入りました');
  header("Location:index.php"); //トップページへ
}
debug('取得したDBデータ：'.print_r($viewData,true));

debug('画面表示処理終了 <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<');
?>
<?php
  $siteTitle = '商品詳細';
  require('head.php');
?>

  <body>
  <!-- ヘッダー -->
  <?php
    require('header.php');
  ?>

  <section class="product_detail input_info" >
    <div class="title">
      <span class="badge"><?php echo sanitize($viewData['category']); ?></span>
      <?php echo sanitize($viewData['name']); ?>
      <i class="fa fa-heart favorite_icon js_favorite_click <?php if(favorite($_SESSION['user_id'], $viewData['id'])){ echo 'active'; } ?>" aria-hidden="true" data-productid="<?php echo sanitize($viewData['id']); ?>" ></i>
    </div>
    <div class="product_img">
      <img src="<?php echo sanitize($viewData['pic']); ?>" alt="メイン画像：<?php echo sanitize($viewData['name']); ?>">
    </div>
    <div class="product_comment">
      <p>[ショップからのコメント]</p>
      <p><?php echo sanitize($viewData['comment']); ?></p>
    </div>
    <div class="product_price">
      <p class="price">¥<?php echo sanitize(number_format($viewData['price'])); ?>-</p>
    </div>
    <div class="product_back">
      <a href="index.php<?php echo appendGetParam(array('p_id')); ?>">&lt; 商品一覧に戻る</a>
    </div>
  </section>

  <!-- footer -->
  <?php
    require('footer.php');
  ?>
