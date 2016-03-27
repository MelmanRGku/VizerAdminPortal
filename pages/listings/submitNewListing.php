<?php

session_start();
if (!isset($_SESSION['state'])) {
  header('Location: ../login/');
}

$projectRoot = "../../";
include_once($projectRoot."/includes/functions.php");

$rooms = $_POST["rooms"];

//getting userID
$userID = generate_user($_POST["email"], $_POST["name"], $_POST["phone"]);

//generate listing uuid
$listingID = createUUID();

$firstRoomUUID = null;

// generate UUID for each room and push to DB
for($i = 0; $i < count($rooms); $i++){
	$rooms[$i]["UUID"] = createUUID();
	$rooms[$i]["imgUUID"] = createUUID();
	$rooms[$i]["listingUUID"] = $listingID;

	if($rooms[$i]["firstRoom"] == true){
		$firstRoomUUID = $rooms[$i]["UUID"];
	}

	//upload image to S3
	uploadImageToS3($rooms[$i]["image"], $rooms[$i]["imgUUID"]);

	insertRoomToDB($rooms[$i]);

}

if($firstRoomUUID == null) { 
	$firstRoomUUID = $rooms[0]["UUID"]; 
	$rooms[0]["firstRoom"] = true;
}

for($i = 0; $i < count($rooms); $i++){

	//assign toUUID for each link and push to DB
	for($j = 0; $j < count($rooms[$i]["links"]); $j++){
		$rooms[$i]["links"][$j]["fromUUID"] = $rooms[$i]["UUID"];
		$toID = $rooms[$i]["links"][$j]["toId"];
		$toUUID = getCorrespondingRoomUUID($rooms, $toID);
		$rooms[$i]["links"][$j]["toUUID"] = $toUUID;
		$rooms[$i]["links"][$j]["listingUUID"] = $listingID;

		insertLinkToDB($rooms[$i]["links"][$j]);
	}

	for($j = 0; $j < count($rooms[$i]["bubbles"]); $j++){
		$rooms[$i]["bubbles"][$j]["UUID"] = createUUID();
		$rooms[$i]["bubbles"][$j]["listingUUID"] = $listingID;
		$rooms[$i]["bubbles"][$j]["roomUUID"] = $rooms[$i]["UUID"];

		insertBubbleToDB($rooms[$i]["bubbles"][$j]);
	}


}

//push listing to DB
$coverPhotoID = createUUID();
uploadImageToS3($_POST["coverPhoto"], $coverPhotoID);

$privateBool = false;
if($_POST['private'] == "true"){ $privateBool = true;}

$item = array(
  "ListingID" => array('S' => $listingID),
  "HousePhotoID" => array('S' => $coverPhotoID),
  "Address" => array('S' => $_POST["address"]),
  "City" => array('S' => $_POST["city"]),
  "Price" => array('N' => $_POST["price"]),
  "Description" => array('S' => $_POST["description"]),
  "UserEmail" => array('S' => $_POST["email"]),
  "URL" => array('S' => $_POST["url"]),
  "Private" => array('BOOL' => $privateBool),
  "NumTours" => array('N' => '0'),
  "TotalTourTime" => array('N' => '0'),
  "StartingRoomID" => array('S' => $firstRoomUUID),
  "UserID" => array('S' => $userID),
  );

addToListingDB($item);


//debugging
$myfile = fopen("submitRec.txt", "w") or die("Unable to open file!");
foreach( $rooms as $room){
  fwrite($myfile, $room["name"] . PHP_EOL);
  fwrite($myfile, $room["id"] . PHP_EOL);
  fwrite($myfile, $room["UUID"] . PHP_EOL);
  fwrite($myfile, $room["firstRoom"] . PHP_EOL); 
  fwrite($myfile, $firstRoomUUID . PHP_EOL);  

  foreach( $room["links"] as $link){
  	fwrite($myfile, $link["toUUID"] . PHP_EOL);
  }
  fwrite($myfile, PHP_EOL);
}
fclose($myfile);



function getCorrespondingRoomUUID($rooms, $id){

	foreach($rooms as $room){
		if($room["id"] == $id){
			return $room["UUID"];
		}
	}

	return "None";
}

function insertRoomToDB($room){
	$item = array(
		"RoomID" => array('S' => $room["UUID"]),
  		"ListingID" => array('S' => $room["listingUUID"]),
  		"Name" => array('S' => $room["name"]),
  		"ImageID" => array('S' => $room["imgUUID"]),
  		);

	addToRoomDB($item);
}

function insertLinkToDB($link){
	$item = array(
		"RoomID1" => array('S' => $link["fromUUID"]),
  		"RoomID2" => array('S' => $link["toUUID"]),
  		"ListingID" => array('S' => $link["listingUUID"]),
  		"Theta" => array('N' => $link["theta"]),
  		"Phi" => array('N' => $link["phi"]),
  		);

	addToLinkDB($item);
}

function insertBubbleToDB($bubble){
	$item = array(
		"BubbleID" => array('S' => $bubble["UUID"]),
  		"RoomID" => array('S' => $bubble["roomUUID"]),
  		"ListingID" => array('S' => $bubble["listingUUID"]),
  		"Text" => array('S' => $bubble["text"]),
  		"Theta" => array('N' => $bubble["theta"]),
  		"Phi" => array('N' => $bubble["phi"]),
  		);

	addToBubbleDB($item);
}

function uploadImageToS3($image, $UUID)
{
	$imageCont = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $image ));
	$tempAddress = './temp_uploads/'. $UUID;
	file_put_contents($tempAddress, $imageCont);
	uploadImage($tempAddress, $UUID);
}

?>
