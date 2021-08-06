<?php

namespace App\Http\Controllers\TestingApi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use SquareConnect\Configuration;
use SquareConnect\ApiClient;

# New Square SDK Client
use Square\SquareClient;
use Square\Environment;
use Square\Exceptions\ApiException;
use Square\Models\CreateCustomerRequest;
use Square\Models\Order;
use Square\Models\CreateOrderRequest;
use Square\Models\OrderSource;
use Square\Models\OrderLineItem;
use Square\Models\OrderQuantityUnit;
use Square\Models\MeasurementUnit;
use Square\Models\Currency;
use Square\Models\Money;
use Square\Models\MeasurementUnitCustom;
use Square\Models\CreateCheckoutRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class SquareApiController extends Controller
{
    public function index()
    {
        return view('Apis.squarepayment');
    }


    public function __construct()
    {
        $this->middleware('auth');
    }

    public function payment_process(Request $request)
    {

        $access_token = 'EAAAEFSon5GthBYF21BdzM9IsbSvOwVhPqhNuEXZ0THjaD5Q5tOVKZgrNXTRrVl_';
        # setup authorization
        \SquareConnect\Configuration::getDefaultConfiguration()->setAccessToken($access_token);
        # create an instance of the Transaction API class
        $transactions_api = new \SquareConnect\Api\TransactionsApi();
        $location_id = 'LVTKK4KR6AXZ9';
        $nonce = $request->nonce;

        $request_body = array(
            "card_nonce" => $nonce,
            # Monetary amounts are specified in the smallest unit of the applicable currency.
            # This amount is in cents. It's also hard-coded for $1.00, which isn't very useful.
            "amount_money" => array(
                "amount" => (int) $request->amount,
                "currency" => "USD"
            ),
            # Every payment you process with the SDK must have a unique idempotency key.
            # If you're unsure whether a particular payment succeeded, you can reattempt
            # it with the same idempotency key without worrying about double charging
            # the buyer.
            "idempotency_key" => uniqid()
        );

        try {
            $result = $transactions_api->charge($location_id,  $request_body);
            // print_r($result);

            // echo '';
            if ($result['transaction']['id']) {
                echo 'Payment success!';
                echo "Transation ID: " . $result['transaction']['id'] . "";
            }
        } catch (\SquareConnect\ApiException $e) {
            echo "Exception when calling TransactionApi->charge:";
            var_dump($e->getResponseBody());
        }
    }


    function sample_process(Request $request)
    {

        $client = new SquareClient([
            'accessToken' => env('SQUARE_SANDBOX_TOKEN'),
            'environment' => Environment::SANDBOX,
        ]);


        $customersApi = $client->getCustomersApi();

        // Create customer
        $request = new CreateCustomerRequest;
        $request->setGivenName('Ameer Moavia');
        $request->setFamilyName('Ahmad');
        $request->setPhoneNumber("92-313-6602150");
        $request->setNote('A customer');

        try {
            $result = $customersApi->createCustomer($request);

            if ($result->isSuccess()) {
                print_r($result->getResult()->getCustomer());
            } else {
                print_r($result->getErrors());
            }
        } catch (ApiException $e) {
            print_r("Recieved error while calling Square: " . $e->getMessage());
        }
    }

    function list_customers(Request $request)
    {

        $client = new SquareClient([
            'accessToken' => env('SQUARE_SANDBOX_TOKEN'),
            'environment' => Environment::SANDBOX,
        ]);

        $customersApi = $client->getCustomersApi();

        $apiResponse = $customersApi->listCustomers();

        if ($apiResponse->isSuccess()) {
            $listCustomersResponse = $apiResponse->getResult();
            // var_dump($listCustomersResponse->getCustomers);
            foreach ($listCustomersResponse->getCustomers() as  $value) {
                //     # code...
                // var_dump($value);
                echo "<h1>{$value->getId()} - {$value->getGivenName()}</h1>";
            }
        } else {
            $errors = $apiResponse->getErrors();
        }
    }


    function checkout(Request $request)
    {
        $client = new SquareClient([
            'accessToken' => env('SQUARE_SANDBOX_TOKEN'),
            'environment' => Environment::SANDBOX,
        ]);

        $checkoutApi = $client->getCheckoutApi();

        $locationId = env('SQUARE_SANDBOX_LOCATION_ID');
        $body_idempotencyKey = uniqid();
        $body_order = new CreateOrderRequest;
        $body_order_order_locationId = $locationId;
        $body_order->setOrder(new Order(
            $body_order_order_locationId
        ));
        // $body_order->getOrder()->setId('id6');
        $body_order->getOrder()->setReferenceId('reference_id');
        $body_order->getOrder()->setSource(new OrderSource);
        $body_order->getOrder()->getSource()->setName('name8');
        $body_order->getOrder()->setCustomerId('customer_id');
        $body_order_order_lineItems = [];

        $body_order_order_lineItems_0_quantity = '2';
        $body_order_order_lineItems[0] = new OrderLineItem(
            $body_order_order_lineItems_0_quantity
        );
        $body_order_order_lineItems[0]->setUid('uid3');
        $body_order_order_lineItems[0]->setName('Printed T Shirt');
        $body_order_order_lineItems[0]->setQuantityUnit(new OrderQuantityUnit);
        $body_order_order_lineItems[0]->getQuantityUnit()->setMeasurementUnit(new MeasurementUnit);


        $body_order_order_lineItems_0_quantityUnit_measurementUnit_customUnit_name = 'name1';
        $body_order_order_lineItems_0_quantityUnit_measurementUnit_customUnit_abbreviation = 'abbreviation3';
        $body_order_order_lineItems[0]->getQuantityUnit()->getMeasurementUnit()->setCustomUnit(new MeasurementUnitCustom(
            $body_order_order_lineItems_0_quantityUnit_measurementUnit_customUnit_name,
            $body_order_order_lineItems_0_quantityUnit_measurementUnit_customUnit_abbreviation
        ));

        $body_order_order_lineItems[0]->getQuantityUnit()->setPrecision(2);
        // $body_order_order_lineItems[0]->getQuantityUnit()->setCatalogVersion(131);
        $body_order_order_lineItems[0]->setNote('note1');
        // $body_order_order_lineItems[0]->setCatalogObjectId('catalog_object_id3');

        $body_order_order_lineItems[0]->setBasePriceMoney(new Money);
        $body_order_order_lineItems[0]->getBasePriceMoney()->setAmount(1500);
        $body_order_order_lineItems[0]->getBasePriceMoney()->setCurrency(Currency::USD);
        $body_order->getOrder()->setLineItems($body_order_order_lineItems);

        $body_order->setIdempotencyKey($body_idempotencyKey);
        $body = new CreateCheckoutRequest(
            $body_idempotencyKey,
            $body_order
        );

        // $body->setAskForShippingAddress(false);
        $body->setMerchantSupportEmail('admin@dapsocially.com');
        $body->setPrePopulateBuyerEmail('moavia@virtuenetz.com');
        // $body->setPrePopulateShippingAddress(new Address);
        // $body->getPrePopulateShippingAddress()->setAddressLine1('1455 Market St.');
        // $body->getPrePopulateShippingAddress()->setAddressLine2('Suite 600');
        // $body->getPrePopulateShippingAddress()->setAddressLine3('address_line_36');
        // $body->getPrePopulateShippingAddress()->setLocality('San Francisco');
        // $body->getPrePopulateShippingAddress()->setSublocality('sublocality0');
        // $body->getPrePopulateShippingAddress()->setAdministrativeDistrictLevel1('CA');
        // $body->getPrePopulateShippingAddress()->setPostalCode('94103');
        // $body->getPrePopulateShippingAddress()->setCountry(Country::US);
        // $body->getPrePopulateShippingAddress()->setFirstName('Jane');
        // $body->getPrePopulateShippingAddress()->setLastName('Doe');
        $body->setRedirectUrl('https://google.com');
        $body_additionalRecipients = [];

        $body->setAdditionalRecipients($body_additionalRecipients);

        // var_dump($body);

        $apiResponse = $checkoutApi->createCheckout($locationId, $body);

        if ($apiResponse->isSuccess()) {
            $createCheckoutResponse = $apiResponse->getResult();
            var_dump($createCheckoutResponse->getCheckout()->getCheckoutPageUrl());
        } else {
            $errors = $apiResponse->getErrors();
            echo 'Something Went Wrong !<hr>';
            var_dump($errors);
        }
    }


    function events(Request $request)
    {
        /**
         * Listing all events/payments here
         */

        $events = DB::table('event_checkouts')
            ->select('events.event_name', 'events.start_date', 'events.end_date', 'event_checkouts.*')
            ->join('events', 'events.id', '=', 'event_checkouts.event_id')
            ->where('created_by', '=', Auth::user()->id)
            ->get();

        return view('users.content.payments', compact('events'));
    }

    function confirm(Request $req)
    {

        try {
            DB::table('event_checkouts')->where(['checkout_id' => $req->input('checkoutId')])
                ->update([
                    'transection_id' => $req->input('transactionId'),
                    'payment_status' => 1
                ]);

            return redirect(route('payment.events'));
        } catch (\Throwable $th) {
            //throw $th;
            return redirect(route('payment.events'));
        }
    }
}
