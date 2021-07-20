<?php

namespace App\Jobs;

use App\Models\E_social_wall;
use App\Models\Event_Social_Post;
use App\Models\User\Attached_Account;
use App\Models\User\Event;
use Atymic\Twitter\Facade\Twitter;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class FetchSocialWallEventPosts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $event;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Event $event)
    {
        //
        $this->event = $event;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $event = Event::where('id','=',$this->event->id)->first();
        if($event->facebook_added()->count() > 0 ):
            $attach_acc=Attached_Account::where('user_id',$this->event->created_by)->where('verified_acc','facebook')->first();
            $accesstoken=$attach_acc->token;
            $event_post=Event_Social_Post::where('event_id',$this->event->id)->first();
            $data=$this->getPost($accesstoken,$event_post->page_id);
            $posts=$data['data'];

            foreach($posts as $post){
                $soc = new E_social_wall;
                $soc->text = $post['message'];
                $soc->image = $post['full_picture'];
                $soc->platform = 'facebook';
                $soc->user_img =$post['from']['picture']['data']['url'];
                $soc->username = $post['from']['name'];
                $soc->posted_at = date('Y-m-d h:i', strtotime($post['created_time']));
                $soc->url = $post['permalink_url'] ;
                $soc->event_id = $this->event->id;
                $soc->save();
            }
        endif;

        if($event->twitter_added()->count() > 0):
            $tw_attach_acc=Attached_Account::where('user_id',$this->event->created_by)->where('verified_acc','twitter')->first();
            $tw_attach_acc = json_decode($tw_attach_acc->token);
            $screen_name = $tw_attach_acc->screen_name;

            $twitter = Twitter::usingCredentials($tw_attach_acc->oauth_token,$tw_attach_acc->oauth_token_secret);
            $user_tweets  = $twitter->getUserTimeline(['count'=>'5','screen_name'=>$screen_name]);
            foreach($user_tweets as $tweet){
                if(isset($tweet->entities->media[0]->media_url)):
                    $media_url = $tweet->entities->media[0]->media_url;
                else:
                    $media_url = asset('assets/Group 389.png');
                endif;
                $tw = new E_social_wall;
                $tw->text = $tweet->text;
                $tw->image = $media_url;
                $tw->platform = 'twitter';
                $tw->user_img =$tweet->user->profile_image_url_https;
                $tw->username = $tweet->user->name;
                $tw->posted_at = date('Y-m-d h:i', strtotime($tweet->created_at));
                $tw->url = Twitter::linkTweet($tweet) ;
                $tw->event_id = $this->event->id;
                $tw->save();
            }

            $hashtag = $this->event->hashtag;
            $q = Str::replaceFirst('#', '', $hashtag);
            $tweets = $twitter->getSearch(['count'=>'5','q'=>$q,'tweet.fields'=>'id,text,attachments,created_at,possibly_sensitive,public_metrics,entities']);
            foreach($tweets->statuses as $tweet){
                if(isset($tweet->entities->media[0]->media_url)):
                    $media_url = $tweet->entities->media[0]->media_url;
                else:
                    $media_url = asset('assets/Group 389.png');
                endif;
                $tw = new E_social_wall;
                $tw->text = $tweet->text;
                $tw->image = $media_url;
                $tw->platform = 'twitter';
                $tw->user_img =$tweet->user->profile_image_url_https;
                $tw->username = $tweet->user->name;
                $tw->posted_at = date('Y-m-d h:i', strtotime($tweet->created_at));
                $tw->url = Twitter::linkTweet($tweet) ;
                $tw->event_id = $this->event->id;
                $tw->save();
            }
        endif;

        if($event->twitter_added()->count() > 0):
            $tiktok=Attached_Account::where('user_id',$this->event->created_by)->where('verified_acc','tiktok')->first();
            $ttoken = $tiktok->token;
            $user_data = json_decode($tiktok->user_social_id);
            $open_id = $user_data->open_id;
            //Url to fetch added user list
            $url = 'https://open-api.tiktok.com/video/list/';
            $response = Http::get($url,[
                    'open_id' => $open_id,
                    'access_token'=> $ttoken,
            ]);

            $response = $response->object();
            $url2 = 'https://www.tiktok.com/oembed';
            $url3 = 'https://open-api.tiktok.com/oauth/userinfo/';
            $response3=Http::get($url3,[
                'open_id' => $open_id,
                'access_token'=> $ttoken,
                ]);
            $response3 = $response3->object();
            $avatar_img = $response3->data->avatar_larger;
            foreach($response->data->video_list as $video){
                $share = $video->share_url;
                $response2 = Http::get($url2,[
                    'url' => $share
                ]);
                $response2 = $response2->object();

                $tw = new E_social_wall;
                $tw->text = $response2->title;
                $tw->image = $response2->html;
                $tw->platform = 'tiktok';
                $tw->user_img = $avatar_img;
                $tw->username = $response3->data->display_name;
                $tw->posted_at = gmdate('Y-m-d h:i', $response->create_time);
                $tw->url = $response->share_url ;
                $tw->event_id = $this->event->id;
                $tw->save();
            }



            // $url = 'https://open-api.tiktok.com/video/list/';
            // $response = Http::get($url,[
            //         'open_id' => $open_id,
            //         'access_token'=> $token,
            // ]);
            // $response = $response->object();
            // // //Here loop is needed
            // $share = $response->data->video_list[0]->share_url;

            // $url2 = 'https://www.tiktok.com/oembed';
            // $response = Http::get($url2,[
            //         'url' => $share
            // ]);
            // $response = $response->object();


        endif;
        Session::flash('message', 'Social Wall Created succesfully');


    }

    public function getPost($accesstoken,$page_id)
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
              $page_id.'/posts?fields=message,shares,permalink_url,full_picture,created_time,from{name,username,picture}',$accesstoken
            );


          } catch(FacebookResponseException $e) {
            dd('Graph returned an error: ' . $e->getMessage());
            exit;
          } catch(FacebookSDKException $e) {
            dd('Facebook SDK returned an error: ' . $e->getMessage());
            exit;
          }
          return $response->getDecodedBody();


    }
}
