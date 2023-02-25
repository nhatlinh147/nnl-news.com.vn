<?php
global $login;
Path::path_file_include("Autoload");

//Đưa biến env vào 
$base_name = pathinfo(Path::path_file_local(""))["dirname"];
$dotenv = Dotenv\Dotenv::createImmutable($base_name);
$dotenv->load();

$fb = new Facebook\Facebook([
   'app_id' => $_ENV['FACEBOOK_CLIENT_ID'],
   'app_secret' => $_ENV['FACEBOOK_CLIENT_SECRET'],
   'default_graph_version' =>  $_ENV['FACEBOOK_VERSION'],
]);

$helper = $fb->getRedirectLoginHelper();
$permissions = ['email']; // optional
if (!empty($helper)) {
}
try {
   if (isset($_SESSION['facebook_access_token'])) {
      $accessToken = $_SESSION['facebook_access_token'];
   } else {
      $accessToken = $helper->getAccessToken();
   }
} catch (Facebook\Exceptions\facebookResponseException $e) {
   // When Graph returns an error
   echo 'Graph returned an error: ' . $e->getMessage();
   // exit;
} catch (Facebook\Exceptions\FacebookSDKException $e) {
   // When validation fails or other local issues
   echo 'Facebook SDK returned an error: ' . $e->getMessage();
   // exit;
}
if (isset($accessToken)) {
   if (isset($_SESSION['facebook_access_token'])) {
      $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
   } else {
      // getting short-lived access token
      $_SESSION['facebook_access_token'] = (string) $accessToken;
      // OAuth 2.0 client handler
      $oAuth2Client = $fb->getOAuth2Client();
      // Exchanges a short-lived access token for a long-lived one
      $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);
      $_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;
      // setting default access token to be used in script
      $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
   }
   // redirect the user to the profile page if it has "code" GET variable
   if (isset($_GET['code'])) {
      header('Location: profile.php');
   }
   // getting basic info about user
   try {
      $profile_request = $fb->get('/me?fields=name,first_name,last_name,email');
      $profile = $profile_request->getGraphUser();
      $fbid = $profile->getField('id');           // To Get Facebook ID
      $fbfullname = $profile->getField('name');   // To Get Facebook full name
      $fbemail = $profile->getField('email');    //  To Get Facebook email
      $_SESSION['check_login_facebook'] = true;

      $login->login_admin_with_google($fbemail, $fbfullname, $fbid);
   } catch (Facebook\Exceptions\FacebookResponseException $e) {
      // When Graph returns an error
      echo 'Graph returned an error: ' . $e->getMessage();
      session_destroy();
      // redirecting user back to app login page
      General::view_link_location("dang-nhap.html");
      exit;
   } catch (Facebook\Exceptions\FacebookSDKException $e) {
      // When validation fails or other local issues
      echo 'Facebook SDK returned an error: ' . $e->getMessage();
      exit;
   }
} else {
   // replace your website URL same as added in the developers.Facebook.com/apps e.g. if you used http instead of https and you used            
   $loginUrl = $helper->getLoginUrl($_ENV['FACEBOOK_REDIRECT_URI'], $permissions);
   echo '<a href="' . $loginUrl . '"><i class="fa fa-facebook fa-4x"></i></a>';
}