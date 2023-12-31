<?php $__env->startSection('title', 'Category List'); ?>

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
                    <h2 class="page-title" align="left" style="width: 100%;">
                        Main Category List

                    </h2>
                    <div class="flex">
                        <form id="dataSearch">
                            <?php echo csrf_field(); ?>
                            <!-- Search -->
                            <div class="d-flex fluid">
                                <input type="search" name="search" class="form-control" placeholder="search category"
                                    aria-label="search categories">
                                <button type="submit" class="btn btn-success">Search</button>
                            </div>
                            <!-- End Search -->
                        </form>
                    </div>&nbsp; <a align="right" style="float:right !important;"
                        href="<?php echo e(route('admin.category.export-all')); ?>" class="btn btn-danger  float-right">Export All
                    </a>&nbsp;
                    <a align="right" style="float:right !important;" href="<?php echo e(route('admin.category.add')); ?>"
                        class="btn btn-primary  float-right">Add New</a>
                </div>
                <div class="card-body">
                    <div class="table" style="width:100%">
                        <table class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th><button class="table-sort" data-sort="sort-s">#</button></th>
                                    <th><button class="table-sort" data-sort="sort-image">Image</button></th>
                                    <th><button class="table-sort" data-sort="sort-id">ID</button></th>
                                    <th><button class="table-sort" data-sort="sort-name">Category Name</button></th>
                                    <th><button class="table-sort" data-sort="sort-name">User Commission %</button></th>
                                    <th><button class="table-sort" data-sort="sort-type">Action</button></th>
                                </tr>
                            </thead>
                            <tbody class="table-tbody">
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td id="row"><?php echo e($key + $categories->firstItem()); ?></td>

                                        <td class="sort-name">
                                            <?php if($category['image'] == null): ?>
                                                <button type="button" class="btn btn-danger" data-toggle="modal"
                                                    data-target="#exampleModal<?php echo e($category->id); ?>">
                                                    Add Image</button>
                                            <?php else: ?>
                                                <img src="<?php echo e(asset('storage/app/public/category')); ?>/<?php echo e($category['image']); ?>"
                                                    alt="no image" style="width:80px">
                                            <?php endif; ?>
                                        </td>
                                        <td class="sort-id"><?php echo e($category->id); ?></td>
                                        <td class="sort-name"><?php echo e(Str::limit($category['name'], 20, '...')); ?></td>
                                        <td><?php echo e($category->commission); ?> %</td>
                                        <td class="sort-type">
                                            <div class="dropdown">
                                                <button class="btn btn-primary dropdown-toggle align-text-top"
                                                    data-bs-boundary="viewport" data-bs-toggle="dropdown">Actions</button>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item"
                                                        href="<?php echo e(route('admin.category.edit', [$category['id']])); ?>"
                                                        title="edit category">Edit
                                                    </a>
                                                    <a href="<?php echo e(route('admin.category.delete', [$category['id']])); ?>"
                                                        class="dropdown-item" href="javascript:"
                                                        onclick="return confirm('Are you sure?');"
                                                        title="delete category">Delete
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
                <div class="card-footer  page-area" align="right">
                    <div class="pull-right" style="float: right;">
                        <?php echo e($categories->render('pagination::bootstrap-4')); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="modal fade" id="exampleModal<?php echo e($category->id); ?>" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel<?php echo e($category->id); ?>" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="<?php echo e(route('admin.category.update_cat_img', $category->id)); ?>" method="post"
                    enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel<?php echo e($category->id); ?>" align="left">Add Image</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" align="right">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group" id="viewerbox" style="display:none;margin-bottom:0%;">
                                <center>
                                    <img style="width: 200px;border: 1px solid #3399db; border-radius: 10px; max-height:200px; padding: 11px;"
                                        id="viewer"
                                        src="<?php echo e(asset('storage/app/public/category')); ?>/<?php echo e($category['image']); ?>"
                                        alt="offer banner" />
                                </center>
                            </div>

                            <div class="mb-3">
                                <div class="form-label">Category Image <small style="color: red">* (Ratio=>1:1)</small>
                                </div>
                                <input type="file" name="image" id="customFileEg1" class="form-control"
                                    accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" />
                                <label class="custom-file-label" for="customFileEg1"></label>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('script_2'); ?>
    <script>
        $(document).on('ready', function() {

            $('#dataSearch').on('submit', function(e) {
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
                    beforeSend: function() {
                        $('#loading').show();
                    },
                    success: function(data) {
                        $('#table-div').html(data.view);
                        $('#itemCount').html(data.count);
                        $('.page-area').hide();
                    },
                    complete: function() {
                        $('#loading').hide();
                    },
                });
            });


            // INITIALIZATION OF SELECT2
            // =======================================================
            $('.js-select2-custom').each(function() {
                var select2 = $.HSCore.components.HSSelect2.init($(this));
            });
        });
    </script>

    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#viewer').attr('src', e.target.result);
                    document.getElementById("viewerbox").style.display = 'block';
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileEg1").change(function() {
            readURL(this);
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\E3App_Laravel\resources\views/admin/category/list.blade.php ENDPATH**/ ?>