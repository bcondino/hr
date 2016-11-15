<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Auth;
use Validator;
use Illuminate\Support\Facades\Input;

class PWizardController extends Controller
{

 protected $validation_rules = [
 'location_code'      => 'required'
 ];


 public function getIndex(Request $request){     

        //PAGE_VARIABLES
    $user_id = Auth::User()->user_id;
    $page_num = $request->get('page') == null ? 1 : $request->get('page');
    $page = 'wiz.setup'.$page_num;

    $company_rec = \App\Company::where('user_id', $user_id)->first();

    $data =[
    'page_num'          =>  $page_num                           
    ,   'user_id'           =>  $user_id
    ,   'comp'              =>  $company_rec == null ? null : $company_rec->company_id
    ];    

    $company_id = $data['comp'];



        //END PAGE VARIABLES

    switch ($page_num) {   

        case '2':{
                         //General Details

            $company_name = $company_id == 0 ? NULL : \App\Company::find($company_id)->company_name;
            $company=[
            'id'                => $company_id
            ,   'name'              => $company_name
            ,   'address'           => $company_id == 0 ? NULL : \App\Company::find($company_id)->address
            ,   'city'              => $company_id == 0 ? NULL : \App\Company::find($company_id)->city
            ,   'region'            => $company_id == 0 ? NULL : \App\Company::find($company_id)->region
            ,   'zip_code'          => $company_id == 0 ? NULL : \App\Company::find($company_id)->zip
            ,   'bir_reg_no'       => $company_id == 0 ? NULL : \App\Company::find($company_id)->bir_reg_no
            ,   'tin_num'           => $company_id == 0 ? NULL : \App\Company::find($company_id)->tin
            ,   'sss_num'           => $company_id == 0 ? NULL : \App\Company::find($company_id)->sss_no
            ,   'hdmf_num'          => $company_id == 0 ? NULL : \App\Company::find($company_id)->hdmf
            ,   'phil_health_num'   => $company_id == 0 ? NULL : \App\Company::find($company_id)->philhealth
            ,   'bir_rdo_num'       => $company_id == 0 ? NULL : \App\Company::find($company_id)->bir_rdo_no
            ];  
            $data['company'] = $company;
            break;
        }
                    case '3':{ //Business structure

                        null;
                        break;
                    }

                    case '4':{ // Location setup
                        $location = null;
                        if ($company_id) {
                            $loc_rec = \App\Location::where('company_id','=',$company_id)
                            ->where('active_flag','1')
                            ->get();                                

                            if($loc_rec->count() > 0){

                                foreach ($loc_rec as $loc) {

                                        // dump($loc_rec);
                                        // dd($loc->location_id);

                                    $location[]=[
                                    'id'        => $loc->location_id
                                    ,   'code'      => $loc->location_code
                                    ,   'name'      => $loc->location_name
                                    ,   'address'   => $loc->address1
                                    ,   'city'      => $loc->city
                                    ];
                                }
                            }

                        }else{
                            return redirect('pwiz?page=2');
                        }                           

                        $data['location'] = $location;
                        break;
                    }

                    case '5':{

                        $employment = null;
                        if ($company_id) {
                            $empt_rec = \App\Employment::where('company_id','=',$company_id)
                            ->where('active_flag','1')
                            ->get();                                

                            if($empt_rec->count() > 0){

                                foreach ($empt_rec as $empt) {


                                    $employment[]=[
                                    'type_id'       => $empt->emp_type_id
                                    ,   'type_name'     => $empt->emp_type_name
                                    ,   'min_hrs'           => $empt->min_hrs
                                    ,   'max_hrs'           => $empt->max_hrs
                                    ];
                                }
                            }

                        }else{
                            return redirect('pwiz?page=2');
                        }                           

                        $data['employment'] = $employment;
                        break;
                    }

                    case '6':{

                        $salary_grade = null;
                        $grade_rec = \App\SalaryGrade::where('company_id','=',$company_id)
                        ->where('active_flag','1')
                        ->get();    

                            //dd($grade_rec);
                        if ($company_id) {
                            if($grade_rec->count() > 0){

                                foreach ($grade_rec as $grade) {


                                    $salary_grade[]=[
                                    'grade_id'       => $grade->grade_id
                                    ,   'grade_code'     => $grade->grade_code
                                    ,   'minimum_salary'           => $grade->minimum_salary
                                    ,   'maximum_salary'           => $grade->maximum_salary
                                    ];
                                }
                            }

                        }else{
                            return redirect('pwiz?page=2');
                        }                           

                        $data['salary_grade'] = $salary_grade;
                        break;
                    }

                    case '7':{

                       $pos =  null;


                       if ($company_id) {
                        $position_rec = \App\Position::where('company_id','=',$company_id)
                        ->where('active_flag','1')
                        ->get();

                        if($position_rec->count() > 0){

                            foreach($position_rec as $post){
                                $grade_code = \App\SalaryGrade::where('grade_id', $post->grade_id)->first()->grade_code;
                                $class_name = \App\Classification::where('class_id', $post->class_id)->first()->class_name;
                                $business_unit_name = \App\BusinessUnit::where('business_unit_id', $post->business_unit_id)->first()->business_unit_name;
                                $pos[]=[
                                'position_id'=> $post->position_id
                                ,'position_code' => $post->position_code
                                ,'description' => $post->description
                                ,'business_unit_name' => $business_unit_name
                                ,'class_name' => $class_name
                                ,'grade_code' => $grade_code
                                ];
                            }
                        } 
                    } 
                    else {
                        return redirect('pwiz?page=2');
                    }

                    $data['pos'] = $pos;
                    break;
                }

                case '8':{

                   $earning_arr =  null;

                   if ($company_id) {
                    $earn_rec = \App\Earning::where('company_id','=',$company_id)
                    ->where('active_flag','1')
                    ->get();

                    if($earn_rec->count() > 0){


                        foreach($earn_rec as $earning){
                            $earning_type_name = \App\EarningType::where('earning_type_id', $earning->earning_type_id)->first()->earning_type_name;
                            $is_taxable = \App\EarningType::where('earning_type_id', $earning->earning_type_id)->first()->is_taxable;
                            $earning_arr[]=[
                            'earning_id'          => $earning->earning_id
                            ,'earning_name'       => $earning->earning_name
                            ,'earning_type_id'    => $earning->earning_type_id
                            ,'earning_type_name'  => $earning_type_name
                            ,'is_taxable'         => $is_taxable
                            ];
                        }
                    } 
                } 
                else {
                    return redirect('pwiz?page=2');
                }

                $data['earning'] = $earning_arr;
                break;
            }

            case '9':{

               $deduction_arr =  null;

               if ($company_id) {
                $ded_rec = \App\Deduction::where('company_id','=',$company_id)
                ->where('active_flag','1')
                ->get();

                if($ded_rec->count() > 0){

                    foreach($ded_rec as $deduction){
                        $deduction_type_name = \App\DeductionType::where('deduction_type_id', $deduction->deduction_type_id)->first()->deduction_type_name;
                        $is_mandatory = \App\DeductionType::where('deduction_type_id', $deduction->deduction_type_id)->first()->is_mandatory;
                        $deduction_arr[]=[
                        'deduction_id'          => $deduction->deduction_id
                        ,'deduction_name'       => $deduction->deduction_name
                        ,'deduction_type_id'    => $deduction->deduction_type_id
                        ,'deduction_type_name'  => $deduction_type_name
                        ,'is_mandatory'         => $is_mandatory
                        ];
                    }
                } 
            } 
            else {
                return redirect('pwiz?page=2');
            }

                            //dd($earning_arr);
            $data['deduction'] = $deduction_arr;
            break;
        }

        default:
        {
            null;
            break;
        }

    }         


    return view($page, $data);
}



  /*  public function postCompany(Request $request){
        //create company
        $user_id    = Auth::User()->user_id;    

        $rec = new \App\Company();
        $rec->company_name  = $request->company_name;
        $rec->address       = $request->address;
        $rec->city          = $request->city;
        $rec->region        = $request->region;
        $rec->zip           = $request->zip_code;
        $rec->bir_reg_no    = $request->bus_reg_num;
        $rec->tin           = $request->tin_num;
        $rec->sss_no        = $request->sss_num;
        $rec->hdmf          = $request->hdmf_num;
        $rec->philhealth    = $request->phil_health_num;
        $rec->bir_rdo_no    = $request->bir_rdo_num;
        $rec->user_id       = $user_id;
        $rec->created_by    = $user_id;
        $rec->active_flag   = '1';
        $rec->save();

        return redirect()->back();
    }*/

    public function putCompany(Request $request){    //BEGIN putCompany
       // dd($request->all());
    /*************************************************************************************************************************
        //BE ADVISED!
        //Auth User Id is required here. Auth Controller must be configured or else accountability for each user will be nullified.
    **************************************************************************************************************************/

    $user_id = Auth::User()->user_id;

    $comp_rules = [
    'company_name'      => 'required|max:250'
    ,   'zip_code'          => 'numeric'
    ,   'bus_reg_num'       => 'min:15'
    ,   'tin_num'            => 'min:16'
    ,   'sss_num'            => 'min:11'
    ,   'hdmf_num'           => 'min:14'
    ,   'phil_health_num'        => 'min:14'
    ,   'bir_rdo_num'        => 'min:3'
            //regex:/^[a-zA-Z0-9\s-]+$/
    ];

    if($request->comp == null){
                // doing the validation
        $validator = Validator::make($request->all() ,$comp_rules);        

        if($validator->fails()){
            $header_message = "Please fill with valid information the fields below.";
            return redirect('pwiz?page=2')
            ->withErrors($validator)
            ->with('display', 'Errors detected. Fill in the fields below with valid information.')
            ->withInput()
            ;
        }
        else{
                   // dd($request->all());
            $rec = new \App\Company();
            $new_id = intval(json_decode(\App\Company::select('MAX(company_id) as new_id')->get())[0]->new_id) + 1;
            $rec->company_id = $new_id;

                    //Company details section
            $rec->company_name = trim($request->input('company_name'),"\x00..\x1F");                
            $rec->address = $request->address;
            $rec->city = $request->city;
            $rec->region = $request->region;
            $rec->zip = $request->zip_code;

                    //Government-details section
            $rec->bir_reg_no =$request->bus_reg_num;            
            $rec->tin   = $request->tin_num;
            $rec->sss_no = $request->sss_num;
            $rec->hdmf = $request->hdmf_num;
            $rec->philhealth = $request->phil_health_num;
            $rec->bir_rdo_no = $request->bir_rdo_num;

            $rec->created_by = $user_id;
            $rec->user_id = $user_id;
            $rec->created_by    = $user_id;
            $rec->active_flag   = '1';

            $rec->save();   

                    return redirect()->back(); //go to next step
                }

            }else{

             //unset($rules['company_name']);
             // doing the validation, passing request, rules and the messages
             $validator = Validator::make($request->all(),$comp_rules);
             
             if($validator->fails()){
                 // doing the validation, passing post data, rules and the messages
                return redirect()->back()
                ->withErrors($validator)
                ->with('display', 'Errors detected. Fill in the fields below with valid information.') 
                ;

            }else{

                //update
                $this->updateCompany($request->comp,$request, $user_id); 
                //return redirect('pwiz?page=3'); 
                return redirect('pwiz?page=2')
                ->with('display', 'Company Details have been updated successfully.')
                ->withInput()
                ;
            }
            
        }

    }//end putCompany

    public function updateCompany($company_id , $data, $user_id){

        $cols =[
        'company_name'      => $data->company_name
        ,   'address'           => $data->address
        ,   'region'            => $data->region
        ,   'city'              => $data->city
        ,   'zip'               => $data->zip_code
        ,   'bir_reg_no'        => $data->bus_reg_num
        ,   'tin'               => $data->tin_num
        ,   'sss_no'            => $data->sss_num
        ,   'hdmf'              => $data->hdmf_num
        ,   'philhealth'        => $data->phil_health_num
        ,   'bir_rdo_no'        => $data->bir_rdo_num
        ,   'updated_by'    => $user_id
        ];

        $company = \App\Company::find($company_id);
        $company->update($cols);                

    }// END updateCompany



    public function postLocation(Request $request, $company_id){
    //BEGIN putLocation

        $user_id    = Auth::User()->user_id;    
        $validator = Validator::make($request->all() ,$this->validation_rules);

        if($validator->fails()){
             //$input['autoOpenModal'] = 'true'; //Add the auto open indicator flag as an input.
            return redirect('pwiz?page=4')
            ->withErrors($validator)
            ->withInput()
            //->with('loc_err', 'Errors detected. Fill in the fields below with valid information.')
            ->with('open_add_modal', true);
            ;}

            else{        

                $rec = new \App\Location();
                $new_id = intval(json_decode(\App\Location::select('MAX(location_id) as new_id')->get())[0]->new_id) + 1;
                $rec->location_id   = $new_id;
                $rec->location_name = $request->location_name;
                $rec->location_code = $request->location_code;
                $rec->address1      = $request->address;
                $rec->city          = $request->city;
                $rec->company_id    = $company_id;
                $rec->created_by    = $user_id;
                $rec->active_flag   = '1';
                $rec->save();

                return redirect()->back();

            }

    }// END postLocation

    public function putLocation(Request $request){
    //UPDATE status 
        $user_id = Auth::User()->user_id;        
        
        $validator = Validator::make($request->all() ,$this->validation_rules);

        if ($request->edit_flag) {

            if($validator->fails()){
                $data['autoOpenModal'] = true;
                return redirect('pwiz?page=4')
                ->withErrors($validator)
                ->withInput()
                ->with('open_edit_modal', true);
                ;}

                else{   
                    $cols =[
                    'location_name' => $request->edit_loc_name
                    ,   'location_code' => $request->edit_loc_code
                    ,   'address1'      => $request->edit_loc_address
                    ,   'city'          => $request->edit_loc_city
                    ,   'updated_by'   => $user_id
                    ];


                    $loc = \App\Location::find($request->loc);
                    $loc->update($cols);
                }

            }

            else{

                foreach ($request->location as $loc) {
                    $loc_rec = \App\Location::find($loc);
                    $loc_rec->active_flag   = 0;
                    $loc_rec->updated_by    = $user_id;
                    $loc_rec->update();
                }

            }
            return redirect()->back();

    }//end putLocation

    public function postEmployment(Request $request, $company_id){

        $user_id = Auth::User()->user_id;

        $rec = new \App\Employment();
        $new_id = intval(json_decode(\App\Employment::select('MAX(emp_type_id) as new_id')->get())[0]->new_id) + 1;
        $rec->emp_type_id   = $new_id;
        $rec->emp_type_name = $request->status_name;
        $rec->min_hrs       = $request->min_hrs;
        $rec->max_hrs       = $request->max_hrs;
        $rec->company_id    = $company_id;
        $rec->created_by    = $user_id;
        $rec->active_flag   = '1';
        $rec->save();

        return redirect()->back();
    }//end postEmploymentem

    public function putEmployment(Request $request){
        //UPDATE status 
        $user_id = Auth::User()->user_id;    
        
        if ($request->edit_flag) {
            $cols =[
            'emp_type_name' => $request->edit_status_name
            ,   'min_hrs' => $request->edit_min_hrs
            ,   'max_hrs'      => $request->edit_max_hrs
            ,   'updated_by'   => $user_id
            ];

            $employment = \App\Employment::find($request->empt);
            $employment->update($cols);            


        } // end if
        
        else{
            foreach ($request->empt as $empt) {
                $emptype_rec = \App\Employment::find($empt);
                $emptype_rec->active_flag   = 0;
                $emptype_rec->updated_by = $user_id;
                $emptype_rec->update();
            }


        }     // end else

        return redirect()->back();


    }// end putEmployment

    public function postGrade(Request $request, $company_id){
    //BEGIN post
        $user_id = Auth::User()->user_id;

        $rec = new \App\SalaryGrade();
        $new_id = intval(json_decode(\App\SalaryGrade::select('MAX(grade_id) as new_id')->get())[0]->new_id) + 1;
        $rec->grade_id   = $new_id;
        $rec->grade_code = $request->grade_code;
        $rec->minimum_salary       = $request->minimum_salary;
        $rec->maximum_salary       = $request->maximum_salary;
        $rec->company_id    = $company_id;
        $rec->created_by    = $user_id;
        $rec->active_flag   = '1';
        $rec->save();

        return redirect()->back();
    }//end postEmployment

    public function putGrade(Request $request){
        //UPDATE status 
        $user_id = Auth::User()->user_id;        

        if ($request->edit_flag) {
            $cols =[
            'grade_code' => $request->edit_grade_code
            ,   'minimum_salary' => $request->edit_minimum_salary
            ,   'maximum_salary'      => $request->edit_maximum_salary
            ,   'updated_by'   => $user_id
            ];

            $grade = \App\SalaryGrade::find($request->grade);
            //$grade = \App\SalaryGrade::where('grade_id','=',$request->grade);
            //dd($cols);
            $grade->update($cols);

        } // end if
        else{
            foreach ($request->grade as $grade) {
                $grade_rec = \App\SalaryGrade::find($grade);
                $grade_rec->active_flag   = 0;
                $grade_rec->updated_by = $user_id;
                $grade_rec->update();
            }


        }     // end else
        return redirect()->back();

    }// end putGrade

    public function postPosition(Request $request, $company_id){
    //BEGIN post
        $user_id = Auth::User()->user_id;

        //dd($request->all());
        $rec = new \App\Position();
        $rec->position_code     = $request->position_code;
        $rec->description       = $request->description;
        $rec->company_id        = $company_id;
        $rec->business_unit_id  = $request->business_unit_id;
        $rec->grade_id          = $request->grade_id;
        $rec->class_id          = $request->class_id;
        $rec->created_by        = $user_id;
        $rec->active_flag       = '1';
        $rec->save();

        return redirect()->back();
    }//end postPosition

    public function putPosition(Request $request){
        //UPDATE status 
        $user_id = Auth::User()->user_id;        

        if ($request->edit_flag) {

            //dd($request->all());
           $cols =[
           'position_code'     => $request->edit_position_code
           ,   'description'       => $request->edit_position_desc
           ,   'business_unit_id'  => $request->business_unit_id
           ,   'grade_id'          => $request->grade_id
           ,   'class_id'          => $request->class_id
           ,   'updated_by'        => $user_id
           ];

           $grade = \App\Position::find($request->position_id);
           $grade->update($cols);

        } // end if
        else{
            foreach ($request->pos as $post) {
                $post_rec = \App\Position::find($post);
                $post_rec->active_flag   = 0;  
                $post_rec->updated_by = $user_id;
                $post_rec->update();              
            }

        }     // end else
        return redirect()->back();

    }// end putGrade

    public function postEarning(Request $request, $company_id){
        //BEGIN post
        $user_id = Auth::User()->user_id;

        $rec = new \App\Earning();
        $rec->earning_name      = $request->earning_name;
        $rec->earning_type_id   = $request->earning_type_id;
        $rec->company_id        = $company_id;
        $rec->created_by        = $user_id;
        $rec->active_flag       = '1';
        $rec->save();

        return redirect()->back();
    }

    public function putEarning(Request $request){
        $user_id = Auth::User()->user_id;        
        if($request->edit_flag) {
            $cols =[
            'earning_name'     => $request->edit_earning_name
            ,   'earning_type_id'     => $request->earning_type_id
            ,   'updated_by'        => $user_id
            ];

            $earning = \App\Earning::find($request->earning_id);
            $earning->update($cols);
        }
        else {
            foreach ($request->earn as $earn) {
                $earn_rec = \App\Earning::find($earn);
                $earn_rec->active_flag = 0; 
                $earn_rec->updated_by = $user_id; 
                $earn_rec->update();              
            }
        }
        return redirect()->back();
    }


    public function postDeduction(Request $request, $company_id){
        //BEGIN post
        $user_id = Auth::User()->user_id;

       //dd($request->all());
        $rec = new \App\Deduction();
        $rec->deduction_name      = $request->deduction_name;
        $rec->deduction_type_id   = $request->deduction_type_id;
        $rec->company_id        = $company_id;
        $rec->created_by        = $user_id;
        $rec->active_flag       = '1';
        $rec->save();

        return redirect()->back();
    }

    public function putDeduction(Request $request){
        $user_id = Auth::User()->user_id;        
        if($request->edit_flag) {
            $cols =[
            'deduction_name'     => $request->edit_deduction_name
            ,   'deduction_type_id'  => $request->deduction_type_id
            ,   'updated_by'         => $user_id
            ];

            $deduction = \App\Deduction::find($request->deduction_id);
            $deduction->update($cols);
        }
        else {
            //dd($request->ded);
            foreach ($request->ded as $ded) {
                $ded_rec = \App\Deduction::find($ded);
                $ded_rec->active_flag = 0; 
                $ded_rec->updated_by = $user_id; 
                $ded_rec->update();              
            }
        }
        return redirect()->back();
    }
}
