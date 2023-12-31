@extends('admin.layout.app')
@section('title','Clicks List')

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
label.form-check.form-check-single.form-switch {
    float: left;
    margin-left: -25px !important;
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
                 <div class="card-header"><h2 class="page-title" align="left" style="width: 100%;">
                  Clicks List
                </h2>&nbsp;<a  align="right" style="float:right !important;" href="{{route('admin.customer.exportclicks')}}" class="btn btn-danger  float-right">Export All </a>&nbsp;<div class="flex">
					 <a href="{{route('admin.customer.deleteclicks')}}" class="btn btn-secondary">Delete clicks older then ten days</a></div></div>
              <div class="card-body">
                  <div class="table" style="width:100%">
                  <table id="example" class="display" style="width:100%">
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
                           @foreach($customers as $k=>$e)
                           
                                     <tr>
                                    <td id="row">{{$k+$customers->firstItem()}}</td>
                              
                                   
                                    <td class="sort-name"> @if($e->user != NULL) {{$e->user['name']}} @else User Deleted @endif</td>
                                     <td class="sort-email"> {{$e['id']}}
										</td>
									<td class="sort-email"> <img width="100px" src="{{$e['image']}}" onerror="this.src='{{url('/')}}/storage/app/public/images/noimage.png'" alt="no image" >
										</td>
                                     <td class="sort-email"><span> {{$e['tracking_link']}} </span>
										</td>
									
									 <td class="sort-email"> {{date('d-M-Y',strtotime($e['created_at']))}}
										</td>
                                   
                                </tr>
						
                            @endforeach
                        
                    </tbody>
                  </table>
                </div>
              </div>
               <div class="card-footer" align="right">
              
                              {{ $customers->links("pagination::bootstrap-4") }}
                   
                <!-- End Pagination -->
            </div>
            </div>
          </div>
        </div>



@endsection


@push('script_2')

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js" integrity="sha512-57oZ/vW8ANMjR/KQ6Be9v/+/h6bq9/l3f0Oc7vn6qMqyhvPd1cvKBRWWpzu0QoneImqr2SkmO4MSqU+RpHom3Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@foreach($customers as $ed)
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewer{{$ed->id}}').attr('src', e.target.result);
                    document.getElementById("viewerbox{{$ed->id}}").style.display = 'block';
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

         $("#customFileEg1").change(function () {
            readURL(this);
        });
    </script>
@endforeach
    
    <!-- jQuery UI 1.11.4 -->
<script src="{{asset('public/theme_assets/plugins/jquery/jquery.min.js')}}"></script>
<script src="{{asset('public/theme_assets/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
@endpush
