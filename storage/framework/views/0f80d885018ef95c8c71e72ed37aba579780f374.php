

<?php $__env->startSection('title', 'Payroll: Disbursement'); ?>

<?php $__env->startSection('styles'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<!-- header -->
<div class="header--title_container">
	<div class="uk-container uk-container-center">
		<div class="container-title">
			<h1 class="page-title"><span class="uk-icon uk-icon-file-text"></span> <strong>Payment Disbursement </strong></a></h1>
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
				<li class="uk-active"><a href="<?php echo e(url('payroll/paymentdisbursement')); ?>">Payment Disbursement</a></li>
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
				
				<!-- payroll disbursement -->
				<table id="disbursements" class="uk-table uk-table-hover uk-table-striped payroll--table">
					<thead class="payroll--table_header">
						<tr> 
						 	<th><input type="checkbox" name="select_all" id="select_all" value="1" ></th>
				            <th>Disbursement Code</th>
				            <th>Bank Name</th>
				            <th>Account Number</th>
							<th>Branch Code</th>
							<th>File Name</th>
							<th>File Type</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($payroll_disbursements as $payroll_disbursement): ?>
							<tr>
									<td><label><input type="checkbox" id="select_all" class="chk-payDisbursement" name="payDisbursement_tbl[]" value="<?php echo e($payroll_disbursement->pay_disb_id); ?>"></label></td>
						        <td><a class="btn-edit" data-uk-modal="{target:'#edit'}"  
									data-edit_pay_disb_id="<?php echo e($payroll_disbursement->pay_disb_id); ?>"
									data-edit_payroll_disb_code="<?php echo e($payroll_disbursement->payroll_disb_code); ?>"
									data-edit_bank_name="<?php echo e($payroll_disbursement->bank_name); ?>"
									data-edit_account_number="<?php echo e($payroll_disbursement->account_number); ?>"
									data-edit_company_code="<?php echo e($payroll_disbursement->company_code); ?>"
									data-edit_branch_code="<?php echo e($payroll_disbursement->branch_code); ?>"
									data-edit_default_file_name="<?php echo e($payroll_disbursement->default_file_name); ?>"
									data-edit_file_type="<?php echo e($payroll_disbursement->file_type); ?>"
									data-edit_data_type_dictionary="<?php echo e($payroll_disbursement->data_type_dictionary); ?>"
									data-edit_header_template="<?php echo e($payroll_disbursement->header_template); ?>"
									data-edit_detail_template="<?php echo e($payroll_disbursement->detail_template); ?>"
									data-edit_footer_template="<?php echo e($payroll_disbursement->footer_template); ?>"
									><?php echo e($payroll_disbursement->payroll_disb_code); ?></a></td>
								
								<td><?php echo e($payroll_disbursement->bank_name); ?></td>
								<td><?php echo e($payroll_disbursement->account_number); ?></td>
								<td><?php echo e($payroll_disbursement->branch_code); ?></td>
								<td><?php echo e($payroll_disbursement->default_file_name); ?></td>
								<td><?php echo e($payroll_disbursement->file_type); ?></td>
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
    <div class="uk-modal-dialog modal-wide">
    	<button class="uk-modal-close uk-close"></button>
    	<div class="uk-modal-header"><span class="uk-icon-plus-circle"></span>Add Bank Disbursement</div>
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
		<form class="uk-form uk-form-horizontal" method="post" action="<?php echo e(url('payroll/paymentdisbursement')); ?>">
			<?php echo e(csrf_field()); ?>

        	<div class="uk-grid">
				<div class="uk-width-1-2">
				    <fieldset class="uk-form-horizontal">
				        <div class="uk-form-row">
				        	<label class="uk-form-label">&nbsp;&nbsp; Payroll Disbursement Code</label>
				        	<div class="uk-form-controls">
				        		<input type="text" class="form-control" name = "payroll_disb_code" placeholder="" value="<?php echo e(old('payroll_disb_code')); ?>">
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Disbursement / Bank Name</label>
				        	<div class="uk-form-controls">
				        		<input type="text" class="form-control" name="bank_name" placeholder="" value="<?php echo e(old('bank_name')); ?>">
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Account Number</label>
				        	<div class="uk-form-controls">
				        		<input type="text" class="form-control" name="account_number" placeholder="" value="<?php echo e(old('account_number')); ?>">
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">&nbsp;&nbsp; Company Code</label>
				        	<div class="uk-form-controls">
				        		<input type="text" class="form-control" name="company_code" placeholder="" value="<?php echo e(old('company_code')); ?>">
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Branch Code</label>
				        	<div class="uk-form-controls">
				        		<input type="text" class="form-control" name="branch_code" placeholder="" value="<?php echo e(old('branch_code')); ?>">
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">&nbsp;&nbsp; Default File Name</label>
				        	<div class="uk-form-controls">
				        		<input type="text" class="form-control" name="default_file_name" placeholder="" value="<?php echo e(old('default_file_name')); ?>">
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">&nbsp;&nbsp; File Type</label>
				        	<div class="uk-form-controls">
				        		<?php echo e(Form::select('file_type', ['xls' => 'Excel(.xls)', 'csv' => 'Excel(.csv)','pdf' => 'Adobe(.pdf)', 'xml' => 'XML(.xml)'], old('file_type'),  array('class'=>'form-control'))); ?>

				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">&nbsp;&nbsp; Data Type Dictionary</label>
				        	<div class="uk-form-controls">
				        		<textarea class="form-control" name="data_type_dictionary" placeholder="" value="<?php echo e(old('data_type_dictionary')); ?>"></textarea>
				        	</div>
				        </div>
				    </fieldset>
				</div>
				<div class="uk-width-1-2">
					<fieldset class="uk-form-stacked">
						<div class="uk-form-row">
				        	<label class="uk-form-label">Header Template</label>
				        	<div class="uk-form-controls uk-form_header-template">
				        		<textarea class="form-control" name="header_template" value="<?php echo e(old('header_template')); ?>"></textarea>
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Detail Template</label>
				        	<div class="uk-form-controls uk-form_detail-template">
				        		<textarea class="form-control" name="detail_template" value="<?php echo e(old('detail_template')); ?>"></textarea>
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Footer Template</label>
				        	<div class="uk-form-controls uk-form_footer-template">
				        		<textarea class="form-control" name="footer_template" value="<?php echo e(old('footer_template')); ?>"></textarea>
				        	</div>
				        </div>
					</fieldset>
				</div>
			</div>
		    <div class="uk-modal-footer uk-text-right form-buttons">
		    	<button class="uk-button btn-save" type="submit"><span class="uk-icon uk-icon-edit"></span> Save</button>
		        <button class="uk-button uk-modal-close btn-cancel"><span class="uk-icon uk-icon-times-circle"></span> Cancel</button>
		    </div>
		</form>
    </div>
</div> <!-- end: modal for add button -->

<!-- start: modal for edit button -->
<div id="edit" class="uk-modal">
    <div class="uk-modal-dialog modal-wide">
    	<button class="uk-modal-close uk-close"></button>
    	<div class="uk-modal-header"><span class="uk-icon-edit"></span>Edit Bank Disbursement</div>
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
        <form class="uk-form uk-form-horizontal" method="post" action="<?php echo e(url('payroll/paymentdisbursement')); ?>" >
        	<?php echo e(csrf_field()); ?>

        	<?php echo e(Form::hidden('_method', 'put')); ?>

		<input type="hidden" name="payDisbursements" value="<?php echo e(old('payDisbursements')); ?>" />
        	<div class="uk-grid">
				<div class="uk-width-1-2">
				   <fieldset class="uk-form-horizontal">
				        <div class="uk-form-row">
				        	<label class="uk-form-label">&nbsp;&nbsp; Payroll Disbursement Code</label>
				        	<div class="uk-form-controls">
				        		<input type="text" class="form-control" name = "payroll_disb_code" id="edit_payroll_disb_code" placeholder="" value="<?php echo e(old('payroll_disb_code')); ?>">
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Disbursement / Bank Name</label>
				        	<div class="uk-form-controls">
				        		<input type="text" class="form-control" name="bank_name" id="edit_bank_name" placeholder="" value="<?php echo e(old('bank_name')); ?>">
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Account Number</label>
				        	<div class="uk-form-controls">
				        		<input type="text" class="form-control" name="account_number" id="edit_account_number" placeholder="" value="<?php echo e(old('account_number')); ?>">
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">&nbsp;&nbsp; Company Code</label>
				        	<div class="uk-form-controls">
				        		<input type="text" class="form-control" name="company_code" id="edit_company_code" placeholder="" value="<?php echo e(old('company_code')); ?>">
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label"><span class="uk-text-danger">*</span> Branch Code</label>
				        	<div class="uk-form-controls">
				        		<input type="text" class="form-control" name="branch_code" id="edit_branch_code" placeholder="" value="<?php echo e(old('branch_code')); ?>">
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">&nbsp;&nbsp; Default File Name</label>
				        	<div class="uk-form-controls">
				        		<input type="text" class="form-control" name="default_file_name" id="edit_default_file_name" placeholder="" value="<?php echo e(old('default_file_name')); ?>">
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">&nbsp;&nbsp; File Type</label>
				        	<div class="uk-form-controls">
				        		<?php echo e(Form::select('file_type', ['xls' => 'Excel(.xls)', 'csv' => 'Excel(.csv)','pdf' => 'Adobe(.pdf)', 'xml' => 'XML(.xml)'], old('file_type'),  array('class'=>'form-control','id'=>'edit_file_type'))); ?>

				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">&nbsp;&nbsp; Data Type Dictionary</label>
				        	<div class="uk-form-controls">
				        		<textarea class="form-control" name="data_type_dictionary" id="edit_data_type_dictionary" placeholder="" value="<?php echo e(old('data_type_dictionary')); ?>"></textarea>
				        	</div>
				        </div>
				    </fieldset>
				</div>
				<div class="uk-width-1-2">
					<fieldset class="uk-form-stacked">
						<div class="uk-form-row">
				        	<label class="uk-form-label">Header Template</label>
				        	<div class="uk-form-controls uk-form_header-template">
				        		<textarea class="form-control" name="header_template" id="edit_header_template" placeholder="" value="<?php echo e(old('header_template')); ?>"></textarea>
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Detail Template</label>
				        	<div class="uk-form-controls uk-form_detail-template">
				        		<textarea class="form-control" name="detail_template"  id="edit_detail_template" placeholder=""  value="<?php echo e(old('detail_template')); ?>"></textarea>
				        	</div>
				        </div>
				        <div class="uk-form-row">
				        	<label class="uk-form-label">Footer Template</label>
				        	<div class="uk-form-controls uk-form_footer-template">
				        		<textarea class="form-control" name="footer_template" id="edit_footer_template" placeholder="" value="<?php echo e(old('footer_template')); ?>"></textarea>
				        	</div>
				        </div>
					</fieldset>
				</div>
			</div>

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
    	<form method="post" action="<?php echo e(url('payroll/paymentdisbursement')); ?>" >
    		<?php echo e(csrf_field()); ?>

    		<?php echo e(Form::hidden('_method', 'put')); ?>

    		<?php echo e(Form::hidden('isDelete', '1')); ?>

	    	<div id="div-del-chk-payDisbursement">
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
					$(".chk-payDisbursement:checked").each(function(){
					$('#div-del-chk-payDisbursement').append('<input type="hidden" name="payDisbursement_tbl[]" value="'+ $(this).val() +'" />');
					});
				});
		
			<?php if(Session::has('add-failed')): ?>
				UIkit.modal('#add').show();
				<?php elseif(Session::has('edit-failed')): ?>
				$(".btn-edit").click();
				<?php endif; ?>
				
			$(".btn-edit").click(function(){
				
					$("input[name|=payDisbursements]").val( $(this).attr('data-edit_pay_disb_id') );
					$("#edit_payroll_disb_code").val( $(this).attr('data-edit_payroll_disb_code') );
					$("#edit_bank_name").val( $(this).attr('data-edit_bank_name') );
					$("#edit_account_number").val( $(this).attr('data-edit_account_number') );
					$("#edit_company_code").val( $(this).attr('data-edit_company_code') );
					$("#edit_branch_code").val( $(this).attr('data-edit_branch_code') );
					$("#edit_default_file_name").val( $(this).attr('data-edit_default_file_name') );
					$("#edit_file_type").val( $(this).attr('data-edit_file_type') );
					$("#edit_data_type_dictionary").val( $(this).attr('data-edit_data_type_dictionary') );
					$("#edit_header_template").val( $(this).attr('data-edit_header_template') );
					$("#edit_detail_template").val( $(this).attr('data-edit_detail_template') );
					$("#edit_footer_template").val( $(this).attr('data-edit_footer_template') );
					
				});	
				
				var dataTable = $('#disbursements').DataTable({
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