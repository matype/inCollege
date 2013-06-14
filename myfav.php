<?php

session_start();
require_once 'model.php';

$db = connect();
$_sql = 'SELECT `id` FROM `users` WHERE `student_num` = ?';
$_sth = $db->prepare($_sql);
$_sth->execute(array($_SESSION['account']));
$my_id = $_sth->fetch(PDO::FETCH_ASSOC);
$my_id = $my_id['id'];

$sql = 'SELECT * FROM `favorites` WHERE `from` = ?;';
$sth = $db->prepare($sql);
$sth->execute(array($my_id));
$list = $sth->fetchall();
//var_dump($list);
$fav_list = array();
//var_dump(count($list));
if (count($list) > 1) {
    foreach ($list as $li) {
        $target_id = $li['to'];
        //var_dump($target_id);
        $sql = 'SELECT student_num, name, facebook FROM `users` WHERE `id` = ?';
        $sth = $db->prepare($sql);
        $sth->execute(array($target_id));
        $fav_list[] = $sth->fetch(PDO::FETCH_ASSOC);

    }
} elseif (count($list) === 1) {
    $target_id = $list['to'];
    $sql = 'SELECT student_num, name, facebook FROM `users` WHERE `id` = ?';
    $sth = $db->prepare($sql);
    $sth->execute(array($target_id));
    $fav_list[] = $sth->fetch(PDO::FETCH_ASSOC);
} else {
    echo "<p>ひとりも登録されてません。</p>";
    exit;
}

/*

echo "<pre>";
var_dump($fav_list);
echo "</pre>";exit;

 */
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
        <h3>会いたい人リスト</h3>
        <ul>
            <?php foreach ($fav_list as $fl) { ?>
            <li><a href="/user.php?account=<?php echo $fl['student_num']; ?>"><?php echo $fl['name']; ?></a></li>
            <?php } ?>
        </ul>
    </div>

</body>
</html>



