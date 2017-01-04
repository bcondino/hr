<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
 */

// update bry check if the user has session
Route::get('/'
	, function () {
		if (Auth::check()) {
			return redirect('/home');
		} else {
			return redirect('auth/login');
		}
	}
);

// Route::get('auth/verify/{email_address}', 'Auth\AuthController@resend_verification');
// Route::get('auth/verify/activate/{email_address}', 'Auth\AuthController@activate_verification');

// Controller for authentication
Route::controller('auth', 'Auth\AuthController');

// if the user is not logged he cannot access links in the route and will be redirect to /auth/login page
Route::group(['middleware' => ['auth']], function () {
	// business structure - primary setup
	Route::get('treeview/treeviewcompany/{company_id}', 'TreeView@treeviewCompany');
	Route::resource('treeview', 'TreeView');

	// business structure - company setup
	Route::get('companies/business_structure/{company_id}', function ($company_id) {
		$company = \App\tbl_company_model::find($company_id);
		return view('main.company_setup.businessstructure', ['company' => $company]);
	});

	Route::get('cancel/{company_id}', 'Wiz2Controller@cancel');

	//Payroll Process
	Route::get('payroll/payrollmgt/{company_id}/payroll_process', 'PayrollController@view_PayrollProcess');
	//Payroll Process Details
	Route::get('payroll/payrollmgt/{company_id}/payroll_process_det/{payroll_process_id}', 'PayrollController@view_PayrollProcessDetails');
	//Payroll Process Employee details
	Route::get('payroll/payrollmgt/{company_id}/payroll_process_emp/{payroll_process_id}/{employee_id}', 'PayrollController@view_PayrollProcessEmpDetails');
	Route::post('payroll/payrollmgt/{company_id}/payroll_process/post', 'PayrollController@add_PayrollProcess');

	Route::get('payrollmanagement/recurring', 'PayrollManagementController@recurring');
	/* 20161028 added below lines by Melvin Militante
		-Reason: Reports UI integration
	*/
	Route::get('payrollmanagement/repdetail', 'PayrollManagementController@repdetail');
	Route::get('payrollmanagement/repparam', 'PayrollManagementController@repparam');
	/* 20161028 end of addition */
	Route::get('payrollmanagement/nonRecurringPayrollMode', 'PayrollManagementController@nonRecurringPayrollMode');
	Route::get('payrollmanagement/nonRecurringYear', 'PayrollManagementController@nonRecurringYear');
	Route::get('payrollmanagement/nonRecurringPayPeriod', 'PayrollManagementController@nonRecurringPayPeriod');
	Route::get('payrollmanagement/payrollperiod', 'PayrollManagementController@payrollperiod');

	Route::controller('wiz2', 'Wiz2Controller');
	Route::controller('home', 'HomeController');
	Route::controller('admin', 'AdminController');
	Route::controller('configuration', 'ConfigurationController');
	Route::controller('companies', 'CompaniesController');
	Route::controller('users', 'UsersController');
	Route::controller('employee', 'EmployeeController');
	Route::controller('payroll', 'PayrollController');
	Route::controller('payrollmanagement', 'PayrollManagementController');
});

/* 20161014 update from Carlo Mendoza
-Reason: For reports
 */
Route::get('ui', 'ReportsController@getUi');
Route::post('/forms', 'ReportsController@ProcessForm');
Route::controller('reports', 'ReportsController');
/* 20160114 end of update from Carlo

/* 20161014 updated by Melvin Militante
-Reason: To direct the page to UI made by Carlo. Will be removed
once the plan for the process and design of UI is final.
 */
Route::get('sample', function () {
	return view('ui');
});
/* 20161014 end of update */
