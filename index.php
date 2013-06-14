<?php
session_start();
require_once 'model.php';
if (@$_SESSION['account']) {
    $account = $_SESSION['account'];
    header("Location: http://sns.ikasamaworks.net/mypage.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>inCollege</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap_readable.min.css">
</head>
<body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="/">inCollege(β)</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li class="active"><a href="/">Home</a></li>
              <li><a href="/about">About</a></li>
              <li><a href="/contact">Contact</a></li>
              <li><a href="login.php">Login</a></li>
              <li><a href="http://ikaasam.com">created by ikasama</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <div class="container">
        <div class="jumbotron">
        <h3><b>inCollege</b>で、<br>あなたの大学生活は変化します。</h3>
        <br>
        <form method="post" action="check_mail.php">
            <input type="text" name="mail" style="width:250px;" placeholder="大学のメールアドレス">
            <input type="submit" name="submit" value="登録する" class="btn btn-primary">
        </form>
        </div>
        <p><b>inCollege</b>を使うと以下のようなことができます。</p>
        <ul>
            <li><small>同じ大学に通うまだ知らない学生と知り合う</small></li>
            <li><small>同じ大学の気になるあの子とつながる</small></li>
            <li><small>Facebook、Twitterでつながる</small></li>
            <li><small>同じ学部、学科に友達ができる</small></li>
            <li><small>充実したキャンパスライフをおくる</small></li>
        </ul>
        <br>
        <p><b>inCollege</b>の使い方はあなた次第。</p>
        <p>登録は上のフォームに大学のメールアドレスを入力して始めて下さい。</p>
        <p>さあ、人生で一度きりの大学生活、たくさんの友達を作りましょう。</p>
        <p><b>Be Encouraged!</b>（勇気を出して！）</p>
        <br>
        <br>
    </div>

</body>
</html>
