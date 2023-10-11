@extends('admin.layout.app')
<?php  header('Access-Control-Allow-Origin: *');
  header('Content-type: application/json'); ?>
@section('title','Dashboard')
   
<?php
  foreach ($params as $key =>$value) {
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
@push('css_or_js')
 <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .grid-card {
            border: 2px solid #00000012;
            border-radius: 10px;
            padding: 10px;
        }

        .label_1 {
            position: absolute;
            font-size: 10px;
            background: #865439;
            color: #ffffff;
            width: 60px;
            padding: 2px;
            font-weight: bold;
            border-radius: 6px; 
        }
     
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
@endpush
@section('content')
<div class="page-header d-print-none" style="border-bottom:none !important">
          <div class="container-xl">
            <div class="row g-2 align-items-center">
              <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                   Overview
                </div>
                <h2 class="page-title">
                  Welcome to Dashboard
                </h2>
              </div>
             
            </div>
          </div>
        </div>
        <!-- Page body -->
        <div class="page-body">
          <div class="container-xl">

          <div class="row row-deck row-cards" id="order_stats">
            @include('admin.partials._dashboard-order-stats',['sales'=>$sales,'revenue'=>$revenue,'ordgv'=>$ordgv,'ordgd'=>$ordgd,'newuser'=>$newuser,'ncgv'=>$ncgv,'ncgv2'=>$ncgv2,'ncgd'=>$ncgd,'userrevenue'=>$userrevenue,'usrevgv'=>$usrevgv,'usrevgd'=>$usrevgd])

              
        <div class="col-12">
                <div class="row row-cards">
                  <div class="col-sm-12 col-lg-2">
                    <div class="card card-sm">
                      <div class="card-body">
                        <div class="row align-items-center">
                          <div class="col-auto">
                            <span class="bg-blue text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar -->
                              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-database" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                   <ellipse cx="12" cy="6" rx="8" ry="3"></ellipse>
                                   <path d="M4 6v6a8 3 0 0 0 16 0v-6"></path>
                                   <path d="M4 12v6a8 3 0 0 0 16 0v-6"></path>
                                </svg>
                            </span>
                          </div>
                          <div class="col">
                            <div class="font-weight-medium">
                             {{ $totalcam }}  Campaigns
                            </div>
                            <div class="text-muted">
                              {{$todaycam}}  Today
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-12 col-lg-2">
                    <div class="card card-sm">
                      <div class="card-body">
                        <div class="row align-items-center">
                          <div class="col-auto">
                            <span class="bg-green text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/shopping-cart -->
                              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-package" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                   <polyline points="12 3 20 7.5 20 16.5 12 21 4 16.5 4 7.5 12 3"></polyline>
                                   <line x1="12" y1="12" x2="20" y2="7.5"></line>
                                   <line x1="12" y1="12" x2="12" y2="21"></line>
                                   <line x1="12" y1="12" x2="4" y2="7.5"></line>
                                   <line x1="16" y1="5.25" x2="8" y2="9.75"></line>
                                </svg>
                            </span>
                          </div>
                          <div class="col">
                            <div class="font-weight-medium">
                             {{ $totaloffers }}  Offers
                            </div>
                            <div class="text-muted">
                             {{ $todayoffers }}  Today
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-12 col-lg-2">
                    <div class="card card-sm">
                      <div class="card-body">
                        <div class="row align-items-center">
                          <div class="col-auto">
                            <span class="bg-twitter text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/brand-twitter -->
                             <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-social" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                               <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                               <circle cx="12" cy="5" r="2"></circle>
                               <circle cx="5" cy="19" r="2"></circle>
                               <circle cx="19" cy="19" r="2"></circle>
                               <circle cx="12" cy="14" r="3"></circle>
                               <line x1="12" y1="7" x2="12" y2="11"></line>
                               <line x1="6.7" y1="17.8" x2="9.5" y2="15.8"></line>
                               <line x1="17.3" y1="17.8" x2="14.5" y2="15.8"></line>
                            </svg>
                            </span>
                          </div>
                          <div class="col">
                            <div class="font-weight-medium">
                             {{$totalads}}  Ads
                            </div>
                            <div class="text-muted">
                              {{$todayads}}  Today
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-sm-12 col-lg-2">
                    <div class="card card-sm">
                      <div class="card-body">
                        <div class="row align-items-center">
                          <div class="col-auto">
                            <span class="bg-youtube text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/brand-twitter -->
                               <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-coin-rupee" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
   <circle cx="12" cy="12" r="9"></circle>
   <path d="M15 8h-6h1a3 3 0 0 1 0 6h-1l3 3"></path>
   <path d="M9 11h6"></path>
</svg>
                             
                            </span>
                          </div>
                          <div class="col">
                            <div class="font-weight-medium">
                             {{$totalwqs}} Withdrawals
                            </div>
                            <div class="text-muted">
                              {{$todaywqs}} Today
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-12 col-lg-2">
                    <div class="card card-sm">
                      <div class="card-body">
                        <div class="row align-items-center">
                          <div class="col-auto">
                            <span class="bg-linkedin text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/brand-facebook -->
                             <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-alert-octagon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
   <path d="M8.7 3h6.6c.3 0 .5 .1 .7 .3l4.7 4.7c.2 .2 .3 .4 .3 .7v6.6c0 .3 -.1 .5 -.3 .7l-4.7 4.7c-.2 .2 -.4 .3 -.7 .3h-6.6c-.3 0 -.5 -.1 -.7 -.3l-4.7 -4.7c-.2 -.2 -.3 -.4 -.3 -.7v-6.6c0 -.3 .1 -.5 .3 -.7l4.7 -4.7c.2 -.2 .4 -.3 .7 -.3z"></path>
   <line x1="12" y1="8" x2="12" y2="12"></line>
   <line x1="12" y1="16" x2="12.01" y2="16"></line>
</svg>
                         </span>
                          </div>
                          <div class="col">
                            <div class="font-weight-medium">
                              {{ $totalcoms }} Complaints
                            </div>
                            <div class="text-muted">
                              {{ $todaycoms }} Today
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-12 col-lg-2">
                    <div class="card card-sm">
                      <div class="card-body">
                        <div class="row align-items-center">
                          <div class="col-auto">
                            <span class="bg-warning text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/brand-facebook -->
                             <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-click" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
   <line x1="3" y1="12" x2="6" y2="12"></line>
   <line x1="12" y1="3" x2="12" y2="6"></line>
   <line x1="7.8" y1="7.8" x2="5.6" y2="5.6"></line>
   <line x1="16.2" y1="7.8" x2="18.4" y2="5.6"></line>
   <line x1="7.8" y1="16.2" x2="5.6" y2="18.4"></line>
   <path d="M12 12l9 3l-4 2l-2 4l-3 -9"></path>
</svg>
                            </span>
                          </div>
                          <div class="col">
                            <div class="font-weight-medium">
                              {{ $totalclicks }} Clicks
                            </div>
                            <div class="text-muted">
                             {{ $todayclicks }} Today
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
        
        
        <div class="col-12 col-md-6 col-lg-6">
                <div class="card">

          <div class="card-header">
          <h2 class="page-title" style="float:left; width: 100%;">
            Customer Withdrawal Requests List
                         
                      </h2>
           <a  style="float:right !important;" href="{{route('admin.records.withdraw_requests')}}" class="btn btn-primary  float-right">View All</a></div>
              <div class="card-body">
                <div class="table" style="width:100%">
                  <table id="example2" class="display" style="width:100%">
                    <thead>
                      <tr>
                         <th><button class="table-sort" data-sort="sort-s">#</button></th>
                         <th><button class="table-sort" data-sort="sort-name">User</button></th>
                        <th><button class="table-sort" data-sort="sort-email">Amount</button></th>
              <th><button class="table-sort" data-sort="sort-email">Withdrawal Medium</button></th>
                        <th><button class="table-sort" data-sort="sort-phone">Status</button></th>
                        <th><button class="table-sort" data-sort="sort-role">Action</button></th>
                      </tr>
                    </thead>
                    <tbody class="table-tbody">
                  
                           @foreach($reqs as $k=>$e)
                                <tr>
                                    <td id="row">{{$k+$reqs->firstItem()}}</td>
                              
                             
                                    <td class="sort-name">@if($e->user != NULL) {{$e->user['name']}} @else <b style="color:red"> User Deleted @endif</td>
                                     <td class="sort-email">{{$e['amount']}}
                    </td>
                  <td class="sort-email"><b>{{$e['medium']}}</b><br>{!! $e['medium_details'] !!}
                    </td>
                                     <td class="sort-phone">@if($e['approved']==0) <p style="color:orange">Not Approved Yet</p>@elseif($e['approved']==2) <p style="color:red">Rejected </p>@else  <p style="color:green">Approved</p>@endif
                  </td>
                                      <td class="sort-phone">@if($e['approved']==0) <a href="{{route('admin.customer.approve_withdraw_requests',$e['id'])}}" class="btn btn-primary" >Approve</a>&nbsp;&nbsp; <a href="{{route('admin.customer.reject_withdraw_requests',$e['id'])}}" class="btn btn-danger" >Reject</a>@elseif($e['approved']==2) <p style="color:red">Rejected </p>@else  <p style="color:green">Approved</p>@endif
                  </td>
                                   
                                </tr>
            <!-- Modal -->
                
                            @endforeach
                        
                    </tbody>
                  </table>
                </div>
              </div>
              
            </div>
              </div>
          <div class="col-12 col-md-6 col-lg-6">
          <div class="card">
                 <div class="card-header">
          <h2 class="page-title" align="left" style="width: 100%;">
                        Customer Complaint List
                      </h2>
           <a  align="right" style="float:right !important;" href="{{route('admin.records.complaint')}}" class="btn btn-primary  float-right">View All</a></div>
              <div class="card-body">
                 <div class="table" style="width:100%">
                  <table id="example" class="display" style="width:100%">
                    <thead>
                      <tr>
                         <th><button class="table-sort" data-sort="sort-s">#</button></th>
                         <th><button class="table-sort" data-sort="sort-name">User</button></th>
                        <th><button class="table-sort" data-sort="sort-email">Order ID</button></th>
              <th><button class="table-sort" data-sort="sort-email">Complaint</button></th>
                        <th><button class="table-sort" data-sort="sort-phone">Status</button></th>
                        <th><button class="table-sort" data-sort="sort-role">Action</button></th>
                      </tr>
                    </thead>
                    <tbody class="table-tbody">
                      
                           @foreach($complains as $k=>$e)
                                <tr>
                                    <td id="row">{{$k+$complains->firstItem()}}</td>
                              
                             
                                    <td class="sort-name">{{$e['user']['name']?? 'user deleted'}}</td>
                                     <td class="sort-email">{{$e['order_id']}}
                    </td>
                  <td class="sort-email"><b>{{$e['complain']}}</b>
                    </td>
                                     <td class="sort-phone">@if($e['status']==0) <p style="color:orange">Not Replied Yet</p>@else  <p style="color:green">Replied</p>@endif
                  </td>
                                      <td class="sort-phone">@if($e['status']==0) <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal{{$e->id}}">
                      Reply</button>@else  <p style="color:green">Replied<br><b style="color:black">Reply: </b><span style="color:black">{{$e['reply']}}</span></p>@endif
                  </td>
                                   
                                </tr>
            
                            @endforeach
                        
                    </tbody>
                  </table>
                </div>
              </div>
             
            </div>
                
              </div>
              <div class="col-md-12 col-lg-12">
                <div class="card">
          <div class="card-header">
          <h2 class="page-title" align="left" style="width: 100%;">
                        Customer CLicks List
                      </h2>
           <a  align="right" style="float:right !important;" href="{{route('admin.records.clicks')}}" class="btn btn-primary  float-right">View All</a></div>
                
              <div class="card-body">
               <div class="table" style="width:100%">
                  <table id="example3" class="display" style="width:100%">
                    <thead>
                      <tr>
                         <th><button class="table-sort" data-sort="sort-s">#</button></th>
                         <th><button class="table-sort" data-sort="sort-name">User</button></th>
                        <th><button class="table-sort" data-sort="sort-email">Click ID</button></th>
              <th><button class="table-sort" data-sort="sort-email">Image</button></th>
                        <th><button class="table-sort" data-sort="sort-phone">URL</button></th>
                <th><button class="table-sort" data-sort="sort-phone">Created At</button></th>
                      </tr>
                    </thead>
                    <tbody class="table-tbody">
               
                           @foreach($clicks as $k=>$e)
                                <tr>
                                    <td id="row">{{$k+$clicks->firstItem()}}</td>
                              
                             
                                    <td class="sort-name">{{$e['user']['name']?? 'user deleted'}}</td>
                                     <td class="sort-email">{{$e['id']}}
                    </td>
                  <td class="sort-email"><img width="100px" src="{{$e['image']}}" onerror="this.src='{{url('/')}}/storage/app/public/images/noimage.png'" alt="no image" >
                    </td>
                                     <td class="sort-email"><span>{{$e['tracking_link']}} </span>
                    </td>
                  
                   <td class="sort-email">{{date('d-M-Y',strtotime($e['created_at']))}}
                    </td>
                                   
                                </tr>
            
                            @endforeach
                        
                    </tbody>
                  </table>
                </div>
              </div>
              
            </div>
              </div>
              <div class="col-12">
                    <div class="card">
                <div class="card-header">
          <h2 class="page-title" align="left" style="width: 100%;">
                        Customer Orders List
                      </h2>
           <a  align="right" style="float:right !important;" href="{{route('admin.records.orders')}}" class="btn btn-primary  float-right">View All</a></div>
              <div class="card-body">
                 <div class="table" style="width:100%">
                  <table id="example4" class="display" style="width:100%">
                  <thead>
                      <tr>
                         <th><button class="table-sort" data-sort="sort-s">#</button></th>
             <th><button class="table-sort" data-sort="sort-name">Image</button></th>
                         <th><button class="table-sort" data-sort="sort-name">User</button></th>
                         <th><button class="table-sort" data-sort="sort-email">Order ID</button></th>
             <th><button class="table-sort" data-sort="sort-id">Partner Order ID</button></th>
             <th><button class="table-sort" data-sort="sort-phone">Advertiser</button></th>
                         <th><button class="table-sort" data-sort="sort-partner">Affiliate Partner</button></th>
              <th><button class="table-sort" data-sort="sort-order">Commission Status</button></th>
             <th><button class="table-sort" data-sort="sort-order">Order Amount</button></th>
              <th><button class="table-sort" data-sort="sort-url">Admin Earning</button></th>
                 <th><button class="table-sort" data-sort="sort-earning">User Earning</button></th>
                      </tr>
                    </thead>
                    <tbody class="table-tbody">
             
                           @foreach($orders as $k=>$e)
                                <tr>
                                    <td id="row" class="sort-s">{{$k+$orders->firstItem()}}</td>
                    <td>
                                 
                               <img src="{{asset('storage/app/public/partner')}}/{{$e['logo']}}" alt="no image" style="width:80px">
                              
                                </td>
                                    <td class="sort-name">@if($e['user']) {{$e['user']['name']??"No name"}} <br> {{$e['user']['email']}} @else User Deleted @endif </td>
                                     <td class="sort-email"> {{$e['id']}}</td>
                  <td class="sort-id"> {{$e['partner_order_id']}}</td>
                  <td class="sort-phone"> {{$e['advertisers']}}</td>
                  <td class="sort-partner"> <b>@if($e['affiliate_partner']=="cuelinks") <span style="color:blue"> @elseif($e['affiliate_partner']=="impact") <span style="color:orange">@else <span style="color:green">@endif  {{$e['affiliate_partner']}}</span></b></td>
                  <td class="sort-url"> <b>@if($e['order_status']==0) <span style="color:orange">Pending </span> @elseif($e['order_status']==1)  <span style="color:green">Approved </span> @else  <span style="color:red">Rejected </span> @endif</b></td>
                  <td class="sort-order"> <b>{{$e['order_amount']}}</b></td>
                    <td class="sort-url"> <b>{{$e['admin_earn']}}</b></td>
                  <td class="sort-earning"> <b>{{$e['earning_amount']}}</b></td>
                                </tr>
                
                            @endforeach
                        
                    </tbody>
                  </table>
                </div>
              </div>
              
            </div>
              </div>
        
                  </div>
                </div>
              </div>
             
       @endsection

@push('script_2')
    <script>
          function order_stats_update(type) {
        $.ajax({
 url: '{{url('admin')}}'+'?statistics_type='+type,
 type: "GET",
 success: function(data){
  alert(data[message]);
 },
 error: function(data){
  alert("error!");
 }
});
}
     </script>
<script>
      // @formatter:off
      document.addEventListener("DOMContentLoaded", function () {
        window.ApexCharts && (new ApexCharts(document.getElementById('team-chart1'), {
            chart: {
                type: "bar",
                fontFamily: 'inherit',
                height: 40.0,
                sparkline: {
                    enabled: true
                },
                animations: {
                    enabled: false
                },
            },
            plotOptions: {
                bar: {
                    columnWidth: '50%',
                }
            },
            dataLabels: {
                enabled: false,
            },
            fill: {
                opacity: 1,
            },
            series: [{
                name: "Total Orders",
                data: @json($ordgv)
            }],
            grid: {
                strokeDashArray: 4,
            },
            xaxis: {
                labels: {
                    padding: 0,
                },
                tooltip: {
                    enabled: false
                },
                axisBorder: {
                    show: false,
                },
                type: 'datetime',
            },
            yaxis: {
                labels: {
                    padding: 4
                },
            },
            labels:@json($ordgd),
            colors: ["#206bc4"],
            legend: {
                show: false,
            },
        })).render();
      });
      // @formatter:on
    </script>


 
<script>
      // @formatter:off
      document.addEventListener("DOMContentLoaded", function () {
        window.ApexCharts && (new ApexCharts(document.getElementById('chart-revenue-bg'), {
            chart: {
                type: "line",
                fontFamily: 'inherit',
                height: 40.0,
                sparkline: {
                    enabled: true
                },
                animations: {
                    enabled: false
                },
            },
            fill: {
                opacity: 1,
            },
            stroke: {
                width: [2, 1],
                dashArray: [0, 3],
                lineCap: "round",
                curve: "smooth",
            },
            series: [{
                name: "Approved",
                data: @json($revgv)
            },{
                name: "Pending",
                data: @json($pgv)
            }],
            grid: {
                strokeDashArray: 4,
            },
            xaxis: {
                labels: {
                    padding: 0,
                },
                tooltip: {
                    enabled: false
                }
            },
            yaxis: {
                labels: {
                    padding: 4
                },
            },
            labels:@json($revgd),
            colors: ["#206bc4", "#a8aeb7"],
            legend: {
                show: false,
            },
        })).render();
      });
      // @formatter:on
    </script>


<script>
      // @formatter:off
      document.addEventListener("DOMContentLoaded", function () {
        window.ApexCharts && (new ApexCharts(document.getElementById('act-user-bg'), {
            chart: {
                type: "line",
                fontFamily: 'inherit',
                height: 40.0,
                sparkline: {
                    enabled: true
                },
                animations: {
                    enabled: false
                },
            },
            fill: {
                opacity: 1,
            },
            stroke: {
                width: [2, 1],
                dashArray: [0, 3],
                lineCap: "round",
                curve: "smooth",
            },
            series: [{
                name: "Approved",
                data: @json($usrevgv)
            },{
                name: "Pending",
                data: @json($usrpgv)
            }],
            grid: {
                strokeDashArray: 4,
            },
            xaxis: {
                labels: {
                    padding: 0,
                },
                tooltip: {
                    enabled: false
                }
            },
            yaxis: {
                labels: {
                    padding: 4
                },
            },
            labels:@json($usrevgd),
            colors: ["#206bc4", "#a8aeb7"],
            legend: {
                show: false,
            },
        })).render();
      });
      // @formatter:on
    </script>
     

    <script>
      // @formatter:off
      document.addEventListener("DOMContentLoaded", function () {
        window.ApexCharts && (new ApexCharts(document.getElementById('chart-new-clients'), {
            chart: {
                type: "line",
                fontFamily: 'inherit',
                height: 40.0,
                sparkline: {
                    enabled: true
                },
                animations: {
                    enabled: false
                },
            },
            fill: {
                opacity: 1,
            },
            stroke: {
                width: [2, 1],
                dashArray: [0, 3],
                lineCap: "round",
                curve: "smooth",
            },
            series: [{
                name: "this day",
                data: @json($ncgv)
            },{
                name: "previous day",
                data: @json($ncgv2)
            }],
            grid: {
                strokeDashArray: 4,
            },
            xaxis: {
                labels: {
                    padding: 0,
                },
                tooltip: {
                    enabled: false
                }
            },
            yaxis: {
                labels: {
                    padding: 4
                },
            },
            labels:@json($ncgd),
            colors: ["#206bc4", "#a8aeb7"],
            legend: {
                show: false,
            },
        })).render();
      });
      // @formatter:on
    </script>



    

@endpush