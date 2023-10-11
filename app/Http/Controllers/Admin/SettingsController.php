<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BusinessSetting;
use App\Models\Country;
use App\Models\Admin;
use App\Models\Floxypay;
use App\Models\CountrySelection;
use App\Models\DefaultLanguage;
use App\Models\Qr;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\CentralLogics\Helpers;
use App\Models\FirebaseDetail;
use App\Models\Demoimage;
use App\Models\WebContent;

class SettingsController extends Controller
{


    public function business_index()
    {
         $admin = Admin::find(auth('admin')->id());
        return view('admin.settings.index',compact('admin'));
    }
  
    public function business_setup(Request $request)
    {
         $admin = Admin::find(auth('admin')->id());
        if(env('APP_MODE')=='demo')
        {
			return redirect()->back()->withErrors('update option is disable for demo');
        }

        DB::table('business_settings')->where('country_slug',$admin->country_slug)->updateOrInsert(['key' => 'business_name'], [
            'value' => $request['app_name']
        ]);
      
		
		 DB::table('business_settings')->where('country_slug',$admin->country_slug)->updateOrInsert(['key' => 'default_commision'], [
            'value' => $request['commision']
        ]);
        
        
        $curr_logo = BusinessSetting::where(['key' => 'logo'])->where('country_slug',$admin->country_slug)->first();
        if ($request->has('logo')) {
            $image_name = Helpers::update('info/', $curr_logo->value, 'png', $request->file('logo'));
        } else {
            $image_name = $curr_logo['value'];
        }

        DB::table('business_settings')->where('country_slug',$admin->country_slug)->updateOrInsert(['key' => 'logo'], [
            'value' => $image_name
        ]);

        $fav_icon = BusinessSetting::where(['key' => 'icon'])->where('country_slug',$admin->country_slug)->first();
        if ($request->has('icon')) {
            $image_name = Helpers::update('info/', $fav_icon->value, 'png', $request->file('icon'));
        } else {
            $image_name = $fav_icon['value'];
        }

        DB::table('business_settings')->where('country_slug',$admin->country_slug)->updateOrInsert(['key' => 'icon'], [
            'value' => $image_name
        ]);

       

        DB::table('business_settings')->where('country_slug',$admin->country_slug)->updateOrInsert(['key' => 'footer_text'], [
            'value' => $request['footer_text']
        ]);
		
		DB::table('business_settings')->where('country_slug',$admin->country_slug)->updateOrInsert(['key' => 'minimum_redeem'], [
            'value' => $request['min_redeem']
        ]);
 

         $update= CountrySelection::first();
		 $upd_coun=CountrySelection::find($update->id);
         $update->active=$request->country_selection;
         $update->save();

		 if($request->dummy_image != NULL){
            $dummy_image=Demoimage::first();
            $dummy_image->image=Helpers::update('info/', $dummy_image->image, 'png', $request->file('dummy_image'));
            $dummy_image->save();
        }

		return redirect()->back()->withSuccess('successfully updated');
       
    }
	
	
	
	
	    public function about_us()
    {
         $admin = Admin::find(auth('admin')->id());
        $tnc = BusinessSetting::where(['key' => 'about_us'])->where('country_slug',$admin->country_slug)->first();
        if ($tnc == false) {
            BusinessSetting::insert([
                'key' => 'about_us',
                'value' => ''
            ]);
        }
        return view('admin.settings.about_us', compact('tnc','admin'));
    }

    public function about_us_update(Request $request)
    {
         $admin = Admin::find(auth('admin')->id());
        BusinessSetting::where(['key' => 'about_us'])->where('country_slug',$admin->country_slug)->update([
            'value' => $request->tnc
        ]);
        return redirect()->back()->withSuccess('terms and condition updated');
       
    }

    public function privacy_policy()
    {
         $admin = Admin::find(auth('admin')->id());
        $data = BusinessSetting::where(['key' => 'privacy_policy'])->where('country_slug',$admin->country_slug)->first();
        if ($data == false) {
            $data = [
                'key' => 'privacy_policy',
                'value' => '',
            ];
            BusinessSetting::insert($data);
        }
        return view('admin.settings.privacy', compact('data','admin'));
    }

    public function privacy_policy_update(Request $request)
    {
         $admin = Admin::find(auth('admin')->id());
        BusinessSetting::where(['key' => 'privacy_policy'])->where('country_slug',$admin->country_slug)->update([
            'value' => $request->privacy_policy,
        ]);
        return redirect()->back()->withSuccess('privacy policy updated');
       
    }

  public function currency_index()
    {
         $admin = Admin::find(auth('admin')->id());
        return view('admin.settings.currency', compact('admin'));
    }
  
    public function currency_setup(Request $request)
    {
         $admin = Admin::find(auth('admin')->id());
        if(env('APP_MODE')=='demo')
        {
			return redirect()->back()->withErrors('update option is disable for demo');
        }

         DB::table('business_settings')->where('country_slug',$admin->country_slug)->where('key','currency')->update([
            'value' => $request['currency']
        ]);
       
		return redirect()->back()->withSuccess('successfully updated');
       
    }
	
	 public function exchange_rate(Request $request)
    {
         $admin = Admin::find(auth('admin')->id());
        if(env('APP_MODE')=='demo')
        {
			return redirect()->back()->withErrors('update option is disable for demo');
        }

         DB::table('business_settings')->where('country_slug',$admin->country_slug)->where('key','cuelinks_rate')->update([
            'value' => $request['cuelinks_rate']
        ]);
       
		 DB::table('business_settings')->where('country_slug',$admin->country_slug)->where('key','impact_rate')->update([
            'value' => $request['impact_rate']
        ]);
		
		
		return redirect()->back()->withSuccess('successfully updated');
       
    }
	
	public function referral_index()
    {
        $admin = Admin::find(auth('admin')->id());
        return view('admin.settings.referral',compact('admin'));
    }
  
    public function referral_setup(Request $request)
    {
         $admin = Admin::find(auth('admin')->id());
        if(env('APP_MODE')=='demo')
        {
			return redirect()->back()->withErrors('update option is disable for demo');
        }

         DB::table('business_settings')->where('country_slug',$admin->country_slug)->updateOrInsert(['key' => 'signup_refer'], [
            'value' => $request['signup_refer']
        ]);
       
		 DB::table('business_settings')->where('country_slug',$admin->country_slug)->updateOrInsert(['key' => 'per_order_refer_percentage'], [
            'value' => $request['per_order_refer_percentage']
        ]);
		
		return redirect()->back()->withSuccess('successfully updated');
       
    }


        public function countryselection()
    {
         $admin = Admin::find(auth('admin')->id());
        $cs = CountrySelection::first();
       
        return view('admin.settings.cs', compact('tnc','admin'));
    }

    
    public function firebase_Settings()
    {
        $admin = Admin::find(auth('admin')->id());
        return view('admin.settings.firebase_settings',compact('admin'));
    }

     public function firebase_Settings_update(Request $request)
    {
         $admin = Admin::find(auth('admin')->id());
         $apikey=$request->apikey;
         $authdomain=$request->authdomain;
         $projectid=$request->projectid;
         $storagebucket=$request->storagebucket;
         $senderid=$request->senderid;
         $appid=$request->appid;
        if(env('APP_MODE')=='demo')
        {
            return redirect()->back()->withErrors('update option is disable for demo');
        }

         $fd=FirebaseDetail::first();
         $fd->apikey=$apikey;
         $fd->authdomain=$authdomain;
         $fd->projectid=$projectid;
         $fd->storagebucket=$storagebucket;
         $fd->senderid=$senderid;
         $fd->appid=$appid;
         $fd->save();

        
        return redirect()->back()->withSuccess('successfully updated');
       
    }
	
	
	
	
	 public function web_footer_index()
    {
         $admin = Admin::find(auth('admin')->id());
        return view('admin.settings.footersettings',compact('admin'));
    }
  
    public function update_footer_settings(Request $request)
    {
         $admin = Admin::find(auth('admin')->id());
        if(env('APP_MODE')=='demo')
        {
			return redirect()->back()->withErrors('update option is disable for demo');
        }

        DB::table('web_contents')->updateOrInsert(['key' => 'play_store_link'], [
            'value' => $request['playstore']
        ]);
      
		
		 DB::table('web_contents')->updateOrInsert(['key' => 'app_store_link'], [
            'value' => $request['appstore']
        ]);
		
		DB::table('web_contents')->updateOrInsert(['key' => 'address'], [
            'value' => $request['address']
        ]);
		
		DB::table('web_contents')->updateOrInsert(['key' => 'contact_phone'], [
            'value' => $request['contact_phone']
        ]);
		
		DB::table('web_contents')->updateOrInsert(['key' => 'contact_email'], [
            'value' => $request['contact_email']
        ]);
 

        
	

		return redirect()->back()->withSuccess('successfully updated');
       
    }

   

   

}
