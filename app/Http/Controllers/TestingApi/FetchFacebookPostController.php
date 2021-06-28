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
      $user_id =Session::get('user_id');
      $fb = new Facebook([
        'app_id' => env('FACEBOOK_CLIENT_ID'),
        'app_secret' => env('FACEBOOK_CLIENT_SECRET'),
        'default_graph_version' => 'v11.0',
        // . . .
        ]);
        try {
            // Returns a `FacebookFacebookResponse` object
            $response = $fb->get(
              '/'.$user_id.'/feed',
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
