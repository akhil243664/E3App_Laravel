
<?php $__env->startSection('title','Update banner'); ?>

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
</style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>

          <div class="page-body">
          <div class="container-xl">
            <div class="card">
                <div class="card-header"><h2 class="page-title">
                  Edit Banner
                </h2></div>
              <div class="card-body">
               <form action="<?php echo e(route('admin.banner.update',[$banner['id']])); ?>" method="post" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
				   <div class="row">
					   <div class="form-group"  id="viewerbox" style="margin-bottom:0%;">
                                <center>
                                    <img style="width: 200px;border: 1px solid #3399db; border-radius: 10px; padding: 11px;" id="viewer"
                                         <?php if(isset($banner)): ?>
                                        src="<?php echo e(asset('storage/app/public/banner')); ?>/<?php echo e($banner['image']); ?>"
                                        <?php else: ?>
                                        src="<?php echo e(asset('assets/theme_assets/img')); ?>/upload1.png"
                                        <?php endif; ?>
                                        alt="image"/>
                                </center>
                            </div>
				    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="mb-3">
                              <label class="form-label required">Banner name</label>
                              <input type="text" class="form-control" name="name" id="name" value="<?php echo e($banner['name']); ?>"/>
                               <input type="hidden" name="position" value="0">
                            </div>
					   </div>
                         <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            
                             <div class="mb-3">
                            <div class="form-label">Image <small style="color: red">* (ratio=>1:1)</small></div>
                            <input type="file"  name="image" id="customFileEg1" class="form-control"
                                accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" required />
                                <label class="custom-file-label" for="customFileEg1"></label>
                             </div>
					   </div>
					   </div>
				    <div class="row">
				
				    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				             <div class="mb-3">
                                       <label class="form-label required">Banner Type</label>
                                        <select name="type" class="form-control" onchange="banner_type_change(this.value)">
                                            <option value="offer" <?php if($banner['type']=='offer'): ?> selected <?php endif; ?>>Offer</option>
                                            <option value="url"  <?php if($banner['type']=='url'): ?> selected <?php endif; ?>>URL</option>
                                        </select>
                                    </div>
						</div>
						  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				              <div class="mb-3" id="offer">
                                        <label class="input-label" for="exampleFormControlSelect1">Select Offer<span
                                                class="input-label-secondary"></span></label>
                                        <select name="offer_id" class="js-data-example-ajax form-control"  title="Select Offer">
											<?php $__currentLoopData = $offers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $offer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<option value="<?php echo e($offer->id); ?>" <?php if($banner['offer_id']==$offer->id): ?> selected <?php endif; ?>><?php echo e($offer->name); ?></option>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            
                                        </select>
                                    </div>
						
                                    <div class="mb-3" id="url">
                                        <label class="input-label" for="exampleFormControlInput1">URL</label>
                                         <input type="text" class="form-control" name="url" id="url" value="<?php echo e($banner['url']); ?>"/>
                                    </div>
						</div>
				   </div>
				   <div class="row">
				
				    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				             <div class="mb-3">
                                       <label class="form-label required">Banner Heading</label>
                                       <input type="text" class="form-control" name="heading" id="heading" value="<?php echo e($banner['heading']); ?>"/>
                                    </div>
						</div>
						  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				             <div class="mb-3">
                                       <label class="form-label required">Banner Short Description</label>
                                       <input type="text" class="form-control" name="description" id="description" value="<?php echo e($banner['description']); ?>"/>
                                    </div>
						
                                  
						</div>
				   </div>
				   
                             <div class="card-footer">
                              <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                         </form>
                            
                      </div></div></div></div>
                  

        <!-- Page body -->
       

<?php $__env->stopSection(); ?>


<?php $__env->startPush('script_2'); ?>
<script>
<?php if($banner['type']=='offer'): ?>
 $('#url').hide();
<?php else: ?>
	 $('#offer').hide();
<?php endif; ?>
        function banner_type_change(order_type) {
           if(order_type=='url')
            {
                $('#offer').hide();
                $('#url').show();
            }
            else if(order_type=='offer')
            {
                $('#offer').show();
                $('#url').hide();
           }else{
                $('#offer').hide();
                $('#url').hide();
            }
        }</script>
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
                    url: '<?php echo e(route('admin.banner.search')); ?>',
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
<script src="<?php echo e(asset('public/theme_assets/plugins/jquery/jquery.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/theme_assets/plugins/jquery-ui/jquery-ui.min.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home1/lpabdgkz/public_html/e3app.in/e3-admin/resources/views/admin/banner/edit.blade.php ENDPATH**/ ?>