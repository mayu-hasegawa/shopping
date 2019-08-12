<?php
require('function.php');

debug('「　マイページ　');
debugLogStart();

require('auth.php');

$u_id = $_SESSION['user_id'];
$favoriteData = getMyFavorite($u_id);

debug('取得したお気に入りデータ：'.print_r($favoriteData,true));
debug('画面表示処理終了 <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<');
?>

<?php
  $siteTitle = 'お気に入り一覧';
  require('head.php');
?>
  <body>

  <!-- ヘッダー -->
  <?php
    require('header.php');
  ?>

  <section class="products">
    <div class="block">
      <h2>お気に入り一覧</h2>
      <div class="products_area">
        <?php
          if(!empty($favoriteData)):
          foreach($favoriteData as $key => $val):
          ?>
          <div class="item">
            <a href="productDetail.php<?php echo (!empty(appendGetParam())) ? appendGetParam().'&p_id='.$val['id'] : '?p_id='.$val['id']; ?>">
              <div class="item_head">
                <img src="<?php echo sanitize($val['pic']); ?>" alt="<?php echo sanitize($val['name']); ?>">
              </div>
              <div class="item_body">
                <p class="item_title"><?php echo sanitize($val['name']); ?> <span class="price">¥<?php echo sanitize(number_format($val['price'])); ?></span></p>
              </div>
            </a>
          </div>
        <?php
          endforeach;
         endif;
        ?>
      </div>
    </div>
  </section>

  <!-- フッター -->
  <?php
    require('footer.php');
  ?>
