<?php
/**
 * PHPExcel
 *
 * Copyright (C) 2006 - 2012 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2012 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    1.7.8, 2012-10-12
 */

/** Error reporting */
/*
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set("Asia/Taipei");
*/
ini_set('display_errors', FALSE);
ini_set('display_startup_errors', FALSE);
date_default_timezone_set("Asia/Taipei");



function number_format2($num,$dec) {
	if ($num <> 0)
		if ($num > 0) {
			$retval = number_format($num,$dec);
		} else {
			$retval = 0;
		}
	else 
		$retval = 0;
		
	return $retval;
}

function percent2($num) {
	if ($num <> 0)
		//if ($num >= 100)
		//	$retval = "100%";
		//else
			$retval = $num;
	else 
		$retval = 0;
		
	return $retval;
}



$case_id = "C1";

//契約容量
$min_kw = (float)$row_web['lc_min_value'];
$base_kw = (float)$row_web['lc_base_value'];
$max_kw = (float)$row_web['lc_max_value'];
$limit_kw = (float)$row_web['lc_limit_value'];


$home = getlang("回首頁");
$goback = getlang("回上頁");
$Export_Excel= getlang("匯出Excel");

$mess_title = getlang("每15分鐘平均需量記錄/24小時");

$Inquire = getlang("查詢");

$year = getlang("年");
$month = getlang("月");
$day = getlang("日");
$hour = getlang("時");
$minute = getlang("分");
$Voltage = getlang("電壓");
$Current = getlang("電流");
$Watts = getlang("瓦數");
$Power_factor = getlang("功率因數");
$Kilowatt_hours = getlang("仟瓦小時");


$dataTable_de = getDataTable_de();
$Prompt = getlang("提示訊息");
$Confirm = getlang("確認");
$Cancel = getlang("取消");

$Close = getlang("關閉");
$goback = getlang("回上頁");


$mylang = $_COOKIE["lang"];
if ($mylang == "zh_TW") {
	$day = "日";
} else if ($mylang == "zh_CN") {
	$day = "日";
} else {
	$day = "day";
}





$fm = $_GET['fm'];
$ch = $_GET['ch'];

$auto_seq = $_GET['auto_seq'];


$t = $_GET['t'];

if (!isset($_GET['choice_date'])) {
	$choice_date = date("Y-m-d");
} else {
	$choice_date = $_GET['choice_date'];
}


$date_filter_str = "";
$date_query_str = "";

if (!empty($choice_date)) {
	$date_filter_str = "&choice_date=".$choice_date;
	$date_query_str = "AND str_to_date(CONCAT(dm_year,'-',dm_month,'-',dm_day), '%Y-%m-%d') = '$choice_date'";
}


//載入公用函數
@include_once '/website/include/pub_function.php';



//現在日期時間
$today = date('Y-m-d H:i');


@include_once("/website/class/".$site_db."_info_class.php");


if (PHP_SAPI == 'cli')
	die('This programe should only be run from a Web Browser');

/** Include PHPExcel */
require_once '/website/os/PHPExcel-1.8.1/Classes/PHPExcel.php';

$Close = getlang("關閉");



// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("apupu")
							 ->setLastModifiedBy("apupu")
							 ->setTitle("Office 2007 XLSX Document")
							 ->setSubject("Office 2007 XLSX Document")
							 ->setDescription("The document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("荒川_每日用電總量分析表_".$choice_date);

							 
//合併儲存格						 
$objPHPExcel->setActiveSheetIndex(0)
			->mergeCells('B1:H1')
			->mergeCells('B2:H2')
			->mergeCells('B3:E3')   // 左半邊
			->mergeCells('F3:H3');  // 右半邊
			;
							 
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B1', "")
            ->setCellValue('B2', '荒川_每日用電總量分析表')
            ->setCellValue('B3', '資料日期：' . $choice_date)
            ->setCellValue('F3', '報表日期：'.$today)
            ->setCellValue('B4', '電表序號')
            ->setCellValue('B4','年')
            ->setCellValue('C4','月')
            ->setCellValue('D4','日')
            ->setCellValue('E4','時')
            ->setCellValue('F4','最高需量 KW')
            ->setCellValue('G4','千瓦小時 KWH')
			->setCellValue('H4','千伏安時 KVAH')


			;

//設置字型大小
$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setSize(24)->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setSize(18)->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('B3')->getFont()->setSize(16);
$objPHPExcel->getActiveSheet()->getStyle('H3')->getFont()->setSize(12);
			
$objPHPExcel->getActiveSheet()->getStyle('B4:H4')->getFont()->setBold(true);			

//設置儲存格垂直及水平對齊
$objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('B2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_BOTTOM);
$objPHPExcel->getActiveSheet()->getStyle('F3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet()->getStyle('F3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_BOTTOM);

//設置行列高度
$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(50);
$objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(40);
$objPHPExcel->getActiveSheet()->getRowDimension(3)->setRowHeight(30);
$objPHPExcel->getActiveSheet()->getRowDimension(4)->setRowHeight(25);
$objPHPExcel->getActiveSheet()->getRowDimension(5)->setRowHeight(25);
$objPHPExcel->getActiveSheet()->getRowDimension(6)->setRowHeight(25);
$objPHPExcel->getActiveSheet()->getRowDimension(7)->setRowHeight(25);
$objPHPExcel->getActiveSheet()->getRowDimension(8)->setRowHeight(25);
$objPHPExcel->getActiveSheet()->getRowDimension(9)->setRowHeight(25);
$objPHPExcel->getActiveSheet()->getRowDimension(10)->setRowHeight(25);
$objPHPExcel->getActiveSheet()->getRowDimension(11)->setRowHeight(25);
$objPHPExcel->getActiveSheet()->getRowDimension(12)->setRowHeight(25);
$objPHPExcel->getActiveSheet()->getRowDimension(13)->setRowHeight(25);
$objPHPExcel->getActiveSheet()->getRowDimension(14)->setRowHeight(25);
$objPHPExcel->getActiveSheet()->getRowDimension(15)->setRowHeight(25);
$objPHPExcel->getActiveSheet()->getRowDimension(16)->setRowHeight(25);


//$objPHPExcel->getActiveSheet()->getStyle('A2:K2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
//$objPHPExcel->getActiveSheet()->getStyle('A2:K2')->getBorders()->getBottom()->getColor()->setRGB('000000');

//設置垂及及水平對齊
$objPHPExcel->getActiveSheet()->getStyle('B4:H4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('B4:H4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

//設置欄位寬度
// $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(40);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(40);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(40);




/*
//$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(8);
*/

// 項目名稱
$objPHPExcel->getActiveSheet()->getStyle('B4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('B4')->getFill()->getStartColor()->setRGB('C0C0C0');


$objPHPExcel->getActiveSheet()->getStyle('C4:H4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('C4:H4')->getFill()->getStartColor()->setRGB('C0C0C0');


// // 合計 (AG4) 和 % (AH4) 藍色
// $objPHPExcel->getActiveSheet()->getStyle('AG4:G4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
// $objPHPExcel->getActiveSheet()->getStyle('AG4:G4')->getFill()->getStartColor()->setRGB('7FDBFF');

// 標題列 (A4:O4) 邊框 + 黑色
$objPHPExcel->getActiveSheet()->getStyle('B4:H4')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->getStyle('B4:H4')->getBorders()->getAllBorders()->getColor()->setRGB('000000');










$mDB = "";
$mDB = new MywebDB();

$cate_data = array();
$m_MAX_KW = array();
$m_SUM_KWH = array();
$m_SUM_KVAH = array();
for ($i = 0; $i <= 24; $i++) {

	$cate_data[] = $i;
	$m_MAX_KW[] = 0;
	$m_SUM_KWH[] = 0;
	$m_SUM_KVAH[] = 0;
}

$series_data_cate_data = json_encode($cate_data);


$show_analysis = "";

$Qry="SELECT seq,dm_year,dm_month,dm_day,dm_hour,ROUND(MAX(AVG_KW),2) AS MAX_KW
,ROUND(SUM(KWH),2) AS SUM_KWH,ROUND(SUM(KVAH),2) AS SUM_KVAH 
FROM grPA310_KW_quarter
WHERE case_id = '$case_id' ".$date_query_str."
GROUP BY case_id,dm_year,dm_month,dm_day,dm_hour
ORDER BY case_id,dm_year DESC,dm_month DESC,dm_day DESC,dm_hour DESC";

$mDB->query($Qry);

$rowCount = $mDB->rowCount();
if ($rowCount > 0) {
	$i = 5;
	while ($PA310_row = $mDB->fetchRow(2)) {

		$seq = $PA310_row['seq'];
		$dm_year = $PA310_row['dm_year'];
		$dm_month = $PA310_row['dm_month'];
		$dm_day = $PA310_row['dm_day'];
		$dm_hour = $PA310_row['dm_hour'];

		$MAX_KW = $PA310_row['MAX_KW'];
		$SUM_KWH = $PA310_row['SUM_KWH'];
		$SUM_KVAH = $PA310_row['SUM_KVAH'];

		$sheet = $objPHPExcel->setActiveSheetIndex(0);
		$sheet
			->setCellValue('B' . $i, $dm_year)
			->setCellValue('C' . $i, $dm_month)
			->setCellValue('D' . $i, $dm_day)
			->setCellValue('E' . $i, $dm_hour)
			->setCellValue('F' . $i, number_format2($MAX_KW, 2))
			->setCellValue('G' . $i, number_format2($SUM_KWH, 2))
			->setCellValue('H' . $i, number_format2($SUM_KVAH, 2));

		// === 樣式設定 ===
		$styleArray = [
			'alignment' => [
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			],
			'font' => [
				'size' => 12,
			],
			'borders' => [
				'allborders' => [
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => ['rgb' => '000000'],
				],
			],
		];

		// 套用樣式
		$sheet->getStyle("B{$i}:H{$i}")->applyFromArray($styleArray);

		// 每列固定高度 20
		$sheet->getRowDimension($i)->setRowHeight(20);

		$i++;
	}
}

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle("荒川_每日用電總量分析表_".$choice_date);


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


$xlsx_filename = "荒川_總電表每日用電總量分析表_".$choice_date.".xls";

// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename='.$xlsx_filename);
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;




?>
