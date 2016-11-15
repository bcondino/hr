<?php

namespace App\Http\Classes;

use App\tbl_payroll_element_model;
use App\tbl_payroll_mode_model;
use App\tbl_philhealth_model;
use App\tbl_sss_model;
use App\tbl_pagibig_model;
use App\tbl_tax_code_model;
use App\tbl_tax_model;
use App\tbl_tax_annual_model;
use App\tbl_wage_order_model;

class AutoSeed
{
	public function company_autoseed($company_id)
	/* Auto seeding processes after company creation */
	{
		/* Auto seeding of payroll elements table for company */
		$seed_elements = [
			['1', 'CR', 'Basic Salary', 'Basic Salary', '', $company_id, 'Y', 'Y', 'N', 'N', 'N', 'Y', 'N', 'Y', 'Y', 'N', 'N', 'Y', 0, 'Y', '', '', '', '', 'Y'],
			['2', 'DB', 'SSS Contribution (Employee)', 'SSS Dedn (Employee)', '', $company_id, 'N', 'N', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'Y', 0, 'Y', '', '', '', '', 'Y'],
			['3', 'DB', 'GSIS Contribution (Employee)', 'GSIS Dedn (Employee)', '', $company_id, 'N', 'N', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'Y', 0, 'Y', '', '', '', '', 'Y'],
			['4', 'DB', 'Philhealth Contribution (Employee)', 'Philhealth Dedn (Employee)', '', $company_id, 'N', 'N', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'Y', 0, 'Y', '', '', '', '', 'Y'],
			['5', 'DB', 'HDMF Contribution (Employee)', 'HDMF Dedn (Employee)', '', $company_id, 'N', 'N', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'Y', 0, 'Y', '', '', '', '', 'Y'],
			['6', 'EE', 'SSS Contribution (Employer)', 'SSS Dedn (Employer)', '', $company_id, 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'Y', 0, 'Y', '', '', '', '', 'Y'],
			['7', 'EE', 'SSS EC (Employer)', 'EC Dedn (Employer)', '', $company_id, 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'Y', 0, 'Y', '', '', '', '', 'Y'],
			['8', 'EE', 'GSIS Contribution (Employer)', 'GSIS Dedn (Employer)', '', $company_id, 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'Y', 0, 'Y', '', '', '', '', 'Y'],
			['9', 'EE', 'GSIS EC (Employer)', 'GSIS EC (Employer)', '', $company_id, 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'Y', 0, 'Y', '', '', '', '', 'Y'],
			['10', 'EE', 'Philhealth Contribution (Employer)', 'Philhealth Dedn (Employer)', '', $company_id, 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'Y', 0, 'Y', '', '', '', '', 'Y'],
			['11', 'EE', 'HDMF Contribution (Employer)', 'HDMF Dedn (Employer)', '', $company_id, 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'Y', 0, 'Y', '', '', '', '', 'Y'],
			['12', 'DB', 'Withholding Tax', 'Withholding Tax', '', $company_id, 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'Y', 0, 'Y', '', '', '', '', 'Y'],
		];

		foreach ($seed_elements as $row) {
			$insert_elements[] = ['payroll_element_id' => $row[0]
			, 'entry_type' => $row[1]
			, 'description' => $row[2]
			, 'gl_description' => $row[3]
			, 'tran_code' => $row[4]
			, 'company_id' => $row[5]
			, 'taxable_flag' => $row[6]
			, 'regular_flag' => $row[7]
			, 'tax_exempt_flag' => $row[8]
			, 'fb_tax_flag' => $row[9]
			, 'deminimis_flag' => $row[10]
			, 'sss_flag' => $row[11]
			, 'gsis_flag' => $row[12]
			, 'pagibig_flag' => $row[13]
			, 'philhealth_flag' => $row[14]
			, 'loan_flag' => $row[15]
			, 'per_employee_flag' => $row[16]
			, 'predefine_flag' => $row[17]
			, 'priority_no' => $row[18]
			, 'show_payslip' => $row[19]
			, 'active_flag' => $row[24]
			];
		}

		tbl_payroll_element_model::insert($insert_elements);
		/* End of auto seeding of payroll elements table for company */
		
		/* Auto seeding of payroll modes table for company */
		$seed_paymodes = [
			['MO','Monthly',1,'MO',$company_id,'Y'],
			['SM','Semi-Monthly',2,'SM',$company_id,'Y'],
			['WK','Weekly',1,'WK',$company_id,'Y'],
		];
		
		foreach ($seed_paymodes as $row) {
			$insert_paymodes[] = ['payroll_mode' => $row[0]
			, 'description' => $row[1]
			, 'no_of_payment' => $row[2]
			, 'tax_mode' => $row[3]
			, 'company_id' => $row[4]
			, 'active_flag' => $row[5]
			];
		}
		
		tbl_payroll_mode_model::insert($insert_paymodes);
		/* End of auto seeding of payroll modes table for company */
		
		/* Auto seeding of philhealth table for company */
		$seed_philhealth = [
			[0,		8999.99,	8000,	200,	100,	100,	$company_id,	1],
			[9000,	9999.99,	9000,	225,	112.5,	112.5,	$company_id,	2],
			[10000,	10999.99,	10000,	250,	125,	125,	$company_id,	3],
			[11000,	11999.99,	11000,	275,	137.5,	137.5,	$company_id,	4],
			[12000,	12999.99,	12000,	300,	150,	150,	$company_id,	5],
			[13000,	13999.99,	13000,	325,	162.5,	162.5,	$company_id,	6],
			[14000,	14999.99,	14000,	350,	175,	175,	$company_id,	7],
			[15000,	15999.99,	15000,	375,	187.5,	187.5,	$company_id,	8],
			[16000,	16999.99,	16000,	400,	200,	200,	$company_id,	9],
			[17000,	17999.99,	17000,	425,	212.5,	212.5,	$company_id,	10],
			[18000,	18999.99,	18000,	450,	225,	225,	$company_id,	11],
			[19000,	19999.99,	19000,	475,	237.5,	237.5,	$company_id,	12],
			[20000,	20999.99,	20000,	500,	250,	250,	$company_id,	13],
			[21000,	21999.99,	21000,	525,	262.5,	262.5,	$company_id,	14],
			[22000,	22999.99,	22000,	550,	275,	275,	$company_id,	15],
			[23000,	23999.99,	23000,	575,	287.5,	287.5,	$company_id,	16],
			[24000,	24999.99,	24000,	600,	300,	300,	$company_id,	17],
			[25000,	25999.99,	25000,	625,	312.5,	312.5,	$company_id,	18],
			[26000,	26999.99,	26000,	650,	325,	325,	$company_id,	19],
			[27000,	27999.99,	27000,	675,	337.5,	337.5,	$company_id,	20],
			[28000,	28999.99,	28000,	700,	350,	350,	$company_id,	21],
			[29000,	29999.99,	29000,	725,	362.5,	362.5,	$company_id,	22],
			[30000,	30999.99,	30000,	750,	375,	375,	$company_id,	23],
			[31000,	31999.99,	31000,	775,	387.6,	387.6,	$company_id,	24],
			[32000,	32999.99,	32000,	800,	400,	400,	$company_id,	25],
			[33000,	33999.99,	33000,	825,	412.5,	412.5,	$company_id,	26],
			[34000,	34999.99,	340000,	850,	425,	425,	$company_id,	27],
			[35000,	999999.99,	350000,	875,	437.5,	437.5,	$company_id,	28],	
		];
		
		foreach ($seed_philhealth as $row) {
			$insert_philhealth[] = ['range_from' => $row[0]
			, 'range_to' => $row[1]
			, 'salary_base' => $row[2]
			, 'ee_cont' => $row[4]
			, 'er_cont' => $row[5]
			, 'company_id' => $row[6]
			, 'msb' => $row[7]
			];
		}
		
		tbl_philhealth_model::insert($insert_philhealth);
		/* End of auto seeding of philhealth table for company */
		
		/* Auto seeding of sss table for company */
		$seed_sss = [
			[1000	,1249.99	,36.3	,73.7	,10	,$company_id],
			[1250	,1749.99	,54.5	,110.5	,10	,$company_id],
			[1750	,2249.99	,72.7	,147.3	,10	,$company_id],
			[2250	,2749.99	,90.8	,184.2	,10	,$company_id],
			[2750	,3249.99	,109	,221	,10	,$company_id],
			[3250	,3749.99	,127.2	,257.8	,10	,$company_id],
			[3750	,4249.99	,145.3	,294.7	,10	,$company_id],
			[4250	,4749.99	,163.5	,331.5	,10	,$company_id],
			[4750	,5249.99	,181.7	,368.3	,10	,$company_id],
			[5250	,5749.99	,199.8	,405.2	,10	,$company_id],
			[5750	,6249.99	,218	,442	,10	,$company_id],
			[6250	,6749.99	,236.2	,478.8	,10	,$company_id],
			[6750	,7249.99	,254.3	,515.7	,10	,$company_id],
			[7250	,7749.99	,272.5	,552.5	,10	,$company_id],
			[7750	,8249.99	,290.7	,589.3	,10	,$company_id],
			[8250	,8749.99	,308.8	,626.2	,10	,$company_id],
			[8750	,9249.99	,327	,663	,10	,$company_id],
			[9250	,9749.99	,345.2	,699.8	,10	,$company_id],
			[9750	,10249.99	,363.3	,736.7	,10	,$company_id],
			[10250	,10749.99	,381.5	,773.5	,10	,$company_id],
			[10750	,11249.99	,399.7	,810.3	,10	,$company_id],
			[11250	,11749.99	,417.8	,847.2	,10	,$company_id],
			[11750	,12249.99	,436	,884	,10	,$company_id],
			[12250	,12749.99	,454.2	,920.8	,10	,$company_id],
			[12750	,13249.99	,472.3	,957.7	,10	,$company_id],
			[13250	,13749.99	,490.5	,994.5	,10	,$company_id],
			[13750	,14249.99	,508.7	,1031.3	,10	,$company_id],
			[14250	,14749.99	,526.8	,1068.2	,10	,$company_id],
			[14750	,15249.99	,545	,1105	,30	,$company_id],
			[15250	,15749.99	,563.2	,1141.8	,30	,$company_id],
			[15750	,99999999	,581.3	,1178.7	,30	,$company_id],
		];
		
		foreach ($seed_sss as $row) {
			$insert_sss[] = ['range_from' => $row[0]
			, 'range_to' => $row[1]
			, 'ee_sss_cont' => $row[2]
			, 'er_sss_cont' => $row[3]
			, 'er_ec_cont' => $row[4]
			, 'company_id' => $row[5]
			];
		}
		
		tbl_sss_model::insert($insert_sss);
		/* End of auto seeding of sss table for company */
		
		/* Auto seeding of hdmf table for company */
		$seed_hdmf = [
			[0, 1500, 15, 30, 0.01, 0.02, $company_id, 'Y'],
			[1501, 999999999, 100, 100, 0.02, 0.02, $company_id, 'Y'],
		];
		
		foreach ($seed_hdmf as $row) {
			$insert_hdmf[] = ['range_from' => $row[0]
			, 'range_to' => $row[1]
			, 'ee_cont' => $row[2]
			, 'er_cont' => $row[3]
			, 'ee_cont_percent' => $row[4]
			, 'er_cont_percent' => $row[5]
			, 'company_id' => $row[6]
			, 'active_flag' => $row[7]
			];
		}
		
		tbl_pagibig_model::insert($insert_hdmf);
		/* End of auto seeding of hdmf table for company */
		
		/* Auto seeding of tax codes table for company */
		$seed_taxcodes = [
			['S','Single',50000.00,$company_id,'Y'],
			['S1','Single with 1 dependent',75000.00,$company_id,'Y'],
			['S2','Single with 2 dependents',100000.00,$company_id,'Y'],
			['S3','Single with 3 dependents',125000.00,$company_id,'Y'],
			['S4','Single with 4 dependents',150000.00,$company_id,'Y'],
			['M','Married',50000.00,$company_id,'Y'],
			['M1','Married with 1 dependent',75000.00,$company_id,'Y'],
			['M2','Married with 2 dependents',100000.00,$company_id,'Y'],
			['M3','Married with 3 dependents',125000.00,$company_id,'Y'],
			['M4','Married with 4 dependents',150000.00,$company_id,'Y'],
			['N','No Tax',0.00,$company_id,'Y'],
			['Z','Zero Exemption',0.00,$company_id,'Y'],
		];
		
		foreach ($seed_taxcodes as $row) {
			$insert_taxcodes[] = ['tax_code' => $row[0]
			, 'description' => $row[1]
			, 'exemption_amount' => $row[2]
			, 'company_id' => $row[3]
			, 'active_flag' => $row[4]
			];
		}
		
		tbl_tax_code_model::insert($insert_taxcodes);
		/* End of auto seeding of tax codes table for company */
		
		/* Auto seeding of tax table for company */
		$seed_tax = [
			['DA'	,'Z',	0	,33		,0.05	,0	,$company_id],
			['DA'	,'Z',	33	,99		,0.1	,1.65	,$company_id],
			['DA'	,'Z',	99	,231		,0.15	,8.25	,$company_id],
			['DA'	,'Z',	231	,462		,0.2	,28.05	,$company_id],
			['DA'	,'Z',	462	,825		,0.25	,74.26	,$company_id],
			['DA'	,'Z',	825	,1650		,0.3	,165.02	,$company_id],
			['DA'	,'Z',	1650	,99999999	,0.32	,412.54	,$company_id],						
			['DA'	,'S',	1	,165		,0	,0	,$company_id],
			['DA'	,'S',	165	,198		,0.05	,0	,$company_id],
			['DA'	,'S',	198	,264		,0.1	,1.65	,$company_id],
			['DA'	,'S',	264	,396		,0.15	,8.25	,$company_id],
			['DA'	,'S',	396	,627		,0.2	,28.05	,$company_id],
			['DA'	,'S',	627	,990		,0.25	,74.26	,$company_id],
			['DA'	,'S',	990	,1815		,0.3	,165.02	,$company_id],
			['DA'	,'S',	1815	,99999999	,0.32	,412.54	,$company_id],						
			['DA'	,'S1',	1	,248		,0	,0	,$company_id],
			['DA'	,'S1',	248	,281		,0.05	,0	,$company_id],
			['DA'	,'S1',	281	,347		,0.1	,1.65	,$company_id],
			['DA'	,'S1',	347	,479		,0.15	,8.25	,$company_id],
			['DA'	,'S1',	479	,710		,0.2	,28.05	,$company_id],
			['DA'	,'S1',	710	,1073		,0.25	,74.26	,$company_id],
			['DA'	,'S1',	1073	,1898		,0.3	,165.02	,$company_id],
			['DA'	,'S1',	1898	,99999999	,0.32	,412.54	,$company_id],						
			['DA'	,'S2',	1	,330		,0	,0	,$company_id],
			['DA'	,'S2',	330	,363		,0.05	,0	,$company_id],
			['DA'	,'S2',	363	,429		,0.1	,1.65	,$company_id],
			['DA'	,'S2',	429	,561		,0.15	,8.25	,$company_id],
			['DA'	,'S2',	561	,792		,0.2	,28.05	,$company_id],
			['DA'	,'S2',	792	,1155		,0.25	,74.26	,$company_id],
			['DA'	,'S2',	1155	,1980		,0.3	,165.02	,$company_id],
			['DA'	,'S2',	1980	,99999999	,0.32	,412.54	,$company_id],						
			['DA'	,'S3',	1	,413		,0	,0	,$company_id],
			['DA'	,'S3',	413	,446		,0.05	,0	,$company_id],
			['DA'	,'S3',	446	,512		,0.1	,1.65	,$company_id],
			['DA'	,'S3',	512	,644		,0.15	,8.25	,$company_id],
			['DA'	,'S3',	644	,875		,0.2	,28.05	,$company_id],
			['DA'	,'S3',	875	,1238		,0.25	,74.26	,$company_id],
			['DA'	,'S3',	1238	,2063		,0.3	,165.02	,$company_id],
			['DA'	,'S3',	2063	,99999999	,0.32	,412.54	,$company_id],						
			['DA'	,'S4',	1	,495		,0	,0	,$company_id],
			['DA'	,'S4',	495	,528		,0.05	,0	,$company_id],
			['DA'	,'S4',	528	,594		,0.1	,1.65	,$company_id],
			['DA'	,'S4',	594	,726		,0.15	,8.25	,$company_id],
			['DA'	,'S4',	726	,957		,0.2	,28.05	,$company_id],
			['DA'	,'S4',	957	,1320		,0.25	,74.26	,$company_id],
			['DA'	,'S4',	1320	,2145		,0.3	,165.02	,$company_id],
			['DA'	,'S4',	2145	,99999999	,0.32	,412.54	,$company_id],						
			['DA'	,'M',	1	,165		,0	,0	,$company_id],
			['DA'	,'M',	165	,198		,0.05	,0	,$company_id],
			['DA'	,'M',	198	,264		,0.1	,1.65	,$company_id],
			['DA'	,'M',	264	,396		,0.15	,8.25	,$company_id],
			['DA'	,'M',	396	,627		,0.2	,28.05	,$company_id],
			['DA'	,'M',	627	,990		,0.25	,74.26	,$company_id],
			['DA'	,'M',	990	,1815		,0.3	,165.02	,$company_id],
			['DA'	,'M',	1815	,99999999	,0.32	,412.54	,$company_id],						
			['DA'	,'M1',	1	,248		,0	,0	,$company_id],
			['DA'	,'M1',	248	,281		,0.05	,0	,$company_id],
			['DA'	,'M1',	281	,347		,0.1	,1.65	,$company_id],
			['DA'	,'M1',	347	,479		,0.15	,8.25	,$company_id],
			['DA'	,'M1',	479	,710		,0.2	,28.05	,$company_id],
			['DA'	,'M1',	710	,1073		,0.25	,74.26	,$company_id],
			['DA'	,'M1',	1073	,1898		,0.3	,165.02	,$company_id],
			['DA'	,'M1',	1898	,99999999	,0.32	,412.54	,$company_id],						
			['DA'	,'M2',	1	,330		,0	,0	,$company_id],
			['DA'	,'M2',	330	,363		,0.05	,0	,$company_id],
			['DA'	,'M2',	363	,429		,0.1	,1.65	,$company_id],
			['DA'	,'M2',	429	,561		,0.15	,8.25	,$company_id],
			['DA'	,'M2',	561	,792		,0.2	,28.05	,$company_id],
			['DA'	,'M2',	792	,1155		,0.25	,74.26	,$company_id],
			['DA'	,'M2',	1155	,1980		,0.3	,165.02	,$company_id],
			['DA'	,'M2',	1980	,99999999	,0.32	,412.54	,$company_id],						
			['DA'	,'M3',	1	,413		,0	,0	,$company_id],
			['DA'	,'M3',	413	,446		,0.05	,0	,$company_id],
			['DA'	,'M3',	446	,512		,0.1	,1.65	,$company_id],
			['DA'	,'M3',	512	,644		,0.15	,8.25	,$company_id],
			['DA'	,'M3',	644	,875		,0.2	,28.05	,$company_id],
			['DA'	,'M3',	875	,1238		,0.25	,74.26	,$company_id],
			['DA'	,'M3',	1238	,2063		,0.3	,165.02	,$company_id],
			['DA'	,'M3',	2063	,99999999	,0.32	,412.54	,$company_id],						
			['DA'	,'M4',	1	,495		,0	,0	,$company_id],
			['DA'	,'M4',	495	,528		,0.05	,0	,$company_id],
			['DA'	,'M4',	528	,594		,0.1	,1.65	,$company_id],
			['DA'	,'M4',	594	,726		,0.15	,8.25	,$company_id],
			['DA'	,'M4',	726	,957		,0.2	,28.05	,$company_id],
			['DA'	,'M4',	957	,1320		,0.25	,74.26	,$company_id],
			['DA'	,'M4',	1320	,2145		,0.3	,165.02	,$company_id],
			['DA'	,'M4',	2145	,99999999	,0.32	,412.54	,$company_id],
			['SM',	'Z',	0,		417,		0.05,	0,			$company_id],
			['SM',	'Z',	417,	1250,		0.1,	20.83,		$company_id],
			['SM',	'Z',	1250,	2917,		0.15,	104.17,		$company_id],
			['SM',	'Z',	2917,	5833,		0.2,	354.17,		$company_id],
			['SM',	'Z',	5833,	10417,		0.25,	937.5,		$company_id],
			['SM',	'Z',	10417,	20833,		0.3,	2083.33,	$company_id],
			['SM',	'Z',	20833,	99999999,	0.32,	5208.33,	$company_id],
			['SM',	'S',	1,		2083,		0,		0,			$company_id],
			['SM',	'S',	2083,	2500,		0.05,	0,			$company_id],
			['SM',	'S',	2500,	3333,		0.1,	20.83,		$company_id],
			['SM',	'S',	3333,	5000,		0.15,	104.17,		$company_id],
			['SM',	'S',	5000,	7917,		0.2,	354.17,		$company_id],
			['SM',	'S',	7917,	12500,		0.25,	937.5,		$company_id],
			['SM',	'S',	12500,	22917,		0.3,	2083.33,	$company_id],
			['SM',	'S',	22917,	99999999,	0.32,	5208.33,	$company_id],
			['SM',	'S1',	1,		3125,		0,		0,			$company_id],
			['SM',	'S1',	3125,	3542,		0.05,	0,			$company_id],
			['SM',	'S1',	3542,	4375,		0.1,	20.83,		$company_id],
			['SM',	'S1',	4375,	6042,		0.15,	104.17,		$company_id],
			['SM',	'S1',	6042,	8958,		0.2,	354.17,		$company_id],
			['SM',	'S1',	8958,	13542,		0.25,	937.5,		$company_id],
			['SM',	'S1',	13542,	23958,		0.3,	2083.33,	$company_id],
			['SM',	'S1',	23958,	99999999,	0.32,	5208.33,	$company_id],
			['SM',	'S2',	1,		4167,		0,		0,			$company_id],
			['SM',	'S2',	4167,	4583,		0.05,	0,			$company_id],
			['SM',	'S2',	4583,	5417,		0.1,	20.83,		$company_id],
			['SM',	'S2',	5417,	7083,		0.15,	104.17,		$company_id],
			['SM',	'S2',	7083,	10000,		0.2,	354.17,		$company_id],
			['SM',	'S2',	10000,	14583,		0.25,	937.5,		$company_id],
			['SM',	'S2',	14583,	25000,		0.3,	2083.33,	$company_id],
			['SM',	'S2',	25000,	99999999,	0.32,	5208.33,	$company_id],
			['SM',	'S3',	1,		5208,		0,		0,			$company_id],
			['SM',	'S3',	5208,	5625,		0.05,	0,			$company_id],
			['SM',	'S3',	5625,	6458,		0.1,	20.83,		$company_id],
			['SM',	'S3',	6458,	8125,		0.15,	104.17,		$company_id],
			['SM',	'S3',	8125,	11042,		0.2,	354.17,		$company_id],
			['SM',	'S3',	11042,	15625,		0.25,	937.5,		$company_id],
			['SM',	'S3',	15625,	26042,		0.3,	2083.33,	$company_id],
			['SM',	'S3',	26042,	999999,		0.32,	5208.33,	$company_id],
			['SM',	'S4',	1,		6250,		0,		0,			$company_id],
			['SM',	'S4',	6250,	6667,		0.05,	0,			$company_id],
			['SM',	'S4',	6667,	7500,		0.1,	20.83,		$company_id],
			['SM',	'S4',	7500,	9167,		0.15,	104.17,		$company_id],
			['SM',	'S4',	9167,	12083,		0.2,	354.17,		$company_id],
			['SM',	'S4',	12083,	16667,		0.25,	937.5,		$company_id],
			['SM',	'S4',	16667,	27083,		0.3,	2083.33,	$company_id],
			['SM',	'S4',	27083,	99999999,	0.32,	5208.33,	$company_id],
			['MO',	'Z',	0,		833,		0.05,	0,			$company_id],
			['MO',	'Z',	833,	2500,		0.1,	41.67,		$company_id],
			['MO',	'Z',	2500	,5833		,0.15	,208.33     ,$company_id],
			['MO',	'Z',	5833	,11667		,0.2	,708.33     ,$company_id],
			['MO',	'Z',	11667	,20833		,0.25	,1875       ,$company_id],
			['MO',	'Z',	20833	,41667		,0.3	,4166.67    ,$company_id],
			['MO',	'Z',	41667	,99999999	,0.32	,10416.67   ,$company_id],					
			['MO',	'S',	1	,4167		,0	,0	    ,$company_id],
			['MO',	'S',	4167	,5000		,0.05	,0          ,$company_id],
			['MO',	'S',	5000	,6667		,0.1	,41.67      ,$company_id],
			['MO',	'S',	6667	,10000		,0.15	,208.33     ,$company_id],
			['MO',	'S',	10000	,15833		,0.2	,708.33     ,$company_id],
			['MO',	'S',	15833	,25000		,0.25	,1875       ,$company_id],
			['MO',	'S',	25000	,45833		,0.3	,4166.67    ,$company_id],
			['MO',	'S',	45833	,99999999	,0.32	,10416.67   ,$company_id],					
			['MO',	'S1',	1	,6250		,0	,0	    ,$company_id],
			['MO',	'S1',	6250	,7083		,0.05	,0          ,$company_id],
			['MO',	'S1',	7083	,8750		,0.1	,41.67      ,$company_id],
			['MO',	'S1',	8750	,12083		,0.15	,208.33     ,$company_id],
			['MO',	'S1',	12083	,17917		,0.2	,708.33     ,$company_id],
			['MO',	'S1',	17917	,27083		,0.25	,1875       ,$company_id],
			['MO',	'S1',	27083	,47917		,0.3	,4166.67    ,$company_id],
			['MO',	'S1',	47917	,99999999	,0.32	,10416.67   ,$company_id],					
			['MO',	'S2',	1	,8333		,0	,0	    ,$company_id],
			['MO',	'S2',	8333	,9167		,0.05	,0          ,$company_id],
			['MO',	'S2',	9167	,10833		,0.1	,41.67      ,$company_id],
			['MO',	'S2',	10833	,14167		,0.15	,208.33     ,$company_id],
			['MO',	'S2',	14167	,20000		,0.2	,708.33     ,$company_id],
			['MO',	'S2',	20000	,29167		,0.25	,1875       ,$company_id],
			['MO',	'S2',	29167	,50000		,0.3	,4166.67    ,$company_id],
			['MO',	'S2',	50000	,99999999	,0.32	,10416.67   ,$company_id],					
			['MO',	'S3',	1	,10417		,0	,0	    ,$company_id],
			['MO',	'S3',	10417	,11250		,0.05	,0          ,$company_id],
			['MO',	'S3',	11250	,12917		,0.1	,41.67      ,$company_id],
			['MO',	'S3',	12917	,16250		,0.15	,208.33     ,$company_id],
			['MO',	'S3',	16250	,22083		,0.2	,708.33     ,$company_id],
			['MO',	'S3',	22083	,31250		,0.25	,1875       ,$company_id],
			['MO',	'S3',	31250	,52083		,0.3	,4166.67    ,$company_id],
			['MO',	'S3',	52083	,99999999	,0.32	,10416.67   ,$company_id],					
			['MO',	'S4',	1	,12500		,0	,0          ,$company_id],
			['MO',	'S4',	12500	,13333		,0.05	,0          ,$company_id],
			['MO',	'S4',	13333	,15000		,0.1	,41.67      ,$company_id],
			['MO',	'S4',	15000	,18333		,0.15	,208.33     ,$company_id],
			['MO',	'S4',	18333	,24167		,0.2	,708.33     ,$company_id],
			['MO',	'S4',	24167	,33333		,0.25	,1875       ,$company_id],
			['MO',	'S4',	33333	,54167		,0.3	,4166.67    ,$company_id],
			['MO',	'S4',	54167	,99999999	,0.32	,10416.67   ,$company_id],					
			['MO',	'M',	1	,4167		,0	,0          ,$company_id],
			['MO',	'M',	4167	,5000		,0.05	,0          ,$company_id],
			['MO',	'M',	5000	,6667		,0.1	,41.67      ,$company_id],
			['MO',	'M',	6667	,10000		,0.15	,208.33     ,$company_id],
			['MO',	'M',	10000	,15833		,0.2	,708.33     ,$company_id],
			['MO',	'M',	15833	,25000		,0.25	,1875       ,$company_id],
			['MO',	'M',	25000	,45833		,0.3	,4166.67    ,$company_id],
			['MO',	'M',	45833	,99999999	,0.32	,10416.67   ,$company_id],					
			['MO',	'M1',	1	,6250		,0	,0	    ,$company_id],
			['MO',	'M1',	6250	,7083		,0.05	,0          ,$company_id],
			['MO',	'M1',	7083	,8750		,0.1	,41.67      ,$company_id],
			['MO',	'M1',	8750	,12083		,0.15	,208.33     ,$company_id],
			['MO',	'M1',	12083	,17917		,0.2	,708.33     ,$company_id],
			['MO',	'M1',	17917	,27083		,0.25	,1875       ,$company_id],
			['MO',	'M1',	27083	,47917		,0.3	,4166.67    ,$company_id],
			['MO',	'M1',	47917	,99999999	,0.32	,10416.67   ,$company_id],					
			['MO',	'M2',	1	,8333		,0	,0	    ,$company_id],
			['MO',	'M2',	8333	,9167		,0.05	,0          ,$company_id],
			['MO',	'M2',	9167	,10833		,0.1	,41.67      ,$company_id],
			['MO',	'M2',	10833	,14167		,0.15	,208.33     ,$company_id],
			['MO',	'M2',	14167	,20000		,0.2	,708.33     ,$company_id],
			['MO',	'M2',	20000	,29167		,0.25	,1875       ,$company_id],
			['MO',	'M2',	29167	,50000		,0.3	,4166.67    ,$company_id],
			['MO',	'M2',	50000	,99999999	,0.32	,10416.67   ,$company_id],					
			['MO',	'M3',	1	,10417		,0	,0	    ,$company_id],
			['MO',	'M3',	10417	,11250		,0.05	,0          ,$company_id],
			['MO',	'M3',	11250	,12917		,0.1	,41.67      ,$company_id],
			['MO',	'M3',	12917	,16250		,0.15	,208.33     ,$company_id],
			['MO',	'M3',	16250	,22083		,0.2	,708.33     ,$company_id],
			['MO',	'M3',	22083	,31250		,0.25	,1875       ,$company_id],
			['MO',	'M3',	31250	,52083		,0.3	,4166.67    ,$company_id],
			['MO',	'M3',	52083	,99999999	,0.32	,10416.67   ,$company_id],				
			['MO',	'M4',	1	,12500		,0	,0	    ,$company_id],
			['MO',	'M4',	12500	,13333		,0.05	,0          ,$company_id],
			['MO',	'M4',	13333	,15000		,0.1	,41.67      ,$company_id],
			['MO',	'M4',	15000	,18333		,0.15	,208.33     ,$company_id],
			['MO',	'M4',	18333	,24167		,0.2	,708.33     ,$company_id],
			['MO',	'M4',	24167	,33333		,0.25	,1875       ,$company_id],
			['MO',	'M4',	33333	,54167		,0.3	,4166.67    ,$company_id],
			['MO',	'M4',	54167	,99999999	,0.32	,10416.67   ,$company_id],
		];
		
		foreach ($seed_tax as $row) {
			$insert_tax[] = ['tax_mode' => $row[0]
			, 'tax_code' => $row[1]
			, 'range_from' => $row[2]
			, 'range_to' => $row[3]
			, 'percentage' => $row[4]
			, 'fix_amount' => $row[5]
			, 'company_id' => $row[6]
			];
		}
		
		tbl_tax_model::insert($insert_tax);
		/* End of auto seeding of tax table for company */
		
		/* Auto seeding of annual tax table for company */
		$seed_annual = [
			[0		,10000		,0.05	,0		,$company_id],
			[10000	,30000		,0.1	,500	,$company_id],
			[30000	,70000		,0.15	,2500	,$company_id],
			[70000	,140000		,0.2	,8500	,$company_id],
			[140000	,250000		,0.25	,22500	,$company_id],
			[250000	,500000		,0.3	,50000	,$company_id],
			[500000	,99999999	,0.32	,125000	,$company_id],
		];
		
		foreach ($seed_annual as $row) {
			$insert_annual[] = ['range_from' => $row[0]
			, 'range_to' => $row[1]
			, 'percentage' => $row[2]
			, 'fix_amount' => $row[3]
			, 'company_id' => $row[4]
			];
		}
		
		tbl_tax_annual_model::insert($insert_annual);
		/* End of auto seeding of annual tax table for company */
		
		/* Auto seeding of wage order table for company */
		$seed_wageorder = [
			['NCR'	,'NCR'			,$company_id	,'WO 20'	,'2016-06-02'	,491	,14934.58333	,128151		,261],
			['CAR'	,'CAR'			,$company_id	,'WO 17'	,'2015-06-29'	,285	,8668.75		,74385		,261],
			['I'	,'Region I'		,$company_id	,'WO 17'	,'2015-07-19'	,253	,7695.416667	,66033		,261],
			['II'	,'Region II'	,$company_id	,'WO 17'	,'2016-05-14'	,300	,9125			,78300		,261],
			['III'	,'Region III'	,$company_id	,'WO 19'	,'2016-01-01'	,364	,11071.66667	,95004		,261],
			['IV-A'	,'Region IV-A'	,$company_id	,'WO 17'	,'2016-07-01'	,378.5	,11512.70833	,98788.5	,261],
			['IV-B'	,'Region IV-B'	,$company_id	,'WO 07'	,'2015-07-03'	,285	,8668.75		,74385		,261],
			['V'	,'Region V'		,$company_id	,'WO 17'	,'2015-12-25'	,265	,8060.416667	,69165		,261],
			['VI'	,'Region VI'	,$company_id	,'WO 22'	,'2015-05-02'	,298.5	,9079.375		,77908.5	,261],
			['VII'	,'Region VII'	,$company_id	,'WO 19'	,'2015-10-10'	,353	,10737.08333	,92133		,261],
			['VIII'	,'Region VIII'	,$company_id	,'WO 18'	,'2015-03-30'	,260	,7908.333333	,67860		,261],
			['IX'	,'Region IX'	,$company_id	,'WO 18'	,'2013-06-10'	,280	,8516.666667	,73080		,261],
			['X'	,'Region X'		,$company_id	,'WO 18'	,'2015-07-03'	,318	,9672.5			,82998		,261],
			['XI'	,'Region XI'	,$company_id	,'WO 18'	,'2014-06-01'	,317	,9642.083333	,82737		,261],
			['XII'	,'Region XII'	,$company_id	,'WO 18'	,'2014-08-01'	,275	,8364.583333	,71775		,261],
			['XIII'	,'Region XIII'	,$company_id	,'WO 14'	,'2016-07-01'	,275	,8364.583333	,71775		,261],
			['ARMM'	,'ARMM'			,$company_id	,'WO 16'	,'2016-03-01'	,265	,8060.416667	,69165		,261],
		];
		
		foreach ($seed_wageorder as $row) {
			$insert_wageorder[] = ['region' => $row[0]
			, 'description' => $row[1]
			, 'company_id' => $row[2]
			, 'wage_order' => $row[3]
			, 'effective_date' => $row[4]
			, 'per_day_amt' => $row[5]
			, 'per_month_amt' => $row[6]
			, 'per_year_amt' => $row[7]
			, 'factor' => $row[8]
			];
		}
		
		tbl_wage_order_model::insert($insert_wageorder);
		/* End of auto seeding of wage order table for company */
	}
}