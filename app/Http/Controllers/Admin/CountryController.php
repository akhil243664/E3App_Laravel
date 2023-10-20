<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Admin;
use App\Models\Currency;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\DefaultCountry;
use DB;

class CountryController extends Controller
{

    public function list(Request $request){

     $country=Country::get();

        return view('admin.country.list',compact('country'));
    }



    public function store(Request $request){
        $request->validate([
             'country'=>'required',
            'currency' => 'required|max:100',
            'slug'=>'required|max:100|unique:countries,slug'
        ], [

            'country.required' => 'select country',
            'currency.required' => 'Currency is required!',
            'slug.required' => 'Country Slug is required!',
        ]);
        $counttry=DefaultCountry::where('id',$request->country)->first();
        $admitad= DB::table('admitad')->first();
        $cuelink= DB::table('cuelink')->first();
        $impact= DB::table('impact')->first();
       

       
$currency=Currency::where('currency_code',$request->currency)->first();
     
           

        $country = Country::create([
            'country_name'      =>   ucwords($counttry->country_name),
            'country_code'      =>  $counttry->country_code,
            'currency_code'     =>  $currency->currency_code,
            'currency_symbol'   => $currency->currency_symbol,
            'phone_code'        =>  $counttry->phone_code,
            'slug'        =>  $request->slug,
        ]); 
        if($country){

            ////ad networks////
        if($request->admitad != NULL){
           DB::table('admitad')->insert(['status'=>1,'client_id'=> $admitad->client_id,'base64code'=>$admitad->base64code,'website_id'=>$admitad->website_id,'client_secret'=>$admitad->client_secret,'country_slug'=>$request->slug,'verified'=>$admitad->verified]);
        }else{

             DB::table('admitad')->insert(['status'=>0,'client_id'=> $admitad->client_id,'base64code'=>$admitad->base64code,'website_id'=>$admitad->website_id,'client_secret'=>$admitad->client_secret,'country_slug'=>$request->slug,'verified'=>$admitad->verified]);

        }


       if($request->cuelink != NULL){
            DB::table('cuelink')->insert(['status'=>1,'apikey'=>$cuelink->apikey,'channel_id'=>$cuelink->channel_id,'country_slug'=>$request->slug,'verified'=>$cuelink->verified]);

        }else{
            DB::table('cuelink')->insert(['status'=>0,'apikey'=>$cuelink->apikey,'channel_id'=>$cuelink->channel_id,'country_slug'=>$request->slug,'verified'=>$cuelink->verified]);
            
        }

        if($request->impact != NULL){
            DB::table('impact')->insert(['status'=>1,'sid'=>$impact->sid,'token'=>$impact->token,'country_slug'=>$request->slug,'verified'=>$impact->verified]);

        }else{
            DB::table('impact')->insert(['status'=>0,'sid'=>$impact->sid,'token'=>$impact->token,'country_slug'=>$request->slug,'verified'=>$impact->verified]);
            
        }
            /////ad networks/////
        ////add settings/////
             $name= DB::table('business_settings')->where('key','business_name')->first();

             DB::table('business_settings')->Insert(['key' => 'business_name',
            'value' => $name->value,'country_slug'=>$request->slug
        ]);
       

        $default_commision= DB::table('business_settings')->where('key','default_commision')->first();
        
         DB::table('business_settings')->Insert(['key' => 'default_commision',
            'value' => $default_commision->value, 'country_slug'=>$request->slug
        ]);
        
        $logo= DB::table('business_settings')->where('key','logo')->first();
       

        DB::table('business_settings')->Insert(['key' => 'logo', 
            'value' => $logo->value, 'country_slug'=>$request->slug
        ]);

       $icon= DB::table('business_settings')->where('key','icon')->first();

        DB::table('business_settings')->Insert(['key' => 'icon', 
            'value' => $icon->value, 'country_slug'=>$request->slug
        ]);

       
       $footer_text= DB::table('business_settings')->where('key','footer_text')->first();

        DB::table('business_settings')->Insert(['key' => 'footer_text', 
            'value' => $footer_text->value, 'country_slug'=>$request->slug
        ]);
        

          $minimum_redeem= DB::table('business_settings')->where('key','minimum_redeem')->first();
          DB::table('business_settings')->Insert(['key' => 'minimum_redeem', 
            'value' => $minimum_redeem->value, 'country_slug'=>$request->slug
        ]);
        
         $privacy= DB::table('business_settings')->where('key','privacy_policy')->first();
          DB::table('business_settings')->Insert(['key' => 'privacy_policy', 
            'value' => $privacy->value, 'country_slug'=>$request->slug
        ]);

          $about_us= DB::table('business_settings')->where('key','about_us')->first();
          DB::table('business_settings')->Insert(['key' => 'about_us', 
            'value' => $about_us->value, 'country_slug'=>$request->slug
        ]);
         
          DB::table('business_settings')->Insert(['key' => 'currency', 
            'value' => $currency->currency_code, 'country_slug'=>$request->slug
        ]); 

         $cuelinks_currency= DB::table('business_settings')->where('key','cuelinks_currency')->first();
          DB::table('business_settings')->Insert(['key' => 'cuelinks_currency', 
            'value' => $cuelinks_currency->value, 'country_slug'=>$request->slug
        ]);
         

         $impact_currency= DB::table('business_settings')->where('key','impact_currency')->first();
          DB::table('business_settings')->Insert(['key' => 'impact_currency', 
            'value' => $impact_currency->value, 'country_slug'=>$request->slug
        ]);
         

         $cuelinks_rate= DB::table('business_settings')->where('key','cuelinks_rate')->first();
          DB::table('business_settings')->Insert(['key' => 'cuelinks_rate', 
            'value' => 1, 'country_slug'=>$request->slug
        ]);

          $impact_rate= DB::table('business_settings')->where('key','impact_rate')->first();
          DB::table('business_settings')->Insert(['key' => 'impact_rate', 
            'value' => 1, 'country_slug'=>$request->slug
        ]);

          $signup_refer= DB::table('business_settings')->where('key','signup_refer')->first();
          DB::table('business_settings')->Insert(['key' => 'signup_refer', 
            'value' => $signup_refer->value, 'country_slug'=>$request->slug
        ]);


          $per_order_refer_percentage= DB::table('business_settings')->where('key','per_order_refer_percentage')->first();
          DB::table('business_settings')->Insert(['key' => 'per_order_refer_percentage',
            'value' => $per_order_refer_percentage->value,'country_slug'=>$request->slug
        ]);


       /////ads settings/////

        DB::table('ad_networks')->Insert(['key' => 'admob',
            'value' => 0,
            'country_slug' => $request->slug
        ]);

        DB::table('ad_networks')->Insert(['key' => 'facebookad',
            'value' => 0,
            'country_slug' => $request->slug
        ]);



        $one=DB::table('admob_ads')->where('location',1)->first();
         DB::table('admob_ads')->Insert(['ad_id' => $one->ad_id,
            'ad_type' =>  $one->ad_type,'status'=>0
        ,'location'=>1,'platform'=>'android','country_slug' => $request->slug]);

        $two=DB::table('admob_ads')->where('location',2)->first();
         DB::table('admob_ads')->Insert(['ad_id' => $two->ad_id,
            'ad_type' =>  $two->ad_type,'status'=>0
        ,'location'=>2,'platform'=>'android','country_slug' => $request->slug]);

        $three=DB::table('admob_ads')->where('location',3)->first();
        DB::table('admob_ads')->Insert(['ad_id' => $three->ad_id,
            'ad_type' =>  $three->ad_type,'status'=>0
        ,'location'=>3,'platform'=>'android','country_slug' => $request->slug]);

        $four=DB::table('admob_ads')->where('location',4)->first();
        DB::table('admob_ads')->Insert(['ad_id' => $four->ad_id,
            'ad_type' =>  $four->ad_type,'status'=>0
        ,'location'=>4,'platform'=>'android','country_slug' => $request->slug]);
        $five=DB::table('admob_ads')->where('location',5)->first();
        DB::table('admob_ads')->Insert(['ad_id' => $five->ad_id,
            'ad_type' =>  $five->ad_type,'status'=>0
        ,'location'=>5,'platform'=>'android','country_slug' => $request->slug]);

        $zero=DB::table('admob_ads')->where('location',0)->first();
        DB::table('admob_ads')->Insert(['ad_id' => $zero->ad_id,
            'ad_type' =>  $zero->ad_type,'status'=>0
        ,'location'=>0,'platform'=>'android','clicks'=>$zero->clicks,'country_slug' => $request->slug]);

   ////facebook////
        $one=DB::table('fb_ads')->where('location',1)->first();
         DB::table('fb_ads')->Insert(['placement_id' => $one->placement_id,
            'ad_type' =>  $one->ad_type,'status'=>0
        ,'location'=>1,'platform'=>'android','country_slug' => $request->slug]);

        $two=DB::table('fb_ads')->where('location',2)->first();
         DB::table('fb_ads')->Insert(['placement_id' => $two->placement_id,
            'ad_type' =>  $two->ad_type,'status'=>0
        ,'location'=>2,'platform'=>'android','country_slug' => $request->slug]);

        $three=DB::table('fb_ads')->where('location',3)->first();
        DB::table('fb_ads')->Insert(['placement_id' => $three->placement_id,
            'ad_type' =>  $three->ad_type,'status'=>0
        ,'location'=>3,'platform'=>'android','country_slug' => $request->slug]);

        $four=DB::table('fb_ads')->where('location',4)->first();
        DB::table('fb_ads')->Insert(['placement_id' => $four->placement_id,
            'ad_type' =>  $four->ad_type,'status'=>0
       ,'location'=>4,'platform'=>'android','country_slug' => $request->slug]);
        $five=DB::table('fb_ads')->where('location',5)->first();
        DB::table('fb_ads')->Insert(['placement_id' => $five->placement_id,
            'ad_type' =>  $five->ad_type,'status'=>0
       ,'location'=>5,'platform'=>'android','country_slug' => $request->slug]);

        $zero=DB::table('fb_ads')->where('location',0)->first();
        DB::table('fb_ads')->Insert(['placement_id' => $zero->placement_id,
            'ad_type' =>  $zero->ad_type,'status'=>0
        ,'location'=>0,'platform'=>'android','clicks'=>$zero->clicks,'country_slug' => $request->slug]);


       ////ads settings/////
         
         

        /////add settings///////
            return redirect()->back()->with('success','Country Create Successfuly');
        }else{
            return redirect()->back()->with('error','Something Went wrong');
        }
    }
    public function edit(Request $request,$id){
		
        $country = Country::find($id);
		
		$currency= DB::table('business_settings')->where('key','currency')->where('country_slug',$country->slug)->first();
		
        $admitad= DB::table('admitad')->where('country_slug',$country->slug)->first();
        $cuelink= DB::table('cuelink')->where('country_slug',$country->slug)->first();
        $impact= DB::table('impact')->where('country_slug',$country->slug)->first();
        
        // dd($country,$impact,$cuelink,$admitad,$currency);
        
        return view('admin.country.edit', compact('country','admitad','cuelink','impact','currency'));
    }





     public function active_status(Request $request)
    {
        $partner = Country::find($request->id);
        $partner->status = $request->status;
        $partner->save();
         return redirect()->back()->withSuccess('country status updated');
    }


    public function update(Request $request,$id){

        $request->validate([
            'country' => 'required',
            'currency' => 'required|max:100',
            'slug' => 'required|regex:/^[a-z]{1,50}$/',
        ], [
            'country.required' => 'Select a country',
            'currency.required' => 'Currency is required!',
            'slug.required' => 'Select a slug',
            'slug.regex' => 'The slug must consist of up to 50 lowercase letters only.',
        ]);

      $currency=Currency::where('currency_code',$request->currency)->first();
        $counttry=DefaultCountry::where('id',$request->country)->first();
        $admitad= DB::table('admitad')->where('country_slug',$counttry->slug)->first();
        $cuelink= DB::table('cuelink')->where('country_slug',$counttry->slug)->first();
        $impact= DB::table('impact')->where('country_slug',$counttry->slug)->first();    
     
    

        $country = Country::find($id);
        $country->country_name       = ucwords($counttry->country_name);
        $country->country_code       = $counttry->country_code;
        $country->slug       = $request->slug;
        $country->currency_code       = $currency->currency_code;
        $country->phone_code       = $counttry->phone_code;
        $country->currency_symbol    = $currency->currency_symbol;
        $country->save();

         $countrydet = Country::find($id);

            ////ad networks////
        if($request->admitad != NULL){
           DB::table('admitad')->where('country_slug',$countrydet->slug)->update(['status'=>1]);
        }else{

             DB::table('admitad')->where('country_slug',$countrydet->slug)->update(['status'=>0]);

        }


       if($request->cuelink != NULL){
            DB::table('cuelink')->where('country_slug',$countrydet->slug)->update(['status'=>1]);

        }else{
            DB::table('cuelink')->where('country_slug',$countrydet->slug)->update(['status'=>0]);
            
        }

        if($request->impact != NULL){
            DB::table('impact')->where('country_slug',$countrydet->slug)->update(['status'=>1]);

        }else{
            DB::table('impact')->where('country_slug',$countrydet->slug)->update(['status'=>0]);
            
        }
		
		$currency= DB::table('business_settings')->where('key','currency')->where('country_slug',$countrydet->slug)->update(['value'=>$currency->currency_code]);
         

         return redirect()->back()->with('success','Country updated Successfuly');
    }

    public function delete(Request $request,$id){
        $country = Country::find($id);
        $delete = $country->delete();
        if($delete){
         $admin = Admin::find(auth('admin')->id());
         if($admin->country_slug == $country->slug){
            $firstcountry = Country::first();
            $admin->country_slug=$firstcountry->slug;
            $admin->save();
         }

              DB::table('business_settings')->where('country_slug',$country->slug)->delete();
               DB::table('ad_networks')->where('country_slug',$country->slug)->delete();

                DB::table('admob_ads')->where('country_slug',$country->slug)->delete();
                DB::table('fb_ads')->where('country_slug',$country->slug)->delete();


                DB::table('admins')->where('country_slug',$country->slug)->delete();
                DB::table('admitad')->where('country_slug',$country->slug)->delete();
                DB::table('allin_campaigns')->where('country_slug',$country->slug)->delete();
                DB::table('api_advcampaigns')->where('country_slug',$country->slug)->delete();
                DB::table('bank_details')->where('country_slug',$country->slug)->delete();
                DB::table('banners')->where('country_slug',$country->slug)->delete();
                DB::table('banner_notifications')->where('country_slug',$country->slug)->delete();
                DB::table('categories')->where('country_slug',$country->slug)->delete();

                DB::table('clicks')->where('country_slug',$country->slug)->delete();
                DB::table('complains')->where('country_slug',$country->slug)->delete();
                DB::table('coupons')->where('country_slug',$country->slug)->delete();
                DB::table('cuelink')->where('country_slug',$country->slug)->delete();
                DB::table('cuelink_campaigns')->where('country_slug',$country->slug)->delete();
                DB::table('cuelink_offers')->where('country_slug',$country->slug)->delete();
                DB::table('earnings')->where('country_slug',$country->slug)->delete();

                DB::table('faqs')->where('country_slug',$country->slug)->delete();
                DB::table('home_advs')->where('country_slug',$country->slug)->delete();
                DB::table('impact')->where('country_slug',$country->slug)->delete();
                DB::table('notifications')->where('country_slug',$country->slug)->delete();
                DB::table('offers')->where('country_slug',$country->slug)->delete();
                DB::table('orders')->where('country_slug',$country->slug)->delete();
                DB::table('partners')->where('country_slug',$country->slug)->delete();

                DB::table('products')->where('country_slug',$country->slug)->delete();
                DB::table('referrals')->where('country_slug',$country->slug)->delete();
                DB::table('trendings')->where('country_slug',$country->slug)->delete();
                DB::table('users')->where('country_slug',$country->slug)->delete();
                DB::table('withdrawal_reqs')->where('country_slug',$country->slug)->delete();
               

            return redirect()->back()->with('error','Country Deleted SuccessFully!!');
        }else{
           return redirect()->back()->with('error', 'Somethng Went Wrorng !!') ;
        }
    }
} 
