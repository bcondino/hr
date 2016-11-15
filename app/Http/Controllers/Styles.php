<?php
namespace App\Http\Controllers;
use PHPExcel_Style_Alignment;
use PHPExcel_Style_Border;
use App\tbl_user_model;
use PDF;
use FPDI;

class Styles{

	function wrapSign() {
		return array(
			'alignment' => array(
				'wrap' => true,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_BOTTOM
				),
			'font' => array(
				'size' => 8,
				'bold' => true
				)
			);
	}

	function ft8wraptrue() {
		return array(
			'alignment' => array(
				'wrap' => true,
				),
			'font' => array(
				'size' => 8,
				'bold' => true
				)
			);
	}

	function empCount() {
		return array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' 	 => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'wrap' => true,
				),
			'font' => array(
				'bold' => true,
				'size' => 9,
			));
	}

	function leftAlign(){
		return array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
				'vertical' 	 => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				));	
	}
	function rightAlign(){
		return array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
				'vertical' 	 => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				));	
	}
	
	function getA1(){
		return array(
			'font' => array(
				'bold' => true,
				'size' => 22,
				),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' 	 => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				));	
	}

	function getBorder_rt() {
		return array(
			'borders' => array(
				'right' => array(
					'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
					'color' => array('argb' => '00000000')
					)));
	}

	function getBorder_tp() {
		return array(
			'borders' => array(
				'top' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('argb' => '00000000')
					)));
	}

	function getBorder_bt() {
		return array(
			'borders' => array(
				'bottom' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('argb' => '00000000')
					)));
	}

	function getVertHoriCenter() {
		return array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				));
	}

	function getAlign_rt() {
		return array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				));
	}

	function getAlign_lf() {
		return array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				));
	}

	function getHeadAlignRT() {
		return array(
			'font' => array(
				'bold' => true,
				'size' => 10,
				),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
				'vertical' 	 => PHPExcel_Style_Alignment::VERTICAL_CENTER,)
			);
	}

	function getHeadAlignLT() {
		return array(
			'font' => array(
				'size' => 10,
				),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,)
			);
	}

	function getInsThin() {
		return array(
			'borders' => array(
				'inside' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('argb' => '00000000')
					)));
	}

	function getInsMed() {
		return array(
			'borders' => array(
				'inside' => array(
					'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
					'color' => array('argb' => '00000000')
					)));
	}

	function getSize12Bold() {
		return array(
			'font' => array(
				'bold' => true,
				'size' => 12,
				));
	}

	function getWhite() {
		return array(
			'borders' => array(
				'inside' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('argb' => '00FFFFFF',),
					)));
	}

	function getBlack() {
		return array(
			'borders' => array(
				'outline' => array(
					'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
					'color' => array('argb' => '00000000')
					)));
	}

	function getFooter() {
		return array(
			'borders' => array(
				'right' => array(
					'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
					'color' => array('argb' => '00000000')
					),
				'bottom' => array(
					'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
					'color' => array('argb' => '00000000')
					)
				)
			);
	}

	function getFtSection10() {
		return array(
			'font' => array(
				'size' => 10,
				'bold' => true
				));
	}

	function getFtSection8() {
		return array(
			'font' => array(
				'size' => 8,
				'bold' => true
				));			
	}

	function getBold() {
		return array(
			'font' => array(
				'bold' => true
				));			
	}


	function getFtSection13() {
		return array(
			'font' => array(
				'size' => 8,
				),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
				));
	}

	function getFtSection14() {
		return array(
			'font' => array(
				'size' => 14,
				));

	}



}
