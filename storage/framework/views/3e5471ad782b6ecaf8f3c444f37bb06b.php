<?php  header('Access-Control-Allow-Origin: *');
  header('Content-type: application/json'); ?>
<?php $__env->startSection('title','Customer Profile'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header d-print-none">
          <div class="container-xl">
            <div class="row g-2 align-items-center">
              <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                  Overview
                </div>
                <h2 class="page-title">
                  Customer Profile
                </h2>
              </div>
       
            </div>
          </div>
        </div>
        <!-- Page body -->
        <div class="page-body">
          <div class="container-xl">
            <div class="row row-deck row-cards">
              <div class="col-md-6 col-lg-4">
                   <div class="card">
                  <div class="card-body p-4 text-center">
					  <img class="avatar avatar-xl mb-3 avatar-rounded" src="<?php echo e(url('/')); ?>/storage/app/public/user/<?php echo e($customers['image']); ?>" onerror="this.src='<?php echo e(url('/')); ?>/storage/app/public/images/noimage.png'" alt="no image" >
					 
                    <h3 class="m-0 mb-1"> <span class="badge bg-purple-lt" style="font-size: 18px !impoertant;"><?php echo e($customers['name']); ?></span></h3>
                    <div class="text-muted"><span class="badge bg-yellow-lt" style="font-size: 18px !impoertant;"><b> Phone = </b><?php echo e($customers['phone']); ?></span></div>
                    <div class="mt-3">
						<?php if($bankdetails): ?>
						<u><b>Bank/UPI/Paytm Details</b></u><br>
						<?php if($bankdetails['bank_name'] != NULL): ?>
                        <b> Bank Name = </b><?php echo e($bankdetails['bank_name']); ?>,<br><b> Account Number = </b><?php echo e($bankdetails['ac_no']); ?>, <br><b> Account Holder Name = </b><?php echo e($bankdetails['ac_holder_name']); ?>,<br><b> IFSC = </b><?php echo e($bankdetails['ifsc']); ?>

						<br>
						<?php endif; ?>
						<?php if($bankdetails['upi'] != NULL): ?>
						<b>UPI :</b><?php echo e($bankdetails['upi']); ?> <br>
						<?php endif; ?>
						<?php if($bankdetails['amazon_no'] != NULL): ?>
						<b>Amazon :</b><?php echo e($bankdetails['amazon_no']); ?> <br>
						<?php endif; ?>
						<?php if($bankdetails['paytm_no'] != NULL): ?>
						<b>Paytm :</b><?php echo e($bankdetails['paytm_no']); ?> <br>
						<?php endif; ?>
						<?php endif; ?>
						
                    </div>
                  </div>
                  <div class="d-flex">
                 
                  </div>
                </div>
              </div>
              <div class="col-md-12 col-lg-8">
				  <div class="card">
                 <div class="card-header"><h2 class="page-title">
                  Customer Complaint List
                </h2></div>
              <div class="card-body">
                 <div class="table" style="width:100%">
                  <table id="example" class="display" style="width:100%">
                    <thead>
                      <tr>
                         <th><button class="table-sort" data-sort="sort-s">#</button></th>
                         <th><button class="table-sort" data-sort="sort-name">User</button></th>
                        <th><button class="table-sort" data-sort="sort-email">Order ID</button></th>
						  <th><button class="table-sort" data-sort="sort-email">Complaint</button></th>
                        <th><button class="table-sort" data-sort="sort-phone">Status</button></th>
                        <th><button class="table-sort" data-sort="sort-role">Actions</button></th>
                      </tr>
                    </thead>
                    <tbody class="table-tbody">
                      
                           <?php $__currentLoopData = $complains; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td id="row"><?php echo e($k+$complains->firstItem()); ?></td>
                              
                             
                                    <td class="sort-name"> <?php echo e($e->user['name']); ?></td>
                                     <td class="sort-email"> <?php echo e($e['order_id']); ?>

										</td>
									<td class="sort-email"> <b><?php echo e($e['complain']); ?></b>
										</td>
                                     <td class="sort-phone"> <?php if($e['status']==0): ?> <p style="color:orange"> Not Replied Yet</p> <?php else: ?>  <p style="color:green">Replied</p><?php endif; ?>
									</td>
                                      <td class="sort-phone"> <?php if($e['status']==0): ?> <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal<?php echo e($e->id); ?>">
										  Reply</button> <?php else: ?>  <p style="color:green">Replied<br><b style="color:black">Reply: </b><span style="color:black"><?php echo e($e['reply']); ?></span></p><?php endif; ?>
									</td>
                                   
                                </tr>
						
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        
                    </tbody>
                  </table>
                </div>
              </div>
               <div class="card-footer" align="right">
                                <?php echo e($complains->appends(['complains' => $complains->currentPage()])->links()); ?>    
                         
                   
                <!-- End Pagination -->
            </div>
            </div>
                
              </div>
             
              <div class="col-md-12 col-lg-12">
                <div class="card">
                 <div class="card-header"><h2 class="page-title">
                  Customer Withdrawal Requests List
                </h2></div>
              <div class="card-body">
                <div class="table" style="width:100%">
                  <table id="example2" class="display" style="width:100%">
                    <thead>
                      <tr>
                         <th><button class="table-sort" data-sort="sort-s">#</button></th>
                         <th><button class="table-sort" data-sort="sort-name">User</button></th>
                        <th><button class="table-sort" data-sort="sort-email">Amount</button></th>
						  <th><button class="table-sort" data-sort="sort-email">Withdrawal Medium</button></th>
                        <th><button class="table-sort" data-sort="sort-phone">Status</button></th>
                        <th><button class="table-sort" data-sort="sort-role">Action</button></th>
                      </tr>
                    </thead>
                    <tbody class="table-tbody">
                  
                           <?php $__currentLoopData = $reqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td id="row"><?php echo e($k+$reqs->firstItem()); ?></td>
                              
                             
                                    <td class="sort-name"> <?php echo e($e->user['name']); ?></td>
                                     <td class="sort-email"> <?php echo e($e['amount']); ?>

										</td>
									<td class="sort-email"> <b><?php echo e($e['medium']); ?></b><br><?php echo $e['medium_details']; ?>

										</td>
                                     <td class="sort-phone"> <?php if($e['approved']==0): ?> <p style="color:orange"> Not Approved Yet</p><?php elseif($e['approved']==2): ?> <p style="color:red"> Rejected </p> <?php else: ?>  <p style="color:green">Approved</p><?php endif; ?>
									</td>
                                      <td class="sort-phone"> <?php if($e['approved']==0): ?> <a href="<?php echo e(route('admin.customer.approve_withdraw_requests',$e['id'])); ?>" class="btn btn-primary" >Approve</a>&nbsp;&nbsp; <a href="<?php echo e(route('admin.customer.reject_withdraw_requests',$e['id'])); ?>" class="btn btn-danger" >Reject</a><?php elseif($e['approved']==2): ?> <p style="color:red"> Rejected </p><?php else: ?>  <p style="color:green">Approved</p><?php endif; ?>
									</td>
                                   
                                </tr>
						<!-- Modal -->
								
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        
                    </tbody>
                  </table>
                </div>
              </div>
               <div class="card-footer" align="right">
               <?php echo e($reqs->appends(['reqs' => $reqs->currentPage()])->links()); ?> 
                          
                   
                <!-- End Pagination -->
            </div>
            </div>
              </div>
              <div class="col-md-12 col-lg-12">
                <div class="card">
                 <div class="card-header"><h2 class="page-title">
                  Customer Clicks List
                </h2></div>
              <div class="card-body">
               <div class="table" style="width:100%">
                  <table id="example3" class="display" style="width:100%">
                    <thead>
                      <tr>
                         <th><button class="table-sort" data-sort="sort-s">#</button></th>
                         <th><button class="table-sort" data-sort="sort-name">User</button></th>
                        <th><button class="table-sort" data-sort="sort-email">Click ID</button></th>
						  <th><button class="table-sort" data-sort="sort-email">Image</button></th>
                        <th><button class="table-sort" data-sort="sort-phone">URL</button></th>
						    <th><button class="table-sort" data-sort="sort-phone">Created At</button></th>
                      </tr>
                    </thead>
                    <tbody class="table-tbody">
               
                           <?php $__currentLoopData = $clicks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td id="row"><?php echo e($k+$clicks->firstItem()); ?></td>
                              
                             
                                    <td class="sort-name"> <?php echo e($e->user['name']); ?></td>
                                     <td class="sort-email"> <?php echo e($e['id']); ?>

										</td>
									<td class="sort-email"> <img width="100px" src="<?php echo e($e['image']); ?>" onerror="this.src='<?php echo e(url('/')); ?>/storage/app/public/images/noimage.png'" alt="no image" >
										</td>
                                     <td class="sort-email"> <?php echo e($e['tracking_link']); ?> 
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
              
                            <?php echo e($clicks->appends(['clicks' => $clicks->currentPage()])->links()); ?> 
                   
                <!-- End Pagination -->
            </div>
            </div>
              </div>
              <div class="col-12">
                    <div class="card">
                 <div class="card-header"><h2 class="page-title">
                  Customer Orders List
                </h2></div>
              <div class="card-body">
                 <div class="table" style="width:100%">
                  <table id="example4" class="display" style="width:100%">
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
             
                           <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td id="row" class="sort-s"><?php echo e($k+$orders->firstItem()); ?></td>
									  <td>
                                 
                               <img src="<?php echo e(asset('storage/app/public/partner')); ?>/<?php echo e($e['logo']); ?>" alt="no image" style="width:80px">
                              
                                </td>
                                    <td class="sort-name"> <?php echo e($e->user['name']); ?></td>
                                     <td class="sort-email"> <?php echo e($e['id']); ?></td>
									<td class="sort-id"> <?php echo e($e['partner_order_id']); ?></td>
									<td class="sort-phone"> <?php echo e($e['advertisers']); ?></td>
									<td class="sort-partner"> <b><?php echo e($e['affiliate_partner']); ?></b></td>
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
              
                       
				   <?php echo e($orders->appends(['orders' => $orders->currentPage()])->links()); ?> 
                   
                <!-- End Pagination -->
            </div>
            </div>
              </div>
              </div>
            </div>
          </div>
 <?php $__currentLoopData = $complains; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<!-- Modal -->
		<div class="modal fade" id="exampleModal<?php echo e($e->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel<?php echo e($e->id); ?>" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<form action="<?php echo e(route('admin.customer.reply',$e->id)); ?>" method="post" enctype="multipart/form-data">
					<?php echo csrf_field(); ?>
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel<?php echo e($e->id); ?>" align="left">Add Reply To Complaint</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"  align="right">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">

							<div class="mb-3">
								<div class="form-label">Complaint <small style="color: red">* </small></div>
								<input type="text" class="form-control" value="<?php echo e($e['complain']); ?>" readonly/>
							</div>	

							<div class="mb-3">
								<div class="form-label">Reply <small style="color: red">* </small></div>
								<input type="text"  name="reply" class="form-control" required />
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
<?php echo $__env->make('admin.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home3/e3appvuu/public_html/e3-admin/resources/views/admin/customer/profile.blade.php ENDPATH**/ ?>