<?php

namespace App\Http\Controllers\Api;

use App\CentralLogics\Helpers;
use App\Http\Controllers\Controller;
use App\Models\BusinessSetting;
use App\Models\Trending;
use App\Models\Country;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{

  
	 public function trending(Request $request)
    {
         $countriedds=Country::first();
      $country_slug= $request->header('countryslug') ?? 'in';;
		$countcheck=Country::where('slug',$country_slug)->first();
		if(!$countcheck){
			$arr = array('status'=>1, 'data'=>[]);
            return response()->json($arr);
		}
		 $trending= Trending::where('country_slug',$country_slug)->get();
		
       $arr = array('status'=>1, 'data'=>$trending);
        return response()->json($arr);
    }
	
	 public static function get_settings($name)
    {
        $config = null;
        $data = BusinessSetting::where(['key' => $name])->first();
        if (isset($data)) {
            $config = json_decode($data['value'], true);
            if (is_null($config)) {
                $config = $data['value'];
            }
        }
        return $config;
    }
	
}
