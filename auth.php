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
  //MemberControllerクラスの読み込み
  $mc = new MemberController;
  //MemberModelクラスの読み込み
  $mm = new MemberModel;

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
      $smarty->assign("title", "マイページ");
      $smarty->assign("message", "ログインしました");
      //正式名称の処理
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

      //商品の正式名称をDBからもってきてjsonへ返還後、main.jsのtypedで処理させる
      try{
        $sql= "SELECT * FROM item";
        $stmh = $pdo->query($sql);
        $stmh->execute();

        $i = 0;
        $data = array();
        while ($row = $stmh->fetch(PDO::FETCH_ASSOC)) {
          foreach ($row as $key => $value)
          $data[$i][$key] = $value;
          $data[$i]['formalName'] = htmlspecialchars($data[$i]['formalName']);
          $code = $data[$i]['code'];
          $i++;
        }
        $fnList = array_column($data , 'formalName');
        // $smarty->assign('data', $fnList);
        $jsone=json_encode($fnList);
        ?>
        <script type="text/javascript">
          var fnList=JSON.parse('<?php echo $jsone; ?>');//jsonをparseしてJavaScriptの変数に代入
        </script>
        <?php
        //売れている商品を検索する
        $limit = 5; //表示する商品の数
        $sql= "SELECT item_code,COUNT(item_code) AS count_item FROM orders GROUP BY item_code ORDER BY count_item DESC LIMIT :lim";
        $stmh = $pdo->prepare($sql);
        $stmh->bindValue(':lim', $limit, PDO::PARAM_INT );
        $stmh->execute();
        $data = array();
        $i = 0;
        while ($row = $stmh->fetch(PDO::FETCH_ASSOC)) {
          foreach ($row as $key => $value)
          $data[$i][$key] = $value;
          $count_item[$i] = $data[$i]['count_item'];
          $item_code[$i] = $data[$i]['item_code'];
          $i++;
        }
        //最も売れている商品を100とした場合の以降商品の売れ筋パーセンテージを計算
        $i = 0;
        $per = array();
        $counter = count($count_item);
        $max_popularity = $count_item[0];
        while($i < $counter){
          $per[$i] = round((($count_item[$i] / $max_popularity) * 100),2);
          $i++;
        }
        //itemテーブルへアクセスしてnameを取得
        $data2 = array();
        $i = 0;
        while($i < $counter){
          $sql= "SELECT * FROM item WHERE code = ($item_code[$i])";
          $stmh = $pdo->prepare($sql);
          $stmh->execute();
          $data2[$i] = $stmh->fetch(PDO::FETCH_ASSOC);
          $data2[$i][$key] = $value;
          $data2[$i]['name'] = htmlspecialchars($data2[$i]['name']);
          //data2へperの値を結合
          $data2[$i]['num'] = $count_item[$i];
          $data2[$i]['per'] = $per[$i];
          $i++;
        }
        //売上データの受け渡し
        $smarty->assign("data2", $data2);
      }catch(PDOException $Exception) {
        die('エラー :' . $Exception->getMessage());
      }
    	$file = 'auth.tpl';
      if (empty($SESSION['id'])){
    		$_SESSION['id']=$_POST['username'];
  		}
    } else {
    	$smarty->assign("message", "IDかパスワードが間違っています");
      $smarty->assign("title", "ゲストページ");
    	$smarty->assign("type", "authenticate");
    	$file = 'login.tpl';
    }
  }else if (!empty($_POST['type']) &&  $_POST['type'] == 'delete_member' ) {  //退会処理
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
    // ユーザ削除
    $file = 'delete_member.tpl';
    // データベースからユーザ情報を削除する処理を挿入
    if(isset($_POST['back'])){
      $smarty->assign("message", "いらっしゃいませ");
      $smarty->assign("title", "マイページ");
      $file = 'auth.tpl';

      //商品の正式名称をDBからもってきてjsonへ返還後、main.jsのtypedで処理させる
      try{
        $sql= "SELECT * FROM item";
        $stmh = $pdo->query($sql);
        $stmh->execute();

        $i = 0;
        $data = array();
        while ($row = $stmh->fetch(PDO::FETCH_ASSOC)) {
          foreach ($row as $key => $value)
          $data[$i][$key] = $value;
          $data[$i]['formalName'] = htmlspecialchars($data[$i]['formalName']);
          $code = $data[$i]['code'];
          $i++;
        }
        $fnList = array_column($data , 'formalName');
        $jsone=json_encode($fnList);
        ?>
        <script type="text/javascript">
          var fnList=JSON.parse('<?php echo $jsone; ?>');//jsonをparseしてJavaScriptの変数に代入
        </script>
        <?php
        //売れている商品を検索する
        $limit = 5;
        $sql= "SELECT item_code,COUNT(item_code) AS count_item FROM orders GROUP BY item_code ORDER BY count_item DESC LIMIT :lim";
        $stmh = $pdo->prepare($sql);
        $stmh->bindValue(':lim', $limit, PDO::PARAM_INT );
        $stmh->execute();
        $data = array();
        $i = 0;
        while ($row = $stmh->fetch(PDO::FETCH_ASSOC)) {
          foreach ($row as $key => $value)
          $data[$i][$key] = $value;
          $count_item[$i] = $data[$i]['count_item'];
          $item_code[$i] = $data[$i]['item_code'];
          $i++;
        }
        //最も売れている商品を100とした場合の以降商品の売れ筋パーセンテージを計算
        $i = 0;
        $per = array();
        $counter = count($count_item);
        $max_popularity = $count_item[0];
        while($i < $counter){
          $per[$i] = round((($count_item[$i] / $max_popularity) * 100),2);
          $i++;
        }
        //itemテーブルへアクセスしてnameを取得
        $data2 = array();
        $i = 0;
        while($i < $counter){
          $sql= "SELECT * FROM item WHERE code = ($item_code[$i])";
          $stmh = $pdo->prepare($sql);
          $stmh->execute();
          $data2[$i] = $stmh->fetch(PDO::FETCH_ASSOC);
          $data2[$i][$key] = $value;
          $data2[$i]['name'] = htmlspecialchars($data2[$i]['name']);
          //data2へperの値を結合
          $data2[$i]['num'] = $count_item[$i];
          $data2[$i]['per'] = $per[$i];

          $i++;
        }
        //売上データの受け渡し
        $smarty->assign("data2", $data2);
      }catch(PDOException $Exception) {
        die('エラー :' . $Exception->getMessage());
      }
    }
    if(isset($_POST['delete'])){
      //削除処理
      $sql = "DELETE FROM member WHERE username = :username";
      $stmh = $pdo->prepare($sql);
      $stmh->bindValue(':username', $_SESSION['id'], PDO::PARAM_STR);
      $stmh->execute();
      $auth->logout();
    }
  }else if ((!empty($_POST['type']) &&  $_POST['type'] == 'favorite') || !empty($_POST['search_all'])) {  //欲しいものリスト処理
    // 欲しいものリスト一覧取得
    $file = 'favorite_list.tpl';
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

    $codedata = [];
    $cdata = array();
    $i = 0;
    $sql = "SELECT code FROM favorite WHERE username = :username";
    $stmh = $pdo->prepare($sql);
    $stmh->bindValue(':username', $_SESSION['id'], PDO::PARAM_STR);
    $stmh->execute();
    $codedata = array();
    while ($row = $stmh->fetch(PDO::FETCH_ASSOC)) {
  		foreach ($row as $key => $value)
  		$codedata[$i][$key] = $value;
  		$codedata[$i]['code'] = htmlspecialchars($codedata[$i]['code']);
      $cdata = $codedata[$i]['code'];
  		$i++;
  	}
    $cdata = array_column( $codedata, "code" ) ;
    $cdata2 = implode(",",$cdata);
    $i = 0;
    $data2 = [];
    while($i < count($cdata)){
      $sql= "SELECT * FROM item WHERE code = ($cdata[$i])";
      $stmh = $pdo->prepare($sql);
      $stmh->execute();
      $data2[$i] = $stmh->fetch(PDO::FETCH_ASSOC);
      $data2[$i][$key] = $value;
      $data2[$i]['name'] = htmlspecialchars($data2[$i]['name']);
      $data2[$i]['comment'] = htmlspecialchars($data2[$i]['comment']);
      $data2[$i]['code'] = $cdata[$i];
      $code = $data2[$i]['code'];
      if (file_exists("$img_dir/$code.jpg")){
        $data2[$i]['file_exists'] = TRUE;
      }else{
        $data2[$i]['file_exists'] = FALSE;
      }
      $i++;
    }
    $smarty->assign('img_dir', $img_dir);
    $smarty->assign('data', $data2);
  }else if ((!empty($_POST['type']) &&  $_POST['type'] == 'shopping') || !empty($_POST['search_all'])) {
    // 商品選択画面
    $file = 'main_shopping.tpl';
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
  	$stmh = $pdo->prepare($sql);
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
    $search_message = '検索したい商品名を入力してください';
    $count = 0;
    if (!empty($_POST['search_key'])) {
      $search_key = '%' . $_POST['search_key'] . '%' ;
      $sql= "SELECT * FROM item WHERE name like :name";
      $stmh = $pdo->prepare($sql);
      $stmh->bindValue(':name', $search_key, PDO::PARAM_STR);
      $stmh->execute();
      $count = $stmh->rowCount();
      if($count <= 0){
        $search_message = '検索結果がありませんでした';
      }else{
        $search_message = '検索結果は'. $count . '件ありました';
      }
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
    }
    $smarty->assign('count', $search_message);
    $smarty->assign('img_dir', $img_dir);
  	$smarty->assign('data', $data);
  }else if (!empty($_POST['type']) &&  $_POST['type'] == 'mypage' ) {
    // マイページ画面へ移動処理
    $smarty->assign("title", "マイページ");
    $smarty->assign("message", "ようこそ");
  }else if (!empty($_POST['type']) &&  $_POST['type'] == 'product' ) {
    //商品詳細画面
    $smarty->assign("title", "商品詳細とおったよ");
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
    $code = $_POST['code'];
    $sql= "SELECT * FROM item WHERE code = :code";
    $stmh = $pdo->prepare($sql);
    $stmh->bindValue(':code', $code, PDO::PARAM_INT);
    $stmh->execute();
    $row = $stmh->fetch(PDO::FETCH_ASSOC);
    $itemN = $row['name'];
    $itemP = $row['price'];
    $itemC = $row['comment'];
    (string)$itemU = $row['url'];
    $itemFN = $row['formalName'];
    (string)$piccode = $code;
    $picfile = [];
    if (file_exists("$img_dir/$code.jpg")){
  		$picfile['file_exists'] = TRUE;
  	}else{
  		$picfile['file_exists'] = FALSE;
  	}
    $smarty->assign('img_dir', $img_dir);
    $smarty->assign('itemN', $itemN);
    $smarty->assign('itemP', $itemP);
    $smarty->assign('itemC', $itemC);
    $smarty->assign('itemU', $itemU);
    $smarty->assign('itemFN', $itemFN);
    $smarty->assign('item_code', $code);
    $smarty->assign('piccode', $piccode);
    $smarty->assign('picfile', $picfile);
    if (isset($_POST['favadd'])){
      try{
        $pdo->beginTransaction();
        $sql = "INSERT into favorite (username, code) VALUES (:username, :code)";
        $stmh = $pdo->prepare($sql);
        $stmh->bindValue(':username', $_SESSION['id'], PDO::PARAM_STR );
        $stmh->bindValue(':code', $code, PDO::PARAM_INT );
        $stmh->execute();
        $pdo->commit();
      } catch(PDOException $Exception) {
        $pdo->rollBack();
          die('エラー :' . $Exception->getMessage());
      }
    }
    if (isset($_POST['favdel'])){
      $sql = "DELETE FROM favorite WHERE username = :username AND code = :code";
      $stmh = $pdo->prepare($sql);
      $stmh->bindValue(':username', $_SESSION['id'], PDO::PARAM_STR );
      $stmh->bindValue(':code', $code, PDO::PARAM_INT );
      $stmh->execute();
    }
    try{
      $sql = "SELECT COUNT(code) from favorite where username = :username and code = :code";
      $stmh = $pdo->prepare($sql);
      $stmh->bindValue(':username', $_SESSION['id'], PDO::PARAM_STR );
      $stmh->bindValue(':code', $code, PDO::PARAM_INT );
      $stmh->execute();
      $count_favorite = $stmh->fetch(PDO::FETCH_ASSOC);
      if($count_favorite['COUNT(code)'] > 0){
        $fav_count = 1;
        ?>
        <script type="text/javascript">
        var fav_count = JSON.parse('<?php echo $fav_count; ?>');//jsonをparseしてJavaScriptの変数に代入
        </script>
        <?php
      }else if($count_favorite['COUNT(code)'] == 0){
        $fav_count = 0;
        ?>
        <script type="text/javascript">
        var fav_count = JSON.parse('<?php echo $fav_count; ?>');//jsonをparseしてJavaScriptの変数に代入
        </script>
        <?php
      }
    } catch(PDOException $Exception) {
      die('エラー :' . $Exception->getMessage());
    }
    $file = 'product.tpl';
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
    //ユーザーデータ検索
    $username = $_SESSION['id'];
    $userdata = [];
    try {
      $sql= "SELECT * FROM member WHERE username = :username ";
      $stmh = $pdo->prepare($sql);
      $stmh->bindValue(':username', $username, PDO::PARAM_STR );
      $stmh->execute();
      $row = $stmh->fetch(PDO::FETCH_ASSOC);
      $address = $row['address'];
      $smarty->assign('address', $address);
    } catch (PDOException $Exception) {
        print "エラー：" . $Exception->getMessage();
    }
    if (!empty($_POST['code']) && $_POST['unit'] > 0) {
    	$code = $_POST['code'];
  		$sql= "SELECT * FROM item WHERE code = :code";
  		$stmh = $pdo->prepare($sql);
  		$stmh->bindValue(':code', $code, PDO::PARAM_INT);
  		$stmh->execute();
    	$row = $stmh->fetch(PDO::FETCH_ASSOC);
    	try{
    		$pdo->beginTransaction();
    		$sql = "INSERT into orders (user_name, item_code, item_name, price, status, unit) VALUES (:user_name, :item_code, :item_name, :price, :status, :unit)";
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
	  if(!empty($_POST['code2']) && $_POST['type'] == 'cart'){
      //カートから削除処理
      $smarty->assign("message", "を削除しました");
      $order_id = $_POST['code2'];
      echo $order_id;
      $sql = "DELETE from orders WHERE order_id = :order_id";
      $stmh = $pdo->prepare($sql);
      $stmh->bindValue(':order_id', $order_id, PDO::PARAM_INT);
      $stmh->execute();
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
        $smarty->assign("title", "マイページ");
    	$smarty->assign("message", "お買い上げありがとうございました");
    	$file = 'auth.tpl';

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
      //商品の正式名称をDBからもってきてjsonへ返還後、main.jsのtypedで処理させる
      try{
        $sql= "SELECT * FROM item";
        $stmh = $pdo->query($sql);
        $stmh->execute();
        $i = 0;
        $data = array();
        while ($row = $stmh->fetch(PDO::FETCH_ASSOC)) {
          foreach ($row as $key => $value)
          $data[$i][$key] = $value;
          $data[$i]['formalName'] = htmlspecialchars($data[$i]['formalName']);
          $code = $data[$i]['code'];
          $i++;
        }
        $fnList = array_column($data , 'formalName');
        $jsone=json_encode($fnList);
        ?>
        <script type="text/javascript">
          var fnList=JSON.parse('<?php echo $jsone; ?>');//jsonをparseしてJavaScriptの変数に代入
        </script>
        <?php
        //売れている商品を検索する
        $limit = 5;
        $sql= "SELECT item_code,COUNT(item_code) AS count_item FROM orders GROUP BY item_code ORDER BY count_item DESC LIMIT :lim";
        $stmh = $pdo->prepare($sql);
        $stmh->bindValue(':lim', $limit, PDO::PARAM_INT );
        $stmh->execute();
        $data = array();
        $i = 0;
        while ($row = $stmh->fetch(PDO::FETCH_ASSOC)) {
          foreach ($row as $key => $value)
          $data[$i][$key] = $value;
          $count_item[$i] = $data[$i]['count_item'];
          $item_code[$i] = $data[$i]['item_code'];
          $i++;
        }
        //最も売れている商品を100とした場合の以降商品の売れ筋パーセンテージを計算
        $i = 0;
        $per = array();
        $counter = count($count_item);
        $max_popularity = $count_item[0];
        while($i < $counter){
          $per[$i] = round((($count_item[$i] / $max_popularity) * 100),2);
          $i++;
        }
        //itemテーブルへアクセスしてnameを取得
        $data2 = array();
        $i = 0;
        while($i < $counter){
          $sql= "SELECT * FROM item WHERE code = ($item_code[$i])";
          $stmh = $pdo->prepare($sql);
          $stmh->execute();
          $data2[$i] = $stmh->fetch(PDO::FETCH_ASSOC);
          $data2[$i][$key] = $value;
          $data2[$i]['name'] = htmlspecialchars($data2[$i]['name']);
          //data2へperの値を結合
          $data2[$i]['num'] = $count_item[$i];
          $data2[$i]['per'] = $per[$i];
          $i++;
        }
        //売上データの受け渡し
        $smarty->assign("data2", $data2);
      }catch(PDOException $Exception) {
        die('エラー :' . $Exception->getMessage());
      }
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
  }else if( !empty($_GET['type']) && $_GET['type'] == 'logout'){
     $auth->logout();
  }
  if($auth->check()){
    $db_user = "user1707";	// ユーザー名
    $db_pass = "password";	// パスワード
    $db_host = "localhost";	// ホスト名
    $db_name = "db1707";	// データベース名
    $db_type = "mysql";	// データベースの種類

    $dsn = "$db_type:host=$db_host;dbname=$db_name;charset=utf8";

    $smarty->assign("aaa", "DB接続");
    try {
      $pdo = new PDO($dsn, $db_user,$db_pass);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    } catch(PDOException $Exception) {
      die('エラー :' . $Exception->getMessage());
    }
    // 認証済み
    if (empty($file)){
    	$smarty->assign("title", "マイページ");
    	$smarty->assign("message", "いらっしゃいませ");
      try{
        //売れている商品を検索する
        $limit = 5;
        $sql= "SELECT item_code,COUNT(item_code) AS count_item FROM orders GROUP BY item_code ORDER BY count_item DESC LIMIT :lim";
        $stmh = $pdo->prepare($sql);
        $stmh->bindValue(':lim', $limit, PDO::PARAM_INT );
        $stmh->execute();
        $data = array();
        $i = 0;
        while ($row = $stmh->fetch(PDO::FETCH_ASSOC)) {
          foreach ($row as $key => $value)
          $data[$i][$key] = $value;
          $count_item[$i] = $data[$i]['count_item'];
          $item_code[$i] = $data[$i]['item_code'];
          $i++;
        }
        //最も売れている商品を100とした場合の以降商品の売れ筋パーセンテージを計算
        $i = 0;
        $per = array();
        $counter = count($count_item);
        $max_popularity = $count_item[0];
        while($i < $counter){
          $per[$i] = round((($count_item[$i] / $max_popularity) * 100),2);
          $i++;
        }
        //itemテーブルへアクセスしてnameを取得
        $data2 = array();
        $i = 0;
        while($i < $counter){
          $sql= "SELECT * FROM item WHERE code = ($item_code[$i])";
          $stmh = $pdo->prepare($sql);
          $stmh->execute();
          $data2[$i] = $stmh->fetch(PDO::FETCH_ASSOC);
          $data2[$i][$key] = $value;
          $data2[$i]['name'] = htmlspecialchars($data2[$i]['name']);
          //data2へperの値を結合
          $data2[$i]['num'] = $count_item[$i];
          $data2[$i]['per'] = $per[$i];
          $i++;
        }
        //売上データの受け渡し
        $smarty->assign("data2", $data2);
        //商品の正式名称をDBからもってきてjsonへ返還後、main.jsのtypedで処理させる
        $sql= "SELECT * FROM item";
        $stmh = $pdo->query($sql);
        $stmh->execute();
        $i = 0;
        $data = array();
        while ($row = $stmh->fetch(PDO::FETCH_ASSOC)) {
          foreach ($row as $key => $value)
          $data[$i][$key] = $value;
          $data[$i]['formalName'] = htmlspecialchars($data[$i]['formalName']);
          $code = $data[$i]['code'];
          $i++;
        }
        $fnList = array_column($data , 'formalName');
        $smarty->assign('data', $fnList);
        $jsone=json_encode($fnList);
        ?>
        <script type="text/javascript">
        var fnList=JSON.parse('<?php echo $jsone; ?>');//jsonをparseしてJavaScriptの変数に代入
        </script>
        <?php
        $file = 'auth.tpl';
      }catch(PDOException $Exception) {
        die('エラー :' . $Exception->getMessage());
      }
      if (!empty($_POST['type']) &&  $_POST['type'] == 'change_password' ) {
        //password変更
        $smarty->assign('title', 'パスワード変更');
        $smarty->assign('message', 'すべてに入力してください');
        $file = 'member_update.tpl';
        //処理
        //DB接続
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

        $userdata = [];
        try {
          $sql= "SELECT * FROM member WHERE username = :username ";
          $stmh = $pdo->prepare($sql);
          $stmh->bindValue(':username',  $_SESSION['id'],  PDO::PARAM_STR );
          $stmh->execute();
          while ($row = $stmh->fetch(PDO::FETCH_ASSOC)) {
            foreach( $row as $key => $value){
                $userdata[$key] = $value;
            }
          }
        } catch (PDOException $Exception) {
          print "エラー：" . $Exception->getMessage();
        }
      if(isset($_POST['old_pass'])){

        if(!empty($userdata['password']) && $auth->check_password($_POST['old_pass'], $userdata['password'])){
          //パスワード変更処理
          $sql= "SELECT * FROM member WHERE username = :username AND password = :password";
          $stmh = $pdo->prepare($sql);
          $stmh->bindValue(':password',  $auth->get_hashed_password($_POST['old_pass']),  PDO::PARAM_STR );
          $stmh->bindValue(':username',  $_SESSION['id'],  PDO::PARAM_STR );
          $stmh->execute();

          try{
            $new_pass = $auth->get_hashed_password($_POST['new_pass']);
            $pdo->beginTransaction();
            $sql = "UPDATE member SET password = :password WHERE username = :username";
            $stmh = $pdo->prepare($sql);
            $stmh->bindValue(':username', $_SESSION['id'], PDO::PARAM_STR );
            $stmh->bindValue(':password', $new_pass, PDO::PARAM_STR );
            $stmh->execute();
            $pdo->commit();

            $smarty->assign("title", "マイページ");
            $smarty->assign("message", "パスワードが変更されました");
            $file = 'auth.tpl';

          } catch(PDOException $Exception) {
            $pdo->rollBack();
            die('エラー :' . $Exception->getMessage());
          }
        }
      }

      if(isset($_POST['back'])){
        $smarty->assign("message", "いらっしゃいませ");
        $smarty->assign("title", "マイページ");
        $file = 'auth.tpl';

        //商品の正式名称をDBからもってきてjsonへ返還後、main.jsのtypedで処理させる
        try{
          $sql= "SELECT * FROM item";
          $stmh = $pdo->query($sql);
          $stmh->execute();

          $i = 0;
          $data = array();
          while ($row = $stmh->fetch(PDO::FETCH_ASSOC)) {
            foreach ($row as $key => $value)
            $data[$i][$key] = $value;
            $data[$i]['formalName'] = htmlspecialchars($data[$i]['formalName']);
            $code = $data[$i]['code'];
            $i++;
          }
          $fnList = array_column($data , 'formalName');
          $jsone=json_encode($fnList);
          ?>
          <script type="text/javascript">
            var fnList=JSON.parse('<?php echo $jsone; ?>');//jsonをparseしてJavaScriptの変数に代入
          </script>
          <?php
          //売れている商品を検索する
          $limit = 5;
          $sql= "SELECT item_code,COUNT(item_code) AS count_item FROM orders GROUP BY item_code ORDER BY count_item DESC LIMIT :lim";
          $stmh = $pdo->prepare($sql);
          $stmh->bindValue(':lim', $limit, PDO::PARAM_INT );
          $stmh->execute();
          $data = array();
          $i = 0;
          while ($row = $stmh->fetch(PDO::FETCH_ASSOC)) {
            foreach ($row as $key => $value)
            $data[$i][$key] = $value;
            $count_item[$i] = $data[$i]['count_item'];
            $item_code[$i] = $data[$i]['item_code'];
            $i++;
          }
          //最も売れている商品を100とした場合の以降商品の売れ筋パーセンテージを計算
          $i = 0;
          $per = array();
          $counter = count($count_item);
          $max_popularity = $count_item[0];
          while($i < $counter){
            $per[$i] = round((($count_item[$i] / $max_popularity) * 100),2);
            $i++;
          }
          //itemテーブルへアクセスしてnameを取得
          $data2 = array();
          $i = 0;
          while($i < $counter){
            $sql= "SELECT * FROM item WHERE code = ($item_code[$i])";
            $stmh = $pdo->prepare($sql);
            $stmh->execute();
            $data2[$i] = $stmh->fetch(PDO::FETCH_ASSOC);
            $data2[$i][$key] = $value;
            $data2[$i]['name'] = htmlspecialchars($data2[$i]['name']);
            //data2へperの値を結合
            $data2[$i]['num'] = $count_item[$i];
            $data2[$i]['per'] = $per[$i];
            $i++;
          }
          //売上データの受け渡し
          $smarty->assign("data2", $data2);
        }catch(PDOException $Exception) {
          die('エラー :' . $Exception->getMessage());
        }
      }
      }
    }
  }else{
      // 未認証
      $smarty->assign("title", "ゲストページ");
      $smarty->assign("type", "authenticate");
      $file = 'login.tpl';
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
      if(!empty($_POST['mail_address']) && !empty($_POST['password']) && !empty($_POST['last_name']) && !empty($_POST['first_name']) && !empty($_POST['address'])){
      	$userdata = [];
      	try {
      		$sql= "INSERT INTO member (username, password, last_name, first_name, address) values(:mail_address, :password, :last_name, :first_name, :address)";
      		$stmh = $pdo->prepare($sql);
      		$stmh->bindValue(':mail_address',  $_POST['mail_address'],  PDO::PARAM_STR );
      		$stmh->bindValue(':password',  $auth->get_hashed_password($_POST['password']),  PDO::PARAM_STR );
      		$stmh->bindValue(':last_name',  $_POST['last_name'],  PDO::PARAM_STR );
      		$stmh->bindValue(':first_name',  $_POST['first_name'],  PDO::PARAM_STR );
      		$stmh->bindValue(':address',  $_POST['address'],  PDO::PARAM_STR );
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
      	$file = 'login.tpl';
      } else {
      	$smarty->assign("message", "登録できませんでした");
      }
  }
  if (!empty($_POST['type']) &&  $_POST['type'] == 'registration' ) {
  	$smarty->assign("title", "新規登録");
  	$file = 'regist.tpl';
  } else {
    // 何もしません
  }
  $smarty->display($file);
?>
