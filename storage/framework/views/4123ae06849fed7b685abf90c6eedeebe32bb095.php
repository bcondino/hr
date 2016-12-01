<?php $__env->startSection('title', 'Payroll Process Details'); ?>

<?php $__env->startSection('content'); ?>

<!-- header -->
<div class="header--title_container">
	<div class="uk-container uk-container-center">
		<div class="container-title">
			<h1 class="page-title"><span class="uk-icon uk-icon-file-text"></span> <strong>Payroll Process Details</strong> </h1>
		</div>
	</div>
</div>

	<div class="uk-container uk-container-center">
		<div class="uk-grid main">
			<aside class="uk-width-1-4">
				<ul class="uk-nav uk-nav-side uk-nav-parent-icon" data-uk-nav>
					<li><a href="<?php echo e(url('payrollmanagement/profile')); ?>">Payroll Profile</a></li>
					<li class="uk-parent"><a href="#">Earnings and Deductions </a>
						<ul class="uk-nav-sub">
							<li><a href="<?php echo e(url('payrollmanagement/rearningsdedn')); ?>">Recurring Earnings and Deductions</a></li>
							<li><a href="<?php echo e(url('payrollmanagement/nonrearningsdedn')); ?>">Non-recurring Earnings and Deductions</a></li>
						</ul>
					</li>
					<li class="uk-active"><a href="<?php echo e(url('payrollmanagement/payrollprocess')); ?>">Payroll Process</a></li>
          <!-- 20161027 updated by Melvin Militante; Reason: To add payroll report interface -->
          <li><a href="<?php echo e(url('payrollmanagement/report')); ?>">Reports</a></li>
				</ul>
			</aside>
			
			<div class="tm-main uk-width-3-4" >
				<div class="button-container">
					<a href="<?php echo e(url('payrollmanagement/payrollprocess')); ?>"><button class="uk-button btn-cancel" data-uk-modal="{target:'#generate'}"><span class="uk-icon uk-icon-arrow-left"></span> Back</button></a>
				</div>
				<table id="payrollprocessdetails" class="uk-table uk-table-hover uk-table-striped payroll--table">
			<thead class="payroll--table_header">
			<tr>
                  <th>Employee Name</th>
                  <th><center>Salary</center></th>
                  <th><center>Daily Rate</center></th>
                  <th><center>Gross</center></th>
                  <th><center>Deduction</center></th>
                  <th><center>Net Pay</center></th>
              </tr>
          </thead>
          <tbody style="text-align: right">
            <?php foreach($pay_proc_det as $pp_det): ?>
          		<tr>
          			<td style="text-align: left">
						<a href=" <?php echo e(url('payrollmanagement/payrollprocessempdetails/'. $pp_det->payroll_process_id .'/'. $pp_det->employee_id)); ?>">
							<?php echo e(ucwords($pp_det->employee_name)); ?>

						</a>
					</td>
          			<td><?php echo e(number_format($pp_det->basic_amt, 2, ".", ",")); ?></td>			
          			<td><?php echo e(number_format($pp_det->daily_rate, 2, ".", ",")); ?></td>
          			<td><?php echo e(number_format($pp_det->gross, 2, ".", ",")); ?></td>
          			<td><?php echo e(number_format($pp_det->deduction, 2, ".", ",")); ?></td>
          			<td><?php echo e(number_format($pp_det->net_pay, 2, ".", ",")); ?></td>
          		</tr>
          	<?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div> <!-- end of main content -->

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
  <script type="text/javascript" language="javascript" src="<?php echo e(asset('js/table.js')); ?>"></script>
  <script type="text/javascript" class="init">
  $(document).ready(function() {
    
    $("#btn-del").click(function() {
      $(".chk-profile:checked").each(function() {
        $('#div-del-chk-profile').append('<input type="hidden" name="profiles[]" value="' + $(this).val() + '" />');
      });
    });
    
    <?php if(Session::has('add-failed')): ?>
    UIkit.modal('#add').show();
    <?php elseif(Session::has('put-failed')): ?>
    $(".btn_profile").click();
    <?php endif; ?>

    $(".btn_profile").click(function() {});
    var dataTable = $('#payrollprocessdetails').DataTable({
      order: [],
      columnDefs: [{
        orderable: false,
        targets: [0]
      }]
    });
    $('#select_all').click(function() {
      $(':checkbox', dataTable.rows().nodes()).prop('checked', this.checked);
    });
  });
  </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('shared._public', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>