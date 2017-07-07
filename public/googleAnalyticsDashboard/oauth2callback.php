<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');

if(!isset($_SESSION))session_start();

$client = new Google_Client();
$client->setAuthConfigFile('service-account-credentials.json');
$client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . '/oauth2callback.php');
$client->addScope('https://www.googleapis.com/auth/analytics.readonly');

if (! isset($_GET['code'])) {
  $auth_url = $client->createAuthUrl();
  header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
} else {
  $client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();
  $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/';
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}
?>