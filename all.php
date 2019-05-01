<!doctype html>
<html lang="ja">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>投稿</title>

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


   $mysqli = new mysqli( "localhost","root","root","keijiban");

   date_default_timezone_set('Asia/Tokyo');
$sql = 'SELECT * FROM comment';
$res = $mysqli->query($sql);
$arrayData = $res->fetch_all(MYSQLI_ASSOC);
 ?>



<?php if( !empty($arrayData) ): ?>
<?php foreach( $arrayData as $value ): ?>
<br>
<article>
<div class="container">
<div class="card">
  <div class="card-body">
   
 
  <?php echo $value['username']; ?>
        <time><?php echo date('Y年m月d日 H:i', strtotime($value['time'])); ?></time>
       
    <p><?php echo nl2br($value['comment']); ?></p>
    
</article>
</article>
</div>
</div>
    
<div>
</div>
<?php endforeach; ?>
<?php endif; ?>