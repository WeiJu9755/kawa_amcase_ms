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
$current_day = $_GET['current_day'];



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
							 ->setCategory("分電表用電日報表(".$current_year."年".$current_month."月".$current_day."日)");

							 
//合併儲存格						 
$objPHPExcel->setActiveSheetIndex(0)
			->mergeCells('A1:AA1')
			->mergeCells('A2:AA2')
			->mergeCells('A3:Q3')
			->mergeCells('R3:AA3')
			;
							 
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', "")
            ->setCellValue('A2', '分電表用電日報表')
            ->setCellValue('A3', '資料年月日：'.$current_year.'年'.$current_month.'月'.$current_day.'日')
            ->setCellValue('R3', '單位 : KWH     報表日期：'.$today)
            ->setCellValue('A4', '設備名稱/小時')
            ->setCellValue('B4', '0')
            ->setCellValue('C4', '1')
            ->setCellValue('D4', '2')
            ->setCellValue('E4', '3')
            ->setCellValue('F4', '4')
            ->setCellValue('G4', '5')
            ->setCellValue('H4', '6')
            ->setCellValue('I4', '7')
            ->setCellValue('J4', '8')
            ->setCellValue('K4', '9')
            ->setCellValue('L4', '10')
            ->setCellValue('M4', '11')
            ->setCellValue('N4', '12')
            ->setCellValue('O4', '13')
            ->setCellValue('P4', '14')
            ->setCellValue('Q4', '15')
            ->setCellValue('R4', '16')
            ->setCellValue('S4', '17')
            ->setCellValue('T4', '18')
            ->setCellValue('U4', '19')
            ->setCellValue('V4', '20')
            ->setCellValue('W4', '21')
            ->setCellValue('X4', '22')
            ->setCellValue('Y4', '23')
            ->setCellValue('Z4', '合計')
            ->setCellValue('AA4', '佔比%')
			;

//設置字型大小
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(24)->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setSize(18)->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setSize(16);
$objPHPExcel->getActiveSheet()->getStyle('R3')->getFont()->setSize(12);
			
$objPHPExcel->getActiveSheet()->getStyle('A4:AA4')->getFont()->setBold(true);			

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
$objPHPExcel->getActiveSheet()->getStyle('A4:AA4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A4:AA4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

//設置欄位寬度
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
/*
//$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(8);
*/



//設置底色
$objPHPExcel->getActiveSheet()->getStyle('A4:Y4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A4:Y4')->getFill()->getStartColor()->setRGB('7FDBFF');

$objPHPExcel->getActiveSheet()->getStyle('Z4:AA4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('Z4:AA4')->getFill()->getStartColor()->setRGB('FFDC00');

//設置邊框線及顏色			
$objPHPExcel->getActiveSheet()->getStyle('A4:AA4')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->getStyle('A4:AA4')->getBorders()->getAllBorders()->getColor()->setRGB('000000');



$mDB = "";
$mDB = new MywebDB();

$mDB2 = "";
$mDB2 = new MywebDB();


//先取得總和
//先取得量測節點
$Qry="SELECT case_id,router_id,ammeter_id,node_no FROM ammeter_node
WHERE case_id = '$case_id' AND `enabled` = 'Y' AND main_meter = 'N'
ORDER BY orderby";
$mDB->query($Qry);

$KWH_SUMMARY_TOT = 0;		//全部總和

if ($mDB->rowCount() > 0) {
	while ($row=$mDB->fetchRow(2)) {
		$case_id = $row['case_id'];
		$router_id = $row['router_id'];
		$ammeter_id = $row['ammeter_id'];
		$node_no = $row['node_no'];

		$Qry2="SELECT * FROM ammeter_node_kwh_hour
			WHERE case_id = '$case_id' AND router_id = '$router_id' AND ammeter_id = '$ammeter_id'
			AND am_year = '$current_year' AND am_month = '$current_month' AND am_day = '$current_day'
			";
		$mDB2->query($Qry2);
		if ($mDB2->rowCount() > 0) {
			while ($row2=$mDB2->fetchRow(2)) {

				for ($i = 0; $i <= 23; $i++) {
					$HOUR = $row2['am_hour'];
					if ($HOUR == $i) {
						$KWH = "KWH_".$node_no;
						//累計總和
						$KWH_SUMMARY_TOT = $KWH_SUMMARY_TOT+$row2[$KWH];
					}
				}

			}
		}
	}
}


$line = 4;

//先取得量測節點
$Qry="SELECT * FROM ammeter_node
WHERE case_id = '$case_id' AND `enabled` = 'Y' AND main_meter = 'N'
ORDER BY orderby";
$mDB->query($Qry);

$m_KWH_TOT = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);

if ($mDB->rowCount() > 0) {

	$seq = 0;
	while ($row=$mDB->fetchRow(2)) {
		$seq++;
		$case_id = $row['case_id'];
		$router_id = $row['router_id'];
		$ammeter_id = $row['ammeter_id'];
		$node_no = $row['node_no'];
		$phase = $row['phase'];
		$description = $row['description'];
		$orderby = $row['orderby'];

		//再取得各 node 的用電 KWH 數值
		$Qry2="SELECT * FROM ammeter_node_kwh_hour
			WHERE case_id = '$case_id' AND router_id = '$router_id' AND ammeter_id = '$ammeter_id'
			AND am_year = '$current_year' AND am_month = '$current_month' AND am_day = '$current_day'
			";
		$mDB2->query($Qry2);

		$KWH_SUMMARY = 0;
		if ($mDB2->rowCount() > 0) {

			$m_KWH = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
			while ($row2=$mDB2->fetchRow(2)) {

				for ($i = 0; $i <= 23; $i++) {
					$HOUR = $row2['am_hour'];
					if ($HOUR == $i) {
						$KWH = "KWH_".$node_no;
						$m_KWH[$i] = $row2[$KWH];
						$KWH_SUMMARY = $KWH_SUMMARY+$row2[$KWH];	//橫向加總
						//累計加總
						$m_KWH_TOT[$i] = $m_KWH_TOT[$i]+$row2[$KWH];


					}
				}
			}
		}

		for ($i = 0; $i <= 30; $i++) {
			$m_KWH[$i] = round($m_KWH[$i],4);
			$m_KWH_TOT[$i] = round($m_KWH_TOT[$i],4);
		}

		$KWH_SUMMARY = round($KWH_SUMMARY,4);

		//計算百分佔比
		$KWH_SUMMARY_PERCENT = 0;
		if ($KWH_SUMMARY_TOT <> 0)
			$KWH_SUMMARY_PERCENT = round(($KWH_SUMMARY/$KWH_SUMMARY_TOT)*100,4);

		$KWH_SUMMARY_TOT = round($KWH_SUMMARY_TOT,4);


		$line++;

		$a = 'A'.$line;
		$b = 'B'.$line;
		$c = 'C'.$line;
		$d = 'D'.$line;
		$e = 'E'.$line;
		$f = 'F'.$line;
		$g = 'G'.$line;
		$h = 'H'.$line;
		$i = 'I'.$line;
		$j = 'J'.$line;
		$k = 'K'.$line;
		$l = 'L'.$line;
		$m = 'M'.$line;
		$n = 'N'.$line;
		$o = 'O'.$line;
		$p = 'P'.$line;
		$q = 'Q'.$line;
		$r = 'R'.$line;
		$s = 'S'.$line;
		$t = 'T'.$line;
		$u = 'U'.$line;
		$v = 'V'.$line;
		$w = 'W'.$line;
		$x = 'X'.$line;
		$y = 'Y'.$line;
		$z = 'Z'.$line;
		$aa = 'AA'.$line;

		

		//設置水平置中
		$objPHPExcel->getActiveSheet()->getStyle($a)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$objPHPExcel->getActiveSheet()->getStyle($b.':'.$aa)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		//設置垂直置上
		$objPHPExcel->getActiveSheet()->getStyle($b.':'.$aa)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		
		
		//設置自動換行
		//$objPHPExcel->getActiveSheet()->getStyle($a.':'.$t)->getAlignment()->setWrapText(true);
		
		
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue($a, $seq." ".$description)
					->setCellValue($b, $m_KWH[0])
					->setCellValue($c, $m_KWH[1])
					->setCellValue($d, $m_KWH[2])
					->setCellValue($e, $m_KWH[3])
					->setCellValue($f, $m_KWH[4])
					->setCellValue($g, $m_KWH[5])
					->setCellValue($h, $m_KWH[6])
					->setCellValue($i, $m_KWH[7])
					->setCellValue($j, $m_KWH[8])
					->setCellValue($k, $m_KWH[9])
					->setCellValue($l, $m_KWH[10])
					->setCellValue($m, $m_KWH[11])
					->setCellValue($n, $m_KWH[12])
					->setCellValue($o, $m_KWH[13])
					->setCellValue($p, $m_KWH[14])
					->setCellValue($q, $m_KWH[15])
					->setCellValue($r, $m_KWH[16])
					->setCellValue($s, $m_KWH[17])
					->setCellValue($t, $m_KWH[18])
					->setCellValue($u, $m_KWH[19])
					->setCellValue($v, $m_KWH[20])
					->setCellValue($w, $m_KWH[21])
					->setCellValue($x, $m_KWH[22])
					->setCellValue($y, $m_KWH[23])
					->setCellValue($z, $KWH_SUMMARY)
					->setCellValue($aa, $KWH_SUMMARY_PERCENT)
			;				

		//設置邊框線及顏色
		$objPHPExcel->getActiveSheet()->getStyle($a.':'.$aa)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle($a.':'.$aa)->getBorders()->getAllBorders()->getColor()->setRGB('000000');
		

		
		

	}


	$line++;

	$a = 'A'.$line;
	$b = 'B'.$line;
	$c = 'C'.$line;
	$d = 'D'.$line;
	$e = 'E'.$line;
	$f = 'F'.$line;
	$g = 'G'.$line;
	$h = 'H'.$line;
	$i = 'I'.$line;
	$j = 'J'.$line;
	$k = 'K'.$line;
	$l = 'L'.$line;
	$m = 'M'.$line;
	$n = 'N'.$line;
	$o = 'O'.$line;
	$p = 'P'.$line;
	$q = 'Q'.$line;
	$r = 'R'.$line;
	$s = 'S'.$line;
	$t = 'T'.$line;
	$u = 'U'.$line;
	$v = 'V'.$line;
	$w = 'W'.$line;
	$x = 'X'.$line;
	$y = 'Y'.$line;
	$z = 'Z'.$line;
	$aa = 'AA'.$line;

	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue($a, '全部總和')
				->setCellValue($b, $m_KWH_TOT[0])
				->setCellValue($c, $m_KWH_TOT[1])
				->setCellValue($d, $m_KWH_TOT[2])
				->setCellValue($e, $m_KWH_TOT[3])
				->setCellValue($f, $m_KWH_TOT[4])
				->setCellValue($g, $m_KWH_TOT[5])
				->setCellValue($h, $m_KWH_TOT[6])
				->setCellValue($i, $m_KWH_TOT[7])
				->setCellValue($j, $m_KWH_TOT[8])
				->setCellValue($k, $m_KWH_TOT[9])
				->setCellValue($l, $m_KWH_TOT[10])
				->setCellValue($m, $m_KWH_TOT[11])
				->setCellValue($n, $m_KWH_TOT[12])
				->setCellValue($o, $m_KWH_TOT[13])
				->setCellValue($p, $m_KWH_TOT[14])
				->setCellValue($q, $m_KWH_TOT[15])
				->setCellValue($r, $m_KWH_TOT[16])
				->setCellValue($s, $m_KWH_TOT[17])
				->setCellValue($t, $m_KWH_TOT[18])
				->setCellValue($u, $m_KWH_TOT[19])
				->setCellValue($v, $m_KWH_TOT[20])
				->setCellValue($w, $m_KWH_TOT[21])
				->setCellValue($x, $m_KWH_TOT[22])
				->setCellValue($y, $m_KWH_TOT[23])
				->setCellValue($z, $KWH_SUMMARY_TOT)
				->setCellValue($aa, '100')
				;				

	//設置底色
	$objPHPExcel->getActiveSheet()->getStyle($a.':'.$aa)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$objPHPExcel->getActiveSheet()->getStyle($a.':'.$aa)->getFill()->getStartColor()->setRGB('FFDC00');

	//設置邊框線及顏色			
	$objPHPExcel->getActiveSheet()->getStyle($a.':'.$aa)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	$objPHPExcel->getActiveSheet()->getStyle($a.':'.$aa)->getBorders()->getAllBorders()->getColor()->setRGB('000000');

	//設置水平置中
	$objPHPExcel->getActiveSheet()->getStyle($a.':'.$aa)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	
	//設置垂直置上
	$objPHPExcel->getActiveSheet()->getStyle($a.':'.$aa)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

	$objPHPExcel->getActiveSheet()->getStyle($a.':'.$aa)->getFont()->setBold(true);			

	$objPHPExcel->getActiveSheet()->getRowDimension($line)->setRowHeight(30);

	
}

$mDB2->remove();
$mDB->remove();




//Set page orientation and size 方向大小
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);



// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle("分電表用電日報表(".$current_year."年".$current_month."月".$current_day."日)");


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


$xlsx_filename = "分電表用電日報表(".$current_year."年".$current_month."月".$current_day."日).xls";

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
