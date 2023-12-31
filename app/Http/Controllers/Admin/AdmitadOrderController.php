<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BusinessSetting;
use App\Models\AdmobAd;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\CentralLogics\Helpers;
use Illuminate\Support\Str;
use App\Models\Api_Advcampaign;
use App\Models\Category;
use App\Models\Admin;
use App\Models\Order;
use App\Models\Partner;
use App\Models\User;
use App\Models\Earning;

class AdmitadOrderController extends Controller
{
    public function __construct(){
        $admitad=DB::table('admitad')->first();
        $this->client_id = $admitad->client_id;  
        $this->client_secret = $admitad->client_secret;
        $this->base64code = $admitad->base64code;
        $this->website_id = $admitad->website_id;
     $this->scope="statistics";
    }


    public function index()
        {
           
        $curl = curl_init();
     
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.admitad.com/token/',
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_POSTFIELDS => http_build_query([
                'client_id' =>  $this->client_id,
                'client_secret' => $this->client_secret,
                'grant_type' => 'client_credentials',
                'scope' => $this->scope,
            ]),
        ));
    
       $headers =  array(
          "Accept: application/json",
          "Authorization: Basic ".$this->base64code,
       );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        
        $resp = curl_exec($curl);
        curl_close($curl);
        $re = json_decode($resp);
        $token = $re->access_token;
        if($token) {
    
            $url = "https://api.admitad.com/statistics/actions/?limit=1000" ;
    
                $curl1 = curl_init($url);
                curl_setopt($curl1, CURLOPT_URL, $url);
                curl_setopt($curl1, CURLOPT_RETURNTRANSFER, true);
                $headers =  array(
                    "Accept: application/json",
                    "Authorization: Bearer $token",
                );
                curl_setopt($curl1, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($curl1, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($curl1, CURLOPT_SSL_VERIFYPEER, false);
    
                $resp1 = curl_exec($curl1);
                curl_close($curl1);
                $res=  json_decode($resp1);      
         
            
                foreach ($res->results as $check) {
                    $userid=User::where('id',$check->subid)->first();
                	if($check->subid != NULL && $check->subid != '' && $userid){
			        $ads=Api_Advcampaign::where('ad_id',$check->advcampaign_id)->first();
			     if($ads){
	  $partner= Partner::where('id',$ads->adv_id)->first();
	  if($partner){
		  $adv_name=$partner->name;
		  $adv_logo=$partner->image;
          $perc=$partner->comission_percentage;
		  $comtype=$partner->comission_type;
	  }else{
		   
		  
		  
		    $amount = BusinessSetting::where(['key' => 'default_commision'])->where('country_slug',$userid->country_slug)->first();
		   $perc=$amount->value;
		  $comtype=1;
	  }
	   }else{
		  
		  
		 
		   $amount = BusinessSetting::where(['key' => 'default_commision'])->where('country_slug',$userid->country_slug)->first();
		   $perc=$amount->value;
		   $comtype=1;
	   }
	   if($perc == NULL){
	       
		   $amount = BusinessSetting::where(['key' => 'default_commision'])->where('country_slug',$userid->country_slug)->first();
		   $perc=$amount->value;
		  $comtype=1;
	   }
                $checkit=Order::where('partner_order_id',$check->order_id)->first();
                
                $ex_rate =1;
                $admin_earn=$check->payment;
                $calc=($perc*$admin_earn)/100;
                $cc[]=$calc;
			   
                $actual_earn=$calc;
                
                    if($check->status=="pending"){
                        $status=0;
                    }elseif($check->status=="approved"){
                        $status=1;
                    }else{
                        $status=2;
                    }


                    /////adbasj
                    $customer=User::where('id',$check->subid)->first();
                    
                    if(!$checkit){
                            
                      if($customer && is_numeric($check->subid)){
                        $insert=new Order();
                        $insert->partner_order_id=$check->order_id;
                        $insert->advertisers=$check->advcampaign_name;
                        $insert->c_id=$check->advcampaign_id;
                        $insert->logo=$partner->image;
                        $insert->affiliate_partner='admitad';
                        $insert->order_amount=(int)($check->cart*$ex_rate);
                        $insert->admin_earn=(int)$admin_earn;
                        $insert->earning_amount=(int)$actual_earn;
                        $insert->order_status=$status;
                        $insert->user_id=$check->subid;
                        $insert->country_slug=$userid->country_slug;
                        $insert->refer_date=date('Y-m-d H:i:s', strtotime($check->click_date));
                        $insert->event_date=date('Y-m-d H:i:s', strtotime($check->click_date));
                        $insert->locking_date=date('Y-m-d H:i:s', strtotime($check->click_date));
                        $insert->created_at=now();
                        $insert->updated_at=now();
                        $insert->save();
                        $comtype=1;
                        if($check->status == 'pending'){
                            if($comtype==0){
                                $rewards=$calc;
                                    $ty="Rewards";
                            }else{
                                $rewards=0;
                                    $ty="Cashback";
                            }
                            $earning=Earning::where('user_id',$check->subid)->first();
                            if($earning){
                             
                            $earning->pending_earnings=$earning->pending_earnings + (int)$actual_earn;
                            $earning->updated_at=now();
                            $earning->save();
                            }
                            
                            if(isset($customer->cm_firebase_token))
                                {
                                    $data = [
                                        'title' => $ty.' Tracked',
                                        'description' => $ty.' of '.$actual_earn.' has been tracked.Check My Orders section.',
                                        'order_id' => '',
                                        'image' => ''
                                    ];
                                    Helpers::send_push_notif_to_device($customer->cm_firebase_token, $data);

                                }
                        }
                        
                        if($check->status == 'rejected'){
                            
                            $earning4=Earning::where('user_id',$check->subid)->first();
                            if($earning4){
                            $earning3=Earning::FindorFail($earning4->id);
                            $earning3->pending_earnings=$earning3->pending_earnings-$calc;
                            $earning3->updated_at=now();
                            $earning3->save();
                            }
                            
                            if(isset($customer->cm_firebase_token))
                                {
                                    $data = [
                                        'title' => 'Purchase Tracked',
                                        'description' => 'New Purchase Tracked Check My Order Section.',
                                        'order_id' => '',
                                        'image' => ''
                                    ];
                                    Helpers::send_push_notif_to_device($customer->cm_firebase_token, $data);

                                }
                            
                        }
                        if($check->status == 'approved'){
                            if($comtype==0){
                                $rewards=$calc;
                                    $ty="Rewards";
                            }else{
                                $rewards=0;
                                    $ty="Cashback";
                            }
                            $earning=Earning::where('user_id',$check->subid)->first();
                            $earning->total_earnings=$earning->total_earnings+(int)$actual_earn;
                            $earning->pending_earnings=$earning->pending_earnings-(int)$actual_earn;
                            $earning->rem_earning=$earning->rem_earning+(int)$actual_earn;
                            $earning->reward_earning=$earning->reward_earning+$rewards;
                            $earning->updated_at=now();
                            $earning->save();
                            
                            $referral=Referral::where('referred_user_id',$check->subid)->first();
                            if($referral){
                            $per_order = BusinessSetting::where(['key' => 'per_order_refer_percentage'])->first();
                            if($per_order){
                                    $referral_earning=($per_order->value*$actual_earn)/100;
                                    $earning1=Earning::where('user_id',$referral->user_id)->first();
                                    $earning1->total_earnings=$earning1->total_earnings+$referral_earning;
                                    $earning1->rem_earning=$earning1->rem_earning+$referral_earning;
                                    $earning1->referral_earning=$earning1->referral_earning+$referral_earning;
                                    $earning1->updated_at=now();
                                    $earning1->save();
                                    }
                            }
                            
                            if(isset($customer->cm_firebase_token))
                                {
                                    $data = [
                                        'title' => $ty.' Approved',
                                        'description' => $ty.' of '.$actual_earn.' has been approved.Check My Earnings or My profile section.',
                                        'order_id' => '',
                                        'image' => ''
                                    ];
                                    Helpers::send_push_notif_to_device($customer->cm_firebase_token, $data);

                                }
                        }
                    }
                        }
                        else{
                            
		  if($checkit->order_status != $status){
			  $insert2=Order::FindorFail($checkit->id);
			  $insert2->order_status=$status;
			  $insert2->updated_at=now();
			  $insert2->save(); 
		   
		   if($check->status == 'approved'){
			   if($comtype==0){
				   $rewards=$calc;
				   $ty="Rewards";
			   }else{
				   $rewards=0;
				   $ty="Cashback";
			   }
			   
			   
			  $earning=Earning::where('user_id',$check->subid)->first();
			  $earning->total_earnings=$earning->total_earnings+(int)$actual_earn;
			  $earning->rem_earning=$earning->rem_earning+(int)$actual_earn;
			  $earning->pending_earnings=$earning->pending_earnings-(int)$actual_earn;
			  $earning->reward_earning=$earning->reward_earning+(int)$rewards;
			  $earning->updated_at=now();
			  $earning->save();
			   
			$referral=Referral::where('referred_user_id',$check->subid)->first();
			if($referral){
			$per_order = BusinessSetting::where(['key' => 'per_order_refer_percentage'])->first();
			if($per_order){
				       $referral_earning=($per_order->value*$actual_earn)/100;
				       $earning1=Earning::where('user_id',$referral->user_id)->first();
					  $earning1->total_earnings=$earning1->total_earnings+$referral_earning;
					  $earning1->rem_earning=$earning1->rem_earning+$referral_earning;
				      $earning1->referral_earning=$earning1->referral_earning+$referral_earning;
					  $earning1->updated_at=now();
					  $earning1->save();
		         	}
		        }
				if(isset($customer->cm_firebase_token))
                {
                    $data = [
                        'title' => $ty.' Approved',
                        'description' => $ty.' of '.$actual_earn.' has been approved.Check My Earnings or My profile section.',
                        'order_id' => '',
                        'image' => ''
                    ];
                    Helpers::send_push_notif_to_device($customer->cm_firebase_token, $data);

                }
		  }
		  if($check->State == 'rejected'){
			   if($comtype==0){
				   $rewards=$calc;
				    $ty="Rewards";
			   }else{
				   $rewards=0;
				    $ty="Cashback";
			   }
			  $earning=Earning::where('user_id',$check->subid)->first();
			  $earning->pending_earnings=$earning->pending_earnings-$calc;
			  $earning->updated_at=now();
			  $earning->save();
			  
			  if(isset($customer->cm_firebase_token))
                {
                    $data = [
                        'title' => $ty.' Rejected',
                        'description' => $ty.' of '.$calc.' has been rejected.You can raise complaint from my order section.',
                        'order_id' => '',
                        'image' => ''
                    ];
                    Helpers::send_push_notif_to_device($customer->cm_firebase_token, $data);

                }
		  }
		}

                    /////asdfasfas
                    
                }
                
                
                }//check subid
            }
            
        }  
    
    }
}