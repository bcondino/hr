<?php

namespace App\Http\Controllers;

use SplFileInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\user;
use Excel;
use App\Http\Requests;

class testimportexcel extends Controller
{
    //
    public function importExcel()
    {
		$path = Input::file('uploadfile')->getRealPath();
		$data = Excel::load($path, function($reader) {})->get();
		if(!empty($data) && $data->count()){
			foreach ($data as $key => $value) {
				$insert[] = ['title' => $value->title, 'description' => $value->description];
			}
			if(!empty($insert)){
				dd($insert);
			}
		}
    }

    public function exportExcel()	
    {
    	$type = 'xls';
		$data = [
					['emp number', 'last name', 'first_name'],
					['0001','condino', 'bryan'],
					['0002','brillantes', 'shei'],
				];
		return Excel::create('itsolutionstuff_example', function($excel) use ($data) 
			{
				$excel->sheet('mySheet', function($sheet) use ($data)
					{	
						$sheet->fromArray($data);
					});
			}
		)->download($type);
    }
}
