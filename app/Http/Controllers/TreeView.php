<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\tbl_company_model;
use App\tbl_business_unit_model;



class TreeView extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companytbl = new tbl_company_model();
        return view('wiz2/treeview',['company'=>$companytbl->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $businessUnit = new tbl_business_unit_model();
        $businessUnit->business_unit_name = $request->text;
        $businessUnit->hierarchy_level = $request->level;
        $businessUnit->company_id = $request->company_id;
        $businessUnit->parent_unit_id = $request->parent_id;
        $businessUnit->active_flag = 'Y';
        $businessUnit->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
		$businessUnit = new tbl_business_unit_model();
		$text = $request->get('text');
		$businessUnit->where('business_unit_id',$id)->update(['business_unit_name'=>$text]);
        return response()->json('1');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $companytbl = new tbl_company_model();
        $businessUnit = new tbl_business_unit_model();
		
		if($request->level = 2){
			$lvl2SQL = $businessUnit->where(['hierarchy_level'=>2, 'parent_unit_id'=>$id])->get();
				foreach($lvl2SQL as $lvl2Val){
				$lvl3SQL = $businessUnit->where(['hierarchy_level'=>3, 'parent_unit_id'=>$lvl2Val->business_unit_id])->get();
				foreach($lvl3SQL as $lvl3Val){
					$lvl4SQL = $businessUnit->where(['hierarchy_level'=>4, 'parent_unit_id'=>$lvl3Val->business_unit_id])->get();
					foreach($lvl4SQL as $lvl4Val){
						$lvl5SQL = $businessUnit->where(['hierarchy_level'=>5, 'parent_unit_id'=>$lvl4Val->business_unit_id])->get();
						foreach($lvl5SQL as $lvl5Val){
							$lvl6SQL = $businessUnit->where(['hierarchy_level'=>6, 'parent_unit_id'=>$lvl5Val->business_unit_id])->get();
							foreach($lvl6SQL as $lvl6Val){
								$businessUnit->where('business_unit_id',$lvl6Val->business_unit_id)->update(['active_flag' => 'N']);
							}
							$businessUnit->where('business_unit_id',$lvl5Val->business_unit_id)->update(['active_flag' => 'N']);
						}
						$businessUnit->where('business_unit_id',$lvl4Val->business_unit_id)->update(['active_flag' => 'N']);
					}
					$businessUnit->where('business_unit_id',$lvl3Val->business_unit_id)->update(['active_flag' => 'N']);
				}
				$businessUnit->where('business_unit_id',$lvl2Val->business_unit_id)->update(['active_flag' => 'N']);
			}
			$businessUnit->where('business_unit_id',$id)->update(['active_flag' => 'N']);
		}elseif($request->level = 3){
			$lvl3SQL = $businessUnit->where(['hierarchy_level'=>3, 'parent_unit_id'=>$id])->get();
			foreach($lvl3SQL as $lvl3Val){
				$lvl4SQL = $businessUnit->where(['hierarchy_level'=>4, 'parent_unit_id'=>$lvl3Val->business_unit_id])->get();
				foreach($lvl4SQL as $lvl4Val){
					$lvl5SQL = $businessUnit->where(['hierarchy_level'=>5, 'parent_unit_id'=>$lvl4Val->business_unit_id])->get();
					foreach($lvl5SQL as $lvl5Val){
						$lvl6SQL = $businessUnit->where(['hierarchy_level'=>6, 'parent_unit_id'=>$lvl5Val->business_unit_id])->get();
						foreach($lvl6SQL as $lvl6Val){
							$businessUnit->where('business_unit_id',$lvl6Val->business_unit_id)->update(['active_flag' => 'N']);
						}
						$businessUnit->where('business_unit_id',$lvl5Val->business_unit_id)->update(['active_flag' => 'N']);
					}
					$businessUnit->where('business_unit_id',$lvl4Val->business_unit_id)->update(['active_flag' => 'N']);
				}
				$businessUnit->where('business_unit_id',$lvl3Val->business_unit_id)->update(['active_flag' => 'N']);
			}
			$businessUnit->where('business_unit_id',$id)->update(['active_flag' => 'N']);
		}elseif($request->level = 4){
			$lvl4SQL = $businessUnit->where(['hierarchy_level'=>4, 'parent_unit_id'=>$id])->get();
			foreach($lvl4SQL as $lvl4Val){
				$lvl5SQL = $businessUnit->where(['hierarchy_level'=>5, 'parent_unit_id'=>$lvl4Val->business_unit_id])->get();
				foreach($lvl5SQL as $lvl5Val){
					$lvl6SQL = $businessUnit->where(['hierarchy_level'=>6, 'parent_unit_id'=>$lvl5Val->business_unit_id])->get();
					foreach($lvl6SQL as $lvl6Val){
						$businessUnit->where('business_unit_id',$lvl6Val->business_unit_id)->update(['active_flag' => 'N']);
					}
					$businessUnit->where('business_unit_id',$lvl5Val->business_unit_id)->update(['active_flag' => 'N']);
				}
				$businessUnit->where('business_unit_id',$lvl4Val->business_unit_id)->update(['active_flag' => 'N']);
			}
			$businessUnit->where('business_unit_id',$id)->update(['active_flag' => 'N']);	
		}elseif($request->level = 5){
			$lvl5SQL = $businessUnit->where(['hierarchy_level'=>5, 'parent_unit_id'=>$id])->get();
				foreach($lvl5SQL as $lvl5Val){
					$lvl6SQL = $businessUnit->where(['hierarchy_level'=>6, 'parent_unit_id'=>$lvl5Val->business_unit_id])->get();
					foreach($lvl6SQL as $lvl6Val){
						$businessUnit->where('business_unit_id',$lvl6Val->business_unit_id)->update(['active_flag' => 'N']);
					}
					$businessUnit->where('business_unit_id',$lvl5Val->business_unit_id)->update(['active_flag' => 'N']);
				}
			$businessUnit->where('business_unit_id',$id)->delete();				
		}elseif($request->level = 6){
			$lvl6SQL = $businessUnit->where(['hierarchy_level'=>6, 'parent_unit_id'=>$id])->get();
				foreach($lvl6SQL as $lvl6Val){
					$businessUnit->where('business_unit_id',$lvl6Val->business_unit_id)->update(['active_flag' => 'N']);
				}
			$businessUnit->where('business_unit_id',$id)->update(['active_flag' => 'N']);
		}elseif($request->level = 7){
			$businessUnit->where('business_unit_id',$id)->update(['active_flag' => 'N']);
		}
    }


    public function treeviewCompany(Request $request, $company_id){
        $companytbl = new tbl_company_model();
        $businessUnit = new tbl_business_unit_model();
        $datatree = [];
        $parents = [];
        $level1 = [];
        $level2 = [];
        $level3 = [];
        $level4 = [];
        $level5 = [];
        $level6 = [];

        //Company(Root)
        foreach ($companytbl->where(['company_id'=>$company_id])->get() as $parent) { //Get all company
			$datatree[] = [
                'id'=> $parent->company_id
                ,'parent'=>'#'
                ,'text'=> $parent->company_name
                ,   'li_attr'  =>  [ 'parent_id' => $parent->company_id, 'level'=>1 ]
            ];
			//Children Level 1 
			$lvl1SQL = $companytbl->find($parent->company_id)->businessUnit()->where(['hierarchy_level'=>1,'parent_unit_id'=>$parent->company_id, 'active_flag'=>'Y'])->get();
			foreach($lvl1SQL as $lvl1Val){
				$level1 = [
						'id'    		=>  $lvl1Val->business_unit_id
                    ,   'parent'        =>  $parent->company_id
					,   'text'  		=>  $lvl1Val->business_unit_name
                    ,   'li_attr'       =>  [ 'parent_id' => $parent->company_id, 'level'=>2 ]

				];
				$datatree[] = $level1;
				//Children Level 2
                $lvl2SQL = $companytbl->find($parent->company_id)->businessUnit()->where(['hierarchy_level'=>2,'parent_unit_id'=>$lvl1Val->business_unit_id, 'active_flag'=>'Y'])->get();
                foreach($lvl2SQL as $lvl2Val){
                    $level2 = [
                            'id'            =>  $lvl2Val->business_unit_id
                        ,   'parent'        =>  $lvl1Val->business_unit_id
                        ,   'text'          =>  $lvl2Val->business_unit_name
                        ,   'li_attr'       =>  [ 'parent_id' => $parent->company_id, 'level'=>3 ]

                    ];
                    $datatree[] = $level2;
                    //Children Level 3
                    $lvl3SQL = $companytbl->find($parent->company_id)->businessUnit()->where(['hierarchy_level'=>3,'parent_unit_id'=>$lvl2Val->business_unit_id, 'active_flag'=>'Y'])->get();
                    //Fix this
                    foreach($lvl3SQL as $lvl3Val){
                        $level3 = [
                                'id'            =>  $lvl3Val->business_unit_id
                            ,   'parent'        =>  $lvl2Val->business_unit_id
                            ,   'text'          =>  $lvl3Val->business_unit_name
                            ,   'li_attr'       =>  [ 'parent_id' => $parent->company_id, 'level'=>4 ]

                        ];
                        $datatree[] = $level3;
                         //Children Level 4
                        $lvl4SQL = $companytbl->find($parent->company_id)->businessUnit()->where(['hierarchy_level'=>4,'parent_unit_id'=>$lvl3Val->business_unit_id, 'active_flag'=>'Y'])->get();
                        foreach($lvl4SQL as $lvl4Val){
                            $level4 = [
                                    'id'            =>  $lvl4Val->business_unit_id
                                ,   'parent'        =>  $lvl3Val->business_unit_id
                                ,   'text'          =>  $lvl4Val->business_unit_name
                                ,   'li_attr'       =>  [ 'parent_id' => $parent->company_id, 'level'=>5 ]

                            ];
                            $datatree[] = $level4;
                             //Children Level 5
                            $lvl5SQL = $companytbl->find($parent->company_id)->businessUnit()->where(['hierarchy_level'=>5,'parent_unit_id'=>$lvl4Val->business_unit_id, 'active_flag'=>'Y'])->get();
                            foreach($lvl5SQL as $lvl5Val){
                                $level5 = [
                                        'id'            =>  $lvl5Val->business_unit_id
                                    ,   'parent'        =>  $lvl4Val->business_unit_id
                                    ,   'text'          =>  $lvl5Val->business_unit_name
                                    ,   'li_attr'       =>  [ 'parent_id' => $parent->company_id, 'level'=>6 ]

                                ];
                                $datatree[] = $level5;
                                 //Children Level 6
								$lvl6SQL = $companytbl->find($parent->company_id)->businessUnit()->where(['hierarchy_level'=>6,'parent_unit_id'=>$lvl5Val->business_unit_id, 'active_flag'=>'Y'])->get();
								foreach($lvl6SQL as $lvl6Val){
									$level6 = [
											'id'            =>  $lvl6Val->business_unit_id
										,   'parent'        =>  $lvl5Val->business_unit_id
										,   'text'          =>  $lvl6Val->business_unit_name
										,   'li_attr'       =>  [ 'parent_id' => $parent->company_id, 'level'=>7 ]

									];
									$datatree[] = $level6;
								}	
                            }
                        }
                    }
                }
				
			}
        }
        return response()->json($datatree);
        
    }
}
