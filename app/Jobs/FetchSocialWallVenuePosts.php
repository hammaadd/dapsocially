<?php

namespace App\Jobs;

use App\Models\Attached_Account;
use App\Models\Event_Social_Post;
use App\Models\User\Venue;
use App\Models\V_social_wall;
use App\Models\Venue_Social_Post;
use Atymic\Twitter\Facade\Twitter;
use Illuminate\Bus\Queueable;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class FetchSocialWallVenuePosts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $venue;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Venue $venue)
    {
        //
        $this->venue = $venue;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //

        $venue = Venue::where('id', '=', $this->venue->id)->first();
        if ($venue->facebook_added()->count() > 0) :
            $attach_acc = Attached_Account::where('user_id', $this->venue->created_by)->where('verified_acc', 'facebook')->first();
            $accesstoken = $attach_acc->token;
            $venue_post = Venue_Social_Post::where('venue_id', $this->venue->id)->first();
            $data = $this->getPost($accesstoken, $venue_post->page_id);
            $posts = $data['data'];

            foreach ($posts as $post) {
                $soc = new V_social_wall;
                $soc->text = $post['message'];
                $soc->image = $post['full_picture'];
                $soc->platform = 'facebook';
                $soc->user_img = $post['from']['picture']['data']['url'];
                $soc->username = $post['from']['name'];
                $soc->posted_at = date('Y-m-d h:i', strtotime($post['created_time']));
                $soc->url = $post['permalink_url'];
                $soc->venue_id = $this->venue->id;
                $soc->save();
            }
        endif;

        if ($venue->twitter_added()->count() > 0) :
            $tw_attach_acc = Attached_Account::where('user_id', $this->venue->created_by)->where('verified_acc', 'twitter')->first();
            $tw_attach_acc = json_decode($tw_attach_acc->token);
            $screen_name = $tw_attach_acc->screen_name;

            $twitter = Twitter::usingCredentials($tw_attach_acc->oauth_token, $tw_attach_acc->oauth_token_secret);
            $user_tweets  = $twitter->getUserTimeline(['count' => '5', 'screen_name' => $screen_name]);
            foreach ($user_tweets as $tweet) {
                if (isset($tweet->entities->media[0]->media_url)) :
                    $media_url = $tweet->entities->media[0]->media_url;
                else :
                    $media_url = asset('assets/Group 389.png');
                endif;
                $tw = new V_social_wall;
                $tw->text = $tweet->text;
                $tw->image = $media_url;
                $tw->platform = 'twitter';
                $tw->user_img = $tweet->user->profile_image_url_https;
                $tw->username = $tweet->user->name;
                $tw->posted_at = date('Y-m-d h:i', strtotime($tweet->created_at));
                $tw->url = Twitter::linkTweet($tweet);
                $tw->venue_id = $this->venue->id;
                $tw->save();
            }

            $hashtag = $this->venue->hashtag;
            $q = Str::replaceFirst('#', '', $hashtag);
            $tweets = $twitter->getSearch(['count' => '5', 'q' => $q, 'tweet.fields' => 'id,text,attachments,created_at,possibly_sensitive,public_metrics,entities']);
            foreach ($tweets->statuses as $tweet) {
                if (isset($tweet->entities->media[0]->media_url)) :
                    $media_url = $tweet->entities->media[0]->media_url;
                else :
                    $media_url = asset('assets/Group 389.png');
                endif;
                $tw = new V_social_wall;
                $tw->text = $tweet->text;
                $tw->image = $media_url;
                $tw->platform = 'twitter';
                $tw->user_img = $tweet->user->profile_image_url_https;
                $tw->username = $tweet->user->name;
                $tw->posted_at = date('Y-m-d h:i', strtotime($tweet->created_at));
                $tw->url = Twitter::linkTweet($tweet);
                $tw->venue_id = $this->venue->id;
                $tw->save();
            }
        endif;
        Session::flash('message', 'Social Wall Created succesfully');
    }



    public function getPost($accesstoken, $page_id)
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
                $page_id . '/posts?fields=message,shares,permalink_url,full_picture,created_time,from{name,username,picture}',
                $accesstoken
            );
        } catch (FacebookResponseException $e) {
            dd('Graph returned an error: ' . $e->getMessage());
            exit;
        } catch (FacebookSDKException $e) {
            dd('Facebook SDK returned an error: ' . $e->getMessage());
            exit;
        }
        return $response->getDecodedBody();
    }
}
