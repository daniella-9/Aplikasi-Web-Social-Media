<?php
session_start();

// Include Librari Google Client (API)
include_once 'libraries/google-client/Google_Client.php';
include_once 'libraries/google-client/contrib/Google_Oauth2Service.php';

$client_id = '1038948963825-kcc5g7r4nc5h2hss1mlnhko549kmq36e.apps.googleusercontent.com'; // Google client ID
$client_secret = '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'; // Google Client Secret
$redirect_url = 'http://localhost/sosmed/google.php'; // Callback URL

// Call Google API
$gclient = new Google_Client();
$gclient->setClientId($client_id); // Set dengan Client ID
$gclient->setClientSecret($client_secret); // Set dengan Client Secret
$gclient->setRedirectUri($redirect_url); // Set URL untuk Redirect setelah berhasil login

$google_oauthv2 = new Google_Oauth2Service($gclient);
?>
