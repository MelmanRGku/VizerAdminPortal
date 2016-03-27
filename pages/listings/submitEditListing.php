<?php

session_start();
if (!isset($_SESSION['state'])) {
  header('Location: ../../login/');
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$projectRoot = "../../";
include_once($projectRoot."/includes/functions.php");

$item = getListing($_POST["idField"]);

$item["Item"]["Address"]["S"] = $_POST["addressField"];
$item["Item"]["City"]["S"] = $_POST["cityField"];
$item["Item"]["Price"]["N"] = $_POST["priceField"];
$item["Item"]["Description"]["S"] = $_POST["descriptionField"];
$item["Item"]["UserEmail"]["S"] = $_POST["emailField"];
$item["Item"]["URL"]["S"] = $_POST["urlField"];
if(isset($_POST["privateField"]))
{
  $item["Item"]["Private"]["BOOL"] = true;
}
else
{
  $item["Item"]["Private"]["BOOL"] = false;
}

addToListingDB($item["Item"]);

header('Location: ./');

?>