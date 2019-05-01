<!doctype html>
<html lang="ja">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>ログインページ</title>

  </head>
  <body>
  <header class="container">

<div class="flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">

<h3><a class="nav-item text-dark" href="all.php">てりー掲示板</a></h3>
  
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

 
  <?php
  
define( 'PASSWORD', 'admin');

$comment_id = null;
$mysqli = null;
$sql = null;
$res = null;




if( !empty($_POST['btn-submit']) ) {

	if( !empty($_POST['admin_password']) && $_POST['admin_password'] === PASSWORD ) {
		$_SESSION['admin_login'] = true;
	} else { ?>
		
        <div class="alert alert-danger" role="alert">
  <?php  echo "メールアドレスを入力してください"; ?>
</div>
	<?php }} ?>

<?php
$mysqli = new mysqli( "localhost","root","root","keijiban");

date_default_timezone_set('Asia/Tokyo');
$sql = 'SELECT * FROM comment';
$res = $mysqli->query($sql);
$arrayData = $res->fetch_all(MYSQLI_ASSOC);



?>



<?php if( !empty($_SESSION['admin_login']) && $_SESSION['admin_login'] === true ): ?>

<?php if( !empty($arrayData) ):  ?>

<div class="container">
<br>

<a class="btn btn-outline-primary" href="comment.php">新規投稿</a>

</div>
<?php foreach( $arrayData as $value ):?>
<br>
<article>
<div class="container">
<div class="card">
  <div class="card-body">
   
        <?php echo $value['username']; ?>
        <time><?php echo date('Y年m月d日 H:i', strtotime($value['time'])); ?></time>
        <a href="edit.php?comment_id=<?php echo $value['id']; ?>">編集</a>  <a href="delete.php?comment_id=<?php echo $value['id']; ?>">削除</a>
        
        
       
    <p><?php echo  nl2br($value['comment']); ?></p>
</article>
</div>
</div>
    
<div>
</div>
<?php endforeach; ?>
<?php endif; ?>
<?php else: ?>


<div class="container">

    <form method="post">
        <div class="form-group">
            <label for="form-mail">メールアドレス</label>
            <input type="mail" class="form-control" name="email" placeholder="example@-----">
        </div>
        <div class="form-group">
            <label for="exampleInputComment">パスワード</label>
            <!-- id属性になってしまった。こちらはname属性 -->
            <input type="password" class="form-control" name="admin_password" placeholder="8文字以上16文字以内">
            <!-- <input type="password" class="form-control" id="admin_password" placeholder="8文字以上16文字以内"> -->
        </div>
        <!-- buttonタグではなく、inputタグでないとポストされない -->
        <input type="submit" class="btn btn-primary" name="btn-submit" value="ログイン">
        <!-- <button type="submit" class="btn btn-primary" name="btn-submit">ログイン</button> -->
   
       
        <a class="btn btn-outline-primary" href="index.php">新規登録</a>

    </form>
    </div>







<?php endif; ?>

</body> 
</html>