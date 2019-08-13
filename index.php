<?php

require('function.php');

debug('「　トップページ　');
debugLogStart();

// 画面処理

$currentPageNum = (!empty($_GET['p'])) ? $_GET['p'] : 1;
$category = (!empty($_GET['c_id'])) ? $_GET['c_id'] : '';
$sort = (!empty($_GET['sort'])) ? $_GET['sort'] : '';
if(!is_int((int)$currentPageNum)){
  error_log('エラー発生:指定ページに不正な値が入りました');
  header("Location:index.php");
}
$listSpan = 6;
$currentMinNum = (($currentPageNum-1)*$listSpan);
$dbProductData = getProductList($currentMinNum, $category, $sort);
$dbCategoryData = getCategory();
debug('現在のページ：'.$currentPageNum);

debug('画面表示処理終了 <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<');
?>
<?php
  $siteTitle = 'ホーム';
  require('head.php');
?>

  <body>
  <!-- ヘッダー -->
  <?php
    require('header.php');
  ?>

  <section class="serch">
    <form name="" method="get">
      <div class="serch_area">
        <h1 class="title">カテゴリー</h1>
        <div class="selectbox">
          <span class="icn_select"></span>
          <select name="c_id" id="">
            <option value="0" <?php if(getFormData('c_id',true) == 0 ){ echo 'selected'; } ?> >選択してください</option>
            <?php
              foreach($dbCategoryData as $key => $val){
            ?>
              <option value="<?php echo $val['id'] ?>" <?php if(getFormData('c_id',true) == $val['id'] ){ echo 'selected'; } ?> >
                <?php echo $val['name']; ?>
              </option>
            <?php
              }
            ?>
          </select>
        </div>
      </div>
      <div class="serch_area">
        <h1 class="title">表示順</h1>
        <div class="selectbox">
          <span class="icn_select"></span>
          <select name="sort">
            <option value="0" <?php if(getFormData('sort',true) == 0 ){ echo 'selected'; } ?> >選択してください</option>
            <option value="1" <?php if(getFormData('sort',true) == 1 ){ echo 'selected'; } ?> >金額が安い順</option>
            <option value="2" <?php if(getFormData('sort',true) == 2 ){ echo 'selected'; } ?> >金額が高い順</option>
          </select>
        </div>
      </div>
      <input type="submit" value="検索" class="submit">
    </form>
  </section>

  <section class="products">
    <div class="block">
      <div class="products_serch">
        <div class="left">
          <span class="total-num"><?php echo sanitize($dbProductData['total']); ?></span>件の商品が見つかりました
        </div>
        <div class="right">
          <span class="num"><?php echo (!empty($dbProductData['data'])) ? $currentMinNum+1 : 0; ?></span> - <span class="num"><?php echo $currentMinNum+count($dbProductData['data']); ?></span>件 / <span class="num"><?php echo sanitize($dbProductData['total']); ?></span>件中
        </div>
      </div>
      <div class="products_area">
        <?php
          foreach($dbProductData['data'] as $key => $val):
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
        ?>
      </div>
    </div>
  </section>

  <?php pagination($currentPageNum, $dbProductData['total_page']); ?>

  <!-- フッター -->
  <?php
    require('footer.php');
  ?>
