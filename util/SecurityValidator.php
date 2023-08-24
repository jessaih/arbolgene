<?php

/*
  $plaintext_user = "gonzapp";
  $plaintext_password = "GonzApp-20@!08$%23_.";
*/
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.html?unauthorized=true');
    exit;
}
?>
