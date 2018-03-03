<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>マイページ</title>
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
    <div class="content">
      <!--HOME-->
      <section id="home">
        <div class="container">
          <div class="row">
            <div class="wrap-hero-content">
                <div class="hero-content jfont">
                  <h1>{$title}</h1>
                  <span class="typed"></span><br>
                  {$message}
                </div>
            </div>
            <div class="mouse-icon margin-20">
              <div class="scroll"></div>
            </div>
          </div>
        </div>
      </section>
      <!--/.HOME END-->
      <!--ABOUT-->
      <section id="about">
        <div class="col-md-6 col-xs-12 no-pad">
          <div class="bg-about">
          </div>
        </div>
        <div class="col-md-6 col-sm-12 col-xs-12 white-col">
          <div class="row">
            <div class="col-md-12">
              <div class="wrap-about">
                <div class="w-content">
                  <form method="post" action="auth.php">
                    <input type="hidden" name="type" value="shopping">
                    <button id="buttonother" class="jfont btn jb" type="submit" name="button"><i class="fa fa-th" aria-hidden="true"></i>商品一覧はこちら</button>
                  </form>
                  <br>
                  <form method="post" action="auth.php">
                    <input type="hidden" name="type" value="favorite">
                    <button id="buttonother" class="jfont btn jb" type="submit" name="button"><i class="fa fa-list" aria-hidden="true"></i>欲しいものリスト一覧はこちら</button>
                  </form>
                  <br>
                  <form method="post" action="auth.php">
                    <input type="hidden" name="type" value="cart">
                    <button id="buttonother" class="jfont btn jb" type="submit" name="button"><i class="fa fa-shopping-cart" aria-hidden="true"></i>カート画面へ</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!--/.ABOUT END-->
      <!--SKILLS-->
      <section class="white-bg" id="skill">
        <div class="container">
          <div class="row">
            <div class="col-md-3">
              <h3 class="title-small">
                <span>人気商品</span>
              </h3>
              <p class="content-detail jfont">
                SANSAI-GROUPで人気のある商品の上位5品を表示しております<br>
                総売上個数も確認することができます
              </p>
            </div>
            <div class="col-md-9 content-right">
              <!--SKILLST-->
              <div class="skillst">
                {if ($data2)}
                {foreach item=item from=$data2}
                <div class="skillbar" data-percent="{$item.per}%" data-num="{$item.num}個">
                  <div class="title head-sm jfont">
                    {$item.name}
                  </div>
                  <div class="count-bar jfont">
                    <div class="count"></div>
                  </div>
                </div>
                {/foreach}
                {/if}
              </div>
              <!--/.SKILLST END-->
            </div>
          </div>
        </div>
      </section>
      <!--/.SKILLS END-->
      <section id="contact" class="grey-bg">
        <div class="container">
          <div class="row jfont">
            <div class="col-md-3">
              <h3 class="title-small">
                <span>各種設定</span>
              </h3>
              <p class="content-detail jfont">
              </p>
            </div>
            <div class="col-md-9 content-right">
              <form method="get" action="auth.php">
                <input type="hidden" name="type" value="logout">
                <!-- <input type="submit" value="パスワード変更"> -->
                <button id="buttonother" class="btn jb" type="submit"><i class="fa fa-sign-out" aria-hidden="true"></i>ログアウト</button>
              </form>
              <form name="registration" method="post" action="auth.php">
                <input type="hidden" name="type" value="change_password">
                <!-- <input type="submit" value="パスワード変更"> -->
                <button id="buttonother" class="btn jb" type="submit" name="button"><i class="fa fa-exchange" aria-hidden="true"></i>パスワード変更</button>
              </form>
              <form name="delete_member" method="post" action="auth.php">
                <input type="hidden" name="type" value="delete_member">
                <!-- <input type="submit" value="退会"> -->
                <button id="buttonother" class="btn jb" type="submit" name="button"><i class="fa fa-times" aria-hidden="true"></i>退会する</button>
              </form>
            </div>
          </div>
        </div>
      </section>
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
