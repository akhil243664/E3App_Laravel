<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BusinessSetting;
use App\Models\FbAd;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\CentralLogics\Helpers;

class FbController extends Controller
{
	 public function index()
	 {
	 	$admin = Admin::find(auth('admin')->id());
		$banner=FbAd::where('ad_type','banner')->where('country_slug', $admin->country_slug)->get();
		$native=FbAd::where('ad_type','native')->where('country_slug', $admin->country_slug)->get();
		$interstitial=FbAd::where('ad_type','interstitial')->where('country_slug', $admin->country_slug)->first();
		$reward=FbAd::where('ad_type','rewards')->where('country_slug', $admin->country_slug)->first();
	     return view('admin.ad_networks.fb',compact('banner','native','interstitial','reward','admin'));
	 }

    public function update(Request $request, $id)
    {
	   $admin = Admin::find(auth('admin')->id());
	   $status=$request->status;
		$placement_id=$request->placement_id;
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
	      $admob=FbAd::FindOrFail($id);
		  $admob->placement_id=$placement_id;
		  $admob->status=$status;
		  $admob->clicks=$clicks;
	     $admob->country_slug=$admin->country_slug;
		  $admob->rewards=$rewards;
		  $admob->save();

		  return redirect()->back()->withSuccess('successfully updated'); 
    }
  

 

}