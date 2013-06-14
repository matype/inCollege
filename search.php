<?php

session_start();
require_once 'model.php';
$db = connect();
error_reporting(0);
//$res = array();
if ($_POST['sex']) {
    $sex = htmlspecialchars($_POST['sex'], ENT_QUOTES, 'utf-8');
    $sql = 'SELECT `student_num` FROM `users` WHERE `sex` = ?';
    $sth = $db->prepare($sql);
    $sth->execute(array($sex));
    $res = $sth->fetchAll();
    //var_dump($res);
}    
if ($_POST['grade']) {
    $grade = htmlspecialchars($_POST['grade'], ENT_QUOTES, 'utf-8');
    $sql = 'SELECT `student_num` FROM `users` WHERE `grade` = ?';
    $sth = $db->prepare($sql);
    $sth->execute(array($grade));
    $res = $sth->fetchAll();
}    
if ($_POST['department']) {
    $department = htmlspecialchars($_POST['department'], ENT_QUOTES, 'utf-8');
    $sql = 'SELECT `student_num` FROM `users` WHERE `department` = ?';
    $sth = $db->prepare($sql);
    $sth->execute(array($department));
    $res = $sth->fetchAll();
}    
if ($_POST['sex'] && $_POST['grade']) {
    $sex = htmlspecialchars($_POST['sex'], ENT_QUOTES, 'utf-8');
    $grade = htmlspecialchars($_POST['grade'], ENT_QUOTES, 'utf-8');
    $sql = 'SELECT `student_num` FROM `users` WHERE `sex` = ? AND `grade` = ?';
    $sth = $db->prepare($sql);
    $sth->execute(array($sex, $grade));
    $res = $sth->fetchAll();
}    
if ($_POST['sex'] && $_POST['department']) {
    $sex = htmlspecialchars($_POST['sex'], ENT_QUOTES, 'utf-8');
    $department = htmlspecialchars($_POST['department'], ENT_QUOTES, 'utf-8');
    $sql = 'SELECT `student_num` FROM `users` WHERE `sex` = ? AND `department` = ?';
    $sth = $db->prepare($sql);
    $sth->execute(array($sex, $department));
    $res = $sth->fetchAll();
}    
if ($_POST['grade'] && $_POST['department']) {
    $grade = htmlspecialchars($_POST['grade'], ENT_QUOTES, 'utf-8');
    $department = htmlspecialchars($_POST['department'], ENT_QUOTES, 'utf-8');
    $sql = 'SELECT `student_num` FROM `users` WHERE `grade` = ? AND `department` = ?';
    $sth = $db->prepare($sql);
    $sth->execute(array($grade, $department));
    $res = $sth->fetchAll();
}    
if ($_POST['sex'] && $_POST['grade'] && $_POST['department']) {
    $sex = htmlspecialchars($_POST['sex'], ENT_QUOTES, 'utf-8');
    $grade = htmlspecialchars($_POST['grade'], ENT_QUOTES, 'utf-8');
    $department = htmlspecialchars($_POST['department'], ENT_QUOTES, 'utf-8');
    $sql = 'SELECT `student_num` FROM `users` WHERE `sex` = ? AND `grade` = ? AND `department` = ?';
    $sth = $db->prepare($sql);
    $sth->execute(array($sex, $grade, $department));
    $res = $sth->fetchAll();
}    
if (empty($_POST['sex']) && empty($_POST['grade']) && empty($_POST['department'])) {
    $sql = 'SELECT `student_num` FROM `users`;';
    $sth = $db->prepare($sql);
    $sth->execute();
    $res = $sth->fetchAll();
}    
foreach ($res as $r) {
    if ($r['student_num'] == $_SESSION['account']) continue;
    $sql = 'SELECT * FROM `users` WHERE `student_num` = ?';
    $sth = $db->prepare($sql);
    $sth->execute(array($r['student_num']));
    $data[] = $sth->fetchAll();
}

/*
if ($_POST) {
    echo "<pre>";
    var_dump($data);
    echo "</pre>";exit;
}
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
        <h3>会いたい人検索</h3>
        <br>
        <div class="row">
        <div class="span6">
        <form method="post" action="search.php">
            <label>性別</label>
            <select name="sex">
                <option value="">選択して下さい</option>
                <option value="men">男</option>
                <option value="women">女</option>
            </select>
            <label>学年</label>
            <select name="grade">
                <option value="">選択して下さい</option>
                <option value="B1">学部 1年</option>
                <option value="B2">学部 2年</option>
                <option value="B3">学部 3年</option>
                <option value="B4">学部 4年</option>
                <option value="M1">修士 1年</option>
                <option value="M2">修士 2年</option>
                <option value="D1">博士 1年</option>
                <option value="D2">博士 2年</option>
                <option value="D3">博士 3年</option>
            </select>
            <label>学部</label>
            <select name="department">
                <option value="">選択して下さい</option>
                <option value="keizai">経済学部</option>
                <option value="kyouiku">教育学部</option>
                <option value="shisukou">システム工学部</option>
                <option value="kankou">観光学部</option>
            </select>
            <br>
            <br>
            <input type="submit" name="submit" value="検索" class="btn btn-success btn-large">
        </form>
        </div>
        <div class="span6">
        <h4>登録してる人たち</h4>
<?php if (isset($data)) { foreach($data as $d) { ?>
<?php 
    $facebook_url = $d[0]['facebook'];
    $split = explode('/', $facebook_url);
    $facebook_name = $split[3];
    $facebook_picture = "https://graph.facebook.com/$facebook_name/picture";

?>
    <a href="http://sns.ikasamaworks.net/user.php?account=<?php echo $d[0]['student_num'] ?>"><img src="<?php echo $facebook_picture ?>" width="70" height="70"></a>

<?php }} else { ?>
    <li>なし</li>
<?php } ?>
        </div>
        </div>
    </div>

</body>
</html>

