<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>退会手続き</title>
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
    <div class="content-wrap">
      <div class="content">
        <section class="grey-bg mar-tm-10" id="work">
          <div class="container">
            <div class="row">
              <div class="col-md-3">
                <h3 class="title-small">
                  <span>退会手続き</span>
                </h3>
                <p class="content-detail jfont">
                  退会をご希望のお客様は、『退会する』のボタンを押してください<br>
                </p>
              </div>
              <div class="col-md-9 content-right">
                <form class="jfont" action="auth.php" method="post">
                  <input type="hidden" name="type" value="delete_member">
                  <input type="hidden" name="delete" value="delete">
                  <button id="buttonother" class="btn jb" type="submit"><i class="fa fa-times" aria-hidden="true"></i>退会する</button>
                </form>
                <br>
                <form class="jfont" action="auth.php" method="post">
                  <input type="hidden" name="type" value="delete_member">
                  <input type="hidden" name="back" value="back">
                  <button id="buttonother" class="btn jb" type="submit"><i class="fa fa-reply" aria-hidden="true"></i>戻る</button>
                </form>
              </div>
            </div>
          </div>
        </section>
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
