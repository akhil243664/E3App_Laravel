<?php

namespace App\Http\Controllers\Api;

use App\CentralLogics\Helpers;
use App\Http\Controllers\Controller;
use App\Models\BusinessSetting;
use App\Models\User;
use App\Models\Partner;
use App\Models\Category;
use App\Models\CuelinkCampaign;
use App\Models\Offer;
use App\Models\Product;
use App\Models\HomeAdv;
use App\Models\Coupon;
use App\Models\Country;
use App\Models\CuelinkOffer;
use App\Models\Api_Advcampaign;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use DB;

class ProductapiController extends Controller
{

    public function getProducts(Request $request)
    {

          $countriedds=Country::first();
       $country_slug= $request->header('countryslug');
		$countcheck=Country::where('slug',$country_slug)->first();
		if(!$countcheck){
			$arr = array('status'=>1, 'data'=>[]);
            return response()->json($arr);
		}
       $products= Product::active()->with('images')->with('product_prices')->where('country_slug', $country_slug)->get();
       if(count($products)>0){
           $arr = array('status'=>1, 'data'=>$products);
           return response()->json($arr);
       }else{
           $arr = array('status'=>1, 'data'=>[]);
           return response()->json($arr);
       }
    }

	
    public function getTrendingProducts(Request $request)
    {
         $countriedds=Country::first();
      $country_slug= $request->header('countryslug');
		$countcheck=Country::where('slug',$country_slug)->first();
		if(!$countcheck){
			$arr = array('status'=>1, 'data'=>[]);
            return response()->json($arr);
		}
       $products= Product::active()->with('images')->with('product_prices')->where('country_slug', $country_slug)->where('trending',1)->get();
       if(count($products)>0){
           $arr = array('status'=>1, 'data'=>$products);
           return response()->json($arr);
       }else{
           $arr = array('status'=>1, 'data'=>[]);
           return response()->json($arr);
       }
    }
    
 
}
