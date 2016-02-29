<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once $projectRoot.'/includes/awsSDK/aws-autoloader.php';

use Aws\DynamoDb\DynamoDbClient;
use Aws\S3\S3Client;
use Aws\DynamoDb\Exception\DynamoDbException;
use Aws\DynamoDb\Marshaler;

function getDBConnection()
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

function getS3Connection()
{
	date_default_timezone_set('UTC');
	global $projectRoot;

	$sdk = new Aws\Sdk([
	'endpoint'   => 'https://s3-us-west-2.amazonaws.com',
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
	$sdkConn = getDBConnection();
	$dynamodb = $sdkConn->createDynamoDb();
	$marshaler = new Marshaler();

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

function getAllListings()
{
	$sdkConn = getDBConnection();
	$dynamodb = $sdkConn->createDynamoDb();

    $iterator = $dynamodb->getIterator('Scan', array( 
		'TableName'     => 'Listing',
    	));

    $returnArr = iterator_to_array($iterator);

    return $returnArr;
}

function getAllAdmins()
{
    $sdkConn = getDBConnection();
    $dynamodb = $sdkConn->createDynamoDb();

    $iterator = $dynamodb->getIterator('Scan', array( 
        'TableName'     => 'Admin',
        'ProjectionExpression' => 'Email, AdminName',
        ));

    $returnArr = iterator_to_array($iterator);

    return $returnArr;
}

function uploadImage($imageAddrs, $imgID)
{
	$sdkConn = getS3Connection();
	$s3 = $sdkConn->createS3();

	$result = $s3->putObject(array(
    'Bucket'     => 'izerlabshousestorage',
    'Key'        => $imgID,
    'ContentType'  => 'image/jpg',
    'SourceFile' => $imageAddrs,
    'ACL'          => 'public-read',
));
	// print_r($result);
	
	// We can poll the object until it is accessible
	$s3->waitUntil('ObjectExists', array(
    	'Bucket' => 'izerlabshousestorage',
   		 'Key'    => $imgID
	));

	//delete temp file
	unlink($imageAddrs);

}

function searchListings($query)
{
	$sdkConn = getDBConnection();
	$dynamodb = $sdkConn->createDynamoDb();

    $iterator = $dynamodb->getIterator('Scan', array( 
		'TableName'     => 'Listing',
    	));

    $returnArr = iterator_to_array($iterator);
    
    return $returnArr;
}

function createUUID()
{
	$hostname = gethostname();
	$time = microtime();
	$UUID = uniqid($hostname);

	return md5($UUID);
}

?>