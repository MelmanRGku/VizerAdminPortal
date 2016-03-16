<?php

session_start();
$projectRoot = "../../";
include_once($projectRoot."/includes/functions.php");

$_SESSION["searchListings"] = $_POST["emailField"];
header('Location: ./');

?>