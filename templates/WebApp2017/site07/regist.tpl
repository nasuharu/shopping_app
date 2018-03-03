<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>新規登録</title>
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
    <section id="contact" class="grey-bg">
      <div class="container">
        <div class="row">
          <div class="col-md-3">
            <h3 class="title-small">
              <span>{$title}</span>
            </h3>
            <div class="jfont content-detail">
              {$message}<br>
              各種項目に必要事項を記入して登録ボタンをクリックしてください<br>
              *・・・必須項目
            </div>
          </div>
          <div class="jfont col-md-9 content-right">
            <form action="auth.php" method="post">
              <div class="group">
                <input required="" type="text" name="first_name"><span class="highlight"></span><span class="bar"></span><label>*First Name</label>
              </div>
              <div class="group">
                <input required="" type="text" name="last_name"><span class="highlight"></span><span class="bar"></span><label>*Last Name</label>
              </div>
              <div class="group">
                <input required="" type="email" name="mail_address"><span class="highlight"></span><span class="bar"></span><label>*Email</label>
              </div>
              <div class="group">
                <input required="" type="password" name="password"><span class="highlight"></span><span class="bar"></span><label>*Password</label>
              </div>
              <div class="group">
                <input required="" type="text" name="address"><span class="highlight"></span><span class="bar"></span><label>*Address</label>
              </div>
              <input type="hidden" name="type" value="registration2">
              <input class="jfont" type="submit" value="登録">
              <!-- <a href="login.html" class="pull-right jfont">ログイン画面へ</a> -->
            </form>
            <form class="" action="auth.php" method="post">
              <input type="hidden" name="type">
              <input class="jfont" type="submit" value="ログイン画面へ">
            </form>
          </div>
        </div>
      </div>
    </section>
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
