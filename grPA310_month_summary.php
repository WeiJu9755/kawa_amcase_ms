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
$ch = $_GET['ch'];
$current_year = $_GET['current_year'];
if (!isset($_GET['current_year']))
	$current_year = date('Y');

$current_month = $_GET['current_month'];
if (!isset($_GET['current_month']))
	$current_month = date('m');

	
$case_id = "c1";


$m_period = $current_year."年".$current_month."月";


$mDB = "";
$mDB = new MywebDB();


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
$m_OFF_PEAK_KW = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
$m_DEMAND_KW = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);

$m_PEAK_KWH = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
$m_HALF_PEAK_KWH = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
$m_OFF_PEAK_KWH = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
$m_KWH = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);


$rowCount = $mDB->rowCount();
if ($rowCount > 0) {
    while ($PA310_row=$mDB->fetchRow(2)) {
		
		$current_day = $PA310_row['dm_day'];

		$DEMAND_KW = round($PA310_row['DEMAND_KW'],0);
		$PEAK_KW = $PA310_row['PEAK_KW'];
		$HALF_PEAK_KW = $PA310_row['HALF_PEAK_KW'];
		$OFF_PEAK_KW = $PA310_row['OFF_PEAK_KW'];
		$PEAK_KWH = $PA310_row['PEAK_KWH'];
		$HALF_PEAK_KWH = $PA310_row['HALF_PEAK_KWH'];
		$OFF_PEAK_KWH = $PA310_row['OFF_PEAK_KWH'];
		$KWH = $PA310_row['KWH'];
		$PF = $PA310_row['PF'];

		$m_data[] = array(
			$current_day
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


		$m_PEAK_KW[$current_day-1] = round($PEAK_KW,2);
		$m_HALF_PEAK_KW[$current_day-1] = round($HALF_PEAK_KW,2);
		$m_OFF_PEAK_KW[$current_day-1] = round($OFF_PEAK_KW,2);
		$m_DEMAND_KW[$current_day-1] = round($DEMAND_KW,2);

		$m_PEAK_KWH[$current_day-1] = round($PEAK_KWH,2);
		$m_HALF_PEAK_KWH[$current_day-1] = round($HALF_PEAK_KWH,2);
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
				<th scope="col" class="size14 bg-silver" style="padding: 10px 0;width:120px;"><b>項目名稱/日期</b></th>
				<th scope="col" class="size14 bg-silver" style="padding: 10px 0;width:40px;"><b>1</b></th>
				<th scope="col" class="size14 bg-silver" style="padding: 10px 0;width:40px;"><b>2</b></th>
				<th scope="col" class="size14 bg-silver" style="padding: 10px 0;width:40px;"><b>3</b></th>
				<th scope="col" class="size14 bg-silver" style="padding: 10px 0;width:40px;"><b>4</b></th>
				<th scope="col" class="size14 bg-silver" style="padding: 10px 0;width:40px;"><b>5</b></th>
				<th scope="col" class="size14 bg-silver" style="padding: 10px 0;width:40px;"><b>6</b></th>
				<th scope="col" class="size14 bg-silver" style="padding: 10px 0;width:40px;"><b>7</b></th>
				<th scope="col" class="size14 bg-silver" style="padding: 10px 0;width:40px;"><b>8</b></th>
				<th scope="col" class="size14 bg-silver" style="padding: 10px 0;width:40px;"><b>9</b></th>
				<th scope="col" class="size14 bg-silver" style="padding: 10px 0;width:40px;"><b>10</b></th>
				<th scope="col" class="size14 bg-silver" style="padding: 10px 0;width:40px;"><b>11</b></th>
				<th scope="col" class="size14 bg-silver" style="padding: 10px 0;width:40px;"><b>12</b></th>
				<th scope="col" class="size14 bg-silver" style="padding: 10px 0;width:40px;"><b>13</b></th>
				<th scope="col" class="size14 bg-silver" style="padding: 10px 0;width:40px;"><b>14</b></th>
				<th scope="col" class="size14 bg-silver" style="padding: 10px 0;width:40px;"><b>15</b></th>
				<th scope="col" class="size14 bg-silver" style="padding: 10px 0;width:40px;"><b>16</b></th>
				<th scope="col" class="size14 bg-silver" style="padding: 10px 0;width:40px;"><b>17</b></th>
				<th scope="col" class="size14 bg-silver" style="padding: 10px 0;width:40px;"><b>18</b></th>
				<th scope="col" class="size14 bg-silver" style="padding: 10px 0;width:40px;"><b>19</b></th>
				<th scope="col" class="size14 bg-silver" style="padding: 10px 0;width:40px;"><b>20</b></th>
				<th scope="col" class="size14 bg-silver" style="padding: 10px 0;width:40px;"><b>21</b></th>
				<th scope="col" class="size14 bg-silver" style="padding: 10px 0;width:40px;"><b>22</b></th>
				<th scope="col" class="size14 bg-silver" style="padding: 10px 0;width:40px;"><b>23</b></th>
				<th scope="col" class="size14 bg-silver" style="padding: 10px 0;width:40px;"><b>24</b></th>
				<th scope="col" class="size14 bg-silver" style="padding: 10px 0;width:40px;"><b>25</b></th>
				<th scope="col" class="size14 bg-silver" style="padding: 10px 0;width:40px;"><b>26</b></th>
				<th scope="col" class="size14 bg-silver" style="padding: 10px 0;width:40px;"><b>27</b></th>
				<th scope="col" class="size14 bg-silver" style="padding: 10px 0;width:40px;"><b>28</b></th>
				<th scope="col" class="size14 bg-silver" style="padding: 10px 0;width:40px;"><b>29</b></th>
				<th scope="col" class="size14 bg-silver" style="padding: 10px 0;width:40px;"><b>30</b></th>
				<th scope="col" class="size14 bg-silver" style="padding: 10px 0;width:40px;"><b>31</b></th>
				<th scope="col" class="size14 bg-aqua" style="padding: 10px 0;width:60px;"><b>合計</b></th>
				<th scope="col" class="size14 bg-aqua" style="padding: 10px 0;width:50px;"><b>%</b></th>
			</tr>
		</thead>
		<tbody>
			<tr  class="text-center" style="background-color: #FFDBDB;">
				<th scope="row" class="text-nowrap text-right" style="vertical-align: middle;">經常契約(kW)</th>
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
				<td>$DEMAND_KW_13</td>
				<td>$DEMAND_KW_14</td>
				<td>$DEMAND_KW_15</td>
				<td>$DEMAND_KW_16</td>
				<td>$DEMAND_KW_17</td>
				<td>$DEMAND_KW_18</td>
				<td>$DEMAND_KW_19</td>
				<td>$DEMAND_KW_20</td>
				<td>$DEMAND_KW_21</td>
				<td>$DEMAND_KW_22</td>
				<td>$DEMAND_KW_23</td>
				<td>$DEMAND_KW_24</td>
				<td>$DEMAND_KW_25</td>
				<td>$DEMAND_KW_26</td>
				<td>$DEMAND_KW_27</td>
				<td>$DEMAND_KW_28</td>
				<td>$DEMAND_KW_29</td>
				<td>$DEMAND_KW_30</td>
				<td>$DEMAND_KW_31</td>
				<td></td>
				<td>100%</td>
			</tr>
EOT;


//PEAK_KW   經常最高需量(kW)
$show_analysis.=<<<EOT
			<tr class="text-center">
				<th scope="row" class="text-nowrap text-right">經常最高需量(kW)</th>
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
				<td>$PEAK_KW_13</td>
				<td>$PEAK_KW_14</td>
				<td>$PEAK_KW_15</td>
				<td>$PEAK_KW_16</td>
				<td>$PEAK_KW_17</td>
				<td>$PEAK_KW_18</td>
				<td>$PEAK_KW_19</td>
				<td>$PEAK_KW_20</td>
				<td>$PEAK_KW_21</td>
				<td>$PEAK_KW_22</td>
				<td>$PEAK_KW_23</td>
				<td>$PEAK_KW_24</td>
				<td>$PEAK_KW_25</td>
				<td>$PEAK_KW_26</td>
				<td>$PEAK_KW_27</td>
				<td>$PEAK_KW_28</td>
				<td>$PEAK_KW_29</td>
				<td>$PEAK_KW_30</td>
				<td>$PEAK_KW_31</td>
				<td>$PEAK_KW_MAX</td>
				<td>$PEAK_KW_PERCENT</td>
			</tr>
EOT;

//HALF_PEAK_KW   半尖峰需量(kW)
$show_analysis.=<<<EOT
			<tr class="text-center">
				<th scope="row" class="text-nowrap text-right">半尖峰需量(kW)</th>
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
				<td>$HALF_PEAK_KW_13</td>
				<td>$HALF_PEAK_KW_14</td>
				<td>$HALF_PEAK_KW_15</td>
				<td>$HALF_PEAK_KW_16</td>
				<td>$HALF_PEAK_KW_17</td>
				<td>$HALF_PEAK_KW_18</td>
				<td>$HALF_PEAK_KW_19</td>
				<td>$HALF_PEAK_KW_20</td>
				<td>$HALF_PEAK_KW_21</td>
				<td>$HALF_PEAK_KW_22</td>
				<td>$HALF_PEAK_KW_23</td>
				<td>$HALF_PEAK_KW_24</td>
				<td>$HALF_PEAK_KW_25</td>
				<td>$HALF_PEAK_KW_26</td>
				<td>$HALF_PEAK_KW_27</td>
				<td>$HALF_PEAK_KW_28</td>
				<td>$HALF_PEAK_KW_29</td>
				<td>$HALF_PEAK_KW_30</td>
				<td>$HALF_PEAK_KW_31</td>
				<td>$HALF_PEAK_KW_MAX</td>
				<td>$HALF_PEAK_KW_PERCENT</td>
			</tr>
EOT;

//OFF_PEAK_KW   離峰需量(kW)
$show_analysis.=<<<EOT
			<tr class="text-center">
				<th scope="row" class="text-nowrap text-right">離峰需量(kW)</th>
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
				<td>$OFF_PEAK_KW_13</td>
				<td>$OFF_PEAK_KW_14</td>
				<td>$OFF_PEAK_KW_15</td>
				<td>$OFF_PEAK_KW_16</td>
				<td>$OFF_PEAK_KW_17</td>
				<td>$OFF_PEAK_KW_18</td>
				<td>$OFF_PEAK_KW_19</td>
				<td>$OFF_PEAK_KW_20</td>
				<td>$OFF_PEAK_KW_21</td>
				<td>$OFF_PEAK_KW_22</td>
				<td>$OFF_PEAK_KW_23</td>
				<td>$OFF_PEAK_KW_24</td>
				<td>$OFF_PEAK_KW_25</td>
				<td>$OFF_PEAK_KW_26</td>
				<td>$OFF_PEAK_KW_27</td>
				<td>$OFF_PEAK_KW_28</td>
				<td>$OFF_PEAK_KW_29</td>
				<td>$OFF_PEAK_KW_30</td>
				<td>$OFF_PEAK_KW_31</td>
				<td>$OFF_PEAK_KW_MAX</td>
				<td>$OFF_PEAK_KW_PERCENT</td>
			</tr>
EOT;



//PEAK_KWH   經常(尖峰)度數(kWh)
$show_analysis.=<<<EOT
			<tr class="text-center">
				<th scope="row" class="text-nowrap text-right">經常(尖峰)度數(kWh)</th>
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
				<td>$PEAK_KWH_13</td>
				<td>$PEAK_KWH_14</td>
				<td>$PEAK_KWH_15</td>
				<td>$PEAK_KWH_16</td>
				<td>$PEAK_KWH_17</td>
				<td>$PEAK_KWH_18</td>
				<td>$PEAK_KWH_19</td>
				<td>$PEAK_KWH_20</td>
				<td>$PEAK_KWH_21</td>
				<td>$PEAK_KWH_22</td>
				<td>$PEAK_KWH_23</td>
				<td>$PEAK_KWH_24</td>
				<td>$PEAK_KWH_25</td>
				<td>$PEAK_KWH_26</td>
				<td>$PEAK_KWH_27</td>
				<td>$PEAK_KWH_28</td>
				<td>$PEAK_KWH_29</td>
				<td>$PEAK_KWH_30</td>
				<td>$PEAK_KWH_31</td>
				<td>$PEAK_KWH_TOTAL</td>
				<td>$PEAK_KWH_PERCENT</td>
			</tr>
EOT;

//HALF_PEAK_KWH   半尖峰度數(kWh)
$show_analysis.=<<<EOT
			<tr class="text-center">
				<th scope="row" class="text-nowrap text-right">半尖峰度數(kWh)</th>
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
				<td>$HALF_PEAK_KWH_13</td>
				<td>$HALF_PEAK_KWH_14</td>
				<td>$HALF_PEAK_KWH_15</td>
				<td>$HALF_PEAK_KWH_16</td>
				<td>$HALF_PEAK_KWH_17</td>
				<td>$HALF_PEAK_KWH_18</td>
				<td>$HALF_PEAK_KWH_19</td>
				<td>$HALF_PEAK_KWH_20</td>
				<td>$HALF_PEAK_KWH_21</td>
				<td>$HALF_PEAK_KWH_22</td>
				<td>$HALF_PEAK_KWH_23</td>
				<td>$HALF_PEAK_KWH_24</td>
				<td>$HALF_PEAK_KWH_25</td>
				<td>$HALF_PEAK_KWH_26</td>
				<td>$HALF_PEAK_KWH_27</td>
				<td>$HALF_PEAK_KWH_28</td>
				<td>$HALF_PEAK_KWH_29</td>
				<td>$HALF_PEAK_KWH_30</td>
				<td>$HALF_PEAK_KWH_31</td>
				<td>$HALF_PEAK_KWH_TOTAL</td>
				<td>$HALF_PEAK_KWH_PERCENT</td>
			</tr>
EOT;

//OFF_PEAK_KWH   離峰度數(kWh)
$show_analysis.=<<<EOT
			<tr class="text-center">
				<th scope="row" class="text-nowrap text-right">離峰度數(kWh)</th>
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
				<td>$OFF_PEAK_KWH_13</td>
				<td>$OFF_PEAK_KWH_14</td>
				<td>$OFF_PEAK_KWH_15</td>
				<td>$OFF_PEAK_KWH_16</td>
				<td>$OFF_PEAK_KWH_17</td>
				<td>$OFF_PEAK_KWH_18</td>
				<td>$OFF_PEAK_KWH_19</td>
				<td>$OFF_PEAK_KWH_20</td>
				<td>$OFF_PEAK_KWH_21</td>
				<td>$OFF_PEAK_KWH_22</td>
				<td>$OFF_PEAK_KWH_23</td>
				<td>$OFF_PEAK_KWH_24</td>
				<td>$OFF_PEAK_KWH_25</td>
				<td>$OFF_PEAK_KWH_26</td>
				<td>$OFF_PEAK_KWH_27</td>
				<td>$OFF_PEAK_KWH_28</td>
				<td>$OFF_PEAK_KWH_29</td>
				<td>$OFF_PEAK_KWH_30</td>
				<td>$OFF_PEAK_KWH_31</td>
				<td>$OFF_PEAK_KWH_TOTAL</td>
				<td>$OFF_PEAK_KWH_PERCENT</td>
			</tr>
EOT;

//KWH  總用電度數(KWh)
$show_analysis.=<<<EOT
			<tr class="text-center size14 weight" style="background-color: #C9FFB7;">
				<th scope="row" class="text-nowrap text-right">總用電度數(kWh)</th>
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
				<td>$KWH_13</td>
				<td>$KWH_14</td>
				<td>$KWH_15</td>
				<td>$KWH_16</td>
				<td>$KWH_17</td>
				<td>$KWH_18</td>
				<td>$KWH_19</td>
				<td>$KWH_20</td>
				<td>$KWH_21</td>
				<td>$KWH_22</td>
				<td>$KWH_23</td>
				<td>$KWH_24</td>
				<td>$KWH_25</td>
				<td>$KWH_26</td>
				<td>$KWH_27</td>
				<td>$KWH_28</td>
				<td>$KWH_29</td>
				<td>$KWH_30</td>
				<td>$KWH_31</td>
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
				<td>$PF_13</td>
				<td>$PF_14</td>
				<td>$PF_15</td>
				<td>$PF_16</td>
				<td>$PF_17</td>
				<td>$PF_18</td>
				<td>$PF_19</td>
				<td>$PF_20</td>
				<td>$PF_21</td>
				<td>$PF_22</td>
				<td>$PF_23</td>
				<td>$PF_24</td>
				<td>$PF_25</td>
				<td>$PF_26</td>
				<td>$PF_27</td>
				<td>$PF_28</td>
				<td>$PF_29</td>
				<td>$PF_30</td>
				<td>$PF_31</td>
				<td></td>
				<td></td>
			</tr>
EOT;



$show_analysis.=<<<EOT
		</tbody>
	</table>
EOT;








$alist_kw = array();

//經常最高需量(kW)
$s_data = array();
$bool = false;
for ($i = 31; $i >= 0; $i--) {
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
	$s_data = array('','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0);

$alist_kw[]=array(
	"type"=>"column"
	,"name"=>"經常最高需量(kW)"
	,"data"=>array_reverse($s_data)

);


//半尖峰需量(kW)
$s_data = array();
$bool = false;
for ($i = 31; $i >= 0; $i--) {
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
	$s_data = array('','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0);

$alist_kw[]=array(
	"type"=>"column"
	,"name"=>"半尖峰需量(kW)"
	,"data"=>array_reverse($s_data)
);


//離峰需量(kW)
$s_data = array();
$bool = false;
for ($i = 31; $i >= 0; $i--) {
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
	$s_data = array('','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0);

$alist_kw[]=array(
	"type"=>"column"
	,"name"=>"離峰需量(kW)"
	,"data"=>array_reverse($s_data)
);


//經常契約(kW)
$s_data = array();
$bool = false;
for ($i = 31; $i >= 0; $i--) {
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
	$s_data = array('','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0);

$alist_kw[]=array(
	"type"=>"spline"
	,"name"=>"經常契約(kW)"
	,"data"=>array_reverse($s_data)
	,"marker"=>array(
		"lineWidth"=> 2,
		"lineColor"=>"#000000",
		"fillColor"=>"white"
	)
	
);



$series_data_kw = json_encode($alist_kw);



$alist_kwh = array();

//經常(尖峰)度數(kWh)
$s_data = array();
$bool = false;
for ($i = 31; $i >= 0; $i--) {
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
	$s_data = array('','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0);

$alist_kwh[]=array(
	"type"=>"column"
	,"name"=>"經常(尖峰)度數(kWh)"
	,"data"=>array_reverse($s_data)

);


//半尖峰度數(kWh)
$s_data = array();
$bool = false;
for ($i = 31; $i >= 0; $i--) {
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
	$s_data = array('','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0);

$alist_kwh[]=array(
	"type"=>"column"
	,"name"=>"半尖峰度數(kWh)"
	,"data"=>array_reverse($s_data)
);


//離峰度數(kWh)
$s_data = array();
$bool = false;
for ($i = 31; $i >= 0; $i--) {
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
	$s_data = array('','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0);

$alist_kwh[]=array(
	"type"=>"column"
	,"name"=>"離峰度數(kWh)"
	,"data"=>array_reverse($s_data)
);


//總用電度數(kWh)
$s_data = array();
$bool = false;
for ($i = 31; $i >= 0; $i--) {
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
	$s_data = array('','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0);

$alist_kwh[]=array(
	"type"=>"spline"
	,"name"=>"總用電度數(kWh)"
	,"data"=>array_reverse($s_data)
	,"marker"=>array(
		"lineWidth"=> 2,
		"lineColor"=>"#000000",
		"fillColor"=>"white"
	)
	
);



$series_data_kwh = json_encode($alist_kwh);



if (!empty($t)) {
	$mess_title = $t;
} else {
	
	if (!($detect->isMobile() || $detect->isTablet()))
		$t = $mess_title;
}


$show_close_btn = "<span style=\"float:right;\"><a href=\"javascript:history.go(-1);\">$goback</a></span>";


//現在日期時間
//$today = date('Y-m-d H:i:s');


$Title_01 = getlang("每月用電總量分析表");
$Title_02 = getlang("請選擇用電年度月份");

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
			text: '月份各日用電需量'
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
		  enableMouseWheelZoom: true
		},
		xAxis: {
			categories: ['1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31'],
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
			text: '月份各日用電量'
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
		  enableMouseWheelZoom: true
		},
		xAxis: {
			categories: ['1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31'],
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