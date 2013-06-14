<?php

$mail = htmlspecialchars($_POST['mail'], ENT_QUOTES, 'utf-8');

if (preg_match('/[sys|center].wakayama-u.ac.jp$/', $mail)) {
    echo "このメールアドレスに登録確認用のメールを送信しました。\n";
    echo "確認用URLをクリックして登録作業を続けて下さい。\n";

    $to = $mail;
    preg_match("/(s[0-9]+)/", $mail, $number);
    $student_num = $number[1];
    //var_dump($student_num);exit;
    $title = "【inCollege】登録確認メール";
    $url = "http://sns.ikasamaworks.net/register.php?sn=$student_num";
    $body = "
        inCollege 運用担当です。

        inCollege はあなたに充実した大学生活をご提供いたします。

        以下のURLをクリックして、登録作業を続けて下さい。

        確認用URL: $url
        ";
    $from = "s145048@center.wakayama-u.ac.jp";

    if (mb_send_mail($to, $title, $body, "From:$from")) echo "送信しました。";;

    exit();
} else {
    echo "このメールアドレスからは登録できません。\n";
    echo "和歌山大学のメールアドレスからのみ登録することができます。\n";
    exit();
}
