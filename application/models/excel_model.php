<?php

/**
 * @author Sonnk
 * @copyright 2013
 */
class excel_model extends CI_Model {

    function __construct() {
        parent::__construct('');
        $this->load->model();
    }
	public function exportExcel($objPHPExcel, $versionExcel = '', $fileName = '') {
        //2003 use 'Excel5'
		//ob_start();
        $extFile = $versionExcel == 'Excel2007' ? ".xlsx" : ".xls";

        if ($fileName == "")
            $fileName = date("yMdhis") . $extFile;
			
        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$fileName.'"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0
		ob_clean();
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, $versionExcel);
        $objWriter->save('php://output');
		
        exit;
    }
	public function mergeCells($sheetIndex,$clum){
		$sheetIndex->mergeCells($clum);
	}
	public function setBold($sheetIndex,$endClum){
		$styleArray = array(
				'font' => array('bold' => true)
		);
		$sheetIndex->getStyle($endClum)->applyFromArray($styleArray);
	}
	function setAutoSize($objPHPExcel, $start, $end){
		foreach(range($start,$end) as $columnID) {
			$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
				->setAutoSize(true);
		}
	}
	public function cv_int_str($clum){
		return PHPExcel_Cell::stringFromColumnIndex($clum);
	}
	public function setBorder($sheetIndex,$endClum){
		$sheetIndex->getStyle($endClum)
				   ->getBorders()
				   ->getAllBorders()
				   ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);	
	}
	public function setBackground($objPHPExcel,$cells,$color){
        $objPHPExcel->getActiveSheet()
					->getStyle($cells)
					->getFill()
					->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,
									'startcolor' => array('rgb' => $color)
					));
    }
	public function setBackgrounds($objPHPExcel,$clun,$row,$color){
        $objPHPExcel->getActiveSheet()
					->getStyleByColumnAndRow($clun,$row)
					->getFill()
					->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,
									'startcolor' => array('rgb' => $color)
					));
    }
	public function setAlign($sheetIndex,$clum,$align){
		if($align == 'right'){
			$sheetIndex->getStyle($clum)
			->getAlignment()
			->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		}
		else if($align == 'center'){
			$sheetIndex->getStyle($clum)
			->getAlignment()
			->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		}
		else{
			$sheetIndex->getStyle($clum)
			->getAlignment()
			->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		}
	}
	public function setAligns($sheetIndex,$clum,$row,$align){
		if($align == 'right'){
			$sheetIndex->getStyleByColumnAndRow($clum,$row)
			->getAlignment()
			->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		}
		else if($align == 'center'){
			$sheetIndex->getStyleByColumnAndRow($clum,$row)
			->getAlignment()
			->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		}
		else{
			$sheetIndex->getStyleByColumnAndRow($clum,$row)
			->getAlignment()
			->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		}
	}
	public function setVertical($sheetIndex,$clum, $align){
		if($align == 'top'){
			$sheetIndex->getStyle($clum)
			->getAlignment()
			->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
		}
		else if($align == 'bottom'){
			$sheetIndex->getStyle($clum)
			->getAlignment()
			->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_BOTTOM);
		}
		else if($align == 'center'){
			$sheetIndex->getStyle($clum)
			->getAlignment()
			->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		}	
	}
	public function setColor($sheetIndex,$clum,$color){	
		$styleArray = array(
			'font'  => array(
				//'bold'  => true,
				'color' => array('rgb' =>$color)
				//'size'  => 15,
				//'name'  => 'Verdana'
			));
		$sheetIndex->getStyle($clum)->applyFromArray($styleArray);
	}
	public function setColors($sheetIndex,$clum,$row,$color){	
		$styleArray = array(
			'font'  => array(
				//'bold'  => true,
				'color' => array('rgb' =>$color)
				//'size'  => 15,
				//'name'  => 'Verdana'
			));
		$sheetIndex->getStyleByColumnAndRow($clum,$row)->applyFromArray($styleArray);
	}
	public function setFontsize($sheetIndex,$clum,$size){	
		$styleArray = array(
			'font'  => array(
				//'bold'  => true,
				//'color' => array('rgb' =>$color)
				'size'  => $size,
				//'name'  => 'Verdana'
			));
		$sheetIndex->getStyle($clum)->applyFromArray($styleArray);
	}
	public function setFontsizes($sheetIndex,$clum,$row,$size){	
		$styleArray = array(
			'font'  => array(
				//'bold'  => true,
				//'color' => array('rgb' =>$color)
				'size'  => $size,
				//'name'  => 'Verdana'
			));
		$sheetIndex->getStyleByColumnAndRow($clum,$row)->applyFromArray($styleArray);
	}
}

?>