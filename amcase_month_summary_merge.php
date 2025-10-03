<?php

//error_reporting(E_ALL); 
//ini_set('display_errors', '1');

require_once '/website/os/Mobile-Detect-2.8.34/Mobile_Detect.php';
$detect = new Mobile_Detect;

if (!($detect->isMobile() && !$detect->isTablet())) {
	$isMobile = "0";
} else {
	$isMobile = "1";
}


$m_location		= "/website/smarty/templates/".$site_db."/".$templates;
$m_pub_modal	= "/website/smarty/templates/".$site_db."/pub_modal";

function number_format2($num,$dec) {
	if ($num <> 0)
		if ($num > 0) {
			$retval = number_format($num,$dec);
		} else {
			$retval = "_";
		}
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
$case_id = $_GET['case_id'];

$current_year = $_GET['current_year'];
if (!isset($_GET['current_year']))
	$current_year = date('Y');

$current_month = $_GET['current_month'];
if (!isset($_GET['current_month']))
	$current_month = date('m');

$m_period = $current_year."年".$current_month."月";



$mDB = "";
$mDB = new MywebDB();

$mDB2 = "";
$mDB2 = new MywebDB();


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
ORDER BY a.orderby
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




//echo "KWH_SUMMARY_TOT:".$KWH_SUMMARY_TOT."<br>";
//exit;


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
ORDER BY a.orderby
";

$mDB->query($Qry);

$m_KWH_TOT = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);

if ($mDB->rowCount() > 0) {

	//顯示抬頭標題列
$show_analysis.=<<<EOT
	<table class="table table-bordered">
		<thead>
			<tr class="text-center">
				<th scope="col" class="size14 bg-aqua text-nowrap weight" style="padding: 10px 0;width:120px;">合併節點</th>
				<th scope="col" class="size14 bg-aqua" style="padding: 10px 0;width:30px;"><b>1日</b></th>
				<th scope="col" class="size14 bg-aqua" style="padding: 10px 0;width:30px;"><b>2日</b></th>
				<th scope="col" class="size14 bg-aqua" style="padding: 10px 0;width:30px;"><b>3日</b></th>
				<th scope="col" class="size14 bg-aqua" style="padding: 10px 0;width:30px;"><b>4日</b></th>
				<th scope="col" class="size14 bg-aqua" style="padding: 10px 0;width:30px;"><b>5日</b></th>
				<th scope="col" class="size14 bg-aqua" style="padding: 10px 0;width:30px;"><b>6日</b></th>
				<th scope="col" class="size14 bg-aqua" style="padding: 10px 0;width:30px;"><b>7日</b></th>
				<th scope="col" class="size14 bg-aqua" style="padding: 10px 0;width:30px;"><b>8日</b></th>
				<th scope="col" class="size14 bg-aqua" style="padding: 10px 0;width:30px;"><b>9日</b></th>
				<th scope="col" class="size14 bg-aqua" style="padding: 10px 0;width:30px;"><b>10日</b></th>
				<th scope="col" class="size14 bg-aqua" style="padding: 10px 0;width:30px;"><b>11日</b></th>
				<th scope="col" class="size14 bg-aqua" style="padding: 10px 0;width:30px;"><b>12日</b></th>
				<th scope="col" class="size14 bg-aqua" style="padding: 10px 0;width:30px;"><b>13日</b></th>
				<th scope="col" class="size14 bg-aqua" style="padding: 10px 0;width:30px;"><b>14日</b></th>
				<th scope="col" class="size14 bg-aqua" style="padding: 10px 0;width:30px;"><b>15日</b></th>
				<th scope="col" class="size14 bg-aqua" style="padding: 10px 0;width:30px;"><b>16日</b></th>
				<th scope="col" class="size14 bg-aqua" style="padding: 10px 0;width:30px;"><b>17日</b></th>
				<th scope="col" class="size14 bg-aqua" style="padding: 10px 0;width:30px;"><b>18日</b></th>
				<th scope="col" class="size14 bg-aqua" style="padding: 10px 0;width:30px;"><b>19日</b></th>
				<th scope="col" class="size14 bg-aqua" style="padding: 10px 0;width:30px;"><b>20日</b></th>
				<th scope="col" class="size14 bg-aqua" style="padding: 10px 0;width:30px;"><b>21日</b></th>
				<th scope="col" class="size14 bg-aqua" style="padding: 10px 0;width:30px;"><b>22日</b></th>
				<th scope="col" class="size14 bg-aqua" style="padding: 10px 0;width:30px;"><b>23日</b></th>
				<th scope="col" class="size14 bg-aqua" style="padding: 10px 0;width:30px;"><b>24日</b></th>
				<th scope="col" class="size14 bg-aqua" style="padding: 10px 0;width:30px;"><b>25日</b></th>
				<th scope="col" class="size14 bg-aqua" style="padding: 10px 0;width:30px;"><b>26日</b></th>
				<th scope="col" class="size14 bg-aqua" style="padding: 10px 0;width:30px;"><b>27日</b></th>
				<th scope="col" class="size14 bg-aqua" style="padding: 10px 0;width:30px;"><b>28日</b></th>
				<th scope="col" class="size14 bg-aqua" style="padding: 10px 0;width:30px;"><b>29日</b></th>
				<th scope="col" class="size14 bg-aqua" style="padding: 10px 0;width:30px;"><b>30日</b></th>
				<th scope="col" class="size14 bg-aqua" style="padding: 10px 0;width:30px;"><b>31日</b></th>
				<th scope="col" class="size14 bg-yellow" style="padding: 10px 0;width:60px;"><b>合計</b></th>
				<th scope="col" class="size14 bg-yellow" style="padding: 10px 0;width:50px;"><b>佔比%</b></th>
			</tr>
		</thead>
		<tbody>
EOT;

	$merge_node = '';

	$m_KWH = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);

	$KWH_SUMMARY = 0;

	$seq_no = 0;

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
				$seq_no++;

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

$show_analysis.=<<<EOT
			<tr class="text-center">
			<th scope="row" class="text-left text-nowrap">({$seq_no}). {$merge_node}</th>
				<td>$m_KWH[0]</td>
				<td>$m_KWH[1]</td>
				<td>$m_KWH[2]</td>
				<td>$m_KWH[3]</td>
				<td>$m_KWH[4]</td>
				<td>$m_KWH[5]</td>
				<td>$m_KWH[6]</td>
				<td>$m_KWH[7]</td>
				<td>$m_KWH[8]</td>
				<td>$m_KWH[9]</td>
				<td>$m_KWH[10]</td>
				<td>$m_KWH[11]</td>
				<td>$m_KWH[12]</td>
				<td>$m_KWH[13]</td>
				<td>$m_KWH[14]</td>
				<td>$m_KWH[15]</td>
				<td>$m_KWH[16]</td>
				<td>$m_KWH[17]</td>
				<td>$m_KWH[18]</td>
				<td>$m_KWH[19]</td>
				<td>$m_KWH[20]</td>
				<td>$m_KWH[21]</td>
				<td>$m_KWH[22]</td>
				<td>$m_KWH[23]</td>
				<td>$m_KWH[24]</td>
				<td>$m_KWH[25]</td>
				<td>$m_KWH[26]</td>
				<td>$m_KWH[27]</td>
				<td>$m_KWH[28]</td>
				<td>$m_KWH[29]</td>
				<td>$m_KWH[30]</td>
				<td class="weight">$fmt_KWH_SUMMARY</td>
				<td class="weight">$KWH_SUMMARY_PERCENT</td>
			</tr>
EOT;		

				$m_KWH = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
				$KWH_SUMMARY = 0;

			}

		}

	}


	$fmt_KWH_SUMMARY_TOT = number_format2($KWH_SUMMARY_TOT,4);


	//顯示全部總和
$show_analysis.=<<<EOT
   <tr class="text-center bg-yellow size14 weight" style="border-top: 2px solid #000;">
	   <th scope="row" class="text-nowrap text-center">全部總和</th>
	   <td>$m_KWH_TOT[0]</td>
	   <td>$m_KWH_TOT[1]</td>
	   <td>$m_KWH_TOT[2]</td>
	   <td>$m_KWH_TOT[3]</td>
	   <td>$m_KWH_TOT[4]</td>
	   <td>$m_KWH_TOT[5]</td>
	   <td>$m_KWH_TOT[6]</td>
	   <td>$m_KWH_TOT[7]</td>
	   <td>$m_KWH_TOT[8]</td>
	   <td>$m_KWH_TOT[9]</td>
	   <td>$m_KWH_TOT[10]</td>
	   <td>$m_KWH_TOT[11]</td>
	   <td>$m_KWH_TOT[12]</td>
	   <td>$m_KWH_TOT[13]</td>
	   <td>$m_KWH_TOT[14]</td>
	   <td>$m_KWH_TOT[15]</td>
	   <td>$m_KWH_TOT[16]</td>
	   <td>$m_KWH_TOT[17]</td>
	   <td>$m_KWH_TOT[18]</td>
	   <td>$m_KWH_TOT[19]</td>
	   <td>$m_KWH_TOT[20]</td>
	   <td>$m_KWH_TOT[21]</td>
	   <td>$m_KWH_TOT[22]</td>
	   <td>$m_KWH_TOT[23]</td>
	   <td>$m_KWH_TOT[24]</td>
	   <td>$m_KWH_TOT[25]</td>
	   <td>$m_KWH_TOT[26]</td>
	   <td>$m_KWH_TOT[27]</td>
	   <td>$m_KWH_TOT[28]</td>
	   <td>$m_KWH_TOT[29]</td>
	   <td>$m_KWH_TOT[30]</td>
	   <td>$fmt_KWH_SUMMARY_TOT</td>
	   <td>100</td>
   </tr>
EOT;



$show_analysis.=<<<EOT
		</tbody>
	</table>
EOT;


}


$mDB2->remove();
$mDB->remove();



/*



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
*/

//$series_data_kwh = json_encode($alist_kwh);


$mess_title = "分電表用電月報表";


$show_top_tools=<<<EOT
	<div class="mytable" style="width:100%;background-color:#fff;padding: 20px 10px 0 10px;opacity: 0.9;">
		<div class="myrow">
			<div class="mycell" style="width:20%;padding: 10px;vertical-align: bottom;">
				<a role="button" class="btn btn-light float-left " href="/index.php?case_id=$case_id&fm=analysis2"><i class="bi bi-chevron-left"></i>&nbsp;回上頁</a>
			</div>
			<div class="mycell weight" style="width:60%;padding: 10px 5px;text-align:center;">
				<h3>$mess_title</h3>
			</div>
			<div class="mycell" style="width:20%;text-align:right;padding: 10px;vertical-align: bottom;">
			</div>
		</div>
	</div>
	<hr class="half-rule" style="margin: 0;padding:0;border-color:$panel_bgcolor;">
EOT;



if (!($detect->isMobile() || $detect->isTablet())) {

$show_report=<<<EOT
$show_top_tools
<div class="mytable" style="width:100%;background-color:#fff;">
	<div class="myrow size14" style="width:100%;">
		<div class="mycell text-left;" style="width:33%;padding: 35px 0 5px 50px;vertical-align: bottom;">
		</div>
		<div class="mycell text-center" style="width:34%;padding: 35px 0 5px 0;vertical-align: bottom;">
			請選擇年月份 : $m_year
			&nbsp;&nbsp;&nbsp;&nbsp;
			<a role="button" class="btn btn-primary" href="/index.php?ch=amcase_month_summary_excel&site_db=$site_db&case_id=$case_id&current_year=$current_year&current_month=$current_month&fm=$fm"><i class="fas fa-file-export"></i>&nbsp;匯出Excel檔</a>
		</div>
		<div class="mycell text-right" style="width:33%;padding: 35px 50px 5px 0;vertical-align: bottom;">
			單位 : KWH
		</div>
	</div>
</div>
<div class="mytable" style="width:100%;background-color:#fff;">
	<div class="myrow" style="width:100%;">
		<div class="mycell" style="width:100%;min-height:500px;margin: 0 auto;padding:10px 40px 70px 40px;">
			$show_analysis
			<!--
			<div id="combination_container"></div>
			<div id="combination_container2"></div>
			-->
		</div>
	</div>
</div>
EOT;

} else {

$show_report=<<<EOT
<div style="width:100%;">
	$show_top_tools
	<div class="mytable" style="width:100%;background-color:#fff;">
		<div class="myrow size14" style="width:100%;">
		<div class="myrow size14" style="width:100%;">
			<div class="mycell text-center" style="width:100%;padding: 10px 10px 0 10px;vertical-align: bottom;">
				請選擇年月份 : $m_year
			</div>
		</div>
		<div class="myrow size14" style="width:100%;">
			<div class="mycell text-center" style="width:100%;padding: 10px 10px 0 10px;vertical-align: bottom;">
				單位 : KWH
			</div>
		</div>
	</div>
	<div style="width:100%;max-width:1600px;min-height:500px;margin: 0 auto;padding:10px;background-color:#fff;">
		<div style="width:100%;overflow-x: auto;">
			<div style="width:100%;min-width:1400px;">
				$show_analysis
				<!--
				<div id="combination_container"></div>
				<div id="combination_container2"></div>
				-->
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