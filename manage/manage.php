<?php
  //全体の設定
  define('_ROOT_DIR', __DIR__ . '/');
  require_once _ROOT_DIR . '../../../../php_libs/WebApp2017/site07/init_manage.php';
  //Smartyの設定
  $smarty  = new Smarty;
  $smarty->template_dir = _SMARTY_TEMPLATES_DIR;
  $smarty->compile_dir  = _SMARTY_TEMPLATES_C_DIR;
  $smarty->config_dir   = _SMARTY_CONFIG_DIR;
  $smarty->cache_dir    = _SMARTY_CACHE_DIR;
  $tplfile = 'manage.tpl';
  //DBの設定
  $db_user = "user1707";	// ユーザー名
  $db_pass = "password";	// パスワード
  $db_host = "localhost";	// ホスト名
  $db_name = "db1707";	// データベース名
  $db_type = "mysql";	// データベースの種類

  $dsn = "$db_type:host=$db_host;dbname=$db_name;charset=utf8";

  try {
    $pdo = new PDO($dsn, $db_user,$db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  } catch(PDOException $Exception) {
    die('エラー :' . $Exception->getMessage());
  }
  $img_dir = '../pictures';
  if (isset($_POST['insert'])) {  //登録処理
    try {
      $pdo->beginTransaction();
      $sql = "INSERT INTO item (name, price, comment, url, formalName) VALUES ( :name, :price, :comment, :url, :formalName )";
      $stmh = $pdo->prepare($sql);
      $stmh->bindValue(':name', $_POST['name'],	PDO::PARAM_STR );
      $stmh->bindValue(':price', $_POST['price'],	PDO::PARAM_INT );
      $stmh->bindValue(':comment', $_POST['comment'],	PDO::PARAM_STR );
      $stmh->bindValue(':url', $_POST['url'], PDO::PARAM_INT );
      $stmh->bindValue(':formalName', $_POST['formalName'], PDO::PARAM_INT );
      $stmh->execute();
      $code = $pdo->lastInsertId();
      $pdo->commit();
      $tname = $_FILES['picture']['tmp_name'];
      if ($tname)
        move_uploaded_file($tname, "$img_dir/$code.jpg");
    } catch (PDOException $Exception) {
      $pdo->rollBack();
      print "エラー：" . $Exception->getMessage();
    }
  }
  else if (isset($_POST['delete'])) {
  //削除処理
    try {
      $pdo->beginTransaction();
      $code = $_POST['code'];
      $sql = "DELETE FROM item WHERE code = :code";
      $stmh = $pdo->prepare($sql);
      $stmh->bindValue(':code', $code, PDO::PARAM_INT);
      $stmh->execute();
      $pdo->commit();
      if (file_exists("$img_dir/$code.jpg"))
        unlink("$img_dir/$code.jpg");
    } catch (PDOException $Exception) {
      $pdo->rollBack();
      print "エラー：" . $Exception->getMessage();
    }
  }
  else if (isset($_POST['update'])) {
    try {
      $pdo->beginTransaction();
      $sql = "UPDATE item SET name = :name, price = :price, comment = :comment, url = :url, formalName = :formalName WHERE code = :code";
      $stmh = $pdo->prepare($sql);
      $stmh->bindValue(':name', $_POST['name'],	PDO::PARAM_STR );
      $stmh->bindValue(':price', $_POST['price'],	PDO::PARAM_INT );
      $stmh->bindValue(':comment', $_POST['comment'],	PDO::PARAM_STR );
      $stmh->bindValue(':url', $_POST['url'], PDO::PARAM_INT );
    	$stmh->bindValue(':code', $_POST['code'],	PDO::PARAM_INT );
    	$stmh->bindValue(':formalName', $_POST['formalName'], PDO::PARAM_INT );
      $stmh->execute();
      $code = $pdo->lastInsertId();
      $pdo->commit();
      $code2 = $_POST['code'];
      $tname = $_FILES['picture']['tmp_name'];
      if ($tname)
      	if (file_exists("$img_dir/$code2.jpg")){
        		unlink("$img_dir/$code2.jpg");}
        move_uploaded_file($tname, "$img_dir/$code2.jpg");
    } catch (PDOException $Exception) {
      $pdo->rollBack();
      print "エラー：" . $Exception->getMessage();
    }
  }
  //商品リスト: DBを検索し、結果を連想配列$dataに格納する
  if (isset($_POST['update_form'])) {
    $tplfile = 'update_form.tpl';
    $code = $_POST['code'];
    $sql= "SELECT * FROM item WHERE code = :code";
    $stmh = $pdo->prepare($sql);
    $stmh->bindValue(':code', $code, PDO::PARAM_INT);
    $stmh->execute();
  }else {
    $sql= "SELECT * FROM item ORDER BY code DESC";
    $stmh = $pdo->query($sql);
    $stmh->execute();
  }
  $i = 0;
  $data = array();
  while ($row = $stmh->fetch(PDO::FETCH_ASSOC)) {
    foreach ($row as $key => $value)
    $data[$i][$key] = $value;
    $data[$i]['name'] = htmlspecialchars($data[$i]['name']);
    $data[$i]['comment'] = htmlspecialchars($data[$i]['comment']);
    $code = $data[$i]['code'];
    if (file_exists("$img_dir/$code.jpg"))
      $data[$i]['file_exists'] = TRUE;
    else
      $data[$i]['file_exists'] = FALSE;
    $i++;
  }
  //表示
  $smarty->assign('img_dir', $img_dir);
  $smarty->assign('data', $data);
  $smarty->display($tplfile);
?>
