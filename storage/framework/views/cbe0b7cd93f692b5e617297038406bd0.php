 
<?php ($admin = \App\Models\Admin::find(auth('admin')->id())); ?>
  <?php ($footer=\App\Models\BusinessSetting::where('key','footer_text')->where('country_slug',$admin->country_slug)->first()->value); ?>
        <footer class="footer footer-transparent d-print-none fixed footer-fixed">
          <div class="container-xl">
            <div class="row text-center align-items-center flex-row-reverse">
             
              <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                <ul class="list-inline list-inline-dots mb-0">
                  <li class="list-inline-item">
                    <?php echo e($footer); ?>

                  </li>
    
                </ul>
              </div>
            </div>
          </div>
        </footer><?php /**PATH /home/u727738086/domains/thecloudstories.com/public_html/admin/resources/views/admin/layout/footer.blade.php ENDPATH**/ ?>