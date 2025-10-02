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



$case_id = $_GET['case_id'];


//載入公用函數
@include_once '/website/include/pub_function.php';



$current_year = $_GET['current_year'];
$current_month = $_GET['current_month'];



//現在日期時間
$today = date('Y-m-d H:i');


@include_once("/website/class/".$site_db."_info_class.php");


if (PHP_SAPI == 'cli')
	die('This programe should only be run from a Web Browser');

/** Include PHPExcel */
require_once '/website/os/PHPExcel-1.8.1/Classes/PHPExcel.php';


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("apupu")
							 ->setLastModifiedBy("apupu")
							 ->setTitle("Office 2007 XLSX Document")
							 ->setSubject("Office 2007 XLSX Document")
							 ->setDescription("The document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("分電表用電月報表".$current_year."年".$current_month."月)");

							 
//合併儲存格						 
$objPHPExcel->setActiveSheetIndex(0)
			->mergeCells('A1:AH1')
			->mergeCells('A2:AH2')
			->mergeCells('A3:Q3')
			->mergeCells('R3:AH3')
			;
							 
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', "")
            ->setCellValue('A2', '分電表用電月報表')
            ->setCellValue('A3', '資料年月份：'.$current_year.'年'.$current_month.'月')
            ->setCellValue('R3', '單位 : KWH     報表日期：'.$today)
            ->setCellValue('A4', '合併節點')
            ->setCellValue('B4', '1日')
            ->setCellValue('C4', '2日')
            ->setCellValue('D4', '3日')
            ->setCellValue('E4', '4日')
            ->setCellValue('F4', '5日')
            ->setCellValue('G4', '6日')
            ->setCellValue('H4', '7日')
            ->setCellValue('I4', '8日')
            ->setCellValue('J4', '9日')
            ->setCellValue('K4', '10日')
            ->setCellValue('L4', '11日')
            ->setCellValue('M4', '12日')
            ->setCellValue('N4', '13日')
            ->setCellValue('O4', '14日')
            ->setCellValue('P4', '15日')
            ->setCellValue('Q4', '16日')
            ->setCellValue('R4', '17日')
            ->setCellValue('S4', '18日')
            ->setCellValue('T4', '19日')
            ->setCellValue('U4', '20日')
            ->setCellValue('V4', '21日')
            ->setCellValue('W4', '22日')
            ->setCellValue('X4', '23日')
            ->setCellValue('Y4', '24日')
            ->setCellValue('Z4', '25日')
            ->setCellValue('AA4', '26日')
            ->setCellValue('AB4', '27日')
            ->setCellValue('AC4', '28日')
            ->setCellValue('AD4', '29日')
            ->setCellValue('AE4', '30日')
            ->setCellValue('AF4', '31日')
            ->setCellValue('AG4', '合計')
            ->setCellValue('AH4', '佔比%')
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

//$objPHPExcel->getActiveSheet()->getStyle('A2:K2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
//$objPHPExcel->getActiveSheet()->getStyle('A2:K2')->getBorders()->getBottom()->getColor()->setRGB('000000');

//設置垂及及水平對齊
$objPHPExcel->getActiveSheet()->getStyle('A4:AH4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A4:AH4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

//設置欄位寬度
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
/*
//$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(8);
*/



//設置底色
$objPHPExcel->getActiveSheet()->getStyle('A4:AF4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A4:AF4')->getFill()->getStartColor()->setRGB('7FDBFF');

$objPHPExcel->getActiveSheet()->getStyle('AG4:AH4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('AG4:AH4')->getFill()->getStartColor()->setRGB('FFDC00');

//設置邊框線及顏色			
$objPHPExcel->getActiveSheet()->getStyle('A4:AH4')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->getStyle('A4:AH4')->getBorders()->getAllBorders()->getColor()->setRGB('000000');



$mDB = "";
$mDB = new MywebDB();

$mDB2 = "";
$mDB2 = new MywebDB();

$fm = $_GET['fm'];
$ch = $_GET['ch'];
$case_id = $_GET['case_id'];

$current_year = $_GET['current_year'];
if (!isset($_GET['current_year']))
	$current_year = date('Y');

$current_month = $_GET['current_month'];
if (!isset($_GET['current_month']))
	$current_month = date('m');

$m_period = $current_year."年".$current_month."月";

//取得年月份
$Qry="SELECT am_year,am_month FROM ammeter_node_kwh_day
WHERE case_id = '$case_id' 
GROUP BY case_id,am_year,am_month ORDER BY case_id,am_year DESC,am_month DESC";

$mDB->query($Qry);
$m_year  = "";
if ($mDB->rowCount() > 0) {
	$m_year  = "<select class=\"inline form-control\" name=\"period_list\" id=\"period_list\" style=\"width:auto;\">";
	$n = 0;
	while ($row=$mDB->fetchRow(2)) {
	
		$o_current_year = $row['am_year'];
		$o_current_month = $row['am_month'];
		$o_period = $o_current_year."年".$o_current_month."月";
		
		$m_year .=  "<option value='/index.php?ch=$ch&case_id=$case_id&current_year=".$o_current_year."&current_month=".$o_current_month."&fm=$fm' ".mySelect($o_period,$m_period).">$o_period</option>";
		
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

//先取得量測節點總和
$KWH_SUMMARY_TOT = 0;		//全部總和

//先取得量測節點
$Qry="SELECT a.merge_node,a.case_id,a.router_id,a.ammeter_id,b.am_year,b.am_month,b.am_day,a.node_no
,b.KWH_1
,b.KWH_2
,b.KWH_3
,b.KWH_4
,b.KWH_5
,b.KWH_6
,b.KWH_7
,b.KWH_8
,b.KWH_9
,b.KWH_10
,b.KWH_11
,b.KWH_12
,b.KWH_13
,b.KWH_14
,b.KWH_15
,b.KWH_16
FROM ammeter_node a
LEFT JOIN ammeter_node_kwh_day b ON b.case_id = a.case_id AND b.router_id = a.router_id AND b.ammeter_id = a.ammeter_id 
WHERE a.case_id = '$case_id' AND a.enabled = 'Y' AND a.main_meter = 'N'
AND b.am_year = '$current_year' AND b.am_month = '$current_month'
AND a.merge_node <> ''
ORDER BY a.case_id,a.merge_node,b.am_year,b.am_month,b.am_day,a.node_no
";

$mDB->query($Qry);

if ($mDB->rowCount() > 0) {

	$merge_node = '';

	while ($row=$mDB->fetchRow(2)) {
		
		$o_am_day = $row['am_day'];
		$o_node_no = $row['node_no'];
		$o_merge_node = $row['merge_node'];

		if ($o_merge_node <> $merge_node) {
			$merge_node = $o_merge_node;
		} 

		if ($o_merge_node == $merge_node) {
			for ($i = 0; $i <= 30; $i++) {
				$DAY = $row['am_day'];
				if ($DAY == $i+1) {
					$KWH = "KWH_".$o_node_no;
					$KWH_SUMMARY_TOT += $row[$KWH];
				}
			}
		}

	}

}

$last_am_day = $o_am_day;

$show_analysis = "";


//先取得量測節點
$Qry="SELECT a.merge_node,a.case_id,a.router_id,a.ammeter_id,b.am_year,b.am_month,b.am_day,a.node_no
,b.KWH_1
,b.KWH_2
,b.KWH_3
,b.KWH_4
,b.KWH_5
,b.KWH_6
,b.KWH_7
,b.KWH_8
,b.KWH_9
,b.KWH_10
,b.KWH_11
,b.KWH_12
,b.KWH_13
,b.KWH_14
,b.KWH_15
,b.KWH_16
,(SELECT count(*) FROM ammeter_node WHERE case_id = a.case_id AND enabled = 'Y' AND main_meter = 'N'
AND b.am_year = '$current_year' AND b.am_month = '$current_month'
AND merge_node = a.merge_node
GROUP BY case_id,merge_node,am_year,am_month,am_day
ORDER BY case_id,merge_node,am_year,am_month,am_day,node_no LIMIT 1
) as icount
FROM ammeter_node a
LEFT JOIN ammeter_node_kwh_day b ON b.case_id = a.case_id AND b.router_id = a.router_id AND b.ammeter_id = a.ammeter_id 
WHERE a.case_id = '$case_id' AND a.enabled = 'Y' AND a.main_meter = 'N'
AND b.am_year = '$current_year' AND b.am_month = '$current_month'
AND a.merge_node <> ''
ORDER BY a.case_id,a.merge_node,b.am_year,b.am_month,b.am_day,a.node_no
";

$mDB->query($Qry);

$m_KWH_TOT = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);


if ($mDB->rowCount() > 0) {

	$merge_node = '';

	$m_KWH = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);

	$KWH_SUMMARY = 0;
	
	while ($row=$mDB->fetchRow(2)) {
		$case_id = $row['case_id'];
		$router_id = $row['router_id'];
		$ammeter_id = $row['ammeter_id'];
		$o_am_day = $row['am_day'];
		$o_node_no = $row['node_no'];
		$phase = $row['phase'];
		$description = $row['description'];
		$o_merge_node = $row['merge_node'];
		$icount = $row['icount'];

		if ($o_merge_node <> $merge_node) {

			$merge_node = $o_merge_node;
			$seq = 0;
			
		} 

		if ($o_merge_node == $merge_node) {
			for ($i = 0; $i <= 30; $i++) {
				$DAY = $row['am_day'];
				if ($DAY == $i+1) {
					$KWH = "KWH_".$o_node_no;
					$m_KWH[$i] += $row[$KWH];
					$m_KWH_TOT[$i] += $row[$KWH];
				}
			}
		}


		$excelRow = 5; // 從第5列開始

	while ($row=$mDB->fetchRow(2)) {
		$case_id = $row['case_id'];
		$router_id = $row['router_id'];
		$ammeter_id = $row['ammeter_id'];
		$o_am_day = $row['am_day'];
		$o_node_no = $row['node_no'];
		$phase = $row['phase'];
		$description = $row['description'];
		$o_merge_node = $row['merge_node'];
		$icount = $row['icount'];

		if ($o_merge_node <> $merge_node) {
			$merge_node = $o_merge_node;
			$seq = 0;
		} 

		if ($o_merge_node == $merge_node) {
			for ($i = 0; $i <= 30; $i++) {
				$DAY = $row['am_day'];
				if ($DAY == $i+1) {
					$KWH = "KWH_".$o_node_no;
					$m_KWH[$i] += $row[$KWH];
					$m_KWH_TOT[$i] += $row[$KWH];
				}
			}
		}

		if ($o_am_day >= $last_am_day) {
			$seq++;
			if ($seq >= $icount) {

				for ($i = 0; $i <= 30; $i++) {
					$KWH_SUMMARY = $KWH_SUMMARY+$m_KWH[$i];
					$m_KWH[$i] = number_format2($m_KWH[$i],4);
				}
				$fmt_KWH_SUMMARY = number_format2($KWH_SUMMARY,4);

				//計算百分佔比
				$KWH_SUMMARY_PERCENT = 0;
				if ($KWH_SUMMARY_TOT <> 0) {
					$KWH_SUMMARY_PERCENT = round(($KWH_SUMMARY/$KWH_SUMMARY_TOT)*100,1);
				}

				// 動態列數寫入
				$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue("A{$excelRow}", $merge_node);

				for ($i = 0; $i <= 30; $i++) {
					$col = PHPExcel_Cell::stringFromColumnIndex($i+1); // B 開始
					$objPHPExcel->getActiveSheet()->setCellValue("{$col}{$excelRow}", $m_KWH[$i]);
				}

				$objPHPExcel->getActiveSheet()
					->setCellValue("AG{$excelRow}", $fmt_KWH_SUMMARY)
					->setCellValue("AH{$excelRow}", $KWH_SUMMARY_PERCENT)
					->setCellValue("AI{$excelRow}", $case_id)
					->setCellValue("AJ{$excelRow}", $router_id)
					->setCellValue("AK{$excelRow}", $ammeter_id)
					->setCellValue("AL{$excelRow}", $o_am_day)
					->setCellValue("AM{$excelRow}", $o_node_no)
					->setCellValue("AN{$excelRow}", $phase)
					->setCellValue("AO{$excelRow}", $description)
					->setCellValue("AP{$excelRow}", $icount)

					;


				// reset
				$m_KWH = array_fill(0, 31, 0);
				$KWH_SUMMARY = 0;

				// 下一列
				$excelRow++;
			}
		}
	}

	}
	
}

$mDB2->remove();
$mDB->remove();




//Set page orientation and size 方向大小
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);



// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle("分電表用電月報表(".$current_year."年".$current_month."月)");


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


$xlsx_filename = "分電表用電月報表(".$current_year."年".$current_month."月).xls";

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
