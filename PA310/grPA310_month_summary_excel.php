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


//載入公用函數
@include_once '/website/include/pub_function.php';



$current_year = $_GET['current_year'];
$current_month = $_GET['current_month'];


$m_period = $current_year."年".$current_month."月";

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
							 ->setCategory("荒川_每月用電總量分析表".$current_year."年".$current_month."月");

							 
//合併儲存格						 
$objPHPExcel->setActiveSheetIndex(0)
			->mergeCells('A1:AH1')
			->mergeCells('A2:AH2')
			->mergeCells('A3:Q3')   // 左半邊
			->mergeCells('R3:AH3');  // 右半邊
			;
							 
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', "")
            ->setCellValue('A2', '荒川_每月用電總量分析表')
            ->setCellValue('A3', '資料年月份：'.$current_year.'年'.$current_month.'月')
            ->setCellValue('R3', '報表日期：'.$today)
            ->setCellValue('A4', '項目名稱/月份')
            ->setCellValue('B4','1')
            ->setCellValue('C4','2')
            ->setCellValue('D4','3')
            ->setCellValue('E4','4')
            ->setCellValue('F4','5')
            ->setCellValue('G4','6')
            ->setCellValue('H4','7')
            ->setCellValue('I4','8')
            ->setCellValue('J4','9')
            ->setCellValue('K4','10')
            ->setCellValue('L4','11')
            ->setCellValue('M4','12')
            ->setCellValue('N4','13')
            ->setCellValue('O4','14')
			->setCellValue('P4','15')
            ->setCellValue('Q4','16')
            ->setCellValue('R4','17')
            ->setCellValue('S4','18')
            ->setCellValue('T4','19')
            ->setCellValue('U4','20')
            ->setCellValue('V4','21')
            ->setCellValue('W4','22')
            ->setCellValue('X4','23')
            ->setCellValue('Y4','24')
            ->setCellValue('Z4','25')
            ->setCellValue('AA4','26')
            ->setCellValue('AB4','27')
            ->setCellValue('AC4','28')
            ->setCellValue('AD4','29')
            ->setCellValue('AE4','30')
            ->setCellValue('AF4','31')
			->setCellValue('AG4','合計')
			->setCellValue('AH4','%')
			;

//設置字型大小
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(24)->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setSize(18)->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setSize(16);
$objPHPExcel->getActiveSheet()->getStyle('R3')->getFont()->setSize(12);
			
$objPHPExcel->getActiveSheet()->getStyle('A4:AH4')->getFont()->setBold(true);			

//設置儲存格垂直及水平對齊
$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_BOTTOM);
$objPHPExcel->getActiveSheet()->getStyle('R3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet()->getStyle('R3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_BOTTOM);

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
$objPHPExcel->getActiveSheet()->getStyle('A4:AH4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A4:AH4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

//設置欄位寬度
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('AC')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('AD')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('AE')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('AF')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('AG')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('AH')->setWidth(10);


/*
//$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(8);
*/

// 項目名稱
$objPHPExcel->getActiveSheet()->getStyle('A4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A4')->getFill()->getStartColor()->setRGB('C0C0C0');


$objPHPExcel->getActiveSheet()->getStyle('B4:AH4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('B4:AH4')->getFill()->getStartColor()->setRGB('C0C0C0');


// 合計 (AG4) 和 % (AH4) 藍色
$objPHPExcel->getActiveSheet()->getStyle('AG4:AH4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('AG4:AH4')->getFill()->getStartColor()->setRGB('7FDBFF');

// 標題列 (A4:O4) 邊框 + 黑色
$objPHPExcel->getActiveSheet()->getStyle('A4:AH4')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->getStyle('A4:AH4')->getBorders()->getAllBorders()->getColor()->setRGB('000000');

// ===== 資料區設定 (B5:AH15) =====
// 邊框 + 黑色
$objPHPExcel->getActiveSheet()->getStyle('A5:AH15')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->getStyle('A5:AH15')->getBorders()->getAllBorders()->getColor()->setRGB('000000');

// 水平與垂直置中
$objPHPExcel->getActiveSheet()->getStyle('A5:AH15')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A5:AH15')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);




// 項目

$objPHPExcel->setActiveSheetIndex(0)
		            ->setCellValue('A5', '經常契約容量(kW)')
					->setCellValue('A6', '尖峰需量(kW)')
					->setCellValue('A7', '半尖峰需量(kW)')
					->setCellValue('A8', '週六半尖峰需量(kW)')
					->setCellValue('A9', '離峰需量(kW)	')
					->setCellValue('A10', '尖峰度數(kWh)')
					->setCellValue('A11', '半尖峰度數(kWh)')
					->setCellValue('A12', '週六半尖峰度數(kWh)')
					->setCellValue('A13', '離峰度數(kWh)')
					->setCellValue('A14', '總用電度數(kWh)')
					->setCellValue('A15', '功率因數(%)')
					;

$styleArray = array(
    'font' => array(
        'bold' => true,
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, // 水平靠右
        'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,  // 垂直置中
    )
);

// 套用到 A5:A15
$objPHPExcel->getActiveSheet()->getStyle('A5:A13')->applyFromArray($styleArray);



$mDB = "";
$mDB = new MywebDB();

$mDB2 = "";
$mDB2 = new MywebDB();

//取得年月份
$Qry="select dm_year,dm_month from grPA310_logs_by_day
where case_id = '$case_id' group by case_id,dm_year,dm_month order by case_id,dm_year desc,dm_month desc";

$mDB->query($Qry);
$m_year  = "";
if ($mDB->rowCount() > 0) {
	$m_year  = "<select class=\"inline form-control\" name=\"period_list\" id=\"period_list\" style=\"width:auto;\">";
	$n = 0;
	while ($row=$mDB->fetchRow(2)) {
	
		$o_current_year = $row['dm_year'];
		$o_current_month = $row['dm_month'];
		$o_period = $o_current_year."年".$o_current_month."月";
		
		$m_year .=  "<option value='/index.php?ch=$ch&current_year=".$o_current_year."&current_month=".$o_current_month."&fm=$fm' ".mySelect($o_period,$m_period).">$o_period</option>";
		
		$n++;
		if ($n == 1) {
			if (!isset($_GET['current_year'])) {
				$current_year = $o_current_year;
				$current_month = $o_current_month;
				$m_period = $current_year."年".$current_month."月";
			}
		}
		
	}
	$m_year .= "</select>";
}






$m_data = array();

$show_analysis = "";



$Qry="SELECT a.*
,(SELECT b.DEMAND_KW FROM grPA310_logs_by_month b WHERE b.case_id = a.case_id AND b.dm_year = a.dm_year AND b.dm_month = a.dm_month LIMIT 1) AS DEMAND_KW
FROM grPA310_logs_by_day a
WHERE a.case_id = '$case_id' AND a.dm_year = '$current_year' AND a.dm_month = '$current_month'
ORDER BY a.case_id,a.dm_year,a.dm_month,a.dm_day";

$mDB->query($Qry);


$m_PEAK_KW = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
$m_HALF_PEAK_KW = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
$m_SATURDAY_HALF_PEAK_KW = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
$m_OFF_PEAK_KW = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
$m_DEMAND_KW = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);

$m_PEAK_KWH = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
$m_HALF_PEAK_KWH = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
$m_SATURDAY_HALF_PEAK_KWH = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
$m_OFF_PEAK_KWH = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
$m_KWH = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);


$rowCount = $mDB->rowCount();
if ($rowCount > 0) {
    while ($PA310_row=$mDB->fetchRow(2)) {
		
		$current_day = $PA310_row['dm_day'];

		$DEMAND_KW = round($PA310_row['DEMAND_KW'],0);
		$PEAK_KW = $PA310_row['PEAK_KW'];
		$HALF_PEAK_KW = $PA310_row['HALF_PEAK_KW'];
		$SATURDAY_HALF_PEAK_KW = $PA310_row['SATURDAY_HALF_PEAK_KW'];
		$OFF_PEAK_KW = $PA310_row['OFF_PEAK_KW'];
		$PEAK_KWH = $PA310_row['PEAK_KWH'];
		$HALF_PEAK_KWH = $PA310_row['HALF_PEAK_KWH'];
		$SATURDAY_HALF_PEAK_KWH = $PA310_row['SATURDAY_HALF_PEAK_KWH'];
		$OFF_PEAK_KWH = $PA310_row['OFF_PEAK_KWH'];
		$KWH = $PA310_row['KWH'];
		$PF = $PA310_row['PF'];

		$m_data[] = array(
			$current_day
			,$DEMAND_KW
			,$PEAK_KW
			,$HALF_PEAK_KW
			,$SATURDAY_HALF_PEAK_KW
			,$OFF_PEAK_KW
			,$PEAK_KWH
			,$HALF_PEAK_KWH
			,$SATURDAY_HALF_PEAK_KWH
			,$OFF_PEAK_KWH
			,$KWH
			,$PF
		);


		$m_PEAK_KW[$current_day-1] = round($PEAK_KW,2);
		$m_HALF_PEAK_KW[$current_day-1] = round($HALF_PEAK_KW,2);
		$m_SATURDAY_HALF_PEAK_KW[$current_day-1] = round($SATURDAY_HALF_PEAK_KW,2);
		$m_OFF_PEAK_KW[$current_day-1] = round($OFF_PEAK_KW,2);
		$m_DEMAND_KW[$current_day-1] = round($DEMAND_KW,2);

		$m_PEAK_KWH[$current_day-1] = round($PEAK_KWH,2);
		$m_HALF_PEAK_KWH[$current_day-1] = round($HALF_PEAK_KWH,2);
		$m_SATURDAY_HALF_PEAK_KWH[$current_day-1] = round($SATURDAY_HALF_PEAK_KWH,2);
		$m_OFF_PEAK_KWH[$current_day-1] = round($OFF_PEAK_KWH,2);
		$m_KWH[$current_day-1] = round($KWH,2);

		
	}
}



$mDB->remove();



$count = count($m_data);
if ($count > 0) {

	//初始化
for ($i = 1; $i <= 31; $i++) {

		$DEMAND_KW = "DEMAND_KW"."_".$i;
		$$DEMAND_KW = "_";

		$PEAK_KW = "PEAK_KW"."_".$i;
		$$PEAK_KW = "_";

		$HALF_PEAK_KW = "HALF_PEAK_KW"."_".$i;
		$$HALF_PEAK_KW = "_";

		$SATURDAY_HALF_PEAK_KW = "SATURDAY_HALF_PEAK_KW"."_".$i;
		$$SATURDAY_HALF_PEAK_KW = "_";

		$OFF_PEAK_KW = "OFF_PEAK_KW"."_".$i;
		$$OFF_PEAK_KW = "_";

		$PEAK_KWH = "PEAK_KWH"."_".$i;
		$$PEAK_KWH = "_";

		$HALF_PEAK_KWH = "HALF_PEAK_KWH"."_".$i;
		$$HALF_PEAK_KWH = "_";

		$SATURDAY_HALF_PEAK_KWH = "SATURDAY_HALF_PEAK_KWH"."_".$i;
		$$SATURDAY_HALF_PEAK_KWH = "_";

		$OFF_PEAK_KWH = "OFF_PEAK_KWH"."_".$i;
		$$OFF_PEAK_KWH = "_";

		$KWH = "KWH"."_".$i;
		$$KWH = "_";

		$PF = "PF"."_".$i;
		$$PF = "_";

	}

		
	$DEMAND_KW_MAX = 0;

	$PEAK_KW_MAX = 0;
	$HALF_PEAK_KW_MAX = 0;
	$SATURDAY_HALF_PEAK_KW_MAX = 0;
	$OFF_PEAK_KW_MAX = 0;
	$PEAK_KWH_TOTAL = 0;
	$HALF_PEAK_KWH_TOTAL = 0;
	$SATURDAY_HALF_PEAK_KWH_TOTAL = 0;
	$OFF_PEAK_KWH_TOTAL = 0;
	$KWH_TOTAL = 0;


	foreach($m_data as &$val) {

		$k = 0;
		$current_day = $val[$k];

		$k++;
		$DEMAND_KW = "DEMAND_KW"."_".$current_day;
		$$DEMAND_KW = number_format2($val[$k],0);
		if ($val[$k] > $DEMAND_KW_MAX)
			$DEMAND_KW_MAX = $val[$k];

		$k++;
		$PEAK_KW = "PEAK_KW"."_".$current_day;
		$$PEAK_KW = number_format2($val[$k],2);
		if ($val[$k] > $PEAK_KW_MAX)
			$PEAK_KW_MAX = $val[$k];

		$k++;
		$HALF_PEAK_KW = "HALF_PEAK_KW"."_".$current_day;
		$$HALF_PEAK_KW = number_format2($val[$k],2);
		if ($val[$k] > $HALF_PEAK_KW_MAX)
			$HALF_PEAK_KW_MAX = $val[$k];

		$k++;
		$SATURDAY_HALF_PEAK_KW = "SATURDAY_HALF_PEAK_KW"."_".$current_day;
		$$SATURDAY_HALF_PEAK_KW = number_format2($val[$k],2);
		if ($val[$k] > $SATURDAY_HALF_PEAK_KW_MAX)
			$SATURDAY_HALF_PEAK_KW_MAX = $val[$k];

		$k++;
		$OFF_PEAK_KW = "OFF_PEAK_KW"."_".$current_day;
		$$OFF_PEAK_KW = number_format2($val[$k],2);
		if ($val[$k] > $OFF_PEAK_KW_MAX)
			$OFF_PEAK_KW_MAX = $val[$k];

		$k++;
		$PEAK_KWH = "PEAK_KWH"."_".$current_day;
		$$PEAK_KWH = number_format2($val[$k],2);
		$PEAK_KWH_TOTAL += $val[$k];

		$k++;
		$HALF_PEAK_KWH = "HALF_PEAK_KWH"."_".$current_day;
		$$HALF_PEAK_KWH = number_format2($val[$k],2);
		$HALF_PEAK_KWH_TOTAL += $val[$k];

		$k++;
		$SATURDAY_HALF_PEAK_KWH = "SATURDAY_HALF_PEAK_KWH"."_".$current_day;
		$$SATURDAY_HALF_PEAK_KWH = number_format2($val[$k],2);
		$SATURDAY_HALF_PEAK_KWH_TOTAL += $val[$k];

		$k++;
		$OFF_PEAK_KWH = "OFF_PEAK_KWH"."_".$current_day;
		$$OFF_PEAK_KWH = number_format2($val[$k],2);
		$OFF_PEAK_KWH_TOTAL += $val[$k];

		$k++;
		$KWH = "KWH"."_".$current_day;
		$$KWH = number_format2($val[$k],2);
		$KWH_TOTAL += $val[$k];

		$k++;
		$PF = "PF"."_".$current_day;
		$$PF = number_format2($val[$k]*100,2);

	}


	$PEAK_KW_MAX = number_format2($PEAK_KW_MAX,2);
	$HALF_PEAK_KW_MAX = number_format2($HALF_PEAK_KW_MAX,2);
	$SATURDAY_HALF_PEAK_KW_MAX = number_format2($SATURDAY_HALF_PEAK_KW_MAX,2);
	$OFF_PEAK_KW_MAX = number_format2($OFF_PEAK_KW_MAX,2);
	$PEAK_KWH_TOTAL = number_format2($PEAK_KWH_TOTAL,2);
	$HALF_PEAK_KWH_TOTAL = number_format2($HALF_PEAK_KWH_TOTAL,2);
	$SATURDAY_HALF_PEAK_KWH_TOTAL = number_format2($SATURDAY_HALF_PEAK_KWH_TOTAL,2);
	$OFF_PEAK_KWH_TOTAL = number_format2($OFF_PEAK_KWH_TOTAL,2);
	$KWH_TOTAL = number_format2($KWH_TOTAL,2);



	$PEAK_KW_PERCENT = ""; if ($DEMAND_KW_MAX > 0) $PEAK_KW_PERCENT = round($PEAK_KW_MAX/$DEMAND_KW_MAX*100,1)."%";
	$HALF_PEAK_KW_PERCENT = ""; if ($DEMAND_KW_MAX > 0) $HALF_PEAK_KW_PERCENT = round($HALF_PEAK_KW_MAX/$DEMAND_KW_MAX*100,1)."%";
	$SATURDAY_HALF_PEAK_KW_PERCENT = ""; if ($DEMAND_KW_MAX > 0) $SATURDAY_HALF_PEAK_KW_PERCENT = round($SATURDAY_HALF_PEAK_KW_MAX/$DEMAND_KW_MAX*100,1)."%";
	$OFF_PEAK_KW_PERCENT = ""; if ($DEMAND_KW_MAX > 0) $OFF_PEAK_KW_PERCENT = round($OFF_PEAK_KW_MAX/$DEMAND_KW_MAX*100,1)."%";
	$PEAK_KWH_PERCENT = ""; if ($KWH_TOTAL > 0) $PEAK_KWH_PERCENT = round($PEAK_KWH_TOTAL/$KWH_TOTAL*100,1)."%";
	$HALF_PEAK_KWH_PERCENT = ""; if ($KWH_TOTAL > 0) $HALF_PEAK_KWH_PERCENT = round($HALF_PEAK_KWH_TOTAL/$KWH_TOTAL*100,1)."%";
	$SATURDAY_HALF_PEAK_KWH_PERCENT = ""; if ($KWH_TOTAL > 0) $SATURDAY_HALF_PEAK_KWH_PERCENT = round($SATURDAY_HALF_PEAK_KWH_TOTAL/$KWH_TOTAL*100,1)."%";
	$OFF_PEAK_KWH_PERCENT = ""; if ($KWH_TOTAL > 0) $OFF_PEAK_KWH_PERCENT = round($OFF_PEAK_KWH_TOTAL/$KWH_TOTAL*100,1)."%";
	$KWH_PERCENT = "100%";


}


//經常契約容量
$objPHPExcel->setActiveSheetIndex(0)

            ->setCellValue('B5', $DEMAND_KW_1)
            ->setCellValue('C5', $DEMAND_KW_2)
            ->setCellValue('D5', $DEMAND_KW_3)
            ->setCellValue('E5', $DEMAND_KW_4)
            ->setCellValue('F5', $DEMAND_KW_5)
            ->setCellValue('G5', $DEMAND_KW_6)
            ->setCellValue('H5', $DEMAND_KW_7)
            ->setCellValue('I5', $DEMAND_KW_8)
            ->setCellValue('J5', $DEMAND_KW_9)
            ->setCellValue('K5', $DEMAND_KW_10)
            ->setCellValue('L5', $DEMAND_KW_11)
            ->setCellValue('M5', $DEMAND_KW_12)
			->setCellValue('N5', $DEMAND_KW_13)
            ->setCellValue('O5', $DEMAND_KW_14)
            ->setCellValue('P5', $DEMAND_KW_15)
            ->setCellValue('Q5', $DEMAND_KW_16)
            ->setCellValue('R5', $DEMAND_KW_17)
            ->setCellValue('S5', $DEMAND_KW_18)
            ->setCellValue('T5', $DEMAND_KW_19)
            ->setCellValue('U5', $DEMAND_KW_20)
            ->setCellValue('V5', $DEMAND_KW_21)
            ->setCellValue('W5', $DEMAND_KW_22)
            ->setCellValue('X5', $DEMAND_KW_23)
            ->setCellValue('Y5', $DEMAND_KW_24)
            ->setCellValue('Z5', $DEMAND_KW_25)
            ->setCellValue('AA5', $DEMAND_KW_26)
            ->setCellValue('AB5', $DEMAND_KW_27)
            ->setCellValue('AC5', $DEMAND_KW_28)
            ->setCellValue('AD5', $DEMAND_KW_29)
            ->setCellValue('AE5', $DEMAND_KW_30)
            ->setCellValue('AF5', $DEMAND_KW_31)

			->setCellValue('AH5', '100%')

			;
// 設定經常契約容量底色
$objPHPExcel->getActiveSheet()->getStyle('A5:AH5')->applyFromArray(
    array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'FFDBDB')
        )
    )
);

//尖峰需量
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('B6', $PEAK_KW_1)
            ->setCellValue('C6', $PEAK_KW_2)
            ->setCellValue('D6', $PEAK_KW_3)
            ->setCellValue('E6', $PEAK_KW_4)
            ->setCellValue('F6', $PEAK_KW_5)
            ->setCellValue('G6', $PEAK_KW_6)
            ->setCellValue('H6', $PEAK_KW_7)
            ->setCellValue('I6', $PEAK_KW_8)
            ->setCellValue('J6', $PEAK_KW_9)
            ->setCellValue('K6', $PEAK_KW_10)
            ->setCellValue('L6', $PEAK_KW_11)
            ->setCellValue('M6', $PEAK_KW_12)
			->setCellValue('N6', $PEAK_KW_13)
            ->setCellValue('O6', $PEAK_KW_14)
            ->setCellValue('P6', $PEAK_KW_15)
            ->setCellValue('Q6', $PEAK_KW_16)
            ->setCellValue('R6', $PEAK_KW_17)
            ->setCellValue('S6', $PEAK_KW_18)
            ->setCellValue('T6', $PEAK_KW_19)
            ->setCellValue('U6', $PEAK_KW_20)
            ->setCellValue('V6', $PEAK_KW_21)
            ->setCellValue('W6', $PEAK_KW_22)
            ->setCellValue('X6', $PEAK_KW_23)
            ->setCellValue('Y6', $PEAK_KW_24)
            ->setCellValue('Z6', $PEAK_KW_25)
            ->setCellValue('AA6', $PEAK_KW_26)
            ->setCellValue('AB6', $PEAK_KW_27)
            ->setCellValue('AC6', $PEAK_KW_28)
            ->setCellValue('AD6', $PEAK_KW_29)
            ->setCellValue('AE6', $PEAK_KW_30)
            ->setCellValue('AF6', $PEAK_KW_31)
			->setCellValue('AG6', $PEAK_KW_MAX)
			->setCellValue('AH6', $PEAK_KW_PERCENT)
			;

//半尖峰需量
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('B7', $HALF_PEAK_KW_1)
            ->setCellValue('C7', $HALF_PEAK_KW_2)
			->setCellValue('D7', $HALF_PEAK_KW_3)
			->setCellValue('E7', $HALF_PEAK_KW_4)
			->setCellValue('F7', $HALF_PEAK_KW_5)
			->setCellValue('G7', $HALF_PEAK_KW_6)
			->setCellValue('H7', $HALF_PEAK_KW_7)
			->setCellValue('I7', $HALF_PEAK_KW_8)
			->setCellValue('J7', $HALF_PEAK_KW_9)
			->setCellValue('K7', $HALF_PEAK_KW_10)
			->setCellValue('L7', $HALF_PEAK_KW_11)
			->setCellValue('M7', $HALF_PEAK_KW_12)
			->setCellValue('N7', $HALF_PEAK_KW_13)
			->setCellValue('O7', $HALF_PEAK_KW_14)
			->setCellValue('P7', $HALF_PEAK_KW_15)
			->setCellValue('Q7', $HALF_PEAK_KW_16)
			->setCellValue('R7', $HALF_PEAK_KW_17)
			->setCellValue('S7', $HALF_PEAK_KW_18)
			->setCellValue('T7', $HALF_PEAK_KW_19)
			->setCellValue('U7', $HALF_PEAK_KW_20)
			->setCellValue('V7', $HALF_PEAK_KW_21)
			->setCellValue('W7', $HALF_PEAK_KW_22)
			->setCellValue('X7', $HALF_PEAK_KW_23)
			->setCellValue('Y7', $HALF_PEAK_KW_24)
			->setCellValue('Z7', $HALF_PEAK_KW_25)
			->setCellValue('AA7', $HALF_PEAK_KW_26)
			->setCellValue('AB7', $HALF_PEAK_KW_27)
			->setCellValue('AC7', $HALF_PEAK_KW_28)
			->setCellValue('AD7', $HALF_PEAK_KW_29)
			->setCellValue('AE7', $HALF_PEAK_KW_30)
			->setCellValue('AF7', $HALF_PEAK_KW_31)
			->setCellValue('AG7', $HALF_PEAK_KW_MAX)
			->setCellValue('AH7', $HALF_PEAK_KW_PERCENT)
			;

//SATURDAY_HALF_PEAK_KW   週六半尖峰需量(kW)
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('B8', $SATURDAY_HALF_PEAK_KW_1)
            ->setCellValue('C8', $SATURDAY_HALF_PEAK_KW_2)
			->setCellValue('D8', $SATURDAY_HALF_PEAK_KW_3)
			->setCellValue('E8', $SATURDAY_HALF_PEAK_KW_4)
			->setCellValue('F8', $SATURDAY_HALF_PEAK_KW_5)
			->setCellValue('G8', $SATURDAY_HALF_PEAK_KW_6)
			->setCellValue('H8', $SATURDAY_HALF_PEAK_KW_7)
			->setCellValue('I8', $SATURDAY_HALF_PEAK_KW_8)
			->setCellValue('J8', $SATURDAY_HALF_PEAK_KW_9)
			->setCellValue('K8', $SATURDAY_HALF_PEAK_KW_10)
			->setCellValue('L8', $SATURDAY_HALF_PEAK_KW_11)
			->setCellValue('M8', $SATURDAY_HALF_PEAK_KW_12)
			->setCellValue('N8', $SATURDAY_HALF_PEAK_KW_13)
			->setCellValue('O8', $SATURDAY_HALF_PEAK_KW_14)
			->setCellValue('P8', $SATURDAY_HALF_PEAK_KW_15)
			->setCellValue('Q8', $SATURDAY_HALF_PEAK_KW_16)
			->setCellValue('R8', $SATURDAY_HALF_PEAK_KW_17)
			->setCellValue('S8', $SATURDAY_HALF_PEAK_KW_18)
			->setCellValue('T8', $SATURDAY_HALF_PEAK_KW_19)
			->setCellValue('U8', $SATURDAY_HALF_PEAK_KW_20)
			->setCellValue('V8', $SATURDAY_HALF_PEAK_KW_21)
			->setCellValue('W8', $SATURDAY_HALF_PEAK_KW_22)
			->setCellValue('X8', $SATURDAY_HALF_PEAK_KW_23)
			->setCellValue('Y8', $SATURDAY_HALF_PEAK_KW_24)
			->setCellValue('Z8', $SATURDAY_HALF_PEAK_KW_25)
			->setCellValue('AA8',$SATURDAY_HALF_PEAK_KW_26)
			->setCellValue('AB8',$SATURDAY_HALF_PEAK_KW_27)
			->setCellValue('AC8',$SATURDAY_HALF_PEAK_KW_28)
			->setCellValue('AD8',$SATURDAY_HALF_PEAK_KW_29)
			->setCellValue('AE8',$SATURDAY_HALF_PEAK_KW_30)
			->setCellValue('AF8',$SATURDAY_HALF_PEAK_KW_31)
			->setCellValue('AG8',$SATURDAY_HALF_PEAK_KW_MAX)
			->setCellValue('AH8',$SATURDAY_HALF_PEAK_KW_PERCENT)
			;


//離峰需量
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('B9', $OFF_PEAK_KW_1)
            ->setCellValue('C9', $OFF_PEAK_KW_2)
			->setCellValue('D9', $OFF_PEAK_KW_3)
			->setCellValue('E9', $OFF_PEAK_KW_4)
			->setCellValue('F9', $OFF_PEAK_KW_5)
			->setCellValue('G9', $OFF_PEAK_KW_6)
			->setCellValue('H9', $OFF_PEAK_KW_7)
			->setCellValue('I9', $OFF_PEAK_KW_8)
			->setCellValue('J9', $OFF_PEAK_KW_9)
			->setCellValue('K9', $OFF_PEAK_KW_10)
			->setCellValue('L9', $OFF_PEAK_KW_11)
			->setCellValue('M9', $OFF_PEAK_KW_12)
			->setCellValue('N9', $OFF_PEAK_KW_13)
			->setCellValue('O9', $OFF_PEAK_KW_14)
			->setCellValue('P9', $OFF_PEAK_KW_15)
			->setCellValue('Q9', $OFF_PEAK_KW_16)
			->setCellValue('R9', $OFF_PEAK_KW_17)
			->setCellValue('S9', $OFF_PEAK_KW_18)
			->setCellValue('T9', $OFF_PEAK_KW_19)
			->setCellValue('U9', $OFF_PEAK_KW_20)
			->setCellValue('V9', $OFF_PEAK_KW_21)
			->setCellValue('W9', $OFF_PEAK_KW_22)
			->setCellValue('X9', $OFF_PEAK_KW_23)
			->setCellValue('Y9', $OFF_PEAK_KW_24)
			->setCellValue('Z9', $OFF_PEAK_KW_25)
			->setCellValue('AA9', $OFF_PEAK_KW_26)
			->setCellValue('AB9', $OFF_PEAK_KW_27)
			->setCellValue('AC9', $OFF_PEAK_KW_28)
			->setCellValue('AD9', $OFF_PEAK_KW_29)
			->setCellValue('AE9', $OFF_PEAK_KW_30)
			->setCellValue('AF9', $OFF_PEAK_KW_31)
			->setCellValue('AG9', $OFF_PEAK_KW_MAX)
			->setCellValue('AH9', $OFF_PEAK_KW_PERCENT)
			;

//尖峰度數(kWh)
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('B10', $PEAK_KWH_1)
			->setCellValue('C10', $PEAK_KWH_2)	
			->setCellValue('D10', $PEAK_KWH_3)
			->setCellValue('E10', $PEAK_KWH_4)
			->setCellValue('F10', $PEAK_KWH_5)
			->setCellValue('G10', $PEAK_KWH_6)
			->setCellValue('H10', $PEAK_KWH_7)
			->setCellValue('I10', $PEAK_KWH_8)
			->setCellValue('J10', $PEAK_KWH_9)
			->setCellValue('K10', $PEAK_KWH_10)
			->setCellValue('L10', $PEAK_KWH_11)
			->setCellValue('M10', $PEAK_KWH_12)
			->setCellValue('N10', $PEAK_KWH_13)
			->setCellValue('O10', $PEAK_KWH_14)
			->setCellValue('P10', $PEAK_KWH_15)
			->setCellValue('Q10', $PEAK_KWH_16)
			->setCellValue('R10', $PEAK_KWH_17)
			->setCellValue('S10', $PEAK_KWH_18)
			->setCellValue('T10', $PEAK_KWH_19)
			->setCellValue('U10', $PEAK_KWH_20)
			->setCellValue('V10', $PEAK_KWH_21)
			->setCellValue('W10', $PEAK_KWH_22)
			->setCellValue('X10', $PEAK_KWH_23)
			->setCellValue('Y10', $PEAK_KWH_24)
			->setCellValue('Z10', $PEAK_KWH_25)
			->setCellValue('AA10', $PEAK_KWH_26)
			->setCellValue('AB10', $PEAK_KWH_27)
			->setCellValue('AC10', $PEAK_KWH_28)
			->setCellValue('AD10', $PEAK_KWH_29)
			->setCellValue('AE10', $PEAK_KWH_30)
			->setCellValue('AF10', $PEAK_KWH_31)
			->setCellValue('AG10', $PEAK_KWH_TOTAL)
			->setCellValue('AH10', $PEAK_KWH_PERCENT)
			;

//半尖峰度數
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('B11', $HALF_PEAK_KWH_1)
			->setCellValue('C11', $HALF_PEAK_KWH_2)
			->setCellValue('D11', $HALF_PEAK_KWH_3)
			->setCellValue('E11', $HALF_PEAK_KWH_4)
			->setCellValue('F11', $HALF_PEAK_KWH_5)
			->setCellValue('G11', $HALF_PEAK_KWH_6)
			->setCellValue('H11', $HALF_PEAK_KWH_7)
			->setCellValue('I11', $HALF_PEAK_KWH_8)
			->setCellValue('J11', $HALF_PEAK_KWH_9)
			->setCellValue('K11', $HALF_PEAK_KWH_10)
			->setCellValue('L11', $HALF_PEAK_KWH_11)
			->setCellValue('M11', $HALF_PEAK_KWH_12)
			->setCellValue('N11', $HALF_PEAK_KWH_13)
			->setCellValue('O11', $HALF_PEAK_KWH_14)
			->setCellValue('P11', $HALF_PEAK_KWH_15)
			->setCellValue('Q11', $HALF_PEAK_KWH_16)
			->setCellValue('R11', $HALF_PEAK_KWH_17)
			->setCellValue('S11', $HALF_PEAK_KWH_18)
			->setCellValue('T11', $HALF_PEAK_KWH_19)
			->setCellValue('U11', $HALF_PEAK_KWH_20)
			->setCellValue('V11', $HALF_PEAK_KWH_21)
			->setCellValue('W11', $HALF_PEAK_KWH_22)
			->setCellValue('X11', $HALF_PEAK_KWH_23)
			->setCellValue('Y11', $HALF_PEAK_KWH_24)
			->setCellValue('Z11', $HALF_PEAK_KWH_25)
			->setCellValue('AA11', $HALF_PEAK_KWH_26)
			->setCellValue('AB11', $HALF_PEAK_KWH_27)
			->setCellValue('AC11', $HALF_PEAK_KWH_28)
			->setCellValue('AD11', $HALF_PEAK_KWH_29)
			->setCellValue('AE11', $HALF_PEAK_KWH_30)
			->setCellValue('AF11', $HALF_PEAK_KWH_31)
			->setCellValue('AG11', $HALF_PEAK_KWH_TOTAL)
			->setCellValue('AH11', $HALF_PEAK_KWH_PERCENT)
			;

//SATURDAY_HALF_PEAK_KWH   週六半尖峰度數(kWh)

$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('B12',  $SATURDAY_HALF_PEAK_KWH_1)
			->setCellValue('C12',  $SATURDAY_HALF_PEAK_KWH_2)
			->setCellValue('D12',  $SATURDAY_HALF_PEAK_KWH_3)
			->setCellValue('E12',  $SATURDAY_HALF_PEAK_KWH_4)
			->setCellValue('F12',  $SATURDAY_HALF_PEAK_KWH_5)
			->setCellValue('G12',  $SATURDAY_HALF_PEAK_KWH_6)
			->setCellValue('H12',  $SATURDAY_HALF_PEAK_KWH_7)
			->setCellValue('I12',  $SATURDAY_HALF_PEAK_KWH_8)
			->setCellValue('J12',  $SATURDAY_HALF_PEAK_KWH_9)
			->setCellValue('K12',  $SATURDAY_HALF_PEAK_KWH_10)
			->setCellValue('L12',  $SATURDAY_HALF_PEAK_KWH_11)
			->setCellValue('M12',  $SATURDAY_HALF_PEAK_KWH_12)
			->setCellValue('N12',  $SATURDAY_HALF_PEAK_KWH_13)
			->setCellValue('O12',  $SATURDAY_HALF_PEAK_KWH_14)
			->setCellValue('P12',  $SATURDAY_HALF_PEAK_KWH_15)
			->setCellValue('Q12',  $SATURDAY_HALF_PEAK_KWH_16)
			->setCellValue('R12',  $SATURDAY_HALF_PEAK_KWH_17)
			->setCellValue('S12',  $SATURDAY_HALF_PEAK_KWH_18)
			->setCellValue('T12',  $SATURDAY_HALF_PEAK_KWH_19)
			->setCellValue('U12',  $SATURDAY_HALF_PEAK_KWH_20)
			->setCellValue('V12',  $SATURDAY_HALF_PEAK_KWH_21)
			->setCellValue('W12',  $SATURDAY_HALF_PEAK_KWH_22)
			->setCellValue('X12',  $SATURDAY_HALF_PEAK_KWH_23)
			->setCellValue('Y12',  $SATURDAY_HALF_PEAK_KWH_24)
			->setCellValue('Z12',  $SATURDAY_HALF_PEAK_KWH_25)
			->setCellValue('AA12', $SATURDAY_HALF_PEAK_KWH_26)
			->setCellValue('AB12', $SATURDAY_HALF_PEAK_KWH_27)
			->setCellValue('AC12', $SATURDAY_HALF_PEAK_KWH_28)
			->setCellValue('AD12', $SATURDAY_HALF_PEAK_KWH_29)
			->setCellValue('AE12', $SATURDAY_HALF_PEAK_KWH_30)
			->setCellValue('AF12', $SATURDAY_HALF_PEAK_KWH_31)
			->setCellValue('AG12', $SATURDAY_HALF_PEAK_KWH_TOTAL)
			->setCellValue('AH12', $SATURDAY_HALF_PEAK_KWH_PERCENT)
			;

//離峰度數
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('B13', $OFF_PEAK_KWH_1)
			->setCellValue('C13', $OFF_PEAK_KWH_2)
			->setCellValue('D13', $OFF_PEAK_KWH_3)
			->setCellValue('E13', $OFF_PEAK_KWH_4)
			->setCellValue('F13', $OFF_PEAK_KWH_5)
			->setCellValue('G13', $OFF_PEAK_KWH_6)
			->setCellValue('H13', $OFF_PEAK_KWH_7)
			->setCellValue('I13', $OFF_PEAK_KWH_8)
			->setCellValue('J13', $OFF_PEAK_KWH_9)
			->setCellValue('K13', $OFF_PEAK_KWH_10)
			->setCellValue('L13', $OFF_PEAK_KWH_11)
			->setCellValue('M13', $OFF_PEAK_KWH_12)
			->setCellValue('N13', $OFF_PEAK_KWH_13)
			->setCellValue('O13', $OFF_PEAK_KWH_14)
			->setCellValue('P13', $OFF_PEAK_KWH_15)
			->setCellValue('Q13', $OFF_PEAK_KWH_16)
			->setCellValue('R13', $OFF_PEAK_KWH_17)
			->setCellValue('S13', $OFF_PEAK_KWH_18)
			->setCellValue('T13', $OFF_PEAK_KWH_19)
			->setCellValue('U13', $OFF_PEAK_KWH_20)
			->setCellValue('V13', $OFF_PEAK_KWH_21)
			->setCellValue('W13', $OFF_PEAK_KWH_22)
			->setCellValue('X13', $OFF_PEAK_KWH_23)
			->setCellValue('Y13', $OFF_PEAK_KWH_24)
			->setCellValue('Z13', $OFF_PEAK_KWH_25)
			->setCellValue('AA13', $OFF_PEAK_KWH_26)
			->setCellValue('AB13', $OFF_PEAK_KWH_27)
			->setCellValue('AC13', $OFF_PEAK_KWH_28)
			->setCellValue('AD13', $OFF_PEAK_KWH_29)
			->setCellValue('AE13', $OFF_PEAK_KWH_30)
			->setCellValue('AF13', $OFF_PEAK_KWH_31)
			->setCellValue('AG13', $OFF_PEAK_KWH_TOTAL)
			->setCellValue('AH13', $OFF_PEAK_KWH_PERCENT)
			;

//總用電度數(KWh)
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('B14', $KWH_1)
			->setCellValue('C14', $KWH_2)
			->setCellValue('D14', $KWH_3)
			->setCellValue('E14', $KWH_4)
			->setCellValue('F14', $KWH_5)
			->setCellValue('G14', $KWH_6)
			->setCellValue('H14', $KWH_7)
			->setCellValue('I14', $KWH_8)
			->setCellValue('J14', $KWH_9)
			->setCellValue('K14', $KWH_10)
			->setCellValue('L14', $KWH_11)
			->setCellValue('M14', $KWH_12)
			->setCellValue('N14', $KWH_13)
			->setCellValue('O14', $KWH_14)
			->setCellValue('P14', $KWH_15)
			->setCellValue('Q14', $KWH_16)
			->setCellValue('R14', $KWH_17)
			->setCellValue('S14', $KWH_18)
			->setCellValue('T14', $KWH_19)
			->setCellValue('U14', $KWH_20)
			->setCellValue('V14', $KWH_21)
			->setCellValue('W14', $KWH_22)
			->setCellValue('X14', $KWH_23)
			->setCellValue('Y14', $KWH_24)
			->setCellValue('Z14', $KWH_25)
			->setCellValue('AA14', $KWH_26)
			->setCellValue('AB14', $KWH_27)
			->setCellValue('AC14', $KWH_28)
			->setCellValue('AD14', $KWH_29)
			->setCellValue('AE14', $KWH_30)
			->setCellValue('AF14', $KWH_31)
			->setCellValue('AG14', $KWH_TOTAL)
			->setCellValue('AH14', $KWH_PERCENT)
			;
//總用電度數(KWh)
$objPHPExcel->getActiveSheet()->getStyle('A14:AH14')->applyFromArray(
    array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'C9FFB7')
        )
    )
);

//PF  功率因數(%)
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('B15', $PF_1)
			->setCellValue('C15', $PF_2)
			->setCellValue('D15', $PF_3)
			->setCellValue('E15', $PF_4)
			->setCellValue('F15', $PF_5)
			->setCellValue('G15', $PF_6)
			->setCellValue('H15', $PF_7)
			->setCellValue('I15', $PF_8)
			->setCellValue('J15', $PF_9)
			->setCellValue('K15', $PF_10)
			->setCellValue('L15', $PF_11)
			->setCellValue('M15', $PF_12)
			->setCellValue('N15', $PF_13)
			->setCellValue('O15', $PF_14)
			->setCellValue('P15', $PF_15)
			->setCellValue('Q15', $PF_16)
			->setCellValue('R15', $PF_17)
			->setCellValue('S15', $PF_18)
			->setCellValue('T15', $PF_19)
			->setCellValue('U15', $PF_20)
			->setCellValue('V15', $PF_21)
			->setCellValue('W15', $PF_22)
			->setCellValue('X15', $PF_23)
			->setCellValue('Y15', $PF_24)
			->setCellValue('Z15', $PF_25)
			->setCellValue('AA15', $PF_26)
			->setCellValue('AB15', $PF_27)
			->setCellValue('AC15', $PF_28)
			->setCellValue('AD15', $PF_29)
			->setCellValue('AE15', $PF_30)
			->setCellValue('AF15', $PF_31)
			;





// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle("荒川_每月用電總量分析表_".$current_year."年".$current_month."月");


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


$xlsx_filename = "荒川_每月用電總量分析表_".$current_year."年".$current_month."月.xls";

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
