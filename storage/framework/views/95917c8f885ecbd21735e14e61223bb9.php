
<?php $__env->startSection('title','Add Home Advertiser'); ?>

<?php $__env->startPush('css_or_js'); ?>
<link href="<?php echo e(url('assets/select/styles/multiselect.css')); ?>" rel="stylesheet"/>
    <script src="<?php echo e(url('assets/select/scripts/multiselect.min.js')); ?>"></script>
    <style>
        /* example of setting the width for multiselect */
        #testSelect1_multiSelect {
            width: 100%;
        }
        .multiselect-wrapper .multiselect-list {
    padding: 5px;
    min-width: 91%;
    position:inherit !important;
}

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
 <div class="page-header d-print-none">
          <div class="page-body">
          <div class="container-xl">
            <div class="card">
                 <div class="card-header"><h2 class="page-title">
                 Add Home Advertiser
                </h2></div>
              <div class="card-body">
               <form action="<?php echo e(route('admin.homeadv.store')); ?>" method="post" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                           
                              
                           <div class="row">
							 <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                             <div class="mb-3">
                                  <label class="form-label required">Select Partner</label>
                                 
                                <select id='testSelect1' name="adv_id"  class="form-control">
                                  <?php $__currentLoopData = $partners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $partner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <option value="<?php echo e($partner->id); ?>"><?php echo e($partner->name); ?></option>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            
                             </div>
						 </div>
						 <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				          <div class="mb-3">
                                  <label for="app_rank">Select Position:</label>
                                  <select class="form-control" name="rank">
                                    <?php for($i=1; $i<11; $i++): ?>
                                      <?php if(!in_array($i, $allPosition)): ?>
                                        <option value="<?php echo e($i); ?>"><?php echo e($i); ?></option>
                                      <?php endif; ?>
                                    <?php endfor; ?>
                                  </select>
				            </div>
						   </div>
				          </div>
                             <div class="card-footer">
                              <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                         </form>
                            
                      </div></div></div></div>
                  

        
<?php $__env->stopSection(); ?>


<?php $__env->startPush('script_2'); ?>
 <script>
    document.multiselect('#testSelect1')
        .setCheckBoxClick("checkboxAll", function(target, args) {
            console.log("Checkbox 'Select All' was clicked and got value ", args.checked);
        })
        .setCheckBoxClick("1", function(target, args) {
            console.log("Checkbox for item with value '1' was clicked and got value ", args.checked);
        });

    function enable() {
        document.multiselect('#testSelect1').setIsEnabled(true);
    }

    function disable() {
        document.multiselect('#testSelect1').setIsEnabled(false);
    }
</script>
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
                    url: '<?php echo e(route('admin.category.search')); ?>',
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

<?php echo $__env->make('admin.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u727738086/domains/thecloudstories.com/public_html/admin/resources/views/admin/heading/index.blade.php ENDPATH**/ ?>