<?php

namespace App\Http\Controllers\API;

use App\Log;
use App\OtpTransaction;
use App\TempTransactionId;
use App\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Ixudra\Curl\Facades\Curl;
use Psr\Http\Message\StreamInterface;
use Webpatser\Uuid\Uuid;

class PushRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric'
        ]);

        $user = auth('api')->user();
        $request = $request->all();
        $array = [
                "servicekey" => 'e5f2ba4fad93434b80aac53be1eaf321',
                "msisdn" => $user->mobile_number,
                "serviceName" => 'CESFCOACHLAND',
                "referenceCode" => Uuid::generate()->string, // unique mal mast
                "shortCode" => '984068210',
                "contentId" => Uuid::generate()->string, // unique mal mast
                "code" => '',  // nt charge code
                "amount" => $request['amount'],
                "description" => 'request for charging'
        ];


        $client = new \GuzzleHttp\Client();
        $res = $client->post('https://31.47.36.141:10443/otp/request', ['auth' =>  ['coachland456', '9a51a663fa7c']]);
        echo $res->getStatusCode(); // 200
        return $res->getBody();



//        if ($response != false) {
//            if ($response['statusCode'] == 200){
//                OtpTransaction::create([
//                    'user_id' => $user->id,
//                    'otp_transaction_id' => $response['OTPTransactionId']
//                ]);
//                return response()->json('otp_transaction_id received.', 200);
//            }
//            return response()->json($response, $response['statusCode']);
//        }
//        else
//            return response()->json('Bad request.', 400);
    }


    public function subscribe_request(Request $request)
    {
        $request->validate([
            'msisdn' => 'required'
        ]);


        $request = $request->all();
        $array = [
            "servicekey" => 'e5f2ba4fad93434b80aac53be1eaf321',
            "msisdn" => $request['msisdn'],
            "serviceName" => 'CESFCOACHLAND',
            "referenceCode" => Uuid::generate()->string, // unique mal mast
//            "referenceCode" => 'test',
            "shortCode" => '984068210',
//            "contentId" => Uuid::generate()->string, // unique mal mast
            "contentId" => uniqid(), // unique mal mast
            "code" => 'ESFSUBCESFCOACHLAN',  // nt charge code
            "amount" => '500',
            "description" => 'tst message from IMI'
        ];


        $client1 =  new Client();
        $r = $client1->request('POST', 'https://31.47.36.141:10443/otp/request', ['auth'=>['coachland456', '9a51a663fa7c'], 'form_params' => $array, 'verify'=> false]);


        /** log */
        Log::create([
            'msisdn' => $request['msisdn'],
            'client_input' => \GuzzleHttp\json_encode($array),
            'server_response' => $r->getBody()->getContents()
        ]);
        /** end log */
        $r = \GuzzleHttp\json_decode($r->getBody());
        if ($r->statusInfo->statusCode != 200){
            return response()->json(['status' => 'trouble in request.', 'response' => $r], 500);
        }
        $response = $r->statusInfo;
        TempTransactionId::create([
            'msisdn' => $request['msisdn'],
            'otp_transaction_id' => $response->OTPTransactionId
        ]);



        return response()->json(['status' => 'otp-transaction id received.', 'response' => $r], 200);

    }







    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
