<?php
session_start();
require_once 'model.php';

if ($_SESSION['account']) {
    $db = connect();
    $sql = 'SELECT * FROM `users` WHERE `student_num` = ?;';
    $sth = $db->prepare($sql);
    $sth->execute(array($_SESSION['account']));
    $data = $sth->fetch(PDO::FETCH_ASSOC);

    $facebook_url = $data['facebook'];
    $split = explode('/', $facebook_url);
    $facebook_name = $split[3];
    $facebook_picture = "https://graph.facebook.com/$facebook_name/picture?type=large";

} else {
    header('Location: http://sns.ikasamaworks.net/login.php');
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
          <a class="brand" href="http://sns.ikasamaworks.net">inCollege(β)</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li class="active"><a href="/mypage.php">Home</a></li>
              <li><a href="/about">About</a></li>
              <li><a href="/contact">Contact</a></li>
              <li><a href="/logout.php">Logout</a></li>
              <li><a href="http://ikaasam.com">created by ikasama</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <div class="container">
        <img src="<?php echo $facebook_picture ?>"></a><br>
        <a href="<?php echo $data['facebook'] ?>"><img src="img/facebook-icon.png" width='70' height='70'></a>
        <a href="<?php echo $data['twitter'] ?>"><img src="img/twitter-icon.png" width='70' height='70'></a><br><br>
        <a href="/myfav.php">会いたいリスト</a><br><br>
        <a href="/search.php" class="btn">友達を探す</a>

    </div>

</body>
</html>

