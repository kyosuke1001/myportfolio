<?php
try {
  $dbh = new PDO(
    'mysql:host=localhost;dbname=myportfolio2;charset=utf8',
    'root',
    'root',
    array(
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_EMULATE_PREPARES => false,
    )
    );
} catch (PDOException $e) {
    $error = $e->getMessage();
}