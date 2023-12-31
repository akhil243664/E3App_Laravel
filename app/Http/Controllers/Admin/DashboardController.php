<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; 
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Complain;
use App\Models\WithdrawalReq;
use App\Models\Click;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {

    	

    	$admin = Admin::find(auth('admin')->id());
		$sid = 1;
		$params = [
            'sales' => $request['sales'] ?? 'thirty_days',
            'admin_earning' => $request['admin_earning'] ?? 'thirty_days',
            'new_user'=> $request['new_user'] ?? 'thirty_days',
            'user_earning'=>$request['user_earning'] ?? 'thirty_days',
        ];
       $check= session()->put('dash_params', $params);
     
        $t =$request['sales'];
        $e=$request['admin_earning'];
		$ue=$request['user_earning'];
        $n=$request['new_user'];
        $country_slug=$admin->country_slug;
	   $sales = Order::orderdataCheckdays($t,$country_slug);
		
       $newuser=Order::newclient($n,$country_slug);  
		
       $revenue= Order::adminrevenuedataCheckdays($e,$country_slug)['sum1'];

	   $userrevenue= Order::userevenuedataCheckdays($ue,$country_slug)['sum1'];
	   $revenue1= Order::adminrevenuedataCheckdays($e,$country_slug)['sum2'];
	   $userrevenue1= Order::userevenuedataCheckdays($ue,$country_slug)['sum2'];
       $ordgraph=Order::orderdataGraph($t,$country_slug);
       $ordgv=$ordgraph['value'];
       $ordgd=$ordgraph['date'];


       $revgraph=Order::adminrevenuedataGraph($e,$country_slug);
       $revgv=$revgraph['value'];
       $pgv=$revgraph['value2'];
       $revgd=$revgraph['date'];
		
	   $usegraph=Order::userrevenuedataGraph($ue,$country_slug);
       $usrevgv=$usegraph['value'];
       $usrpgv=$usegraph['value2'];
       $usrevgd=$usegraph['date'];
		
       $ncgraph=Order::newclientGraph($n,$country_slug);
       $ncgv=$ncgraph['value'];
       $ncgv2=$ncgraph['value2'];
       $ncgd=$ncgraph['date1'];
       $today = date('d F Y');

		
		$data1 = date('Y-m-d');
		$data2 = date('Y-m-d', strtotime('-1 days'));
		$data3 = date('Y-m-d', strtotime('-2 days'));
		$data4 = date('Y-m-d', strtotime('-3 days'));
		$data5 = date('Y-m-d', strtotime('-4 days'));
		$data6 = date('Y-m-d', strtotime('-5 days'));
		$data7 = date('Y-m-d', strtotime('-6 days'));
		
		$totalclicks=DB::table('clicks')->where('country_slug',$country_slug)->count();
		$todayclicks=DB::table('clicks')->whereDate('created_at',$data1)->where('country_slug',$country_slug)->count();
		
		$totalcam=DB::table('cuelink_campaigns')->where('country_slug',$country_slug)->count();
		$todaycam=DB::table('cuelink_campaigns')->where('country_slug',$country_slug)->whereDate('created_at',$data1)->count();
		
		$totaloffers=DB::table('cuelink_offers')->where('country_slug',$country_slug)->count();
		$todayoffers=DB::table('cuelink_offers')->where('country_slug',$country_slug)->whereDate('created_at',$data1)->count();
		
        $totalads=DB::table('offers')->where('country_slug',$country_slug)->count();
		$todayads=DB::table('offers')->where('country_slug',$country_slug)->whereDate('created_at',$data1)->count();
		
		$totalwqs=DB::table('withdrawal_reqs')->where('country_slug',$country_slug)->count();
		$todaywqs=DB::table('withdrawal_reqs')->where('country_slug',$country_slug)->whereDate('created_at',$data1)->count();
		
		$totalcoms=DB::table('complains')->where('country_slug',$country_slug)->count();
		$todaycoms=DB::table('complains')->where('country_slug',$country_slug)->whereDate('created_at',$data1)->count();

         $clicks = Click::with('user')->where('country_slug',$country_slug)->orderBy('id','desc')->paginate(10,['*'], 'clicks');
		 $orders = Order::with('user')->where('country_slug',$country_slug)->orderBy('id','desc')->paginate(10,['*'], 'orders');
		  $reqs = WithdrawalReq::with('user')->where('country_slug',$country_slug)->orderBy('id','desc')->paginate(5,['*'], 'reqs');
		 $complains=Complain::with('user')->orderBy('id','desc')->where('country_slug',$country_slug)->paginate(5,['*'], 'complains');


		return view('admin.dashboard', [ 'todays' => $today, 'params'=>$params,'sales'=>$sales,'revenue'=>$revenue,'userrevenue'=>$userrevenue,'newuser'=>$newuser,'ordgv'=>$ordgv,'ordgd'=>$ordgd,'revgv'=>$revgv,'revgd'=>$revgd,'ncgv'=>$ncgv,'ncgd'=>$ncgd,'ncgv2'=>$ncgv2,'usrevgv'=>$usrevgv,'usrevgd'=>$usrevgd,'totalclicks'=>$totalclicks,'todayclicks'=>$todayclicks,'totalcam'=>$totalcam,'todaycam'=>$todaycam,'totaloffers'=>$totaloffers,'todayoffers'=>$todayoffers,'totalcoms'=>$totalcoms,'todaycoms'=>$todaycoms,'totalwqs'=>$totalwqs,'todaywqs'=>$todaywqs,'totalads'=>$totalads,'todayads'=>$todayads, 'clicks'=>$clicks, 'complains'=>$complains,'reqs'=>$reqs,'orders'=>$orders,'usrpgv'=>$usrpgv,'pgv'=>$pgv,'revenue1'=>$revenue1,'userrevenue1'=>$userrevenue1 ]);

       
    }

   

  
}
