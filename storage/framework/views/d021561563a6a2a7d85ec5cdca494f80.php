
<?php $__env->startSection('title','Update Team Member'); ?>

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
                  Update Team Member
                </h2>
               </div>
              <div class="card-body">
               <form action="<?php echo e(route('admin.team.update',[$e['id']])); ?>" method="post" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>

                           <div class="form-group">
                                    <?php ($de_co=\App\Models\DefaultCountry::get()); ?>
                                <label id="folderLabel">Select Country</label>
                                <select class="form-control" name="country">
                                    <?php $__currentLoopData = $de_co; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $de_country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($de_country->id); ?>" <?php if($e->country_slug == $de_country->slug): ?> selected <?php endif; ?>><?php echo e($de_country->country_name); ?> </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                </div>
                     <div class="mb-3">
                       <label class="form-label required">Role</label>
                        <select id="exampleFormControlSelect1" name="role_id" class="form-control js-select2-custom" required>
                                        <option value="" selected disabled>Select Role</option>
                                        <?php $__currentLoopData = $rls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($r->id); ?>" <?php echo e($r['id']==$e['role_id']?'selected':''); ?>><?php echo e($r->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              
                        </select>
                    </div>
                            <div class="mb-3">
                              <label class="form-label required">First Name</label>
                              <input type="text" class="form-control" name="f_name" id="f_name" value="<?php echo e($e['f_name']); ?>" placeholder="john" />
                            </div>
                             <div class="mb-3">
                              <label class="form-label required">Last Name</label>
                              <input type="text" class="form-control" name="l_name" id="l_name" value="<?php echo e($e['l_name']); ?>" placeholder="doe"/>
                            </div>
                             <div class="mb-3">
                              <label class="form-label required">Phone</label>
                              <input type="phone" class="form-control" name="phone" id="phone" value="<?php echo e($e['phone']); ?>" placeholder="9999999999"/>
                            </div>
                             <div class="mb-3">
                              <label class="form-label required">Email</label>
                              <input type="email" class="form-control" name="email" id="email" value="<?php echo e($e['email']); ?>" placeholder="xyz@gmail.com"/>
                               <input type="hidden" name="position" value="1">
                            </div>
                             <div class="mb-3">
                              <label class="form-label required">Password</label>
                              <input type="text" class="form-control" name="password" id="password" placeholder="Enter 6 letters or above password if you want to change" />
                               <input type="hidden" name="position" value="1">
                            </div>
                             
                               <div class="form-group"  id="viewerbox" style="margin-bottom:0%;">
                                <center>
                                    <img style="width: 200px;border: 1px solid #3399db; border-radius: 10px; max-height:200px; padding: 11px;" id="viewer"
                                            src="<?php echo e(asset('storage/app/public/admin')); ?>/<?php echo e($e['image']); ?>" alt="Team thumbnail"/>
                                </center>
                            </div>
                            
                             <div class="mb-3">
                            <div class="form-label">Image <small style="color: red">* (Ratio=> 1:1)</small></div>
                            <input type="file"  name="image" id="customFileEg1" class="form-control"
                                accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" />
                                <label class="custom-file-label" for="customFileEg1"></label>
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
<?php echo $__env->make('admin.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\E3App_Laravel\resources\views/admin/team/edit.blade.php ENDPATH**/ ?>