<?php

session_start();
if (!isset($_SESSION['state'])) {
  header('Location: ../login/');
}

$projectRoot = "../../";
include_once($projectRoot."/includes/functions.php");

$rooms = $_POST["rooms"];


//generate listing uuid
$listingID = createUUID();

// generate UUID for each room
for($i = 0; $i < count($rooms); $i++){
	$rooms[$i]["UUID"] = createUUID();
	$rooms[$i]["imgUUID"] = createUUID();

	//upload image to S3
	$imageCont = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $rooms[$i]["image"])  );
	$tempAddress = './temp_uploads/'.$rooms[$i]["imgUUID"].'.jpeg';
	file_put_contents($tempAddress, $imageCont);
	uploadImage($tempAddress, $rooms[$i]["imgUUID"]);
}

//assign toUUID for each link
for($i = 0; $i < count($rooms); $i++){
	for($j = 0; $j < count($rooms[$i]["links"]); $j++){
		$toID = $rooms[$i]["links"][$j]["toId"];
		$toUUID = getCorrespondingRoomUUID($rooms, $toID);
		$rooms[$i]["links"][$j]["toUUID"] = $toUUID;
	}
}


//debugging
$myfile = fopen("submitRec.txt", "w") or die("Unable to open file!");
foreach( $rooms as $room){
  fwrite($myfile, $room["name"] . PHP_EOL);
  fwrite($myfile, $room["id"] . PHP_EOL);
  fwrite($myfile, $room["UUID"] . PHP_EOL);

  foreach( $room["links"] as $link){
  	fwrite($myfile, $link["toUUID"] . PHP_EOL);
  }
  fwrite($myfile, PHP_EOL);
}
fclose($myfile);


// $imageCont = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data["rooms"][0]["image"]));
// file_put_contents('./house.jpeg', $imageCont);


function getCorrespondingRoomUUID($rooms, $id){

	foreach($rooms as $room){
		if($room["id"] == $id){
			return $room["UUID"];
		}
	}

	return "None";
}


?>
