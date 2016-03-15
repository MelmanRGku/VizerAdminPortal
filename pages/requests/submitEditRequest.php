<?php

session_start();
if (!isset($_SESSION['state'])) {
  header('Location: ../../login/');
}

$projectRoot = "../../";
include_once($projectRoot."/includes/functions.php");

$item = getRequest($_POST["idField"]);
$item["Item"]["Status"]["S"] = $_POST["statusField"];
if(isset($_POST["handeledField"]))
{
	$item["Item"]["Handeled"]["BOOL"] = true;
}
else
{
	$item["Item"]["Handeled"]["BOOL"] = false;
}
$time = getdate();
$item["Item"]["LastEditedOn"]["S"] = $time["mday"]."/".$time["mon"]."/".$time["year"];
$item["Item"]["LastEditedBy"]["S"] = getAdminName($_SESSION['user']);

addToRequestDB($item["Item"]);

header('Location: ./');

?>