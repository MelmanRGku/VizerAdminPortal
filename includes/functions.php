<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once $projectRoot.'/includes/awsSDK/aws-autoloader.php';

use Aws\DynamoDb\DynamoDbClient;
use Aws\S3\S3Client;
use Aws\Ses\SesClient;
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
        #'verify' => 'C:\wamp\www\ca-bundle.crt'
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
        #'verify' => 'C:\wamp\www\ca-bundle.crt'
    ]
]);

	return $sdk;

}


function getSesConnection()
{
    $client = SesClient::factory(array(
    'region'   => 'us-west-2',
    'version'  => 'latest',
    'credentials' => [
    'key'    => 'AKIAICEANPUXOOHUW7GQ',
    'secret' => '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'
    ],
    ));

    return $client;

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

function addToBubbleDB($item)
{
    $sdkConn = getDBConnection();
    $dynamodb = $sdkConn->createDynamoDb();
    $marshaler = new Marshaler();

    $params = [
        'TableName' => 'FeatureBubble',
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

function addToRoomDB($item)
{
    $sdkConn = getDBConnection();
    $dynamodb = $sdkConn->createDynamoDb();
    $marshaler = new Marshaler();

    $params = [
        'TableName' => 'Room',
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

function addToLinkDB($item)
{
    $sdkConn = getDBConnection();
    $dynamodb = $sdkConn->createDynamoDb();
    $marshaler = new Marshaler();

    $params = [
        'TableName' => 'Link',
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

function addToAdminDB($item)
{
    $sdkConn = getDBConnection();
    $dynamodb = $sdkConn->createDynamoDb();
    $marshaler = new Marshaler();

    $params = [
        'TableName' => 'Admin',
        'Item' => $item
    ];

    try {
        $result = $dynamodb->putItem($params);

    } catch (DynamoDbException $e) {
        echo "Unable to add item:\n";
        echo $e->getMessage() . "\n";
    }
}

function addToRequestDB($item)
{
    $sdkConn = getDBConnection();
    $dynamodb = $sdkConn->createDynamoDb();
    $marshaler = new Marshaler();

    $params = [
        'TableName' => 'Request',
        'Item' => $item
    ];

    try {
        $result = $dynamodb->putItem($params);

    } catch (DynamoDbException $e) {
        echo "Unable to add item:\n";
        echo $e->getMessage() . "\n";
    }
}

function addToUserDB($item)
{
    $sdkConn = getDBConnection();
    $dynamodb = $sdkConn->createDynamoDb();
    $marshaler = new Marshaler();

    $params = [
        'TableName' => 'User',
        'Item' => $item
    ];

    try {
        $result = $dynamodb->putItem($params);

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

function getAllUsers()
{
    $sdkConn = getDBConnection();
    $dynamodb = $sdkConn->createDynamoDb();

    $iterator = $dynamodb->getIterator('Scan', array( 
        'TableName'     => 'User',
        ));

    $returnArr = iterator_to_array($iterator);

    return $returnArr;
}

function getAllRequests()
{
    $sdkConn = getDBConnection();
    $dynamodb = $sdkConn->createDynamoDb();

    $iterator = $dynamodb->getIterator('Scan', array( 
        'TableName'     => 'Request',
        ));

    $returnArr = iterator_to_array($iterator);

    return $returnArr;
}

function getAllRequestsSorted($index)
{
    $sdkConn = getDBConnection();
    $dynamodb = $sdkConn->createDynamoDb();

    $iterator = $dynamodb->getIterator('Scan', array( 
        'TableName'     => 'Request',
        'IndexName'     => $index
        ));

    $returnArr = iterator_to_array($iterator);

    return $returnArr;
}

function getListing($id)
{
    $sdkConn = getDBConnection();
    $dynamodb = $sdkConn->createDynamoDb();

    $item = $dynamodb->getItem(array( 
        'TableName'     => 'Listing',
        'ConsistentRead' => true,
        'Key' => [
            'ListingID' => array('S' => $id),
        ],
    ));

    return $item;
}

function getUser($email)
{
    $sdkConn = getDBConnection();
    $dynamodb = $sdkConn->createDynamoDb();

    $iterator = $dynamodb->query(array( 
        'TableName'     => 'User',
        'IndexName'     => 'Email-index',
        'KeyConditionExpression' => 'Email = :v_id',
        'ExpressionAttributeValues' =>  [
        ':v_id' => [
            'S' => $email]
        ],
    ));

    $returnArr = iterator_to_array($iterator);

    return $returnArr;
}

function getUsersListings($email)
{
    $sdkConn = getDBConnection();
    $dynamodb = $sdkConn->createDynamoDb();

    $iterator = $dynamodb->query(array( 
        'TableName'     => 'Listing',
        'IndexName'     => 'UserEmail-index',
        'KeyConditionExpression' => 'UserEmail = :v_id',
        'ExpressionAttributeValues' =>  [
        ':v_id' => [
            'S' => $email]
        ],
    ));

    $returnArr = iterator_to_array($iterator);

    return $returnArr;
}

function getUsersRequests($email)
{
    $sdkConn = getDBConnection();
    $dynamodb = $sdkConn->createDynamoDb();

    $iterator = $dynamodb->query(array( 
        'TableName'     => 'Request',
        'IndexName'     => 'Email-index',
        'KeyConditionExpression' => 'Email = :v_id',
        'ExpressionAttributeValues' =>  [
        ':v_id' => [
            'S' => $email]
        ],
    ));

    $returnArr = iterator_to_array($iterator);

    return $returnArr;
}

function getListingRooms($id)
{
    $sdkConn = getDBConnection();
    $dynamodb = $sdkConn->createDynamoDb();

    $iterator = $dynamodb->query(array( 
        'TableName'     => 'Room',
        'IndexName'     => 'ListingID-index',
        'KeyConditionExpression' => 'ListingID = :v_id',
        'ExpressionAttributeValues' =>  [
        ':v_id' => [
            'S' => $id]
        ],
    ));

    $returnArr = iterator_to_array($iterator);

    return $returnArr;
}

function getRoomLinks($id)
{
    $sdkConn = getDBConnection();
    $dynamodb = $sdkConn->createDynamoDb();

    $iterator = $dynamodb->query(array( 
        'TableName'     => 'Link',
        'IndexName'     => 'RoomID1-index',
        'KeyConditionExpression' => 'RoomID1 = :v_id',
        'ExpressionAttributeValues' =>  [
        ':v_id' => [
            'S' => $id]
        ],
    ));

    $returnArr = iterator_to_array($iterator);

    return $returnArr;
}

function getRoomBubbles($id)
{
    $sdkConn = getDBConnection();
    $dynamodb = $sdkConn->createDynamoDb();

    $iterator = $dynamodb->query(array( 
        'TableName'     => 'FeatureBubble',
        'IndexName'     => 'RoomID-index',
        'KeyConditionExpression' => 'RoomID = :v_id',
        'ExpressionAttributeValues' =>  [
        ':v_id' => [
            'S' => $id]
        ],
    ));

    $returnArr = iterator_to_array($iterator);

    return $returnArr;
}

function getAdminPassword($email)
{
    $sdkConn = getDBConnection();
    $dynamodb = $sdkConn->createDynamoDb();

    $item = $dynamodb->getItem(array( 
        'TableName'     => 'Admin',
        'ConsistentRead' => true,
        'Key' => [
            'Email' => array('S' => $email),
        ],
    ));

    $returnPass = $item['Item']['Password']['S'];

    return $returnPass;
}

function getAdminName($email)
{
    $sdkConn = getDBConnection();
    $dynamodb = $sdkConn->createDynamoDb();

    $item = $dynamodb->getItem(array( 
        'TableName'     => 'Admin',
        'ConsistentRead' => true,
        'Key' => [
            'Email' => array('S' => $email),
        ],
    ));

    $returnName = $item['Item']['AdminName']['S'];

    return $returnName;
}

function getAdmin($email)
{
    $sdkConn = getDBConnection();
    $dynamodb = $sdkConn->createDynamoDb();

    $item = $dynamodb->getItem(array( 
        'TableName'     => 'Admin',
        'ConsistentRead' => true,
        'Key' => [
            'Email' => array('S' => $email),
        ],
    ));

    return $item;
}

function getRequest($id)
{
    $sdkConn = getDBConnection();
    $dynamodb = $sdkConn->createDynamoDb();

    $item = $dynamodb->getItem(array( 
        'TableName'     => 'Request',
        'ConsistentRead' => true,
        'Key' => [
            'RequestID' => array('S' => $id),
        ],
    ));

    return $item;
}

function updateRequest($id, $status)
{
    $sdkConn = getDBConnection();
    $dynamodb = $sdkConn->createDynamoDb();

    $response = $dynamodb->updateItem(array( 
        'TableName' => 'ProductCatalog',
        'Key' => [
            'RequestID' => array('S' => $id),
        ],
        'ExpressionAttributeValues' =>  [
            'Status' => array('S' => $status),
            //'Status' => array('S' => $handeled)
        ] ,
        'UpdateExpression' => 'updated'
    ));

    return $response;
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

function deleteListing($id)
{
    $sdkConn = getDBConnection();
    $dynamodb = $sdkConn->createDynamoDb();

    $response = $dynamodb->deleteItem(array( 
        'TableName'     => 'Listing',
        'Key' =>  [
        'ListingID' => [
            'S' => $id]
        ],
    ));

    //print_r($response);
}

function deleteRoom($id)
{
    $sdkConn = getDBConnection();
    $dynamodb = $sdkConn->createDynamoDb();

    $response = $dynamodb->deleteItem(array( 
        'TableName'     => 'Room',
        'Key' =>  [
        'RoomID' => [
            'S' => $id]
        ],
    ));

    //print_r($response);
}

function deleteLink($id1, $id2)
{
    $sdkConn = getDBConnection();
    $dynamodb = $sdkConn->createDynamoDb();

    $response = $dynamodb->deleteItem(array( 
        'TableName'     => 'Link',
        'Key' =>  [
        'RoomID1' => [
            'S' => $id1],
        'RoomID2' => [
            'S' => $id2]
        ],
    ));

    //print_r($response);
}

function deleteBubble($id)
{
    $sdkConn = getDBConnection();
    $dynamodb = $sdkConn->createDynamoDb();

    $response = $dynamodb->deleteItem(array( 
        'TableName'     => 'FeatureBubble',
        'Key' =>  [
        'BubbleID' => [
            'S' => $id]
        ],
    ));

    //print_r($response);
}

function deleteImage($id)
{
    $sdkConn = getS3Connection();
    $s3 = $sdkConn->createS3();

    $result = $s3->deleteObject(array(
    'Bucket'     => 'izerlabshousestorage',
    'Key'        => $id
    ));
    // print_r($result);
}

function createUUID()
{
	$hostname = gethostname();
	$time = microtime();
	$UUID = uniqid($hostname);

	return md5($UUID);
}

function random_password( $length = 8 ) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
    $password = substr( str_shuffle( $chars ), 0, $length );
    return $password;
}

function generate_user($email, $name, $phone) {

    $user = getUser($email);
    if (count($user["Items"]) == 0)
    {
        $password = random_password();

        $client = getSesConnection();
        $msg = array();
        $msg['Source'] = "izerlabs@gmail.com";
        //ToAddresses must be an array
        $msg['Destination']['ToAddresses'][] = $email;

        $msg['Message']['Subject']['Data'] = "Vizer Account Credentials";
        $msg['Message']['Subject']['Charset'] = "UTF-8";

        $msg['Message']['Body']['Text']['Data'] ="Hello, thank you for choosing Vizer. Your listing request is now complete and live, to make it easier for you to submit listing requests in the future and to allow you to view your existing listings we have created an account you can use to login to our homepage at: *website url*

The Login Credentials for your Vizer account are as follows:
Email: ".$email."
Password: ".$password."

We hope to work with you again.

-Izer Labs";
        $msg['Message']['Body']['Text']['Charset'] = "UTF-8";

        try{
            $result = $client->sendEmail($msg);

            //save the MessageId which can be used to track the request
            $msg_id = $result->get('MessageId');
            echo("MessageId: $msg_id");

            //view sample output
            print_r($result);
        } catch (Exception $e) {
            //An error happened and the email did not get sent
            echo '   error   ';
            echo($e->getMessage());
        }

        $id = createUUID();
        $hashpassword = hash("sha256", $password, false);

        $item = array(
        "UserID" => array('S' => $id),
        "Email" => array('S' => $email),
        "ContactPhone" => array('S' => $phone),
        "Name" => array('S' => $name),
        "Password" => array('S' => $hashpassword),
        );

        addToUserDB($item);

        return $id;
    }
    else{
        return $user["Items"][0]["UserID"]["S"];
    }
}

?>