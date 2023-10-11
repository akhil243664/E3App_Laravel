<?php

namespace App\Http\Controllers\Api;

use App\CentralLogics\Helpers;
use App\Http\Controllers\Controller;
use App\Models\BusinessSetting;
use App\Models\AdNetwork;
use App\Models\User;
use App\Models\Click;
use App\Models\Currency;
use App\Models\DefaultLanguage;
use App\Models\CountrySelection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Country;
use App\Models\Demoimage;

class ConfigController extends Controller
{

    public function configuration(Request $request)
    {
		$countriedds=Country::first();
        $country_slug= $request->header('countryslug')??$countriedds->slug;
	
		$cc= Country::where('slug', $country_slug)->first();
		if($cc){
		      $phonecode=$cc->phone_code;
			$countryname=$cc->country_name;
			$country_code=$cc->country_code;
			}else{
			$phonecode=$countriedds->phone_code;
			$countryname=$countriedds->country_name;
			$country_code=$countriedds->country_code;
		}
		$countrysel=CountrySelection::first();
		$chck=BusinessSetting::where(['key' => 'currency'])->where('country_slug', $country_slug)->first()->value;
		$curren=Currency::where('currency_code',$chck)->first();
		$langg=DefaultLanguage::select('languageName','languageCode')->where('selected',1)->get();
		$country=Country::where('status',1)->get();
		$demoimage=Demoimage::first();
		
        return response()->json([
			'admob' => AdNetwork::where(['key' => 'admob'])->where('country_slug', $country_slug)->first()->value,
			'facebook_ad' => AdNetwork::where(['key' => 'facebookad'])->where('country_slug', $country_slug)->first()->value,
            'business_name' => BusinessSetting::where(['key' => 'business_name'])->where('country_slug', $country_slug)->first()->value,
			'per_order_refer_percentage' => BusinessSetting::where(['key' => 'per_order_refer_percentage'])->where('country_slug', $country_slug)->first()->value,
			'signup_referrer_earning' => BusinessSetting::where(['key' => 'signup_refer'])->where('country_slug', $country_slug)->first()->value,
            'logo' => BusinessSetting::where(['key' => 'logo'])->where('country_slug', $country_slug)->first()->value,
            'icon' => BusinessSetting::where(['key' => 'icon'])->where('country_slug', $country_slug)->first()->value,
			'minimum_redeem_value' => BusinessSetting::where(['key' => 'minimum_redeem'])->where('country_slug', $country_slug)->first()->value,
			'phone_code' => '+'.$phonecode,
			'country_code' =>  $country_code,
			'country' =>  $countryname,
			'currency' => $curren->currency_symbol,
			 'languages'=> $langg,
			'countries'=>$country,
            'countryselection'=>$countrysel->active,
            'dummy_image'=>$demoimage->image,
            'base_urls' => [
				'order_image_url' => asset('storage/app/public/order'),
				'notification_image_url' => asset('storage/app/public/notification'),
				'faq_image_url' => asset('storage/app/public/faq'),
                'offer_image_url' => asset('storage/app/public/offer'),
                'partner_image_url' => asset('storage/app/public/partner'),
				'banner_image_url' => asset('storage/app/public/banner'),
                'user_image_url' => asset('storage/app/public/user'),
                'category_image_url' => asset('storage/app/public/category'),
                'business_logo_url' => asset('storage/app/public/info'),
				'coupon_banner_url' => asset('storage/app/public/coupon'),
                'product_image_url' => asset('storage/app/public/product'),
                'product_site_url' => asset('storage/app/public/partner'),

            ]
        ]);
    }

   public function update_profile(Request $request)
    { 
	   $countriedds=Country::first();
        $country_slug= $request->header('countryslug')??$countriedds->slug;
	   
        $validator = Validator::make($request->all(), [
			'user_id'=>'required',
            'name' => 'required',
            'email' => 'required',
			'phone' => 'required',
        ], [
			'user_id.required' => 'user_id is required!',
            'name.required' => 'Name is required!',
            'email.required' => 'Email is required!',
			'phone.required' => 'Phone is required!',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }
	   $users=User::where('email',$request->email)->where('id','!=',$request->user_id)->first();
	   if($users){
		   return response()->json(['status'=>0, 'message' => 'email already exists with other account'], 403);
	   }
        $user=User::where('id',$request->user_id)->first();
        $image = $request->file('user_profile');
  
        if ($request->has('user_profile')) {
            $imageName = Helpers::update('user/', $user->image, 'png', $request->file('user_profile'));
        } else {
            $imageName = $user->image;
        }

        if ($request['password'] != null && strlen($request['password']) > 5) {
            $pass = bcrypt($request['password']);
        } else {
            $pass = $user->password;
        }

        $userDetails = [
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'image' => $imageName,
            'password' => $pass,
            'country_slug'=>$country_slug,
            'updated_at' => now()
        ];

         $uu = User::where(['id' => $request->user_id])->update($userDetails);
	   $user=User::where(['id' => $request->user_id])->first();
        if($uu){
        return response()->json(['status'=>1,'message' => 'successfully_updated' , 'data'=>$user], 200);
		}else{
			return response()->json(['status'=>0, 'message' => 'nothing_to_update'], 200);
		}
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
	
	 public function about_us(Request $request)
    {
       $countriedds=Country::first();
        $country_slug= $request->header('countryslug');
		$countcheck=Country::where('slug',$country_slug)->first();
		if(!$countcheck){
			$arr = array('status'=>1, 'data'=>NULL);
            return response()->json($arr);
		}
	   $about_us= BusinessSetting::where(['key' => 'about_us'])->where('country_slug',$country_slug)->first()->value??NULL;
       $arr = array('status'=>1, 'data'=>$about_us);
        return response()->json($arr);
    }
	
	 public function privacy_policy(Request $request)
    {
        $countriedds=Country::first();
       $country_slug= $request->header('countryslug');
		$countcheck=Country::where('slug',$country_slug)->first();
		if(!$countcheck){
			$arr = array('status'=>1, 'data'=>NULL);
            return response()->json($arr);
		}
         $about_us= BusinessSetting::where(['key' => 'privacy_policy'])->where('country_slug',$country_slug)->first()->value??NULL;

       $arr = array('status'=>1, 'data'=>$about_us);
        return response()->json($arr);
    }
	
	
	 public function deleteclicks(Request $request)
    {
		 
        $validator = Validator::make($request->all(), [
			'user_id'=>'required'
        ], [
			'user_id.required' => 'user_id is required!'
        ]);
     

      $check_user=User::where('id', $request->user_id)->first();
        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }
		 $user_id=$request->user_id;
		 $clicks= Click::where('created_at', '<=', Carbon::now()->subDays(10)->toDateTimeString())
			 ->where('user_id',$user_id)->where('country_slug',$check_user->country_slug)->delete();
		
        if($clicks){
        return response()->json(['status'=>1,'message' => 'successfully deleted clicks older then 10 days'], 200);
		}else{
			return response()->json(['status'=>1, 'message' => 'nothing to delete'], 200);
		}
    }
	
	
	
	 public function deleteallclicks(Request $request)
    {
		 
        $validator = Validator::make($request->all(), [
			'user_id'=>'required'
        ], [
			'user_id.required' => 'user_id is required!'
        ]);
         $check_user=User::where('id', $request->user_id)->first();
        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }
		 $user_id=$request->user_id;
		 $clicks= Click::where('user_id',$user_id)->where('country_slug',$check_user->country_slug)->delete();
		
        if($clicks){
        return response()->json(['status'=>1,'message' => 'successfully deleted clicks older then 10 days'], 200);
		}else{
			return response()->json(['status'=>1, 'message' => 'nothing to delete'], 200);
		}
    }

  


   public function country_list()
    {
         $country_list= Country::where('status',1)->get();
        
       $arr = array('status'=>1, 'data'=>$country_list);
        return response()->json($arr);
    }


     public function language_list()
    {
         $country_list= DefaultLanguage::where('selected',1)->get();
        
       $arr = array('status'=>1, 'data'=>$country_list);
        return response()->json($arr);
    }



     public function update_country(Request $request)
    {
          $validator = Validator::make($request->all(), [
            'country_name'=>'required'
        ], [
             'country_name.required' => 'country slug is required!'
        ]);


        $country_name=ucwords($request->country_name);
     
        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }
        $getcountry= Country::where('country_name',$country_name)->first();
        if($request->user_id != NULL){
            $user_id=$request->user_id;
            $clicks= User::where('id',$user_id)->update(['country_slug'=>$getcountry->slug]);
            if($clicks){
            return response()->json(['status'=>1,'message' => 'country changed successfully','slug'=>$getcountry->slug], 200);
            }else{
                return response()->json(['status'=>0, 'message' => 'something went wrong, Please try again later'], 200);
            }
        }else{
             return response()->json(['status'=>1,'message' => 'country changed successfully','slug'=>$getcountry->slug], 200);
        }

    }


    
}
