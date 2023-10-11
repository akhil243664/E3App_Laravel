<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BusinessSetting;
use App\Models\AdmobAd;
use App\Models\Admin;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\CentralLogics\Helpers;

class AdnetworkController extends Controller
{

	  public function settings()
    {
    	$admin = Admin::find(auth('admin')->id());
        return view('admin.ad_networks.index',compact('admin'));
    }
  
    public function update_setup(Request $request)
    {

    	$admin = Admin::find(auth('admin')->id());

        DB::table('ad_networks')->updateOrInsert(['key' => 'admob'], [
            'value' => $request['admob']
        ],[
            'country_slug' => $admin->country_slug
        ]);
      
		
		 DB::table('ad_networks')->updateOrInsert(['key' => 'facebookad'], [
            'value' => $request['fb']
        ],[
            'country_slug' =>  $admin->country_slug
        ]);
        

        
		
		return redirect()->back()->withSuccess('successfully updated');
       
    }
	
    public function index()
    {
    	$admin = Admin::find(auth('admin')->id());
		$banner=AdmobAd::where('ad_type','banner')->where('country_slug', $admin->country_slug)->get();
		$native=AdmobAd::where('ad_type','native')->where('country_slug', $admin->country_slug)->get();
		$interstitial=AdmobAd::where('ad_type','interstitial')->where('country_slug', $admin->country_slug)->first();
		$reward=AdmobAd::where('ad_type','rewards')->where('country_slug', $admin->country_slug)->first();
        return view('admin.ad_networks.settings',compact('banner','native','interstitial','reward','admin'));
    }
  
    public function update(Request $request, $id)
    {
     $admin = Admin::find(auth('admin')->id());
     $status=$request->status;
	 $ad_id=$request->ad_id;
	if($request->clicks != NULL){
	  $clicks=$request->clicks;	
	}else{
		$clicks=NULL;
	}
		if($request->rewards != NULL){
	  $rewards=$request->rewards;	
	}else{
		$rewards=NULL;
	}
      $admob=AdmobAd::FindOrFail($id);
	  $admob->ad_id=$ad_id;
	  $admob->country_slug=$admin->country_slug;
	  $admob->status=$status;
	  $admob->clicks=$clicks;
	  $admob->rewards=$rewards;
	  $admob->save();

	  return redirect()->back()->withSuccess('successfully updated');
       
    }
  

 

}
