<?php

namespace App\Http\Controllers\Api;

use App\CentralLogics\Helpers;
use App\Http\Controllers\Controller;
use App\Models\BannerNotification;
use App\Models\User;
use App\Models\Country;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class  BannernotificationController extends Controller
{

    

   public function bannernotification(Request $request)
    {
	    $countriedds=Country::first();
      $country_slug= $request->header('countryslug') ?? 'in';;
		$countcheck=Country::where('slug',$country_slug)->first();
		if(!$countcheck){
			$arr = array('status'=>1, 'data'=>NULL);
            return response()->json($arr);
		}
        $banner=BannerNotification::active()->where('country_slug',$country_slug)->first();

        return response()->json(['status'=>1,'message' => 'banner notification' , 'data'=>$banner]);
		
    }
	

	 public static function get_settings($name)
    {
       $countriedds=Country::first();
      $country_slug= $request->header('countryslug') ?? 'in';;
		$countcheck=Country::where('slug',$country_slug)->first();
		if(!$countcheck){
			$arr = array('status'=>1, 'data'=>NULL);
            return response()->json($arr);
		}
        $config = null;
        $data = BusinessSetting::where(['key' => $name])->where('country_slug',$country_slug)->first();
        if (isset($data)) {
            $config = json_decode($data['value'], true);
            if (is_null($config)) {
                $config = $data['value'];
            }
        }
        return $config;
    }
	

	
}
