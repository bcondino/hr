<?php $__env->startSection('title', 'Payroll Profile'); ?>

<?php $__env->startSection('styles'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<!-- header -->
<div class="header--title_container">
	<div class="uk-container uk-container-center">
		<div class="container-title">
			<h1 class="page-title"><span class="uk-icon uk-icon-file-text"></span> <strong>Payroll Profile</strong></h1>
		</div>
	</div>
</div>

<!-- list payroll profile setup -->
<div class="uk-container uk-container-center">
	<div class="uk-grid main">
		<div class="uk-width-1-4">
			<ul class="uk-nav uk-nav-side uk-nav-parent-icon" data-uk-nav>
				<li class="uk-active"><a href="<?php echo e(url('payrollmanagement/profile')); ?>">Payroll Profile</a></li>
				<li class="uk-parent"><a href="#">Earnings and Deductions </a>
					<ul class="uk-nav-sub">
						<li><a href="<?php echo e(url('payrollmanagement/rearningsdedn')); ?>">Recurring Earnings and Deductions</a></li>
						<li><a href="<?php echo e(url('payrollmanagement/nonrearningsdedn')); ?>">Non-recurring Earnings and Deductions</a></li>
					</ul>
				</li>
				<li><a href="<?php echo e(url('payrollmanagement/payrollprocess')); ?>">Payroll Process</a></li>
				<!-- 20161027 updated by Melvin Militante; Reason: To add payroll report interface -->
				<li><a href="<?php echo e(url('payrollmanagement/report')); ?>">Reports</a></li>
			</ul>
		</div>
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

				<!-- profile -->
				<table id="profile" class="uk-table uk-table-hover uk-table-striped payroll--table">
					<thead class="payroll--table_header">
						<tr>
				            <th><input type="checkbox" name="select_all" id="select_all" value="1" ></th>
							<th>Payroll Group</th>
							<th>Fixed WT Amount</th>
							<th>Additional WT Amount</th>
							<th>Substitute Filling</th>
							<th>SSS Deduction</th>
							<th>Pagibig Deduction</th>
							<th>Pagibig Fix Amount</th>
							<th>Philhealth Deduction</th>
						</tr>
				    </thead>
				    <tbody>
				    	<?php foreach($profiles as $profile): ?>
							<tr>
					            <td> <input type="checkbox" id="select_all" class="chk-profile" name="profiles[]" value="<?php echo e($profile->payroll_profile_id); ?>"/></td>
								<td> <a class="btn_profile" data-uk-modal="{target:'#edit'}"
									data-payroll_profile_id = "<?php echo e($profile->payroll_profile_id); ?>"
									data-payroll_group_id = "<?php echo e($profile->payroll_group_id); ?>"
									data-tax_fix_amt = "<?php echo e($profile->tax_fix_amt); ?>"
									data-add_tax_amt = "<?php echo e($profile->add_tax_amt); ?>"
									data-sub_filing_flag = "<?php echo e($profile->sub_filing_flag); ?>"
									data-ded_sss_flag = "<?php echo e($profile->ded_sss_flag); ?>"
									data-ded_pagibig_flag = "<?php echo e($profile->ded_pagibig_flag); ?>"
									data-ded_philhealth_flag = "<?php echo e($profile->ded_philhealth_flag); ?>"
									data-pagibig_fix_amt = "<?php echo e($profile->pagibig_fix_amt); ?>"
									data-ded_philhealth_flag = "<?php echo e($profile->ded_philhealth_flag); ?>"
									data-ded_sss_basic_flag = "<?php echo e($profile->ded_sss_basic_flag); ?>"
									data-ded_pagibig_basic_flag = "<?php echo e($profile->ded_pagibig_basic_flag); ?>"									
									data-ded_philhealth_basic_flag = "<?php echo e($profile->ded_philhealth_basic_flag); ?>"
									data-ded_sss_sb_amt = "<?php echo e($profile->ded_sss_sb_amt); ?>"
									data-ded_pagibig_sb_amt = "<?php echo e($profile->ded_pagibig_sb_amt); ?>"
									data-ded_philhealth_sb_amt = "<?php echo e($profile->ded_philhealth_sb_amt); ?>">
									 <?php echo e(\App\tbl_payroll_group_model::
									 	where('payroll_group_id', $profile->payroll_group_id)
									 	->first()
									 	->description); ?> </a></td>
								<td> <?php echo e($profile->tax_fix_amt); ?> </td>
								<td> <?php echo e($profile->add_tax_amt); ?> </td>
								<td> <?php echo e($profile->sub_filing_flag == 'Y'? 'Yes': 'No'); ?> </td>
								<td> <?php echo e($profile->ded_sss_flag == 'Y'? 'Yes': 'No'); ?> </td>
								<td> <?php echo e($profile->ded_pagibig_flag == 'Y'? 'Yes': 'No'); ?> </td>
								<td> <?php echo e($profile->ded_philhealth_flag == 'Y'? 'Yes': 'No'); ?> </td>
								<td> <?php echo e($profile->pagibig_fix_amt); ?> </td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table> <!-- payroll management profile -->
			</article>
		</div>		
	</div> <!-- grid -->
</div> <!-- container -->

<!-- start: modal for add button -->
<div id="add" class="uk-modal">
    <div class="uk-modal-dialog modal-wide">
    	<button class="uk-modal-close uk-close"></button>
    	<div class="uk-modal-header"><span class="uk-icon-plus-circle"></span>Add Payroll Profile</div>

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

        <form class="uk-form uk-form-horizontal" action="<?php echo e(url('payrollmanagement/profile')); ?>" method="post">
        	<?php echo e(csrf_field()); ?>

        	<div class="uk-grid">
				<div class="uk-width-1-2">
			        <div class="uk-form-row">
			        	<label class="uk-form-label">Payroll Group</label>
			        	<div class="uk-form-controls">
							<?php echo e(Form::select('payroll_group_id'
								, [null => '-- Select --'] + 
								\App\tbl_payroll_group_model::
									where('active_flag', 'Y')
									->where('company_id', $company->company_id)
									->lists('description', 'payroll_group_id')
									->toArray()
								, old('payroll_group_id')
								, ['class' => 'form-control'])); ?>

			        	</div>
			        </div>
			        <div class="uk-form-row">
			        	<label class="uk-form-label">Fixed Withholding Tax</label>
			        	<div class="uk-form-controls">
			        		<input type="text" class="form-control" placeholder="" name="tax_fix_amt" value="<?php echo e(old('tax_fix_amt')); ?>" default="0">
			        	</div>
			        </div>
			        <div class="uk-form-row">
			        	<label class="uk-form-label">Additional Withholding Tax</label>
			        	<div class="uk-form-controls">
			        		<input type="text" class="form-control" placeholder="" name="add_tax_amt" value="<?php echo e(old('add_tax_amt')); ?>">
			        	</div>
			        </div>
			        <div class="uk-form-row">
			        	<label class="uk-form-label">Subtitute Filling</label>
			        	<div class="uk-form-controls">
			        		<?php echo e(Form::select('sub_filing_flag'
				        		, [null => '-- Select --', 'Y' => 'Yes', 'N' => 'No']
								, old('sub_filing_flag')
								, ['class' => 'form-control'])); ?>

			        	</div>
			        </div>
			        <div class="uk-form-row">
			        	<label class="uk-form-label">With SSS Deduction</label>
			        	<div class="uk-form-controls">
			        		<?php echo e(Form::select('ded_sss_flag'
				        		, [null => '-- Select --', 'Y' => 'Yes', 'N' => 'No']
								, old('ded_sss_flag')
								, ['class' => 'form-control'])); ?>

			        	</div>
			        </div>
			        <div class="uk-form-row">
			        	<label class="uk-form-label">With Pagibig Deduction </label>
			        	<div class="uk-form-controls">
			        		<?php echo e(Form::select('ded_pagibig_flag'
				        		, [null => '-- Select --', 'Y' => 'Yes', 'N' => 'No']
								, old('ded_pagibig_flag')
								, ['class' => 'form-control'])); ?>

			        	</div>
			        </div>
			        <div class="uk-form-row">
			        	<label class="uk-form-label">Pagibig Fixed Amount</label>
			        	<div class="uk-form-controls">
			        		<input type="text" class="form-control" placeholder="" name="pagibig_fix_amt" value="<?php echo e(old('pagibig_fix_amt')); ?>">
			        	</div>
			        </div>
			        <div class="uk-form-row">
			        	<label class="uk-form-label">With PhilHealth Deduction </label>
			        	<div class="uk-form-controls">
			        		<?php echo e(Form::select('ded_philhealth_flag'
				        		, [null => '-- Select --', 'Y' => 'Yes', 'N' => 'No']
								, old('ded_philhealth_flag')
								, ['class' => 'form-control'])); ?>

			        	</div>
			        </div>
				</div>
				<div class="uk-width-1-2">
			        <div class="uk-form-row">
				        <strong>Applicable only to Monthly Wage Earner</strong>
				    </div>
			        <div class="uk-form-row">
			        	<label class="uk-form-label">SSS Deduction Based on Salary</label>
			        	<div class="uk-form-controls">
			        		<?php echo e(Form::select('ded_sss_basic_flag'
				        		, [null => '-- Select --', 'Y' => 'Yes', 'N' => 'No']
								, old('ded_sss_basic_flag')
								, ['class' => 'form-control'])); ?>

			        	</div>
			        </div>
			        <div class="uk-form-row">
			        	<label class="uk-form-label">Pagibig Deduction Based on Salary</label>
			        	<div class="uk-form-controls">
			        		<?php echo e(Form::select('ded_pagibig_basic_flag'
				        		, [null => '-- Select --', 'Y' => 'Yes', 'N' => 'No']
								, old('ded_pagibig_basic_flag')
								, ['class' => 'form-control'])); ?>

			        	</div>
			        </div>
			        <div class="uk-form-row">
			        	<label class="uk-form-label">Philhealth Deduction Based on Salary</label>
			        	<div class="uk-form-controls">
			        		<?php echo e(Form::select('ded_philhealth_basic_flag'
				        		, [null => '-- Select --', 'Y' => 'Yes', 'N' => 'No']
								, old('ded_philhealth_basic_flag')
								, ['class' => 'form-control'])); ?>

			        	</div>
			        </div>
			        <div class="uk-form-row">
				        <strong>Applicable only to Daily Wage Earner using Fixed Amount</strong>
				    </div>
			        <div class="uk-form-row">
			        	<label class="uk-form-label">SSS Deduction Based on Fixed Salary Base</label>
			        	<div class="uk-form-controls">
			        		<input type="text" class="form-control" placeholder="" name="ded_sss_sb_amt" value="<?php echo e(old('ded_sss_sb_amt')); ?>">
			        	</div>
			        </div>
			        <div class="uk-form-row">
			        	<label class="uk-form-label">Pagibig Deduction Based on Fixed Salary Base</label>
			        	<div class="uk-form-controls">
			        		<input type="text" class="form-control" placeholder="" name="ded_pagibig_sb_amt" value="<?php echo e(old('ded_pagibig_sb_amt')); ?>">
			        	</div>
			        </div>
			        <div class="uk-form-row">
			        	<label class="uk-form-label">Philhealth Deduction Based on Fixed Salary Base</label>
			        	<div class="uk-form-controls">
			        		<input type="text" class="form-control" placeholder="" name="ded_philhealth_sb_amt" value="<?php echo e(old('ded_philhealth_sb_amt')); ?>">
			        	</div>
			        </div>
				</div>
			</div>
			<div class="uk-modal-footer uk-text-right form-buttons">
				<button class="uk-button btn-save" type="submit"><span class="uk-icon uk-icon-edit"></span> Save</button>
				<button class="uk-button uk-modal-close btn-cancel"><span class="uk-icon uk-icon-times-circle"></span> Cancel</button>
			</div>			
		</form>
    </div>
</div> <!-- end: modal for add button -->

<!-- start: modal for add button -->
<div id="edit" class="uk-modal">
    <div class="uk-modal-dialog modal-wide">
    	<button class="uk-modal-close uk-close"></button>
    	<div class="uk-modal-header"><span class="uk-icon-plus-circle"></span>Edit Payroll Profile</div>

    	<!-- alerts -->
		<?php if(Session::has('put-failed')): ?>
			<?php if($errors->has()): ?>
				<div class="uk-alert uk-alert-danger ">				
					<?php foreach($errors->all() as $error): ?>
						<p class="uk-text-left"> <span class="uk-icon-close"></span> <?php echo e($error); ?> </p>
					<?php endforeach; ?>
				</div>				
			<?php endif; ?>
		<?php endif; ?>

        <form class="uk-form uk-form-horizontal" action="<?php echo e(url('payrollmanagement/profile')); ?>" method="post">
        	<?php echo e(csrf_field()); ?>

        	<?php echo e(Form::hidden('_method', 'put')); ?>

        	<?php echo e(Form::hidden('put_payroll_profile_id', old('put_payroll_profile_id'), ['id' => 'payroll_profile_id'])); ?>

        	<div class="uk-grid">
				<div class="uk-width-1-2">
			        <div class="uk-form-row">
			        	<label class="uk-form-label">Payroll Group</label>
			        	<div class="uk-form-controls">
							<?php echo e(Form::select('put_payroll_group_id'
								, \App\tbl_payroll_group_model::
									where('active_flag', 'Y')
									->where('company_id', $company->company_id)
									->lists('description', 'payroll_group_id')
									->toArray()
								, old('put_payroll_group_id')
								, ['class' => 'form-control', 'id' => 'payroll_group_id'])); ?>

			        	</div>
			        </div>
			        <div class="uk-form-row">
			        	<label class="uk-form-label">Fixed Withholding Tax</label>
			        	<div class="uk-form-controls">
			        		<input type="text" class="form-control" placeholder="" id="tax_fix_amt" name="put_tax_fix_amt" value="<?php echo e(old('put_tax_fix_amt')); ?>">
			        	</div>
			        </div>
			        <div class="uk-form-row">
			        	<label class="uk-form-label">Additional Withholding Tax</label>
			        	<div class="uk-form-controls">
			        		<input type="text" class="form-control" placeholder="" id="add_tax_amt" name="put_add_tax_amt" value="<?php echo e(old('add_tax_amt')); ?>">
			        	</div>
			        </div>
			        <div class="uk-form-row">
			        	<label class="uk-form-label">Subtitute Filling</label>
			        	<div class="uk-form-controls">
			        		<?php echo e(Form::select('put_sub_filing_flag'
				        		, [null => '-- Select --', 'Y' => 'Yes', 'N' => 'No']
								, old('put_sub_filing_flag')
								, ['class' => 'form-control', 'id' => 'sub_filing_flag'])); ?>

			        	</div>
			        </div>
			        <div class="uk-form-row">
			        	<label class="uk-form-label">With SSS Deduction</label>
			        	<div class="uk-form-controls">
			        		<?php echo e(Form::select('put_ded_sss_flag'
				        		, [null => '-- Select --', 'Y' => 'Yes', 'N' => 'No']
								, old('put_ded_sss_flag')
								, ['class' => 'form-control', 'id' => 'ded_sss_flag'])); ?>

			        	</div>
			        </div>
			        <div class="uk-form-row">
			        	<label class="uk-form-label">With Pagibig Deduction </label>
			        	<div class="uk-form-controls">
			        		<?php echo e(Form::select('put_ded_pagibig_flag'
				        		, [null => '-- Select --', 'Y' => 'Yes', 'N' => 'No']
								, old('put_ded_pagibig_flag')
								, ['class' => 'form-control', 'id' => 'ded_pagibig_flag'])); ?>

			        	</div>
			        </div>
			        <div class="uk-form-row">
			        	<label class="uk-form-label">Pagibig Fixed Amount</label>
			        	<div class="uk-form-controls">
			        		<input type="text" class="form-control" placeholder="" id="pagibig_fix_amt" name="put_pagibig_fix_amt" value="<?php echo e(old('put_pagibig_fix_amt')); ?>">
			        	</div>
			        </div>
			        <div class="uk-form-row">
			        	<label class="uk-form-label">With PhilHealth Deduction </label>
			        	<div class="uk-form-controls">
			        		<?php echo e(Form::select('put_ded_philhealth_flag'
				        		, [null => '-- Select --', 'Y' => 'Yes', 'N' => 'No']
								, old('put_ded_philhealth_flag')
								, ['class' => 'form-control', 'id' => 'ded_philhealth_flag'])); ?>

			        	</div>
			        </div>
				</div>
				<div class="uk-width-1-2">
			        <div class="uk-form-row">
				        <strong>Applicable only to Monthly Wage Earner</strong>
				    </div>
			        <div class="uk-form-row">
			        	<label class="uk-form-label">SSS Deduction Based on Salary</label>
			        	<div class="uk-form-controls">
			        		<?php echo e(Form::select('put_ded_sss_basic_flag'
				        		, [null => '-- Select --', 'Y' => 'Yes', 'N' => 'No']
								, old('put_ded_sss_basic_flag')
								, ['class' => 'form-control', 'id' => 'ded_sss_basic_flag'])); ?>

			        	</div>
			        </div>
			        <div class="uk-form-row">
			        	<label class="uk-form-label">Pagibig Deduction Based on Salary</label>
			        	<div class="uk-form-controls">
			        		<?php echo e(Form::select('put_ded_pagibig_basic_flag'
				        		, [null => '-- Select --', 'Y' => 'Yes', 'N' => 'No']
								, old('put_ded_pagibig_basic_flag')
								, ['class' => 'form-control', 'id' => 'ded_pagibig_basic_flag'])); ?>

			        	</div>
			        </div>
			        <div class="uk-form-row">
			        	<label class="uk-form-label">Philhealth Deduction Based on Salary</label>
			        	<div class="uk-form-controls">
			        		<?php echo e(Form::select('put_ded_philhealth_basic_flag'
				        		, [null => '-- Select --', 'Y' => 'Yes', 'N' => 'No']
								, old('put_ded_philhealth_basic_flag')
								, ['class' => 'form-control', 'id' => 'ded_philhealth_basic_flag'])); ?>

			        	</div>
			        </div>
			        <div class="uk-form-row">
				        <strong>Applicable only to Daily Wage Earner using Fixed Amount</strong>
				    </div>
			        <div class="uk-form-row">
			        	<label class="uk-form-label">SSS Deduction Based on Fixed Salary Base</label>
			        	<div class="uk-form-controls">
			        		<input type="text" class="form-control" placeholder="" id="ded_sss_sb_amt" name="put_ded_sss_sb_amt" value="<?php echo e(old('put_ded_sss_sb_amt')); ?>">
			        	</div>
			        </div>
			        <div class="uk-form-row">
			        	<label class="uk-form-label">Pagibig Deduction Based on Fixed Salary Base</label>
			        	<div class="uk-form-controls">
			        		<input type="text" class="form-control" placeholder="" id="ded_pagibig_sb_amt" name="put_ded_pagibig_sb_amt" value="<?php echo e(old('put_ded_pagibig_sb_amt')); ?>">
			        	</div>
			        </div>
			        <div class="uk-form-row">
			        	<label class="uk-form-label">Philhealth Deduction Based on Fixed Salary Base</label>
			        	<div class="uk-form-controls">
			        		<input type="text" class="form-control" placeholder="" id="ded_philhealth_sb_amt" name="put_ded_philhealth_sb_amt" value="<?php echo e(old('put_ded_philhealth_sb_amt')); ?>">
			        	</div>
			        </div>
				</div>
			</div>
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
    	<form method="post" action="<?php echo e(url('payrollmanagement/profile')); ?>">
	    	<?php echo e(csrf_field()); ?>

	    	<?php echo e(Form::hidden('_method', 'put')); ?>

	    	<?php echo e(Form::hidden('isDelete', '1')); ?>

	    	<div id="div-del-chk-profile">
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
				$(".chk-profile:checked").each(function(){
					$('#div-del-chk-profile').append('<input type="hidden" name="profiles[]" value="'+ $(this).val() +'" />');
				});
			});

			<?php if(Session::has('add-failed')): ?>
				UIkit.modal('#add').show();
			<?php elseif(Session::has('put-failed')): ?>
				$(".btn_profile").click();
			<?php endif; ?>

			$(".btn_profile").click(function(){
				$("#payroll_profile_id").val($(this).attr('data-payroll_profile_id'));
				$("#payroll_group_id").val($(this).attr('data-payroll_group_id'));
				$("#tax_fix_amt").val($(this).attr('data-tax_fix_amt'));
				$("#add_tax_amt").val($(this).attr('data-add_tax_amt'));
				$("#sub_filing_flag").val($(this).attr('data-sub_filing_flag'));
				$("#ded_sss_flag").val($(this).attr('data-ded_sss_flag'));
				$("#ded_pagibig_flag").val($(this).attr('data-ded_pagibig_flag'));
				$("#ded_philhealth_flag").val($(this).attr('data-ded_philhealth_flag'));
				$("#pagibig_fix_amt").val($(this).attr('data-pagibig_fix_amt'));
				$("#ded_philhealth_basic_flag").val($(this).attr('data-ded_philhealth_basic_flag'));
				$("#ded_sss_basic_flag").val($(this).attr('data-ded_sss_basic_flag'));
				$("#ded_pagibig_basic_flag").val($(this).attr('data-ded_pagibig_basic_flag'));
				$("#ded_sss_sb_amt").val($(this).attr('data-ded_sss_sb_amt'));
				$("#ded_pagibig_sb_amt").val($(this).attr('data-ded_pagibig_sb_amt'));
				$("#ded_philhealth_sb_amt").val($(this).attr('data-ded_philhealth_sb_amt'));
			});

			var dataTable = $('#profile').DataTable({
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