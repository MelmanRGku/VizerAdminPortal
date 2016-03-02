<?php

$projectRoot = "../../";
include_once($projectRoot."/includes/functions.php");

$adminName = $_POST["nameField"];
$adminEmail = $_POST["emailField"];
$password = hash("sha256", $_POST["passwordField"], false);

$item = array(
  "Email" => array('S' => $adminEmail),
  "AdminName" => array('S' => $adminName),
  "Password" => array('S' => $password),
  );

addToAdminDB($item);

header('Location: ./');

?>