<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>カート画面</title>
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
      <!--CONTENT-->
      <div class="content">
        <!--WORK-->
        <section class="white-bg mar-tm-10" id="work">
          <div class="container">
            <div class="row">
              <div class="col-md-3">
                <h3 class="title-small content-left">
                  <span>カート内容</span>
                </h3>
                <p class="content-detail jfont">
                  購入未確定の商品一覧を表示しています<br>購入を確定する場合は下の確定ボタンを押してください
                </p>
                <form class="jfont" method=post action="auth.php">
                  <button id="buttonother" class="btn jb" type="submit" name="buy"><i class="fa fa-cart-plus" aria-hidden="true"></i>買い物を続ける</button>
                <input type=hidden name=type value="shopping">
                </form>
              </div>
              <div class="col-md-9 content-right">
                <table class="type04 jfont">
                  {if ($data)}
                  {foreach item=orders from=$data}
                  <form method=post action="auth.php"><tr>
                  <tr>
                  	<th scope="row">{$orders.item_name}</th>
                  	<td>{$orders.unit}個</td>
                    <td>{$orders.price}</td>
                    <td>
                      <button id="buttonother" class="btn jb" type="submit" name="cart_delete"><i class="fa fa-times" aria-hidden="true"></i>カートから削除</button>
                      <!-- <input type=submit name=cart_delete value="カートから削除"> -->
                      <input type=hidden name=code2 value={$orders.order_id}>
                      <input type=hidden name=type value="cart">
                    </td>
                  </tr>
                  {/foreach}
                  {/if}
                </table>
              </div>
            </div>
          </div>
        </section>
        <!--CONTACT-->
        <section id="contact" class="grey-bg">
          <div class="container">
            <div class="row">
              <div class="col-md-3">
                <h3 class="title-small">
                  <span>ご注文最終確認</span>
                </h3>
                <p class="content-detail jfont">
                </p>
              </div>
              <div class="col-md-9 content-right">
                <form action="auth.html" method="post">
                  <div class="group">
                    <h4 class="jfont">【合計金額】 {$total}円</h4>
                  </div>
                  <div class="group">
                    <table class="type04 jfont">
                      <tr>
                        <td><p class="jfont">お支払請求書送付先</p></td>
                        <td>{$address}</td>
                      </tr>
                    </table>
                  </div>
                  <div class="group">
                    <p class="jfont">利用規約に同意します</p>
                    <table class="type04 jfont">
                      <tr>
                        <td>はい</td>
                        <td><input type="radio" name="optionsRadios" value="1"></td>
                      </tr>
                      <tr>
                        <td>いいえ</td>
                        <td><input type="radio" name="optionsRadios" value="0"></td>
                      </tr>
                    </table>
                  </div>
                </form>
                <form action="auth.php" method="post">
                  <input type=hidden name=type value="cart">
                  <div class="aa1 jfont">
                    <button id="buttonother" class="btn jb" type="submit" name="buy" disabled="disabled">購入確定</button>
                  </div>
                </form>
              </div>
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
