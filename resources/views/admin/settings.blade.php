
@extends('admin.layout.app')
@section('title','Profile Settings')

@push('css_or_js')

@endpush
@section('content')
          <div class="page-body">
          <div class="container-xl">
            <div class="card">
              <div class="card-header"><h2 class="page-title">
                 Basic Information
                </h2>
               </div>
              <div class="card-body">
               <form action="{{route('admin.settings')}}" method="post" enctype="multipart/form-data">
                    @csrf
				     <div class="row">
			    <div class="col-lg-6 col-sm-12 col-xs-12 col-md-6">
                            <div class="mb-3">
                              <label class="form-label required">First Name</label>
                              <input type="text" class="form-control" name="f_name" id="f_name" value="{{auth('admin')->user()->f_name}}" placeholder="john" />
                            </div></div>
					<div class="col-lg-6 col-sm-12 col-xs-12 col-md-6">
                            <div class="mb-3">

                              <label class="form-label required">Last Name</label>
                              <input type="text" class="form-control" name="l_name" id="l_name" value="{{auth('admin')->user()->l_name}}" placeholder="doe" />
                            </div></div>
				   </div>
					
					  <div class="row">
			         <div class="col-lg-6 col-sm-12 col-xs-12 col-md-6">

                            <div class="mb-3">

                              <label class="form-label required">Email</label>
                              <input type="email" class="form-control" name="email" id="email" value="{{auth('admin')->user()->email}}" placeholder="xyz@gmail.com" />
                            </div></div>
						    <div class="col-lg-6 col-sm-12 col-xs-12 col-md-6">
                            <div class="mb-3">

                              <label class="form-label required">Phone</label>
                              <input type="phone" class="form-control" name="phone" id="phone" value="{{auth('admin')->user()->phone}}" placeholder="999999999" />
                            </div></div>
				   </div>
                          
				   <div class="row">
			         <div class="col-lg-6 col-sm-12 col-xs-12 col-md-6">
                             <div class="mb-3">
                            <div class="form-label">Admin Image <small style="color: red">* (Ratio=> 1:1)</small></div>
                            <input type="file"  name="image" id="customFileEg1" class="form-control"
                                accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" />
                                <label class="custom-file-label" for="customFileEg1"></label>
                             </div>
						  </div>
					    <div class="col-lg-6 col-sm-12 col-xs-12 col-md-6">
						  <center>
                               <img id="viewer"
                                 class="avatar avatar-md"
                                 onerror="this.src='{{asset('assets/theme_assets/img')}}/upload1.png'"
                                 src="{{asset('storage/app/public/admin')}}/{{auth('admin')->user()->image}}"
                                 alt="Image">
                            </center>
					   </div></div>
        
                             <div class="card-footer">
                              <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                         </form>
                            
          </div></div></div></div>
          <div class="page-body">
          <div class="container-xl">
            <div class="card">
              <div class="card-header"><h2 class="page-title">
                  Change Password
                </h2>
               </div>
              <div class="card-body">
               <form action="{{route('admin.settings-password')}}" method="post" enctype="multipart/form-data">
                    @csrf
                      <div class="row">
			         <div class="col-lg-6 col-sm-12 col-xs-12 col-md-6">
                            <div class="mb-3">

                              <label class="form-label required">New Password</label>
                               <input type="password" class="js-pwstrength form-control" name="password"
                                           id="newPassword" placeholder="enter new password"
                                           aria-label="enter new password"
                                           data-hs-pwstrength-options='{
                                           "ui": {
                                             "container": "#changePasswordForm",
                                             "viewports": {
                                               "progress": "#passwordStrengthProgress",
                                               "verdict": "#passwordStrengthVerdict"
                                             }
                                           }
                                         }' required>

                                    <p id="passwordStrengthVerdict" class="form-text mb-2"></p>

                                    <div id="passwordStrengthProgress"></div>
						 </div></div>
						   <div class="col-lg-6 col-sm-12 col-xs-12 col-md-6">
                            <div class="mb-3">

                              <label class="form-label required">Confirm Password</label>
                              
                                        <input type="password" class="form-control" name="confirm_password"
                                               id="confirmNewPasswordLabel" placeholder="confirm new password"
                                               aria-label="confirm new password" required>
                                
                            </div></div></div><hr>

                          
        
                             <div class="card-footer">
                              <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                         </form>
                            
                      </div></div></div></div>
                  

      



@endsection


@push('script_2')
      <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewer').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileEg1").change(function () {
            readURL(this);
        });
    </script>
       <script>
        $("#generalSection").click(function() {
            $("#passwordSection").removeClass("active");
            $("#generalSection").addClass("active");
            $('html, body').animate({
                scrollTop: $("#generalDiv").offset().top
            }, 2000);
        });

        $("#passwordSection").click(function() {
            $("#generalSection").removeClass("active");
            $("#passwordSection").addClass("active");
            $('html, body').animate({
                scrollTop: $("#passwordDiv").offset().top
            }, 2000);
        });
    </script>
    
    <!-- jQuery UI 1.11.4 -->
<script src="{{asset('public/theme_assets/plugins/jquery/jquery.min.js')}}"></script>
<script src="{{asset('public/theme_assets/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
@endpush


