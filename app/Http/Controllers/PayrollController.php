<?php

namespace App\Http\Controllers;

use App\tbl_employee_model;
use App\tbl_overtime_model;
use App\tbl_pagibig_model;
use App\tbl_payroll_disbursement_model;
use App\tbl_payroll_element_model;
use App\tbl_payroll_group_model;
use App\tbl_payroll_mode_model;
use App\tbl_payroll_parameter_model;
use App\tbl_payroll_period_model;
use App\tbl_payroll_signatory_model;
use App\tbl_philhealth_model;
use App\tbl_sss_model;
use App\tbl_tax_annual_model;
use App\tbl_tax_code_model;
use App\tbl_tax_model;
use App\tbl_tax_mode_model;
use App\tbl_wage_order_model;
use Illuminate\Http\Request;
use Session;
use Validator;
use DB;

class PayrollController extends Controller
{
    public function getTaxexemption()
    {
        $tax_codes = tbl_tax_code_model::
            where('company_id', $this->currentCompany->company_id)
            ->where('active_flag', 'Y')
            ->orderBy('exemption_amount')
            ->orderBy('tax_code')
            ->get();
        return view('main.payroll.tax_exemption', ['tax_codes' => $tax_codes]);
    }

    public function postTaxexemption(Request $request)
    {
        $post_taxExemp_rule = [
            'tax_code'         => 'required',
            'description'      => 'required',
            'exemption_amount' => 'required'];
        $post_taxExemp_msg = [
            'tax_code.required'         => 'Tax code is a required field.',
            'description.required'      => 'Description is a required field.',
            'exemption_amount.required' => 'Exemption amount is a required field.'];
        $validator = Validator::make($request->all(), $post_taxExemp_rule, $post_taxExemp_msg);
        if ($validator->fails()) {
            Session::flash('add-failed', 'Failed to add input details!');
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            tbl_tax_code_model::create([
                'tax_code'         => $request->tax_code,
                'description'      => $request->description,
                'exemption_amount' => $request->exemption_amount,
                'company_id'       => $this->currentCompany->company_id,
                'created_by'       => $this->currentUser->user_id,
                'updated_by'       => $this->currentUser->user_id,
            ]);
            Session::flash('add-success', 'New tax exemption has been added successfully!');
            return redirect()->back();
        }
    }

    public function putTaxexemption(Request $request)
    {
        if ($request->isDelete) {
            if (count($request->tax_exemption) > 0) {
                foreach ($request->tax_exemption as $tax_exemption) {
                    tbl_tax_code_model::find($tax_exemption)->update([
                        'active_flag' => 'N',
                        'updated_by'  => $this->currentUser->user_id,
                    ]);
                }
                Session::flash('del-success', 'Records selected have been deleted successfully.');
            } else {
                Session::flash('del-warning', 'No selected records found! Nothing to delete.');
            }
        } else {
            $update_taxExemp_rule = [
                'tax_code'         => 'required',
                'description'      => 'required',
                'exemption_amount' => 'required'];
            $update_taxExemp_msg = [
                'tax_code.required'         => 'Tax code is a required field.',
                'description.required'      => 'Description is a required field.',
                'exemption_amount.required' => 'Exemption amount is a required field.'];
            $validator = Validator::make($request->all(), $update_taxExemp_rule, $update_taxExemp_msg);
            if ($validator->fails()) {
                Session::flash('edit-failed', 'Failed to update input details!');
                return redirect()->back()->withErrors($validator)->withInput();
            } else {
                tbl_tax_code_model::where('tax_code_id', $request->tax_codes)->update([
                    'tax_code'         => $request->tax_code,
                    'description'      => $request->description,
                    'exemption_amount' => $request->exemption_amount,
                    'updated_by'       => $this->currentUser->user_id,
                ]);
                Session::flash('edit-success', 'A tax exemption item has been updated successfully!');
            }
        }
        return redirect()->back();
    }

    public function getTaxtable()
    {
        $taxs = tbl_tax_model::
            where('company_id', $this->currentCompany->company_id)
            ->where('active_flag', 'Y')
            ->orderBy('tax_mode')
            ->orderBy('tax_code')
            ->get();
        return view('main.payroll.tax_table', ['taxs' => $taxs]);
    }

    public function postTaxtable(Request $request)
    {
        $post_taxTbl_rule = [
            'tax_mode'   => 'required',
            'tax_code'   => 'required',
            'range_from' => 'required',
            'range_to'   => 'required',
            'percentage' => 'required',
            'fix_amount' => 'required'];
        $post_taxTbl_msg = [
            'tax_mode.required'   => 'Tax mode is a required field.',
            'tax_code.required'   => 'Tax code is a required field.',
            'range_from.required' => 'Range-from is a required field.',
            'range_to.required'   => 'Range-to is a required field.',
            'percentage.required' => 'Percentage  is a required field.',
            'fix_amount.required' => 'Fix amount is a required field.'];
        $validator = Validator::make($request->all(), $post_taxTbl_rule, $post_taxTbl_msg);
        if ($validator->fails()) {
            Session::flash('add-failed', 'Failed to add input details!');
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            tbl_tax_model::create([
                'tax_mode'   => $request->tax_mode,
                'tax_code'   => $request->tax_code,
                'range_from' => $request->range_from,
                'range_to'   => $request->range_to,
                'percentage' => $request->percentage,
                'fix_amount' => $request->fix_amount,
                'created_by' => $this->currentUser->user_id,
                'updated_by' => $this->currentUser->user_id,
                'company_id' => $this->currentCompany->company_id,
            ]);
            Session::flash('add-success', 'New tax item has been added successfully!');
            return redirect()->back();
        }
    } //end of function

    public function putTaxtable(Request $request)
    {
        if ($request->isDelete) {
            if (count($request->tax_table) > 0) {
                foreach ($request->tax_table as $tax_tbl) {
                    tbl_tax_model::find($tax_tbl)->update([
                        'active_flag' => 'N',
                        'updated_by'  => $this->currentUser->user_id,
                    ]);
                }
                Session::flash('del-success', 'Records selected have been deleted successfully.');
            } else {
                Session::flash('del-warning', 'No selected records found! Nothing to delete.');
            }
        } else {
            $update_taxTbl_rule = [
                'tax_mode'   => 'required',
                'tax_code'   => 'required',
                'range_from' => 'required',
                'range_to'   => 'required',
                'percentage' => 'required'];
            $update_taxTbl_msg = [
                'tax_mode.required'   => 'Tax mode is a required field.',
                'tax_code.required'   => 'Tax code is a required field.',
                'range_from.required' => 'Range-from is a required field.',
                'range_to.required'   => 'Range-to is a required field.',
                'percentage.required' => 'Percentage  is a required field.'];
            $validator = Validator::make($request->all(), $update_taxTbl_rule, $update_taxTbl_msg);
            if ($validator->fails()) {
                Session::flash('edit-failed', 'Failed to edit input details!');
                return redirect()->back()->withErrors($validator)->withInput();
            } else {
                tbl_tax_model::where('tax_id', $request->edit_tax)->update([
                    'tax_mode'   => $request->tax_mode,
                    'tax_code'   => $request->tax_code,
                    'range_from' => $request->range_from,
                    'range_to'   => $request->range_to,
                    'percentage' => $request->percentage,
                    'fix_amount' => $request->fix_amount,
                    'updated_by' => $this->currentUser->user_id,
                ]);
                Session::flash('edit-success', 'A tax item has been updated successfully!');
            }
        }
        return redirect()->back();
    } //end of function

    public function getAnnualtaxtable()
    {
        $tax_annuals = tbl_tax_annual_model::
            where('company_id', $this->currentCompany->company_id)
            ->where('active_flag', 'Y')
            ->orderBy('range_from')
            ->get();
        return view('main.payroll.annual_tax_table', ['tax_annuals' => $tax_annuals]);
    }

    public function postAnnualtaxtable(Request $request)
    {
        $post_annualTax_rule = [
            'range_from' => 'required',
            'range_to'   => 'required',
            'percentage' => 'required',
            'fix_amount' => 'required'];
        $post_annualTax_msg = [
            'range_from.required' => 'Range-from is a required field.',
            'range_to.required'   => 'Range-to is a required field.',
            'percentage.required' => 'Percentage  is a required field.',
            'fix_amount.required' => 'Fix amount is a required field.'];
        $validator = Validator::make($request->all(), $post_annualTax_rule, $post_annualTax_msg);
        if ($validator->fails()) {
            $request->session()->flash('add-failed', 'Failed to add input details!');
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            tbl_tax_annual_model::create([
                'range_from' => $request->range_from,
                'range_to'   => $request->range_to,
                'percentage' => $request->percentage,
                'fix_amount' => $request->fix_amount,
                'created_by' => $this->currentUser->user_id,
                'updated_by' => $this->currentUser->user_id,
                'company_id' => $this->currentCompany->company_id,
            ]);
            Session::flash('add-success', 'A new annual tax item has been added successfully!');
            return redirect()->back();
        }
    } //end of function

    public function putAnnualtaxtable(Request $request)
    {
        if ($request->isDelete) {
            if (count($request->annual_tax) > 0) {
                foreach ($request->annual_tax as $annualTax) {
                    tbl_tax_annual_model::find($annualTax)->update([
                        'active_flag' => 'N',
                        'updated_by'  => $this->currentUser->user_id,
                    ]);
                }
                Session::flash('del-success', 'Records selected have been deleted successfully.');
            } else {
                Session::flash('del-warning', 'No selected records found! Nothing to delete.');
            }
        } else {
            $update_annualTax_rule = [
                'range_from' => 'required',
                'range_to'   => 'required',
                'percentage' => 'required',
                'fix_amount' => 'required'];
            $update_annualTax_msg = [
                'range_from.required' => 'Range-from is a required field.',
                'range_to.required'   => 'Range-to is a required field.',
                'percentage.required' => 'Percentage  is a required field.',
                'fix_amount.required' => 'Fix amount is a required field.'];
            $validator = Validator::make($request->all(), $update_annualTax_rule, $update_annualTax_msg);
            if ($validator->fails()) {
                Session::flash('edit-failed', 'Failed to edit input details!');
                return redirect()->back()->withErrors($validator)->withInput();
            } else {
                tbl_tax_annual_model::where('tax_annual_id', $request->annual_tax)->update([
                    'range_from' => $request->range_from,
                    'range_to'   => $request->range_to,
                    'percentage' => $request->percentage,
                    'fix_amount' => $request->fix_amount,
                    'updated_by' => $this->currentUser->user_id,
                ]);
                Session::flash('edit-success', 'An annual tax item has been updated successfully!');
            }
        }
        return redirect()->back();
    }

    public function getSsstable()
    {
        $ssss = tbl_sss_model::
            where('company_id', $this->currentCompany->company_id)
            ->where('active_flag', 'Y')
            ->orderBy('range_from')
            ->get();
        return view('main.payroll.sss_table', ['ssss' => $ssss]);
    }
    public function postSsstable(Request $request)
    {
        $post_sssTbl_rule = [
            'range_from'  => 'required',
            'range_to'    => 'required',
            'ee_sss_cont' => 'required',
            'er_sss_cont' => 'required',
            'er_ec_cont'  => 'required'];
        $post_sssTbl_msg = [
            'range_from.required'  => 'Range-from is a required field.',
            'range_to.required'    => 'Range-to is a required field.',
            'ee_sss_cont.required' => 'Employee contribution is a required field.',
            'er_sss_cont.required' => 'Employer contribution is a required field.',
            'er_ec_cont.required'  => 'Employer EC contribution is a required field.'];
        $validator = Validator::make($request->all(), $post_sssTbl_rule, $post_sssTbl_msg);
        if ($validator->fails()) {
            Session::flash('add-failed', 'Failed to add input details!');
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            tbl_sss_model::create([
                'range_from'  => $request->range_from,
                'range_to'    => $request->range_to,
                'ee_sss_cont' => $request->ee_sss_cont,
                'er_sss_cont' => $request->er_sss_cont,
                'er_ec_cont'  => $request->er_ec_cont,
                'created_by'  => $this->currentUser->user_id,
                'updated_by'  => $this->currentUser->user_id,
                'company_id'  => $this->currentCompany->company_id,
            ]);
            Session::flash('add-success', 'New SSS item has been added successfully!');
            return redirect()->back();
        }
    } //end of function

    public function putSsstable(Request $request)
    {
        if ($request->isDelete) {
            if (count($request->sss_table) > 0) {
                foreach ($request->sss_table as $sss_tbl) {
                    tbl_sss_model::find($sss_tbl)->update([
                        'active_flag' => 'N',
                        'updated_by'  => $this->currentUser->user_id,
                    ]);
                }
                Session::flash('del-success', 'Records selected have been deleted successfully.');
            } else {
                Session::flash('del-warning', 'No selected records found! Nothing to delete.');
            }
        } else {
            $update_sssTbl_rule = [
                'range_from'  => 'required',
                'range_to'    => 'required',
                'ee_sss_cont' => 'required',
                'er_sss_cont' => 'required',
                'er_ec_cont'  => 'required'];
            $update_sssTbl_msg = [
                'range_from.required'  => 'Range-from is a required field.',
                'range_to.required'    => 'Range-to is a required field.',
                'ee_sss_cont.required' => 'Employee contribution is a required field.',
                'er_sss_cont.required' => 'Employer contribution is a required field.',
                'er_ec_cont.required'  => 'Employer EC contribution is a required field.'];
            $validator = Validator::make($request->all(), $update_sssTbl_rule, $update_sssTbl_msg);
            if ($validator->fails()) {
                Session::flash('edit-failed', 'Failed to edit input details!');
                return redirect()->back()->withErrors($validator)->withInput();
            } else {
                tbl_sss_model::where('sss_id', $request->sss)->update([
                    'range_from'  => $request->range_from,
                    'range_to'    => $request->range_to,
                    'ee_sss_cont' => $request->ee_sss_cont,
                    'er_sss_cont' => $request->er_sss_cont,
                    'er_ec_cont'  => $request->er_ec_cont,
                    'updated_by'  => $this->currentUser->user_id,
                ]);
                Session::flash('edit-success', 'SSS item has been updated successfully!');
            }
        }
        return redirect()->back();
    }

    public function getPagibigtable()
    {
        $pagibigs = tbl_pagibig_model::
            where('company_id', $this->currentCompany->company_id)
            ->where('active_flag', 'Y')
            ->orderBy('range_from')
            ->get();
        return view('main.payroll.pagibig_table', ['pagibigs' => $pagibigs]);
    }
    public function postPagibigtable(Request $request)
    {
        $post_pagibigTbl_rule = [
            'range_from'      => 'required',
            'range_to'        => 'required',
            'ee_cont'         => 'required',
            'er_cont'         => 'required',
            'ee_cont_percent' => 'required',
            'er_cont_percent' => 'required'];
        $post_pagibigTbl_msg = [
            'range_from.required'      => 'Range-from is a required field.',
            'range_to.required'        => 'Range-to is a required field.',
            'ee_cont.required'         => 'Employee contribution is a required field.',
            'er_cont.required'         => 'Employer contribution is a required field.',
            'ee_cont_percent.required' => 'Employee  contribution % is a required field.',
            'er_cont_percent.required' => 'Employer contribution % is a required field.'];
        $validator = Validator::make($request->all(), $post_pagibigTbl_rule, $post_pagibigTbl_msg);
        if ($validator->fails()) {
            Session::flash('add-failed', 'Failed to add new item details!');
            return redirect()->back()->withErrors($validator)->withInput();
        } else {

            tbl_pagibig_model::create([
                'range_from'      => $request->range_from,
                'range_to'        => $request->range_to,
                'ee_cont'         => $request->ee_cont,
                'er_cont'         => $request->er_cont,
                'ee_cont_percent' => $request->ee_cont_percent,
                'er_cont_percent' => $request->er_cont_percent,
                'created_by'      => $this->currentUser->user_id,
                'updated_by'      => $this->currentUser->user_id,
                'company_id'      => $this->currentCompany->company_id,
            ]);
            Session::flash('edit success', 'New Pagibig item has been added successfully!');
            return redirect()->back();
        }
    } //end of function

    public function putPagibigtable(Request $request)
    {
        if ($request->isDelete) {
            if (count($request->pagibig_tbl) > 0) {
                foreach ($request->pagibig_tbl as $pagibig_tbl) {
                    tbl_pagibig_model::find($pagibig_tbl)->update([
                        'active_flag' => 'N',
                        'updated_by'  => $this->currentUser->user_id,
                    ]);
                }
                Session::flash('del-success', 'Records selected have been deleted successfully.');
            } else {
                Session::flash('del-warning', 'No selected records found! Nothing to delete.');
            }
        } else {
            $update_pagibigTbl_rule = [
                'range_from'      => 'required',
                'range_to'        => 'required',
                'ee_cont'         => 'required',
                'er_cont'         => 'required',
                'ee_cont_percent' => 'required',
                'er_cont_percent' => 'required'];
            $update_pagibigTbl_msg = [
                'range_from.required'      => 'Range-from is a required field.',
                'range_to.required'        => 'Range-to is a required field.',
                'ee_cont.required'         => 'Employee contribution is a required field.',
                'er_cont.required'         => 'Employer contribution is a required field.',
                'ee_cont_percent.required' => 'Employee  contribution % is a required field.',
                'er_cont_percent.required' => 'Employer contribution % is a required field.'];
            $validator = Validator::make($request->all(), $update_pagibigTbl_rule, $update_pagibigTbl_msg);
            if ($validator->fails()) {
                $request->session()->flash('edit-failed', 'Failed to update item details!');
                return redirect()->back()->withErrors($validator)->withInput();
            } else {
                tbl_pagibig_model::where('pagibig_id', $request->pagibig)->update([
                    'range_from'      => $request->range_from,
                    'range_to'        => $request->range_to,
                    'ee_cont'         => $request->ee_cont,
                    'er_cont'         => $request->er_cont,
                    'ee_cont_percent' => $request->ee_cont_percent,
                    'er_cont_percent' => $request->er_cont_percent,
                    'updated_by'      => $this->currentUser->user_id,
                ]);
                Session::flash('edit-success', 'Pagibig item has been updated successfully!');
            }
        }
        return redirect()->back();
    }

    public function getPhilhealthtable()
    {
        $philhealths = tbl_philhealth_model::
            where('company_id', $this->currentCompany->company_id)
            ->where('active_flag', 'Y')
            ->orderBy('msb')
            ->get();
        return view('main.payroll.philhealth_table', ['philhealths' => $philhealths]);
    }
    public function postPhilhealthtable(Request $request)
    {
        $post_philhealthTbl_rule = [
            'msb'         => 'required',
            'range_from'  => 'required',
            'range_to'    => 'required',
            'salary_base' => 'required',
            'ee_cont'     => 'required',
            'er_cont'     => 'required'];
        $post_philhealthTbl_msg = [
            'msb.required'         => 'Monthly salary bracket is a required field.',
            'range_from.required'  => 'Range-from is a required field.',
            'range_to.required'    => 'Range-to is a required field.',
            'salary_base.required' => 'Salary base is a required field.',
            'ee_cont.required'     => 'Employee contribution is a required field.',
            'er_cont.required'     => 'Employer contribution is a required field.'];
        $validator = Validator::make($request->all(), $post_philhealthTbl_rule, $post_philhealthTbl_msg);
        if ($validator->fails()) {
            $request->session()->flash('add-failed', 'Failed to add new item details!');
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            tbl_philhealth_model::create([
                'range_from'  => $request->range_from,
                'range_to'    => $request->range_to,
                'salary_base' => $request->salary_base,
                'ee_cont'     => $request->ee_cont,
                'er_cont'     => $request->er_cont,
                'msb'         => $request->msb,
                'created_by'  => $this->currentUser->user_id,
                'updated_by'  => $this->currentUser->user_id,
                'company_id'  => $this->currentCompany->company_id,
            ]);
            Session::flash('add-success', 'New Philhealth item has been added successfully!');
            return redirect()->back();
        }

    } //end of function
    public function putPhilhealthtable(Request $request)
    {
        if ($request->isDelete) {
            if (count($request->philhealth_tbl) > 0) {
                foreach ($request->philhealth_tbl as $philhealth_tbl) {
                    tbl_philhealth_model::find($philhealth_tbl)->update([
                        'active_flag' => 'N',
                        'updated_by'  => $this->currentUser->user_id,
                    ]);
                }
                Session::flash('del-success', 'Records selected have been deleted successfully.');
            } else {
                Session::flash('del-warning', 'No selected records found! Nothing to delete.');
            }
        } else {
            $update_philhealthTbl_rule = [
                'msb'         => 'required',
                'range_from'  => 'required',
                'range_to'    => 'required',
                'salary_base' => 'required',
                'ee_cont'     => 'required',
                'er_cont'     => 'required'];
            $update_philhealthTbl_msg = [
                'msb.required'         => 'Monthly salary bracket is a required field.',
                'range_from.required'  => 'Range-from is a required field.',
                'range_to.required'    => 'Range-to is a required field.',
                'salary_base.required' => 'Salary base is a required field.',
                'ee_cont.required'     => 'Employee contribution is a required field.',
                'er_cont.required'     => 'Employer contribution is a required field.'];
            $validator = Validator::make($request->all(), $update_philhealthTbl_rule, $update_philhealthTbl_msg);
            if ($validator->fails()) {
                $request->session()->flash('edit-failed', 'Failed to update item details!');
                return redirect()->back()->withErrors($validator)->withInput();
            } else {
                tbl_philhealth_model::where('philhealth_id', $request->philhealth)->update([
                    'range_from'  => $request->range_from,
                    'range_to'    => $request->range_to,
                    'salary_base' => $request->salary_base,
                    'ee_cont'     => $request->ee_cont,
                    'er_cont'     => $request->er_cont,
                    'msb'         => $request->msb,
                    'updated_by'  => $this->currentUser->user_id,
                ]);
                Session::flash('edit-success', 'An item has been updated successfully!');
            }
        }
        return redirect()->back();
    }

    public function getPaymentdisbursement()
    {
        $payroll_disbursements = tbl_payroll_disbursement_model::
            where('company_id', $this->currentCompany->company_id)
            ->where('active_flag', 'Y')
            ->orderBy('payroll_disb_code')
            ->get();
        return view('main.payroll.payment_disbursement', ['payroll_disbursements' => $payroll_disbursements]);
    }
    public function postPaymentdisbursement(Request $request)
    {
        $post_payDisbTbl_rule = [
            'payroll_disb_code' => 'required',
            'bank_name'         => 'required',
            'account_number'    => 'required',
            'company_code'      => 'required',
            'branch_code'       => 'required',
            'default_file_name' => 'required'];
        $post_payDisbTbl_msg = [
            'payroll_disb_code.required' => 'Payroll Disbursement Code is a required field.',
            'bank_name.required'         => 'Bank name is a required field.',
            'account_number.required'    => 'Account number is a required field.',
            'company_code.required'      => 'Company Code is a required field.',
            'branch_code.required'       => 'Branch Code is a required field.',
            'default_file_name.required' => 'Default file name is a required field.'];
        $validator = Validator::make($request->all(), $post_payDisbTbl_rule, $post_payDisbTbl_msg);
        if ($validator->fails()) {
            $request->session()->flash('add-failed', 'Failed to add new item details!');
            return redirect()->back()->withErrors($validator)->withInput();
        } else {

            tbl_payroll_disbursement_model::create([

                'payroll_disb_code'    => $request->payroll_disb_code,
                'bank_name'            => $request->bank_name,
                'account_number'       => $request->account_number,
                'company_code'         => $request->company_code,
                'branch_code'          => $request->branch_code,
                'default_file_name'    => $request->default_file_name,
                'file_type'            => $request->file_type,
                'data_type_dictionary' => $request->data_type_dictionary,
                'header_template'      => $request->header_template,
                'detail_template'      => $request->detail_template,
                'footer_template'      => $request->footer_template,
                'created_by'           => $this->currentUser->user_id,
                'updated_by'           => $this->currentUser->user_id,
                'company_id'           => $this->currentCompany->company_id,
            ]);

            Session::flash('add-success', 'New Payment Disbursement item has been added successfully!');
            return redirect()->back();
        }
    }
    public function putPaymentdisbursement(Request $request)
    {
        if ($request->isDelete) {
            if (count($request->payDisbursement_tbl) > 0) {
                foreach ($request->payDisbursement_tbl as $payDisbursement_tbl) {
                    tbl_payroll_disbursement_model::find($payDisbursement_tbl)->update([
                        'active_flag' => 'N',
                        'updated_by'  => $this->currentUser->user_id,
                    ]);
                }
                Session::flash('del-success', 'Records selected have been deleted successfully.');
            } else {
                Session::flash('del-warning', 'No selected records found! Nothing to delete.');
            }
        } else {
            $update_payDisbTbl_rule = [
                'payroll_disb_code' => 'required',
                'bank_name'         => 'required',
                'account_number'    => 'required',
                'company_code'      => 'required',
                'branch_code'       => 'required',
                'default_file_name' => 'required'];
            $update_payDisbTbl_msg = [
                'payroll_disb_code.required' => 'Payroll Disbursement Code is a required field.',
                'bank_name.required'         => 'Bank name is a required field.',
                'account_number.required'    => 'Account number is a required field.',
                'company_code.required'      => 'Company Code is a required field.',
                'branch_code.required'       => 'Branch Code is a required field.',
                'default_file_name.required' => 'Default file name is a required field.'];
            $validator = Validator::make($request->all(), $update_payDisbTbl_rule, $update_payDisbTbl_msg);
            if ($validator->fails()) {
                Session::flash('add-failed', 'Failed to add new item details!');
                return redirect()->back()->withErrors($validator)->withInput();
            } else {

                tbl_payroll_disbursement_model::where('pay_disb_id', $request->payDisbursements)->update([
                    'payroll_disb_code'    => $request->payroll_disb_code,
                    'bank_name'            => $request->bank_name,
                    'account_number'       => $request->account_number,
                    'company_code'         => $request->company_code,
                    'branch_code'          => $request->branch_code,
                    'default_file_name'    => $request->default_file_name,
                    'file_type'            => $request->file_type,
                    'data_type_dictionary' => $request->data_type_dictionary,
                    'header_template'      => $request->header_template,
                    'detail_template'      => $request->detail_template,
                    'footer_template'      => $request->footer_template,
                    'updated_by'           => $this->currentUser->user_id,
                ]);
                Session::flash('edit-success', 'An item has been updated successfully!');
            }
        }
        return redirect()->back();
    }

    public function getEarnings()
    {
        $earnings = tbl_payroll_element_model::
            where('company_id', $this->currentCompany->company_id)
            ->where('entry_type', 'CR')
            ->where('active_flag', 'Y')
            ->orderBy('description')
            ->get();
        return view('main.payroll.earnings', ['earnings' => $earnings]);
    }

    public function postEarnings(Request $request)
    {
        $post_earningsTbl_rule = [
            'description' => 'required',
        ];
        $post_earningsTbl_msg = [
            'description.required' => 'Element name is a required field.',
        ];
        $validator = Validator::make($request->all(), $post_earningsTbl_rule, $post_earningsTbl_msg);
        if ($validator->fails()) {
            Session::flash('add-failed', 'Failed to add new item details!');
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            tbl_payroll_element_model::create([
                'entry_type'        => 'CR',
                'description'       => $request->description,
                'tran_code'         => $request->tran_code,
                'taxable_flag'      => $request->taxable_flag,
                'regular_flag'      => $request->regular_flag,
                'tax_exempt_flag'   => $request->tax_exempt_flag,
                'fb_tax_flag'       => $request->fb_tax_flag,
                'deminimis_flag'    => $request->deminimis_flag,
                'sss_flag'          => $request->sss_flag,
                'pagibig_flag'      => $request->regular_flag,
                'philhealth_flag'   => $request->philhealth_flag,
                'loan_flag'         => $request->loan_flag,
                'show_payslip'      => $request->show_payslip,
                'gsis_flag'         => 'N',
                'per_employee_flag' => 'N',
                'predefine_flag'    => 'N',
                'priority_no'       => '0',
                'created_by'        => $this->currentUser->user_id,
                'updated_by'        => $this->currentUser->user_id,
                'payroll_element_id' => $this->returnPayrollelementid($this->currentCompany->company_id),
                'company_id'        => $this->currentCompany->company_id,
            ]);
            Session::flash('add-success', 'New Earnings has been added successfully!');
            return redirect()->back();
        }
    }

    public function putEarnings(Request $request)
    {
        if ($request->isDelete) {
            if (count($request->earnings_tbl) > 0) {
                foreach ($request->earnings_tbl as $earnings_tbl) {
                    tbl_payroll_element_model::find($earnings_tbl)->update([
                        'active_flag' => 'N',
                        'updated_by'  => $this->currentUser->user_id,
                    ]);
                }
                Session::flash('del-success', 'Records selected have been deleted successfully.');
            } else {
                Session::flash('del-warning', 'No selected records found! Nothing to delete.');
            }
        } else {
            $update_earningsTbl_rule = [
                'description' => 'required',
            ];
            $update_earningsTbl_msg = [
                'description.required' => 'Element name is a required field.',
            ];
            $validator = Validator::make($request->all(), $update_earningsTbl_rule, $update_earningsTbl_msg);
            if ($validator->fails()) {
                $request->session()->flash('edit-failed', 'Failed to update item details!');
                return redirect()->back()->withErrors($validator)->withInput();
            } else {
                tbl_payroll_element_model::where('payroll_element_id', $request->earning_s)->update([
                    'description'     => $request->description,
                    'tran_code'       => $request->tran_code,
                    'taxable_flag'    => $request->taxable_flag,
                    'regular_flag'    => $request->regular_flag,
                    'tax_exempt_flag' => $request->tax_exempt_flag,
                    'fb_tax_flag'     => $request->fb_tax_flag,
                    'deminimis_flag'  => $request->deminimis_flag,
                    'sss_flag'        => $request->sss_flag,
                    'pagibig_flag'    => $request->regular_flag,
                    'philhealth_flag' => $request->philhealth_flag,
                    'loan_flag'       => $request->loan_flag,
                    'show_payslip'    => $request->show_payslip,
                    'updated_by'      => $this->currentUser->user_id,
                ]);
                Session::flash('edit-success', 'An item has been updated successfully!');
            }
        }
        return redirect()->back();
    }

    public function getDeductions()
    {
        $deductions = tbl_payroll_element_model::
            where('company_id', $this->currentCompany->company_id)
            ->where('entry_type', 'DB')
            ->where('active_flag', 'Y')
            ->orderBy('description')
            ->get();
        return view('main.payroll.deductions', ['deductions' => $deductions]);
    }

    public function postDeductions(Request $request)
    {
        $post_deductionsTbl_rule = [
            'description' => 'required',
        ];
        $post_deductionsTbl_msg = [
            'description.required' => 'Element name is a required field.',
        ];
        $validator = Validator::make($request->all(), $post_deductionsTbl_rule, $post_deductionsTbl_msg);
        if ($validator->fails()) {
            $request->session()->flash('add-failed', 'Failed to add new item details!');
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            tbl_payroll_element_model::create([
                'entry_type'        => 'DB',
                'description'       => $request->description,
                'tran_code'         => $request->tran_code,
                'taxable_flag'      => $request->taxable_flag,
                'regular_flag'      => $request->regular_flag,
                'tax_exempt_flag'   => $request->tax_exempt_flag,
                'fb_tax_flag'       => $request->fb_tax_flag,
                'deminimis_flag'    => $request->deminimis_flag,
                'sss_flag'          => $request->sss_flag,
                'pagibig_flag'      => $request->regular_flag,
                'philhealth_flag'   => $request->philhealth_flag,
                'loan_flag'         => $request->loan_flag,
                'show_payslip'      => $request->show_payslip,
                'gsis_flag'         => 'N',
                'per_employee_flag' => 'N',
                'predefine_flag'    => 'N',
                'priority_no'       => '0',
                'created_by'        => $this->currentUser->user_id,
                'updated_by'        => $this->currentUser->user_id,
                'payroll_element_id' => $this->returnPayrollelementid($this->currentCompany->company_id),                
                'company_id'        => $this->currentCompany->company_id,
            ]);
            Session::flash('add-success', 'New Deductions has been added successfully!');
            return redirect()->back();
        }
    }

    public function putDeductions(Request $request)
    {
        if ($request->isDelete) {
            if (count($request->deductions_tbl) > 0) {
                foreach ($request->deductions_tbl as $deductions_tbl) {
                    tbl_payroll_element_model::find($deductions_tbl)->update([
                        'active_flag' => 'N',
                        'updated_by'  => $this->currentUser->user_id,
                    ]);
                }
                Session::flash('del-success', 'Records selected have been deleted successfully.');
            } else {
                Session::flash('del-warning', 'No selected records found! Nothing to delete.');
            }
        } else {
            $update_deductionsTbl_rule = [
                'description' => 'required',
            ];
            $update_deductionsTbl_msg = [
                'description.required' => 'Element name is a required field.',
            ];
            $validator = Validator::make($request->all(), $update_deductionsTbl_rule, $update_deductionsTbl_msg);
            if ($validator->fails()) {
                $request->session()->flash('edit-failed', 'Failed to update item details!');
                return redirect()->back()->withErrors($validator)->withInput();
            } else {
                tbl_payroll_element_model::where('payroll_element_id', $request->deduction_s)->update([
                    'description'     => $request->description,
                    'tran_code'       => $request->tran_code,
                    'taxable_flag'    => $request->taxable_flag,
                    'regular_flag'    => $request->regular_flag,
                    'tax_exempt_flag' => $request->tax_exempt_flag,
                    'fb_tax_flag'     => $request->fb_tax_flag,
                    'deminimis_flag'  => $request->deminimis_flag,
                    'sss_flag'        => $request->sss_flag,
                    'pagibig_flag'    => $request->regular_flag,
                    'philhealth_flag' => $request->philhealth_flag,
                    'loan_flag'       => $request->loan_flag,
                    'show_payslip'    => $request->show_payslip,
                    'updated_by'      => $this->currentUser->user_id,
                ]);
                Session::flash('edit-success', 'An item has been updated successfully!');
            }
        }
        return redirect()->back();
    }

    public function getPayrollmode()
    {
        $payroll_modes = tbl_payroll_mode_model::
            where('company_id', $this->currentCompany->company_id)
            ->where('active_flag', 'Y')
            ->orderBy('payroll_mode')
            ->get();
        $tax_modes = tbl_tax_mode_model::
            where('active_flag', 'Y')
            ->orderBy('description')
            ->get();
        return view('main.payroll.payroll_mode', ['payroll_modes' => $payroll_modes, 'tax_modes' => $tax_modes]);
    }
    public function postPayrollmode(Request $request)
    {
        $post_payrollModeTbl_rule = [
            'payroll_mode'  => 'required',
            'description'   => 'required',
            'no_of_payment' => 'required',
            'tax_mode'      => 'required'];
        $post_payrollModeTbl_msg = [
            'payroll_mode.required'  => 'Payroll mode is a required field.',
            'description.required'   => 'Description is a required field.',
            'no_of_payment.required' => 'Number of payment is a required field.',
            'tax_mode.required'      => 'Tax mode is a required field.'];
        $validator = Validator::make($request->all(), $post_payrollModeTbl_rule, $post_payrollModeTbl_msg);
        if ($validator->fails()) {
            $request->session()->flash('add-failed', 'Failed to add new item details!');
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            tbl_payroll_mode_model::create([
                'payroll_mode'  => $request->payroll_mode,
                'description'   => $request->description,
                'no_of_payment' => $request->no_of_payment,
                'tax_mode'      => $request->tax_mode,
                'created_by'    => $this->currentUser->user_id,
                'updated_by'    => $this->currentUser->user_id,
                'company_id'    => $this->currentCompany->company_id,
            ]);
            Session::flash('add-success', 'New Payroll mode item has been added successfully!');
            return redirect()->back();
        }
    }
    public function putPayrollmode(Request $request)
    {
        if ($request->isDelete) {
            if (count($request->payroll_mode_tbl) > 0) {
                foreach ($request->payroll_mode_tbl as $payroll_mode_tbl) {
                    tbl_payroll_mode_model::find($payroll_mode_tbl)->update([
                        'active_flag' => 'N',
                        'updated_by'  => $this->currentUser->user_id,
                    ]);
                }
                Session::flash('del-success', 'Records selected have been deleted successfully.');
            } else {
                Session::flash('del-warning', 'No selected records found! Nothing to delete.');
            }
        } else {
            $update_payrollModeTbl_rule = [
                'payroll_mode'  => 'required',
                'description'   => 'required',
                'no_of_payment' => 'required'];
            $update_payrollModeTbl_msg = [
                'payroll_mode.required'  => 'Payroll mode is a required field.',
                'description.required'   => 'Description is a required field.',
                'no_of_payment.required' => 'Number of payment is a required field.'];
            $validator = Validator::make($request->all(), $update_payrollModeTbl_rule, $update_payrollModeTbl_msg);
            if ($validator->fails()) {
                $request->session()->flash('edit-failed', 'Failed to update item details!');
                return redirect()->back()->withErrors($validator)->withInput();
            } else {
                tbl_payroll_mode_model::where('payroll_mode_id', $request->payroll_modes)->update([
                    'payroll_mode'  => $request->payroll_mode,
                    'description'   => $request->description,
                    'no_of_payment' => $request->no_of_payment,
                    'tax_mode'      => $request->tax_mode,
                    'updated_by'    => $this->currentUser->user_id,
                ]);
                Session::flash('edit-success', 'An item has been updated successfully!');
            }
        }
        return redirect()->back();
    }

    public function getPayrollperiod()
    {
        $payroll_periods = tbl_payroll_period_model::
            where('company_id', $this->currentCompany->company_id)
            ->where('active_flag', 'Y')
            ->orderBy('year')
            ->get();

        $payroll_modes = tbl_payroll_mode_model::
            where('company_id', $this->currentCompany->company_id)
            ->where('active_flag', 'Y')
            ->orderBy('description')
            ->get();
        return view('main.payroll.payroll_period', ['payroll_periods' => $payroll_periods, 'payroll_modes' => $payroll_modes]);
    }

    public function postPayrollperiod(Request $request)
    {
        $post_payrollPeriodTbl_rule = [
            'year'      => 'required',
            'work_days' => 'required',
            'hrs_day'   => 'required',
            'hrs_pay'   => 'required',
            'days_mo'   => 'required',
            'days_yr'   => 'required'];
        $post_payrollPeriodTbl_msg = [
            'year.required'      => 'Year is a required field.',
            'work_days.required' => 'Working days is a required field.',
            'hrs_day.required'   => 'Working hours/day is a required field.',
            'hrs_pay.required'   => 'Working hours/payday is a required field.',
            'days_mo.required'   => 'Working days/month is a required field.',
            'days_yr.required'   => 'Working days/year is a required field.'];
        $validator = Validator::make($request->all(), $post_payrollPeriodTbl_rule, $post_payrollPeriodTbl_msg);
        if ($validator->fails()) {
            $request->session()->flash('add-failed', 'Failed to add new item details!');
            return redirect()->back()->withErrors($validator)->withInput();
        } else {

			/* 20161007 updated by Melvin Militante */
            /*tbl_payroll_period_model::create([
                'year'         => $request->year,
                'payroll_mode' => $request->payroll_mode,
                'work_days'    => $request->work_days,
                'hrs_day'      => $request->hrs_day,
                'hrs_pay'      => $request->hrs_pay,
                'days_mo'      => $request->days_mo,
                'days_yr'      => $request->days_yr,
                'created_by'   => $this->currentUser->user_id,
                'updated_by'   => $this->currentUser->user_id,
                'company_id'   => $this->currentCompany->company_id,
            ]);*/
			
			switch ($request->payroll_mode)
			{
				case "MO":
					for ($x = 1; $x <= 12; $x++) {
						$insert_period[] = ['company_id' => $this->currentCompany->company_id
						, 'payroll_mode' => $request->payroll_mode
						, 'date_from' => $request->year.'-'.$x.'-01'
						, 'date_to' => $request->year.'-'.$x.'-'.date('t',strtotime($request->year.'-'.$x.'-01'))
						, 'year' => $request->year
						, 'month' => $x
						, 'work_days' => $request->work_days
						, 'hrs_day' => $request->hrs_day
						, 'hrs_pay' => $request->hrs_pay
						, 'days_mo' => $request->days_mo
						, 'days_yr' => $request->days_yr
						, 'created_by' => $this->currentUser->user_id
						, 'payroll_period' => 1
						];
					}
					break;
				case "SM":
					for ($x = 1; $x <= 12; $x++) {
						for ($y = 1; $y <= 2; $y++) {
							$insert_period[] = ['company_id' => $this->currentCompany->company_id
							, 'payroll_mode' => $request->payroll_mode
							, 'date_from' => $request->year.'-'.$x.'-'.($y==1? '01' : '16')
							, 'date_to' => $request->year.'-'.$x.'-'.($y==1? '15' : date('t',strtotime($request->year.'-'.$x.'-01')))
							, 'year' => $request->year
							, 'month' => $x
							, 'work_days' => $request->work_days
							, 'hrs_day' => $request->hrs_day
							, 'hrs_pay' => $request->hrs_pay
							, 'days_mo' => $request->days_mo
							, 'days_yr' => $request->days_yr
							, 'created_by' => $this->currentUser->user_id
							, 'payroll_period' => $y
							];
						}
					}
					break;
			}
			
			tbl_payroll_period_model::insert($insert_period);
			/* 20161007 end of update */
			
            Session::flash('add-success', 'New Payroll mode item has been added successfully!');
            return redirect()->back();
        }
    }
    public function putPayrollperiod(Request $request)
    {
        if ($request->isDelete) {
            if (count($request->payroll_period_tbl) > 0) {
                foreach ($request->payroll_period_tbl as $payroll_period_tbl) {
                    tbl_payroll_period_model::find($payroll_period_tbl)->update([
                        'active_flag' => 'N',
                        'updated_by'  => $this->currentUser->user_id,
                    ]);
                }
                Session::flash('del-success', 'Records selected have been deleted successfully.');
            } else {
                Session::flash('del-warning', 'No selected records found! Nothing to delete.');
            }
        } else {
            $update_payrollPeriodTbl_rule = [
                'year'      => 'required',
                'work_days' => 'required',
                'hrs_day'   => 'required',
                'hrs_pay'   => 'required',
                'days_mo'   => 'required',
                'days_yr'   => 'required'];
            $update_payrollPeriodTbl_msg = [
                'year.required'      => 'Year is a required field.',
                'work_days.required' => 'Working days is a required field.',
                'hrs_day.required'   => 'Working hours/day is a required field.',
                'hrs_pay.required'   => 'Working hours/payday is a required field.',
                'days_mo.required'   => 'Working days/month is a required field.',
                'days_yr.required'   => 'Working days/year is a required field.'];
            $validator = Validator::make($request->all(), $update_payrollPeriodTbl_rule, $update_payrollPeriodTbl_msg);
            if ($validator->fails()) {
                $request->session()->flash('edit-failed', 'Failed to update item details!');
                return redirect()->back()->withErrors($validator)->withInput();
            } else {
                tbl_payroll_period_model::where('payroll_period_id', $request->payroll_periods)->update([
                    'year'         => $request->year,
                    'payroll_mode' => $request->payroll_mode,
                    'work_days'    => $request->work_days,
                    'hrs_day'      => $request->hrs_day,
                    'hrs_pay'      => $request->hrs_pay,
                    'days_mo'      => $request->days_mo,
                    'days_yr'      => $request->days_yr,
                    'updated_by'   => $this->currentUser->user_id,
                ]);
                Session::flash('edit-success', 'An item has been updated successfully!');
            }
        }
        return redirect()->back();
    }

    public function getPayrollgroup()
    {
        $payroll_groups = tbl_payroll_group_model::
            where('company_id', $this->currentCompany->company_id)
            ->where('active_flag', 'Y')
            ->orderBy('description')
            ->get();

        $payroll_modes = tbl_payroll_mode_model::
            where('company_id', $this->currentCompany->company_id)
            ->where('active_flag', 'Y')
            ->orderBy('description')
            ->get();
        return view('main.payroll.payroll_group', ['payroll_groups' => $payroll_groups, 'payroll_modes' => $payroll_modes]);
    }

    public function postPayrollgroup(Request $request)
    {
        $post_payrollGroupTbl_rule = [
            'description' => 'required',
        ];
        $post_payrollGroupTbl_msg = [
            'description.required' => 'Group name is a required field.',
        ];

        $validator = Validator::make($request->all(), $post_payrollGroupTbl_rule, $post_payrollGroupTbl_msg);
        if ($validator->fails()) {
            $request->session()->flash('add-failed', 'Failed to add new item details!');
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            tbl_payroll_group_model::create([
                'description'  => $request->description,
                'payroll_mode' => $request->payroll_mode,
                'created_by'   => $this->currentUser->user_id,
                'updated_by'   => $this->currentUser->user_id,
                'company_id'   => $this->currentCompany->company_id,
            ]);
            Session::flash('add-success', 'New Payroll mode item has been added successfully!');
            return redirect()->back();
        }
    }

    public function putPayrollgroup(Request $request)
    {
        if ($request->isDelete) {
            if (count($request->payroll_group_tbl) > 0) {
                foreach ($request->payroll_group_tbl as $payroll_group_tbl) {
                    tbl_payroll_group_model::find($payroll_group_tbl)->update([
                        'active_flag' => 'N',
                        'updated_by'  => $this->currentUser->user_id,
                    ]);
                }
                Session::flash('del-success', 'Records selected have been deleted successfully.');
            } else {
                Session::flash('del-warning', 'No selected records found! Nothing to delete.');
            }
        } else {
            $update_payrollGroupTbl_rule = [
                'description' => 'required',
            ];
            $update_payrollGroupTbl_msg = [
                'description.required' => 'Group name is a required field.',
            ];
            $validator = Validator::make($request->all(), $update_payrollGroupTbl_rule, $update_payrollGroupTbl_msg);
            if ($validator->fails()) {
                $request->session()->flash('edit-failed', 'Failed to update item details!');
                return redirect()->back()->withErrors($validator)->withInput();
            } else {
                tbl_payroll_group_model::where('payroll_group_id', $request->payroll_groups)->update([
                    'description'  => $request->description,
                    'payroll_mode' => $request->payroll_mode,
                    'updated_by'   => $this->currentUser->user_id,
                ]);
                Session::flash('edit-success', 'An item has been updated  successfully!');
            }
        }
        return redirect()->back();
    }

    public function getPayrolltemplate()
    {
        $payroll_templates = tbl_payroll_parameter_model::where('active_flag', 'Y')->first();
        return view('main.payroll.payroll_template', ['payroll_templates' => $payroll_templates]);
    }

    public function postPayrolltemplate(Request $request)
    {
        $payroll_templates = tbl_payroll_parameter_model::where('active_flag', 'Y')->first();
        if ($payroll_templates == null) {
            tbl_payroll_parameter_model::create([
                'exempted_amt'        => empty($request->exempted_amt) ? 0 : $request->exempted_amt,
                'net_takehome_flag'   => empty($request->net_takehome_flag) ? 0 : $request->net_takehome_flag,
                'net_takehome_amt'    => empty($request->net_takehome_amt) ? 0 : $request->net_takehome_amt,
				'tax_method'		  => '1', // 20161018 added by Melvin Militante; Reason: There is no option to select tax method but it is needed in payroll run computation
                'annualize_income_mo' => empty($request->annualize_income_mo) ? $request->notapplicable : $request->annualize_income_mo, // 20161014 updated by Brian Condino; Reason: Adding means for the user to deselect radio buttons
                'ded_late_flag'       => $request->ded_late_flag,
                'ded_utime_flag'      => $request->ded_utime_flag,
                'ded_absent_flag'     => $request->ded_absent_flag,
                'min_ded_late'        => empty($request->min_ded_late) ? 0 : $request->min_ded_late,
                'with_dtr_flag'       => $request->with_dtr_flag,
                'sss_sched'           => $request->sss_sched,
                'pagibig_sched'       => $request->pagibig_sched,
                'philhealth_sched'    => $request->philhealth_sched,
                'created_by'          => $this->currentUser->user_id,
                'updated_by'          => $this->currentUser->user_id,
                'company_id'          => $this->currentCompany->company_id,
            ]);
            Session::flash('add-success', 'New Payroll template parameter has been added successfully!');
        } else {
            tbl_payroll_parameter_model::
                where('payroll_parameter_id', $payroll_templates->payroll_parameter_id)
                ->update([
                    'exempted_amt'        => empty($request->exempted_amt) ? 0 : $request->exempted_amt,
                    'net_takehome_flag'   => empty($request->net_takehome_flag) ? 0 : $request->net_takehome_flag,
                    'net_takehome_amt'    => empty($request->net_takehome_amt) ? 0 : $request->net_takehome_amt,
                    'annualize_income_mo' => empty($request->annualize_income_mo) ? $request->notapplicable : $request->annualize_income_mo, // 20161014 updated by Brian Condino; Reason: Adding means for the user to deselect radio buttons
                    'ded_late_flag'       => $request->ded_late_flag,
                    'ded_utime_flag'      => $request->ded_utime_flag,
                    'ded_absent_flag'     => $request->ded_absent_flag,
                    'min_ded_late'        => empty($request->min_ded_late) ? 0 : $request->min_ded_late,
                    'with_dtr_flag'       => $request->with_dtr_flag,
                    'sss_sched'           => $request->sss_sched,
                    'pagibig_sched'       => $request->pagibig_sched,
                    'philhealth_sched'    => $request->philhealth_sched,
                    'created_by'          => $this->currentUser->user_id,
                    'updated_by'          => $this->currentUser->user_id,
                    'company_id'          => $this->currentCompany->company_id,
                ]);
            Session::flash('put-success', 'Payroll template parameter has been updated successfully!');
        }
        return redirect()->back();
    }

    public function getPayrollsignatory()
    {
        $payroll_signatorys = tbl_payroll_signatory_model::
            where('company_id', $this->currentCompany->company_id)
            ->where('active_flag', 'Y')
            ->orderBy('employee_id')
            ->get();
        $employees = tbl_employee_model::
            where('company_id', $this->currentCompany->company_id)
            ->where('active_flag', 'Y')
            ->orderBy('employee_number')
            ->get();
        return view('main.payroll.payroll_signatory', ['payroll_signatorys' => $payroll_signatorys, 'employees' => $employees]);
    }

    public function postPayrollsignatory(Request $request)
    {
        $post_payrollSigTbl_rule = [
            'employee_id' => 'required',
        ];
        $post_payrollSigTbl_msg = [
            'employee_id.required' => 'Employee number is a required field.',
        ];
        $validator = Validator::make($request->all(), $post_payrollSigTbl_rule, $post_payrollSigTbl_msg);
        if ($validator->fails()) {
            $request->session()->flash('add-failed', 'Failed to add new item details!');
            return redirect()->back()->withErrors($validator)->withInput();
        } else {

            tbl_payroll_signatory_model::create([
                'employee_id' => $request->employee_id,
                'status'      => 'A',
                'created_by'  => $this->currentUser->user_id,
                'updated_by'  => $this->currentUser->user_id,
                'company_id'  => $this->currentCompany->company_id,
            ]);
            Session::flash('add-success', 'New Payroll Signatory item has been added successfully!');
            return redirect()->back();
        }
    }
    public function putPayrollsignatory(Request $request)
    {
        if ($request->isDelete) {
            if (count($request->payroll_signatory_tbl) > 0) {
                foreach ($request->payroll_signatory_tbl as $payroll_signatory_tbl) {
                    tbl_payroll_signatory_model::find($payroll_signatory_tbl)->update([
                        'active_flag' => 'N',
                        'updated_by'  => $this->currentUser->user_id,
                    ]);
                }
                Session::flash('del-success', 'Records selected have been deleted successfully.');
            } else {
                Session::flash('del-warning', 'No selected records found! Nothing to delete.');
            }
        } else {
            $update_payrollSigTbl_rule = [
                'status' => 'required',
            ];
            $update_payrollSigTbl_msg = [
                'status.required' => 'Status is a required field.',
            ];
            $validator = Validator::make($request->all(), $update_payrollSigTbl_rule, $update_payrollSigTbl_msg);

            if ($validator->fails()) {
                $request->session()->flash('edit-failed', 'Failed to update item details!');
                return redirect()->back()->withErrors($validator)->withInput();
            } else {
                tbl_payroll_signatory_model::where('signatory_id', $request->payroll_sign)->update([
                    'status'     => $request->status,
                    'updated_by' => $this->currentUser->user_id,
                ]);
                Session::flash('add-success', 'An item has been updated successfully!');
            }
        }
        return redirect()->back();
    } // end of function..

    public function getOvertimeparamenter()
    {
        $overtimes = tbl_overtime_model::
            where('company_id', $this->currentCompany->company_id)
            ->where('active_flag', 'Y')
            ->orderBy('overtime_id')
            ->get();
        $payroll_elements = tbl_payroll_element_model::
            where('company_id', $this->currentCompany->company_id)
            ->where('active_flag', 'Y')
            ->orderBy('description')
            ->get();
        return view('main.payroll.overtime_parameter', ['overtimes' => $overtimes, 'payroll_elements' => $payroll_elements]);
    }

    public function postOvertimeparamenter(Request $request)
    {
        $post_overtimeParamTbl_rule = [
            'description' => 'required',
            'time_from'   => 'required',
            'time_to'     => 'required',
            'rate'        => 'required',
        ];
        $post_overtimeParamTbl_msg = [
            'description.required' => 'Description is a required field.',
            'time_from'            => 'Time-from is required field.',
            'time_to'              => 'Time-to is required field.',
            'rate'                 => 'Rate is required field.',
        ];
        $validator = Validator::make($request->all(), $post_overtimeParamTbl_rule, $post_overtimeParamTbl_msg);

        if ($validator->fails()) {
            $request->session()->flash('add-failed', 'Failed to add new item details!');
            return redirect()->back()->withErrors($validator)->withInput();
        } else {

            tbl_overtime_model::create([
                'description'          => $request->description,
                'overtime_type_id'     => $request->overtime_type_id,
                'overtime_category_id' => $request->overtime_category_id,
                'time_from'            => $request->time_from,
                'time_to'              => $request->time_to,
                'payroll_element_id'   => $request->payroll_element_id,
                'first_hour'           => $request->first_hour,
                'rate'                 => $request->rate,
                'date_overlap_flag'    => $request->date_overlap_flag,
                'created_by'           => $this->currentUser->user_id,
                'updated_by'           => $this->currentUser->user_id,
                'company_id'           => $this->currentCompany->company_id,
            ]);
            Session::flash('add-success', 'New  item has been added successfully!');
            return redirect()->back();
        }
    }

    public function putOvertimeparamenter(Request $request)
    {
        if ($request->isDelete) {
            if (count($request->overtime_tbl) > 0) {
                foreach ($request->overtime_tbl as $overtime_tbl) {
                    tbl_overtime_model::find($overtime_tbl)->update([
                        'active_flag' => 'N',
                        'updated_by'  => $this->currentUser->user_id,
                    ]);
                }
                Session::flash('del-success', 'Records selected have been deleted successfully.');
            } else {
                Session::flash('del-warning', 'No selected records found! Nothing to delete.');
            }

        } else {
            $update_overtimeParamTbl_rule = [
                'description' => 'required',
                'time_from'   => 'required',
                'time_to'     => 'required',
                'rate'        => 'required',
            ];
            $update_overtimeParamTbl_msg = [
                'description.required' => 'Description is a required field.',
                'time_from'            => 'Time-from is required field.',
                'time_to'              => 'Time-to is required field.',
                'rate'                 => 'Rate is required field.',
            ];
            $validator = Validator::make($request->all(), $update_overtimeParamTbl_rule, $update_overtimeParamTbl_msg);

            if ($validator->fails()) {
                $request->session()->flash('edit-failed', 'Failed to update item details!');
                return redirect()->back()->withErrors($validator)->withInput();
            } else {
                tbl_overtime_model::where('overtime_id', $request->overtimes)->update([
                    'description'          => $request->description,
                    'overtime_type_id'     => $request->overtime_type_id,
                    'overtime_category_id' => $request->overtime_category_id,
                    'time_from'            => $request->time_from,
                    'time_to'              => $request->time_to,
                    'payroll_element_id'   => $request->payroll_element_id,
                    'first_hour'           => $request->first_hour,
                    'rate'                 => $request->rate,
                    'date_overlap_flag'    => $request->date_overlap_flag,
                    'updated_by'           => $this->currentUser->user_id,
                ]);
                Session::flash('add-success', 'An item has been updated successfully!');
            }
        }
        return redirect()->back();
    }

    public function getWageorder()
    {
        $wage_orders = tbl_wage_order_model::where('company_id', $this->currentCompany->company_id)->where('active_flag', 'Y')->orderBy('region')->orderBy('wage_order')->get();
        return view('main.payroll.wage_order', ['wage_orders' => $wage_orders]);
    }
    public function postWageorder(Request $request)
    {
        $post_wageOrderTbl_rule = [
            'description'    => 'required',
            'region'         => 'required',
            'wage_order'     => 'required',
            'effective_date' => 'required',
        ];
        $post_wageOrderTbl_msg = [
            'description.required'    => 'Description is a required field.',
            'region.required'         => 'Region is a required field.',
            'wage_order.required'     => 'Wage Order is a required field.',
            'effective_date.required' => 'Effective Date is a required field.',
        ];
        $validator = Validator::make($request->all(), $post_wageOrderTbl_rule, $post_wageOrderTbl_msg);

        if ($validator->fails()) {
            $request->session()->flash('add-failed', 'Failed to add new item details!');
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            tbl_wage_order_model::create([
                'region'         => $request->region,
                'description'    => $request->description,
                'wage_order'     => $request->wage_order,
                'effective_date' => $request->effective_date,
                'per_day_amt'    => $request->per_day_amt,
                'per_month_amt'  => $request->per_month_amt,
                'per_year_amt'   => $request->per_year_amt,
                'factor'         => $request->factor,
                'created_by'     => $this->currentUser->user_id,
                'updated_by'     => $this->currentUser->user_id,
                'company_id'     => $this->currentCompany->company_id,
            ]);
            Session::flash('add-success', 'New wage order item has been added successfully!');
            return redirect()->back();
        }
    }

    public function putWageorder(Request $request)
    {
        if ($request->isDelete) {
            if (count($request->wageOrder_tbl) > 0) {
                foreach ($request->wageOrder_tbl as $wageOrder_tbl) {
                    tbl_wage_order_model::find($wageOrder_tbl)->update([
                        'active_flag' => 'N',
                        'updated_by'  => $this->currentUser->user_id,
                    ]);
                }
                Session::flash('del-success', 'Records selected have been deleted successfully.');
            } else {
                Session::flash('del-warning', 'No selected records found! Nothing to delete.');
            }
        } else {
            $update_wageOrderTbl_rule = [
                'description'    => 'required',
                'region'         => 'required',
                'wage_order'     => 'required',
                'effective_date' => 'required',
            ];
            $update_wageOrderTbl_msg = [
                'description.required'    => 'Description is a required field.',
                'region.required'         => 'Region is a required field.',
                'wage_order.required'     => 'Wage Order is a required field.',
                'effective_date.required' => 'Effective Date is a required field.',
            ];
            $validator = Validator::make($request->all(), $update_wageOrderTbl_rule, $update_wageOrderTbl_msg);
            if ($validator->fails()) {
                $request->session()->flash('edit-failed', 'Failed to add wage order details!');
                return redirect()->back()->withErrors($validator)->withInput();
            } else {
                tbl_wage_order_model::where('wage_order_id', $request->wages_order)->update([
                    'region'         => $request->region,
                    'description'    => $request->description,
                    'wage_order'     => $request->wage_order,
                    'effective_date' => $request->effective_date,
                    'per_day_amt'    => $request->per_day_amt,
                    'per_month_amt'  => $request->per_month_amt,
                    'per_year_amt'   => $request->per_year_amt,
                    'factor'         => $request->factor,
                    'updated_by'     => $this->currentUser->user_id,
                ]);
                Session::flash('edit-success', 'Wage order has been updated successfully!');
            }
        }
        return redirect()->back();
    }

    public function returnPayrollelementid($company_id)
    {
        $payroll_element_id = db::select(
                                db::raw("
                                    select max(payroll_element_id::integer)
                                    from hr.tbl_payroll_element
                                    where 6=6
                                    and company_id = '$company_id'"));
        return reset($payroll_element_id)->max + 1;
    }
}
