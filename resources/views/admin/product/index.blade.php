@extends('admin.layout.app')
@section('title','Add new Product')

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
hr{
    border-bottom:2px solid grey !important;
}
</style>
@endpush
@section('content')

          <div class="page-body">
          <div class="container-xl">
            <div class="card">
                <div class="card-header"><h2 class="page-title">
                  Create Product
                </h2></div>
              <div class="card-body">
                 <form action="{{route('admin.product.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                            <div class="mb-3">
                              <label class="form-label required">Product Name</label>
                              <input type="text" class="form-control" name="name" id="name" placeholder="product name" value="{{old('name')}}"/>
                               <input type="hidden" name="position" value="0">
                            </div>
                            <div class="mb-3">
                              <label class="form-label required">Product Description</label>
                              <textarea name="desc" value="{{old('desc')}}" id="desc" class="form-control" ></textarea>
                            </div>
                              <div class="form-group"  id="viewerbox" style="display:none;margin-bottom:0%;">
                                <center>
                                    <img style="width: 200px;border: 1px solid #3399db; border-radius: 10px; padding: 11px;" id="viewer"
                                         @if(isset($product))
                                        src="{{asset('storage/app/public/product')}}/{{$product['image']}}"
                                        @else
                                        src="{{asset('assets/theme_assets/img')}}/upload1.png"
                                        @endif
                                        alt="image"/>
                                </center>
                             </div>
                            
                            <div class="mb-3">
                            <div class="form-label">Images <small style="color: red">* (Ratio=>1:1)</small></div>
                            <input type="file"  name="image[]" id="customFileEg1" class="form-control"
                                accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" multiple required />
                                <label class="custom-file-label" for="customFileEg1"></label>
                             </div>
					  <div class="mb-3">
                              <label class="form-label required">Select Affiliate Partner</label>
                              <select name="aff_partner" class="form-control" required>
								  <option value="admitad"> Admitad </option>
								  <option value="cuelinks"> Cuelinks </option>
								  <option value="impact"> Impact </option>
					          </select>
                            </div>
				           
					 
					       
                             <h3 align="center"> Add Prices</h3>
                             <div class="row">
                             <div class="container">
                                <div class="row">
                                    <div class="col-md-4">
                                    <label class="form-label required">Select Advertiser no. 1</label>
										<select name="morefields[0][adv_id]" class="form-control" required>
											@php($partner= \App\Models\Partner::get())
											@foreach($partner as $part)
											<option value="{{$part->id}}">{{$part->name}} </option>
											@endforeach
										</select>
                                   
                                    </div>
									@php($currency_code=\App\Models\BusinessSetting::where('key','currency')->first()->value)
                                   <div class="col-md-4">
                                    <label class="form-label required">Cashback({{$currency_code}})</label>
                                    <input type="number" class="form-control" name="morefields[0][cashback]" id="validationCustom01" placeholder="product cashback" required/>
                                   
                                    </div>
                                    <div class="col-md-4">
                                    <label class="form-label required">Campaign ID(required if partner is admitad or impact)</label>
                                    <input type="text" class="form-control" name="morefields[0][c_id]" id="validationCustom01" placeholder="Campaign ID" required/>
                                   
                                    </div>
                                    <div class="col-md-4">
                                    <label class="form-label required">Product MRP</label>
                                    <input type="number" class="form-control" name="morefields[0][mrp]" id="validationCustom01" placeholder="Product MRPp" required/>
                                   
                                    </div>
									


                                    <div class="col-md-4">
                                    <label class="form-label required">Product Price</label>
                                    <input type="number" class="form-control" name="morefields[0][price]" id="validationCustom01" placeholder="Product Price" required/>
                                   
                                    </div>


                                    <div class="col-md-4">
                                    <label class="form-label required">Product URL</label>
                                    <input type="text" class="form-control" name="morefields[0][url]" id="validationCustom01" placeholder="Product URL" required/>
                                   
                                    </div>

                               </div>
                               <hr>
                               <div id="dynamicquestadd"></div>
                               <div class="col-12" align="right">
										 	 
                                <label for="validationCustom01" class="form-label"></label><br>
                            <button type="button" name="add" id="add-questbtn" class="btn btn-primary">Add Morere</button>
                            <br>
                                </div>

                               
                            </div> </div>
                             <div class="card-footer">
                              <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                         </form>
                            
                      </div></div></div></div>
                  
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.10.1/standard/ckeditor.js"></script>
<script type="text/javascript">
var j = 0;
var l=1;

$("#add-questbtn").click(function(){
++j;
++l;
$("#dynamicquestadd").append('<div class="row"><div class="col-md-4"><label class="form-label required">{{ "Select Advertiser No." }} '+l+'</label><select name="morefields['+j+'][adv_id]" class="form-control">@php($partner= \App\Models\Partner::get())@foreach($partner as $part)<option value="{{$part->id}}">{{$part->name}} </option>@endforeach</select></div><div class="col-md-4"><label class="form-label required">{{ "Cashback" }} ({{$currency_code}})</label><input type="number" class="form-control" name="morefields['+j+'][cashback]" id="validationCustom01" placeholder="{{ "Product Cashback" }} "/></div><div class="col-md-4"><label class="form-label required">{{ "Campaign ID" }} ({{ "Required If Affiliate Partner is Admitad or impact" }} )</label><input type="text" class="form-control" name="morefields['+j+'][c_id]" id="validationCustom01" placeholder="{{ "Campaign ID" }} "/></div><div class="col-md-4"><label class="form-label required">{{ "Product MRP" }} </label><input type="number" class="form-control" name="morefields['+j+'][mrp]" id="morefields['+j+'][mrp]" placeholder="{{ "Product MRP" }} "/></div><div class="col-md-4"><label class="form-label required">{{ "Product Price" }} </label><input type="number" class="form-control" name="morefields['+j+'][price]" id="validationCustom01" placeholder="{{ "Product Price" }} "/></div><div class="col-md-4"><label class="form-label required">{{ "Product URL" }} </label><input type="text" class="form-control" name="morefields['+j+'][url]" id="validationCustom01" placeholder="{{ "Product URL" }} "/></div></div><hr>');
});

$(document).on('click', '.remove-tr', function(){  
$(this).parents('div').remove();
});  
</script>

@endsection


@push('script_2')

    

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
    






@endpush
