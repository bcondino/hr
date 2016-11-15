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

<table id="position" class="uk-table uk-table-hover uk-table-striped payroll--table">
	<thead class="payroll--table_header">
		<tr> 
			<th><input type="checkbox" name="select_all" id="select_all" value="1" ></th>
			<th>Position Code</th>
			<th>Position Name</th>
			<th>Business Unit</th>
			<th>Salary Grade</th>
			<th>Class</th>
		</tr>
	</thead>
	<tbody style="cursor:pointer;">
		@if(count($pos) > 0 )
			 @foreach($pos as $pos)
			<tr>
				<td><input type="checkbox" id="chk-post" class="chk-post" name="position[]" value="{{$pos['position_id']}}"></td>
				<td><a id="edit_link" class="edit_link" data-uk-modal="{target:'#edit'}" data-id="{{ $pos['position_id'] }}" data-code="{{ $pos['position_code'] }}" data-desc = "{{ $pos['description'] }}" data-bu ="{{ $pos['business_unit_name'] or null }}" data-class="{{ $pos['class_name'] or null }}" data-grade="{{ $pos['grade_name'] or null }}">{{ $pos['position_code'] or null }}</a></td>
				<td>{{ $pos['description'] or null }}</td>
				<td>{{ $pos['business_unit_name'] or null }}</td>
				<td>{{ $pos['grade_name'] or null }}</td>
				<td>{{ $pos['class_name'] or null }}</td>
			</tr>
			@endforeach
        @endif
	</tbody> 
</table>

<!-- start: modal for add button -->
<div id="add" class="uk-modal">
	<div class="uk-modal-dialog">
		<button class="uk-modal-close uk-close"></button>
		<div class="uk-modal-header"><span class="uk-icon-plus-circle"></span>Add Position</div>
		<form class="uk-form uk-form-horizontal" action="{{ url('wiz2/position'.'/'.$comp) }}" method="POST" id="form-add-post">  
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
					<label class="uk-form-label"><span class="uk-text-danger">*</span> Position Code</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control " placeholder="Position Code" name="position_code" id="position_code" value="{{old('position_code')}}"/>
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"> &nbsp;&nbsp; Position Name</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control " placeholder="Position Name" name="position_name" id="position_name" value="{{old('position_name')}}"/>
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"><span class="uk-text-danger">*</span> Business Unit</label>
					<div class="uk-form-controls">
						{{ Form::select('business_unit_id', [null => 'Select Business Unit...']  + \App\tbl_business_unit_model::where('active_flag', 'Y')->where('company_id',$comp)->lists('business_unit_name', 'business_unit_id') -> toArray() ,null, array('class'=>'form-control', 'id' => 'business_unit', 'name' => 'business_unit')) }}
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"><span class="uk-text-danger">*</span> Salary Grade</label>
					<div class="uk-form-controls">
						{{ Form::select('grade_id', [null => 'Select Salary Grade...']  + \App\tbl_salary_grade_model::where('active_flag', 'Y')->where('company_id',$comp)->lists('grade_name', 'grade_id') -> toArray() ,null, array('class'=>'form-control', 'id' => 'salary_grade', 'name' => 'salary_grade')) }}
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"><span class="uk-text-danger">*</span> Classification</label>
					<div class="uk-form-controls">
						{{ Form::select('class_id',[null => 'Select Classification...']  + \App\tbl_classification_model::where('active_flag', 'Y')->lists('class_name', 'class_id') -> toArray() ,null, array('class'=>'form-control', 'id' => 'classification', 'name' => 'classification')) }}
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
		<div class="uk-modal-header"><span class="uk-icon-edit"></span>Edit Position</div>
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
		<form class="uk-form uk-form-horizontal" action="{{ url('wiz2/position'.'/'.$comp) }}" method="POST" id="form-edit-post">
			<fieldset>
				{!! csrf_field() !!}
				<input type="hidden" name="_method" value="PUT" />
				<input type="hidden" name="edit_flag" value="0" />
				<div class="uk-form-row">
				<input type="hidden" name="edt_position_id" id="edt_position_id" value="{{ old('edt_position_id') }}"> 
					<label class="uk-form-label"><span class="uk-text-danger">*</span>Position Code</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control " placeholder="Position Code" name="edt_position_code" id="edt_position_code" value="{{ old('edt_position_code') }}"/>
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label">Position Name</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control " placeholder="Position Name" name="edt_position_name" id="edt_position_name" value="{{ old('edt_position_name') }}"/>
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"><span class="uk-text-danger">*</span>Business Unit</label>
					<div class="uk-form-controls">
						{{ Form::select('edt_business_unit', [null => 'Select Business Unit...']  + App\tbl_business_unit_model::where('active_flag', 'Y')->where('company_id',$comp)->lists('business_unit_name', 'business_unit_id') -> toArray() ,old('edt_business_unit'), array('class'=>'form-control', 'id' => 'edt_business_unit')) }}
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"><span class="uk-text-danger">*</span>Salary Grade</label>
					<div class="uk-form-controls">
						{{ Form::select('edt_salary_grade', [null => 'Select Salary Grade...']  + \App\tbl_salary_grade_model::where('active_flag', 'Y')->where('company_id',$comp)->lists('grade_name', 'grade_id') -> toArray(), old('edt_salary_grade'), array('class'=>'form-control', 'id' => 'edt_salary_grade')) }}
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"><span class="uk-text-danger">*</span>Classification</label>
					<div class="uk-form-controls">
						{{ Form::select('edt_classification',[null => 'Select Classification...']  + \App\tbl_classification_model::where('active_flag', 'Y')->lists('class_name', 'class_id') -> toArray() , old('edt_classification') , array('class'=>'form-control', 'id' => 'edt_classification')) }}
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
	    	<form method="post" action="{{ url('wiz2/position'.'/'.$comp) }}">
		    	{{ csrf_field() }}
				<input type="hidden" name="_method" value="PUT" />
		    	<div id="div-del-chk-pos">
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
				$('#form-add-post').submit();
			});

			$('#btn-save-chng').click(function(){    
				$('#form-edit-post').submit();
			});

			@if(Session::has('add-failed'))
				UIkit.modal('#add').show();
			@elseif(Session::has('put-failed')){
				$("input[name|=edit_flag]").val('1');
				UIkit.modal('#edit').show();
			}
			@endif

			$('.edit_link').click(function(){  
				$("#edt_position_id").val( $(this).attr('data-id') );
				$("#edt_position_code").val( $(this).attr('data-code') );
				$("#edt_position_name").val( $(this).attr('data-desc') );
				$("#edt_business_unit option:contains(" + $(this).attr('data-bu') +")").attr("selected", true);
				$("#edt_salary_grade option:contains(" + $(this).attr('data-grade') +")").attr("selected", true);
				$("#edt_classification option:contains(" + $(this).attr('data-class') +")").attr("selected", true);
				$("input[name|=edit_flag]").val('1');
			});

			$("#btn-del").click(function(){
				$(".chk-post:checked").each(function(){
					$('#div-del-chk-pos').append('<input type="hidden" name="post2[]" value="'+ $(this).val() +'" />');
				});
			});


			var dt = $('#position').DataTable({
			order: [],
			columnDefs: [ { orderable: false, targets: [0] } ]
			});

			$('#select_all').click(function () {
	       	 $(':checkbox', dt.rows().nodes()).prop('checked', this.checked);
	    	});

		});
</script>
@endsection