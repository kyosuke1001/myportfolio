<?php 
session_start();
require('./dbconnect.php');

if (isset($_SESSION['id'])) {
  $id = $_REQUEST['id'];

  $stmt = $dbh->prepare("SELECT * FROM posts WHERE id=?");
  $stmt->bindValue(1, $_REQUEST['id'], PDO::PARAM_STR);
  $stmt->execute();
  $message = $stmt->fetch();

  if ($message['member_id'] === $_SESSION['id']) {
    $stmt = $dbh->prepare("DELETE FROM posts WHERE id=?");
    $stmt->bindValue(1, $_REQUEST['id'], PDO::PARAM_STR);
    $stmt->execute(); 

  }
}

header('Location: index.php'); exit();