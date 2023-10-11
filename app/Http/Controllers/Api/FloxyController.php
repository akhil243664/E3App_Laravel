<?php

namespace App\Http\Controllers\Api;

use App\CentralLogics\Helpers;
use App\Http\Controllers\Controller;
use App\Models\BusinessSetting;
use App\Models\AdNetwork;
use App\Models\User;
use App\Models\Click;
use App\Models\Currency;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Country;
use GuzzleHttp\Client;

class FloxyController extends Controller
{

    public function floxypay(Request $request)
    {

      $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.floxypay.com/v2/withdrawal/upi',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
           CURLOPT_POSTFIELDS => http_build_query([
                  "name"=>"dee",
                  "mobile"=>"7895811769",
                  "amount"=>"100.00",
                  "upi"=>"8476978906@ybl",
                  "note"=>"dsdw",
                  "orderid"=>"CDGGD53d6723"
            ]),
        
          CURLOPT_HTTPHEADER => array(
            'x-key: flox-b25ad5d06346043a',
            'x-secret: flox-ba9b8298bea834eeea1c3ba134baff79b815f70e0ebae68d116e1280c3ec8de5d7d0e0defdb8c4e5'
          ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return response()->json([json_decode($response)]);
    }



    
}
