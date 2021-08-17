<?php

session_start();
$_SESSION = array();
session_destroy();
?>

<p>ログアウトしました。</p>
<p><a href="login.php">ログインページへ</a></p>
