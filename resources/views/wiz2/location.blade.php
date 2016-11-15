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
	<table id="location" class="uk-table uk-table-hover uk-table-striped payroll--table">
		<thead class="payroll--table_header">
			<tr> 
				<th><input type="checkbox" name="select_all" id="select_all" value="1" ></th>
				<th>Code</th>
				<th>Name</th>
				<th>Address</th>
				<th>City</th>
			</tr>
		</thead>
		<tbody>
			@if(count($location) > 0 )		
			@foreach($location as $loc)
			<tr>
				<td>
					<input type="checkbox" class="chk-loc" value="{{ $loc['id'] }}" data-name="{{ $loc['code'] }}" />
				</td>
				<td><a id="edit_link" class="edit_link" data-uk-modal="{target:'#edit'}" data-lid="{{ $loc['id'] }}" data-lcode="{{ $loc['code'] }}" data-lname="{{ $loc['name'] or null }}" data-laddress="{{ $loc['address'] or null }}" data-city="{{ $loc['city'] or null }}">{{ $loc['code'] }}</a></td>
				<td>{{ $loc['name'] }}</td>
				<td>{{ $loc['address'] }}</td>
				<td>{{ $loc['city'] }}</td>
			</tr>
			@endforeach
			@endif
		</tbody> 
	</table>

	<!-- start: modal for add button -->
	<div id="add" class="uk-modal">
		<div class="uk-modal-dialog">
			<button class="uk-modal-close uk-close"></button>
			<div class="uk-modal-header"><span class="uk-icon-plus-circle"></span>Add Location</div>
			<form class="uk-form uk-form-horizontal" action="{{ url('wiz2/location'.'/'.$comp) }}" role="form" method="POST" id="form-add-loc" value="">  
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
						<label class="uk-form-label"><span class="uk-text-danger">*</span> Location Code</label>
						<div class="uk-form-controls">
							<input type="text" class="form-control" name="location_code" placeholder="Location Code..." value="{{old('location_code')}}" />
						</div>
					</div>
					<div class="uk-form-row">
						<label class="uk-form-label">&nbsp;&nbsp; Location Name</label>
						<div class="uk-form-controls">
							<input type="text" class="form-control" name="location_name" placeholder="Location Name..." value="{{old('location_name')}}"/>
						</div>
					</div>
					<div class="uk-form-row">
						<label class="uk-form-label">&nbsp;&nbsp; Address</label>
						<div class="uk-form-controls">
							<input type="text" class="form-control" name="address" id="address" placeholder="Address..." value="{{ old('address')}}"/>
						</div>
					</div>
					<div class="uk-form-row">
						<label class="uk-form-label">&nbsp;&nbsp; City</label>
						<div class="uk-form-controls">
							<input type="text" class="form-control" name="city" id="city"  placeholder="City..." value="{{old('city')}}"/>
						</div>
					</div>
				</fieldset>
				<div class="uk-modal-footer uk-text-right form-buttons">
					<button class="uk-button btn-save" type="submit"><span class="uk-icon uk-icon-edit"></span>Save</button>
					<button class="uk-button uk-modal-close btn-cancel"><span class="uk-icon uk-icon-times-circle"></span>Cancel</button>
				</div>
			</form>
		</div>
	</div> <!-- end: modal for add button -->

	<!-- start: modal for edit button -->
	<div id="edit" class="uk-modal">
		<div class="uk-modal-dialog">
			<button class="uk-modal-close uk-close"></button>
			<div class="uk-modal-header"><span class="uk-icon-edit"></span>Edit Location</div>
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
			<form class="uk-form uk-form-horizontal" action="{{ url('wiz2/location'.'/'.$comp) }}" role="form" method="POST" id="form-edit-loc" value=""> {!! csrf_field() !!}
				<fieldset>
					<input type="hidden" name="_method" value="PUT" />
					<input type="hidden" name="edit_flag" value="0" />
					<div class="uk-form-row">
					<input type="hidden" name="edt_location_id" id="edt_location_id" value="{{ old('edt_location_id') }}"> 
						<label class="uk-form-label"><span class="uk-text-danger">*</span> Location Code</label>
						<div class="uk-form-controls">
							<input type="text" class="form-control" name="edt_location_code" id="edt_location_code"  value="{{old('edt_location_code')}}" placeholder="Location Code..."/>
						</div>
					</div>
					<div class="uk-form-row">
						<label class="uk-form-label">&nbsp;&nbsp; Location Name</label>
						<div class="uk-form-controls">
							<input type="text" class="form-control" name="edt_location_name" id="edt_location_name" placeholder="Location Name..." value="{{old('edt_location_name')}}"/>
						</div>
					</div>
					<div class="uk-form-row">
						<label class="uk-form-label">&nbsp;&nbsp; Address</label>
						<div class="uk-form-controls">
							<input type="text" class="form-control" name="edt_address" id="edt_address" placeholder="Address..." value="{{old('edt_address')}}"/>
						</div>
					</div>
					<div class="uk-form-row">
						<label class="uk-form-label">&nbsp;&nbsp; City</label>
						<div class="uk-form-controls">
							<input placeholder="City..." type="text" class="form-control" name="edt_city" id="edt_city"  value="{{old('edt_city')}}"/>
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

	<!-- delete location modal -->
	<div id="delete" class="uk-modal">
	    <div class="uk-modal-dialog">
	    	<button class="uk-modal-close uk-close"></button>
	    	<div class="uk-modal-header"><span class="uk-icon-trash"></span>Delete Confirmation</div>
	    	<div class="uk-margin uk-modal-content">
	    		Are you sure you want to delete the selected records?
	    	</div>
	    	<form method="post" action="{{ url('wiz2/location'.'/'.$comp) }}">
		    	{{ csrf_field() }}
				<input type="hidden" name="_method" value="PUT" />
		    	<div id="div-del-chk-loc">
		    	</div>
			    <div class="uk-modal-footer uk-text-right form-buttons">
			    	<button id="btn-del" type="submit" class="uk-button btn-delete js-modal-confirm"><span class="uk-icon uk-icon-trash"></span> Delete</button>
			        <button type="button" class="uk-button uk-modal-close btn-cancel js-modal-cancel"><span class="uk-icon uk-icon-times-circle"></span> Cancel</button>
			    </div>
			</form>	    
	    </div>
	</div> 
	<!-- delete location modal -->

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
			$('#form-add-loc').submit();
		});

		$('#btn-save-chng').click(function(){    
			$('#form-edit-loc').submit();
		});

		@if(Session::has('add-failed'))
			UIkit.modal('#add').show();
		@elseif(Session::has('put-failed')){
			$("input[name|=edit_flag]").val('1');
			UIkit.modal('#edit').show();}
		@endif

		$("#btn-del").click(function(){
			$(".chk-loc:checked").each(function(){
				$('#div-del-chk-loc').append('<input type="hidden" name="location[]" value="'+ $(this).val() +'" />');
			});					
		});


		$('.edit_link').click(function(){  
			$("#edt_location_id").val($(this).attr('data-lid'));
			$("input[name|=loc]").val( $(this).attr('data-lid') );
			$("#edt_location_name").val( $(this).attr('data-lname') );
			$("#edt_location_code").val( $(this).attr('data-lcode') );
			$("#edt_city").val( $(this).attr('data-city') );
			$("#edt_address").val( $(this).attr('data-laddress') );
			$("input[name|=edit_flag]").val('1');
		});



		var dt = $('#location').DataTable({
			order: [],
			columnDefs: [ { orderable: false, targets: [0] } ]
		});	

		$('#select_all').click(function (e) {
			$(':checkbox', dt.rows().nodes()).prop('checked', this.checked);
		});
	}
	);
</script>
@endsection