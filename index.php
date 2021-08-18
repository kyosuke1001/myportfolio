<!-- こんにちは -->
<?php 
session_start();
require("./dbconnect.php");
require("./function.php");

createToken();

// 直接アクセスさせるのを防ぐ
if (isset($_SESSION['id'])) {
  $stmt = $dbh->prepare('SELECT * FROM members WHERE id=?');
  $stmt->bindValue(1, $_SESSION['id'], PDO::PARAM_STR);
  $stmt->execute();
  $member = $stmt->fetch();
} else {
  header('Location: login.php'); exit();
}

  $stmt = $dbh->prepare('SELECT * FROM posts WHERE member_id=?');
  $stmt->bindValue(1, $member['id'], PDO::PARAM_STR);
  $stmt->execute();
  $todos = $stmt->fetchALL();

// データベースに保存
if (!empty($_POST)) {
  if ($_POST['message'] != '') {
    $message = $dbh->prepare('INSERT INTO posts SET member_id=?, message=?,created=NOW()');
    $message->bindValue(1, $member['id'], PDO::PARAM_STR);
    $message->bindValue(2, $_POST['message'], PDO::PARAM_STR);
    $message->execute();

// 二重投稿を防ぐ処理。
    header('Location: index.php');
    exit();
  }
}
?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>My Todo List</title>
    <link rel="stylesheet" href="css/style.css">
  </head>
  <body>
    <h1>My Todo List</h1>
    <p><?php echo h($member['name']). "さんようこそ" ?></p>

    <form action="#" method="post">
      <input type="text" name="message" placeholder="Type new todo.">
      <input type="hidden" name="token" value="<?php echo h($_SESSION['token']); ?>">
    </form>
    <hr>
    <ul>
      <?php foreach ($todos as $todo): ?>
        <li>
          <form action="" method="post">
            <input type="checkbox">
            <input type="hidden" name="token" value="<?php echo h($_SESSION['token']); ?>">
            <span><?= h($todo['message']); ?></span>
            <?php if ($_SESSION['id'] === $todo['member_id']): ?>
              <a href="delete.php?id=<?php echo h($todo['id']); ?>">×</a>
            <?php endif ;?>
          </form>
        </li>
      <?php endforeach; ?>
    </ul>
    
    <a href="logout.php">ログアウトする</a>
  </body>
</html>