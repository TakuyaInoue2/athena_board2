<!doctype html>
<html lang="ja">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>てりー掲示板</title>

  </head>
  <body>
  <header class="container">

<div class="flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">

   <h5 >掲示板サイト</h5>
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

<div class="container">

          <form method="post">
        <div class="form-group">
          <label for="form-mail">メールアドレス</label>
          <input type="mail" class="form-control" name="email" placeholder="example@-----">
        </div>
        <div class="form-group">
          <label for="exampleInputComment">パスワード</label>
          <input type="password" class="form-control" name="password" placeholder="8文字以上16文字以内">
        </div>
        <button type="submit" class="btn btn-primary">新規登録</button>
      </form>

</div>



    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>


<?php

$link= mysqli_connect("localhost","root","root","keijiban");

date_default_timezone_set('Asia/Tokyo');



if(mysqli_connect_error()){

  die( "errorはありません");
}

if(array_key_exists('email',$_POST) OR array_key_exists('password',$_POST)){

  // print_r($_POST);

  if($_POST['email'] == ''){

    ?>
    <div class="alert alert-danger" role="alert">
    <?php   echo "Eメールアドレスを入力してください"; ?>
  </div>
  
  <?php
   
  }elseif($_POST['password'] == ''){
    ?>
    <div class="alert alert-danger" role="alert">
    <?php   echo "パスワードを入力してください"; ?>
  </div>
  
  <?php
  } else{

    $query = "SELECT `id` FROM `keijiban` WHERE email='".mysqli_real_escape_string($link,$_POST['email'])."'";
    $result= mysqli_query($link,$query);

    if(mysqli_num_rows($result)  > 0){

      ?>
      <div class="alert alert-danger" role="alert">
      <?php  echo "すでにそのメールアドレスは使用されています。"; ?>
    </div>

    <?php
  }else{

    $query = "SET GLOBAL sql_mode=NO_ENGINE_SUBSTITUTION";

    mysqli_query($link,$query);
$query="INSERT INTO `keijiban`(`email`,`password`) VALUES ('".mysqli_real_escape_string($link,$_POST['email'])."','".mysqli_real_escape_string($link,$_POST['password'])."')";
if(mysqli_query($link,$query)){

  ?>
  <div class="alert alert-danger" role="alert">
  <?php  echo "登録されました"; ?>
</div>

<?php

}else{

  ?>
  <div class="alert alert-danger" role="alert">
  <?php  echo "登録に失敗しました！"; ?>
</div>

<?php

}

  }


  }

}

// $query="SELECT * FROM keijiban  WHERE name = ' ".mysqli_real_escape_string($link,$name)."'";


?>
