@extends('admin.layout.app')
@section('title','Update Customer')

@push('css_or_js')

@endpush
@section('content')

          <div class="page-body">
          <div class="container-xl">
            <div class="card">
                <div class="card-header"><h2 class="page-title">
                Customer Update
                </h2></div>
              <div class="card-body">
               <form action="{{route('admin.customer.update',[$user['id']])}}" method="post" enctype="multipart/form-data">
                    @csrf
				     <div class="form-group"  id="viewerbox" style="margin-bottom:0%;">
                                <center>
                                    <img style="width: 200px;border: 1px solid #3399db; border-radius: 10px; padding: 11px;" id="viewer"
                                         @if(isset($category))
                                        src="{{asset('storage/app/public/category')}}/{{$category['image']}}"
                                        @else
                                        src="{{asset('assets/theme_assets/img')}}/upload1.png"
                                        @endif
                                        alt="image"/>
                                </center>
                            </div>
				   <div class="row">    
				    <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12">
                            <div class="mb-3">
                              <label class="form-label required">User Name</label>
                              <input type="text" class="form-control" name="name" id="name" value="{{$user['name']}}" required/>
                            </div>
					   </div>
					   <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12">
                            <div class="mb-3">
                              <label class="form-label required">User Email</label>
                              <input type="email" class="form-control" name="email" id="email" value="{{$user['email']}}" required/>
                            </div>
					   </div>	
				   </div>
				   <div class="row">    
				    <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12">
                            <div class="mb-3">
                           <label class="form-label required">User Phone (Insert Phone Number With Country Code e.g.- +919898989898)</label>
                              <input type="text" class="form-control" name="phone" id="phone" value="{{$user['phone']}}" required/>
                            </div>
					   </div>
					   <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12">
                            <div class="mb-3">
                            <div class="form-label">Image <small style="color: red">* (Ratio=> 1:1)</small></div>
                            <input type="file"  name="image" id="customFileEg1" class="form-control"
                                accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" />
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
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewer').attr('src', e.target.result);
                    document.getElementById("viewerbox").style.display = 'block';
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

         $("#customFileEg1").change(function () {
            readURL(this);
        });
    </script>
    
    <!-- jQuery UI 1.11.4 -->
<script src="{{asset('public/theme_assets/plugins/jquery/jquery.min.js')}}"></script>
<script src="{{asset('public/theme_assets/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
@endpush