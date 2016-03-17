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
	unset($_SESSION['passwordmismatch']);
	$item["Item"]["Password"]["S"] = hash("sha256", $_POST["passField1"], false);
	addToAdminDB($item["Item"]);
    header('Location: ./');
}
else
{
	$_SESSION['passwordmismatch'] = "yes";
	header('Location: ./editAdmin.php');
}

?>