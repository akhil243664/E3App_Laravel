<?php $__env->startSection('title','Banner Notification'); ?>

<?php $__env->startPush('css_or_js'); ?>

<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
          <div class="page-body">
          <div class="container-xl">
            <div class="card">
              <div class="card-header"><h2 class="page-title">
               Banner Notification (Show On App Start)
                </h2>
               </div>
              <div class="card-body">
               <form action="<?php echo e(route('admin.notification.storebanner')); ?>" method="post" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
				      <?php if($n): ?>
				            <center>
                               <img id="viewer"
                                 class="avatar avatar-lg"
                                 onerror="this.src='<?php echo e(asset('storage/app/public/images')); ?>/noimage.png'"
                                 src="<?php echo e(asset('storage/app/public/notification')); ?>/<?php echo e($n['image']); ?>"
                                 alt="Image">
                            </center>
				   <?php endif; ?>
				     <div class="row">
						
			    <div class="col-lg-6 col-sm-12 col-xs-12 col-md-6">
                            <div class="mb-3">
                              <label class="form-label required">Start Date </label>
                              <input type="date" class="form-control" name="start_date" id="start_date" <?php if($n): ?> value="<?php echo e(date('Y-m-d', strtotime($n['start_date']))); ?>" <?php endif; ?>/>

                            </div></div>
				<div class="col-lg-6 col-sm-12 col-xs-12 col-md-6">
                            <div class="mb-3">
                              <label class="form-label required">End Date</label>
                               <input type="date" class="form-control" name="end_date" id="end_date" <?php if($n): ?> value="<?php echo e(date('Y-m-d', strtotime($n['end_date']))); ?>" <?php endif; ?>/>
                             
                            </div></div>
					<div class="col-lg-6 col-sm-12 col-xs-12 col-md-6">
                            <div class="mb-3">

                              <label class="form-label">Image</label>
                              <input type="file"  name="image" id="customFileEg1" class="form-control"
                                accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" />
                                <label class="custom-file-label" for="customFileEg1"></label>
                            </div></div>
				   </div>
					
		
				 
                             <div class="card-footer">
                              <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                         </form>
                            
          </div></div></div></div>
          
                  

      



<?php $__env->stopSection(); ?>


<?php $__env->startPush('script_2'); ?>
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
<script src="<?php echo e(asset('public/theme_assets/plugins/jquery/jquery.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/theme_assets/plugins/jquery-ui/jquery-ui.min.js')); ?>"></script>
<?php $__env->stopPush(); ?>



<?php echo $__env->make('admin.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\E3App_Laravel\resources\views/admin/notification/bannernotification.blade.php ENDPATH**/ ?>