<?php
session_start();
require_once 'model.php';
if (@$_SESSION['account']) {
    $account = $_SESSION['account'];
    header("Location: http://sns.ikasamaworks.net/mypage.php?account=$account");
    exit;
}

if ($_POST) {
    $mail = htmlspecialchars($_POST['mail'], ENT_QUOTES, 'utf-8');
    if ($split = explode('@', $mail)) {
        $student_num = $split[0];
    } else {
        $student_num = $mail;
    }

    //$student_num = $mail;
    $password = htmlspecialchars($_POST['password'], ENT_QUOTES, 'utf-8');
    
    $db = connect();
    $sql = 'SELECT `id` FROM `users` WHERE `student_num` = ? AND `password` = ?;';
    $sth = $db->prepare($sql);
    $sth->execute(array($student_num, $password));
    $result = $sth->fetch(PDO::FETCH_ASSOC);
    if ($result) {
        $_SESSION['account'] = $student_num;
        header("Location: http://sns.ikasamaworks.net/mypage.php");
        exit;
    } else {
        $error_msg = 'メールアドレスもしくはパスワードが違います';
    }
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
            </ul>
          </div>
        </div>
      </div>
    </div>

    <div class="container">
        <h3>ログイン</h3>
        <br>
        <form method="post" action="login.php">
            <label style="color:red;"><?php if (@$error_msg) echo $error_msg; ?></label>
            <label>登録メールアドレス</label>
            <label><small>(@ 以下は省略できます。)</small></label>
            <input type="text" name="mail">
            <label>パスワード</label>
            <input type="password" name="password">
            <br>
            <br>
            <input type="submit" name="submit" value="ログイン" class="btn btn-primary btn-large">
        </form>
    </div>

</body>
</html>
