<?php
global $login;
Path::path_file_include("Autoload");

//Đưa biến env vào 
$base_name = pathinfo(Path::path_file_local(""))["dirname"];
$dotenv = Dotenv\Dotenv::createImmutable($base_name);
$dotenv->load();

$clientID = $_ENV['GOOGLE_CLIENT_ID'];
$clientSecret = $_ENV['GOOGLE_CLIENT_SECRET'];
$redirectUri = $_ENV['GOOGLE_REDIRECT_URI'];

// create Client Request to access Google API 
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);

//trước khi dùng phải thêm srope trong oauth screen
$client->addScope("email");
$client->addScope("profile");

$service = new Google_Service_Oauth2($client);

/* * **********************************************
  If we have a code back from the OAuth 2.0 flow,
  we need to exchange that with the authenticate()
  function. We store the resultant access token
  bundle in the session, and redirect to ourself.
 */

if (isset($_GET['code'])) {
  $client->fetchAccessTokenWithAuthCode($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();
  General::view("dang-nhap");
  // exit;
}
/* * **********************************************
  If we have an access token, we can make
  requests, else we generate an authentication URL.
 * ********************************************** */
if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
  $client->setAccessToken($_SESSION['access_token']);
} else {
  $authUrl = $client->createAuthUrl();
}
if ($client->isAccessTokenExpired()) {
  $authUrl = $client->createAuthUrl();
}

if (!isset($authUrl)) {
  $googleUser = $service->userinfo->get(); //get user info 
  if (!empty($googleUser)) {
    $email =  $googleUser->email;
    $name =  $googleUser->name;
    $id = $googleUser->id;

    $login->login_admin_with_google($email, $name, $id);
  }
} else {
  echo '<a href="' . $authUrl . '"><i class="fa fa-google fa-4x"></i></a>';
}
