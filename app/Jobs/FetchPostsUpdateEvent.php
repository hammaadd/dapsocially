<?php

namespace App\Jobs;

use Facebook\Facebook;
use App\Models\User\Event;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Models\E_social_wall;
use Illuminate\Bus\Queueable;
use App\Models\Event_Social_Post;
use Atymic\Twitter\Facade\Twitter;
use Illuminate\Support\Facades\Http;
use App\Models\User\Attached_Account;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Session;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Facebook\Exceptions\FacebookSDKException;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Facebook\Exceptions\FacebookResponseException;

class FetchPostsUpdateEvent implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $event;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Event $event)
    {
        //
        $this->event = $event;

        $this->media = array();

        $this->index = 0;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $event = Event::where('id', '=', $this->event->id)->first();
        $res = E_social_wall::where('event_id',$event->id)->delete();
        if ($event->facebook_added() != null && $event->facebook_added()->count() > 0):
            $attach_acc=Attached_Account::where('user_id', $this->event->created_by)->where('verified_acc', 'facebook')->first();
        $accesstoken=$attach_acc->token;
        $event_post=Event_Social_Post::where('event_id', $this->event->id)->first();
        $data=$this->getPost($accesstoken, $event_post->page_id);
        $posts=$data['data'];
        //dd($posts);
        foreach ($posts as $post) {
            $soc = new E_social_wall;
            $soc->text = $post['message'] ?? '';
            $soc->image = $post['full_picture'] ?? '';
            $soc->platform = 'facebook';
            $soc->user_img =$post['from']['picture']['data']['url'];
            $soc->username = $post['from']['name'];
            $soc->posted_at = date('Y-m-d h:i', strtotime($post['created_time']));
            $soc->url = $post['permalink_url'] ;
            $soc->event_id = $this->event->id;
            $soc->save();
        }
        endif;

        if ($event->twitter_added() != null && $event->twitter_added()->count() > 0):
            $tw_attach_acc=Attached_Account::where('user_id', $this->event->created_by)->where('verified_acc', 'twitter')->first();
        $tw_attach_acc = json_decode($tw_attach_acc->token);
        $screen_name = $tw_attach_acc->screen_name;

        $twitter = Twitter::usingCredentials($tw_attach_acc->oauth_token, $tw_attach_acc->oauth_token_secret);
        $user_tweets  = $twitter->getUserTimeline(['count'=>'5','screen_name'=>$screen_name]);
        foreach ($user_tweets as $tweet) {
            if (isset($tweet->entities->media[0]->media_url)):
                    $media_url = $tweet->entities->media[0]->media_url; else:
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
        foreach ($tweets->statuses as $tweet) {
            if (isset($tweet->entities->media[0]->media_url)):
                    $media_url = $tweet->entities->media[0]->media_url; else:
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

        if ($event->tiktok_added() != null && $event->tiktok_added()->count() > 0):
            $tiktok=Attached_Account::where('user_id', $this->event->created_by)->where('verified_acc', 'tiktok')->first();
        $ttoken = $tiktok->token;
        $user_data = json_decode($tiktok->user_social_id);
        $open_id = $user_data->open_id;
        //Url to fetch added user list
        $url = 'https://open-api.tiktok.com/video/list/';
        $response = Http::get($url, [
                    'open_id' => $open_id,
                    'access_token'=> $ttoken,
            ]);

        $response = $response->object();
        $url2 = 'https://www.tiktok.com/oembed';
        $url3 = 'https://open-api.tiktok.com/oauth/userinfo/';
        $response3 = Http::get($url3, [
                'open_id' => $open_id,
                'access_token'=> $ttoken,
                ]);
        $response3 = $response3->object();
        $avatar_img = $response3->data->avatar_larger;
        foreach ($response->data->video_list as $video) {
            $share = $video->share_url;
            $response2 = Http::get($url2, [
                    'url' => $share
                ]);
            $response2 = $response2->object();

            $tw = new E_social_wall;
            $tw->text = $response2->title;
            $tw->image = $response2->html;
            $tw->platform = 'tiktok';
            $tw->user_img = $avatar_img;
            $tw->username = $response3->data->display_name;
            $tw->posted_at = gmdate('Y-m-d h:i', $video->create_time);
            $tw->url = $video->share_url ;
            $tw->event_id = $this->event->id;
            $tw->save();
        }

        endif;

        if ($event->instagram_added() != null && $event->instagram_added()->count() > 0) {
            //dd(auth()->user()->id);
            $attach_account = Attached_Account::where('user_id', auth()->user()->id)->where('verified_acc', 'facebook')->orderBy('created_at', 'desc')->first();
            $instaID = Attached_Account::where('user_id', auth()->user()->id)->where('verified_acc', 'instagram')->orderBy('created_at', 'desc')->first();
            $hashtag = $this->event->hashtag;
            $q = Str::replaceFirst('#', '', $hashtag);
            $this->getInstaHashID($instaID->user_social_id, $q, $attach_account->token, $instaID->token);
        }


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
                $page_id.'/posts?fields=message,shares,permalink_url,full_picture,created_time,from{name,username,picture}',
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

    public function getInstaHashID($userId, $htags, $token, $IGtoken)
    {
        $client = new \GuzzleHttp\Client();

        $sec = env('INSTAGRAM_CLIENT_SECRET');
        $app_id = env('INSTAGRAM_CLIENT_ID');

        $media = $this->getData($userId, $IGtoken);
        $hasharray = explode(',', $htags);

        if (isset($hasharray) && !empty($hasharray)) {
            $filteredArray = Arr::where($media, function ($value, $key) use ($hasharray) {
                if (isset($value->caption) && !empty($value->caption)) {
                    $caption = strtolower($value->caption);
                    foreach ($hasharray as $key => $item) {
                        $item = strtolower($item);
                        if (strpos($caption, '#'.$item) !== false) {
                            return $value;
                            break;
                        }
                    }
                }
            });
        }
        if(isset($filteredArray) && !empty($filteredArray))
        {
            foreach($filteredArray as $post)
            {
                $soc = new E_social_wall;
                $soc->text = $post->caption ?? '';
                $soc->image = $post->media_url ?? '';
                $soc->platform = 'instagram';
                $soc->user_img = '';
                $soc->username = $post->username;
                $soc->posted_at = date('Y-m-d h:i', strtotime($post->timestamp));
                $soc->url = $post->media_url ?? '';
                $soc->event_id = $this->event->id;
                $soc->save();
            }
        }
    }

    public function getHastagMediaByID($userId, $token, $after)
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', "https://graph.instagram.com/v11.0/$userId/media?fields=caption,media_type,timestamp,username,permalink,media_url&access_token=$token&after=$after");

        $content = $response->getBody()->getContents();
        $data = json_decode($content);
        $media['data'] = $data->data;
        $media['next'] = (isset($data->paging->next) ? true : false);
        $media['after'] = (isset($data->paging->cursors->after) ? $data->paging->cursors->after : '');

        return $media;

    }
    public function getData($userId, $token, $after = ''){
        $res = $this->getHastagMediaByID($userId, $token, $after);
               if(!empty($res['data']))
               {
                    foreach($res['data'] as $key => $value)
                    {
                        $this->media[$this->index] =  $value;
                        $this->index++;
                    }
                   if($res['next'] == true)
                   {
                       $after = $res['after'];
                       $this->getData($userId, $token, $after);
                   }
               }

            return $this->media;
    }
    // public function getMediaByID($mediaID, $token){

    //     $client = new \GuzzleHttp\Client();

    //     $media = $client->request('GET', "https://graph.facebook.com/$mediaID/recent_media?user_id=17841405309211844");

    //     $Med = $media->getBody()->getContents();
    //     $dataMed = json_decode($Med);
    //     dd($dataMed);
    //     return $dataMed;
    // }
}
