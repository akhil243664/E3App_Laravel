<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BusinessSetting;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\CentralLogics\Helpers;
use App\Models\Admin;

class CuelinksettingsController extends Controller
{

	
	 public function check(Request $request)
    {
    	 $admin = Admin::find(auth('admin')->id());
        $cuelink=DB::table('cuelink')->where('country_slug',$admin->country_slug)->first();
        
      $url = 'https://www.cuelinks.com/api/v2/campaigns.json';
    $ch2 = curl_init($url);
    $headers = [];
    $headers[] = 'Content-Type:application/json';
    $token = $cuelink->apikey;
    $headers[] = "Authorization: Bearer ".$token;
    curl_setopt($ch2, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
    $result1 = curl_exec($ch2);
    curl_close($ch2);
	$dataw=json_decode($result1); 
	   if($dataw != NULL){
		    DB::table('cuelink')->where('country_slug',$admin->country_slug)->update(['verified'=>1]);
			return redirect()->back()->withSuccess('Verified');
	
			

	   }else{
		  
			  DB::table('cuelink')->where('country_slug',$admin->country_slug)->update(['verified'=>2]);
			return redirect()->back()->withErrors('Wrong API key');
		}
    }
	
    public function index()
    {
    	$admin = Admin::find(auth('admin')->id());
		$cuelink=DB::table('cuelink')->where('country_slug',$admin->country_slug)->first();
        return view('admin.cuelinks.settings',compact('cuelink'));
    }
  
    public function update(Request $request)
    {

    	 $admin = Admin::find(auth('admin')->id());
        $status=$request->status;
		$apikey=$request->apikey;
       $channel=$request->channel;
       $cuecheck=DB::table('cuelink')->where('country_slug',$admin->country_slug)->first();
       if($cuecheck){
       	DB::table('cuelink')->where('country_slug',$admin->country_slug)->update([
			'apikey'=>$apikey,
			'channel_id'=>$channel,
			'status'=>$status,
			'country_slug'=>$admin->country_slug,
			'verified'=>0
        ]);

       }else{
        DB::table('cuelink')->insert([
			'apikey'=>$apikey,
			'channel_id'=>$channel,
			'status'=>$status,
			'country_slug'=>$admin->country_slug,
			'verified'=>0
        ]);
        }
       
		
		return redirect()->back()->withSuccess('successfully updated');
       
    }
  

 

}
