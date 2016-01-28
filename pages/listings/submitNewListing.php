<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$projectRoot = "../../";
include_once($projectRoot."/includes/functions.php");

$address = $_POST["addressField"];
$city = $_POST["cityField"];
$price = $_POST["priceField"];
$description = $_POST["descriptionField"];
$userEmail = $_POST["emailField"];
$url = $_POST["urlField"];
$private = false;
if( isset($_POST["privateField"])) { $private = true; }
$UUID = createUUID();

$item = array(
  "ListingID" => array('S' => $UUID),
  "HousePhotoURL" => array('S' => 'blahblah'),
  "Address" => array('S' => $address),
  "City" => array('S' => $city),
  "Price" => array('N' => $price),
  "Description" => array('S' => $description),
  "UserEmail" => array('S' => $userEmail),
  "URL" => array('S' => $url),
  "Private" => array('BOOL' => $private),
  "NumTours" => array('N' => '0'),
  "TotalTourTime" => array('N' => '0'),
  "StartingRoomID" => array('S' => 'x'),
  "UserID" => array('S' => 'x'),
  );

addToListingDB($item);

header('Location: ./');

?>