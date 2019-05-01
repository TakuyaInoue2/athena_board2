
<?php

$link= mysqli_connect("localhost","root","root","keijiban");

date_default_timezone_set('Asia/Tokyo');

if( empty($_SESSION['admin_login']) || $_SESSION['admin_login'] !== true ) {

	// ログインページへリダイレクト
	header("Location: ./admin.php");
}

                

if( !empty($_GET['comment_id'])&& empty($_POST['comment_id']) ) {

    $comment_id = (int)htmlspecialchars($_GET['comment_id'], ENT_QUOTES);
	
	// データベースに接続
	$mysqli = new mysqli( "localhost","root","root","keijiban");
    
    
    	// データベースに接続
	$mysqli = new mysqli( DB_HOST, DB_USER, DB_PASS, DB_NAME);
	
	// 接続エラーの確認
	if( $mysqli->connect_errno ) {
		$error_message[] = 'データベースの接続に失敗しました。 エラー番号 ' . $mysqli->connect_errno . ' : ' . $mysqli->connect_error;
	} else {
		$sql = "DELETE FROM message WHERE id = $comment_id";
		$res = $mysqli->query($sql);
	}
	
	$mysqli->close();
	
	// 更新に成功したら一覧に戻る
	if( $res ) {
		header("Location: ./admin.php");
	}
	

}


?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>てりー掲示板 管理ページ（投稿の削除）</title>
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

.text-confirm {
	margin-bottom: 20px;
	font-size: 86%;
	line-height: 1.6em;
}

</style>
</head>
<body>
<h1>てりー掲示板　管理ページ（投稿の削除）</h1>
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
          <input type="username" class="form-control" name="username" placeholder="てりー"　value="<?php if( !empty($arrayData['username']) ){ echo $arrayData['username']; } ?>"disabled>
        </div>
        <div class="form-group">
          <label for="exampleInputComment">コメント</label>
          <input type="comment" class="form-control" name="comment" placeholder="自由に投稿！" 　disabled　value="<?php if( !empty($arrayData['comment']) ){ echo $arrayData['comment']; } ?>">
        </div>
        <a class="btn_cancel" href="admin.php">キャンセル</a>
        <button type="submit" class="btn btn-primary">削除</button>
        <input type="hidden" name="comment_id" value="<?php echo $arrayData['id']; ?>">
      </form>

</div>
</body>
</html>