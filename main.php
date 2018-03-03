<?php
define('_ROOT_DIR', __DIR__ . '/');
require_once _ROOT_DIR . '../../../php_libs/WebApp2017/site07/init.php';

$img_dir = 'pictures';

$smarty = new Smarty;
$smarty->template_dir = _SMARTY_TEMPLATES_DIR;
$smarty->compile_dir  = _SMARTY_TEMPLATES_C_DIR;
$smarty->config_dir   = _SMARTY_CONFIG_DIR;
$smarty->cache_dir    = _SMARTY_CACHE_DIR;

// Authクラスの読み込み
$auth = new Auth;
$auth->set_authname(_MEMBER_AUTHINFO);
$auth->set_sessname(_MEMBER_SESSNAME);
$auth->start();

$smarty->assign("message", "いらっしゃいませ");

if (!empty($_POST['type']) &&  $_POST['type'] == 'authenticate' ) {
    // 認証機能

    // DBに接続
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

    // ユーザーネームで検索
    $userdata = [];
    try {
        $sql= "SELECT * FROM member WHERE username = :username ";
        $stmh = $pdo->prepare($sql);
        $stmh->bindValue(':username',  $_POST['username'],  PDO::PARAM_STR );
        $stmh->execute();
        while ($row = $stmh->fetch(PDO::FETCH_ASSOC)) {
            foreach( $row as $key => $value){
                $userdata[$key] = $value;
            }
        }
    } catch (PDOException $Exception) {
        print "エラー：" . $Exception->getMessage();
    }
    if(!empty($userdata['password']) && $auth->check_password($_POST['password'], $userdata['password'])){

        $auth->auth_ok($userdata);
        $smarty->assign("title", "会員ページ");
        $smarty->assign("message", "ログインしました");
    	$file = 'main_auth.tpl';


        if (empty($SESSION['id'])){
    		$_SESSION['id']=$_POST['username'];
    		}
    } else {
    	$smarty->assign("message", "ログインに失敗しました");
    	$smarty->assign("title", "ゲストページ");
    	$smarty->assign("type", "authenticate");
    	$file = 'main_login.tpl';
    }

}else if (!empty($_POST['type']) &&  $_POST['type'] == 'delete_member' ) {
    // ユーザ削除

    // データベースからユーザ情報を削除する処理を挿入



}else if (!empty($_POST['type']) &&  $_POST['type'] == 'shopping' ) {
    // 商品選択画面

    // DBに接続
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

    $sql= "SELECT * FROM item ORDER BY code DESC";
	$stmh = $pdo->query($sql);
	$stmh->execute();

    $i = 0;
	$data = array();

    while ($row = $stmh->fetch(PDO::FETCH_ASSOC)) {
  		foreach ($row as $key => $value)
  		$data[$i][$key] = $value;
  		$data[$i]['name'] = htmlspecialchars($data[$i]['name']);
  		$data[$i]['comment'] = htmlspecialchars($data[$i]['comment']);
  		$code = $data[$i]['code'];
  		if (file_exists("$img_dir/$code.jpg")){
    		$data[$i]['file_exists'] = TRUE;
  		}else{
    		$data[$i]['file_exists'] = FALSE;
  		}
  		$i++;
	}
    $smarty->assign('img_dir', $img_dir);
	$smarty->assign('data', $data);
    $file = 'main_shopping.tpl';

}else if (!empty($_POST['type']) &&  $_POST['type'] == 'cart' ) {
    // カート画面
     // DBに接続
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

    if (!empty($_POST['code']) && $_POST['unit'] > 0) {
    	$code = $_POST['code'];
		$sql= "SELECT * FROM item WHERE code = :code";
		$stmh = $pdo->prepare($sql);
		$stmh->bindValue(':code', $code, PDO::PARAM_INT);
		$stmh->execute();

    	//$user_name = $_SESSION['id'];
    	$row = $stmh->fetch(PDO::FETCH_ASSOC);

    	$updated_stock = $row['stock'] - $_POST['unit'];

    	try{
    		$pdo->beginTransaction();

    		$sql = "UPDATE item SET stock = :updated_stock WHERE code = :code";
    		$stmh = $pdo->prepare($sql);
    		$stmh->bindValue(':updated_stock', $updated_stock, PDO::PARAM_STR );
    		$stmh->bindValue(':code', $code, PDO::PARAM_INT );
    		$stmh->execute();

    		$sql = "INSERT into orders (user_name, item_code, item_name, price, unit, status) VALUES (:user_name, :item_code, :item_name, :price, :unit, :status)";
    		$stmh = $pdo->prepare($sql);
    		$stmh->bindValue(':user_name', $_SESSION['id'], PDO::PARAM_STR );
    		$stmh->bindValue(':item_code', $code, PDO::PARAM_INT );
    		$stmh->bindValue(':item_name', $row['name'], PDO::PARAM_STR );
    		$stmh->bindValue(':price', $row['price'], PDO::PARAM_INT );
    		$stmh->bindValue(':unit', $_POST['unit'], PDO::PARAM_INT );
    		$stmh->bindValue(':status', 1, PDO::PARAM_INT );
    		$stmh->execute();

    		$pdo->commit();

    	} catch(PDOException $Exception) {
    		$pdo->rollBack();
      		die('エラー :' . $Exception->getMessage());
    	}
	}

    $sql= "SELECT * FROM orders WHERE user_name = :user_name AND status = 1";
	$stmh = $pdo->prepare($sql);
	$stmh->bindValue(':user_name', $_SESSION['id'], PDO::PARAM_STR);
	$stmh->execute();

    if (isset($_POST['buy'])) {

    	try{
	    	$pdo->beginTransaction();

    		$sql = "UPDATE orders SET status = 2 WHERE user_name = :user_name AND status = 1";
    		$stmh = $pdo->prepare($sql);
    		$stmh->bindValue(':user_name', $_SESSION['id'], PDO::PARAM_STR );
    		$stmh->execute();

    		$pdo->commit();
    	} catch(PDOException $Exception) {
    		$pdo->rollBack();
      		die('エラー :' . $Exception->getMessage());
      	}


    	$smarty->assign("title", "会員ページ");
    	$smarty->assign("message", "お買い上げありがとうございました");
    	$file = 'main_auth.tpl';

	}else{

    $total = 0;
    $i = 0;
	$data = array();
	while ($row = $stmh->fetch(PDO::FETCH_ASSOC)) {
  		foreach ($row as $key => $value)
  		$data[$i][$key] = $value;
  		$data[$i]['item_name'] = htmlspecialchars($data[$i]['item_name']);

  		$total = $total + $data[$i]['price'] * $data[$i]['unit'];

  	$i++;
	}

    $smarty->assign('total', $total);
    $smarty->assign('data', $data);
    $file = 'main_cart.tpl';
    }






}else if (!empty($_POST['type']) &&  $_POST['type'] == 'delete' ) {
    // ユーザ削除

    // パスワード変更の処理を挿入

}else if( !empty($_GET['type']) && $_GET['type'] == 'logout'){
   $auth->logout();
}


if($auth->check()){
    // 認証済み
    if (empty($file)){
    	$smarty->assign("title", "会員ページ");
    	$smarty->assign("message", "いらっしゃいませ");
    	$file = 'main_auth.tpl';
	}else{
	}

}else{
    // 未認証
    $smarty->assign("title", "ゲストページ");
    $smarty->assign("type", "authenticate");
    $file = 'main_login.tpl';
}

if (!empty($_POST['type']) &&  $_POST['type'] == 'registration2' ) {
    // 新規ユーザ追加

    // DBに接続
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

    // フォームに入力があればユーザを追加
    if(!empty($_POST['mail_address']) && !empty($_POST['password']) && !empty($_POST['last_name']) && !empty($_POST['first_name'])){
    	$userdata = [];
    	try {
    		$sql= "INSERT INTO member (username, password, last_name, first_name) values(:mail_address, :password, :last_name, :first_name)";
    		$stmh = $pdo->prepare($sql);


    		$stmh->bindValue(':mail_address',  $_POST['mail_address'],  PDO::PARAM_STR );

    		$cost = 10;
    		$salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
    		$salt = sprintf("$2y$%02d$", $cost) . $salt;
    		$hash = crypt($_POST['password'], $salt);
    		$stmh->bindValue(':password',  $hash,  PDO::PARAM_STR );

    		$stmh->bindValue(':last_name',  $_POST['last_name'],  PDO::PARAM_STR );
    		$stmh->bindValue(':first_name',  $_POST['first_name'],  PDO::PARAM_STR );

        	$stmh->execute();
        	while ($row = $stmh->fetch(PDO::FETCH_ASSOC)) {
            	foreach( $row as $key => $value){
                	$userdata[$key] = $value;
            	}
        	}
    	} catch (PDOException $Exception) {
        	print "エラー：" . $Exception->getMessage();
    	}
	$smarty->assign("title", "ゲストページ");
	$smarty->assign("type", "authenticate");
	$smarty->assign("message", "登録完了");
	$file = 'main_login.tpl';
    } else {
    	$smarty->assign("message", "登録できませんでした");
    }

}

if (!empty($_POST['type']) &&  $_POST['type'] == 'registration' ) {
	$smarty->assign("title", "新規登録");
	$file = 'main_regist.tpl';
    } else {
      // 何もしません
    }




$smarty->display($file);
?>
