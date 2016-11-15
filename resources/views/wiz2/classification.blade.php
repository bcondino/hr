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

<table id="classification" class="uk-table uk-table-hover uk-table-striped payroll--table">
	<thead class="payroll--table_header">
		<tr> 
			<th><input type="checkbox" name="select_all" id="select_all" value="1" ></th>
			<th>Classification</th>
		</tr>
	</thead>
	<tbody>
		@foreach($classification as $class)
		<tr>
			<td> <input type="checkbox" class="chk-classification" name="class[]" value="{{ $class->class_id }}"> </td>
			<td> <a class="btn-edit" data-uk-modal="{target:'#edit'}" 
					data-class_id = "{{ $class->class_id }}"
					data-class_name = "{{ $class->class_name }}">
				{{ $class->class_name }}
			</td>
		</tr>
		@endforeach	
	</tbody> 
</table>

<!-- start: modal for add button -->
<div id="add" class="uk-modal">
	<div class="uk-modal-dialog">
		<button class="uk-modal-close uk-close"></button>
		<div class="uk-modal-header"><span class="uk-icon-plus-circle"></span>Add Classification</div>
		<form class="uk-form uk-form-horizontal" action="{{ url('wiz2/classification'.'/'.$comp) }}" method="post">  
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
					<label class="uk-form-label"><span class="uk-text-danger">*</span> Classification Name</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" placeholder="Classification Name..." name="class_name" value="{{ old('class_name') }}"/>
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
		<div class="uk-modal-header"><span class="uk-icon-plus-circle"></span>Edit Classification</div>
		<form class="uk-form uk-form-horizontal" action="{{ url('wiz2/classification'.'/'.$comp) }}" method="post">  
			{{ csrf_field() }}
			<input type="hidden" name="_method" value="put">
			<input type="hidden" id="class_id" name="put_class_id" value="{{ old('put_class_id') }}">
			<fieldset>
				<div >
					<!-- alerts -->
					@if(Session::has('put-failed'))
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
					<label class="uk-form-label"><span class="uk-text-danger">*</span> Classification Name</label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" placeholder="Classification Name..." id="class_name" name="put_class_name" />
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

<!-- start: modal for delete button -->
	<div id="delete" class="uk-modal">
	    <div class="uk-modal-dialog">
	    	<button class="uk-modal-close uk-close"></button>
	    	<div class="uk-modal-header"><span class="uk-icon-trash"></span>Delete Confirmation</div>
	    	<div class="uk-margin uk-modal-content">
	    		Are you sure you want to delete the selected records?
	    	</div>
	    	<form method="post" action="{{ url('wiz2/classification'.'/'.$comp) }}">
		    	{{ csrf_field() }}
				{{ Form::hidden('_method', 'delete') }}
				<!-- <input type="hidden" name="_method" value="PUT" /> -->
		    	<div id="div-del-chk-class"></div>
			    <div class="uk-modal-footer uk-text-right form-buttons">
			    	<button id="btn-del" type="submit" class="uk-button btn-delete js-modal-confirm"><span class="uk-icon uk-icon-trash"></span> Delete</button>
			        <button type="button" class="uk-button uk-modal-close btn-cancel js-modal-cancel"><span class="uk-icon uk-icon-times-circle"></span> Cancel</button>
			    </div>
			</form>	    
	    </div>
	</div> 
<!-- end: modal for delete button -->

</br>
</br>

<div class="uk-text-right form-buttons">
	@include('wiz2.controls')
</div>


@section('scripts')

<script type="text/javascript" language="javascript" src="{{ asset('js/table.js') }}"></script>
	<script type="text/javascript" class="init">
   		$(document).ready(function() {

			@if(Session::has('add-failed'))
				UIkit.modal('#add').show();
			@elseif(Session::has('put-failed')){
				UIkit.modal('#edit').show();
			}
			@endif

			$('.btn-edit').click(function(){  
				$("#class_id").val($(this).attr('data-class_id'));
				$("#class_name").val( $(this).attr('data-class_name'));
			});

			$("#btn-del").click(function(){
				$(".chk-classification:checked").each(function(){
					$('#div-del-chk-class').append('<input type="hidden" name="classification[]" value="'+ $(this).val() +'" />');
				});
			});

			var dt = $('#classification').DataTable({
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