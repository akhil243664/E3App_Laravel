
<?php $__env->startSection('content'); ?>
<div class="container">
    <?php if(session()->has('success')): ?>
        <div class="alert alert-success">
        <?php if(is_array(session()->get('success'))): ?>
            <ul>
                <?php $__currentLoopData = session()->get('success'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($message); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        <?php else: ?>
            <?php echo e(session()->get('success')); ?>

        <?php endif; ?>
            </div>
    <?php endif; ?>
    <?php if(session('error')): ?>
    <div class="alert alert-danger alert-dismissible">
         <?php echo session("error"); ?>

    </div>
    <?php endif; ?>
    <?php if(count($errors) > 0): ?>
        <?php if($errors->any()): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo e($errors->first()); ?>


        </div>
        <?php endif; ?>
    <?php endif; ?>
    <br>
    <div class="card">
        <div class="card-header">
            <div class="col-6 card-title">
                <p style="float: left">Edit Country </p> 
            </div>
            <div class="col-6">                
                <a class="btn btn-primary" href="<?php echo e(route('admin.country.index')); ?>" style="float:right;">Back</a>
            </div>
        </div>
        <div class="card-body">
            <form class="form-group" action="<?php echo e(route('admin.country.update',$country->id)); ?>" method="post" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                              <div class="form-group">
                                    <label id="folderLabel">Partner</label><br>
                                    <input type="checkbox" name="admitad" <?php if($admitad->status==1): ?> checked <?php endif; ?>> <span>Admited</span>        
                                    <input type="checkbox" name="cuelink"  <?php if($cuelink->status==1): ?> checked <?php endif; ?>>  <span>Cuelink</span>       
                                    <input type="checkbox" name="impact" <?php if($impact->status==1): ?> checked <?php endif; ?>><span>Impact</span>       
                                </div>                                             
                                <div class="form-group">
                                    <?php ($de_co=\App\Models\DefaultCountry::get()); ?>
                                <label id="folderLabel">Select Country</label>
                                <select class="form-control" name="country">
                                    <?php $__currentLoopData = $de_co; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $de_country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($de_country->id); ?>" <?php if($country->country_name == $de_country->country_name): ?> selected <?php endif; ?>><?php echo e($de_country->country_name); ?> </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                </div>
                                <div class="form-group">
									
                                <label id="folderLabel">Currency</label>
                                <select name="currency" class="form-control js-select2-custom">
                                    <?php $__currentLoopData = \App\Models\Currency::orderBy('currency_code')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option
                                            value="<?php echo e($currency['currency_code']); ?>" <?php if($currency['currency_code'] == $country['currency_code']): ?> selected <?php endif; ?>>
                                            <?php echo e($currency['currency_code']); ?> ( <?php echo e($currency['currency_symbol']); ?> )
                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                </div>                    
                                                                   
                                <div class="form-group">
                                <label id="folderLabel">Slug</label>
                                <input type="text" class="form-control no-space"  value="<?php echo e($country->slug); ?>" readonly disabled>        
                                </div>                    
           
       
        <div class="card-footer">
            <div>
                <input class="btn btn-primary" type="submit" value="Submit">
            </div>
        </div>
    </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('script'); ?>
<script type="text/javascript">
$(document).ready(function() {

// do not allow users to enter spaces:
$(".no-space").on({
  keydown: function(event) {
    if (event.which === 32)
      return false;
  },
  // if a space copied and pasted in the input field, replace it (remove it):
  change: function() {
    this.value = this.value.replace(/\s/g, "");
  }
});

});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\E3App_Laravel\resources\views/admin/country/edit.blade.php ENDPATH**/ ?>