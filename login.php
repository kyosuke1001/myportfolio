<?php
require("dbconnect.php");
require("function.php");
session_start();

if (!empty($_POST)) {
  if (($_POST['email']) || $_POST['password'] != '') {
    $stmt = $dbh->prepare("SELECT * FROM members WHERE email=:email");
    $stmt->bindValue(':email', $_POST['email']);
    $stmt->execute();
    $member = $stmt->fetch();

    if (password_verify($_POST['password'], $member['password'])) {
      $_SESSION['id'] = $member['id'];
      $_SESSION['name'] = $member['name'];
      header ("Location: index.php"); exit();
    } else {
      $message = 'メールアドレス又はパスワードが違います';
    }
  } else {
    $message = 'メールアドレスとパスワードを入力してください。';
  }
} else {
  $message = '';
}
?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>ログイン</title>
  </head>
  <body>
    <h1>ログイン</h1>
    <a href="signup.php"><p>会員登録がお済みでない方はコチラ</p></a>
    <form action="" method="post">
      <p><?php echo $message; ?></p>
      <dl>
        <dt>メールアドレス</dt>
        <dd>
          <input type="text" name="email" size="35" maxlength="255">
        </dd>

        <dt>パスワード</dt>
        <dd>
          <input type="password" name="password" size="35" maxlength="255">
        </dd>

        <dt>ログイン情報の記録</dt>
        <dd>
          <input id="save" type="checkbox" name="save" value="on"><label for="save">次回からは自動的にログインする</label>
        </dd>
      </dl>
      <div>
        <input type="submit" value="ログインする">
      </div>
    </form>
  </body>
</html>
