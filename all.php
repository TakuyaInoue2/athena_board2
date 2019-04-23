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

   <h5 >投稿一覧</h5>
    <ul class="nav justify-content-end ">
  <li class="nav-item">
    <a class="nav-link active text-dark" href="index.php">会員登録</a>
  </li>
  <li class="nav-item">
    <a class="nav-link text-dark" href="all.php">掲示板</a>
  </li>
  <li class="nav-item">
    <a class="btn btn-outline-primary" href="comment.php">ログイン</a>
  </li>
    </ul>
  </div>
  </header>


<?php
   $mysqli = new mysqli( "localhost","root","root","keijiban");

$sql = 'SELECT * FROM comment';
$res = $mysqli->query($sql);
$arrayData = $res->fetch_all(MYSQLI_ASSOC);
 ?>

<br>
<div class="container">

<tr　>
    <th>ID</th>
    <th>ユーザーネーム</th>
    <th>コメント</th>
</tr>
<tr>

<div>

<?php
for($i = 0; $i < count($arrayData); $i++) { ?>
<br>
<tr>
    <td><?php echo $arrayData[$i]['id']; ?></td>
    <td><?php echo $arrayData[$i]['username']; ?></td>
    <td><?php echo $arrayData[$i]['comment']; ?></td>
</tr>


<?php } ?>