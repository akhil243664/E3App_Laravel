
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
            <div class="row w-100"> 
                <div class="col-6">
                    <h4 class=""><span style="border-bottom: 4px solid #6773ff;">Country </span></h4>
                </div>
                <div class="col-6">                      
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addcountry" style="float:right">Add Country</button>
                </div>           
            </div> </div>
            <div class=" justify-content-between align-items-center flex-wrap grid-margin">
              
                    <!-- Modal -->
                <div class="modal fade" id="addcountry" tabindex="-1" aria-labelledby="folderLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="folderLabel">Add Country</h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="btn-close"></button>
                        </div>
                        <form action="<?php echo e(route('admin.country.store')); ?>" method="post" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                        <div class="modal-body">
                                <div class="form-group">
                                    <label id="folderLabel">Partner</label><br>
                                    <input type="checkbox" name="admitad" > <span>Admited</span>        
                                    <input type="checkbox" name="cuelink"  >  <span>Cuelink</span>       
                                    <input type="checkbox" name="impact" ><span>Impact</span>       
                                </div>                                            
                                <div class="form-group">
                                    <?php ($de_co=\App\Models\DefaultCountry::get()); ?>
                                <label id="folderLabel">Select Country</label>
                                <select class="form-control" name="country">
                                    <?php $__currentLoopData = $de_co; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $de_country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($de_country->id); ?>"><?php echo e($de_country->country_name); ?> </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                </div>
                                <div class="form-group">
                                <label id="folderLabel">Currency</label>
                                 <select name="currency" class="form-control js-select2-custom">
                                    <?php $__currentLoopData = \App\Models\Currency::orderBy('currency_code')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option
                                            value="<?php echo e($currency['currency_code']); ?>">
                                            <?php echo e($currency['currency_code']); ?> ( <?php echo e($currency['currency_symbol']); ?> )
                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                </div>                    
                                                                 
                                <div class="form-group">
                                <label id="folderLabel">Slug(Not Changeable Later)</label>
                                <input type="text"  name="slug" class="form-control no-space" placeholder="in">        
                                </div>                    
                                                  
                                    
                            </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" id="submit" class="btn btn-primary">Submit</button>
                        </div>
                        </form>
                        </div>
                    </div>
                </div>               
            </div>
        </div>
        <div class="card">
        <div class="card-body">
            <div class="card-content collapse show">
                <div class="card-body ">
                    <div class="table-responsive">
                        <table id="example" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th><?php echo e(__('#')); ?></th>
                                    <th>Country Name</th>
                                    <th>Country Code</th>
                                    <th>Slug</th>
                                    <th>Status</button></th>
                                    <th>Currency</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody  class="table-tbody" id="table-div"> 
                                 <?php $i = 1; ?>
                             <?php $__currentLoopData = $country; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$partner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td id="row"><?php echo e($i); ?></td>
                                   
                                    <td class="sort-id"><?php echo e($partner->country_name); ?></td>
                                    <td class="sort-id"><?php echo e($partner->country_code); ?></td>
                                    <td class="sort-name"> <?php echo e($partner->slug); ?></td>
                                     <td class="sort-role"> <center> <label class="form-check form-check-single form-switch" for="stocksCheckboxactive<?php echo e($partner->id); ?>">
                                          <input type="checkbox" class="form-check-input" onclick="myFunction2<?php echo e($partner->id); ?>()" id="stocksCheckboxactive<?php echo e($partner->id); ?>" <?php echo e($partner->status?'checked':''); ?>>
                                          </label>
                                        </center>
                                        <script>
                                    function myFunction2<?php echo e($partner->id); ?>() {
                                      if (window.confirm('Do you want to change the active status?'))
                                    {
                                        window.location.href = "<?php echo e(route('admin.country.active_status',[$partner->id,$partner->status?0:1])); ?>"
                                    }
                                    }
                                    </script>                                    
                                    </td>
                                    <td class="sort-name"> <?php echo e($partner->currency_symbol); ?></td>
                                    <td class="sort-type">
                                    <div class="dropdown">
                                      <button class="btn btn-primary dropdown-toggle align-text-top" data-bs-boundary="viewport" data-bs-toggle="dropdown">Actions</button>
                                      <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item"
                                                    href="<?php echo e(route('admin.country.edit',[$partner['id']])); ?>" title="edit partner">Edit
                                                </a>
                                                <a  href="<?php echo e(route('admin.country.delete',[$partner['id']])); ?>" class="dropdown-item" href="javascript:"
                                                    onclick="return confirm('Are you sure?');" title="delete partner">Delete
                                                </a>
                                      </div>
                                    </div>
                                    </td>
                                </tr>
                                <?php $i++; ?>
                        
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                         
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
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
<?php echo $__env->make('admin.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u727738086/domains/thecloudstories.com/public_html/admin/resources/views/admin/country/list.blade.php ENDPATH**/ ?>