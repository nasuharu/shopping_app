<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>商品の更新</title>
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta content="Bodo - Simple One Page Personal" name="description">
    <meta content="BdgPixel" name="author">
    <!--Fav-->
    <link href="../images/favicon.ico" rel="shortcut icon">
    <!--styles-->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/owl.carousel.css" rel="stylesheet">
    <link href="../css/owl.theme.css" rel="stylesheet">
    <link href="../css/magnific-popup.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/responsive.css" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" >
    <!--fonts google-->
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,500,700' rel='stylesheet' type='text/css'>
    <!--[if lt IE 9]>
       <script type="text/javascript" src="js/html5shiv.min.js"></script>
    <![endif]-->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  </head>
  <body>
    <div id="target"></div>
    <div class="content-wrap">
      <div class="content">
        <section class="grey-bg mar-tm-10 content-left" id="work">
          <div class="container">
            <div class="row">
              <div class="col-md-2 jfont">
                <h3 class="title-small">
                  <span>商品一覧</span>
                </h3>
                <p class="content-detail jfont">
                  登録されている商品の<br>一覧を表示しています
                </p>
              </div>
              <div class="col-md-9 content-left">
                <div class="">
                  <table class="col-md-4 table table-bordered alt-table-responsive jfont" border="1">
                    <tr>
                      <th class="col-xs-3 col-ms-3 col-md-4 col-lg-4" scope="row">商品画像</th>
                      <td>商品名</td>
                      <td>価格</td>
                      <td>説明</td>
                      <td>リンク</td>
                      <td>正式名称（アルファベット）</td>
                    </tr>
                    <form class="col-xs-2" method="post" action="{$SCRIPT_NAME}" enctype= "multipart/form-data">
                      <tr>
                      {if ($data)}
                      {foreach item=item from=$data}
                      <form method=post action="{$SCRIPT_NAME}">
                          <th class="col-xs-3 col-ms-3 col-md-4 col-lg-4" scope="row">
                            {if ($item.file_exists)}<img src="{$img_dir}/{$item.code}.jpg" border=0 width="100">{/if}
                            <br><input type="file" name="picture">
                          </th>
                          <td><textarea type="text" name="name" cols="10" rows="4" maxlength="100" placeholder="商品名を入力"></textarea></td>
                          <td><input type="text" name="price" value={$item.price}></td>
                          <td><textarea type="text" name="comment" cols="10" rows="4" maxlength="100" placeholder="説明文を入力"></textarea></td>
                          <td><textarea type="text" name="url" cols="10" rows="4" maxlength="100" placeholder="URLを入力"></textarea></td>
                          <td><textarea type="text" name="formalName" cols="10" rows="4" maxlength="100" placeholder="正式名称を入力"></textarea></td>
                          <td>
                            <button id="buttonother" class="btn jfont jb" type="submit" name="update"><i class="fa fa-refresh" aria-hidden="true"></i>更新確定</button>
                            <input type=hidden name=code value={$item.code}>
                          </td>
                        </tr>
                      </form>
                      {/foreach}
                      {/if}
                    </table>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
      <!--/.CONTENT-WRAP END-->
    </div>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="../js/jquery-1.9.1.min.js" type="text/javascript"></script>
    <script src="../js/jquery.appear.js" type="text/javascript"></script>
    <script src="../js/bootstrap.min.js" type="text/javascript"></script>
    <script src="../js/classie.js" type="text/javascript"></script>
    <script src="../js/owl.carousel.min.js" type="text/javascript"></script>
    <script src="../js/jquery.magnific-popup.min.js" type="text/javascript"></script>
    <script src="../js/masonry.pkgd.min.js" type="text/javascript"></script>
    <script src="../js/masonry.js" type="text/javascript"></script>
    <script src="../js/smooth-scroll.min.js" type="text/javascript"></script>
    <script src="../js/typed.js" type="text/javascript"></script>
    <script src="../js/main.js" type="text/javascript"></script>
  </body>
</html>
