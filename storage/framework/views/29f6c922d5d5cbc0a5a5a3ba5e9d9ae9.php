
<?php $__env->startSection('title','Team Member List'); ?>

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
        <!-- Page body -->
        <div class="page-body">
          <div class="container-xl">
            <div class="card">
                <div class="card-header">
					<h2 class="page-title"  align="left" style="width: 100%;">
                  Team Member List
                    </h2>
					<div class="flex">
					<form id="dataSearch">
                    <?php echo csrf_field(); ?>
                    <!-- Search -->
                    <div class="d-flex fluid">
                        <input type="search" name="search" class="form-control" placeholder="Search Team Member" aria-label="Search Team Member">
                        &nbsp;<button type="submit" class="btn btn-success">Search</button>
                    </div>
                    <!-- End Search -->
						</form></div>
                        <a  align="right" style="float:right !important;" href="<?php echo e(route('admin.team.export-all')); ?>" class="btn btn-danger  float-right">Export All </a>&nbsp;
               </div>
              <div class="card-body">
                  <div class="table" style="width:100%">
                  <table id="example" class="display" style="width:100%">
                    <thead>
                      <tr>
                         <th><button class="table-sort" data-sort="sort-s">#</button></th>
                            <th><button class="table-sort" data-sort="sort-image">Image</button></th>
                         <th><button class="table-sort" data-sort="sort-name">Name</button></th>
                        <th><button class="table-sort" data-sort="sort-email">Email</button></th>
                        <th><button class="table-sort" data-sort="sort-phone">Phone</button></th>
                        <th><button class="table-sort" data-sort="sort-phone">Country Slug</button></th>
                        <th><button class="table-sort" data-sort="sort-role">Role</button></th>
                        <th><button class="table-sort" data-sort="sort-type">Actions</button></th>
                      </tr>
                    </thead>
                    <tbody class="table-tbody">
                           <?php $__currentLoopData = $em; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td id="row"><?php echo e($k+$em->firstItem()); ?></td>
                                    <td>
                                 
                               <img src="<?php echo e(asset('storage/app/public/admin')); ?>/<?php echo e($e['image']); ?>" alt="no image" style="width:80px">
                              
                                </td>
                             
                                    <td class="sort-name"> <?php echo e($e['f_name']); ?> <?php echo e($e['l_name']); ?></td>
                                     <td class="sort-email"> <?php echo e($e['email']); ?></td>
                                     <td class="sort-phone"> <?php echo e($e['phone']); ?></td>
                                      <td class="sort-phone"> <?php echo e($e['slug']); ?></td>
                                       <td><?php echo e($e->role?$e->role['name']:'role deleted'); ?></td>
                                    <td class="sort-type">
                                    <div class="dropdown">
                                      <button class="btn btn-primary dropdown-toggle align-text-top" data-bs-boundary="viewport" data-bs-toggle="dropdown">Actions</button>
                                      <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item"
                                                    href="<?php echo e(route('admin.team.edit',[$e['id']])); ?>" title="edit category">Edit
                                                </a>
                                                <a  href="<?php echo e(route('admin.team.delete',[$e['id']])); ?>" class="dropdown-item" href="javascript:"
                                                    onclick="return confirm('Are you sure?');" title="delete category">Delete
                                                </a>
                                      </div>
                                    </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        
                    </tbody>
                  </table>
                </div>
              </div>
               <div class="card-footer" align="right">
              
                            <?php echo $em->links(); ?>

                   
                <!-- End Pagination -->
            </div>
            </div>
          </div>
        </div>



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

<?php echo $__env->make('admin.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home3/e3appvuu/public_html/e3-admin/resources/views/admin/team/list.blade.php ENDPATH**/ ?>