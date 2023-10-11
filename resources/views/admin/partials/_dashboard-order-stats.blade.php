<?php  
     foreach ($params as $key => $value) {
            if ($key == 'sales') {
                $sa = $params['sales'];
           }else{
              $sa="thirty_days";
            }
		 
             if ($key == 'admin_earning') {
                $reven = $params['admin_earning'];
           }else{
              $reven="thirty_days";
            }

            if ($key == 'new_user') {
                $new = $params['new_user'];
           }else{
              $new="thirty_days";
            }
            if ($key == 'user_earning') {
                $ac = $params['user_earning'];
           }else{
              $ac="thirty_days";
            }
           
            }
          
      
  ?> 
 @php($name=\App\Models\BusinessSetting::where('key','currency')->first()->value)
 @php($currency=\App\Models\Currency::where('currency_code',$name)->first())
<div class="col-sm-6 col-lg-3">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex align-items-center">
                      <div class="subheader">Orders</div>
                       <div class="ms-auto lh-1">
                        <div class="dropdown">
                          <a class="dropdown-toggle text-muted" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">@if($params['sales']=="seven_days") Seven Days @endif @if($params['sales']=="thirty_days") Thirty Days @endif @if($params['sales']=="ninety_days") Ninety Days @endif @if($params['sales']=="overall") Overall @endif</a>
                          <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="{{url('/')}}?sales=seven_days&admin_earning={{$reven}}&new_user={{$new}}&user_earning={{$ac}}">Last Seven Days</a>
                            <a class="dropdown-item" href="{{url('/')}}?sales=thirty_days&admin_earning={{$reven}}&new_user={{$new}}&user_earning={{$ac}}">Last Thirty Days</a>
                            <a class="dropdown-item"  href="{{url('/')}}?sales=ninety_days&admin_earning={{$reven}}&new_user={{$new}}&user_earning={{$ac}}">Last Ninety Days</a>
                            <a class="dropdown-item"  href="{{url('/')}}?sales=overall&admin_earning={{$reven}}&new_user={{$new}}&user_earning={{$ac}}">Overall</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="h1 mb-3">{{ $sales }}</div>
                  </div>
                  <div id="team-chart1" class="chart-sm"></div>
                </div>
              </div>
              
<div class="col-sm-6 col-lg-3">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex align-items-center">
                      <div class="subheader">Admin Earning</div>
                       <div class="ms-auto lh-1">
                        <div class="dropdown">
                          <a class="dropdown-toggle text-muted" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">@if($params['admin_earning']=="seven_days") Seven Days @endif @if($params['admin_earning']=="thirty_days") Thirty Days @endif @if($params['admin_earning']=="ninety_days") Ninety Days @endif @if($params['admin_earning']=="overall") Overall @endif</a>
                          <div class="dropdown-menu dropdown-menu-end">
                              <a class="dropdown-item" href="{{url('/')}}?sales={{$sa}}&admin_earning=seven_days&new_user={{$new}}&user_earning={{$ac}}">Last Seven Days</a>
                            <a class="dropdown-item" href="{{url('/')}}?sales={{$sa}}&admin_earning=thirty_days&new_user={{$new}}&user_earning={{$ac}}">Last Thirty Days</a>
                            <a class="dropdown-item"  href="{{url('/')}}?sales={{$sa}}&admin_earning=ninety_days&new_user={{$new}}&user_earning={{$ac}}">Last Ninety Days</a>
                            <a class="dropdown-item"  href="{{url('/')}}?sales={{$sa}}&admin_earning=overall&new_user={{$new}}&user_earning={{$ac}}">Overall</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="d-flex align-items-baseline">
                      <div class="h1 mb-3 me-2">{{$currency->currency_symbol}}{{round($revenue,0)}}</div>
                      <div class="me-auto">
                        <span class="text-red d-inline-flex align-items-center lh-1">
                          {{$currency->currency_symbol}}{{round($revenue1,0)}}<!-- Download SVG icon from http://tabler-icons.io/i/trending-up -->
                          pending
                        </span>
                      </div>
                    </div>
                    
                  </div>
                  <div id="chart-revenue-bg" class="chart-mentions"></div>
                </div>
              </div>
     <div class="col-sm-6 col-lg-3">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex align-items-center">
                      <div class="subheader">User Earning</div>
                       <div class="ms-auto lh-1">
                        <div class="dropdown">
                          <a class="dropdown-toggle text-muted" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">@if($params['user_earning']=="seven_days") Seven Days @endif @if($params['user_earning']=="thirty_days") Thirty Days @endif @if($params['user_earning']=="ninety_days") Ninety Days @endif @if($params['user_earning']=="overall") Overall @endif</a>
                          <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="{{url('/')}}?sales={{$sa}}&admin_earning={{$reven}}&new_user={{$new}}&user_earning=seven_days">Last Seven Days</a>
                            <a class="dropdown-item" href="{{url('/')}}?sales={{$sa}}&admin_earning={{$reven}}&new_user={{$new}}&user_earning=thirty_days">Last Thirty Days</a>
                            <a class="dropdown-item"  href="{{url('/')}}?sales={{$sa}}&admin_earning={{$reven}}&new_user={{$new}}&user_earning=ninety_days">Last Ninety Days</a>
                            <a class="dropdown-item"  href="{{url('/')}}?sales={{$sa}}&admin_earning={{$reven}}&new_user={{$new}}&user_earning=overall">Overall</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="d-flex align-items-baseline">
                      <div class="h1 mb-3 me-2">{{$currency->currency_symbol}}{{round($userrevenue,2)}}</div>
                       <div class="me-auto">
                        <span class="text-red d-inline-flex align-items-center lh-1">
                          {{$currency->currency_symbol}}{{round($userrevenue1,0)}}<!-- Download SVG icon from http://tabler-icons.io/i/trending-up -->
                          pending
                        </span>
                      </div>
                    </div>
                    
                  </div>
                  <div id="act-user-bg" class="chart-mentions"></div>
                </div>
              </div>
              <div class="col-sm-6 col-lg-3">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex align-items-center">
                      <div class="subheader">New Users</div>
                       <div class="ms-auto lh-1">
                        <div class="dropdown">
                          <a class="dropdown-toggle text-muted" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">@if($params['new_user']=="seven_days") Seven Days @endif @if($params['new_user']=="thirty_days") Thirty Days @endif</a>
                          <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="{{url('/')}}?sales={{$sa}}&admin_earning={{$reven}}&new_user=seven_days&user_earning={{$ac}}">Last Seven Days</a>
                            <a class="dropdown-item" href="{{url('/')}}?sales={{$sa}}&admin_earning={{$reven}}&new_user=thirty_days&user_earning={{$ac}}">Last Thirty Days</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="d-flex align-items-baseline">
                      <div class="h1 mb-3 me-2">{{$newuser}}</div>
                    
                    </div>
                    
                  </div>
                  <div id="chart-new-clients" class="chart-sm"></div>
                </div>
              </div>

            