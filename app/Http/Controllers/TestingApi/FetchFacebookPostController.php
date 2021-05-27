<?php

namespace App\Http\Controllers\TestingApi;
use Facebook\Facebook;
use App\Http\Controllers\Controller;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Helpers\FacebookRedirectLoginHelper;
use Illuminate\Http\Request;

class FetchFacebookPostController extends Controller
{
    public function getPost()
    {
      $fb = new Facebook([
        'app_id' => '3021116741456838',
        'app_secret' => 'e42319cf4c7518766b46f4c59956b145',
        'default_graph_version' => 'v2.3',
        // . . .
        ]);
        try {
            // Returns a `FacebookFacebookResponse` object
            $response = $fb->get(
              '/me/feed',
              'EAAq7sI4zE8YBAPEFskGtVqFeFxQZBbyI95lZAAiTUjMJOKknGBxoozTN9CglNMrrWsvQHV87gYVjmNP2G5IrnKJzcD4Eg56W1SW4siY6gWOFz4cLgZB65bDkHZCJSbq2AKf1NRfZCCZA0uZAa4jUJB8rbcyDelnbk9qJk0dwUq3EFsKfYzpWiakHhV9KUBSkfccHQ7LhYMrgwZDZD'
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
