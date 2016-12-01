

<?php $__env->startSection('title', 'Payroll: Period'); ?>

<?php $__env->startSection('styles'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<!-- header -->
<div class="header--title_container">
	<div class="uk-container uk-container-center">
		<div class="container-title">
			<h1 class="page-title"><span class="uk-icon uk-icon-file-text"></span> <strong>Payroll Period</strong> </a></h1>
		</div>
	</div>
</div>

<!-- list payroll setup -->
<div class="uk-container uk-container-center">
	<div class="uk-grid main">
		<div class="uk-width-1-4">
			<ul class="uk-nav uk-nav-side uk-nav-parent-icon" data-uk-nav>
				<li><a href="<?php echo e(url('payroll/taxexemption')); ?>">Tax Exemption</a></li>
				<li><a href="<?php echo e(url('payroll/taxtable')); ?>">Tax Table</a></li>
				<li><a href="<?php echo e(url('payroll/annualtaxtable')); ?>">Annual Tax Table</a></li>
				<li><a href="<?php echo e(url('payroll/ssstable')); ?>">SSS Table</a></li>
				<li><a href="<?php echo e(url('payroll/pagibigtable')); ?>">Pagibig Table</a></li>
				<li><a href="<?php echo e(url('payroll/philhealthtable')); ?>">Philhealth Table</a></li>
				<li><a href="<?php echo e(url('payroll/paymentdisbursement')); ?>">Payment Disbursement</a></li>
				<li class="uk-parent"><a href="#">Payroll Details</a>
					<ul class="uk-nav-sub">
						<li><a href="<?php echo e(url('payroll/earnings')); ?>">Earnings</a></li>
						<li><a href="<?php echo e(url('payroll/deductions')); ?>">Deductions</a></li>
					</ul>
				</li>
				<li><a href="<?php echo e(url('payroll/payrollmode')); ?>">Payroll Mode</a></li>
				<li class="uk-active"><a href="<?php echo e(url('payroll/payrollperiod')); ?>">Payroll Period</a></li>
				<li><a href="<?php echo e(url('payroll/payrollgroup')); ?>">Payroll Group</a></li>
				<li><a href="<?php echo e(url('payroll/payrolltemplate')); ?>">Payroll Template Parameter</a></li>
				<li><a href="<?php echo e(url('payroll/payrollsignatory')); ?>">Payroll Signatory</a></li>
				<li><a href="<?php echo e(url('payroll/overtimeparamenter')); ?>">Overtime Parameter</a></li>
				<li><a href="<?php echo e(url('payroll/wageorder')); ?>">Wage Order</a></li>
			</ul>
		</div> <!-- payroll parameter list -->
		<div class="uk-width-3-4" >
			<article class="uk-article">

				<!-- buttons -->
				<div class="button-container">
					<!-- alerts -->
					<?php foreach(['add','edit','del'] as $msg): ?>
						<?php if(Session::has($msg.'-success')): ?>
							<div class="uk-alert uk-alert-success">
								<span class="uk-icon uk-icon-check"></span> <?php echo e(Session::get($msg.'-success')); ?>

							</div>
						<?php elseif(Session::has($msg.'-warning')): ?>
							<div class="uk-alert uk-alert-warning">
							<span class="uk-icon uk-icon-warning"></span> <?php echo e(Session::get($msg.'-warning')); ?>

							</div>
						<?php endif; ?>
					<?php endforeach; ?>	
					<button type="button" class="uk-button btn-add" data-uk-modal="{target:'#add'}"><span class="uk-icon uk-icon-plus-circle"></span> Add</button>
					<button type="button" class="uk-button" data-uk-modal="{target:'#delete'}"><span class="uk-icon uk-icon-trash"></span>  Delete</button>
				</div>	
				<!-- end buttons -->
				
				<!-- payroll period -->
				<table id="payroll_period" class="uk-table uk-table-hover uk-table-striped payroll--table">
					<thead class="payroll--table_header">
						<tr> 
				            <th><input type="checkbox" name="select_all" id="select_all" value="1" ></th>
				            <th>Year</th>
				            <th>Payroll Mode</th>
							<!-- 20161007 updated by Melvin Militante -->
							<th>Date From</th>
							<th>Date To</th>
							<!-- 20161007 end of update -->
				            <th>Days</th>
				            <th>Hours/Day</th>
				            <th>Hours/Payday</th>
				            <th>Days/Mon</th>
				            <th>Days/Year</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($payroll_periods as $payroll_period): ?>
							<tr>
						         <td><input type="checkbox" id="select_all" class="chk-payroll_period" name="payroll_period[]" value="<?php echo e($payroll_period->payroll_period_id); ?>"/></td>
						        <td><a class="btn-edit" data-uk-modal="{target:'#edit'}"
									data-edit_payroll_period_id="<?php echo e($payroll_period->payroll_period_id); ?>"
									data-edit_year="<?php echo e($payroll_period->year); ?>"
									data-edit_work_days="<?php echo e($payroll_period->work_days); ?>"
									data-edit_hrs_day="<?php echo e($payroll_period->hrs_day); ?>"
									data-edit_hrs_pay="<?php echo e($payroll_period->hrs_pay); ?>"
									data-edit_days_mo="<?php echo e($payroll_period->days_mo); ?>"
									data-edit_days_yr="<?php echo e($payroll_period->days_yr); ?>"
									data-edit_payroll_mode="<?php echo e($payroll_period->payroll_mode); ?>"
									>
								
								<?php echo e($payroll_period->year); ?></a></td>
						        <td><?php echo e(\App\tbl_payroll_mode_model::where('payroll_mode', $payroll_period->payroll_mode)->first()->description); ?></td>
								<!-- 20161007 updated by Melvin Militante -->
								<td><?php echo e($payroll_period->date_from); ?></td>
								<td><?php echo e($payroll_period->date_to); ?></td>
								<!-- 20161007 end of update -->
						        <td><?php echo e($payroll_period->work_days); ?></td>
								<td><?php echo e($payroll_period->hrs_day); ?></td>
						        <td><?php echo e($payroll_period->hrs_pay); ?></td>
						        <td><?php echo e($payroll_period->days_mo); ?></td>
						        <td><?php echo e($payroll_period->days_yr); ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table> <!-- tax exemption -->
			</article>
		</div>		
	</div> <!-- grid -->
</div> <!-- container -->
<!-- start: modal for add button -->
<div id="add" class="uk-modal">
    <div class="uk-modal-dialog">
    	<button class="uk-modal-close uk-close"></button>
    	<div class="uk-modal-header"><span class="uk-icon-plus-circle"></span>Add Payroll Period</div>
		<!-- alerts -->
			<?php if(Session::has('add-failed')): ?>
			<?php if($errors->has()): ?>
				<div class="uk-alert uk-alert-danger ">				
					<?php foreach($errors->all() as $error): ?>
						<p class="uk-text-left"> <span class="uk-icon-close"></span> <?php echo e($error); ?> </p>
					<?php endforeach; ?>
					<!-- end alerts -->
				</div>
			<?php endif; ?>
			<?php endif; ?>
			<!-- end alerts -->
        <form class="uk-form uk-form-horizontal" method="post" action="<?php echo e(url('payroll/payrollperiod')); ?>">
        	<?php echo e(csrf_field()); ?>

		    <fieldset>
		        <div class="uk-form-row">
		        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Year</label>
		        	<div class="uk-form-controls">
		        		<input type="text" class="form-control" name="year" placeholder="" value="<?php echo e(old('year')); ?>">
		        	</div>
		        </div>
		        <div class="uk-form-row">
		        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Payroll Mode</label>
		        	<div class="uk-form-controls">
		        		<?php echo e(Form::select('payroll_mode',  
							[null => '-- Select --'] + \App\tbl_payroll_mode_model::first()->lists('description', 'payroll_mode') -> toArray() ,old('payroll_mode'), 
							array('class'=>'form-control'))); ?>

		        	</div>
		        </div>
		        <hr />
		    </fieldset>

		    <fieldset>
		        <div class="uk-form-row">
			    	<strong>Total Number of:</strong>
			    </div>
		        <div class="uk-form-row">
		        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Working Days</label>
		        	<div class="uk-form-controls">
		        		<input type="text" class="form-control" name="work_days" value="<?php echo e(old('work_days')); ?>">
		        	</div>
		        </div>
		        <div class="uk-form-row">
		        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Working Hours/Day</label>
		        	<div class="uk-form-controls">
		        		<input type="text" class="form-control" name="hrs_day" value="<?php echo e(old('hrs_day')); ?>">
		        	</div>
		        </div>
		        <div class="uk-form-row">
		        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Working Hours/Payday</label>
		        	<div class="uk-form-controls">
		        		<input type="text" class="form-control" name="hrs_pay" value="<?php echo e(old('hrs_pay')); ?>">
		        	</div>
		        </div>
		        <div class="uk-form-row">
		        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Working Days/Month</label>
		        	<div class="uk-form-controls">
		        		<input type="text" class="form-control" name="days_mo" value="<?php echo e(old('days_mo')); ?>">
		        	</div>
		        </div>
		        <div class="uk-form-row">
		        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Working Days/Year</label>
		        	<div class="uk-form-controls">
		        		<input type="text" class="form-control" name="days_yr" value="<?php echo e(old('days_yr')); ?>">
		        	</div>
		        </div>
		    </fieldset>
		    <div class="uk-modal-footer uk-text-right form-buttons">
		    	<button class="uk-button btn-save" type="submit"><span class="uk-icon uk-icon-edit"></span> Save</button>
		        <button class="uk-button uk-modal-close btn-cancel"><span class="uk-icon uk-icon-times-circle"></span> Cancel</button>
		    </div>
		</form>
    </div>
</div> <!-- end: modal for add button -->

<!-- start: modal for edit button -->
<div id="edit" class="uk-modal">
    <div class="uk-modal-dialog">
    	<button class="uk-modal-close uk-close"></button>
    	<div class="uk-modal-header"><span class="uk-icon-edit"></span>Edit Payroll Period</div>
		<!-- alerts -->
			<?php if(Session::has('edit-failed')): ?>
			<?php if($errors->has()): ?>
				<div class="uk-alert uk-alert-danger ">				
					<?php foreach($errors->all() as $error): ?>
						<p class="uk-text-left"> <span class="uk-icon-close"></span> <?php echo e($error); ?> </p>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
			<?php endif; ?>
		<!-- end alerts -->
       <form class="uk-form uk-form-horizontal" method="post" action="<?php echo e(url('payroll/payrollperiod')); ?>" >
       		<?php echo e(csrf_field()); ?>

       		<?php echo e(Form::hidden('_method', 'put')); ?>

			<input type="hidden" name="payroll_periods" value="<?php echo e(old('payroll_periods')); ?>" />
		     <fieldset>
		        <div class="uk-form-row">
		        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Year</label>
		        	<div class="uk-form-controls">
		        		<input type="text" class="form-control" name="year" id="edit_year"placeholder="" value="<?php echo e(old('year')); ?>">
		        	</div>
		        </div>
		        <div class="uk-form-row">
		        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Payroll Mode</label>
		        	<div class="uk-form-controls">
		        		<?php echo e(Form::select('payroll_mode',  
							[null => '-- Select --'] + \App\tbl_payroll_mode_model::first()->lists('description', 'payroll_mode') -> toArray() ,old('payroll_mode'), 
							array('class'=>'form-control','id'=>'edit_payroll_mode'))); ?>

		        	</div>
		        </div>
		        <hr />
		    </fieldset>

		    <fieldset>
		        <div class="uk-form-row">
		    		<strong>Total Number of:</strong>
		    	</div>
		        <div class="uk-form-row">
		        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Working Days</label>
		        	<div class="uk-form-controls">
		        		<input type="text" class="form-control" name="work_days" id="edit_work_days" placeholder="" value="<?php echo e(old('work_days')); ?>">
		        	</div>
		        </div>
		        <div class="uk-form-row">
		        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Working Hours/Day</label>
		        	<div class="uk-form-controls">
		        		<input type="text" class="form-control" name="hrs_day" id="edit_hrs_day" placeholder="" value="<?php echo e(old('hrs_day')); ?>">
		        	</div>
		        </div>
		        <div class="uk-form-row">
		        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Working Hours/Payday</label>
		        	<div class="uk-form-controls">
		        		<input type="text" class="form-control" name="hrs_pay" id="edit_hrs_pay" placeholder="" value="<?php echo e(old('hrs_pay')); ?>">
		        	</div>
		        </div>
		        <div class="uk-form-row">
		        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Working Days/Month</label>
		        	<div class="uk-form-controls">
		        		<input type="text" class="form-control" name="days_mo" id="edit_days_mo" placeholder="" value="<?php echo e(old('days_mo')); ?>">
		        	</div>
		        </div>
		        <div class="uk-form-row">
		        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Working Days/Year</label>
		        	<div class="uk-form-controls">
		        		<input type="text" class="form-control" name="days_yr" id="edit_days_yr" placeholder="" value="<?php echo e(old('days_yr')); ?>">
		        	</div>
		        </div>
		    </fieldset>
		    <div class="uk-modal-footer uk-text-right form-buttons">
		    	<button class="uk-button btn-save" type="submit"><span class="uk-icon uk-icon-edit"></span> Save </button>
		        <button class="uk-button uk-modal-close btn-cancel"><span class="uk-icon uk-icon-times-circle"></span> Cancel</button>
		    </div>
		</form>
    </div>
</div> <!-- end: modal for edit button -->
<!-- delete modal -->
<div id="delete" class="uk-modal">
    <div class="uk-modal-dialog">
    	<button class="uk-modal-close uk-close"></button>
    	<div class="uk-modal-header"><span class="uk-icon-trash"></span>Delete Confirmation</div>
    	<div class="uk-margin uk-modal-content">
    		Are you sure you want to delete the selected records?
    	</div>
    	<form method="post" action="<?php echo e(url('payroll/payrollperiod')); ?>" >
    		<?php echo e(csrf_field()); ?>

    		<?php echo e(Form::hidden('_method', 'put')); ?>

    		<?php echo e(Form::hidden('isDelete', '1')); ?>

	    	<div id="div-del-chk-payroll_period">
	    	</div>
		    <div class="uk-modal-footer uk-text-right form-buttons">
		    	<button id="btn-del" type="submit" class="uk-button btn-delete js-modal-confirm"><span class="uk-icon uk-icon-trash"></span> Delete</button>
		        <button type="button" class="uk-button uk-modal-close btn-cancel js-modal-cancel"><span class="uk-icon uk-icon-times-circle"></span> Cancel</button>
		    </div>
		</form>	    
    </div>
</div> 
<!-- delete  modal -->


<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<script type="text/javascript" language="javascript" src="<?php echo e(asset('js/table.js')); ?>"></script>
<script type="text/javascript" class="init">
	$(document).ready(
		function() {
			
				$("#btn-del").click(function(){
					$(".chk-payroll_period:checked").each(function(){
					$('#div-del-chk-payroll_period').append('<input type="hidden" name="payroll_period_tbl[]" value="'+ $(this).val() +'" />');
					});
				});
			
			<?php if(Session::has('add-failed')): ?>
				UIkit.modal('#add').show();
				<?php elseif(Session::has('edit-failed')): ?>
				$(".btn-edit").click();
				<?php endif; ?>
				
			$(".btn-edit").click(function(){
				
				$("input[name|=payroll_periods]").val( $(this).attr('data-edit_payroll_period_id') );
				$("#edit_year").val( $(this).attr('data-edit_year') );
				$("#edit_work_days").val( $(this).attr('data-edit_work_days') );
				$("#edit_hrs_day").val( $(this).attr('data-edit_hrs_day') );
				$("#edit_hrs_pay").val( $(this).attr('data-edit_hrs_pay') );
				$("#edit_days_mo").val( $(this).attr('data-edit_days_mo') );
				$("#edit_days_yr").val( $(this).attr('data-edit_days_yr') );
				$("#edit_payroll_mode").val( $(this).attr('data-edit_payroll_mode') );
				});
			
			var dataTable = $('#payroll_period').DataTable({
					order: [],
					columnDefs: [ { orderable: false, targets: [0] } ]
				});	
			
				$('#select_all').click(function () {
					$(':checkbox', dataTable.rows().nodes()).prop('checked', this.checked);
				});
		}
	);
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('shared._public', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>