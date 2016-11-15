<!-- buttons -->
<div calss="uk-block">
	<!-- buttons -->
	<div class="button-container">
		<!-- alerts -->
		@foreach(['add','put','del'] as $msg)
			@if(Session::has($msg.'-success'))
				<div class="uk-alert uk-alert-success">
					<span class="uk-icon uk-icon-check"></span> {{ Session::get($msg.'-success') }}
				</div>
			@elseif(Session::has($msg.'-warning'))
				<div class="uk-alert uk-alert-warning">
					<span class="uk-icon uk-icon-warning"></span> {{ Session::get($msg.'-warning') }}
				</div>
			@endif
		@endforeach	
		<button type="button" class="uk-button btn-add" data-uk-modal="{target:'#add'}"><span class="uk-icon uk-icon-plus-circle"></span> Add</button>
		<button type="button" class="uk-button" data-uk-modal="{target:'#delete'}"><span class="uk-icon uk-icon-trash"></span>  Delete</button>
	</div>
</div>

<table id="salarygrade" class="uk-table uk-table-hover uk-table-striped payroll--table">
	<thead class="payroll--table_header">
		<tr> 
			<th><input type="checkbox" name="select_all" id="select_all" value="1" ></th>
			<th>Salary Grade</th>
			<th>Minimum Salary</th>
			<th>Maximum Salary</th>
		</tr>
	</thead>
	<tbody>
		@if(count($salary_grade) > 0 )
		@foreach($salary_grade as $salgrade)
		<tr>
			<td><input type="checkbox" class="chk-grade" id="chk-grade" name="grade[]" value="{{ $salgrade['grade_id']}}"></td>
			<td><a id="edit_link" class="edit_link" data-uk-modal="{target:'#edit'}" data-id="{{ $salgrade['grade_id']}}" data-name="{{ $salgrade['grade_name'] or null }}" data-min="{{ $salgrade['minimum_salary'] or null }}" data-max="{{ $salgrade['maximum_salary'] or null }}">{{ $salgrade['grade_name'] or null }}</a></td>
			<td align='right'>{{ $salgrade['minimum_salary'] or null }}</td>
			<td align='right'>{{ $salgrade['maximum_salary'] or null }}</td>
		</tr>
		@endforeach	
		@endif
	</tbody> 
</table>

<!-- start: modal for add button -->
<div id="add" class="uk-modal">
	<div class="uk-modal-dialog">
		<button class="uk-modal-close uk-close"></button>
		<div class="uk-modal-header"><span class="uk-icon-plus-circle"></span>Add Salary Grade</div>
		<form class="uk-form uk-form-horizontal" action="{{ url('wiz2/grade'.'/'.$comp) }}" method="POST" id="form-add-grade">  
			{!! csrf_field() !!}
			<fieldset>
				<div >
					<!-- alerts -->
					@if(Session::has('add-failed'))
					@if($errors->has())
					<div class="uk-alert uk-alert-danger">				
						@foreach ($errors->all() as $error)
						<p class="uk-text-left"> <span class="uk-icon-close"></span> {{ $error }} </p>
						@endforeach
					</div>
					@endif
					@endif
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"><span class="uk-text-danger">*</span> Salary Grade</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" placeholder="Salary Grade..." name="grade_name" id="grade_name" value="{{old('grade_name')}}"/>
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"><span class="uk-text-danger">*</span> Minimum Salary</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" placeholder="Minimum Salary..." name="min_sal" id="min_sal" value="{{old('min_sal')}}"/>
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"><span class="uk-text-danger">*</span> Maximum Salary</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" placeholder="Maximum Salary..." name="max_sal" id="max_sal" value="{{old('max_sal')}}"/>
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
		<div class="uk-modal-header"><span class="uk-icon-edit"></span>Edit Salary Grade</div>
		<!-- alerts -->
		@if(Session::has('put-failed'))
		@if($errors->has())
		<div class="uk-alert uk-alert-danger ">				
			@foreach ($errors->all() as $error)
			<p class="uk-text-left"> <span class="uk-icon-close"></span> {{ $error }} </p>
			@endforeach
		</div>				
		@endif
		@endif
		<form class="uk-form uk-form-horizontal" action="{{ url('wiz2/grade'.'/'.$comp) }}" method="POST" id="form-edit-emptype">
			<fieldset>
				{!! csrf_field() !!}
				<input type="hidden" name="_method" value="PUT" />
				<input type="hidden" name="edit_flag" value="0" />
				<div class="uk-form-row">
					<input type="hidden" name="edt_grade_id" id="edt_grade_id" value="{{ old('edt_grade_id') }}"> 
					<label class="uk-form-label"><span class="uk-text-danger">*</span> Salary Grade</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" placeholder="Salary Grade..." name="edt_grade_name" id="edt_grade_name" value="{{ old('edt_grade_name') }}"/>
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"><span class="uk-text-danger">*</span> Minimum Salary</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" placeholder="Minimum Salary..." name="edt_min_sal" id="edt_min_sal" value="{{ old('edt_min_sal') }}"/>
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"><span class="uk-text-danger">*</span> Maximum Salary</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" placeholder="Maximum Salary..." name="edt_max_sal" id="edt_max_sal" value="{{ old('edt_max_sal') }}"/>
					</div>
				</div>
			</fieldset>
			<div class="uk-modal-footer uk-text-right form-buttons">
				<button id="btn-save-chng" class="uk-button btn-save" type="submit"><span class="uk-icon uk-icon-edit"></span> Save Changes</button>
				<button class="uk-button uk-modal-close btn-cancel"><span class="uk-icon uk-icon-times-circle"></span> Cancel</button>
			</div>
		</form>
	</div>
</div> <!-- end: modal for edit button -->

	<!-- delete employment modal -->
	<div id="delete" class="uk-modal">
	    <div class="uk-modal-dialog">
	    	<button class="uk-modal-close uk-close"></button>
	    	<div class="uk-modal-header"><span class="uk-icon-trash"></span>Delete Confirmation</div>
	    	<div class="uk-margin uk-modal-content">
	    		Are you sure you want to delete the selected records?
	    	</div>
	    	<form method="post" action="{{ url('wiz2/grade'.'/'.$comp) }}">
		    	{{ csrf_field() }}
				<input type="hidden" name="_method" value="PUT" />
		    	<div id="div-del-chk-grade">
		    	</div>
			    <div class="uk-modal-footer uk-text-right form-buttons">
			    	<button id="btn-del" type="submit" class="uk-button btn-delete js-modal-confirm"><span class="uk-icon uk-icon-trash"></span> Delete</button>
			        <button type="button" class="uk-button uk-modal-close btn-cancel js-modal-cancel"><span class="uk-icon uk-icon-times-circle"></span> Cancel</button>
			    </div>
			</form>	    
	    </div>
	</div> 
	<!-- delete employment modal -->
</br>
</br>

<div class="uk-text-right form-buttons">
	@include('wiz2.controls')
</div>


@section('scripts')

<script type="text/javascript" language="javascript" src="{{ asset('js/table.js') }}"></script>
	<script type="text/javascript" class="init">
   		$(document).ready(function() {
			$('#btn-save').click(function(){ 
				$('#form-add-grade').submit();
			});

			$('#btn-save-chng').click(function(){    
				$('#form-edit-grade').submit();
			});

			@if(Session::has('add-failed'))
				UIkit.modal('#add').show();
			@elseif(Session::has('put-failed')){
				$("input[name|=edit_flag]").val('1');
				UIkit.modal('#edit').show();
			}
			@endif

			$('.edit_link').click(function(){  
				$("#edt_grade_id").val($(this).attr('data-id'));
				$("#edt_grade_name").val( $(this).attr('data-name') );
				$("#edt_min_sal").val( $(this).attr('data-min') );
				$("#edt_max_sal").val( $(this).attr('data-max') );
				$("input[name|=edit_flag]").val('1');
			});

			$("#btn-del").click(function(){
				$(".chk-grade:checked").each(function(){
					$('#div-del-chk-grade').append('<input type="hidden" name="grade[]" value="'+ $(this).val() +'" />');
				});
			});

			var dt = $('#salarygrade').DataTable({
			order: [],
			columnDefs: [ { orderable: false, targets: [0] } ]
			});

			$('#select_all').click(function () {
	       	 $(':checkbox', dt.rows().nodes()).prop('checked', this.checked);
	    	});

		}
		);
   		</script>
	@endsection