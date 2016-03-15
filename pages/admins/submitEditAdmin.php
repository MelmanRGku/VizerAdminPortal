<?php

session_start();
if (!isset($_SESSION['state'])) {
  header('Location: ../../login/');
}

$projectRoot = "../../";
include_once($projectRoot."/includes/functions.php");

$item = getAdmin($_SESSION['user']);
if(strcmp($_POST["passField1"], $_POST["passField2"]) == 0)
{
	$item["Item"]["Password"]["S"] = hash("sha256", $_POST["passField1"], false);
}
else
{
	header('Location: ./');
}

addToAdminDB($item["Item"]);

header('Location: ./');

?>