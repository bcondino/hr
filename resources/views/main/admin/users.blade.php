@extends('shared._public')

@section('title', 'Admin')

@section('styles')

@endsection

@section('content')

<!-- header -->
<div class="header--title_container">
	<div class="uk-container uk-container-center">
		<div class="container-title">
			<h1 class="page-title"><span class="uk-icon uk-icon-users"></span> <strong>Users</strong> </h1>
		</div>
	</div>
</div>

<!-- content -->
<div class="uk-container uk-container-center">
	
	<!-- buttons -->
	<div class="button-container">

		<!-- alerts -->
		@if(Session::has('add-success'))
			<div class="uk-alert-success">
				<span class="uk-icon uk-icon-check"></span> {{ Session::get('add-success') }}
			</div> </br>
		@elseif(Session::has('del-warning'))
			<div class="uk-alert-warning">
				<span class="uk-icon uk-icon-warning"></span> {{ Session::get('del-warning') }}
			</div> </br>
		@endif
		
		<button type="button" class="uk-button btn-add" data-uk-modal="{target:'#add'}"><span class="uk-icon uk-icon-plus-circle"></span> Add</button>
		<button type="button" class="uk-button" data-uk-modal="{target:'#delete'}"><span class="uk-icon uk-icon-trash"></span>  Delete</button>
	</div>	

	<!-- users table -->
	<div class="categories">
		<table id="user" class="uk-table uk-table-hover uk-table-striped payroll--table">
			<thead class="payroll--table_header">
				<tr>
					<th><input type="checkbox" name="select_all" id="select_all" value="1" ></th>
					<th>Name</th>
					<th>Role</th>
					<th>E-mail Address</th>
					<th>Company</th>
					<th>Activated</th>
					<th>Resend Verification</th>
				</tr>
			</thead>
			<tbody>
				@foreach($users as $user)
					<tr>
						<td><input type="checkbox" class="chk-users" name="users[]" value="{{$user->user_id}}"/></td>
						<td>
							<a class="btn_user" data-uk-modal="{target:'#edit'}" 
							data-user_id	= "{{ $user->user_id }}"
							data-first_name	= "{{ $user->first_name }}"
							data-last_name	= "{{ $user->last_name }}"
							data-user_type_id = "{{ $user->user_type_id }}"
							data-email_address = "{{ $user->email_address }}"
							data-company_id = "{{ $company->company_id }}" >
							{{ ucwords($user->last_name) }}, {{ ucwords($user->first_name) }} </a>
						</td>
						<td>{{ ucwords(\App\tbl_user_type_model::where('user_type_id', $user->user_type_id)->first()->user_type_name) }}</td>
						<td>{{ $user->email_address }}</td>
						<td>{{ ucwords($company->company_name) }}</td>
						<td>{{ $user->is_activated == 'Y'? 'Yes' : 'No' }}</td>
						<td><a href="{{ url('users/resendverification/'.$user->email_address) }}" class="uk-button"> Resend Verification</a></td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div> <!-- content -->


<!-- add users modal -->
<div id="add" class="uk-modal">
	<div class="uk-modal-dialog">
		<button class="uk-modal-close uk-close"></button>
    	<div class="uk-modal-header"><span class="uk-icon-plus-circle"></span>Add User</div>	

    	<!-- alerts -->
		@if(Session::has('add-failed'))
			@if($errors->has())
				<div class="uk-alert uk-alert-danger ">				
					@foreach ($errors->all() as $error)
						<p class="uk-text-left"> <span class="uk-icon-close"></span> {{ $error }} </p>
					@endforeach
				</div>
			@endif
		@endif

		<form class="uk-form uk-form-horizontal" method="POST" action="{{ url('users/users') }}">
			<fieldset>
				{{ csrf_field() }}
				<div class="uk-form-row">
					<label class="uk-form-label"><span class="uk-text-danger">*</span> First Name : </label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}"/>	
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"><span class="uk-text-danger">*</span> Last Name : </label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}"/>	
					</div>
				</div>				
				<div class="uk-form-row">
					<label class="uk-form-label"><span class="uk-text-danger">*</span> Role : </label>
					<div class="uk-form-controls">
						{{Form::select('user_type_id'
							, [null => '-- Select --'] + 
								\App\tbl_user_type_model::
									orderBy('user_type_name')
									->lists('user_type_name','user_type_id')
									->toArray()
							, old('user_type_id')
							, array('class'=>'form-control')) }}		
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"><span class="uk-text-danger">*</span> E-mail Address : </label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" name="email_address" value="{{ old('email_address') }}"/>	
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"><span class="uk-text-danger">*</span> Company : </label>
					<div class="uk-form-controls">
						{{Form::select('company_id'
							, [null => '-- Select --'] +
								\App\tbl_company_model::
							  		where('active_flag', 'Y')
                                    ->whereIn('company_id', 
                                    	\App\tbl_user_company_model::
                                    		where('user_id', Auth::user()->user_id)
                                    		->lists('company_id'))
                                    ->orderBy('company_name')
							        ->lists('company_name','company_id')->toArray()
							, old('company_id')
							, array('class'=>'form-control')) }}		
					</div>
				</div>	
				<div class="uk-modal-footer uk-text-right form-buttons">
					<button type="submit" class="uk-button btn-save"><span class="uk-icon uk-icon-edit"></span>Save</button>
					<button type="button" class="uk-button uk-modal-close btn-cancel"><span class="uk-icon uk-icon-times-circle"> Cancel</button>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<!-- /.add companies modal -->

<!-- edit users modal -->
<div id="edit" class="uk-modal">
	<div class="uk-modal-dialog">
		<button class="uk-modal-close uk-close"></button>
    	<div class="uk-modal-header"><span class="uk-icon-plus-circle"></span>Edit User</div>	

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

		<form class="uk-form uk-form-horizontal" method="POST" action="{{ url('users/users') }}">
			<fieldset>
				{{ csrf_field() }}
				{{ Form::hidden('_method', 'put') }}
				<input type="hidden" name="put_user_id" id="user_id" value="{{ old('put_user_id') }}"> 
				<div class="uk-form-row">
					<label class="uk-form-label"><span class="uk-text-danger">*</span> First Name : </label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" name="put_first_name" id="first_name" value="{{ old('put_first_name') }}"/>	
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"><span class="uk-text-danger">*</span> Last Name : </label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" name="put_last_name" id="last_name" value="{{ old('put_last_name') }}"/>	
					</div>
				</div>				
				<div class="uk-form-row">
					<label class="uk-form-label">&nbsp;&nbsp; Role : </label>
					<div class="uk-form-controls">
						{{Form::select('put_user_type_id'
							, \App\tbl_user_type_model::
								orderBy('user_type_name')
								->lists('user_type_name','user_type_id')
								->toArray()
							, ''
							, ['class'=>'form-control', 'id' => 'user_type_id']) }}		
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label"><span class="uk-text-danger">*</span> E-mail Address : </label>
					<div class="uk-form-controls">
						<input type="text" class="form-control" name="put_email_address" id="email_address" value="{{ old('put_email_address') }}"/>	
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label">&nbsp;&nbsp; Company : </label>
					<div class="uk-form-controls">
						{{Form::select('put_company_id'
							, \App\tbl_company_model::
							  		where('active_flag', 'Y')
                                    ->whereIn('company_id', 
                                    	\App\tbl_user_company_model::
                                    		where('user_id', Auth::user()->user_id)
                                    		->lists('company_id'))
                                    ->orderBy('company_name')
							        ->lists('company_name','company_id')->toArray()
							, old('put_company_id')
							, ['class'=>'form-control', 'id' => 'company_id']) }}		
					</div>
				</div>	
				<div class="uk-modal-footer uk-text-right form-buttons">
					<button type="submit" class="uk-button btn-save"><span class="uk-icon uk-icon-edit"></span>Save</button>
					<button type="button" class="uk-button uk-modal-close btn-cancel"><span class="uk-icon uk-icon-times-circle"> Cancel</button>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<!-- /.edit users modal -->

<!-- delete users modal -->
<div id="delete" class="uk-modal">
    <div class="uk-modal-dialog">
    	<button class="uk-modal-close uk-close"></button>
    	<div class="uk-modal-header"><span class="uk-icon-trash"></span>Delete Confirmation</div>
    	<div class="uk-margin uk-modal-content">
    		Are you sure you want to delete the selected records?
    	</div>
    	<form method="post" action="{{ url('users/users')}}">
				{{ csrf_field() }}
				{{ Form::hidden('_method', 'put') }}
	    	<input type="hidden" name="isDelete" value="1"> 
	    	<div id="div-del-chk-user">
	    	</div>
		    <div class="uk-modal-footer uk-text-right form-buttons">
		    	<button id="btn-del" type="submit" class="uk-button btn-delete js-modal-confirm"><span class="uk-icon uk-icon-trash"></span> Delete</button>
		        <button type="button" class="uk-button uk-modal-close btn-cancel js-modal-cancel"><span class="uk-icon uk-icon-times-circle"></span> Cancel</button>
		    </div>
		</form>	    
    </div>
</div> 
<!-- delete users modal -->

@endsection

@section('scripts')

<script type="text/javascript" language="javascript" src="{{asset('js/table.js')}}"></script>
<script type="text/javascript" class="init">
	$(document).ready(
		function() {

			$("#btn-del").click(function(){
				$(".chk-users:checked").each(function(){
					$('#div-del-chk-user').append('<input type="hidden" name="users[]" value="'+ $(this).val() +'" />');
				});
			});

			@if(Session::has('add-failed'))
				UIkit.modal('#add').show();
			@elseif(Session::has('put-failed'))
				$(".btn_user").click();
			@endif

			$(".btn_user").click(function(){
				$("#user_id").val($(this).attr('data-user_id'));
				$("#first_name").val($(this).attr('data-first_name'));
				$("#last_name").val($(this).attr('data-last_name'));
				$("#user_type_id").val($(this).attr('data-user_type_id'));
				$("#email_address").val($(this).attr('data-email_address'));
				$("#company_id").val($(this).attr('data-company_id'));
			});

			var dataTable = $('#user').DataTable({
				order: [],
				columnDefs: [ { orderable: false, targets: [0, 5, 6] } ]
			});			

			$('#select_all').click(function () {
			 $(':checkbox', dataTable.rows().nodes()).prop('checked', this.checked);
			});

		}
	);
</script>

@endsection
