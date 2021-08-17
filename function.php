<?php

function h($str) {
  return htmlspecialchars($str, ENT_QUOTES);
}

function createToken()
{
  if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
  }
}

?>