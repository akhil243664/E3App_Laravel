@extends('admin.layout.app')
@section('title','Update Currency Settings')

@push('css_or_js')
<style>
    .flex.justify-between.flex-1.sm\:hidden {
    display: none;
}
                    
p.text-sm.text-gray-700.leading-5 {
    display: none;
}
svg.w-5.h-5 {
    width: 22px !important;
}


a.relative.inline-flex.items-center.px-4.py-2.-ml-px.text-sm.font-medium.text-gray-700.bg-white.border.border-gray-300.leading-5.hover\:text-gray-500.focus\:z-10.focus\:outline-none.focus\:ring.ring-gray-300.focus\:border-blue-300.active\:bg-gray-100.active\:text-gray-700.transition.ease-in-out.duration-150 {
    margin: 3px;
    padding: 9px !important;
}



span.relative.inline-flex.items-center.px-4.py-2.-ml-px.text-sm.font-medium.text-gray-500.bg-white.border.border-gray-300.cursor-default.leading-5 {
    background-color: blue !important;
    color: white;
    margin: 3px;
    padding: 10px !important;
}
</style>
@endpush
@section('content')
          <div class="page-body">
          <div class="container-xl">
            <div class="card">
                <div class="card-header"><h2 class="page-title">
                 Update Currency Settings
                </h2>
               </div>
              <div class="card-body">
               <form action="{{route('admin.info-settings.update-currency')}}" method="post" enctype="multipart/form-data">
                    @csrf
				   <div class="row">    
				    <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12">
                        @php($name=\App\Models\BusinessSetting::where('key','business_name')->where('country_slug',$admin->country_slug)->first()->value)
                            <div class="mb-3">

                              <label class="form-label required">Main Admin/App Currency</label>
                             @php($currency_code=\App\Models\BusinessSetting::where('key','currency')->where('country_slug',$admin->country_slug)->first())
							
                                <select name="currency" class="form-control js-select2-custom">
                                    @foreach(\App\Models\Currency::orderBy('currency_code')->get() as $currency)
                                        <option
                                            value="{{$currency['currency_code']}}" {{$currency_code?($currency_code->value==$currency['currency_code']?'selected':''):''}}>
                                            {{$currency['currency_code']}} ( {{$currency['currency_symbol']}} )
                                        </option>
                                    @endforeach
                                </select>
                            </div>
					   </div>
					   
					   
				  </div>

                             <div class="card-footer">
                              <button type="submit" onclick="return confirm('Are you sure?');" class="btn btn-primary">Submit</button>
                            </div>
                         </form>
                            
                      </div></div>
	

			  
			  <div class="card">
                <div class="card-header"><h2 class="page-title">
                 Update Currency Exchange Rate
                </h2>
               </div>
              <div class="card-body">
               <form action="{{route('admin.info-settings.exchange_rate')}}" method="post" enctype="multipart/form-data">
                    @csrf
				   <div class="row">   
					     @php($currency_code=\App\Models\BusinessSetting::where('key','currency')->where('country_slug',$admin->country_slug)->first())
					   @php($cuelink_currency_code=\App\Models\BusinessSetting::where('key','cuelinks_currency')->where('country_slug',$admin->country_slug)->first())
					  @if($cuelink_currency_code)
				    <div class="col-lg-6 col-sm-12 col-xs-12 col-md-6">
                        @php($c_e_r=\App\Models\BusinessSetting::where('key','cuelinks_rate')->where('country_slug',$admin->country_slug)->first())
						
                            <div class="mb-3">
                            
						
                              <label class="form-label required">Cuelinks Currency Exchange Rate(1 {{$cuelink_currency_code->value}} = How Many {{$currency_code->value}}?)</label>
                             <input type="number" name="cuelinks_rate" value="{{$c_e_r->value??''}}" class="form-control"
                               placeholder="1 {{$cuelink_currency_code->value}} = How many {{$currency_code->value}}?" step="0.1" min="1"  required>
                            </div>
					   </div>
					   @else
					   <div class="mb-3">
						   <p><b style="color:red">Please Select Cuelinks Currency First.</b></p>
                            </div>
					   @endif
					   @php($impact_currency_code=\App\Models\BusinessSetting::where('key','impact_currency')->where('country_slug',$admin->country_slug)->first())
					    @if($impact_currency_code)
					    <div class="col-lg-6 col-sm-12 col-xs-12 col-md-6">
                        @php($i_e_r=\App\Models\BusinessSetting::where('key','impact_rate')->where('country_slug',$admin->country_slug)->first())
                            <div class="mb-3">
                            
								
                              <label class="form-label required">Impact Currency Exchange Rate(1 {{$impact_currency_code->value}} =  How Many {{$currency_code->value}}?)</label>
                             <input type="number" name="impact_rate" value="{{$i_e_r->value??''}}" class="form-control"
                               placeholder="1 {{$impact_currency_code->value}} =  How many {{$currency_code->value}}?" step="0.1" min="1" required>
                            </div>
					   </div>
					   @else
					    <div class="mb-3">
						   <p><b style="color:red">Please select impact currency first.</b></p>
                            </div>
					   @endif
				  </div>
                    <div class="card-footer">
                          <button type="submit"  onclick="return confirm('After this the new order cashback/rewards will distributed according to this exchange rates. Are you sure? ');" class="btn btn-primary">Submit</button>
                       </div>
                         </form>
                            
                      </div></div>
			  
			  
			  </div></div>
                  

      



@endsection


@push('script_2')

    <script>
        $(document).on('ready', function () {
            // INITIALIZATION OF DATATABLES
            // =======================================================
            

            $('#dataSearch').on('submit', function (e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.post({
                    url: '{{route('admin.category.search')}}',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function () {
                        $('#loading').show();
                    },
                    success: function (data) {
                        $('#table-div').html(data.view);
                        $('#itemCount').html(data.count);
                        $('.page-area').hide();
                    },
                    complete: function () {
                        $('#loading').hide();
                    },
                });
            });


            // INITIALIZATION OF SELECT2
            // =======================================================
            $('.js-select2-custom').each(function () {
                var select2 = $.HSCore.components.HSSelect2.init($(this));
            });
        });
    </script>

    
     <script>
       function readURL(input, viewer) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#'+viewer).attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileEg1").change(function () {
            readURL(this, 'viewer');
        });

        $("#favIconUpload").change(function () {
            readURL(this, 'iconViewer');
        });
    </script>
    
    <!-- jQuery UI 1.11.4 -->
<script src="{{asset('public/theme_assets/plugins/jquery/jquery.min.js')}}"></script>
<script src="{{asset('public/theme_assets/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
@endpush