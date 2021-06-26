<?php

namespace App\Http\Controllers\TestingApi;
use Facebook\Facebook;
use App\Http\Controllers\Controller;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Helpers\FacebookRedirectLoginHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class FetchFacebookPostController extends Controller
{

    // public $helper='';
    // public function getPost()
    // {
    //   $user_id =Session::get('user_id');
    //   $fb = new Facebook([
    //     'app_id' => env('FACEBOOK_CLIENT_ID'),
    //     'app_secret' => env('FACEBOOK_CLIENT_SECRET'),
    //     'default_graph_version' => 'v11.0',
    //     // . . .
    //     ]);
    //     try {
    //         // Returns a `FacebookFacebookResponse` object
    //         $response = $fb->get(
    //           '/'.$user_id.'/feed',
    //            Session::get('fb_token')
    //         );
    //       } catch(FacebookResponseException $e) {
    //         dd('Graph returned an error: ' . $e->getMessage());
    //         exit;
    //       } catch(FacebookSDKException $e) {
    //         dd('Facebook SDK returned an error: ' . $e->getMessage());
    //         exit;
    //       }
    //       // $graphNode = $response->getDecodedBody();
    //       $graphNode = $response->getGraphEdge();
    //       dd($graphNode);
    // }




//  public function instagram_posts()
//  {
//     $accessToken = 'ACCESS-TOKEN';

// 	$params = array(
// 		'get_code' => isset( $_GET['code'] ) ? $_GET['code'] : '',
// 		'access_token' => $accessToken,
// 		'user_id' => 'USER-ID'
// 	);
// 	$ig = new instagram_basic_display_api( $params );
//     return view('Apis.squarepayment',compact('ig'));
//  }

// }
// class instagram_basic_display_api
// {
//    private $_appId ="4358055167561672";
//    private $_appSecret ="29a481aef5f05cedc7055e56023ae666";
//    private $_redirectUrl = "https://localhost:8000/";
//    private  $_getCode = '';
//    private $_apiBaseUrl = 'https://api.instagram.com/';
//    private  $_graphBaseUrl = 'https://graph.instagram.com/';
//    private $_userAccessToken = '';
//    private  $_userAccessTokenExpires = '';

//    public $authorizationUrl = '';
//    public $hasUserAccessToken = false;
//    public $userId = '';
//     function __construct( $params ) {
//         // save instagram code
//         $this->_getCode = $params['get_code'];

//         // get an access token
//         $this->_setUserInstagramAccessToken( $params );

//         // get authorization url
//         $this->_setAuthorizationUrl();
//     }

//     function getUserAccessToken() {
//         return $this->_userAccessToken;
//     }

//    function getUserAccessTokenExpires() {
//         return $this->_userAccessTokenExpires;
//     }

//      function _setAuthorizationUrl() {
//         $getVars = array(
//             'app_id' => $this->_appId,
//             'redirect_uri' => $this->_redirectUrl,
//             'scope' => 'user_profile,user_media',
//             'response_type' => 'code'
//         );

//         // create url
//         $this->authorizationUrl = $this->_apiBaseUrl . 'oauth/authorize?' . http_build_query( $getVars );
//     }

//  function _setUserInstagramAccessToken( $params ) {
//         if ( $params['access_token'] ) { // we have an access token
//             $this->_userAccessToken = $params['access_token'];
//             $this->hasUserAccessToken = true;
//             $this->userId = $params['user_id'];
//         } elseif ( $params['get_code'] ) { // try and get an access token
//             $userAccessTokenResponse = $this->_getUserAccessToken();
//             $this->_userAccessToken = $userAccessTokenResponse['access_token'];
//             $this->hasUserAccessToken = true;
//             $this->userId = $userAccessTokenResponse['user_id'];

//             // get long lived access token
//             $longLivedAccessTokenResponse = $this->_getLongLivedUserAccessToken();
//             $this->_userAccessToken = $longLivedAccessTokenResponse['access_token'];
//             $this->_userAccessTokenExpires = $longLivedAccessTokenResponse['expires_in'];
//         }
//     }

//  function _getUserAccessToken() {
//         $params = array(
//             'endpoint_url' => $this->_apiBaseUrl . 'oauth/access_token',
//             'type' => 'POST',
//             'url_params' => array(
//                 'app_id' => $this->_appId,
//                 'app_secret' => $this->_appSecret,
//                 'grant_type' => 'authorization_code',
//                 'redirect_uri' => $this->_redirectUrl,
//                 'code' => $this->_getCode
//             )
//         );

//         $response = $this->_makeApiCall( $params );
//         return $response;
//     }

//   function _getLongLivedUserAccessToken() {
//         $params = array(
//             'endpoint_url' => $this->_graphBaseUrl . 'access_token',
//             'type' => 'GET',
//             'url_params' => array(
//                 'client_secret' => $this->_appSecret,
//                 'grant_type' => 'ig_exchange_token',
//             )
//         );

//         $response = $this->_makeApiCall( $params );
//         return $response;
//     }

//      function getUser() {
//         $params = array(
//             'endpoint_url' => $this->_graphBaseUrl . 'me',
//             'type' => 'GET',
//             'url_params' => array(
//                 'fields' => 'id,username,media_count,account_type',
//             )
//         );

//         $response = $this->_makeApiCall( $params );
//         return $response;
//     }

//     function getUsersMedia() {
//         $params = array(
//             'endpoint_url' => $this->_graphBaseUrl . $this->userId . '/media',
//             'type' => 'GET',
//             'url_params' => array(
//                 'fields' => 'id,caption,media_type,media_url',
//             )
//         );

//         $response = $this->_makeApiCall( $params );
//         return $response;
//     }

//   function getPaging( $pagingEndpoint ) {
//         $params = array(
//             'endpoint_url' => $pagingEndpoint,
//             'type' => 'GET',
//             'url_params' => array(
//                 'paging' => true
//             )
//         );

//         $response = $this->_makeApiCall( $params );
//         return $response;
//     }

//      function getMedia( $mediaId ) {
//         $params = array(
//             'endpoint_url' => $this->_graphBaseUrl . $mediaId,
//             'type' => 'GET',
//             'url_params' => array(
//                 'fields' => 'id,caption,media_type,media_url,permalink,thumbnail_url,timestamp,username'
//             )
//         );

//         $response = $this->_makeApiCall( $params );
//         return $response;
//     }

//     function getMediaChildren( $mediaId ) {
//         $params = array(
//             'endpoint_url' => $this->_graphBaseUrl . $mediaId . '/children',
//             'type' => 'GET',
//             'url_params' => array(
//                 'fields' => 'id,media_type,media_url,permalink,thumbnail_url,timestamp,username'
//             )
//         );

//         $response = $this->_makeApiCall( $params );
//         return $response;
//     }

//      function _makeApiCall( $params ) {
//         $ch = curl_init();

//         $endpoint = $params['endpoint_url'];

//         if ( 'POST' == $params['type'] ) { // post request
//             curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $params['url_params'] ) );
//             curl_setopt( $ch, CURLOPT_POST, 1 );
//         } elseif ( 'GET' == $params['type'] && !$params['url_params']['paging'] ) { // get request
//             $params['url_params']['access_token'] = $this->_userAccessToken;

//             //add params to endpoint
//             $endpoint .= '?' . http_build_query( $params['url_params'] );
//         }

//         // general curl options
//         curl_setopt( $ch, CURLOPT_URL, $endpoint );

//         curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );
//         curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
//         curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

//         $response = curl_exec( $ch );

//         curl_close( $ch );

//         $responseArray = json_decode( $response, true );

//         if ( isset( $responseArray['error_type'] ) ) {
//             var_dump( $responseArray );
//             die();
//         } else {
//             return $responseArray;
//         }
//     }







}
