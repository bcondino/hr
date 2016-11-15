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
<table id="employmenttype" class="uk-table uk-table-hover uk-table-striped payroll--table">
	<thead class="payroll--table_header">
		<tr> 
			<th><input type="checkbox" name="select_all" id="select_all" value="1" ></th>
			<th>Employment Type</th>
			<th>Minimum Hour(s)</th>
			<th>Maximum Hour(s)</th>
		</tr>
	</thead>
	<tbody>
		@if(count($employment) > 0 )
		@foreach($employment as $emptype)
		<tr>
			<td><input type="checkbox" class="chk-emptype" name="emptype[]" value="{{ $emptype['type_id'] }}"/></td>
			<!-- <td>{{ $emptype['type_id'] or null }}</td> -->
			<td><a id="edit_link" class="edit_link" data-uk-modal="{target:'#edit'}" data-id="{{ $emptype['type_id'] }}" data-type="{{ $emptype['type_name'] }}" data-min="{{ $emptype['min_hrs'] or null }}" data-max="{{ $emptype['max_hrs'] or null }}">{{ $emptype['type_name'] }}</a></td>
			<td>{{ $emptype['min_hrs'] or null }}</td>
			<td>{{ $emptype['max_hrs'] or null }}</td>
		</tr>
		@endforeach
		@endif
	</tbody> 
</table>

<!-- start: modal for add button -->
<div id="add" class="uk-modal">
	<div class="uk-modal-dialog">
		<button class="uk-modal-close uk-close"></button>
		<div class="uk-modal-header"><span class="uk-icon-plus-circle"></span>Add Employment Type</div>
		<form class="uk-form uk-form-horizontal" action="{{ url('wiz2/employment'.'/'.$comp) }}" method="POST" id="form-add-emptype">  
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
					<label class="uk-form-label"><span class="uk-text-danger">*</span> Employment Type</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" placeholder="Employment Type..." name="type_name" id="type_name" value="{{old('type_name')}}"/>
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"><span class="uk-text-danger">*</span> Minimum Hours</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" placeholder="Minimum Hours..." name="min_hrs" id="min_hrs" value="{{old('min_hrs')}}"/>
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"><span class="uk-text-danger">*</span> Maximum Hours</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" placeholder="Maximum Hours..." name="max_hrs" id="max_hrs" value="{{old('max_hrs')}}"/>
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
		<div class="uk-modal-header"><span class="uk-icon-edit"></span>Edit Employment Type</div>
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
		<form class="uk-form uk-form-horizontal" action="{{ url('wiz2/employment'.'/'.$comp) }}" method="POST" id="form-edit-emptype">
			<fieldset>
				{!! csrf_field() !!}
				<input type="hidden" name="_method" value="PUT" />
				<input type="hidden" name="edit_flag" value="0" />
				<!-- <input type="hidden" name="emptype" value="" /> -->
				<div class="uk-form-row">
					<input type="hidden" name="edt_emptype_id" id="edt_emptype_id" value="{{ old('edt_emptype_id') }}"> 
					<label class="uk-form-label"><span class="uk-text-danger">*</span> Employment Type</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" placeholder="Employment Type..." name="edt_type_name" id="edt_type_name" value="{{old('edt_type_name')}}"/>
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"><span class="uk-text-danger">*</span> Minimum Hours</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" placeholder="Minimum Hours..." name="edt_min_hrs" id="edt_min_hrs" value="{{old('edt_min_hrs')}}"/>
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"><span class="uk-text-danger">*</span> Maximum Hours</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" placeholder="Maximum Hours..." name="edt_max_hrs" id="edt_max_hrs" value="{{old('edt_max_hrs')}}"/>
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
	    	<form method="post" action="{{ url('wiz2/employment'.'/'.$comp) }}">
		    	{{ csrf_field() }}
				<input type="hidden" name="_method" value="PUT" />
		    	<div id="div-del-chk-emptype">
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
<script type="text/javascript">

	$(document).ready(function() {
		$('#btn-save').click(function(){ 
			$('#form-add-emptype').submit();
		});

		$('#btn-save-chng').click(function(){    
			$('#form-edit-emptype').submit();
		});

		@if(Session::has('add-failed'))
			UIkit.modal('#add').show();
		@elseif(Session::has('put-failed')){
			$("input[name|=edit_flag]").val('1');
			UIkit.modal('#edit').show();
		}
		@endif

		$("#btn-del").click(function(){
			$(".chk-emptype:checked").each(function(){
				$('#div-del-chk-emptype').append('<input type="hidden" name="emptype[]" value="'+ $(this).val() +'" />');
			});
		});

		$('.edit_link').click(function(){  
			$("#edt_emptype_id").val($(this).attr('data-id'));
			$("#edt_type_name").val( $(this).attr('data-type') );
			$("#edt_min_hrs").val( $(this).attr('data-min') );
			$("#edt_max_hrs").val( $(this).attr('data-max') );
			$("input[name|=edit_flag]").val('1');
		});


			var dt = $('#employmenttype').DataTable({
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