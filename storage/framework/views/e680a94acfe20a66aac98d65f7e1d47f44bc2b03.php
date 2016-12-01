

<?php $__env->startSection('title', 'Payroll: Tax Exemption'); ?>

<?php $__env->startSection('styles'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<!-- header -->
<div class="header--title_container">
	<div class="uk-container uk-container-center">
		<div class="container-title">
			<h1 class="page-title"><span class="uk-icon uk-icon-file-text"></span> <strong>Tax Exemption </strong></h1>
		</div>
	</div>
</div>

<!-- list payroll setup -->
<div class="uk-container uk-container-center">
	<div class="uk-grid main">
		<div class="uk-width-1-4">
			<ul class="uk-nav uk-nav-side uk-nav-parent-icon" data-uk-nav>
				<li class="uk-active"><a href="<?php echo e(url('payroll/taxexemption')); ?>">Tax Exemption</a></li>
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
				
				<!-- tax exemption -->
				<table id="tax_exemption" class="uk-table uk-table-hover uk-table-striped payroll--table">
					<thead class="payroll--table_header">
						<tr> 
							<th><input type="checkbox" name="select_all" id="select_all" value="1" ></th>
							<th>Tax Code</th>
							<th>Description</th>
							<th>Exemption Amount</th>
						</tr>
					</thead>
					<tbody>
					<?php foreach($tax_codes as $tax_code): ?>
						<tr>
							<td><input type="checkbox" id="select_all" class="chk-tax_exemption" name="tax_exemption[]" value="<?php echo e($tax_code->tax_code_id); ?>"/></td>
							<td><a class="btn-edit" data-uk-modal="{target:'#edit'}"
									data-edit_tax_code_id="<?php echo e($tax_code->tax_code_id); ?>"
									data-edit_tax_code="<?php echo e($tax_code->tax_code); ?>"
									data-edit_description="<?php echo e($tax_code->description); ?>"
								data-edit_exemption_amount="<?php echo e($tax_code->exemption_amount); ?>">
															
							<?php echo e($tax_code->tax_code); ?></a></td>
							<td><?php echo e($tax_code->description); ?></td>
							<td><?php echo e(number_format($tax_code->exemption_amount, 2, ".", ",")); ?></td>
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
    	<div class="uk-modal-header"><span class="uk-icon-plus-circle"></span>Add Tax Exemption</div>
		
		<!-- alerts -->
		<?php if(Session::has('add-failed')): ?>
			<?php if($errors->has()): ?>
				<div class="uk-alert uk-alert-danger ">				
					<?php foreach($errors->all() as $error): ?>
						<p class="uk-text-left"> <span class="uk-icon-close"></span> <?php echo e($error); ?> </p>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		<?php endif; ?>
		<!-- end alerts -->
		
        <form class="uk-form uk-form-horizontal" method="post" action="<?php echo e(url('payroll/taxexemption')); ?>" >
        	<?php echo e(csrf_field()); ?>

		    <fieldset>
		        <div class="uk-form-row">
		        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Tax Code</label>
		        	<div class="uk-form-controls">
		        		<input type="text" class="form-control" name="tax_code" value="<?php echo e(old('tax_code')); ?>">
		        	</div>
		        </div>
		        <div class="uk-form-row">
		        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Description</label>
		        	<div class="uk-form-controls">
		        		<input type="text" class="form-control" name="description" value="<?php echo e(old('description')); ?>">
		        	</div>
		        </div>
		        <div class="uk-form-row">
		        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Exemption Amount</label>
		        	<div class="uk-form-controls">
		        		<input type="text" class="form-control" name="exemption_amount" value="<?php echo e(old('exemption_amount')); ?>">
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
    	<div class="uk-modal-header"><span class="uk-icon-edit"></span>Edit Tax Exemption</div>
		<?php if(Session::has('edit-failed')): ?>
			<?php if($errors->has()): ?>
				<div class="uk-alert uk-alert-danger ">				
					<?php foreach($errors->all() as $error): ?>
						<p class="uk-text-left"> <span class="uk-icon-close"></span> <?php echo e($error); ?> </p>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		<?php endif; ?>
        <form class="uk-form uk-form-horizontal" method="post" action="<?php echo e(url('payroll/taxexemption')); ?>">
        	<?php echo e(csrf_field()); ?>

        	<?php echo e(Form::hidden('_method', 'put')); ?>

			<input type="hidden" name="tax_codes" value="<?php echo e(old('tax_codes')); ?>"/>
		    <fieldset>
		        <div class="uk-form-row">
		        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Tax Code</label>
		        	<div class="uk-form-controls">
		        		<input type="text" class="form-control" name="tax_code" id="edit_tax_code" placeholder="" value="<?php echo e(old('tax_code')); ?>">
		        	</div>
		        </div>
		        <div class="uk-form-row">
		        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Description</label>
		        	<div class="uk-form-controls">
		        		<input type="text" class="form-control" name="description" id="edit_description"placeholder="" value="<?php echo e(old('description')); ?>">
		        	</div>
		        </div>
		        <div class="uk-form-row">
		        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Exemption Amount</label>
		        	<div class="uk-form-controls">
		        		<input type="text" class="form-control" name="exemption_amount" id="edit_exemption_amount" placeholder="" value="<?php echo e(old('exemption_amount')); ?>">
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
<!-- delete location modal -->
<div id="delete" class="uk-modal">
    <div class="uk-modal-dialog">
    	<button class="uk-modal-close uk-close"></button>
    	<div class="uk-modal-header"><span class="uk-icon-trash"></span>Delete Confirmation</div>
    	<div class="uk-margin uk-modal-content">
    		Are you sure you want to delete the selected records?
    	</div>
    	<form method="post" action="<?php echo e(url('payroll/taxexemption')); ?>" >
    		<?php echo e(csrf_field()); ?>

    		<?php echo e(Form::hidden('_method', 'put')); ?>

    		<?php echo e(Form::hidden('isDelete', '1')); ?>

	    	<div id="div-del-chk-tax_exempt">
	    	</div>
		    <div class="uk-modal-footer uk-text-right form-buttons">
		    	<button id="btn-del" type="submit" class="uk-button btn-delete js-modal-confirm"><span class="uk-icon uk-icon-trash"></span> Delete</button>
		        <button type="button" class="uk-button uk-modal-close btn-cancel js-modal-cancel"><span class="uk-icon uk-icon-times-circle"></span> Cancel</button>
		    </div>
		</form>	    
    </div>
</div> 
<!-- delete location modal -->


<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<script type="text/javascript" language="javascript" src="<?php echo e(asset('js/table.js')); ?>"></script>
<script type="text/javascript" class="init">
	$(document).ready(
		function() {
			
			$("#btn-del").click(function(){
				$(".chk-tax_exemption:checked").each(function(){
					$('#div-del-chk-tax_exempt').append('<input type="hidden" name="tax_exemption[]" value="'+ $(this).val() +'" />');
				});
			});
			
			<?php if(Session::has('add-failed')): ?>
				UIkit.modal('#add').show();
			<?php elseif(Session::has('edit-failed')): ?>
				$(".btn-edit").click();
			<?php endif; ?>
			
			$(".btn-edit").click(function(){
				
				$("input[name|=tax_codes]").val( $(this).attr('data-edit_tax_code_id') );
				$("#edit_tax_code").val( $(this).attr('data-edit_tax_code') );
				$("#edit_exemption_amount").val( $(this).attr('data-edit_exemption_amount') );
				$("#edit_description").val( $(this).attr('data-edit_description') );
				
				});
				
				var dataTable = $('#tax_exemption').DataTable({
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