
<?php $__env->startSection('title','Update Product'); ?>

<?php $__env->startPush('css_or_js'); ?>
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
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>

          <div class="page-body">
          <div class="container-xl">
            <div class="card">
                <div class="card-header"><h2 class="page-title">
                  Update Product
                </h2></div>
              <div class="card-body">
               <form action="<?php echo e(route('admin.product.update',$product['id'])); ?>" method="post" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
				   <h4 align="center"> Product Images </h4><hr>
				          <div class="row">
                           
                                <?php ($images=\App\Models\Image::where('product_id',$product['id'])->get()); ?>
								  
								  <?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $imag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								 <div class="col-lg-2 col-md-2 col-xl-1 col-sm-4 col-xs-4 mb-3" style="float:left">
								   <img src="<?php echo e(asset('storage/app/public/product')); ?>/<?php echo e($imag['image']); ?>" alt="image" style="max-width:100px; max-height:100px;"><br> <a href="<?php echo e(route('admin.product.delete_product_image',$imag['id'])); ?>" >Delete Image </a>
								  </div>
								  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                             </div><hr>
							
				 
                            <div class="mb-3">
								<br>
                              <label class="form-label required mt-2">Product Name</label>
                              <input type="text" class="form-control" name="name" id="name" placeholder="Product Name" value="<?php echo e($product['name']); ?>"/>
                               <input type="hidden" name="position" value="0">
                            </div>
                            <div class="mb-3">
                              <label class="form-label required">Product Description</label>
                              <textarea name="desc" id="desc" class="form-control" id="summernote8"><?php echo e($product['description']); ?></textarea>
                            </div>
				          
				       
                            
                            <div class="mb-3">
							
                            <div class="form-label">Images <small style="color: red">* (Ratio=>1:1)</small></div>
                            <input type="file"  name="image[]" id="customFileEg1" class="form-control"
                                accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" multiple/>
                                <label class="custom-file-label" for="customFileEg1"></label>
                             </div>
				   
				            <div class="mb-3">
                              <label class="form-label required">Select Affiliate Partner</label>
                              <select name="aff_partner" class="form-control" required>
								  <option value="admitad" <?php if($product['affiliate_partner']=="admitad"): ?> selected <?php endif; ?>> Admitad </option>
								  <option value="cuelinks" <?php if($product['affiliate_partner']=="cuelinks"): ?> selected <?php endif; ?>> Cuelinks </option>
								  <option value="impact" <?php if($product['affiliate_partner']=="impact"): ?> selected <?php endif; ?>> Impact </option>
					          </select>
                            </div>
				      
				   
                             <h3 align="center"> Add Prices</h3>
                             <div class="row">
                             <div class="container">
                                <?php $j=0;
								 $l=1;?>
                             <?php if(count($product->product_prices)>0): ?>
                                	<?php $__currentLoopData = $product->product_prices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fields): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="row">
                                      <div class="col-md-4">
                                    <label class="form-label required">Select Advertiser no. <?php echo e($l); ?></label>
										<select name="morefields[<?php echo e($j); ?>][adv_id]" class="form-control" required>
											<?php ($partner= \App\Models\Partner::get()); ?>
											<?php $__currentLoopData = $partner; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $part): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<option value="<?php echo e($part->id); ?>" <?php if($part->id==$fields['adv_id']): ?> selected <?php endif; ?>><?php echo e($part->name); ?> </option>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										</select>
                                   
                                    </div>

                                    <?php ($currency_code=\App\Models\BusinessSetting::where('key','currency')->first()->value); ?>
                                   <div class="col-md-4">
                                    <label class="form-label required">Cashback(<?php echo e($currency_code); ?>)</label>
                                    <input type="number" class="form-control" name="morefields[<?php echo e($j); ?>][cashback]" id="validationCustom01" placeholder="Product Cashback" value="<?php echo e($fields['cashback']); ?>" required/></div>

                                     <div class="col-md-4">
                                    <label class="form-label required" for="validationCustom01">Campaign ID(required if partner is admitad or impact)</label>
                                    <input type="text" class="form-control" name="morefields[<?php echo e($j); ?>][c_id]" id="validationCustom01" placeholder="Campaign ID"  value="<?php echo e($fields['c_id']); ?>" required/>
                                   
                                    </div>
									
                                    <div class="col-md-4">
                                    <label class="form-label required" for="validationCustom01">Product MRP</label>
                                    <input type="number" class="form-control" name="morefields[<?php echo e($j); ?>][mrp]" id="validationCustom01" placeholder="Product MRP"  value="<?php echo e($fields['mrp']); ?>" required/>
                                   
                                    </div>


                                    <div class="col-md-4">
                                    <label class="form-label required" for="validationCustom01">Product Price</label>
                                    <input type="number" class="form-control" name="morefields[<?php echo e($j); ?>][price]" id="validationCustom01" placeholder="Product Price"  value="<?php echo e($fields['price']); ?>" required/>
                                   
                                    </div>


                                    <div class="col-md-4">
                                    <label class="form-label required" for="validationCustom01">Product URL</label>
                                    <input type="text" class="form-control" name="morefields[<?php echo e($j); ?>][url]" id="validationCustom01"  placeholder="Product URL"  value="<?php echo e($fields['url']); ?>" required/>
                                   
                                    </div>

                               </div><hr>
                               <?php $j++; ?>
								  <?php $l++; ?>
                               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                               <?php endif; ?>
                               
                               <div id="dynamicquestadd"></div>
                               <div class="col-12" align="right">
                                             
                                <label for="validationCustom01" class="form-label"></label><br>
                            <button type="button" name="add" id="add-questbtn" class="btn btn-primary">Add More</button>
                            <br>
                                </div>

                                </div>

                               
                            </div>
                             <div class="card-footer">
                              <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                         </form>
                            
                      </div></div></div></div>
                  

        <!-- Page body -->
         <!-- jQuery UI 1.11.4 -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.10.1/standard/ckeditor.js"></script>




<script type="text/javascript">
var j = <?php echo e($j); ?>-1;
var l=1;

$("#add-questbtn").click(function(){
++j;
++l;
$("#dynamicquestadd").append('<div class="row"><div class="col-md-4"><label class="form-label required"><?php echo e("Select Advertiser No."); ?> '+l+'</label><select name="morefields['+j+'][adv_id]" class="form-control"><?php ($partner= \App\Models\Partner::get()); ?><?php $__currentLoopData = $partner; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $part): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($part->id); ?>"><?php echo e($part->name); ?> </option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div><div class="col-md-4"><label class="form-label required"><?php echo e("Cashback"); ?> (<?php echo e($currency_code); ?>)</label><input type="number" class="form-control" name="morefields['+j+'][cashback]" id="validationCustom01" placeholder="<?php echo e("Product Cashback"); ?> "/></div><div class="col-md-4"><label class="form-label required"><?php echo e("Campaign ID"); ?> (<?php echo e("Required If Affiliate Partner is Admitad or impact"); ?> )</label><input type="text" class="form-control" name="morefields['+j+'][c_id]" id="validationCustom01" placeholder="<?php echo e("Campaign ID"); ?> "/></div><div class="col-md-4"><label class="form-label required"><?php echo e("Product MRP"); ?> </label><input type="number" class="form-control" name="morefields['+j+'][mrp]" id="morefields['+j+'][mrp]" placeholder="<?php echo e("Product MRP"); ?> "/></div><div class="col-md-4"><label class="form-label required"><?php echo e("Product Price"); ?> </label><input type="number" class="form-control" name="morefields['+j+'][price]" id="validationCustom01" placeholder="<?php echo e("Product Price"); ?> "/></div><div class="col-md-4"><label class="form-label required"><?php echo e("Product URL"); ?> </label><input type="text" class="form-control" name="morefields['+j+'][url]" id="validationCustom01" placeholder="<?php echo e("Product URL"); ?> "/></div></div><hr>');
});

$(document).on('click', '.remove-tr', function(){  
$(this).parents('div').remove();
});  

var a=0;
var b=1;
$("#add-optionbtn").click(function(){
++a;
++b;
$("#dynamicoptionadd").append('<div class="mt-2 mb-2 col-md-12" style="float:left"><input type="text" name="chatmorefields['+j+'][type]['+a+'][option]" class="form-control" placeholder="option-'+b+'"></div>');
});
</script>

<?php $__env->stopSection(); ?>


<?php $__env->startPush('script_2'); ?>

<script type="text/javascript">
        $('#summernote8').summernote({
            height: 400
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
    
  
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u727738086/domains/thecloudstories.com/public_html/admin/resources/views/admin/product/edit.blade.php ENDPATH**/ ?>