<?php
require_once 'C:\Users\Said Muqeem Halimi\vendor\facebook\graph-sdk\src\Facebook\autoload.php';

session_start();
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\Entities\AccessToken;
use Facebook\HttpClients\FacebookCurlHttpClient;
use Facebook\HttpClients\FacebookHttpable;

// Include required libraries
use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;


// Call Facebook API
$fb = new Facebook(array(
    'app_id' => '722065571967291',
    'app_secret' => 'bdc8df277300bb02a1bc23e649e111fe',
    'default_graph_version' => 'v3.2',
));
// login helper with redirect_uri
$helper = $fb->getRedirectLoginHelper('http://localhost/fyp%20project/index.php');
try {
    if(isset($_SESSION['facebook_access_token'])){
        $accessToken = $_SESSION['facebook_access_token'];
    }else{
        $accessToken = $helper->getAccessToken();
    }
} catch(FacebookResponseException $e) {
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
} catch(FacebookSDKException $e) {
    echo 'Facebook SDK returned an error: ' . $e->getMessage();

}
echo "config";


?>