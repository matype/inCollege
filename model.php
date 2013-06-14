<?php

function connect()
{
    $pdo = new PDO(
        'mysql:host=localhost;dbname=sns;charset=utf8',
        '',
        '',
        array(PDO::ATTR_EMULATE_PREPARES => false)
    );
    return $pdo;
}
