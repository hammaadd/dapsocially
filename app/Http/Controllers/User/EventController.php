<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Jobs\FetchPostsUpdateEvent;
use App\Jobs\FetchSocialWallEventPosts;
use App\Models\E_social_wall;
use App\Models\Event_Social_Post;
use Illuminate\Http\Request;
use App\Models\User\Event;
use App\Models\Location;
use App\Models\User\Venue;
use App\Models\Order;
use App\Models\Payment_Plans;
use App\Models\User;
use App\Models\User\Attached_Account;
use App\Models\User\Collect_Event_Htag;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Atymic\Twitter\Facade\Twitter;
use Illuminate\Support\Facades\Http;
use App\Models\Event_checkouts;

# New Square SDK Client
use Square\SquareClient;
use Square\Environment;
use Square\Exceptions\ApiException;
use Square\Models\CreateCustomerRequest;
use Square\Models\Order as SORDER;
use Square\Models\CreateOrderRequest;
use Square\Models\OrderSource;
use Square\Models\OrderLineItem;
use Square\Models\OrderQuantityUnit;
use Square\Models\MeasurementUnit;
use Square\Models\Currency;
use Square\Models\Money;
use Square\Models\MeasurementUnitCustom;
use Square\Models\CreateCheckoutRequest;

class EventController extends Controller
{
    public $page_data = [];
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {


        $P_plans = Payment_Plans::all();
        ///$attach_acc=Attached_Account::where('user_id',Auth::user()->id)->where('verified_acc','facebook')->first();
        $data = [];
        $tw_user = null;
        # Setting Default
        $tname = null;


        if (Auth::user()->facebook()) :
            $accestoken = Auth::user()->facebook()->token;
            $data = $this->getPages($accestoken);
            $this->page_data = $data['data'];
            $data = $data['data'];
        endif;

        if (Auth::user()->twitter()) :
            $tw_token = json_decode(Auth::user()->twitter()->token);
            Session::put('tw_screen_name', $tw_token->screen_name);
            $tw_user = $this->getTwUserProfile();

        endif;

        if (Auth::user()->tiktok()) :
            $tiktok = Auth::user()->tiktok();
            $ttoken = $tiktok->token;
            $user_data = json_decode($tiktok->user_social_id);
            $open_id = $user_data->open_id;
            $url = 'https://open-api.tiktok.com/oauth/userinfo/';
            $response = Http::get($url, [
                'open_id' => $open_id,
                'access_token' => $ttoken,
            ]);

            $response = $response->object();
            //dd($response);
            $tname = $response->data->display_name;

        endif;



        return view('users.content.add-event', compact('P_plans', 'tw_user', 'data', 'tname'));
    }

    public function events()
    {


        $events = Event::all()->take(8);

        /**
         * 
         * Location should have all the venue as drop down
         */
        $locations = [];
        $location = Venue::all();
        foreach ($location as $key => $value) {
            $locations[] = $value['venue_name'];
        }

        return view('users.content.events', compact('events', 'locations'));
    }
    public function add_event(Request $request)
    {

        //dd($request->file('cover_img'));

        $request->validate([
            'ename' => 'required',
            'e_descrip' => 'required|max:1000',
            'cover_img' => 'required',
            'plan' => 'required',
            'location' => 'required',
            'c' => 'required',
            // 'h_tag' => 'required',
            'm_dap_wall' => 'required',
            'wall_bg_img' => 'required',
            's_date' => 'required',
            's_time' => 'required',
            'e_date' => 'required',
            'e_time' => 'required',

        ]);




        $event = new Event();
        $event->event_name = $request->ename;
        $event->location = $request->location;
        if ($request->hasFile('cover_img')) {
            $coverImagename = $request->file('cover_img');
            $coverImagename = str_replace(' ', '', time() . '-' . $coverImagename->getClientOriginalName());

            $request->cover_img->move(public_path("Users/EventImages"), $coverImagename);

            $event->c_image = $coverImagename;
        }
        if ($request->hasFile('wall_bg_img')) {
            $bgImagename = $request->file('wall_bg_img');
            $bgImagename = str_replace(' ', '', time() . '-' . $bgImagename->getClientOriginalName());

            $request->wall_bg_img->move(public_path("Users/EventImages"), $bgImagename);

            $event->wall_bg_image = $bgImagename;
        }


        $event->e_description = $request->e_descrip;
        $event->hashtag = $request->h_tag;
        $event->approve_htag = $request->app_htag;
        $event->wall_location_msg = $request->m_dap_wall;
        $event->start_date = $request->s_date;
        $event->start_time = $request->s_time;
        $event->end_date = $request->e_date;
        $event->end_time = $request->e_time;
        $event->created_by = Auth::user()->id;
        $event->save();
        $this->add_event_social_posts($event->id, $request);
        $p = Payment_Plans::where('id', $request->plan)->first();
        $odr = new Order();
        $odr->order_type = "event";
        $odr->order_status = "Pending";
        $odr->account_type = $p->name;
        $odr->event_id = $event->id;
        $odr->user_id = Auth::user()->id;
        $odr->total_payment = $p->price;
        $odr->payment_plan_id = $request->plan;
        $odr->save();
        User::where('id', Auth::user()->id)->update(['account_type' => $p->name]);
        $user = User::whereHas(
            'roles',
            function ($q) {
                $q->where('name', 'superadministrator');
            }
        )->get();

        if ($p->price > 0) {
            /**
             * 
             * Create Checkout Request
             * 
             */


            try {
                # Create Connection 
                $client = new SquareClient([
                    'accessToken' => env('SQUARE_SANDBOX_TOKEN'),
                    'environment' => Environment::SANDBOX,
                ]);
                # Setting Params
                $checkoutApi = $client->getCheckoutApi();

                $locationId = env('SQUARE_SANDBOX_LOCATION_ID');
                # Unique Key for Transection
                $body_idempotencyKey = "EV-" . sprintf("%04d", $event->id);
                $body_order = new CreateOrderRequest;
                $body_order_order_locationId = $locationId;
                $body_order->setOrder(new SOrder(
                    $body_order_order_locationId
                ));
                # Setting Reference ID
                $body_order->getOrder()->setReferenceId('reference_id');
                $body_order->getOrder()->setSource(new OrderSource);
                $body_order->getOrder()->getSource()->setName('name8');
                $body_order->getOrder()->setCustomerId(Auth::user()->id);
                $body_order_order_lineItems = [];

                $body_order_order_lineItems_0_quantity = '1';
                $body_order_order_lineItems[0] = new OrderLineItem(
                    $body_order_order_lineItems_0_quantity
                );
                $body_order_order_lineItems[0]->setUid($p->id);
                $body_order_order_lineItems[0]->setName($p->name);
                $body_order_order_lineItems[0]->setQuantityUnit(new OrderQuantityUnit);
                $body_order_order_lineItems[0]->getQuantityUnit()->setMeasurementUnit(new MeasurementUnit);


                $body_order_order_lineItems_0_quantityUnit_measurementUnit_customUnit_name = Auth::user()->name;
                $body_order_order_lineItems_0_quantityUnit_measurementUnit_customUnit_abbreviation = '';
                $body_order_order_lineItems[0]->getQuantityUnit()->getMeasurementUnit()->setCustomUnit(new MeasurementUnitCustom(
                    $body_order_order_lineItems_0_quantityUnit_measurementUnit_customUnit_name,
                    $body_order_order_lineItems_0_quantityUnit_measurementUnit_customUnit_abbreviation
                ));

                $body_order_order_lineItems[0]->getQuantityUnit()->setPrecision(0);
                $body_order_order_lineItems[0]->setNote($p->description);

                $body_order_order_lineItems[0]->setBasePriceMoney(new Money);
                # amount is considerd to be in cents
                $body_order_order_lineItems[0]->getBasePriceMoney()->setAmount($p->price * 100);
                $body_order_order_lineItems[0]->getBasePriceMoney()->setCurrency(Currency::USD);
                $body_order->getOrder()->setLineItems($body_order_order_lineItems);

                $body_order->setIdempotencyKey($body_idempotencyKey);
                $body = new CreateCheckoutRequest(
                    $body_idempotencyKey,
                    $body_order
                );

                // $body->setAskForShippingAddress(false);
                $body->setMerchantSupportEmail('admin@dapsocially.com');
                $body->setPrePopulateBuyerEmail(Auth::user()->email);
                $body->setRedirectUrl('https://dapsocially.com/payment/confirm');
                $body_additionalRecipients = [];

                $body->setAdditionalRecipients($body_additionalRecipients);

                // var_dump($body);
                // die('I am here !');

                $apiResponse = $checkoutApi->createCheckout($locationId, $body);

                if ($apiResponse->isSuccess()) {
                    $createCheckoutResponse = $apiResponse->getResult();
                    // var_dump($createCheckoutResponse->getCheckout()->getCheckoutPageUrl());
                    // redirect();
                    // die($createCheckoutResponse->getCheckout()->getCheckoutPageUrl());
                    // echo "<script>window.open('".$createCheckoutResponse->getCheckout()->getCheckoutPageUrl()."', '_blank')</script>";
                    // $request->session->set('checkout_page_url',$createCheckoutResponse->getCheckout()->getCheckoutPageUrl());

                    $event_checkout = new Event_checkouts();
                    $event_checkout->event_id = $event->id;
                    $event_checkout->checkout_id = $createCheckoutResponse->getCheckout()->getId();
                    $event_checkout->checkout_page_url = $createCheckoutResponse->getCheckout()->getCheckoutPageUrl();
                    $event_checkout->payment_status = false;
                    $event_checkout->charges = $p->price;
                    $event_checkout->save();
                } else {
                    // $errors = $apiResponse->getErrors();
                    Session::flash('error', 'Something went wrong while processing payment !');
                    // echo 'Something went wrong while processing payment !<hr>';
                    // var_dump($errors);
                    // die();
                }
            } catch (\Throwable $th) {
                throw $th;
            }
        }


        FetchSocialWallEventPosts::dispatchAfterResponse($event);

        Session::flash('message', 'Event added succesfully');

        return back();
    }
    public function add_event_social_posts($event_id, Request $request)
    {

        $count = count($request->c);

        $counter = 0;
        for ($i = 0; $i < $count; $i++) {
            if ($request->c[$i] == 'facebook') {
                foreach ($request->fb_page as $fb) {
                    $posts = new Event_Social_Post();
                    $posts->platform = 'facebook';
                    $posts->page_name = $fb;
                    $posts->event_id = $event_id;
                    $posts->save();
                }

                $attach_acc = Attached_Account::where('user_id', Auth::user()->id)->where('verified_acc', 'facebook')->first();
                $accestoken = $attach_acc->token;
                $data = $this->getPages($accestoken);
                $data = $data['data'];

                foreach ($data as $page) {

                    Event_Social_Post::where('event_id', $event_id)->where('platform', 'facebook')->update(['page_id' => $page['id']]);
                }
            }
            if ($request->c[$i] == 'insta') {
                $posts = new Event_Social_Post();
                $posts->platform = $request->c[$i];
                $posts->page_name = $request->inp[1];
                $posts->event_id = $event_id;
                $posts->save();
            }
            if ($request->c[$i] == 'twitter') {
                $posts = new Event_Social_Post();
                $posts->platform = $request->c[$i];
                $posts->page_name = $request->tw_page;
                $posts->event_id = $event_id;
                $posts->save();
            }
            if ($request->c[$i] == 'tiktok') {
                $posts = new Event_Social_Post();
                $posts->platform = 'tiktok';
                $posts->page_name = $request->tt_page;
                $posts->event_id = $event_id;
                $posts->save();
            }
        }
    }
    public function filter_location(Request $request)
    {
        if ($request->ajax()) {
            $locations = Location::where('city', $request->q)->get();
            $loc = [];
            foreach ($locations as $location) {
                if (Arr::has($loc, $location->address)) {
                } else {
                    $loc = Arr::add($loc, $location->address, $location->address);
                }
            }
            $locations = $loc;
            $data = '';
            foreach ($locations as $add) {
                $data .= '<option value="' . $add . '">' . $add . '</option>';
            }
            echo json_encode($data);
        }
    }

    public function load_more_events()
    {

        $events = Event::all();
        $locations = Location::all();
        $loc = [];
        foreach ($locations as $location) {
            if (Arr::has($loc, $location->address)) {
            } else {
                $loc = Arr::add($loc, $location->address, $location->address);
            }
        }
        $locations = $loc;
        $locationss = Location::all();
        $loc = [];
        foreach ($locationss as $location) {
            if (Arr::has($loc, $location->city)) {
            } else {
                $loc = Arr::add($loc, $location->city, $location->city);
            }
        }

        $load_more = false;

        return view('users.content.events', compact('events', 'locations', 'loc','load_more'));
    }
    public function my_events()
    {

        $locations = Location::all();
        $loc = [];
        foreach ($locations as $location) {
            if (Arr::has($loc, $location->address)) {
            } else {
                $loc = Arr::add($loc, $location->address, $location->address);
            }
        }
        $locations = $loc;
        $events = Event::where('created_by', '=', Auth::user()->id)->take(10)->get();
        $locationss = Location::all();
        $loc = [];
        foreach ($locationss as $location) {
            if (Arr::has($loc, $location->city)) {
            } else {
                $loc = Arr::add($loc, $location->city, $location->city);
            }
        }
        return view('users.content.myevents', compact('locations', 'events', 'loc'));
    }
    public function load_my_events()
    {
        $events = Event::where('created_by', '=', Auth::user()->id)->get();
        $locations = Location::all();
        $loc = [];
        foreach ($locations as $location) {
            if (Arr::has($loc, $location->address)) {
            } else {
                $loc = Arr::add($loc, $location->address, $location->address);
            }
        }
        $locations = $loc;
        $locationss = Location::all();
        $loc = [];
        foreach ($locationss as $location) {
            if (Arr::has($loc, $location->city)) {
            } else {
                $loc = Arr::add($loc, $location->city, $location->city);
            }
        }
        return view('users.content.myevents', compact('events', 'locations', 'loc'));
    }

    public function search_my_Event(Request $request)
    {
        $events = [];

        if (!is_null($request->keyword) && !is_null($request->location)) {
            $events = Event::where('created_by', '=', Auth::user()->id)->where('hashtag', '=', $request->keyword)->where('location', '=', $request->location)->get();
        } elseif (is_null($request->keyword) && !is_null($request->location)) {
            $events = Event::where('created_by', '=', Auth::user()->id)->where('location', '=', $request->location)->get();
        }

        $load_more_events = (count($events) > 0) ? true : false;

        return view('users.content.myevents', compact('events', 'load_more_events'));
    }

    public function delete_myevent(Event $event)
    {
        $del = Event::find($event->id);
        if (!is_null(public_path('Users/EventImages/' . $event->c_image))) {
            File::delete(public_path('Users/EventImages/' . $event->c_image));
        }
        if (!is_null(public_path('Users/EventImages/' . $event->wall_bg_image))) {
            File::delete(public_path('Users/EventImages/' . $event->wall_bg_image));
        }
        $vTags = Collect_Event_Htag::where('event_id', $event->id)->get();
        if (!is_null(Collect_Event_Htag::where('event_id', $event->id)->get())) {
            foreach ($vTags as $vTag) {
                $vTag->delete();
            }
        }

        if (!is_null(Event_Social_Post::where('event_id', $event->id)->get())) {
            $dat = Event_Social_Post::where('event_id', $event->id)->get();
            foreach ($dat as $dt) {
                $dt->delete();
            }
        }

        $del->delete();
        Session::flash('message', 'Event deleted succesfully succesfully');
        return back();
    }

    public function edit_event(Event $event)
    {
        $locations = Location::all();
        $event_htags = Collect_Event_Htag::where('event_id', '=', $event->id)->get();
        $odr = Order::where('event_id', $event->id)->first();

        $payment_details = Payment_Plans::where('id', $odr->payment_plan_id)->first();
        $P_plans = Payment_Plans::all();
        $posts = Event_Social_Post::where('event_id', $event->id)->get();

        $data = [];
        $tw_user = null;
        if (Auth::user()->facebook()) :
            $accestoken = Auth::user()->facebook()->token;
            $data = $this->getPages($accestoken);
            $this->page_data = $data['data'];
            $data = $data['data'];
        endif;

        return view('users.content.editevents', compact('event', 'event_htags', 'locations', 'payment_details', 'P_plans', 'posts', 'data'));
    }

    public function update_event(Request $request, Event $event)
    {



        $request->validate([
            'ename' => 'required',
            'e_descrip' => 'required',
            'plan' => 'required',
            // 'country' => 'required',
            'location' => 'required',
            // 'locality'=>'required',
            // 'state'=>'required',
            // 'h_tag'=>'required',
            'm_dap_wall' => 'required',
            'c' => 'required',
            's_date' => 'required',
            's_time' => 'required',
            'e_date' => 'required',

            'e_time' => 'required',

            //    'h_tags'=>'required',
            //    'c_posts'=>'sometimes',
            //    'p_fb'=>'required_with:c_posts,on'
        ]);

        if ($request->hasFile('cover_img')) {
            $coverImagename = $request->file('cover_img');
            $coverImagename = str_replace(' ', '', time() . '-' . $coverImagename->getClientOriginalName());
            File::delete(public_path('Users/EventImages/' . $event->c_image));

            $request->cover_img->move(public_path("Users/EventImages"), $coverImagename);

            Event::where('id', $event->id)->update([
                'c_image' => $coverImagename, 'event_name' => $request->ename, 'e_description' => $request->e_descrip, 'hashtag' => $request->h_tag, 'approve_htag' => $request->app_htag,
                'start_time' => $request->s_time, 'start_date' => $request->s_date, 'end_time' => $request->e_time, 'end_date' => $request->e_date, 'created_by' => Auth::user()->id, 'location' => $request->location
            ]);
        }
        if ($request->hasFile('wall_bg_img')) {
            $coverImagename = $request->file('wall_bg_img');
            $coverImagename = str_replace(' ', '', time() . '-' . $coverImagename->getClientOriginalName());
            File::delete(public_path('venues/EventImages/' . $event->wall_bg_img));
            $request->wall_bg_img->move(public_path("Users/EventImages"), $coverImagename);

            Event::where('id', $event->id)->update([
                'wall_bg_image' => $coverImagename, 'event_name' => $request->ename, 'e_description' => $request->e_descrip, 'hashtag' => $request->h_tag, 'approve_htag' => $request->app_htag,
                'start_time' => $request->s_time, 'start_date' => $request->s_date, 'end_time' => $request->e_time, 'end_date' => $request->e_date, 'created_by' => Auth::user()->id, 'location' => $request->location
            ]);
        }
        $vTags = Collect_Event_Htag::where('event_id', $event->id)->get();

        foreach ($vTags as $vTag) {

            $vTag->delete();
        }
        $Posts = Event_Social_Post::where('event_id', $event->id)->get();

        foreach ($Posts as $Post) {

            $Post->delete();
        }

        // var_dump($request);

        $this->update_event_social_posts($event->id, $request);
        foreach ($request->h_tags as $h_tag) {
            $hashtag = new Collect_Event_Htag();
            $hashtag->account_name = $h_tag;
            $hashtag->event_id = $event->id;
            $hashtag->save();
        }
        $plans = Payment_Plans::where('id', $request->plan)->first();
        Order::where('event_id', $event->id)->update(['account_type' => $plans->name, 'payment_plan_id' => $request->plan, 'total_payment' => $plans->price]);
        Event::where('id', $event->id)->update([
            'event_name' => $request->ename, 'e_description' => $request->e_descrip, 'hashtag' => $request->h_tag, 'approve_htag' => $request->app_htag,
            'wall_location_msg' => $request->m_dap_wall,
            'start_time' => $request->s_time, 'start_date' => $request->s_date, 'end_time' => $request->e_time, 'end_date' => $request->e_date, 'created_by' => Auth::user()->id, 'location' => $request->location
        ]);

        FetchPostsUpdateEvent::dispatchAfterResponse($event);
        Session::flash('message', 'Event updated  succesfully');
        return back();
        // if(!is_null($request->longitude && $request->latitude))
        // {

        //     Location::where('id',$event->location_id)->update(['country'=>$request->country,'state'=>$request->state,'city'=>$request->locality,'address'=>$request->loc_address,'lng'=>$request->longitude,'lat'=>$request->latitude]);
        // }
        // else{
        //     Location::where('id',$event->location_id)->update(['country'=>$request->country,'state'=>$request->state,'city'=>$request->locality,'address'=>$request->loc_address]);
        // }




    }

    public function update_event_social_posts($event_id, Request $request)
    {
        $count = count($request->c);

        for ($i = 0; $i < $count; $i++) {

            $post = Event_Social_Post::updateOrCreate(
                ['event_id' => $event_id, 'platform' => $request->c[$i]],
                ['page_name' => $request->inp[$i]]
            );
        }

        return $post;
    }

    public function getTwUserProfile()
    {
        $tw_attach_acc = json_decode(Auth::user()->twitter()->token);
        $screen_name = $tw_attach_acc->screen_name;

        //Set user credentials
        $twitter = Twitter::usingCredentials($tw_attach_acc->oauth_token, $tw_attach_acc->oauth_token_secret);
        $user = $twitter->getUsers(['screen_name' => $screen_name]);
        return $user;
    }
    public function getPages($accestoken)
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
                '/me/accounts',
                $accestoken
            );
        } catch (FacebookResponseException $e) {
            dd('Graph returned an error: ' . $e->getMessage());
            exit;
        } catch (FacebookSDKException $e) {
            dd('Facebook SDK returned an error: ' . $e->getMessage());
            exit;
        }
        return $response->getDecodedBody();

        // // $graphNode = $response->getDecodedBody();
        // $graphNode = $response->getGraphEdge();
        // dd($graphNode);

    }
    public function show_posts(Event $event)
    {

        // $attach_acc=Attached_Account::where('user_id',$event->created_by)->where('verified_acc','facebook')->first();
        // $accesstoken=$attach_acc->token;
        // $event_post=Event_Social_Post::where('event_id',$event->id)->first();
        // $data=$this->getPost($accesstoken,$event_post->page_id);
        // $this->page_data=$data['data'];
        // $posts=$data['data'];

        // //Get twitter data
        // $tw_attach_acc=Attached_Account::where('user_id',$event->created_by)->where('verified_acc','twitter')->first();
        // //$token = json_decode(Auth::user()->twitter()->token);
        // $tw_attach_acc = json_decode($tw_attach_acc->token);
        // $screen_name = $tw_attach_acc->screen_name;

        // //Set user credentials
        // $twitter = Twitter::usingCredentials($tw_attach_acc->oauth_token,$tw_attach_acc->oauth_token_secret);
        // $user_tweets  = $twitter->getUserTimeline(['count'=>'5','screen_name'=>$screen_name]);

        $posts = E_social_wall::where('event_id', $event->id)->get();



        return view('users.content.social-wall', compact('posts', 'event'));
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

        // // $graphNode = $response->getDecodedBody();
        // $graphNode = $response->getGraphEdge();
        // dd($graphNode);

    }


    
}
