<?php
session_start();

if ($_SESSION['account']) {
    session_destroy();
    header('Location: http://sns.ikasamaworks.net/login.php');
    exit;
} else {
    header('Location: http://sns.ikasamaworks.net/login.php');
    exit;
}
