<?php
require("dbconnect.php");
session_start();

if (!empty($_POST)) {
  if ($_POST['email'] ==="") {
    $error['email'] = "blank";
  }
  if ($_POST['password'] ==="") {
    $error['password'] = "blank";
  }
  if (strlen($_POST['password']) < 4) {
    $error['password'] = 'length';
  }

  if (empty($error)) {
    $stmt = $dbh->prepare('SELECT COUNT(*) as cnt FROM members WHERE email=:email');
    $stmt->bindValue(1, $_POST['email']);
    $stmt->execute();
    $record = $stmt->fetch();
    if ($record['cnt'] > 0) {
      $error['email'] = 'duplicate';
    }
  }

  if (empty($error)) {
    $_SESSION['join'] = $_POST;
    header('Location: check.php');
    exit();
  }
}
?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf8">
    <meta name="viewport" content="width=device-width,initial-scale1.0,minimum-scale=1.0">
    <title>新規会員登録</title>
  </head>
  
  <body>
    <h1>会員登録</h1>
    <a href="login.php">登録をお済みの方はコチラ</a>
    <form action="" method="POST">
      <div>
        <label for="name">ユーザーネーム</label>
        <input type="text" name="name">
      </div>

      <div>
        <label for="email">メールアドレス</label>
        <input type="email" name="email" maxlength=255>
        <?php if (!empty($error['email']) && $error['email'] === 'blank'): ?>
          <p>メールアドレスを入力してください！</p>
        <?php elseif (!empty($error['email']) && $error['email'] === 'duplicate'): ?>
          <p>このメールアドレスは既に登録済みです！</p>
        <?php endif ?>
      </div>

      <div>
        <label for="password">パスワード</label>
        <input type="password" name="password">
        <?php if (!empty($error['password']) && $error['password'] === 'blank'): ?>
          <p>パスワードを入力してください！</p>
        <?php endif ?>
        <?php if (!empty($error['password']) && $error['password'] === 'length'): ?>
          <p>パスワードは４文字以上で入力してください！</p>
        <?php endif ?>
      </div>

      <button type="submit">確認する</button>
    </form>
  </body>

</html>