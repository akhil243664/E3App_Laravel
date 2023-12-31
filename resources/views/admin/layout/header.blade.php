<?php  $admin = \App\Models\Admin::find(auth('admin')->id()); 
?>

@php($neworders=\DB::table('orders')->where('country_slug',$admin->country_slug)->where('notify',0)->get())
@php($newwd=\DB::table('withdrawal_reqs')->where('country_slug',$admin->country_slug)->where('approved',0)->where('notify',0)->get())
@php($cont=\DB::table('users')->where('country_slug',$admin->country_slug)->where('is_phone_verified',0)->where('notify',0)->get())
@php($sc=\DB::table('offers')->where('country_slug',$admin->country_slug)->where('notify',0)->get())
@php($sr=\DB::table('cuelink_campaigns')->where('country_slug',$admin->country_slug)->where('notify',0)->get())
@php($or=\DB::table('cuelink_offers')->where('country_slug',$admin->country_slug)->where('notify',0)->get())
@php($com=\DB::table('complains')->where('country_slug',$admin->country_slug)->where('complain',0)->where('notify',0)->get())
@php($adv=\DB::table('partners')->where('country_slug',$admin->country_slug)->where('notify',0)->get())

 @php($name=\App\Models\BusinessSetting::where('key','currency')->first()->value)
 @php($currency=\App\Models\Currency::where('currency_code',$name)->first())
<?php $result=array();
   
foreach($neworders as $new){
	$newcheck=array('id'=>1,'title'=>'New Order','message'=>'New Order Created ('.$new->partner_order_id.').','dated'=>date('F jS, Y', strtotime($new->created_at)));
	array_push($result,$newcheck);
}
foreach($newwd as $new1){
	$newcheck1=array('id'=>2,'title'=>'Withdrawal request','message'=>'New Withdrawal Request Received ('.$currency->currency_symbol.$new1->amount.').','dated'=>date('F jS, Y', strtotime($new1->created_at)) );
	array_push($result,$newcheck1);
}
foreach($cont as $new2){
	$newcheck2=array('id'=>3,'title'=>'New User','message'=>'New User Registered ('.$new2->phone.').','dated'=>date('F jS, Y', strtotime($new2->created_at)));
	array_push($result,$newcheck2);
}
foreach($sc as $new3){
	$newcheck3=array('id'=>4,'title'=>'New Ad','message'=>'New Advertisement Added ('.$new3->name.').','dated'=>date('F jS, Y', strtotime($new3->created_at)));
	array_push($result,$newcheck3);
}
foreach($sr as $new4){
	$newcheck4=array('id'=>5,'title'=>'New Campaign','message'=>'New Campaign Added ('.$new4->name.').','dated'=>date('F jS, Y', strtotime($new4->created_at)));
	array_push($result,$newcheck4);
}
foreach($or as $new5){
	$newcheck5=array('id'=>6,'title'=>'New Offer','message'=>'New Offer Added ('.$new5->name.').','dated'=>date('F jS, Y', strtotime($new5->created_at)));
	array_push($result,$newcheck5);
}

foreach($adv as $new6){
	$newcheck6=array('id'=>7,'title'=>'New Advertiser','message'=>'New Advertiser Added ('.$new6->name.').','dated'=>date('F jS, Y', strtotime($new6->created_at)));
	array_push($result,$newcheck6);
}

foreach($com as $new7){
	$newcheck7=array('id'=>8,'title'=>'New Complaint','message'=>'New Complaint received ('.$new7->complain.').','dated'=>date('F jS, Y', strtotime($new7->created_at)));
	array_push($result,$newcheck7);
}
$result = collect($result)->sortByDesc('dated')->all();


?>
 <header class="navbar navbar-expand-md navbar-light d-none d-lg-flex d-print-none navbar-fixed fixed">
        <div class="container-xl">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
            <span class="navbar-toggler-icon"></span>
          </button>
         <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">

                       
                    
          </h1>
          <div class="navbar-nav flex-row order-md-last" style="float: right !important;">
			    @if(\App\CentralLogics\Helpers::module_permission_check('notifications'))
            <div class="nav-item d-none d-md-flex me-3">
              <div class="btn-list">
                <a href="{{Route('admin.notification.index')}}" class="notification" target="_blank" rel="noreferrer">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-bell" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
   <path d="M10 5a2 2 0 0 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6"></path>
   <path d="M9 17v1a3 3 0 0 0 6 0v-1"></path>
</svg> 
                 Send Notification
                </a>
              </div>
            </div>
			     @endif
         
            <div align="right" style="margin-top:6px">
             
              @if(auth('admin')->user()->role_id == 1)
                @php($de_co=\App\Models\Country::get())
                <select class="form-control changeCountry">
                    @foreach($de_co as  $de_country)
                            <option value="{{$de_country->slug}}" @if(auth('admin')->user()->country_slug==$de_country->slug) selected @endif>{{$de_country->country_name}} </option>
                       @endforeach
                </select>
              @else
                   
                   {{auth('admin')->user()->country_slug}}

              @endif
             
            </div>
            <div class="d-none d-md-flex">
					<div class="nav-item dropdown d-none d-md-flex me-3">
                <a href="#" class="nav-link" data-bs-toggle="dropdown" tabindex="-1" aria-label="Show notifications">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 5a2 2 0 0 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" /><path d="M9 17v1a3 3 0 0 0 6 0v-1" /></svg>
                  @if(count($sr) > 0 || count($sc) > 0 || count($newwd)>0 || count($neworders)>0 || count($cont)>0 || count($or)>0 || count($com)>0 || count($adv)>0)<span class="badge bg-red">{{count($sr) + count($sc) + count($newwd) + count($neworders) + count($cont) + count($or) + count($com) + count($adv)}}</span> @endif 
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-end dropdown-menu-card">
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Latest Updates</h3>
                    </div>
                    <div class="list-group list-group-flush list-group-hoverable">
						 @foreach($result as $res)
						
                      <div class="list-group-item">
						 
                        <div class="row align-items-center">
                          <div class="col-auto"><span @if($res['id']==1 || $res['id'] == 6 || $res['id'] == 7 ) class="status-dot status-dot-animated bg-green d-block" @endif @if($res['id']==2) class="status-dot status-dot-animated bg-yellow d-block" @endif @if($res['id']==3) class="status-dot status-dot-animated bg-orange d-block" @endif @if($res['id']==4 || $res['id']==8) class="status-dot status-dot-animated bg-red d-block" @endif @if($res['id']==5) class="status-dot status-dot-animated bg-black d-block" @endif></span></div>
                          <div class="col text-truncate">
                            <a @if($res['id']==1) href="{{ url('/records/orders') }}" @endif @if($res['id']==2) href="{{ url('/records/withdraw_requests') }}" @endif @if($res['id']==3) href="{{ url('/customer/list') }}" @endif @if($res['id']==4) href="{{ url('/ads/list') }}" @endif @if($res['id']==5) href="{{ url('/cuelinkscampaigns/list') }}" @endif @if($res['id']==6) href="{{ url('/cuelinksoffers/list') }}" @endif @if($res['id']==7) href="{{ url('/advertiser/list') }}" @endif @if($res['id']==8) href="{{ url('/records/complaint') }}" @endif class="text-body d-block">{{Str::limit($res['title'],30)}}</a>
                            <div class="d-block text-muted mt-n1">
                             {{Str::limit($res['message'],30)}}
                            </div>
                          </div>
                          <div class="col-auto">                           
                             {{date('d F',strtotime($res['dated']))}}
                          </div>
                        </div>
                      </div>
						  
						@endforeach
                    </div>
                  </div>
                </div>
              </div>
              <a href="?theme=dark" class="nav-link px-0 hide-theme-dark" title="Enable dark mode" data-bs-toggle="tooltip"
		   data-bs-placement="bottom">
                <!-- Download SVG icon from http://tabler-icons.io/i/moon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z" /></svg>
              </a>
              <a href="?theme=light" class="nav-link px-0 hide-theme-light" title="Enable light mode" data-bs-toggle="tooltip"
		   data-bs-placement="bottom">
                <!-- Download SVG icon from http://tabler-icons.io/i/sun -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="4" /><path d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7" /></svg>
              </a>
              <img class="avatar avatar-sm"
                                        onerror="this.src='{{asset('assets/theme_assets/img')}}/upload1.png'"
                                        src="{{asset('storage/app/public/admin/'.auth('admin')->user()->image)}}" alt="logo image" style="margin: 7px !important;"/>
            </div>
            <div class="nav-item dropdown">
              <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
              

              
                
                <div class="d-none d-xl-block ps-2">
                  <div> {{auth('admin')->user()->f_name}}</div>
                  <div class="mt-1 small text-muted"> {{auth('admin')->user()->email}}</div>
                </div>
              </a>
              <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <a href="{{route('admin.settings')}}" class="dropdown-item">Profile Settings</a>
                <div class="dropdown-divider"></div>
                <a href="{{route('admin.auth.logout')}}" class="dropdown-item">Logout</a>
              </div>
            </div>
          </div>
        </div>
      </header>
       <script type="text/javascript">
    
    var url2 = "{{ route('changeCountry') }}";
  
    $(".changeCountry").change(function(){
        window.location.href = url2 + "?country="+ $(this).val();
    });
  
</script>


<script type="text/javascript">
    
    var url = "{{ route('changeLang') }}";
    
    $(".changeLang").change(function(){
        window.location.href = url + "?lang="+ $(this).val();
    });
    
</script>

        @yield('jquery')
  
