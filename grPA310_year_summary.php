<?php

//error_reporting(E_ALL); 
//ini_set('display_errors', '1');


require_once '/website/os/Mobile-Detect-2.8.34/Mobile_Detect.php';
$detect = new Mobile_Detect;


$m_location		= "/website/smarty/templates/".$site_db."/".$templates;
$m_pub_modal	= "/website/smarty/templates/".$site_db."/pub_modal";

function number_format2($num,$dec) {
	if ($num <> 0)
		$retval = number_format($num,$dec);
	else 
		$retval = "_";
		
	return $retval;
}

function percent2($num) {
	if ($num <> 0)
		//if ($num >= 100)
		//	$retval = "100%";
		//else
			$retval = $num;
	else 
		$retval = "_";
		
	return $retval;
}


//載入公用函數
@include_once '/website/include/pub_function.php';

@include_once("/website/class/".$site_db."_info_class.php");



$fm = $_GET['fm'];
$current_year = $_GET['current_year'];
if (!isset($_GET['current_year']))
	$current_year = date('Y');

$case_id = "c1";


$mylang = $_COOKIE["lang"];

if ($mylang == "en_US") {
	$m_period = $current_year." year";
} else {
	$m_period = "$First ".$current_year." $theyear";
}




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


$mDB = "";
$mDB = new MywebDB();


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
$m_OFF_PEAK_KW = array(0,0,0,0,0,0,0,0,0,0,0,0);
$m_DEMAND_KW = array(0,0,0,0,0,0,0,0,0,0,0,0);

$m_PEAK_KWH = array(0,0,0,0,0,0,0,0,0,0,0,0);
$m_HALF_PEAK_KWH = array(0,0,0,0,0,0,0,0,0,0,0,0);
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
		$OFF_PEAK_KW = $PA310_row['OFF_PEAK_KW'];
		$PEAK_KWH = $PA310_row['PEAK_KWH'];
		$HALF_PEAK_KWH = $PA310_row['HALF_PEAK_KWH'];
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
			,$OFF_PEAK_KW
			,$PEAK_KWH
			,$HALF_PEAK_KWH
			,$OFF_PEAK_KWH
			,$KWH
			,$PF
		);


		$m_PEAK_KW[$current_month-1] = round($PEAK_KW,2);
		$m_HALF_PEAK_KW[$current_month-1] = round($HALF_PEAK_KW,2);
		$m_OFF_PEAK_KW[$current_month-1] = round($OFF_PEAK_KW,2);
		$m_DEMAND_KW[$current_month-1] = round($DEMAND_KW,2);

		$m_PEAK_KWH[$current_month-1] = round($PEAK_KWH,2);
		$m_HALF_PEAK_KWH[$current_month-1] = round($HALF_PEAK_KWH,2);
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
		$$START_DATE = "_";

		$END_DATE = "END_DATE"."_".$i;
		$$END_DATE = "_";

		$DEMAND_KW = "DEMAND_KW"."_".$i;
		$$DEMAND_KW = "_";

		$PEAK_KW = "PEAK_KW"."_".$i;
		$$PEAK_KW = "_";

		$HALF_PEAK_KW = "HALF_PEAK_KW"."_".$i;
		$$HALF_PEAK_KW = "_";

		$OFF_PEAK_KW = "OFF_PEAK_KW"."_".$i;
		$$OFF_PEAK_KW = "_";

		$PEAK_KWH = "PEAK_KWH"."_".$i;
		$$PEAK_KWH = "_";

		$HALF_PEAK_KWH = "HALF_PEAK_KWH"."_".$i;
		$$HALF_PEAK_KWH = "_";

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
	$OFF_PEAK_KW_MAX = 0;
	$PEAK_KWH_TOTAL = 0;
	$HALF_PEAK_KWH_TOTAL = 0;
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
	$OFF_PEAK_KW_MAX = number_format2($OFF_PEAK_KW_MAX,2);
	$PEAK_KWH_TOTAL = number_format2($PEAK_KWH_TOTAL,2);
	$HALF_PEAK_KWH_TOTAL = number_format2($HALF_PEAK_KWH_TOTAL,2);
	$OFF_PEAK_KWH_TOTAL = number_format2($OFF_PEAK_KWH_TOTAL,2);
	$KWH_TOTAL = number_format2($KWH_TOTAL,2);


	$PEAK_KW_PERCENT = ""; if ($DEMAND_KW_MAX > 0) $PEAK_KW_PERCENT = round($PEAK_KW_MAX/$DEMAND_KW_MAX*100,1)."%";
	$HALF_PEAK_KW_PERCENT = ""; if ($DEMAND_KW_MAX > 0) $HALF_PEAK_KW_PERCENT = round($HALF_PEAK_KW_MAX/$DEMAND_KW_MAX*100,1)."%";
	$OFF_PEAK_KW_PERCENT = ""; if ($DEMAND_KW_MAX > 0) $OFF_PEAK_KW_PERCENT = round($OFF_PEAK_KW_MAX/$DEMAND_KW_MAX*100,1)."%";
	$PEAK_KWH_PERCENT = ""; if ($KWH_TOTAL > 0) $PEAK_KWH_PERCENT = round($PEAK_KWH_TOTAL/$KWH_TOTAL*100,1)."%";
	$HALF_PEAK_KWH_PERCENT = ""; if ($KWH_TOTAL > 0) $HALF_PEAK_KWH_PERCENT = round($HALF_PEAK_KWH_TOTAL/$KWH_TOTAL*100,1)."%";
	$OFF_PEAK_KWH_PERCENT = ""; if ($KWH_TOTAL > 0) $OFF_PEAK_KWH_PERCENT = round($OFF_PEAK_KWH_TOTAL/$KWH_TOTAL*100,1)."%";
	$KWH_PERCENT = "100%";


}


$show_analysis.=<<<EOT
	<table class="table table-bordered">
		<thead>
			<tr class="text-center">
				<th scope="col" class="size14 bg-silver" style="padding: 10px 0;width:120px;"><b>項目名稱/月份</b></th>
				<th scope="col" class="size14 bg-silver" style="padding: 10px 0;width:60px;"><b>1月</b></th>
				<th scope="col" class="size14 bg-silver" style="padding: 10px 0;width:60px;"><b>2月</b></th>
				<th scope="col" class="size14 bg-silver" style="padding: 10px 0;width:60px;"><b>3月</b></th>
				<th scope="col" class="size14 bg-silver" style="padding: 10px 0;width:60px;"><b>4月</b></th>
				<th scope="col" class="size14 bg-silver" style="padding: 10px 0;width:60px;"><b>5月</b></th>
				<th scope="col" class="size14 bg-red white" style="padding: 10px 0;width:60px;"><b>6月</b></th>
				<th scope="col" class="size14 bg-red white" style="padding: 10px 0;width:60px;"><b>7月</b></th>
				<th scope="col" class="size14 bg-red white" style="padding: 10px 0;width:60px;"><b>8月</b></th>
				<th scope="col" class="size14 bg-red white" style="padding: 10px 0;width:60px;"><b>9月</b></th>
				<th scope="col" class="size14 bg-silver" style="padding: 10px 0;width:60px;"><b>10月</b></th>
				<th scope="col" class="size14 bg-silver" style="padding: 10px 0;width:60px;"><b>11月</b></th>
				<th scope="col" class="size14 bg-silver" style="padding: 10px 0;width:60px;"><b>12月</b></th>
				<th scope="col" class="size14 bg-aqua" style="padding: 10px 0;width:70px;"><b>合計</b></th>
				<th scope="col" class="size14 bg-aqua" style="padding: 10px 0;width:50px;"><b>%</b></th>
			</tr>
		</thead>
		<tbody>
			<tr class="text-center">
				<th scope="row" class="text-nowrap text-right" style="vertical-align: middle;">計費起始日</th>
				<td>$START_DATE_1</td>
				<td>$START_DATE_2</td>
				<td>$START_DATE_3</td>
				<td>$START_DATE_4</td>
				<td>$START_DATE_5</td>
				<td>$START_DATE_6</td>
				<td>$START_DATE_7</td>
				<td>$START_DATE_8</td>
				<td>$START_DATE_9</td>
				<td>$START_DATE_10</td>
				<td>$START_DATE_11</td>
				<td>$START_DATE_12</td>
				<td></td>
				<td></td>
			</tr>
			<tr class="text-center">
				<th scope="row" class="text-nowrap text-right" style="vertical-align: middle;">計費迄止日</th>
				<td>$END_DATE_1</td>
				<td>$END_DATE_2</td>
				<td>$END_DATE_3</td>
				<td>$END_DATE_4</td>
				<td>$END_DATE_5</td>
				<td>$END_DATE_6</td>
				<td>$END_DATE_7</td>
				<td>$END_DATE_8</td>
				<td>$END_DATE_9</td>
				<td>$END_DATE_10</td>
				<td>$END_DATE_11</td>
				<td>$END_DATE_12</td>
				<td></td>
				<td></td>
			</tr>
			<tr  class="text-center" style="background-color: #FFDBDB;">
				<th scope="row" class="text-nowrap text-right" style="vertical-align: middle;">經常契約(KW)</th>
				<td>$DEMAND_KW_1</td>
				<td>$DEMAND_KW_2</td>
				<td>$DEMAND_KW_3</td>
				<td>$DEMAND_KW_4</td>
				<td>$DEMAND_KW_5</td>
				<td>$DEMAND_KW_6</td>
				<td>$DEMAND_KW_7</td>
				<td>$DEMAND_KW_8</td>
				<td>$DEMAND_KW_9</td>
				<td>$DEMAND_KW_10</td>
				<td>$DEMAND_KW_11</td>
				<td>$DEMAND_KW_12</td>
				<td></td>
				<td>100%</td>
			</tr>
EOT;


//PEAK_KW   經常最高需量(KW)
$show_analysis.=<<<EOT
			<tr class="text-center">
				<th scope="row" class="text-nowrap text-right">經常最高需量(KW)</th>
				<td>$PEAK_KW_1</td>
				<td>$PEAK_KW_2</td>
				<td>$PEAK_KW_3</td>
				<td>$PEAK_KW_4</td>
				<td>$PEAK_KW_5</td>
				<td>$PEAK_KW_6</td>
				<td>$PEAK_KW_7</td>
				<td>$PEAK_KW_8</td>
				<td>$PEAK_KW_9</td>
				<td>$PEAK_KW_10</td>
				<td>$PEAK_KW_11</td>
				<td>$PEAK_KW_12</td>
				<td>$PEAK_KW_MAX</td>
				<td>$PEAK_KW_PERCENT</td>
			</tr>
EOT;

//HALF_PEAK_KW   半尖峰需量(KW)
$show_analysis.=<<<EOT
			<tr class="text-center">
				<th scope="row" class="text-nowrap text-right">半尖峰需量(KW)</th>
				<td>$HALF_PEAK_KW_1</td>
				<td>$HALF_PEAK_KW_2</td>
				<td>$HALF_PEAK_KW_3</td>
				<td>$HALF_PEAK_KW_4</td>
				<td>$HALF_PEAK_KW_5</td>
				<td>$HALF_PEAK_KW_6</td>
				<td>$HALF_PEAK_KW_7</td>
				<td>$HALF_PEAK_KW_8</td>
				<td>$HALF_PEAK_KW_9</td>
				<td>$HALF_PEAK_KW_10</td>
				<td>$HALF_PEAK_KW_11</td>
				<td>$HALF_PEAK_KW_12</td>
				<td>$HALF_PEAK_KW_MAX</td>
				<td>$HALF_PEAK_KW_PERCENT</td>
			</tr>
EOT;

//OFF_PEAK_KW   離峰需量(KW)
$show_analysis.=<<<EOT
			<tr class="text-center">
				<th scope="row" class="text-nowrap text-right">離峰需量(KW)</th>
				<td>$OFF_PEAK_KW_1</td>
				<td>$OFF_PEAK_KW_2</td>
				<td>$OFF_PEAK_KW_3</td>
				<td>$OFF_PEAK_KW_4</td>
				<td>$OFF_PEAK_KW_5</td>
				<td>$OFF_PEAK_KW_6</td>
				<td>$OFF_PEAK_KW_7</td>
				<td>$OFF_PEAK_KW_8</td>
				<td>$OFF_PEAK_KW_9</td>
				<td>$OFF_PEAK_KW_10</td>
				<td>$OFF_PEAK_KW_11</td>
				<td>$OFF_PEAK_KW_12</td>
				<td>$OFF_PEAK_KW_MAX</td>
				<td>$OFF_PEAK_KW_PERCENT</td>
			</tr>
EOT;



//PEAK_KWH   經常(尖峰)度數(KWh)
$show_analysis.=<<<EOT
			<tr class="text-center">
				<th scope="row" class="text-nowrap text-right">經常(尖峰)度數(KWh)</th>
				<td>$PEAK_KWH_1</td>
				<td>$PEAK_KWH_2</td>
				<td>$PEAK_KWH_3</td>
				<td>$PEAK_KWH_4</td>
				<td>$PEAK_KWH_5</td>
				<td>$PEAK_KWH_6</td>
				<td>$PEAK_KWH_7</td>
				<td>$PEAK_KWH_8</td>
				<td>$PEAK_KWH_9</td>
				<td>$PEAK_KWH_10</td>
				<td>$PEAK_KWH_11</td>
				<td>$PEAK_KWH_12</td>
				<td>$PEAK_KWH_TOTAL</td>
				<td>$PEAK_KWH_PERCENT</td>
			</tr>
EOT;

//HALF_PEAK_KWH   半尖峰度數(KWh)
$show_analysis.=<<<EOT
			<tr class="text-center">
				<th scope="row" class="text-nowrap text-right">半尖峰度數(KWh)</th>
				<td>$HALF_PEAK_KWH_1</td>
				<td>$HALF_PEAK_KWH_2</td>
				<td>$HALF_PEAK_KWH_3</td>
				<td>$HALF_PEAK_KWH_4</td>
				<td>$HALF_PEAK_KWH_5</td>
				<td>$HALF_PEAK_KWH_6</td>
				<td>$HALF_PEAK_KWH_7</td>
				<td>$HALF_PEAK_KWH_8</td>
				<td>$HALF_PEAK_KWH_9</td>
				<td>$HALF_PEAK_KWH_10</td>
				<td>$HALF_PEAK_KWH_11</td>
				<td>$HALF_PEAK_KWH_12</td>
				<td>$HALF_PEAK_KWH_TOTAL</td>
				<td>$HALF_PEAK_KWH_PERCENT</td>
			</tr>
EOT;

//OFF_PEAK_KWH   離峰度數(KWh)
$show_analysis.=<<<EOT
			<tr class="text-center">
				<th scope="row" class="text-nowrap text-right">離峰度數(KWh)</th>
				<td>$OFF_PEAK_KWH_1</td>
				<td>$OFF_PEAK_KWH_2</td>
				<td>$OFF_PEAK_KWH_3</td>
				<td>$OFF_PEAK_KWH_4</td>
				<td>$OFF_PEAK_KWH_5</td>
				<td>$OFF_PEAK_KWH_6</td>
				<td>$OFF_PEAK_KWH_7</td>
				<td>$OFF_PEAK_KWH_8</td>
				<td>$OFF_PEAK_KWH_9</td>
				<td>$OFF_PEAK_KWH_10</td>
				<td>$OFF_PEAK_KWH_11</td>
				<td>$OFF_PEAK_KWH_12</td>
				<td>$OFF_PEAK_KWH_TOTAL</td>
				<td>$OFF_PEAK_KWH_PERCENT</td>
			</tr>
EOT;

//KWH  總用電度數(KWh)
$show_analysis.=<<<EOT
			<tr class="text-center size14 weight" style="background-color: #C9FFB7;">
				<th scope="row" class="text-nowrap text-right">總用電度數(KWh)</th>
				<td>$KWH_1</td>
				<td>$KWH_2</td>
				<td>$KWH_3</td>
				<td>$KWH_4</td>
				<td>$KWH_5</td>
				<td>$KWH_6</td>
				<td>$KWH_7</td>
				<td>$KWH_8</td>
				<td>$KWH_9</td>
				<td>$KWH_10</td>
				<td>$KWH_11</td>
				<td>$KWH_12</td>
				<td>$KWH_TOTAL</td>
				<td>$KWH_PERCENT</td>
			</tr>
EOT;

//PF  功率因數(%)
$show_analysis.=<<<EOT
			<tr class="text-center">
				<th scope="row" class="text-nowrap text-right">功率因數(%)</th>
				<td>$PF_1</td>
				<td>$PF_2</td>
				<td>$PF_3</td>
				<td>$PF_4</td>
				<td>$PF_5</td>
				<td>$PF_6</td>
				<td>$PF_7</td>
				<td>$PF_8</td>
				<td>$PF_9</td>
				<td>$PF_10</td>
				<td>$PF_11</td>
				<td>$PF_12</td>
				<td></td>
				<td></td>
			</tr>
EOT;



$show_analysis.=<<<EOT
		</tbody>
	</table>
EOT;








$alist_kw = array();

//經常最高需量(KW)
$s_data = array();
$bool = false;
for ($i = 11; $i >= 0; $i--) {
	if ($m_PEAK_KW[$i] == 0) {
		if ($bool == true)
			$s_data[] = 0;
		else
			$s_data[] = "";
	} else {
		$s_data[] = $m_PEAK_KW[$i];
		$bool = true;
	}
}
if (!$bool)
	$s_data = array('','','','','','','','','','','',0);

$alist_kw[]=array(
	"type"=>"column"
	,"name"=>"經常最高需量(KW)"
	,"data"=>array_reverse($s_data)

);


//半尖峰需量(KW)
$s_data = array();
$bool = false;
for ($i = 11; $i >= 0; $i--) {
	if ($m_HALF_PEAK_KW[$i] == 0) {
		if ($bool == true)
			$s_data[] = 0;
		else
			$s_data[] = "";
	} else {
		$s_data[] = $m_HALF_PEAK_KW[$i];
		$bool = true;
	}
}
if (!$bool)
	$s_data = array('','','','','','','','','','','',0);

$alist_kw[]=array(
	"type"=>"column"
	,"name"=>"半尖峰需量(KW)"
	,"data"=>array_reverse($s_data)
);


//離峰需量(KW)
$s_data = array();
$bool = false;
for ($i = 11; $i >= 0; $i--) {
	if ($m_OFF_PEAK_KW[$i] == 0) {
		if ($bool == true)
			$s_data[] = 0;
		else
			$s_data[] = "";
	} else {
		$s_data[] = $m_OFF_PEAK_KW[$i];
		$bool = true;
	}
}
if (!$bool)
	$s_data = array('','','','','','','','','','','',0);

$alist_kw[]=array(
	"type"=>"column"
	,"name"=>"離峰需量(KW)"
	,"data"=>array_reverse($s_data)
);


//經常契約(KW)
$s_data = array();
$bool = false;
for ($i = 11; $i >= 0; $i--) {
	if ($m_DEMAND_KW[$i] == 0) {
		if ($bool == true)
			$s_data[] = 0;
		else
			$s_data[] = "";
	} else {
		$s_data[] = $m_DEMAND_KW[$i];
		$bool = true;
	}
}
if (!$bool)
	$s_data = array('','','','','','','','','','','',0);

$alist_kw[]=array(
	"type"=>"spline"
	,"name"=>"經常契約(KW)"
	,"data"=>array_reverse($s_data)
	,"marker"=>array(
		"lineWidth"=> 2,
		"lineColor"=>"#000000",
		"fillColor"=>"white"
	)
	
);



$series_data_kw = json_encode($alist_kw);



$alist_kwh = array();

//經常(尖峰)度數(KWh)
$s_data = array();
$bool = false;
for ($i = 11; $i >= 0; $i--) {
	if ($m_PEAK_KWH[$i] == 0) {
		if ($bool == true)
			$s_data[] = 0;
		else
			$s_data[] = "";
	} else {
		$s_data[] = $m_PEAK_KWH[$i];
		$bool = true;
	}
}
if (!$bool)
	$s_data = array('','','','','','','','','','','',0);

$alist_kwh[]=array(
	"type"=>"column"
	,"name"=>"經常(尖峰)度數(KWh)"
	,"data"=>array_reverse($s_data)

);


//半尖峰度數(KWh)
$s_data = array();
$bool = false;
for ($i = 11; $i >= 0; $i--) {
	if ($m_HALF_PEAK_KWH[$i] == 0) {
		if ($bool == true)
			$s_data[] = 0;
		else
			$s_data[] = "";
	} else {
		$s_data[] = $m_HALF_PEAK_KWH[$i];
		$bool = true;
	}
}
if (!$bool)
	$s_data = array('','','','','','','','','','','',0);

$alist_kwh[]=array(
	"type"=>"column"
	,"name"=>"半尖峰度數(KWh)"
	,"data"=>array_reverse($s_data)
);


//離峰度數(KWh)
$s_data = array();
$bool = false;
for ($i = 11; $i >= 0; $i--) {
	if ($m_OFF_PEAK_KWH[$i] == 0) {
		if ($bool == true)
			$s_data[] = 0;
		else
			$s_data[] = "";
	} else {
		$s_data[] = $m_OFF_PEAK_KWH[$i];
		$bool = true;
	}
}
if (!$bool)
	$s_data = array('','','','','','','','','','','',0);

$alist_kwh[]=array(
	"type"=>"column"
	,"name"=>"離峰度數(KWh)"
	,"data"=>array_reverse($s_data)
);


//總用電度數(KWh)
$s_data = array();
$bool = false;
for ($i = 11; $i >= 0; $i--) {
	if ($m_KWH[$i] == 0) {
		if ($bool == true)
			$s_data[] = 0;
		else
			$s_data[] = "";
	} else {
		$s_data[] = $m_KWH[$i];
		$bool = true;
	}
}
if (!$bool)
	$s_data = array('','','','','','','','','','','',0);

$alist_kwh[]=array(
	"type"=>"spline"
	,"name"=>"總用電度數(KWh)"
	,"data"=>array_reverse($s_data)
	,"marker"=>array(
		"lineWidth"=> 2,
		"lineColor"=>"#000000",
		"fillColor"=>"white"
	)
	
);



$series_data_kwh = json_encode($alist_kwh);



//現在日期時間
//$today = date('Y-m-d H:i:s');


$Title_01 = getlang("年度用電總量分析表");
$Title_02 = getlang("請選擇用電年度");

$Close = getlang("關閉");
$Print = getlang("列印");


if (!($detect->isMobile() || $detect->isTablet())) {

$show_report=<<<EOT
<div class="w-auto" style="position:fixed;top: 10px; right:10px;z-index: 9999;">
	<button id="close" class="btn btn-danger p-2 px-3" type="button" onclick="window.close();"><i class="bi bi-power"></i>&nbsp;關閉</button>
</div>
<h3 class="weight text-center p-3">$Title_01</h3>
<hr class="half-rule" style="margin: 0;padding:0;border-color:$panel_bgcolor;">
<div class="mytable" style="width:100%;background-color:#fff;padding: 0 10px;">
	<div class="myrow">
		<div class="mycell" style="width:100%;padding: 0;vertical-align: bottom;">
			<div style="width:auto;min-height:500px;margin: 0 auto;padding:20px;">
				<div class="text-nowrap" style="width:300px;text-align:center;margin: 20px auto;">$Title_02 : $m_year</div>
				<div style="float:right;width:150px;text-align:right;padding: 5px 20px 5px 0;margin:-40px 0 20px 0;"></div>
				<div style="width:100%;">
					$show_analysis
					<div id="combination_container"></div>
					<div id="combination_container2"></div>
				</div>
			</div>
		</div>
	</div>
</div>
EOT;
	
} else {

$show_report=<<<EOT
<div style="width:100%;">
	<div class="w-auto" style="position:fixed;top: 10px; right:10px;z-index: 9999;">
		<button id="close" class="btn btn-danger p-2 px-3" type="button" onclick="window.close();"><i class="bi bi-power"></i>&nbsp;關閉</button>
	</div>
	<h3 class="weight text-left p-3">$Title_01</h3>
	<hr class="half-rule" style="margin: 0;padding:0;border-color:$panel_bgcolor;">
	<div style="width:100%;max-width:1600px;min-height:500px;margin: 0 auto;padding:20px;background-color:#fff;">
		<div class="text-nowrap" style="width:300px;text-align:center;margin: 20px auto;">$Title_02 : $m_year</div>
		<div style="float:right;width:150px;text-align:right;padding: 5px 20px 5px 0;margin:-40px 0 20px 0;"></div>
		<div style="width:100%;overflow-x: auto;">
			<div style="width:100%;min-width:1400px;">
				$show_analysis
				<div id="combination_container"></div>
				<div id="combination_container2"></div>
			</div>
		</div>
	</div>
</div>
EOT;
	
}
	

$show_center=<<<EOT
<script src="/js/highstock.js"></script>
<script src="/js/highcharts-more.js"></script>

<script src="/js/map.js"></script>



<style>

.card-default > .card-header-custom {
	background:$panel_bgcolor; color:$panel_fontcolor;
}

table.table-bordered {
	border:1px solid black;
}
table.table-bordered > thead > tr > th{
	border:1px solid black;
}
table.table-bordered > tbody > tr > th {
	border:1px solid black;
}
table.table-bordered > tbody > tr > td {
	border:1px solid black;
}


#combination_container {
	width: 100%;
	padding: 0 20px;
	height: 500px;
	margin: 50px auto;
}

#combination_container2 {
	width: 100%;
	padding: 0 20px;
	height: 500px;
	margin: 50px auto;
}

</style>

$show_report

<script>

    $(function(){
      // bind change event to select
      $('#period_list').bind('change', function () {
          var url = $(this).val(); // get selected value
          if (url) { // require a URL
              window.location = url; // redirect
          }
          return false;
      });
    });
	
	
	var series_data_kw = JSON.parse('$series_data_kw');

	Highcharts.chart('combination_container', {
		title: {
			text: '年度各月用電需量'
		},
		legend: {
			enabled: true
		},
		yAxis: {
			title: {
				text: '<span class="font_a size12 weight">KW</span>'
			}
		},
		mapNavigation: {
		  enableMouseWheelZoom: false
		},
		xAxis: {
			categories: ['$Jan', '$Feb', '$Mar', '$Apr', '$May', '$Jun',  '$Jul', '$Aug', '$Sep', '$Oct', '$Nov', '$Dec'],
			events: {
			afterSetExtremes: function() {
			  var extr = this.getExtremes();
			  if (extr.min === extr.dataMin && extr.max === extr.dataMax) {
				$('.highcharts-scrollbar').hide();
			  } else {
				$('.highcharts-scrollbar').show();
			  }
			}
		  }
		},
		credits: {
			enabled: false
		},
		series: series_data_kw
		,responsive: {
			rules: [{
				condition: {
					maxWidth: 500
				},
				chartOptions: {
					legend: {
						layout: 'horizontal',
						align: 'center',
						verticalAlign: 'bottom'
					}
				}
			}]
		}
	
	});	
		

	var series_data_kwh = JSON.parse('$series_data_kwh');

	Highcharts.chart('combination_container2', {
		title: {
			text: '年度各月用電量'
		},
		legend: {
			enabled: true
		},
		yAxis: {
			title: {
				text: '<span class="font_a size12 weight">KWh</span>'
			}
		},
		mapNavigation: {
		  enableMouseWheelZoom: false
		},
		xAxis: {
			categories: ['$Jan', '$Feb', '$Mar', '$Apr', '$May', '$Jun',  '$Jul', '$Aug', '$Sep', '$Oct', '$Nov', '$Dec'],
			events: {
			afterSetExtremes: function() {
			  var extr = this.getExtremes();
			  if (extr.min === extr.dataMin && extr.max === extr.dataMax) {
				$('.highcharts-scrollbar').hide();
			  } else {
				$('.highcharts-scrollbar').show();
			  }
			}
		  }
		},
		credits: {
			enabled: false
		},
		series: series_data_kwh
		,responsive: {
			rules: [{
				condition: {
					maxWidth: 500
				},
				chartOptions: {
					legend: {
						layout: 'horizontal',
						align: 'center',
						verticalAlign: 'bottom'
					}
				}
			}]
		}
	
	});	
			

</script>
EOT;



?>