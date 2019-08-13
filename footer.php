<footer class="footer">
  <div class="copyright">
    <p>Copyright © 2019&nbsp;Mayu Hasegawa&nbsp;<br class="hidden_pc">&nbsp;All Rights Reserved.</p>
  </div>
</footer>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="js/header.js" type="text/javascript"></script>
<script>
  $(function(){

    var $favorite,
        favoriteProductId;
    $favorite = $('.js_favorite_click') || null;
    favoriteProductId = $favorite.data('productid') || null;
    if(favoriteProductId !== undefined && favoriteProductId !== null){
      $favorite.on('click',function(){
        var $this = $(this);
        $.ajax({
          type: "POST",
          url: "ajaxFavorite.php",
          data: { productId : favoriteProductId}
        }).done(function( data ){
          $this.toggleClass('active');
        }).fail(function( msg ) {
        });
      });
    }
  });
</script>
</body>
</html>
