<?php

session_start();
$projectRoot = "../../";
include_once($projectRoot."/includes/functions.php");

$email = $_POST["emailField"];
$password = hash("sha256", $_POST["passwordField"], false);
$truePassword = getAdminPassword($email);

if (strcmp ($password, $truePassword) == 0) {
  session_unset();
  $_SESSION["state"] = "active";
  header('Location: ../listings/');
}
else {
  session_unset();
  $_SESSION["pass"] = "wrong";
  header('Location: ./');
}

?>