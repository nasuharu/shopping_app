<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>商品一覧</title>
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
    <!--[if lt IE 9]>
       <script type="text/javascript" src="js/html5shiv.min.js"></script>
    <![endif]-->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  </head>
  <body>
    <div id="target"></div>
    <div class="content-wrap">
      <div class="content">
        <section class="grey-bg mar-tm-10" id="work">
          <div class="container">
            <div class="row">
              <div class="col-md-3">
                <h3 class="title-small jfont">
                  <span>商品一覧</span>
                </h3>
                <p class="content-detail jfont">
                  SANSAI-GROUPで購入できる品すべてを表示しています
                </p>

                <p class="content-detail jfont">
                  {$count}
                </p>
                <form name="nameform" action="auth.php" method="post">
                  <div class="group">
                    <input class="form-control jfont" type="text" name="search_key" placeholder="商品名を入力">
                  </div>
                  <input type="hidden" name="type" value="shopping">
                  <br>
                  <button type="submit" name="button" class="jfont jb"><i class="fa fa-search" aria-hidden="true"></i>検索</button>
                </form>
                <br>
                <form class="" action="auth.php" method="post">
                  <input type="hidden" name="search_all">
                  <input type="hidden" name="type" value="shopping">
                  <button type="submit" name="button" class="jfont jb"><i class="fa fa-th" aria-hidden="true"></i>全件表示</button>
                </form>
                <br>
                <form method="post" action="auth.php">
                  <input type="hidden" name="type" value="mypage">
                  <button type="submit" name="button" class="jfont jb"><i class="fa fa-reply" aria-hidden="true"></i>マイページへ戻る</button>
                </form>
              </div>
              <div class="col-md-9 content-right">
                <!--PORTFOLIO IMAGE-->
                <ul class="portfolio-image">
                  {if ($data)}
                  {foreach item=item from=$data}
                  <li class="col-md-6">
                    <form action="auth.php" method="post">
                      <input type="hidden" name="type" value="product">
                      <input type="hidden" name="code" value="{$item.code}">
                      {if ($item.file_exists)}<img src="{$img_dir}/{$item.code}.jpg">{/if}
                      <div class="decription-wrap">
                        <div class="image-bg">
                           <p class="desc">
                             <button type="submit" class="jfont jbutton">{$item.name}</button>
                           </p>
                        </div>
                      </div>
                    </form>
                  </li>
                  {/foreach}
                  {/if}
                </ul>
                <!--/.PORTFOLIO IMAGE END-->
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
