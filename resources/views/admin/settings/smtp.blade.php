@extends('admin.layout.app')
@section('title','Update SMTP Settings')

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

element.style {
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
                 Update SMTP Settings
                </h2>
               </div>
              <div class="card-body">
               <form action="{{route('admin.smtp-settings.update-smtp')}}" method="post" enctype="multipart/form-data">
                    @csrf
				   <div class="row">
				    <div class="col-lg-6 col-sm-12 col-xs-12 col-md-6">
                      
                            <div class="mb-3">

                              <label class="form-label required">SMTP Host</label>
                              <input type="text" class="form-control" name="host" id="host" value="{{$g['smtp_host']}}" placeholder="smtp.gmail.com" />
                            </div>
					   </div>
				    <div class="col-lg-6 col-sm-12 col-xs-12 col-md-6">
                            <div class="mb-3">

                              <label class="form-label required">SMTP Port</label>
                              <input type="text" class="form-control" name="port" id="port" value="{{$g['smtp_port']}}" placeholder="465" />
                            </div>
					     </div>
					  
				    <div class="col-lg-6 col-sm-12 col-xs-12 col-md-6">
                             <div class="mb-3">
                              <label class="form-label required">SMTP Username</label>
                              <input type="text" class="form-control" name="username" id="username" value="{{$g['username']}}" placeholder="xyz@gmail.com"/>
                            </div>
				       </div>
				    <div class="col-lg-6 col-sm-12 col-xs-12 col-md-6">
                             <div class="mb-3">
                              <label class="form-label required">SMTP Password</label>
                              <input type="password" class="form-control" name="password" id="password" value="{{$g['password']}}" placeholder="smtp password"/>
                            </div>
				       </div>
						
						<div class="col-lg-6 col-sm-12 col-xs-12 col-md-6">
                             <div class="mb-3">
                              <label class="form-label required">Select SMTP Encryption</label>
								<select name="encryption" class="form-control">
									<option value="ssl" @if($g['encryption'] == "ssl") selected @endif>ssl</option>
                                    <option value="tls" @if($g['encryption'] == "tls") selected @endif>tls</option>
								 </select>
                              
                            </div>
				       </div>
                        <div class="col-lg-6 col-sm-12 col-xs-12 col-md-6">
                             <div class="mb-3">
                              <label class="form-label required">Mail From Address</label>
                              <input type="text" class="form-control" name="mail_from" id="mail_from" value="{{$g['mail_from']}}" placeholder="xyz@gmail.com"/>
                            </div>
                       </div>
				   </div>
				   
                             <div class="card-footer">
                              <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                         </form> 
                            
                      </div></div></div></div>
                  

      



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