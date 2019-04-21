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
    <a class="nav-link text-dark" href="comment.php">掲示板</a>
  </li>
  <li class="nav-item">
    <a class="btn btn-outline-primary" href="comment.php">ログイン</a>
  </li>
    </ul>
  </div>
  </header>

<div class="container">

          <form method="post">
        <div class="form-group">
          <label for="form-mail">ユーザー名</label>
          <input type="username" class="form-control" name="username" placeholder="てりー">
        </div>
        <div class="form-group">
          <label for="exampleInputComment">コメント</label>
          <input type="comment" class="form-control" name="comment" placeholder="自由に投稿！">
        </div>
        <button type="submit" class="btn btn-primary">投稿</button>
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





if(mysqli_connect_error()){

  die( "errorはありません");
}

if(array_key_exists('username',$_POST) OR array_key_exists('comment',$_POST)){

  // print_r($_POST);

  if($_POST['username'] == ''){

    echo "ユーザーネームを入力してください";
  }elseif($_POST['comment'] == ''){

    echo "コメントを入力してください";
  } else{

    $query = "SELECT `id` FROM `comment` WHERE username='".mysqli_real_escape_string($link,$_POST['comment'])."'";
    $result= mysqli_query($link,$query);

    if(mysqli_num_rows($result)  > 0){


    echo "";
  }else{

    $query = "SET GLOBAL sql_mode=NO_ENGINE_SUBSTITUTION";

    mysqli_query($link,$query);
$query="INSERT INTO `comment`(`username`,`comment`) VALUES ('".mysqli_real_escape_string($link,$_POST['username'])."','".mysqli_real_escape_string($link,$_POST['comment'])."')";
if(mysqli_query($link,$query)){

// echo "登録されました";
}else{

// echo "登録に失敗しました！";
}

  }


  }

}

// $query="SELECT * FROM keijiban  WHERE name = ' ".mysqli_real_escape_string($link,$name)."'";


?>