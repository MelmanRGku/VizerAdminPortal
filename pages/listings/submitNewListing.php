<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$projectRoot = "../../";
include_once($projectRoot."/includes/functions.php");


$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["imgUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["imgUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}

$imagePath = "";

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["imgUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["imgUpload"]["name"]). " has been uploaded.";
        $imagePath = $_FILES["imgUpload"]["name"];
        uploadImage($target_file);

    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}


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

// header('Location: ./');

?>