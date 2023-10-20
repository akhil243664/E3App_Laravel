<?php

namespace App\Http\Controllers\Api;

use App\CentralLogics\Helpers;
use App\Http\Controllers\Controller;
use App\Models\BusinessSetting;
use App\Models\User;
use App\Models\Partner;
use App\Models\Offer;
use App\Models\Country;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AdsController extends Controller
{

    public function getadvs(Request $request)
    {
		$offset=1;
		$countriedds=Country::first();
         $country_slug= $request->header('countryslug') ?? 'in';;
		$countcheck=Country::where('slug',$country_slug)->first();
		if(!$countcheck){
			$arr = array('status'=>1, 'data'=>[]);
            return response()->json($arr);
		}
		$partners=Partner::active()->with('offers')->where('country_slug',$country_slug)->orWhere('country_name',$country_slug)->paginate(15, ['*'], 'page', $offset);
		
        return response()->json([$partners->data]);
    }

	  public function getbannerads(Request $request)
    {
		  $offset=1;
		 $countriedds=Country::first();
         $country_slug= $request->header('countryslug') ?? 'in';;
		$countcheck=Country::where('slug',$country_slug)->first();
		if(!$countcheck){
			$arr = array('status'=>1, 'data'=>[]);
            return response()->json($arr);
		}
		$partners=Offer::active()->with('partner')->where('type','banner')->where('country_slug',$country_slug)->orWhere('country_name',$country_slug)->paginate(15, ['*'], 'page', $offset);
		
        return response()->json($partners->items());
    }
	  public function getvideoads(Request $request)
    {
		  $offset=1;
    	$countriedds=Country::first();
       $country_slug= $request->header('countryslug') ?? 'in';;
		$countcheck=Country::where('slug',$country_slug)->first();
		if(!$countcheck){
			$arr = array('status'=>1, 'data'=>[]);
            return response()->json($arr);
		}
		$partners=Offer::active()->with('partner')->where('type','video')->where('country_slug',$country_slug)->orWhere('country_name',$country_slug)->paginate(15, ['*'], 'page', $offset);
		
        return response()->json($partners->items());
    }
	  public function getimageads(Request $request)
    {
		  $offset=1;
		 $countriedds=Country::first();
      $country_slug= $request->header('countryslug') ?? 'in';;
		$countcheck=Country::where('slug',$country_slug)->first();
		if(!$countcheck){
			$arr = array('status'=>1, 'data'=>[]);
            return response()->json($arr);
		}
		$partners=Offer::active()->with('partner')->where('type','image')->where('country_slug',$country_slug)->orWhere('country_name',$country_slug)->paginate(15, ['*'], 'page', $offset);
		
       return response()->json($partners->items());
    }
    
	 
}
