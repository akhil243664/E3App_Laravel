<?php $__env->startSection('title','Orders List'); ?>

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
                  Orders List
                </h2> <a  align="right" style="float:right !important;" href="<?php echo e(route('admin.customer.exportorders')); ?>" class="btn btn-danger  float-right">Export All </a>&nbsp;</div>
              <div class="card-body">
                <div class="table" style="width:100%">
                  <table id="example" class="display" style="width:100%">
                    <thead>
                      <tr>
                         <th><button class="table-sort" data-sort="sort-s">#</button></th>
                         <th><button class="table-sort" data-sort="sort-name">Image</button></th>
                         <th><button class="table-sort" data-sort="sort-name">User</button></th>
                         <th><button class="table-sort" data-sort="sort-email">Order ID</button></th>
                         <th><button class="table-sort" data-sort="sort-id">Partner Order ID</button></th>
                         <th><button class="table-sort" data-sort="sort-phone">Advertiser</button></th>
                         <th><button class="table-sort" data-sort="sort-partner">Affiliate Partner</button></th>
                          <th><button class="table-sort" data-sort="sort-order">Commission Status</button></th>
                         <th><button class="table-sort" data-sort="sort-order">Order Amount</button></th>
                          <th><button class="table-sort" data-sort="sort-url">Admin Earning</button></th>
                         <th><button class="table-sort" data-sort="sort-earning">User Earning</button></th>
                      </tr>
                    </thead>
                    <tbody class="table-tbody">
             
                           <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td id="row" class="sort-s"><?php echo e($k+$customers->firstItem()); ?></td>
                                      <td>
                                 
                               <img src="<?php echo e(asset('storage/app/public/partner')); ?>/<?php echo e($e['logo']); ?>" alt="no image" style="width:80px">
                              
                                </td>
                                    <td class="sort-name"><?php if($e['user']): ?> <?php echo e($e['user']['name']??"No name"); ?> <br> <?php echo e($e['user']['email']); ?> <?php else: ?> User Deleted <?php endif; ?> </td>
                                     <td class="sort-email"> <?php echo e($e['id']); ?></td>
                                    <td class="sort-id"> <?php echo e($e['partner_order_id']); ?></td>
                                    <td class="sort-phone"> <?php echo e($e['advertisers']); ?></td>
                                    <td class="sort-partner"> <b><?php if($e['affiliate_partner']=="cuelinks"): ?> <span style="color:blue"> <?php elseif($e['affiliate_partner']=="impact"): ?> <span style="color:orange"><?php else: ?> <span style="color:green"><?php endif; ?>  <?php echo e($e['affiliate_partner']); ?></span></b></td>
                                    <td class="sort-url"> <b><?php if($e['order_status']==0): ?> <span style="color:orange">Pending </span> <?php elseif($e['order_status']==1): ?>  <span style="color:green">Approved </span> <?php else: ?>  <span style="color:red">Rejected </span> <?php endif; ?></b></td>
                                    <td class="sort-order"> <b><?php echo e($e['order_amount']); ?></b></td>
                                        <td class="sort-url"> <b><?php echo e($e['admin_earn']); ?></b></td>
                                    <td class="sort-earning"> <b><?php echo e($e['earning_amount']); ?></b></td>
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
    

<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u727738086/domains/thecloudstories.com/public_html/admin/resources/views/admin/customer/orders.blade.php ENDPATH**/ ?>