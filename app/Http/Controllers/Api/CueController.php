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
use App\Models\Banner;
use App\Models\HomeAdv;
use App\Models\Coupon;
use App\Models\CuelinkOffer;
use App\Models\Api_Advcampaign;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Country;
use DB;


class CueController extends Controller
{

    public function exclusiveoffers(Request $request)
    {
        $offset=1;
       $countriedds=Country::first();
        $country_slug= $request->header('countryslug') ?? 'in';;
		$countcheck=Country::where('slug',$country_slug)->first();
		if(!$countcheck){
			$arr = array('status'=>1, 'data'=>[]);
            return response()->json($arr);
		}
		$check=DB::table('cuelink')->where('country_slug',$country_slug)->first();
		
		$partnerr=NULL;
		if($check->status==1){
        $partners=CuelinkOffer::exclusive()->active()->ongoing()->with('category')->where('country_slug',$country_slug)->where('status',1)->get();
        foreach($partners as $part){
            $campaign=CuelinkCampaign::with('partner')->where('campaign_id',$part->campaign_id)->where('country_slug',$country_slug)->first();
            $part->partner=$campaign->partner??NULL;
            $campaign2=CuelinkCampaign::with('partner.coupon')->where('campaign_id',$part->campaign_id)->where('country_slug',$country_slug)->first();
            $part->coupon=$campaign2->partner->coupon??NULL;
            $partnerr[]=$part;
        }
		}else{
			$partnerr=array();
		}
		if($partnerr==NULL){
			$partnerr=array();
		}
        $arr = array('status'=>1, 'data'=>$partnerr);
        return response()->json($arr);
    }
    
    public function getalloffers(Request $request)
    {
        $offset=1;
         $countriedds=Country::first();
        $country_slug= $request->header('countryslug') ?? 'in';;
		$countcheck=Country::where('slug',$country_slug)->first();
		if(!$countcheck){
			$arr = array('status'=>1, 'data'=>[]);
            return response()->json($arr);
		}
		$check=DB::table('cuelink')->where('country_slug',$country_slug)->first();
		$partnerr=NULL;
		if($check->status==1){
        $partners=CuelinkOffer::active()->ongoing()->with('category')->where('country_slug',$country_slug)->where('status',1)->paginate(150);
        
        foreach($partners->items() as $part){
            $campaign=CuelinkCampaign::with('partner')->where('campaign_id',$part->campaign_id)->where('country_slug',$country_slug)->get();
            foreach($campaign as $cam){
            $part->partner=$cam->partner??NULL;
            }
            $campaign2=CuelinkCampaign::with('partner.coupon')->where('campaign_id',$part->campaign_id)->where('country_slug',$country_slug)->get();
            foreach($campaign2 as $cam2){
            $part->coupon=$cam2->partner->coupon??NULL;
            }
            
            $partnerr[]=$part;
        }
		}else{
			$partnerr=array();
		}
		if($partnerr==NULL){
			$partnerr=array();
		}
        $arr = array('status'=>1, 'data'=>$partnerr);
        return response()->json($arr);
    }
    
    public function getcategory(Request $request)
    {
        $offset = 1;
		$countriedds = Country::first();
		$country_slug = $request->header('countryslug') ?? 'in';;
		$countcheck = Country::where('slug', $country_slug)->first();

		if (!$countcheck) {
			$arr = array('status' => 1, 'data' => []);
			return response()->json($arr);
		}

		$check = DB::table('cuelink')->where('country_slug', $country_slug)->first();
		$check2 = DB::table('impact')->where('country_slug', $country_slug)->first();
		$check3 = DB::table('admitad')->where('country_slug', $country_slug)->first();

		$parr = [];

		if ($check->status == 1) {
			$parr = Category::where('country_slug', $country_slug);

			if ($check2->status == 1) {
				$parr = $parr->with('cuecampaigns');
			}

			if ($check3->status == 1) {
				$parr = $parr->with('admitadoffers');
			}

			$parr = $parr->orderBy('name', 'asc')->paginate(100);

			if ($parr->isEmpty()) {
				$arr = array('status' => 1, 'data' => []);
				return response()->json($arr);
			}



			$arr = array('status' => 1, 'data' => $parr->items());
			return response()->json($arr);
		} else {
			$pars = Category::where('country_slug', $country_slug)->paginate(15);

			foreach ($pars as $parss) {
				if ($check2->status != 1) {
					$parss['cuecampaigns'] = [];
				}

				if ($check3->status != 1) {
					$parss['admitadoffers'] = [];
				}

				$parr[] = $parss;
			}

			if (empty($parr)) {
				$arr = array('status' => 1, 'data' => []);
				return response()->json($arr);
			}

			$arr = array('status' => 1, 'data' => $parr);
			return response()->json($arr);
		}
    }
    public function getallpartner(Request $request)
    {
        $offset=1;
        $countriedds=Country::first();
       $country_slug= $request->header('countryslug') ?? 'in';;
		$countcheck=Country::where('slug',$country_slug)->first();
		if(!$countcheck){
			$arr = array('status'=>1, 'data'=>[]);
            return response()->json($arr);
		}
        $partners=Partner::active()->with('cuecampaigns')->paginate(150);
       $arr = array('status'=>1, 'data'=>$partners->items());
        return response()->json($arr);
    }
    
    public function getallcampaigns(Request $request)
    {
        $offset=1;
          $countriedds=Country::first();
       $country_slug= $request->header('countryslug') ?? 'in';;
		$countcheck=Country::where('slug',$country_slug)->first();
		if(!$countcheck){
			$arr = array('status'=>1, 'data'=>[]);
            return response()->json($arr);
		}
		$check=DB::table('cuelink')->where('country_slug',$country_slug)->first();
		if($check->status==1){
        $partners=CuelinkCampaign::with('partner','category')->where('country_slug',$country_slug)->where('status',1)->paginate(150);
        $partnerr=NULL;
        foreach($partners->items() as $part){
            $coupon=Coupon::where('adv_id',$part->adv_id)->get();
            $part->coupon=$coupon;
            $partnerr[]=$part;
        }
		}else{
			$partnerr=[];
		}
        
        $arr = array('status'=>1, 'data'=>$partnerr==NULL?[]:$partnerr);
        return response()->json($arr);
    }

    
        public function homepartner(Request $request)
    {
		$offset=1;
		  $countriedds=Country::first();
     $country_slug= $request->header('countryslug') ?? 'in';;
		$countcheck=Country::where('slug',$country_slug)->first();
		if(!$countcheck){
			$arr = array('status'=>1, 'data'=>[]);
            return response()->json($arr);
		}
		 $check=DB::table('cuelink')->where('country_slug',$country_slug)->first();
	   $check2=DB::table('impact')->where('country_slug',$country_slug)->first();
       $check3=DB::table('admitad')->where('country_slug',$country_slug)->first();
	   $parr=NULL;
		if($check->status==1 && $check2->status==1 && $check3->status==1){
           $parr=Partner::active()->with('cuecampaigns','ads','coupon','admitadoffers')->join('home_advs', 'partners.id', '=', 'home_advs.p_id')->select('partners.*','home_advs.p_id','home_advs.rank')->where('partners.country_slug',$country_slug)->orderBy('rank','asc')->get();
		   $arr = array('status'=>1, 'data'=>$parr);
            return response()->json($arr);
        }elseif($check->status==1 && $check2->status==1 && $check3->status !=1){
			$pars=Partner::active()->with('cuecampaigns','ads','coupon')->join('home_advs', 'partners.id', '=', 'home_advs.p_id')->select('partners.*','home_advs.p_id','home_advs.rank')->where('partners.country_slug',$country_slug)->orderBy('rank','asc')->get();
		    foreach($pars as $parss){
			 $parss['admitadoffers']=[];
			 $parr[]=$parss;
		     }
			 if($parr==NULL){
				 $arr = array('status'=>1, 'data'=>[]);
                  return response()->json($arr);
			 }
			 
			$arr = array('status'=>1, 'data'=>$parr);
            return response()->json($arr);
		}elseif($check->status==1 && $check2->status!=1 && $check3->status!=1){
			$pars=Partner::active()->with('cuecampaigns','coupon')->join('home_advs', 'partners.id', '=', 'home_advs.p_id')->select('partners.*','home_advs.p_id','home_advs.rank')->where('partners.country_slug',$country_slug)->orderBy('rank','asc')->get();
		    foreach($pars as $parss){
			 $parss['ads']=[];
             $parss['admitadoffers']=[];
			 $parr[]=$parss;
		     }
			 if($parr==NULL){
				 $arr = array('status'=>1, 'data'=>[]);
                  return response()->json($arr);
			 }
			 $arr = array('status'=>1, 'data'=>$parr);
            return response()->json($arr);
		}elseif($check->status==1 && $check2->status==1 && $check3->status!=1){
            $pars=Partner::active()->with('cuecampaigns','ads','coupon')->join('home_advs', 'partners.id', '=', 'home_advs.p_id')->select('partners.*','home_advs.p_id','home_advs.rank')->where('partners.country_slug',$country_slug)->orderBy('rank','asc')->get();
		    foreach($pars as $parss){
             $parss['admitadoffers']=[];
			 $parr[]=$parss;
		     }
			 if($parr==NULL){
				 $arr = array('status'=>1, 'data'=>[]);
                  return response()->json($arr);
			 }
			 $arr = array('status'=>1, 'data'=>$parr);
            return response()->json($arr);
        }elseif($check->status==1 && $check2->status!=1 && $check3->status==1){
            $pars=Partner::active()->with('cuecampaigns','coupon','admitadoffers')->join('home_advs', 'partners.id', '=', 'home_advs.p_id')->select('partners.*','home_advs.p_id','home_advs.rank')->where('partners.country_slug',$country_slug)->orderBy('rank','asc')->get();
		    foreach($pars as $parss){
             $parss['ads']=[];
			 $parr[]=$parss;
		     }
			 if($parr==NULL){
				 $arr = array('status'=>1, 'data'=>[]);
                  return response()->json($arr);
			 }
			 $arr = array('status'=>1, 'data'=>$parr);
            return response()->json($arr);
        }elseif($check->status!=1 && $check2->status==1 && $check3->status!=1){
            $pars=Partner::active()->with('ads','coupon')->join('home_advs', 'partners.id', '=', 'home_advs.p_id')->select('partners.*','home_advs.p_id','home_advs.rank')->where('partners.country_slug',$country_slug)->orderBy('rank','asc')->get();
		    foreach($pars as $parss){
             $parss['cuecampaigns']=[];
             $parss['admitadoffers']=[];
			 $parr[]=$parss;
		     }
			 if($parr==NULL){
				 $arr = array('status'=>1, 'data'=>[]);
                  return response()->json($arr);
			 }
			 $arr = array('status'=>1, 'data'=>$parr);
            return response()->json($arr);
        }elseif($check->status!=1 && $check2->status!=1 && $check3->status==1){
            $pars=Partner::active()->with('coupon','admitadoffers')->join('home_advs', 'partners.id', '=', 'home_advs.p_id')->select('partners.*','home_advs.p_id','home_advs.rank')->where('partners.country_slug',$country_slug)->orderBy('rank','asc')->get();
		    foreach($pars as $parss){
             $parss['cuecampaigns']=[];
             $parss['ads']=[];
			 $parr[]=$parss;
		     }
			 if($parr==NULL){
				 $arr = array('status'=>1, 'data'=>[]);
                  return response()->json($arr);
			 }
			 $arr = array('status'=>1, 'data'=>$parr);
            return response()->json($arr);
        }elseif($check->status!=1 && $check2->status==1 && $check3->status==1){
            $pars=Partner::active()->with('ads','coupon','admitadoffers')->join('home_advs', 'partners.id', '=', 'home_advs.p_id')->select('partners.*','home_advs.p_id','home_advs.rank')->where('partners.country_slug',$country_slug)->orderBy('rank','asc')->get();
		    foreach($pars as $parss){
             $parss['cuecampaigns']=[];
			 $parr[]=$parss;
		     }
			 if($parr==NULL){
				 $arr = array('status'=>1, 'data'=>[]);
                  return response()->json($arr);
			 }
			 $arr = array('status'=>1, 'data'=>$parr);
            return response()->json($arr);
        }
        else{
			$parr=array();
			 $arr = array('status'=>1, 'data'=>[]);
            return response()->json($arr);
		}
		
		if($parr==NULL){
			$parr=array();
			 $arr = array('status'=>1, 'data'=>[]);
            return response()->json($arr);
		}
        

        $arr = array('status'=>1, 'data'=>$parr);
        return response()->json($arr);		
			
		
     }
    
    
        public function topcashback(Request $request)
    {
    	 $countriedds=Country::first();
      $country_slug= $request->header('countryslug') ?? 'in';;
		$countcheck=Country::where('slug',$country_slug)->first();
		if(!$countcheck){
			$arr = array('status'=>1, 'data'=>[]);
            return response()->json($arr);
		}
        $offset=1;
		 $check=DB::table('cuelink')->first();
	   $check2=DB::table('impact')->first();
       $check3=DB::table('admitad')->first();
	   $parr=NULL;
		if($check->status==1 && $check2->status==1 && $check3->status==1){
           $parr=Partner::active()->with('cuecampaigns','ads','coupon','admitadoffers')->where('country_slug',$country_slug)->where('top_cashback',1)->get();
		   $arr = array('status'=>1, 'data'=>$parr);
            return response()->json($arr);
        }elseif($check->status==1 && $check2->status==1 && $check3->status !=1){
			$pars=Partner::active()->with('cuecampaigns','ads','coupon')->where('country_slug',$country_slug)->where('top_cashback',1)->get();
		    foreach($pars as $parss){
			 $parss['admitadoffers']=[];
			 $parr[]=$parss;
		     }
			 if($parr==NULL){
				 $arr = array('status'=>1, 'data'=>[]);
                  return response()->json($arr);
			 }
			 
			$arr = array('status'=>1, 'data'=>$parr);
            return response()->json($arr);
		}elseif($check->status==1 && $check2->status!=1 && $check3->status!=1){
			$pars=Partner::active()->with('cuecampaigns','coupon')->where('country_slug',$country_slug)->where('top_cashback',1)->get();
		    foreach($pars as $parss){
			 $parss['ads']=[];
             $parss['admitadoffers']=[];
			 $parr[]=$parss;
		     }
			 if($parr==NULL){
				 $arr = array('status'=>1, 'data'=>[]);
                  return response()->json($arr);
			 }
			 $arr = array('status'=>1, 'data'=>$parr);
            return response()->json($arr);
		}elseif($check->status==1 && $check2->status==1 && $check3->status!=1){
            $pars=Partner::active()->with('cuecampaigns','ads','coupon')->where('country_slug',$country_slug)->where('top_cashback',1)->get();
		    foreach($pars as $parss){
             $parss['admitadoffers']=[];
			 $parr[]=$parss;
		     }
			 if($parr==NULL){
				 $arr = array('status'=>1, 'data'=>[]);
                  return response()->json($arr);
			 }
			 $arr = array('status'=>1, 'data'=>$parr);
            return response()->json($arr);
        }elseif($check->status==1 && $check2->status!=1 && $check3->status==1){
            $pars=Partner::active()->with('cuecampaigns','coupon','admitadoffers')->where('country_slug',$country_slug)->where('top_cashback',1)->get();
		    foreach($pars as $parss){
             $parss['ads']=[];
			 $parr[]=$parss;
		     }
			 if($parr==NULL){
				 $arr = array('status'=>1, 'data'=>[]);
                  return response()->json($arr);
			 }
			 $arr = array('status'=>1, 'data'=>$parr);
            return response()->json($arr);
        }elseif($check->status!=1 && $check2->status==1 && $check3->status!=1){
            $pars=Partner::active()->with('ads','coupon')->where('country_slug',$country_slug)->where('top_cashback',1)->get();
		    foreach($pars as $parss){
             $parss['cuecampaigns']=[];
             $parss['admitadoffers']=[];
			 $parr[]=$parss;
		     }
			 if($parr==NULL){
				 $arr = array('status'=>1, 'data'=>[]);
                  return response()->json($arr);
			 }
			 $arr = array('status'=>1, 'data'=>$parr);
            return response()->json($arr);
        }elseif($check->status!=1 && $check2->status!=1 && $check3->status==1){
            $pars=Partner::active()->with('coupon','admitadoffers')->where('country_slug',$country_slug)->where('top_cashback',1)->get();
		    foreach($pars as $parss){
             $parss['cuecampaigns']=[];
             $parss['ads']=[];
			 $parr[]=$parss;
		     }
			 if($parr==NULL){
				 $arr = array('status'=>1, 'data'=>[]);
                  return response()->json($arr);
			 }
			 $arr = array('status'=>1, 'data'=>$parr);
            return response()->json($arr);
        }elseif($check->status!=1 && $check2->status==1 && $check3->status==1){
            $pars=Partner::active()->with('ads','coupon','admitadoffers')->where('country_slug',$country_slug)->where('top_cashback',1)->get();
		    foreach($pars as $parss){
             $parss['cuecampaigns']=[];
			 $parr[]=$parss;
		     }
			 if($parr==NULL){
				 $arr = array('status'=>1, 'data'=>[]);
                  return response()->json($arr);
			 }
			 $arr = array('status'=>1, 'data'=>$parr);
            return response()->json($arr);
        }
        else{
			$parr=array();
			 $arr = array('status'=>1, 'data'=>[]);
            return response()->json($arr);
		}
		
		if($parr==NULL){
			$parr=array();
			 $arr = array('status'=>1, 'data'=>[]);
            return response()->json($arr);
		}
        

        $arr = array('status'=>1, 'data'=>$parr);
        return response()->json($arr);	
			
			
		
     }
    
        public function alladv(Request $request)
    {
			
	 $countriedds=Country::first();
       $country_slug= $request->header('countryslug') ?? 'in';;
		$countcheck=Country::where('slug',$country_slug)->first();
		if(!$countcheck){
			$arr = array('status'=>1, 'data'=>[]);
            return response()->json($arr);
		}
	$offset=1;
	$check=DB::table('cuelink')->where('country_slug',$country_slug)->first();
	   $check2=DB::table('impact')->where('country_slug',$country_slug)->first();
       $check3=DB::table('admitad')->where('country_slug',$country_slug)->first();
	   $parr=NULL;
		if($check->status==1 && $check2->status==1 && $check3->status==1){
           $parr=Partner::active()->with('cuecampaigns','ads','coupon','admitadoffers')->where('country_slug',$country_slug)->orderBy('id','desc')->paginate(150);
		  $arr = array('status'=>1, 'data'=>$parr->items());
            return response()->json($arr);
        }elseif($check->status==1 && $check2->status==1 && $check3->status !=1){
			$pars=Partner::active()->with('cuecampaigns','ads','coupon')->where('country_slug',$country_slug)->orderBy('id','desc')->paginate(150);
		    foreach($pars as $parss){
			 $parss['admitadoffers']=[];
			 $parr[]=$parss;
		     }
			 if($parr==NULL){
				 $arr = array('status'=>1, 'data'=>[]);
                  return response()->json($arr);
			 }
			 
			$arr = array('status'=>1, 'data'=>$parr);
            return response()->json($arr);
		}elseif($check->status==1 && $check2->status!=1 && $check3->status!=1){
			$pars=Partner::active()->with('cuecampaigns','coupon')->where('country_slug',$country_slug)->orderBy('id','desc')->paginate(150);
		    foreach($pars as $parss){
			 $parss['ads']=[];
             $parss['admitadoffers']=[];
			 $parr[]=$parss;
		     }
			 if($parr==NULL){
				 $arr = array('status'=>1, 'data'=>[]);
                  return response()->json($arr);
			 }
			 $arr = array('status'=>1, 'data'=>$parr);
            return response()->json($arr);
		}elseif($check->status==1 && $check2->status==1 && $check3->status!=1){
            $pars=Partner::active()->with('cuecampaigns','ads','coupon')->where('country_slug',$country_slug)->orderBy('id','desc')->paginate(150);
		    foreach($pars as $parss){
             $parss['admitadoffers']=[];
			 $parr[]=$parss;
		     }
			 if($parr==NULL){
				 $arr = array('status'=>1, 'data'=>[]);
                  return response()->json($arr);
			 }
			 $arr = array('status'=>1, 'data'=>$parr);
            return response()->json($arr);
        }elseif($check->status==1 && $check2->status!=1 && $check3->status==1){
            $pars=Partner::active()->with('cuecampaigns','coupon','admitadoffers')->where('country_slug',$country_slug)->orderBy('id','desc')->paginate(150);
		    foreach($pars as $parss){
             $parss['ads']=[];
			 $parr[]=$parss;
		     }
			 if($parr==NULL){
				 $arr = array('status'=>1, 'data'=>[]);
                  return response()->json($arr);
			 }
			 $arr = array('status'=>1, 'data'=>$parr);
            return response()->json($arr);
        }elseif($check->status!=1 && $check2->status==1 && $check3->status!=1){
            $pars=Partner::active()->with('ads','coupon')->orderBy('id','desc')->where('country_slug',$country_slug)->paginate(150);
		    foreach($pars as $parss){
             $parss['cuecampaigns']=[];
             $parss['admitadoffers']=[];
			 $parr[]=$parss;
		     }
			 if($parr==NULL){
				 $arr = array('status'=>1, 'data'=>[]);
                  return response()->json($arr);
			 }
			 $arr = array('status'=>1, 'data'=>$parr);
            return response()->json($arr);
        }elseif($check->status!=1 && $check2->status!=1 && $check3->status==1){
            $pars=Partner::active()->with('coupon','admitadoffers')->orderBy('id','desc')->where('country_slug',$country_slug)->paginate(150);
		    foreach($pars as $parss){
             $parss['cuecampaigns']=[];
             $parss['ads']=[];
			 $parr[]=$parss;
		     }
			 if($parr==NULL){
				 $arr = array('status'=>1, 'data'=>[]);
                  return response()->json($arr);
			 }
			 $arr = array('status'=>1, 'data'=>$parr);
            return response()->json($arr);
        }elseif($check->status!=1 && $check2->status==1 && $check3->status==1){
            $pars=Partner::active()->with('ads','coupon','admitadoffers')->where('country_slug',$country_slug)->orderBy('id','desc')->paginate(150);
		    foreach($pars as $parss){
             $parss['cuecampaigns']=[];
			 $parr[]=$parss;
		     }
			 if($parr==NULL){
				 $arr = array('status'=>1, 'data'=>[]);
                  return response()->json($arr);
			 }
			 $arr = array('status'=>1, 'data'=>$parr);
            return response()->json($arr);
        }
        else{
			$parr=array();
			 $arr = array('status'=>1, 'data'=>[]);
            return response()->json($arr);
		}
		
		if($parr==NULL){
			$parr=array();
			 $arr = array('status'=>1, 'data'=>[]);
            return response()->json($arr);
		}
        

        $arr = array('status'=>1, 'data'=>$parr);
        return response()->json($arr);			
			
			
        
     }
    
    public function getallbanners(Request $request)
    {
       $countriedds=Country::first();
    //   $country_slug= $request->header('countryslug') ?? 'in';;
        $country_slug= $request->header('countryslug') ?? 'in';
		$countcheck=Country::where('slug',$country_slug)->first();
		if(!$countcheck){
			$arr = array('status'=>1, 'data'=>[]);
            return response()->json($arr);
		}
       $offset=1;
	   $check=DB::table('cuelink')->where('country_slug',$country_slug)->first();
	   $parr=NULL;
		if($check->status==1){
        $partners=Banner::with('cuelinkoffer')->where('country_slug',$country_slug)->paginate(150);
        $arr = array('status'=>1, 'data'=>$partners->items());
		return response()->json($arr);
		}else{
			
			$partners=Banner::paginate(15);
			foreach($partners as $parss){
				if(empty($parss['cuelinkoffer'])){
			 
			     $parr[]=$parss;
				}
		     }
			 
			 if($parr==NULL){
				 $parr2=[];
			 }else{
				 $parr2=$parr;
			 }
        $arr = array('status'=>1, 'data'=>$parr2);
		return response()->json($arr);
		}
		$arr = array('status'=>1, 'data'=>[]);
        return response()->json($arr);
    }
    
    public function offer_details(Request $request)
    {
    	 $countriedds=Country::first();
      $country_slug= $request->header('countryslug') ?? 'in';;
		$countcheck=Country::where('slug',$country_slug)->first();
		if(!$countcheck){
			$arr = array('status'=>1, 'data'=>NULL);
            return response()->json($arr);
		}
        $offset=1;
        $partners=CuelinkOffer::with('category')->where('country_slug',$country_slug)->where('id',$request->offer_id)->first();
            $campaign=CuelinkCampaign::with('partner')->where('country_slug',$country_slug)->where('campaign_id',$partners->campaign_id)->first();
            $partners->partner=$campaign->partner??NULL;
            if($partners->partner != NULL){
            $partners->coupon=Coupon::where('adv_id',$campaign->adv_id)->where('country_slug',$country_slug)->get();
            }else{
                $partners->coupon=NULL;
            }
            
        return response()->json($partners);
    }
    
    public function ads_details(Request $request)
    {
    	  $countriedds=Country::first();
       $country_slug= $request->header('countryslug') ?? 'in';;
		$countcheck=Country::where('slug',$country_slug)->first();
		if(!$countcheck){
			$arr = array('status'=>1, 'data'=>NULL);
            return response()->json($arr);
		}
        $offset=1;
        $partners=Offer::with('partner')->where('country_slug',$country_slug)->where('id',$request->ad_id)->first();
		if($partners){
        $partners->coupon=Coupon::where('adv_id',$partners->partner_id)->where('country_slug',$country_slug)->get();
		}else{
			$partners=[];
		}
        return response()->json($partners);
    }

    public function campaigns_details(Request $request)
    {
    	  $countriedds=Country::first();
		//   $country_slug= $request->header('countryslug') ?? $countriedds->slug;
        $country_slug= $request->header('countryslug') ?? 'in';
        $offset=1;
        $partners=CuelinkCampaign::with('partner')->where('country_slug',$country_slug)->where('id',$request->campaign_id)->first();
        $partners->coupon=Coupon::where('adv_id',$partners->adv_id)->where('country_slug',$country_slug)->get();
        return response()->json($partners);
    }
    
    public function seemorecampaigns(Request $request)
    {
    	  $countriedds=Country::first();
        $country_slug= $request->header('countryslug') ?? 'in';;
		$countcheck=Country::where('slug',$country_slug)->first();
		if(!$countcheck){
			$arr = array('status'=>1, 'data'=>[]);
            return response()->json($arr);
		}
        $offset=1;
		$check=DB::table('cuelink')->where('country_slug',$country_slug)->first();
	   $parr=NULL;
		if($check->status==1){
        $p=CuelinkCampaign::where('id',$request->campaign_id)->where('country_slug',$country_slug)->first();
        $partners=CuelinkCampaign::with('partner')->where('country_slug',$country_slug)->where('campaign_id',$p->campaign_id)->where('id','!=',$request->campaign_id)->get();
        $partnerr=NULL;
        foreach($partners as $part){
            $coupon=Coupon::where('adv_id',$part->adv_id)->where('country_slug',$country_slug)->get();
            $part->coupon=$coupon;
            $partnerr[]=$part;
        }
        }else{
			$partnerr=[];
		}
        $arr = array('status'=>1, 'data'=>$partnerr==NULL?[]:$partnerr);
        return response()->json($arr);
    }

  public function seemoreoffers(Request $request)
    {
    	  $countriedds=Country::first();
        $country_slug= $request->header('countryslug') ?? 'in';;
		$countcheck=Country::where('slug',$country_slug)->first();
		if(!$countcheck){
			$arr = array('status'=>1, 'data'=>[]);
            return response()->json($arr);
		}
        $offset=1;
	   $check=DB::table('cuelink')->first();
	   $parr=NULL;
		if($check->status==1){
        $p=CuelinkOffer::where('id',$request->offer_id)->first();
        
        $partners=CuelinkOffer::with('category')->where('campaign_id',$p->campaign_id)->where('country_slug',$country_slug)->where('id','!=',$request->offer_id)->get();
        foreach($partners as $part){
            $campaign=CuelinkCampaign::with('partner')->where('campaign_id',$part->campaign_id)->where('country_slug',$country_slug)->first();
            $part->partner=$campaign->partner??NULL;
            if($part->partner != NULL){
            $part->coupon=Coupon::where('adv_id',$campaign->adv_id)->where('country_slug',$country_slug)->get();
            }else{
                $part->coupon=NULL;
            }
            $partnerr[]=$part;
        }
		}else{
			$partnerr=[];
		}
        $arr = array('status'=>1, 'data'=>$partnerr);
        return response()->json($arr);
    }
    
    public function seemorads(Request $request)
    {
    	  $countriedds=Country::first();
        $country_slug= $request->header('countryslug') ?? 'in';;
		$countcheck=Country::where('slug',$country_slug)->first();
		if(!$countcheck){
			$arr = array('status'=>1, 'data'=>[]);
            return response()->json($arr);
		}
        $offset=1;
		 $check=DB::table('impact')->first();
	   $parr=NULL;
		if($check->status==1){
        $p=Offer::where('id',$request->ad_id)->first();
        
        $partners=Offer::with('partner')->where('partner_id',$p->partner_id)->where('country_slug',$country_slug)->where('id','!=',$request->ad_id)->get();
        $partnerr=NULL;
        foreach($partners as $part){
            $coupon=Coupon::where('adv_id',$part->partner_id)->where('country_slug',$country_slug)->get();
            $part->coupon=$coupon;
            $partnerr[]=$part;
        }
		}else{
			$partnerr=[];
		}
        $arr = array('status'=>1, 'data'=>$partnerr==NULL?[]:$partnerr);
        return response()->json($arr);
    }


    public function getalladmitadcampaigns(Request $request)
    {
    	  $countriedds=Country::first();
       $country_slug= $request->header('countryslug') ?? 'in';;
		$countcheck=Country::where('slug',$country_slug)->first();
		if(!$countcheck){
			$arr = array('status'=>1, 'data'=>[]);
            return response()->json($arr);
		}
        $offset=1;
		$check=DB::table('admitad')->where('country_slug',$country_slug)->first();
		if($check->status==1){
        $partners=Api_Advcampaign::Active()->with('partner','category')->where('country_slug',$country_slug)->paginate(150);
        $partnerr=NULL;
        foreach($partners->items() as $part){
            $coupon=Coupon::where('adv_id',$part->adv_id)->where('country_slug',$country_slug)->get();
            $part->coupon=$coupon;
            $partnerr[]=$part;
        }
		}else{
			$partnerr=[];
		}
        
        $arr = array('status'=>1, 'data'=>$partnerr==NULL?[]:$partnerr);
        return response()->json($arr);
    }

     public function seemoradmitadoffers(Request $request)
    {
    	  $countriedds=Country::first();
       $country_slug= $request->header('countryslug') ?? 'in';;
		$countcheck=Country::where('slug',$country_slug)->first();
		if(!$countcheck){
			$arr = array('status'=>1, 'data'=>[]);
            return response()->json($arr);
		}
        $offset=1;
		 $check=DB::table('admitad')->where('country_slug',$country_slug)->first();
	   $parr=NULL;
		if($check->status==1){
        $p=Api_Advcampaign::where('id',$request->id)->where('country_slug',$country_slug)->first();
        
        $partners=Api_Advcampaign::Active()->with('partner')->where('country_slug',$country_slug)->where('adv_id',$p->adv_id)->where('id','!=',$request->id)->get();
        $partnerr=NULL;
        foreach($partners as $part){
            $coupon=Coupon::where('adv_id',$part->adv_id)->where('country_slug',$country_slug)->get();
            $part->coupon=$coupon;
            $partnerr[]=$part;
        }
		}else{
			$partnerr=[];
		}
        $arr = array('status'=>1, 'data'=>$partnerr==NULL?[]:$partnerr);
        return response()->json($arr);
    }
     

    public function admitadoffer_details(Request $request)
    {
    	  $countriedds=Country::first();
       $country_slug= $request->header('countryslug') ?? 'in';;
		$countcheck=Country::where('slug',$country_slug)->first();
		if(!$countcheck){
			$arr = array('status'=>1, 'data'=>NULL);
            return response()->json($arr);
		}
        $offset=1;
        $partners=Api_Advcampaign::with('partner')->where('country_slug',$country_slug)->where('id',$request->id)->first();
		if($partners){
        $partners->coupon=Coupon::where('adv_id',$partners->adv_id)->where('country_slug',$country_slug)->get();
		}else{

			$partners=NULL;
		}
        return response()->json($partners);
    } 
}
