<?php

/*@author 
 *
Carlo Mendoza
 *
 */

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use PDF;
use FPDI;
use DB;

class PDFReportsController 
{
	public function getRformc($id) {

	$results = db::select(
			   db::raw("
	select 	    c.company_name,
			 	c.address,
			    p.month_trans,
			    p.year_trans,
				c.tin_no,
			 	c.bir_rdo_no,
			 	c.contact_no,
			 	c.city,
			 	c.zip,
				sum(case
					when p.entry_type = 'CR' AND p.payroll_element_id = '1' then entry_amt
						else 0
				 	end
				)e_amt,
				sum(case
				 	when p.entry_type = 'DB' and p.payroll_element_id = '2' then entry_amt
				  	when p.entry_type = 'DB' and p.payroll_element_id = '4' then entry_amt
				  	when p.entry_type = 'DB' and p.payroll_element_id = '5' then entry_amt
				 		else 0
				 	end
				)tax,
				(sum(case
					when p.entry_type = 'CR' and p.payroll_element_id = '1' then entry_amt
						else 0
	            	end
				) - 
				sum(case
				when p.entry_type = 'DB' and p.payroll_element_id = '2' then entry_amt
		  			 when p.entry_type = 'DB' and p.payroll_element_id = '4' then entry_amt
		  			 when p.entry_type = 'DB' and p.payroll_element_id = '5' then entry_amt
						else 0
		 			end
				))net
	from      	hr.tbl_payroll p 
	right join  hr.tbl_company c ON c.company_id = p.company_id
	where     	c.company_id = '$id'
	group by  	c.company_name,
				c.address, 
				p.month_trans, 
				p.year_trans, 
				c.tin_no, 
				c.bir_rdo_no, 
				c.contact_no, 
				c.city, 
				c.zip

			          ")
					);

	foreach($results as $result) {
			
	$DATA = [
		    'fld1'  => $result -> month_trans,
		   	'fld1a' => $result -> year_trans,
			'fld3'  => '2',
			'fld5'  => $result -> tin_no,
			'fld6'  => $result -> bir_rdo_no,
			'fld8'  => $result -> company_name,
			'fld9'  => $result -> contact_no,
			'fld10' => $result -> address. '  ' .$result -> city ,
			'fld11' => $result -> zip,
			'fld12' => 'X',
			'fld15' => $result -> e_amt,
			'fld16' => $result -> tax,
			'fld17' => '',
			'fld18' => '',
			'fld19' => '',
			'fld19a' => $result -> net,
			'fld20' => '',
			'fld21' => '',
			'fld22' => '',
			'fld23' => '',
			'fld24' => '',
			'fld25' => '',
			'fld26' => '',
			'fld27' => '',
			'fld28' => '',
			'fld29' => '',
			'fld30' => '',
			'fld31' => '',
			'fld32' => '',
			'fld33' => '',
			'fld34' => '',
			'fld35' => '',
			'fld36' => '',
			'fld37' => '',
			'fld38' => '',
			'fld39' => '',
			'fld40' => '',
			'fld41' => '',
			'fld42' => '',
			'fld43' => '',
			'fld44' => '',
			'fld45' => '',
			'fld46' => '',
			'fld47' => '',
			'fld48' => '',
			'fld49' => '',
			'fld50' => '',
			'fld51' => '',
			'fld52' => '',
			'fld53' => '',
			'sheets'  => '',
			];
	}

		PDF::loadView('rformc',$DATA) ->save(public_path().'/pdfs/rformc_val.pdf');	
		$new_pdf = new FPDI();
		$new_pdf->setSourceFile(public_path().'/pdfs/rformc_template.pdf');
		$backId = $new_pdf->importPage(1);
		$backId2 = $new_pdf->importPage(2);
		$size = $new_pdf -> getTemplateSize($backId);
		$pageCount = $new_pdf->setSourceFile(public_path().'/pdfs/rformc_val.pdf');
		for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {	
			if ($pageNo <= 2) {
				$new_pdf->AddPage();   			
				if ($pageNo == 1) {
					$new_pdf->useTemplate($backId, null, null, $size['w'], $size['h'], true);			
				} elseif ($pageNo == 2) {
					$new_pdf->useTemplate($backId2, null, null, $size['w'], $size['h'], true);
				}
			}	
			$pageId = $new_pdf->importPage($pageNo);		
			$new_pdf->useTemplate($pageId, null, null, $size['w'], $size['h'], true);
		}	
		return $new_pdf-> Output();
	} 

	public function getRforme($id)
	{

	$results = db::select(
			   db::raw("
	select 		p.month_trans,
			   	p.year_trans,
			   	c.tin_no,
			   	c.bir_rdo_no,
			   	c.company_name,
			   	c.contact_no,
			   	c.address,
			   	c.city,
			   	c.zip
	from 	 	hr.tbl_company AS c 
	right join 	hr.tbl_payroll AS p on c.company_id = p.company_id
	where  		c.company_id = '$id'
	group by 	p.month_trans, 
			    p.year_trans, 
			   	c.tin_no, 
			   	c.bir_rdo_no, 
			   	c.company_name, 
			   	c.contact_no, 
			   	c.address, 
			   	c.zip, 
			   	c.city
			   	")
			);

	foreach($results as $result) {

	$DATA = 
			['fld1' => $result -> month_trans,
			 'fld2' => $result -> year_trans,
			 'fld3' => $result -> tin_no,
			 'fld4' => $result -> bir_rdo_no,
			 'fld5' => $result -> company_name,
			 'fld6' => $result -> contact_no,
			 'fld7' => $result -> address. ' ' .$result -> city,
			 'fld8' => $result -> zip,
			 'fld9' => 'X',
			 'shts' => '1',
			 'sheets' => '',
			]; 
	}

		PDF::loadView('rforme', $DATA) -> save(public_path().'/pdfs/rforme_val.pdf');
		$new_pdf = new FPDI();
		$new_pdf -> setSourceFile(public_path().'/pdfs/rforme_template.pdf');
		$backpage = $new_pdf -> importPage(1);
		$size = $new_pdf -> getTemplateSize($backpage);
		$pageCount = $new_pdf -> setSourceFile(public_path().'/pdfs/rforme_val.pdf');
		for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
			$new_pdf -> AddPage();
			$new_pdf -> useTemplate($backpage, null, null, $size['w'], $size['h'], true);
			$pageId = $new_pdf -> importPage($pageNo);
			$new_pdf -> useTemplate($pageId, null, null, $size['w'], $size['h'], true);
		}
		return $new_pdf -> Output();
	}

	public function getRformf($id)
	{
	$results =  db::select(
			   	db::raw("
	select 	 	p.month_trans,
			   	p.year_trans,
			   	c.tin_no,
			   	c.bir_rdo_no,
			   	c.company_name,
			   	c.contact_no,
			   	c.address,
			   	c.city,
			   	c.zip
	from 	 	hr.tbl_company AS c 
	join 		hr.tbl_payroll AS p on c.company_id = p.company_id
	where       c.company_id = '$id'
	group by 	p.month_trans, 
			   	p.year_trans, 
			   	c.tin_no, 
			   	c.bir_rdo_no, 
			   	c.company_name, 
			   	c.contact_no, 
			   	c.address, 
			   	c.zip, 
			   	c.city
				   ")
				);

	foreach($results as $result) {

	$DATA = 
			['fld1' => $result -> month_trans,
			 'fld2' => $result -> year_trans,
			 'fld3' => $result -> tin_no,
			 'fld4' => $result -> bir_rdo_no,
			 'fld5' => $result -> company_name,
			 'fld6' => $result -> contact_no,
			 'fld7' => $result -> address. ' ' .$result -> city,
			 'fld8' => $result -> zip,
			 'fld9' => 'X',
			 'shts' => '1',
			 'sheets' => '',
			];
	}
		PDF::loadView('rformf', $DATA) -> save(public_path() .'/pdfs/rformf_val.pdf');
		$new_pdf = new FPDI();
		$new_pdf -> setSourceFile(public_path().'/pdfs/rformf_template.pdf');
		$back_page_1 = $new_pdf -> importPage(1);
		$back_page_2 = $new_pdf -> importPage(2);
		$back_page_3 = $new_pdf -> importPage(3);
		$size = $new_pdf -> getTemplateSize($back_page_1);
		$pageCount = $new_pdf -> setSourceFile(public_path().'/pdfs/rformf_val.pdf');
		for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
			if ($pageNo <= 3) {
				$new_pdf -> AddPage();

				if ($pageNo == 1) {
					$new_pdf -> useTemplate($back_page_1, null, null, $size['w'], $size['h'], true);
				} elseif ($pageNo == 2) {
					$new_pdf -> useTemplate($back_page_2, null, null, $size['w'], $size['h'], true);
					$new_pdf -> SetXY(175, 68);
				} else {
					$new_pdf -> useTemplate($back_page_3, null, null, $size['w'], $size['h'], true);
				}
				$pageId = $new_pdf -> importPage($pageNo);
				$new_pdf -> useTemplate($pageId, null, null, $size['w'], $size['h'], true);
			}
		}
		return $new_pdf -> Output();
	}
}