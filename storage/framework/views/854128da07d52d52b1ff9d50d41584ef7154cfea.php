<?php $__env->startSection('title','Clicks List'); ?>

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
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>

        <!-- Page body -->
        <div class="page-body">
          <div class="container-xl">
            <div class="card">
                 <div class="card-header"><h2 class="page-title" align="left" style="width: 100%;">
                  Clicks List
                </h2>&nbsp;<a  align="right" style="float:right !important;" href="<?php echo e(route('admin.customer.exportclicks')); ?>" class="btn btn-danger  float-right">Export All </a>&nbsp;<div class="flex">
					 <a href="<?php echo e(route('admin.customer.deleteclicks')); ?>" class="btn btn-secondary"> Delete Clicks Older than 10 days</a></div></div>
              <div class="card-body">
                  <div class="table" style="width:100%">
                  <table id="example" class="display" style="width:100%">
                    <thead>
                      <tr>
                         <th><button class="table-sort" data-sort="sort-s">#</button></th>
                         <th><button class="table-sort" data-sort="sort-name">User</button></th>
                        <th><button class="table-sort" data-sort="sort-email">Click Id</button></th>
						  <th><button class="table-sort" data-sort="sort-email">image</button></th>
                        <th><button class="table-sort" data-sort="sort-phone">Url</button></th>
						  <th><button class="table-sort" data-sort="sort-phone">Created At</button></th>
                      </tr>
                    </thead>
                    <tbody class="table-tbody">
                           <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           
                                     <tr>
                                    <td id="row"><?php echo e($k+$customers->firstItem()); ?></td>
                              
                                   
                                    <td class="sort-name"> <?php if($e->user != NULL): ?> <?php echo e($e->user['name']); ?> <?php else: ?> User Deleted <?php endif; ?></td>
                                     <td class="sort-email"> <?php echo e($e['id']); ?>

										</td>
									<td class="sort-email"> <img width="100px" src="<?php echo e($e['image']); ?>" onerror="this.src='<?php echo e(url('/')); ?>/storage/app/public/images/noimage.png'" alt="no image" >
										</td>
                                     <td class="sort-email"><span> <?php echo e($e['tracking_link']); ?> </span>
										</td>
									
									 <td class="sort-email"> <?php echo e(date('d-M-Y',strtotime($e['created_at']))); ?>

										</td>
                                   
                                </tr>
						
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        
                    </tbody>
                  </table>
                </div>
              </div>
               <div class="card-footer" align="right">
              
                              <?php echo e($customers->links("pagination::bootstrap-4")); ?>

                   
                <!-- End Pagination -->
            </div>
            </div>
          </div>
        </div>



<?php $__env->stopSection(); ?>


<?php $__env->startPush('script_2'); ?>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js" integrity="sha512-57oZ/vW8ANMjR/KQ6Be9v/+/h6bq9/l3f0Oc7vn6qMqyhvPd1cvKBRWWpzu0QoneImqr2SkmO4MSqU+RpHom3Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ed): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewer<?php echo e($ed->id); ?>').attr('src', e.target.result);
                    document.getElementById("viewerbox<?php echo e($ed->id); ?>").style.display = 'block';
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

         $("#customFileEg1").change(function () {
            readURL(this);
        });
    </script>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    
    <!-- jQuery UI 1.11.4 -->
<script src="<?php echo e(asset('public/theme_assets/plugins/jquery/jquery.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/theme_assets/plugins/jquery-ui/jquery-ui.min.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home1/lpabdgkz/public_html/e3app.in/e3-admin/resources/views/admin/customer/clicks.blade.php ENDPATH**/ ?>