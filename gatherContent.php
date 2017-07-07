<?php
$username = 'jared@stealthwd.ca';
$apikey = 'cdc7d7a9-314c-41f7-ada9-73face3072db';
$account_id = '4400';

#project
$ch = curl_init();

curl_setopt( $ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Accept: application/vnd.gathercontent.v0.5+json'));
curl_setopt( $ch, CURLOPT_USERPWD, $username . ':' . $apikey);
curl_setopt( $ch, CURLOPT_URL, 'https://api.gathercontent.com/projects/79703?account_id=' . $account_id);
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

$response = json_encode( curl_exec( $ch ),true );

$ch = curl_init();

curl_setopt( $ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Accept: application/vnd.gathercontent.v0.5+json'));
curl_setopt( $ch, CURLOPT_USERPWD, $username . ':' . $apikey);
curl_setopt( $ch, CURLOPT_URL, 'https://api.gathercontent.com/items?project_id=79703');
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

$response = json_encode( curl_exec( $ch ),true );
curl_close( $ch );

$ch = curl_init();

curl_setopt( $ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Accept: application/vnd.gathercontent.v0.5+json'));
curl_setopt( $ch, CURLOPT_USERPWD, $username . ':' . $apikey);
curl_setopt( $ch, CURLOPT_URL, 'https://api.gathercontent.com/items/2862264');
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

$response = json_encode( curl_exec( $ch ),true );
curl_close( $ch );
var_dump($response);
?>