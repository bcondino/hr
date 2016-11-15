@extends('shared._public')
@section('title', 'Profile: Basic Information')
@section('styles')
@endsection
@section('content')
<!-- header -->
<div class="header--title_container">
    <div class="uk-container uk-container-center">
        <div class="container-title">
            <h1 class="page-title">
                <span class="uk-icon uk-icon-user">
                </span>
                <b>
                    {{ ucwords($employee->last_name) }}, {{ ucwords($employee->first_name) }}
                </b>
            </h1>
        </div>
    </div>
</div>
<!-- employee profile -->
<div class="uk-container uk-container-center">
    <div class="categories">
        <div class="uk-grid">
            <div class="uk-width-1-4">
                <ul class="uk-nav uk-nav-side">
                    <li class="uk-active"> <a href="{{ url('employee/basicinformation/'. $employee->employee_id) }}"> Basic Information </a> </li>
                    <li><a href="{{ url('employee/contactinformation/'. $employee->employee_id) }}"> Contact Information </a> </li>
                    <li><a href="{{ url('employee/employmentdetails/'. $employee->employee_id) }}"> Employment Details </a> </li>
                    <li><a href="{{ url('employee/governmentdetails/'. $employee->employee_id) }}"> Government Details </a> </li>
                    <li><a href="{{ url('employee/dependent/'. $employee->employee_id) }}"> Dependent </a> </li>
                    <li><a href="{{ url('employee/educbackground/'. $employee->employee_id) }}"> Educational Background </a> </li>
                    <li><a href="{{ url('employee/employmenthistory/'. $employee->employee_id) }}"> Employment History </a> </li>
                </ul>
            </div>
            <!--
                list company setup
            -->
            <!-- basic information -->
            <div class="uk-width" style="width:75%;">
				<!-- alerts -->
				@if(Session::has('put-success'))
					<div class="uk-alert uk-alert-success">
						<p class="uk-text-left"> <span class="uk-icon uk-icon-check"></span> {{ Session::get('put-success') }} </p>
					</div> 
				@elseif(Session::has('put-failed'))
					@if($errors->has())
						<div class="uk-alert uk-alert-danger ">				
							@foreach ($errors->all() as $error)
								<p class="uk-text-left"> <span class="uk-icon-close"></span> {{ $error }} </p>
							@endforeach
						</div>
					@endif
				@endif

                <form class="uk-form uk-form-horizontal"  method="post" action="{{ url('employee/basicinformation/'. $employee->employee_id) }}">
                    {{ csrf_field() }}
                    {{ Form::hidden('_method', 'put') }}
                    <div class="uk-grid">
                        <div class="uk-width-1-2">
                            <fieldset>
                                <div class="uk-form-row">
                                    <label class="uk-form-label">
                                        Employee Number
                                    </label>
                                    <div class="uk-form-controls">
                                        <input type="text" class="form-control" name="put_employee_number" value="{{ $employee->employee_number }}">
                                    </div>
                                </div>
                                <div class="uk-form-row">
                                    <label class="uk-form-label">
                                        Salutation
                                    </label>
                                    <div class="uk-form-controls">
                                        {{ Form::select('put_salutation'
                                            , ['Mr' =>'Mr.', 'Ms' =>'Ms.']
                                            , $employee->salutation
                                            , ['class' =>'form-control']) }}
                                    </div>
                                </div>
                                <div class="uk-form-row">
                                    <label class="uk-form-label">
                                        Last Name
                                    </label>
                                    <div class="uk-form-controls">
                                        <input type="text" class="form-control"  name="put_last_name" value="{{ $employee->last_name }}">
                                    </div>
                                </div>
                                <div class="uk-form-row">
                                    <label class="uk-form-label">
                                        First Name
                                    </label>
                                    <div class="uk-form-controls">
                                        <input type="text" class="form-control" name="put_first_name" value="{{ $employee->first_name }}">
                                    </div>
                                </div>
                                <div class="uk-form-row">
                                    <label class="uk-form-label">
                                        Middle Name
                                    </label>
                                    <div class="uk-form-controls">
                                        <input type="text" class="form-control" name="put_middle_name" value="{{ $employee->middle_name }}">
                                    </div>
                                </div>
                                <div class="uk-form-row">
                                    <label class="uk-form-label">
                                        Gender
                                    </label>
                                    <div class="uk-form-controls">
                                        {{ Form::select('put_gender'
                                            , ['M' =>'Male', 'F' =>'Female']
                                            , $employee->gender
                                            , ['class' =>'form-control']) }}
                                    </div>
                                </div>
                                <div class="uk-form-row">
                                    <label class="uk-form-label">
                                        Birthdate
                                    </label>
                                    <div class="uk-form-controls date-calendar" data-uk-form-select>
                                        <span class="uk-icon-calendar">
                                        </span>
                                        <input class="form-control" type="text" name="put_date_birth" data-uk-datepicker="{format:'DD/MM/YYYY'}" value="{{ $employee->date_birth }}">
                                    </div>
                                </div>
                            </div>
                            <div class="uk-width-1-2">
                                <div class="uk-form-row">
                                    <div style="text-align:right;">
                                        @if($employee->
                                        emp_photo == null)
                                        <a href="#" data-uk-modal="{target:'#upload_photo'}" data-employee_id="{{ $employee['employee_id'] }}"  data-employee_number="{{ $employee['employee_number'] }}">
                                            <img src="{{ asset('images/anon_user.png') }}"  id="profile_img"  style="width:187px; height:200px;"/>
                                        </a>
                                        @else
                                        <a href="#" data-uk-modal="{target:'#upload_photo'}" data-employee_id="{{ $employee['employee_id'] }}"  data-employee_number="{{ $employee['employee_number'] }}">
                                            <img src="{{ asset($employee->emp_photo) }}"   id="profile_img"  style="width:187px; height:200px;">
                                        </a>
                                        @endif
                                    </div>
                                </div>
                                <div class="uk-form-row">
                                    <label class="uk-form-label">
                                        Civil Status
                                    </label>
                                    <div class="uk-form-controls">
                                    	{{ Form::select('put_civil_stat'
                                            , ['S' => 'Single', 'M' => 'Married', 'W' => 'Widow']
                                            , $employee->civil_stat
                                            , ['class' => 'form-control']) }}
                                    </div>
                                </div>
                                <div class="uk-form-row">
                                    <label class="uk-form-label">
                                        Nationality
                                    </label>
                                    <div class="uk-form-controls">
                                        <input type="text" class="form-control" name="put_nationality" value="{{ $employee->nationality }}">
                                    </div>
                                </div>
                                <div class="uk-form-row">
                                    <label class="uk-form-label">
                                        Is Active
                                    </label>
                                    <div class="uk-form-controls">
                                        {{ Form::select('put_active_flag'
                                            , ['Y' =>'Yes', 'N' =>'No']
                                            , $employee->active_flag
                                            , ['class' =>'form-control']) }}
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <div class="uk-text-right form-buttons">
                        <button class="uk-button btn-save" type="submit">
                            <span class="uk-icon uk-icon-edit">
                            </span>
                            Save
                        </button>
                        <a href="{{ url('employee/employees') }}" class="uk-button uk-modal-close btn-cancel">
                            <span class="uk-icon uk-icon-times-circle">
                            </span>
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- upload photo modal -->
<div id="upload_photo" class="uk-modal">
    <div class="uk-modal-dialog">
        <button class="uk-modal-close uk-close">
        </button>
        <div class="uk-modal-header">
            <span class="uk-icon uk-icon-plus-square">
            </span>
            Upload Photo
        </div>
        <form role="form"  method="post" action="{{ url('employee/uploadimg/'. $employee->employee_id) }}" class="uk-form uk-form-horizontal" enctype="multipart/form-data">
            {{ csrf_field() }}
            <fieldset>
                <div class="uk-form-row">
                    <label class="uk-form-label">Select File</label>
                    <div class="uk-form-controls">
                        <div class="uk-form-file" value="">
                            <button class="uk-button"><span class="uk-icon-file"></span>Select</button>
                            <input id="upload-select" type="file" name="image" onchange="setFilename()">
                            <label id="filename" value="gg"> </label>
                        </div>
                    </div>                    
                </div>
                <div class="uk-modal-footer uk-text-right form-buttons">
                    <button type="submit" class="uk-button btn-save" type="submit">
                        <span class="uk-icon uk-icon-edit">
                        </span>
                        Submit
                    </button>
                    <button type="button" class="uk-button uk-modal-close btn-cancel" type="submit">
                        <span class="uk-icon uk-icon-times-circle">
                            Cancel
                        </button>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts')

<script type="text/javascript" language="javascript">
    function setFilename()
    {
        var filename = document.getElementById('upload-select').value;
        document.getElementById('filename').value = filename;
    }
</script>
@endsection
