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
// $current_month = $_GET['current_month'];



//現在日期時間
$today = date('Y-m-d H:i');


@include_once("/website/class/".$site_db."_info_class.php");


if (PHP_SAPI == 'cli')
	die('This programe should only be run from a Web Browser');

/** Include PHPExcel */
require_once '/website/os/PHPExcel-1.8.1/Classes/PHPExcel.php';

$Jan = getlang("一月");
$Feb = getlang("二月");
$Mar = getlang("三月");
$Apr = getlang("四月");
$May = getlang("五月");
$Jun = getlang("六月");
$Jul = getlang("七月");
$Aug = getlang("八月");
$Sep = getlang("九月");
$Oct = getlang("十月");
$Nov = getlang("十一月");
$Dec = getlang("十二月");

$Sun = getlang("星期日");
$Mon = getlang("星期一");
$Tue = getlang("星期二");
$Wed = getlang("星期三");
$Thu = getlang("星期四");
$Fri = getlang("星期五");
$Sat = getlang("星期六");

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
							 ->setCategory("荒川_年度用電總量分析表".$current_year."年");

							 
//合併儲存格						 
$objPHPExcel->setActiveSheetIndex(0)
			->mergeCells('A1:O1')
			->mergeCells('A2:O2')
			->mergeCells('A3:F3')   // 左半邊
			->mergeCells('G3:O3');  // 右半邊
			;
							 
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', "")
            ->setCellValue('A2', '荒川_年度用電總量分析表')
            ->setCellValue('A3', '資料年月份：'.$current_year.'年')
            ->setCellValue('G3', '報表日期：'.$today)
            ->setCellValue('A4', '項目名稱/月份')
            ->setCellValue('B4', $Jan)
            ->setCellValue('C4', $Feb)
            ->setCellValue('D4', $Mar)
            ->setCellValue('E4', $Apr)
            ->setCellValue('F4', $May)
            ->setCellValue('G4', $Jun)
            ->setCellValue('H4', $Jul)
            ->setCellValue('I4', $Aug)
            ->setCellValue('J4', $Sep)
            ->setCellValue('K4', $Oct)
            ->setCellValue('L4', $Nov)
            ->setCellValue('M4', $Dec)
            ->setCellValue('N4', '最高/合計')
            ->setCellValue('O4', '比重%')
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
$objPHPExcel->getActiveSheet()->getStyle('G3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet()->getStyle('G3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_BOTTOM);

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
$objPHPExcel->getActiveSheet()->getRowDimension(17)->setRowHeight(25);


//$objPHPExcel->getActiveSheet()->getStyle('A2:K2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
//$objPHPExcel->getActiveSheet()->getStyle('A2:K2')->getBorders()->getBottom()->getColor()->setRGB('000000');

//設置垂及及水平對齊
$objPHPExcel->getActiveSheet()->getStyle('A4:AH4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A4:AH4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

//設置欄位寬度
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(13);


/*
//$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(8);
*/

// 項目名稱
$objPHPExcel->getActiveSheet()->getStyle('A4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A4')->getFill()->getStartColor()->setRGB('C0C0C0');

// 一到五月 (B4:F4) 灰色
$objPHPExcel->getActiveSheet()->getStyle('B4:F4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('B4:F4')->getFill()->getStartColor()->setRGB('C0C0C0');

// 六到九月 (G4:J4) 紅底 + 白字
$objPHPExcel->getActiveSheet()->getStyle('G4:J4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('G4:J4')->getFill()->getStartColor()->setRGB('FF0000');
$objPHPExcel->getActiveSheet()->getStyle('G4:J4')->getFont()->getColor()->setRGB('FFFFFF');

// 十到十二月 (K4:M4) 灰色
$objPHPExcel->getActiveSheet()->getStyle('K4:M4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('K4:M4')->getFill()->getStartColor()->setRGB('C0C0C0');

// 合計 (N4) 和 % (O4) 藍色
$objPHPExcel->getActiveSheet()->getStyle('N4:O4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('N4:O4')->getFill()->getStartColor()->setRGB('7FDBFF');

// 標題列 (A4:O4) 邊框 + 黑色
$objPHPExcel->getActiveSheet()->getStyle('A4:O4')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->getStyle('A4:O4')->getBorders()->getAllBorders()->getColor()->setRGB('000000');

// ===== 資料區設定 (B5:O15) =====
// 邊框 + 黑色
$objPHPExcel->getActiveSheet()->getStyle('A5:O17')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->getStyle('A5:O17')->getBorders()->getAllBorders()->getColor()->setRGB('000000');

// 水平與垂直置中
$objPHPExcel->getActiveSheet()->getStyle('A5:O17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A5:O17')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);




// 項目

$objPHPExcel->setActiveSheetIndex(0)
		            ->setCellValue('A5', '計費起始日')
					->setCellValue('A6', '計費迄止日')
					->setCellValue('A7', '經常契約容量(KW)')
					->setCellValue('A8', '尖峰需量(KW)')
					->setCellValue('A9', '半尖峰需量(KW)')
					->setCellValue('A10', '週六半尖峰需量(KW)')
					->setCellValue('A11', '離峰需量(KW)')
					->setCellValue('A12', '尖峰度數(KWh)')
					->setCellValue('A13', '半尖峰度數(KWh)')
					->setCellValue('A14', '週六半尖峰度數(KWh)')
					->setCellValue('A15', '離峰度數(KWh)')
					->setCellValue('A16', '總用電度數(KWh)')
					->setCellValue('A17', '功率因數(%)')
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

// 套用到 A5:A17
$objPHPExcel->getActiveSheet()->getStyle('A5:A17')->applyFromArray($styleArray);



$mDB = "";
$mDB = new MywebDB();

$mDB2 = "";
$mDB2 = new MywebDB();


//取得年月份
$Qry="select dm_year from grPA310_logs_by_month
where case_id = '$case_id' group by dm_year order by dm_year desc";

$mDB->query($Qry);
$m_year  = "";
if ($mDB->rowCount() > 0) {
	$m_year  = "<select class=\"inline form-control\" name=\"period_list\" id=\"period_list\" style=\"width:auto;\">";
	$n = 0;
	while ($row=$mDB->fetchRow(2)) {
	
		$o_current_year = $row['dm_year'];
		$o_period = "$First ".$o_current_year." $theyear";
		
		$m_year .=  "<option value='/index.php?ch=grPA310_year_summary&current_year=".$o_current_year."&fm=$fm' ".mySelect($o_period,$m_period).">$o_period</option>";
		
		$n++;
		if ($n == 1) {
			if (!isset($_GET['current_year'])) {
				$current_year = $o_current_year;
				$m_period = "$First ".$current_year." $theyear";
			}
		}
		
	}
	$m_year .= "</select>";
}






$m_data = array();

$show_analysis = "";



$Qry="SELECT * FROM grPA310_logs_by_month
WHERE case_id = '$case_id' AND dm_year = '$current_year'
ORDER BY case_id,dm_year,dm_month";

$mDB->query($Qry);


$m_PEAK_KW = array(0,0,0,0,0,0,0,0,0,0,0,0);
$m_HALF_PEAK_KW = array(0,0,0,0,0,0,0,0,0,0,0,0);
$m_SATURDAY_HALF_PEAK_KW = array(0,0,0,0,0,0,0,0,0,0,0,0);
$m_OFF_PEAK_KW = array(0,0,0,0,0,0,0,0,0,0,0,0);
$m_DEMAND_KW = array(0,0,0,0,0,0,0,0,0,0,0,0);

$m_PEAK_KWH = array(0,0,0,0,0,0,0,0,0,0,0,0);
$m_HALF_PEAK_KWH = array(0,0,0,0,0,0,0,0,0,0,0,0);
$m_SATURDAY_HALF_PEAK_KWH = array(0,0,0,0,0,0,0,0,0,0,0,0);
$m_OFF_PEAK_KWH = array(0,0,0,0,0,0,0,0,0,0,0,0);
$m_KWH = array(0,0,0,0,0,0,0,0,0,0,0,0);


$rowCount = $mDB->rowCount();
if ($rowCount > 0) {
    while ($PA310_row=$mDB->fetchRow(2)) {
		
		$current_month = $PA310_row['dm_month'];

		$START_DATE = $PA310_row['START_DATE'];
		//$END_DATE = date("Y-m-d",strtotime($PA310_row['END_DATE']." -1 day"));
		$END_DATE = $PA310_row['END_DATE'];
		$DEMAND_KW = $PA310_row['DEMAND_KW'];
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
			$current_month
			,$START_DATE
			,$END_DATE
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


		$m_PEAK_KW[$current_month-1] = round($PEAK_KW,2);
		$m_HALF_PEAK_KW[$current_month-1] = round($HALF_PEAK_KW,2);
		$m_SATURDAY_HALF_PEAK_KW[$current_month-1] = round($SATURDAY_HALF_PEAK_KW,2);
		$m_OFF_PEAK_KW[$current_month-1] = round($OFF_PEAK_KW,2);
		$m_DEMAND_KW[$current_month-1] = round($DEMAND_KW,2);

		$m_PEAK_KWH[$current_month-1] = round($PEAK_KWH,2);
		$m_HALF_PEAK_KWH[$current_month-1] = round($HALF_PEAK_KWH,2);
		$m_SATURDAY_HALF_PEAK_KWH[$current_month-1] = round($SATURDAY_HALF_PEAK_KWH,2);
		$m_OFF_PEAK_KWH[$current_month-1] = round($OFF_PEAK_KWH,2);
		$m_KWH[$current_month-1] = round($KWH,2);

		
	}
}



$mDB->remove();



$count = count($m_data);
if ($count > 0) {

	//初始化
	for ($i = 1; $i <= 12; $i++) {

		$START_DATE = "START_DATE"."_".$i;
		$$START_DATE = "-";

		$END_DATE = "END_DATE"."_".$i;
		$$END_DATE = "-";

		$DEMAND_KW = "DEMAND_KW"."_".$i;
		$$DEMAND_KW = "-";

		$PEAK_KW = "PEAK_KW"."_".$i;
		$$PEAK_KW = "-";

		$HALF_PEAK_KW = "HALF_PEAK_KW"."_".$i;
		$$HALF_PEAK_KW = "-";

		$SATURDAY_HALF_PEAK_KW = "SATURDAY_HALF_PEAK_KW"."_".$i;
		$$SATURDAY_HALF_PEAK_KW = "_";

		$OFF_PEAK_KW = "OFF_PEAK_KW"."_".$i;
		$$OFF_PEAK_KW = "-";

		$PEAK_KWH = "PEAK_KWH"."_".$i;
		$$PEAK_KWH = "-";

		$HALF_PEAK_KWH = "HALF_PEAK_KWH"."_".$i;
		$$HALF_PEAK_KWH = "-";
		
		$SATURDAY_HALF_PEAK_KWH = "SATURDAY_HALF_PEAK_KWH"."_".$i;
		$$SATURDAY_HALF_PEAK_KWH = "_";

		$OFF_PEAK_KWH = "OFF_PEAK_KWH"."_".$i;
		$$OFF_PEAK_KWH = "-";

		$KWH = "KWH"."_".$i;
		$$KWH = "-";

		$PF = "PF"."_".$i;
		$$PF = "-";

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
		$current_month = $val[$k];

		$k++;
		$START_DATE = "START_DATE"."_".$current_month;
		$$START_DATE = date('m-d',strtotime($val[$k]));

		$k++;
		$END_DATE = "END_DATE"."_".$current_month;
		$$END_DATE = date('m-d',strtotime($val[$k]));

		$k++;
		$DEMAND_KW = "DEMAND_KW"."_".$current_month;
		$$DEMAND_KW = number_format2($val[$k],0);
		if ($val[$k] > $DEMAND_KW_MAX)
			$DEMAND_KW_MAX = $val[$k];

		$k++;
		$PEAK_KW = "PEAK_KW"."_".$current_month;
		$$PEAK_KW = number_format2($val[$k],2);
		if ($val[$k] > $PEAK_KW_MAX)
			$PEAK_KW_MAX = $val[$k];

		$k++;
		$HALF_PEAK_KW = "HALF_PEAK_KW"."_".$current_month;
		$$HALF_PEAK_KW = number_format2($val[$k],2);
		if ($val[$k] > $HALF_PEAK_KW_MAX)
			$HALF_PEAK_KW_MAX = $val[$k];

		$k++;
		$SATURDAY_HALF_PEAK_KW = "SATURDAY_HALF_PEAK_KW"."_".$current_month;
		$$SATURDAY_HALF_PEAK_KW = number_format2($val[$k],2);
		if ($val[$k] > $SATURDAY_HALF_PEAK_KW_MAX)
			$SATURDAY_HALF_PEAK_KW_MAX = $val[$k];


		$k++;
		$OFF_PEAK_KW = "OFF_PEAK_KW"."_".$current_month;
		$$OFF_PEAK_KW = number_format2($val[$k],2);
		if ($val[$k] > $OFF_PEAK_KW_MAX)
			$OFF_PEAK_KW_MAX = $val[$k];

		$k++;
		$PEAK_KWH = "PEAK_KWH"."_".$current_month;
		$$PEAK_KWH = number_format2($val[$k],2);
		$PEAK_KWH_TOTAL += $val[$k];

		$k++;
		$HALF_PEAK_KWH = "HALF_PEAK_KWH"."_".$current_month;
		$$HALF_PEAK_KWH = number_format2($val[$k],2);
		$HALF_PEAK_KWH_TOTAL += $val[$k];

		$k++;
		$SATURDAY_HALF_PEAK_KWH = "SATURDAY_HALF_PEAK_KWH"."_".$current_month;
		$$SATURDAY_HALF_PEAK_KWH = number_format2($val[$k],2);
		$SATURDAY_HALF_PEAK_KWH_TOTAL += $val[$k];

		$k++;
		$OFF_PEAK_KWH = "OFF_PEAK_KWH"."_".$current_month;
		$$OFF_PEAK_KWH = number_format2($val[$k],2);
		$OFF_PEAK_KWH_TOTAL += $val[$k];

		$k++;
		$KWH = "KWH"."_".$current_month;
		$$KWH = number_format2($val[$k],2);
		$KWH_TOTAL += $val[$k];

		$k++;
		$PF = "PF"."_".$current_month;
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
	$SATURDAY_HALF_PEAK_KW_PERCENT = ""; if ($DEMAND_KW_MAX > 0) $SATURDAY_HALF_PEAK_KW_PERCENT = round($SATURDAY_HALF_PEAK_KW_MAX / $DEMAND_KW_MAX * 100, 2) . "%";
	$OFF_PEAK_KW_PERCENT = ""; if ($DEMAND_KW_MAX > 0) $OFF_PEAK_KW_PERCENT = round($OFF_PEAK_KW_MAX/$DEMAND_KW_MAX*100,1)."%";
	$PEAK_KWH_PERCENT = ""; if ($KWH_TOTAL > 0) $PEAK_KWH_PERCENT = round($PEAK_KWH_TOTAL/$KWH_TOTAL*100,1)."%";
	$HALF_PEAK_KWH_PERCENT = ""; if ($KWH_TOTAL > 0) $HALF_PEAK_KWH_PERCENT = round($HALF_PEAK_KWH_TOTAL/$KWH_TOTAL*100,1)."%";
	$SATURDAY_HALF_PEAK_KWH_PERCENT = ""; if ($KWH_TOTAL > 0) $SATURDAY_HALF_PEAK_KWH_PERCENT = round($SATURDAY_HALF_PEAK_KWH_TOTAL/$KWH_TOTAL*100,1)."%";
	$OFF_PEAK_KWH_PERCENT = ""; if ($KWH_TOTAL > 0) $OFF_PEAK_KWH_PERCENT = round($OFF_PEAK_KWH_TOTAL/$KWH_TOTAL*100,1)."%";
	$KWH_PERCENT = "100%";


}

//計費起始日
$objPHPExcel->setActiveSheetIndex(0)

            ->setCellValue('B5', $START_DATE_1)
            ->setCellValue('C5', $START_DATE_2)
            ->setCellValue('D5', $START_DATE_3)
            ->setCellValue('E5', $START_DATE_4)
            ->setCellValue('F5', $START_DATE_5)
            ->setCellValue('G5', $START_DATE_6)
            ->setCellValue('H5', $START_DATE_7)
            ->setCellValue('I5', $START_DATE_8)
            ->setCellValue('J5', $START_DATE_9)
            ->setCellValue('K5', $START_DATE_10)
            ->setCellValue('L5', $START_DATE_11)
            ->setCellValue('M5', $START_DATE_12)

			;

//計費起始日
$objPHPExcel->setActiveSheetIndex(0)

            ->setCellValue('B6', $END_DATE_1)
            ->setCellValue('C6', $END_DATE_2)
            ->setCellValue('D6', $END_DATE_3)
            ->setCellValue('E6', $END_DATE_4)
            ->setCellValue('F6', $END_DATE_5)
            ->setCellValue('G6', $END_DATE_6)
            ->setCellValue('H6', $END_DATE_7)
            ->setCellValue('I6', $END_DATE_8)
            ->setCellValue('J6', $END_DATE_9)
            ->setCellValue('K6', $END_DATE_10)
            ->setCellValue('L6', $END_DATE_11)
            ->setCellValue('M6', $END_DATE_12)

			;

//經常契約容量(KW)
$objPHPExcel->setActiveSheetIndex(0)

            ->setCellValue('B7', $DEMAND_KW_1)
            ->setCellValue('C7', $DEMAND_KW_2)
            ->setCellValue('D7', $DEMAND_KW_3)
            ->setCellValue('E7', $DEMAND_KW_4)
            ->setCellValue('F7', $DEMAND_KW_5)
            ->setCellValue('G7', $DEMAND_KW_6)
            ->setCellValue('H7', $DEMAND_KW_7)
            ->setCellValue('I7', $DEMAND_KW_8)
            ->setCellValue('J7', $DEMAND_KW_9)
            ->setCellValue('K7', $DEMAND_KW_10)
            ->setCellValue('L7', $DEMAND_KW_11)
            ->setCellValue('M7', $DEMAND_KW_12)
			->setCellValue('O7', '100%')

			;

// 設定經常契約底色
$objPHPExcel->getActiveSheet()->getStyle('A7:O7')->applyFromArray(
    array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'FFDBDB')
        )
    )
);

//尖峰需量(KW)
$PEAK_KW_PERCENT = "";
if ($DEMAND_KW_MAX > 0) {
    $PEAK_KW_PERCENT = number_format($PEAK_KW_MAX / $DEMAND_KW_MAX * 100, 2) . "%";
}
$objPHPExcel->setActiveSheetIndex(0)

			->setCellValue('B8', $PEAK_KW_1)
			->setCellValue('C8', $PEAK_KW_2)
			->setCellValue('D8', $PEAK_KW_3)
			->setCellValue('E8', $PEAK_KW_4)
			->setCellValue('F8', $PEAK_KW_5)
			->setCellValue('G8', $PEAK_KW_6)
			->setCellValue('H8', $PEAK_KW_7)
			->setCellValue('I8', $PEAK_KW_8)
			->setCellValue('J8', $PEAK_KW_9)
			->setCellValue('K8', $PEAK_KW_10)
			->setCellValue('L8', $PEAK_KW_11)
			->setCellValue('M8', $PEAK_KW_12)
			->setCellValue('N8', $PEAK_KW_MAX)
			->setCellValue('O8', $PEAK_KW_PERCENT)

			;

//半尖峰需量(KW)
$objPHPExcel->setActiveSheetIndex(0)

			->setCellValue('B9', $HALF_PEAK_KW_1)
			->setCellValue('C9', $HALF_PEAK_KW_2)
			->setCellValue('D9', $HALF_PEAK_KW_3)
			->setCellValue('E9', $HALF_PEAK_KW_4)
			->setCellValue('F9', $HALF_PEAK_KW_5)
			->setCellValue('G9', $HALF_PEAK_KW_6)
			->setCellValue('H9', $HALF_PEAK_KW_7)
			->setCellValue('I9', $HALF_PEAK_KW_8)
			->setCellValue('J9', $HALF_PEAK_KW_9)
			->setCellValue('K9', $HALF_PEAK_KW_10)
			->setCellValue('L9', $HALF_PEAK_KW_11)
			->setCellValue('M9', $HALF_PEAK_KW_12)
			->setCellValue('N9', $HALF_PEAK_KW_MAX)
			->setCellValue('O9', $HALF_PEAK_KW_PERCENT)
			;

//SATURDAY_HALF_PEAK_KW   週六半尖峰需量(KW)
$objPHPExcel->setActiveSheetIndex(0)

			->setCellValue('B10', $SATURDAY_HALF_PEAK_KW_1)
			->setCellValue('C10', $SATURDAY_HALF_PEAK_KW_2)
			->setCellValue('D10', $SATURDAY_HALF_PEAK_KW_3)
			->setCellValue('E10', $SATURDAY_HALF_PEAK_KW_4)
			->setCellValue('F10', $SATURDAY_HALF_PEAK_KW_5)
			->setCellValue('G10', $SATURDAY_HALF_PEAK_KW_6)
			->setCellValue('H10', $SATURDAY_HALF_PEAK_KW_7)
			->setCellValue('I10', $SATURDAY_HALF_PEAK_KW_8)
			->setCellValue('J10', $SATURDAY_HALF_PEAK_KW_9)
			->setCellValue('K10', $SATURDAY_HALF_PEAK_KW_10)
			->setCellValue('L10', $SATURDAY_HALF_PEAK_KW_11)
			->setCellValue('M10', $SATURDAY_HALF_PEAK_KW_12)
			->setCellValue('N10', $SATURDAY_HALF_PEAK_KW_MAX)
			->setCellValue('O10', $SATURDAY_HALF_PEAK_KW_PERCENT)
			;

//離峰需量(KW)
$objPHPExcel->setActiveSheetIndex(0)

			->setCellValue('B11', $OFF_PEAK_KW_1)
			->setCellValue('C11', $OFF_PEAK_KW_2)
			->setCellValue('D11', $OFF_PEAK_KW_3)
			->setCellValue('E11', $OFF_PEAK_KW_4)
			->setCellValue('F11', $OFF_PEAK_KW_5)
			->setCellValue('G11', $OFF_PEAK_KW_6)
			->setCellValue('H11', $OFF_PEAK_KW_7)
			->setCellValue('I11', $OFF_PEAK_KW_8)
			->setCellValue('J11', $OFF_PEAK_KW_9)
			->setCellValue('K11', $OFF_PEAK_KW_10)
			->setCellValue('L11', $OFF_PEAK_KW_11)
			->setCellValue('M11', $OFF_PEAK_KW_12)
			->setCellValue('N11', $OFF_PEAK_KW_MAX)
			->setCellValue('O11', $OFF_PEAK_KW_PERCENT)
			;

//PEAK_KWH   尖峰度數(KWh)
$objPHPExcel->setActiveSheetIndex(0)

			->setCellValue('B12', $PEAK_KWH_1)
			->setCellValue('C12', $PEAK_KWH_2)
			->setCellValue('D12', $PEAK_KWH_3)
			->setCellValue('E12', $PEAK_KWH_4)
			->setCellValue('F12', $PEAK_KWH_5)
			->setCellValue('G12', $PEAK_KWH_6)
			->setCellValue('H12', $PEAK_KWH_7)
			->setCellValue('I12', $PEAK_KWH_8)
			->setCellValue('J12', $PEAK_KWH_9)
			->setCellValue('K12', $PEAK_KWH_10)
			->setCellValue('L12', $PEAK_KWH_11)
			->setCellValue('M12', $PEAK_KWH_12)
			->setCellValue('N12', $PEAK_KWH_TOTAL)
			->setCellValue('O12', $PEAK_KWH_PERCENT)
			;

//HALF_PEAK_KWH   半尖峰度數(KWh)
$objPHPExcel->setActiveSheetIndex(0)

			->setCellValue('B13', $HALF_PEAK_KWH_1)
			->setCellValue('C13', $HALF_PEAK_KWH_2)
			->setCellValue('D13', $HALF_PEAK_KWH_3)
			->setCellValue('E13', $HALF_PEAK_KWH_4)
			->setCellValue('F13', $HALF_PEAK_KWH_5)
			->setCellValue('G13', $HALF_PEAK_KWH_6)
			->setCellValue('H13', $HALF_PEAK_KWH_7)
			->setCellValue('I13', $HALF_PEAK_KWH_8)
			->setCellValue('J13', $HALF_PEAK_KWH_9)
			->setCellValue('K13', $HALF_PEAK_KWH_10)
			->setCellValue('L13', $HALF_PEAK_KWH_11)
			->setCellValue('M13', $HALF_PEAK_KWH_12)
			->setCellValue('N13', $HALF_PEAK_KWH_TOTAL)
			->setCellValue('O13', $HALF_PEAK_KWH_PERCENT)
			;

//SATURDAY_HALF_PEAK_KWH   週六半尖峰度數(KWh)
$objPHPExcel->setActiveSheetIndex(0)

			->setCellValue('B14', $SATURDAY_HALF_PEAK_KWH_1)
			->setCellValue('C14', $SATURDAY_HALF_PEAK_KWH_2)
			->setCellValue('D14', $SATURDAY_HALF_PEAK_KWH_3)
			->setCellValue('E14', $SATURDAY_HALF_PEAK_KWH_4)
			->setCellValue('F14', $SATURDAY_HALF_PEAK_KWH_5)
			->setCellValue('G14', $SATURDAY_HALF_PEAK_KWH_6)
			->setCellValue('H14', $SATURDAY_HALF_PEAK_KWH_7)
			->setCellValue('I14', $SATURDAY_HALF_PEAK_KWH_8)
			->setCellValue('J14', $SATURDAY_HALF_PEAK_KWH_9)
			->setCellValue('K14', $SATURDAY_HALF_PEAK_KWH_10)
			->setCellValue('L14', $SATURDAY_HALF_PEAK_KWH_11)
			->setCellValue('M14', $SATURDAY_HALF_PEAK_KWH_12)
			->setCellValue('N14', $SATURDAY_HALF_PEAK_KWH_TOTAL)
			->setCellValue('O14', $SATURDAY_HALF_PEAK_KWH_PERCENT)
			;

//OFF_PEAK_KWH   離峰度數(KWh)
$objPHPExcel->setActiveSheetIndex(0)	

			->setCellValue('B15', $OFF_PEAK_KWH_1)
			->setCellValue('C15', $OFF_PEAK_KWH_2)
			->setCellValue('D15', $OFF_PEAK_KWH_3)
			->setCellValue('E15', $OFF_PEAK_KWH_4)
			->setCellValue('F15', $OFF_PEAK_KWH_5)
			->setCellValue('G15', $OFF_PEAK_KWH_6)
			->setCellValue('H15', $OFF_PEAK_KWH_7)
			->setCellValue('I15', $OFF_PEAK_KWH_8)
			->setCellValue('J15', $OFF_PEAK_KWH_9)
			->setCellValue('K15', $OFF_PEAK_KWH_10)
			->setCellValue('L15', $OFF_PEAK_KWH_11)
			->setCellValue('M15', $OFF_PEAK_KWH_12)
			->setCellValue('N15', $OFF_PEAK_KWH_TOTAL)
			->setCellValue('O15', $OFF_PEAK_KWH_PERCENT)
			;	

//KWH   總度數(KWh)
$objPHPExcel->setActiveSheetIndex(0)	

			->setCellValue('B16', $KWH_1)
			->setCellValue('C16', $KWH_2)
			->setCellValue('D16', $KWH_3)
			->setCellValue('E16', $KWH_4)
			->setCellValue('F16', $KWH_5)
			->setCellValue('G16', $KWH_6)
			->setCellValue('H16', $KWH_7)
			->setCellValue('I16', $KWH_8)
			->setCellValue('J16', $KWH_9)
			->setCellValue('K16', $KWH_10)
			->setCellValue('L16', $KWH_11)
			->setCellValue('M16', $KWH_12)
			->setCellValue('N16', $KWH_TOTAL)
			->setCellValue('O16', $KWH_PERCENT)
			;

// 設定總度數底色
$objPHPExcel->getActiveSheet()->getStyle('A16:O16')->applyFromArray(
    array(
        'fill' => array(
            'type'  => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'C9FFB7') 
        )
    )
);

//PF   功率因數(%)
$objPHPExcel->setActiveSheetIndex(0)	

			->setCellValue('B17', $PF_1)
			->setCellValue('C17', $PF_2)
			->setCellValue('D17', $PF_3)
			->setCellValue('E17', $PF_4)
			->setCellValue('F17', $PF_5)
			->setCellValue('G17', $PF_6)
			->setCellValue('H17', $PF_7)
			->setCellValue('I17', $PF_8)
			->setCellValue('J17', $PF_9)
			->setCellValue('K17', $PF_10)
			->setCellValue('L17', $PF_11)
			->setCellValue('M17', $PF_12)
			;





//Set page orientation and size 方向大小
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);



// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle("荒川_年度用電總量分析表_".$current_year."年");


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


$xlsx_filename = "荒川_年度用電總量分析表_".$current_year."年.xls";

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
