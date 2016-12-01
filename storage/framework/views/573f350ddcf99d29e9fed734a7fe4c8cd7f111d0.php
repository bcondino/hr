

<?php $__env->startSection('title', 'Payroll: Payroll Group'); ?>

<?php $__env->startSection('styles'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<!-- header -->
<div class="header--title_container">
	<div class="uk-container uk-container-center">
		<div class="container-title">
			<h1 class="page-title"><span class="uk-icon uk-icon-file-text"></span> <strong>Payroll Group</strong> </a></h1>
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
				<li><a href="<?php echo e(url('payroll/payrollperiod')); ?>">Payroll Period</a></li>
				<li class="uk-active"><a href="<?php echo e(url('payroll/payrollgroup')); ?>">Payroll Group</a></li>
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
				<!-- payroll group -->
				<table id="payrollgroup" class="uk-table uk-table-hover uk-table-striped payroll--table">
					<thead class="payroll--table_header">
						<tr> 
							<th><input type="checkbox" name="select_all" id="select_all" value="1" ></th>
							<th>Group Name</th>
							<th>Payroll Mode</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($payroll_groups as $payroll_group): ?>
							<tr>
								<td><input type="checkbox" id="select_all" class="chk-payroll_group" name="payroll_group[]" value="<?php echo e($payroll_group->payroll_group_id); ?>"/></td>
								<td><a class="btn-edit" data-uk-modal="{target:'#edit'}"
									data-edit_payroll_group_id="<?php echo e($payroll_group->payroll_group_id); ?>"
									data-edit_payroll_mode="<?php echo e($payroll_group->payroll_mode); ?>"
									data-edit_description="<?php echo e($payroll_group->description); ?>">
								<?php echo e($payroll_group->description); ?></a></td>
								<td><?php echo e(\App\tbl_payroll_mode_model::where('payroll_mode', $payroll_group->payroll_mode)->first()->description); ?></td>
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
        <form class="uk-form uk-form-horizontal" method="post" action="<?php echo e(url('payroll/payrollgroup')); ?>">
        	<?php echo e(csrf_field()); ?>

			    <fieldset>
			        <div class="uk-form-row">
						<label class="uk-form-label"><span class="uk-text-danger">*</span> Group Name</label>
						<div class="uk-form-controls">
							<input type="text" class="form-control" name="description" placeholder="" value="<?php echo e(old('description')); ?>">
			        	</div>
			        </div>
			        <div class="uk-form-row">
			        	<label class="uk-form-label"> <span class="uk-text-danger">*</span> Payroll Mode</label>
			        	<div class="uk-form-controls">
			        		<?php echo e(Form::select('payroll_mode'
			        		, [null => '-- Select --'] + 
			        			$payroll_modes
			        			->lists('description', 'payroll_mode')
			        			->toArray()
			        		, old('payroll_mode')
			        		, array('class'=>'form-control'))); ?>

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
         <form class="uk-form uk-form-horizontal" method="post" action="<?php echo e(url('payroll/payrollgroup')); ?>">
         	<?php echo e(csrf_field()); ?>

         	<?php echo e(Form::hidden('_method', 'put')); ?>

					<input type="hidden" name="payroll_groups" value="<?php echo e(old('payroll_groups')); ?>" />
			    <fieldset>
			        <div class="uk-form-row">
						<label class="uk-form-label"><span class="uk-text-danger">*</span> Group Name</label>
						<div class="uk-form-controls">
							<input type="text" class="form-control" name="description" id="edit_description" placeholder="" value="<?php echo e(old('description')); ?>">
			        	</div>
			        </div>
			        <div class="uk-form-row">
			        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Payroll Mode</label>
			        	<div class="uk-form-controls">
			        		<?php echo e(Form::select('payroll_mode'
			        		, $payroll_modes
			        			->lists('description', 'payroll_mode')
			        			->toArray()
			        		, old('payroll_mode')
			        		, array('class'=>'form-control','id'=>'edit_payroll_mode'))); ?>

						</div>
					</div>
		       
		    </fieldset>
		    <div class="uk-modal-footer uk-text-right form-buttons">
		    	<button class="uk-button btn-save" type="submit"><span class="uk-icon uk-icon-edit"></span> Save</button>
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
    	<form method="post" action="<?php echo e(url('payroll/payrollgroup')); ?>" >
    		<?php echo e(csrf_field()); ?>

    		<?php echo e(Form::hidden('_method', 'put')); ?>

    		<?php echo e(Form::hidden('isDelete', '1')); ?>

	    	<div id="div-del-chk-payroll_group">
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
					$(".chk-payroll_group:checked").each(function(){
					$('#div-del-chk-payroll_group').append('<input type="hidden" name="payroll_group_tbl[]" value="'+ $(this).val() +'" />');
					});
				});
			
			<?php if(Session::has('add-failed')): ?>
				UIkit.modal('#add').show();
				<?php elseif(Session::has('edit-failed')): ?>
				$(".btn-edit").click();
				<?php endif; ?>
				
			$(".btn-edit").click(function(){
				
				$("input[name|=payroll_groups]").val( $(this).attr('data-edit_payroll_group_id') );
				$("#edit_payroll_mode").val( $(this).attr('data-edit_payroll_mode') );
				
				$("#edit_description").val( $(this).attr('data-edit_description') );
				
				
				});
			var dataTable = $('#payrollgroup').DataTable({
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