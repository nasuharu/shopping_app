<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>商品詳細</title>
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta content="Bodo - Simple One Page Personal" name="description">
    <meta content="BdgPixel" name="author">
    <!--Fav-->
    <link href="images/favicon.ico" rel="shortcut icon">
    <!--styles-->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/owl.carousel.css" rel="stylesheet">
    <link href="css/owl.theme.css" rel="stylesheet">
    <link href="css/magnific-popup.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/responsive.css" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" >
    <!--fonts google-->
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,500,700' rel='stylesheet' type='text/css'>
  </head>
  <body>
    <div id="target"></div>
    <!--CONTENT WRAP-->
    <div class="content-wrap">
      <div class="content">
        <section id="about" class="grey-bg">
          <div class="col-md-6 col-xs-12 no-pad">
            <div class="bg-about2">
              {if ($picfile.file_exists)}<img src="{$img_dir}/{$piccode}.jpg" class="img-thumbnail center-block">{/if}
            </div>
          </div>
          <div class="col-md-6 col-sm-12 col-xs-12 grey-col">
            <div class="row">
              <!--OWL CAROUSEL2-->
              <div class="">
                <div class="col-md-12">
                  <div class="wrap-about">
                    <div class="w-content">
                      <h1 class="pull-right">{$itemN}</h1>
                      <p class="head-about jfont">{$itemFN}<br></p>
                      <p class="head-about jfont">{$itemC}<br></p>
                      <h5 class="name">
                        ￥{$itemP}
                      </h5>
                      <form class="jfont" action="auth.php" method="post">
                        個数を入力
                        <input type="number" min="1" name="unit" class="form-control bfh-number" value="1">
                        <br>
                        <input type=hidden name=code value={$item_code}>
                        <input type=hidden name=type value="cart">
                        <button id="buttonother" class="btn jb" type="submit" name="add"><i class="fa fa-cart-arrow-down" aria-hidden="true"></i>カートへ追加</button>
                      </form>
                      <br>
                      <button class="jbutton">
                        <a href="{$itemU}" id="buttonother" class="jfont btn jb" type="submit"><i class="fa fa-cutlery" aria-hidden="true"></i>おすすめのレシピを見る</a>
                      </button>
                      <form action="auth.php" method="post">
                        <input type=hidden name=type value="product">
                        <input type="hidden" name="code" value="{$piccode}">
                        <br>
                          <div class="favadddel">
                          </div>
                      </form>
                      <br>
                    </div>
                  </div>
                </div>
                <form method="post" action="auth.php">
                  <input type="hidden" name="type" value="shopping">
                  <button id="buttonother" class="btn jfont jb" type="submit"><i class="fa fa-reply" aria-hidden="true"></i>商品一覧へ戻る</button>
                </form>
              </div>
              <!--/.OWL CAROUSEL2 END-->
            </div>
          </div>
        </section>
        <!--/.CONTACT END-->
        <!--FOOTER-->
        <footer>
          <div class="footer-top">
            <ul class="socials">
              <li class="facebook">
                <a href="#" data-hover="Facebook">Facebook</a>
              </li>
              <li class="twitter">
                <a href="#" data-hover="Twitter">Twitter</a>
              </li>
              <li class="gplus">
                <a href="#" data-hover="Google +">Google +</a>
              </li>
            </ul>
          </div>
          <div class="footer-bottom">
            <div class="container">
              <div class="row">
                <img src="images/spinach.png" alt="logo bottom" class="center-block" />
              </div>
            </div>
          </div>
        </footer>
        <!--/.FOOTER-END-->
      <!--/.CONTENT END-->
      </div>
    <!--/.CONTENT-WRAP END-->
    </div>
    <script src="js/jquery-1.9.1.min.js" type="text/javascript"></script>
    <script src="js/jquery.appear.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
    <script src="js/classie.js" type="text/javascript"></script>
    <script src="js/owl.carousel.min.js" type="text/javascript"></script>
    <script src="js/jquery.magnific-popup.min.js" type="text/javascript"></script>
    <script src="js/masonry.pkgd.min.js" type="text/javascript"></script>
    <script src="js/masonry.js" type="text/javascript"></script>
    <script src="js/smooth-scroll.min.js" type="text/javascript"></script>
    <script src="js/typed.js" type="text/javascript"></script>
    <script src="js/main.js" type="text/javascript"></script>
  </body>
</html>
