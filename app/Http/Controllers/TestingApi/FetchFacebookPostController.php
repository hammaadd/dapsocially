<?php

namespace App\Http\Controllers\TestingApi;
use Facebook\Facebook;
use App\Http\Controllers\Controller;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Illuminate\Support\Facades\Session;

class FetchFacebookPostController extends Controller
{

    // public $helper='';
    public function getPost()
    {
      // $fb_token =Session::get('fb_token');
      $fb = new Facebook(array( 
        'app_id' => env('FACEBOOK_APP_ID'), 
        'app_secret' => env('FACEBOOK_APP_SECRET'), 
        'default_graph_version' => 'v11.0',
    )); 
        try {
            // Returns a `FacebookFacebookResponse` object
            $response = $fb->get(
              '/me',
               Session::get('fb_token')
            );
          } catch(FacebookResponseException $e) {
            dd('Graph returned an error: ' . $e->getMessage());
            exit;
          } catch(FacebookSDKException $e) {
            dd('Facebook SDK returned an error: ' . $e->getMessage());
            exit;
          }
          // $graphNode = $response->getDecodedBody();
          $graphNode = $response->getGraphEdge();
          dd($graphNode);
    }

}
