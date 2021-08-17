<?php
require("dbconnect.php");
require("function.php");
session_start();

if (!isset($_SESSION['join'])) {
  header('Location: entry.php');
  exit();
}

if (!empty($_POST['check'])) {
  $hash = password_hash($_SESSION['join']['password'], PASSWORD_DEFAULT);
  $stmt = $dbh->prepare("INSERT INTO members SET name=?, email=?, password=?");
  $stmt->execute(array(
    $_SESSION['join']['name'],
    $_SESSION['join']['email'],
    $hash
  ));

    if (!isset($error)) {
    $_SESSION['join'] = $_POST;
    header('Location: login.php');
    exit();
  }
  
}
?>

<!DOCTYPE html>
<html lamg="ja">
  <head>
    <meta charset="utf8">
    <meta name="viewport" content="width=device-width,initial-scale1.0,minimum-scale=1.0">
    <title>確認画面</title>
  </head>
  <body> 
    <form action="" method="POST">
      <input type="hidden" name="check" value="checked">
        <h1>ご入力情報の確認</h1>
        <p>ご入力情報に変更が必要な場合、下のボタンから、変更を行ってください</p>
        <p>登録情報は後から変更も可能です</p>
        <?php if (!empty($error) && $error === "error"): ?>
          <p>会員登録に失敗しました。</p>
        <?php endif ?>
        <hr>

        <div>
          <p>ニックネーム</p>
          <p><?php echo htmlspecialchars($_SESSION['join']['name'], ENT_QUOTES); ?></p>
        </div>

        <div>
          <p>メールアドレス</p>
          <p><?php echo htmlspecialchars($_SESSION['join']['email'], ENT_QUOTES); ?></p>
        </div>

        <div>
          <p>パスワード</p>
          <p><?php echo h(str_repeat("*", mb_strlen($_SESSION['join']['password'], "UTF8")));?></p>
        </div>

      <a href="signup.php">変更する</a>
      <button type="submit">登録する</button>
    </form>
    
  </body>
</html>