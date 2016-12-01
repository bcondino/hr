

<?php $__env->startSection('title', 'Payroll: Tax Table'); ?>

<?php $__env->startSection('styles'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<!-- header -->
<div class="header--title_container">
	<div class="uk-container uk-container-center">
		<div class="container-title">
			<h1 class="page-title"><span class="uk-icon uk-icon-file-text"></span> <strong>Tax Table </strong></h1>
		</div>
	</div>
</div>

<!-- list payroll setup -->
<div class="uk-container uk-container-center">
	<div class="uk-grid main">
		<div class="uk-width-1-4">
			<ul class="uk-nav uk-nav-side uk-nav-parent-icon" data-uk-nav>
				<li><a href="<?php echo e(url('payroll/taxexemption')); ?>">Tax Exemption</a></li>
				<li class="uk-active"><a href="<?php echo e(url('payroll/taxtable')); ?>">Tax Table</a></li>
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

				<!-- tax table -->
				<table id="tax_table" class="uk-table uk-table-hover uk-table-striped payroll--table">
				    <thead class="payroll--table_header">
				        <tr>
				            <th><input type="checkbox" name="select_all" id="select_all" value="1" ></th>
							<th>Tax ID</th>
				            <th>Tax Mode</th>
				            <th>Tax Code</th>
				            <th>Range From <br/ > (over or equal)</th>
				            <th>Range To <br/ > (less than)</th>
				            <th>Percentage</th>
				            <th>Fix Amount</th>
				        </tr>
				    </thead>
				    <tbody>
				    	<?php foreach($taxs as $tax): ?>
					        <tr>
					            <td><input type="checkbox" id="select_all" class="chk-tax_table" name="tax_table[]" value="<?php echo e($tax->tax_id); ?>"/></td>
								<td><a class="btn-edit"   data-uk-modal="{target:'#edit'}"
								data-edit_tax_id="<?php echo e($tax->tax_id); ?>"
								data-edit_tax_mode="<?php echo e($tax->tax_mode); ?>"
								data-edit_tax_code="<?php echo e($tax->tax_code); ?>"
								data-edit_range_from="<?php echo e($tax->range_from); ?>"
								data-edit_range_to="<?php echo e($tax->range_to); ?>"
								data-edit_percentage="<?php echo e($tax->percentage); ?>"
								data-edit_fix_amount="<?php echo e($tax->fix_amount); ?>"
								><?php echo e($tax->tax_id); ?></td>
					            <td><?php echo e(\App\tbl_tax_mode_model::where('tax_mode', $tax->tax_mode)->first()->description); ?></td>
					            <td><?php echo e(\App\tbl_tax_code_model::where('tax_code', $tax->tax_code)->first()->description); ?></td>
					            <td><?php echo e(number_format($tax->range_from, 2, ".", ",")); ?></td>
					            <td><?php echo e(number_format($tax->range_to, 2, ".", ",")); ?></td>
					            <td><?php echo e($tax->percentage * 100); ?>%</td>
					            <td><?php echo e(number_format($tax->fix_amount, 2, ".", ",")); ?></a></td>
					        </tr>
					    <?php endforeach; ?>
					</tbody>
				</table> <!-- tax table -->
			</article>
		</div>		
	</div> <!-- grid -->
</div> <!-- container -->

<!-- start: modal for add button -->
<div id="add" class="uk-modal">
    <div class="uk-modal-dialog">
    	<button class="uk-modal-close uk-close"></button>
    	<div class="uk-modal-header"><span class="uk-icon-plus-circle"></span>Add Tax Table</div>
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
        <form class="uk-form uk-form-horizontal" method="post" action="<?php echo e(url('payroll/taxtable')); ?>">
        	<?php echo e(csrf_field()); ?>

		    <fieldset>
		    	<div class="uk-form-row">
		        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Tax Mode</label>
		        	<div class="uk-form-controls">
						<?php echo e(Form::select('tax_mode'
							, [null => '-- Select --'] + 
								\App\tbl_tax_mode_model::
									orderBy('description')
									->lists('description', 'tax_mode')
									->toArray()
							, old('tax_mode')
							, array('class'=>'form-control'))); ?>

		        	</div>
		        </div>
		        <div class="uk-form-row">
		        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Tax Code</label>
		        	<div class="uk-form-controls">
						<?php echo e(Form::select('tax_code'
							, [null => '-- Select --'] + 
								\App\tbl_tax_code_model::
									orderBy('description')
								    ->lists('description', 'tax_code')
								    ->toArray()
							, old('tax_code')
							, array('class'=>'form-control'))); ?>

		        	</div>
		        </div>
		        <div class="uk-form-row">
		        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Range From</label>
		        	<div class="uk-form-controls">
		        		<input type="text" class="form-control" name="range_from" value="<?php echo e(old('range_from')); ?>">
		        	</div>
		        </div>
		        <div class="uk-form-row">
		        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Range To</label>
		        	<div class="uk-form-controls">
		        		<input type="text" class="form-control" name="range_to" value="<?php echo e(old('range_to')); ?>">
		        	</div>
		        </div>
		        <div class="uk-form-row">
		        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Percentage</label>
		        	<div class="uk-form-controls">
		        		<input type="text" class="form-control" name="percentage" value="<?php echo e(old('percentage')); ?>">
		        		<caption>Please enter with decimal (i.e. 0.01)</caption>
		        	</div>
		        </div>
		        <div class="uk-form-row">
		        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Fix Amount</label>
		        	<div class="uk-form-controls">
		        		<input type="text" class="form-control" name="fix_amount" value="<?php echo e(old('fix_amount')); ?>">
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
    	<div class="uk-modal-header"><span class="uk-icon-edit"></span>Edit Tax Table </div>
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
        <form class="uk-form uk-form-horizontal" method="post" action="<?php echo e(url('payroll/taxtable')); ?>">
        	<?php echo e(csrf_field()); ?>

        	<?php echo e(Form::hidden('_method', 'put')); ?>

			<input type="hidden" name="edit_tax" value="<?php echo e(old('edit_tax')); ?>" />
			    <fieldset>
			        <div class="uk-form-row">
			        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Tax Mode</label>
			        	<div class="uk-form-controls">
			        		<?php echo e(Form::select('tax_mode'
			        			, \App\tbl_tax_mode_model::
		        					orderBy('description')
		        				    ->lists('description', 'tax_mode')
		        				    ->toArray()
			        			, old('tax_mode')
			        			, array('class'=>'form-control', 'id' => 'edit_tax_mode'))); ?>

			        	</div>
			        </div>
			        <div class="uk-form-row">
			        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Tax Code</label>
			        	<div class="uk-form-controls">
			        		<?php echo e(Form::select('tax_code'
			        			, \App\tbl_tax_code_model::
			        				orderBy('description')
			        			    ->lists('description', 'tax_code')
			        			    ->toArray()
			        			, old('tax_code')
			        			, array('class'=>'form-control' , 'id' => 'edit_tax_code'))); ?>

			        	</div>
			        </div>
			        <div class="uk-form-row">
			        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Range From</label>
			        	<div class="uk-form-controls">
			        		<input type="text" class="form-control" name="range_from" id="edit_range_from" value="<?php echo e(old('range_from')); ?>">
			        	</div>
			        </div>
			        <div class="uk-form-row">
			        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Range To</label>
			        	<div class="uk-form-controls">
			        		<input type="text" class="form-control" name="range_to" id="edit_range_to" value="<?php echo e(old('range_to')); ?>">
			        	</div>
			        </div>
			        <div class="uk-form-row">
			        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Percentage</label>
			        	<div class="uk-form-controls">
			        		<input type="text" class="form-control" name="percentage" id="edit_percentage" value="<?php echo e(old('percentage')); ?>">
			        		<caption>Please enter with decimal (i.e. 0.01)</caption>
			        	</div>
			        </div>
			        <div class="uk-form-row">
			        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Fix Amount</label>
			        	<div class="uk-form-controls">
			        		<input type="text" class="form-control" name="fix_amount"  id="edit_fix_amount" value="<?php echo e(old('fix_amount')); ?>">
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
    	<form method="post" action="<?php echo e(url('payroll/taxtable')); ?>">
    		<?php echo e(csrf_field()); ?>

    		<?php echo e(Form::hidden('_method', 'put')); ?>

    		<?php echo e(Form::hidden('isDelete', '1')); ?>

	    	<div id="div-del-chk-tax_table">
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
				$(".chk-tax_table:checked").each(function(){
					$('#div-del-chk-tax_table').append('<input type="hidden" name="tax_table[]" value="'+ $(this).val() +'" />');
				});
			});
			
			<?php if(Session::has('add-failed')): ?>
				UIkit.modal('#add').show();
			<?php elseif(Session::has('edit-failed')): ?>
				$(".btn-edit").click();
			<?php endif; ?>
			
			$(".btn-edit").click(function(){
				//var my_id = $(this).attr('data-edit_tax_id') ;
				$("input[name|=edit_tax]").val( $(this).attr('data-edit_tax_id') );
				$("#edit_tax_code").val( $(this).attr('data-edit_tax_code') );
				$("#edit_tax_mode").val( $(this).attr('data-edit_tax_mode') );
							
				$("#edit_range_from").val( $(this).attr('data-edit_range_from') );
				$("#edit_range_to").val( $(this).attr('data-edit_range_to') );
				$("#edit_percentage").val( $(this).attr('data-edit_percentage') );
				$("#edit_fix_amount").val( $(this).attr('data-edit_fix_amount') );
			//alert(my_id);
			});
			var dataTable = $('#tax_table').DataTable({
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