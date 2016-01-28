<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use Aws\DynamoDb\DynamoDbClient;
use Aws\S3\S3Client;
use Aws\DynamoDb\Exception\DynamoDbException;
use Aws\DynamoDb\Marshaler;

function getSDKConnection()
{
	date_default_timezone_set('UTC');
	global $projectRoot;

	$sdk = new Aws\Sdk([
    'endpoint'   => 'https://dynamodb.us-west-2.amazonaws.com',
    'region'   => 'us-west-2',
    'version'  => 'latest',
    'credentials' => [
    'key'    => 'AKIAICEANPUXOOHUW7GQ',
    'secret' => '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'
    ],
    'http'    => [
        'verify' => $projectRoot .'includes/awsSDK/ca-bundle.crt'
    ]
]);

	return $sdk;

}

function addToListingDB($item)
{
	$sdkConn = getSDKConnection();
	$dynamodb = $sdkConn->createDynamoDb();
	$marshaler = new Marshaler();

	$tableName = 'Listing';

	$ListingID = 21312;
	$UserID = 00000001;
	$StartingRoomID = 00000006;
	$IsPrivate = True;
	$HousePhotoURL = 'testurl.com';
	$Description = 'This house is a test house';
	$Address = 'Test Address';
	$MLSURL = 'testmlsurl.ca';
	$Price = '$0';

	$params = [
    	'TableName' => 'Listing',
    	'Item' => $item
	];

	try {
    	$result = $dynamodb->putItem($params);
    	// echo "Added item: $Address\n";

	} catch (DynamoDbException $e) {
    	echo "Unable to add item:\n";
    	echo $e->getMessage() . "\n";
	}
}

function createUUID()
{
	$hostname = gethostname();
	$time = microtime();
	$UUID = uniqid($hostname);

	return md5($UUID);
}


?>