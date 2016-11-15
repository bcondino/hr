@extends('shared._public')
@section('title', 'Profile: Employment Details')
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
                    <li> <a href="{{ url('employee/basicinformation/'. $employee->employee_id) }}"> Basic Information </a> </li>
                    <li><a href="{{ url('employee/contactinformation/'. $employee->employee_id) }}"> Contact Information </a> </li>
                    <li class="uk-active"><a href="{{ url('employee/employmentdetails/'. $employee->employee_id) }}"> Employment Details </a> </li>
                    <li><a href="{{ url('employee/governmentdetails/'. $employee->employee_id) }}"> Government Details </a> </li>
                    <li><a href="{{ url('employee/dependent/'. $employee->employee_id) }}"> Dependent </a> </li>
                    <li><a href="{{ url('employee/educbackground/'. $employee->employee_id) }}"> Educational Background </a> </li>
                    <li><a href="{{ url('employee/employmenthistory/'. $employee->employee_id) }}"> Employment History </a> </li>
                </ul>
            </div>
            <!--
                list company setup
            -->
            <!-- employment details -->
            <div class="uk-width" style="width:75%;">
                
                <!-- alerts -->
                @if(Session::has('put-success'))
                <div class="uk-alert uk-alert-success">
                    <span class="uk-icon uk-icon-check">
                    </span>
                    {{ Session::get('put-success') }}
                </div>
                @endif

            <form class="uk-form uk-form-horizontal" method="post" action="{{ url('employee/employmentdetails/'. $employee->employee_id) }}">
                {{ csrf_field() }}
                {{ Form::hidden('_method', 'put') }}
                <div class="uk-grid">
                    <div class="uk-width-1-2">
                        <fieldset>
                            <div class="uk-form-row">
                                <label class="uk-form-label">
                                    Employment Type
                                </label>
                                <div class="uk-form-controls">
                                    {{ Form::select('put_emp_type_id'
                                    ,  $emp_type
                                            ->lists('emp_type_name', 'emp_type_id')
                                            ->toArray()
                                    , $employee->emp_type_id
                                    , ['class' =>'form-control']) }}
                                </div>
                            </div>
                            <div class="uk-form-row">
                                <label class="uk-form-label">
                                    Date Hired
                                </label>
                                <div class="uk-form-controls date-calendar" data-uk-form-select>
                                    <span class="uk-icon-calendar">
                                    </span>
                                    <input class="form-control" type="text" name="put_date_hired" data-uk-datepicker="{format:'DD/MM/YYYY'}" value="{{ $employee->date_hired }}">
                                </div>
                            </div>
                            <div class="uk-form-row">
                                <label class="uk-form-label">
                                    Date Regular
                                </label>
                                <div class="uk-form-controls date-calendar" data-uk-form-select>
                                    <span class="uk-icon-calendar">
                                    </span>
                                    <input class="form-control" type="text" name="put_date_regular" data-uk-datepicker="{format:'DD/MM/YYYY'}" value="{{ $employee->date_regular }}">
                                </div>
                            </div>
                            <div class="uk-form-row">
                                <label class="uk-form-label">
                                    Payroll Group
                                </label>
                                <div class="uk-form-controls date-calendar" data-uk-form-select>
                                    {{ Form::select('put_payroll_group_id'
                                        , [null => '-- Select --'] + 
                                            $emp_pay_group
                                                ->lists('description', 'payroll_group_id')
                                                ->toArray()
                                        , $employee->payroll_group_id
                                        , ['class' => 'form-control']) }}
                                </div>
                            </div>
                        </div>
                        <!--
                            first column
                        -->
                        <div class="uk-width-1-2">
                            <div class="uk-form-row">
                                <label class="uk-form-label">
                                    Position
                                </label>
                                <div class="uk-form-controls">
                                    {{ Form::select('put_position_id'
                                        , [null => '-- Select --'] + 
                                            $emp_pos
                                                ->lists('description', 'position_id')
                                                ->toArray()
                                        , $employee->position_id
                                        , ['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class="uk-form-row">
                                <label class="uk-form-label">
                                    Business Unit
                                </label>
                                <div class="uk-form-controls">
                                    @if($employee->
                                    position_id == null)
                                    <input type="text" value="" disabled/>
                                    @else
                                    <input type="text" value="{{ \App\tbl_business_unit_model::where('business_unit_id',  \App\tbl_position_model::where('position_id', $employee->position_id)->first()->business_unit_id)->first()->business_unit_name }}" disabled/>
                                    @endif
                                </div>
                            </div>
                            <div class="uk-form-row">
                                <label class="uk-form-label">
                                    Salary Grade
                                </label>
                                <div class="uk-form-controls">
                                    @if($employee->
                                    position_id == null)
                                    <input type="text" value="" disabled/>
                                    @else
                                    <input type="text" value="{{ \App\tbl_salary_grade_model::where('grade_id',  \App\tbl_position_model::where('position_id', $employee->position_id)->first()->grade_id)->first()->grade_name }}" disabled/>
                                    @endif
                                </div>
                            </div>
                            <div class="uk-form-row">
                                <label class="uk-form-label">
                                    Classification
                                </label>
                                <div class="uk-form-controls">
                                    @if($employee->
                                    position_id == null)
                                    <input type="text" value="" disabled/>
                                    @else
                                    <input type="text" value="{{ \App\tbl_classification_model::where('class_id',  \App\tbl_position_model::where('position_id', $employee->position_id)->first()->class_id)->first()->class_name }}" disabled/>
                                    @endif
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
                    <a href="{{ url('employee/employees') }}"class="uk-button uk-modal-close btn-cancel">
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
@endsection
@section('scripts')
@endsection
