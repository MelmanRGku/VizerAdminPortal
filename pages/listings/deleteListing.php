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

$allRooms = getListingRooms($_GET["id"]);

foreach($allRooms["Items"] as $room)
{
	$allLinks = getRoomLinks($room["RoomID"]["S"]);

	foreach($allLinks["Items"] as $link)
	{
		deleteLink($link["RoomID1"]["S"], $link["RoomID2"]["S"]);
	}

	$allBubbles = getRoomBubbles($room["RoomID"]["S"]);

	foreach($allBubbles["Items"] as $bubble)
	{
		deleteBubble($bubble["BubbleID"]["S"]);
	}

	deleteRoom($room["RoomID"]["S"]);
}

deleteListing($_GET["id"]);

header('Location: ./');

?>