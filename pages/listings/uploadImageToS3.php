<?php

header('Content-type: application/json');

session_start();

$projectRoot = "../../";
include_once($projectRoot."/includes/functions.php");

$id = $_POST["id"];
$image = $_POST["image"];
$UUID = createUUID();

uploadImageToS3($image, $UUID);

$retArr = array(
    "id" => $id,
    "UUID" => $UUID,
);

echo json_encode( $retArr );

function uploadImageToS3($image, $UUID)
{
	$imageCont = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $image ));
	$tempAddress = './temp_uploads/'. $UUID;
	file_put_contents($tempAddress, $imageCont);
	uploadImage($tempAddress, $UUID);
}

?>
