<h1>Verify Your OTP</h1>
<?php ($appname= \App\Models\BusinessSetting::where("key","business_name")->first()->value); ?>
Please Find Your OTP Below:<br>
<h4>OTP :  <?php echo e($data['otp']); ?> </h4><br><hr>
Thanks<br>
Team <?php echo e($appname); ?><?php /**PATH /home/u727738086/domains/thecloudstories.com/public_html/admin/resources/views/email/emailVerificationEmail.blade.php ENDPATH**/ ?>