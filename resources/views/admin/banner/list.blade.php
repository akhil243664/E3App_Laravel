@extends('admin.layout.app')
@section('title', 'Banner List')

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
        <!-- Page body -->
        <div class="page-body">
          <div class="container-xl">
            <div class="card">
                <div class="card-header">
					<h2 class="page-title" align="left" style="width: 100%;">
                           Banner List
						
                       </h2>
                       <a  align="right" style="float:right !important;" href="{{route('admin.banner.export-all')}}" class="btn btn-danger  float-right"> Export All </a>&nbsp;
					 <a  align="right" style="float:right !important;" href="{{route('admin.banner.add')}}" class="btn btn-primary  float-right"> Add New </a></div>
              <div class="card-body">
                <div id="table-default" class="table-bordered table-responsive">
                  <table class="table">
                    <thead>
                      <tr>
                         <th><button class="table-sort" data-sort="sort-s">#</button></th>
                            <th><button class="table-sort" data-sort="sort-image"> Image</button></th>
                        <th><button class="table-sort" data-sort="sort-name"> Name</button></th>
                        <th><button class="table-sort" data-sort="sort-type"> Actions</button></th>
                      </tr>
                    </thead>
                    <tbody class="table-tbody">
                      <tr>
                          @foreach($banners as $key=>$banner)
                                <tr>
                                    <td id="row">{{$key+$banners->firstItem()}}</td>
                                    
										 <td class="sort-name">
							<img src="{{asset('storage/app/public/banner')}}/{{$banner['image']}}" alt="no image" style="width:80px">
								</td>
                                 
                               
                              
                              
                                    <td class="sort-name">{{Str::limit($banner['name'], 20,'...')}}</td>
                                    <td class="sort-type">
                                    <div class="dropdown">
                                      <button class="btn btn-primary dropdown-toggle align-text-top" data-bs-boundary="viewport" data-bs-toggle="dropdown"> Actions</button>
                                      <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item"
                                                    href="{{route('admin.banner.edit',[$banner['id']])}}" title="edit category"> Edit
                                                </a>
                                                <a  href="{{route('admin.banner.delete',[$banner['id']])}}" class="dropdown-item" href="javascript:"
                                                    onclick="return confirm('Are you sure?');" title="delete banner"> Delete
                                                </a>
                                      </div>
                                    </div>
                                    </td>
                                </tr>
						
			
                            @endforeach
                        
                    </tbody>
                  </table>
                </div>
              </div>
               <div class="card-footer" align="right">
                <div class="pull-right" style="float: right;">
  {{ $banners->render("pagination::bootstrap-4") }}
</div>
            </div>
            </div>
          </div>
        </div>



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
                    url: '{{route('admin.banner.search')}}',
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
