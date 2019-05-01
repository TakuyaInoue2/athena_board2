
<?php



$comment_id = null;
$mysqli = null;
$sql = null;
$res = null;

$link= mysqli_connect("localhost","root","root","keijiban");

date_default_timezone_set('Asia/Tokyo');


session_start();
	
$_SESSION['admin_login'] = true;


if( empty($_SESSION['admin_login']) || $_SESSION['admin_login'] !== true ) {

	// ログインページへリダイレクト
	header("Location: ./admin.php");
} 

                

if( !empty($_GET['comment_id'])&& empty($_POST['comment_id']) ) {

    $comment_id = (int)htmlspecialchars($_GET['comment_id'], ENT_QUOTES);
	
	// データベースに接続
	$mysqli = new mysqli( "localhost","root","root","keijiban");
	
	// 接続エラーの確認
	if( $mysqli->connect_errno ) {
		$error_message[] = 'データベースの接続に失敗しました。 エラー番号 '.$mysqli->connect_errno.' : '.$mysqli->connect_error;
	} else {
	
		// データの読み込み
		$sql = "SELECT * FROM comment WHERE id = $comment_id";
		$res = $mysqli->query($sql);
		
		if( $res ) {
			$arrayData  = $res->fetch_assoc();
		} else {
		
			// データが読み込めなかったら一覧に戻る
			header("Location: ./admin.php");
		}
		
		$mysqli->close();
	}

} elseif( !empty($_POST['comment_id']) ) {

	$comment_id = (int)htmlspecialchars( $_POST['comment_id'], ENT_QUOTES);
	
	if( empty($_POST['username']) ) {?>
    <div class="container">
  <div class="alert alert-danger" role="alert">
  <?php  $error_message[] = 'ユーザーネームを入力してください。'; ?>
</div>
</div>

		<?php
		
	} else {
        $arrayData ['username'] = htmlspecialchars($_POST['username'], ENT_QUOTES);
        
	}
	
	if( empty($_POST['comment']) ) {?>
        <div class="container">
  <div class="alert alert-danger" role="alert">
  <?php  $error_message[] = 'コメントを入力してください。'; ?>
</div>
</div>
		<?php

	} else {
        $arrayData ['comment'] = htmlspecialchars($_POST['comment'], ENT_QUOTES);
	}

	if( empty($error_message) ) {
	
		// データベースに接続
		$mysqli = new mysqli( "localhost","root","root","keijiban");
		
		// 接続エラーの確認
		if( $mysqli->connect_errno ) {
			$error_message[] = 'データベースの接続に失敗しました。 エラー番号 ' . $mysqli->connect_errno . ' : ' . $mysqli->connect_error;
		} else {
			$sql = "UPDATE comment set username = ' $arrayData[username]', comment= ' $arrayData[comment]' WHERE id =  $comment_id";
			$res = $mysqli->query($sql);
		}
		
		$mysqli->close();
		
		// 更新に成功したら一覧に戻る
		if( $res ) {
			header("Location: ./admin.php");
		}
	}

}


?>

<!doctype html>
<html lang="ja">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>てりー掲示板 管理ページ（投稿の編集）</title>


<style>

.btn_cancel {
	display: inline-block;
	margin-right: 10px;
	padding: 10px 20px;
	color: #555;
	font-size: 86%;
	border-radius: 5px;
	border: 1px solid #999;
}
.btn_cancel:hover {
	color: #999;
	border-color: #999;
	text-decoration: none;
}

</style>
</head>
<body>
<header class="container">

<div class="flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">

<h3><a class="nav-item text-dark" href="all.php">てりー掲示板　管理ページ（投稿の編集）</a></h3>
  
    <ul class="nav justify-content-end ">
  
  <li class="nav-item">
    <a class="nav-link text-dark" href="all.php">掲示板</a>
  </li>
  <li class="nav-item">
    <a class="btn btn-outline-primary" href="admin.php">ログイン</a>
  </li>
    </ul>
  </div>
  </header>


<?php if( !empty($error_message) ): ?>
    <ul class="error_message">
		<?php foreach( $error_message as $value ): ?>
            <li>・<?php echo $value; ?></li>
		<?php endforeach; ?>
    </ul>
<?php endif; ?>
<div class="container">

          <form method="post">
        <div class="form-group">
          <label for="form-mail">ユーザー名</label>
          <input type="username" class="form-control" name="username" placeholder="てりー"　value="<?php if( !empty($arrayData['username']) ){ echo $arrayData['username']; } ?>">
        </div>
        <div class="form-group">
          <label for="exampleInputComment">コメント</label>
          <input type="comment" class="form-control" name="comment" placeholder="自由に投稿！" value="<?php if( !empty($arrayData['comment']) ){ echo $arrayData['comment']; } ?>">
        </div>
        <a class="btn_cancel" href="admin.php">キャンセル</a>
        <button type="submit" class="btn btn-primary">更新</button>
        <input type="hidden" name="comment_id" value="<?php echo $arrayData['id']; ?>">
      </form>

</div>
</body>
</html>