<?php
require_once 'model.php';
session_start();

if (isset($_GET['sn'])) {
    $_SESSION['student_num'] = htmlspecialchars($_GET['sn'], ENT_QUOTES, 'utf-8');
    $student_num = $_SESSION['student_num'];
    $db = connect();
    $sql = 'SELECT `student_num` FROM `users` WHERE `student_num` = ?;';
    $sth = $db->prepare($sql);
    $sth->execute(array($student_num));
    $result = $sth->fetch(PDO::FETCH_ASSOC);
    if ($result) {
        echo "<p>このメールアドレスからは登録済みです。</p>";
        echo "<p><a href='/'>トップに戻る</a></p>";
        exit;
    }
    header('Location: http://sns.ikasamaworks.net/register.php');
    exit;
}

if ($_POST) {
    $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'utf-8');
    $sex = htmlspecialchars($_POST['sex'], ENT_QUOTES, 'utf-8');
    $grade = htmlspecialchars($_POST['grade'], ENT_QUOTES, 'utf-8');
    $department = htmlspecialchars($_POST['department'], ENT_QUOTES, 'utf-8');
    $facebook = htmlspecialchars($_POST['facebook'], ENT_QUOTES, 'utf-8');
    $twitter = htmlspecialchars($_POST['twitter'], ENT_QUOTES, 'utf-8');
    $passwd1 = htmlspecialchars($_POST['passwd1'], ENT_QUOTES, 'utf-8');
    $passwd2 = htmlspecialchars($_POST['passwd2'], ENT_QUOTES, 'utf-8');
    //$mail = $_SESSION['student_num'] . '@center.wakayama-u.ac.jp';

    $error_msg = array();
    if ($passwd1 !== $passwd2 || ($passwd1 === '' && $passwd2 === '')) {
        $error_msg['passwd'] = '入力されたパスワードが異なります。もう一度入力して下さい。';
    } else {
        $password = $passwd1;
    }
    if (!preg_match('/facebook.com\/[a-zA-Z0-9_]+/', $facebook)) {
        $error_msg['facebook'] = 'Facebookの自分のページのURLを入力して下さい。';
    }
    /*
    if (!preg_match('/twitter.com\/[a-zA-Z0-9_]+/', $twitter)) {
        $error_msg['twitter'] = 'twitterの自分のページのURLを入力して下さい。';
    }
     */
    if ($name === '') {
        $error_msg['name'] = '名前を入力して下さい。';
    }
    if ($grade === '') {
        $error_msg['grade'] = '学年を選択して下さい。';
    }
    if ($sex === '') {
        $error_msg['sex'] = '性別を選択して下さい。';
    }
    if ($department === '') {
        $error_msg['department'] = '学部を選択して下さい。';
    }
    if (empty($error_msg)) {
        $now = date('Y-m-d H:i:s'); 
        
        $db = connect();
        $sql = 'INSERT INTO `users` (student_num, password, name, sex, grade, department, facebook, twitter, created, modified) VALUES (:student_num, :password, :name, :sex, :grade, :department, :facebook, :twitter, :created, :modified);';
        $sth = $db->prepare($sql);
        $sth->bindParam(':student_num', $_SESSION['student_num']);
        $sth->bindParam(':password', $password);
        $sth->bindParam(':name', $name);
        $sth->bindParam(':sex', $sex);
        $sth->bindParam(':grade', $grade);
        $sth->bindParam(':department', $department);
        $sth->bindParam(':facebook', $facebook);
        $sth->bindParam(':twitter', $twitter);
        $sth->bindParam(':created', $now);
        $sth->bindParam(':modified', $now);
        $ret = $sth->execute();
        //$ret = 1;
        if ($ret) {
            echo "<p>登録完了しました。</p>";
            echo "<p><a href='login.php'>こちら</a>からログインして下さい。</p>";
            exit(); 
        }
        
    }

//    var_dump($error_msg);exit();
    //exit();
    //$sth = $db->prepare('INSERT INTO `users` VALUES ()');
    //$sth->execute();

}

?>

<?php if (isset($_SESSION['student_num']) || isset($error_msg)) { ?>
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
          <a class="brand" href="/">inCollege</a>
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
        <h3>新規登録</h3>
        <br>
        <form method="post" action="register.php">
            <label>名前</label>
            <label style="color:red;"><?php if (isset($error_msg['name'])) echo $error_msg['name']; ?></label>
            <input type="text" name="name" value="<?php if (isset($name)) echo $name; ?>">
            <label>性別</label>
            <label style="color:red;"><?php if (isset($error_msg['sex'])) echo $error_msg['sex']; ?></label>
            <select name="sex">
                <option value="">選択して下さい</option>
                <option value="men">男</option>
                <option value="women">女</option>
            </select>
            <label>学年</label>
            <label style="color:red;"><?php if (isset($error_msg['grade'])) echo $error_msg['grade']; ?></label>
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
            <label style="color:red;"><?php if (isset($error_msg['department'])) echo $error_msg['department']; ?></label>
            <select name="department">
                <option value="">選択して下さい</option>
                <option value="keizai">経済学部</option>
                <option value="kyouiku">教育学部</option>
                <option value="shisukou">システム工学部</option>
                <option value="kankou">観光学部</option>
            </select>
            <label>Facebookの自分のページのURL（必須）</label>
            <label style="color:red;"><?php if (isset($error_msg['facebook'])) echo $error_msg['facebook']; ?></label>
            <input type="text" name="facebook" style="width:350px;" value="<?php if (isset($facebook)) echo $facebook; else echo 'https://www.facebook.com/'; ?>">
            <label>Twitterの自分のアカウントのURL（任意）</label>
           <!-- <label style="color:red;"><?php /*if (@$error_msg['twitter']) echo $error_msg['twitter'];*/ ?></label> -->
            <input type="text" name="twitter" style="width:350px;" value="<?php if (isset($twitter)) echo $twitter; else echo 'https://twitter.com/'; ?>">
            <input type="hidden" name="student_num" value="<?php echo $student_num; ?>">
            <label>パスワード</label>
            <label style="color:red;"><?php if (isset($error_msg['passwd'])) echo $error_msg['passwd']; ?></label>
            <input type="password" name="passwd1">
            <label>パスワード(確認)</label>
            <input type="password" name="passwd2">
            <br>
            <br>
            <input type="submit" name="submit" value="登録する" class="btn btn-primary btn-large">
        </form>
    </div>

</body>
</html>
<?php
} else {
    header('Location: http://sns.ikasamaworks.net');
}
 ?>
