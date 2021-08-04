<?php

namespace App\Http\Controllers\TestingApi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use SquareConnect\Configuration;
use SquareConnect\ApiClient;

# New Square SDK Client
use Square\SquareClient;
use Square\Environment;

class SquareApiController extends Controller
{
    public function index()
    {
        return view('Apis.squarepayment');
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


    function sample_process(Request $request){

        $client = new SquareClient([
            'accessToken' => env('SQUARE_SANDBOX_TOKEN'),
            'environment' => Environment::SANDBOX,
        ]);

        $locationsApi = $client->getLocationsApi();

        $apiResponse = $locationsApi->listLocations();
        echo "<h1>Location</h1>";
        var_dump($locationsApi);
        echo "<hr><h1>Api Response</h1>";
        var_dump($apiResponse);

    }

}
