<?php

session_start();
require_once 'model.php';

if ($_SESSION['account']) {
    $student_num = htmlspecialchars($_GET['account'], ENT_QUOTES, 'utf-8');
    if ($student_num == $_SESSION['account']) {
        header("Location: http://sns.ikasamaworks.net/mypage.php");
        exit;
    }
    $db = connect();
    $sql = 'SELECT * FROM `users` WHERE `student_num` = ?;';
    $sth = $db->prepare($sql);
    $sth->execute(array($student_num));
    $data = $sth->fetch(PDO::FETCH_ASSOC);
    if (!$data) {
        header("HTTP/1.0 404 Not Found");
        echo "Threre is no such user. ($student_num)";
        exit;
    }
    if (!preg_match('/twitter.com\/[a-zA-Z0-9_]+/', $data['twitter'])) {
        unset($data['twitter']);
    }

    $facebook_url = $data['facebook'];
    $split = explode('/', $facebook_url);
    $facebook_name = $split[3];
    $facebook_picture = "https://graph.facebook.com/$facebook_name/picture?type=large";

    if ($_POST) {
        $fav = htmlspecialchars($_POST['fav'], ENT_QUOTES, 'utf-8');
        $from = $_SESSION['account'];
        $sql_get_id = 'SELECT `id` FROM `users` WHERE `student_num` = ?;';
        $sth = $db->prepare($sql_get_id);
        $sth->execute(array($from));
        $from_id = $sth->fetch(PDO::FETCH_ASSOC);
        $from_id = (int)$from_id['id'];

        $to = $student_num;
        $sth->execute(array($to));
        $to_id = $sth->fetch(PDO::FETCH_ASSOC);
        $to_id = (int)$to_id['id'];

        $db2 = connect();
        $sql = 'SELECT * FROM `favorites` WHERE `from` = ? AND `to` = ?;'; 
        $sth2 = $db2->prepare($sql);
        $sth->execute(array($from_id, $to_id));
        $data = $sth->fetch(PDO::FETCH_ASSOC);
        if (!$data) {
            $now = date('Y-m-d H:i:s');
            $sql = 'INSERT INTO `favorites` (`from`, `to`, `created`, `modified`) VALUES (:from_id, :to_id, :created, :modified);';
            $sth = $db->prepare($sql);
            $sth->bindParam(':from_id', $from_id);
            $sth->bindParam(':to_id', $to_id);
            $sth->bindParam(':created', $now);
            $sth->bindParam(':modified', $now);
            $ret = $sth->execute();
            if ($ret) {
                echo "<p>会いたいリストに追加しました。</p>";
                echo "<p><a href='mypage.php'>戻る</a></p>";
                exit;
            }
        } else {
            echo "<p>すでに登録済みです。</p>";
            echo "<p><a href='mypage.php'>戻る</a></p>";
            exit;

        }
    }

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
              <li class="active"><a href="/">Home</a></li>
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
    名前: <p><?php echo $data['name']; ?></p>
    学部: <p><?php switch ($data['department']) {
    case 'keizai':
        echo "経済学部";break;
    case 'kyouiku':
        echo "教育学部";break;
    case 'shisukou':
        echo "システム工学部";break;
    case 'kankou':
        echo "観光学部";break;


    }?></p>
    学年: <p><?php echo $data['grade']; ?></p>

    <a href="<?php echo $data['facebook'] ?>"><img src="img/facebook-icon.png" width='70' height='70'></a>
<?php if (isset($data['twitter'])) { ?>
        <a href="<?php echo $data['twitter'] ?>"><img src="img/twitter-icon.png" width='70' height='70'></a>
<?php } ?>

    <br>
    <br>
    <br>
    <form method="POST" action="">
        <input type="submit" name="fav" value="会いたいリストに登録" class="btn btn-large btn-success">
    </form>
    </div>

</body>
</html>

