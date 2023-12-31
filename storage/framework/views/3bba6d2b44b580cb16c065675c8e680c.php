
<?php $__env->startSection('title','Update Advertiser'); ?>

<?php $__env->startPush('css_or_js'); ?>

<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
          <div class="page-body">
          <div class="container-xl">
            <div class="card">
                 <div class="card-header"><h2 class="page-title">
                  Advertiser Update
                </h2></div>
              <div class="card-body">
               <form action="<?php echo e(route('admin.advertiser.update',[$partner['id']])); ?>" method="post" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                            <div class="mb-3">
                              <label class="form-label required">Advertiser Name</label>
                              <input type="text" class="form-control" name="name" id="name" value="<?php echo e($partner['name']); ?>"/>
                            </div>
                              <div class="form-group"  id="viewerbox" style="margin-bottom:0%;">
                                <center>
                                    <img style="width: 200px;border: 1px solid #3399db; border-radius: 10px; padding: 11px;" id="viewer"
                                         <?php if(isset($partner)): ?>
                                        src="<?php echo e(asset('storage/app/public/partner')); ?>/<?php echo e($partner['image']); ?>"
                                        <?php else: ?>
                                        src="<?php echo e(asset('assets/theme_assets/img')); ?>/upload1.png"
                                        <?php endif; ?>
                                        alt="image"/>
                                </center>
                            </div>
                             <div class="mb-3">
                            <div class="form-label">Image <small style="color: red">* (Ratio=> 1:1)</small></div>
                            <input type="file"  name="image" id="customFileEg1" class="form-control"
                                accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" />
                             </div>
				            <div class="mb-3">
                              <label class="form-label required">Left Tab Text</label>
                              <input type="phone" class="form-control" name="left_tab" id="left_tab" value="<?php echo e($partner['left_tab']); ?>" placeholder="ex: Reward Rates"/>
                            </div>
                             <div class="mb-3">
                              <label class="form-label required">Left Tab Description</label>
                              <textarea class="form-control" name="left_tab_desc" id="summernote1"><?php echo e($partner['left_tab_desc']); ?></textarea>
                            </div>
                             <div class="mb-3">
                              <label class="form-label required">Right Tab Text</label>
                              <input type="text" class="form-control" name="right_tab" id="right_tab" value="<?php echo e($partner['right_tab']); ?>"  placeholder="ex: Offer Terms" />
                               <input type="hidden" name="position" value="1">
                            </div>
                             <div class="mb-3">
                              <label class="form-label required">Right Tab Description</label>
                              <textarea class="form-control" name="right_tab_desc" id="summernote2"><?php echo e($partner['right_tab_desc']); ?></textarea>
                            </div>
                             <div class="card-footer">
                              <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                         </form>
                            
                      </div></div></div></div>
                  

<?php $__env->stopSection(); ?>


<?php $__env->startPush('script_2'); ?>

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
                    url: '<?php echo e(route('admin.advertiser.search')); ?>',
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
<?php echo $__env->make('admin.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u727738086/domains/thecloudstories.com/public_html/admin/resources/views/admin/partner/edit.blade.php ENDPATH**/ ?>