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

$current_date = $_GET['current_date'];
if (!isset($_GET['current_date']))
	$current_date = date('Y-m-d');



$report_date = $current_date;
	
$am_year = date('Y', strtotime($current_date));
$am_month = date('m', strtotime($current_date));
$am_day = date('d', strtotime($current_date));
$am_hour = date('H', strtotime($current_date));
$am_minutes = date('i', strtotime($current_date));
//$am_second = date('s', strtotime($current_date));
	


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
			AND am_year = '$am_year' AND am_month = '$am_month' AND am_day = '$am_day'
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

//echo "KWH_SUMMARY_TOT:".$KWH_SUMMARY_TOT."<br>";
//exit;


$show_analysis = "";


//先取得量測節點
$Qry="SELECT * FROM ammeter_node
WHERE case_id = '$case_id' AND `enabled` = 'Y' AND main_meter = 'N'
ORDER BY orderby";
$mDB->query($Qry);

$m_KWH_TOT = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);

if ($mDB->rowCount() > 0) {

	//顯示抬頭標題列
$show_analysis.=<<<EOT
	<table class="table table-bordered">
		<thead>
			<tr class="text-center">
				<th scope="col" class="size14 bg-aqua text-nowrap" style="padding: 10px 0;width:120px;"><b>設備名稱/小時</b></th>
				<th scope="col" class="size14 bg-aqua" style="padding: 10px 0;width:30px;"><b>0</b></th>
				<th scope="col" class="size14 bg-aqua" style="padding: 10px 0;width:30px;"><b>1</b></th>
				<th scope="col" class="size14 bg-aqua" style="padding: 10px 0;width:30px;"><b>2</b></th>
				<th scope="col" class="size14 bg-aqua" style="padding: 10px 0;width:30px;"><b>3</b></th>
				<th scope="col" class="size14 bg-aqua" style="padding: 10px 0;width:30px;"><b>4</b></th>
				<th scope="col" class="size14 bg-aqua" style="padding: 10px 0;width:30px;"><b>5</b></th>
				<th scope="col" class="size14 bg-aqua" style="padding: 10px 0;width:30px;"><b>6</b></th>
				<th scope="col" class="size14 bg-aqua" style="padding: 10px 0;width:30px;"><b>7</b></th>
				<th scope="col" class="size14 bg-aqua" style="padding: 10px 0;width:30px;"><b>8</b></th>
				<th scope="col" class="size14 bg-aqua" style="padding: 10px 0;width:30px;"><b>9</b></th>
				<th scope="col" class="size14 bg-aqua" style="padding: 10px 0;width:30px;"><b>10</b></th>
				<th scope="col" class="size14 bg-aqua" style="padding: 10px 0;width:30px;"><b>11</b></th>
				<th scope="col" class="size14 bg-aqua" style="padding: 10px 0;width:30px;"><b>12</b></th>
				<th scope="col" class="size14 bg-aqua" style="padding: 10px 0;width:30px;"><b>13</b></th>
				<th scope="col" class="size14 bg-aqua" style="padding: 10px 0;width:30px;"><b>14</b></th>
				<th scope="col" class="size14 bg-aqua" style="padding: 10px 0;width:30px;"><b>15</b></th>
				<th scope="col" class="size14 bg-aqua" style="padding: 10px 0;width:30px;"><b>16</b></th>
				<th scope="col" class="size14 bg-aqua" style="padding: 10px 0;width:30px;"><b>17</b></th>
				<th scope="col" class="size14 bg-aqua" style="padding: 10px 0;width:30px;"><b>18</b></th>
				<th scope="col" class="size14 bg-aqua" style="padding: 10px 0;width:30px;"><b>19</b></th>
				<th scope="col" class="size14 bg-aqua" style="padding: 10px 0;width:30px;"><b>20</b></th>
				<th scope="col" class="size14 bg-aqua" style="padding: 10px 0;width:30px;"><b>21</b></th>
				<th scope="col" class="size14 bg-aqua" style="padding: 10px 0;width:30px;"><b>22</b></th>
				<th scope="col" class="size14 bg-aqua" style="padding: 10px 0;width:30px;"><b>23</b></th>
				<th scope="col" class="size14 bg-yellow" style="padding: 10px 0;width:60px;"><b>合計</b></th>
				<th scope="col" class="size14 bg-yellow" style="padding: 10px 0;width:50px;"><b>佔比%</b></th>
			</tr>
		</thead>
		<tbody>
EOT;

	$seq = 0;
	while ($row=$mDB->fetchRow(2)) {
		$seq++;
		$case_id = $row['case_id'];
		$router_id = $row['router_id'];
		$ammeter_id = $row['ammeter_id'];
		$node_no = $row['node_no'];
		$phase = $row['phase'];
		$description = $row['description'];

		//再取得各 node 的用電 KWH 數值
		$Qry2="SELECT * FROM ammeter_node_kwh_hour
			WHERE case_id = '$case_id' AND router_id = '$router_id' AND ammeter_id = '$ammeter_id'
			AND am_year = '$am_year' AND am_month = '$am_month' AND am_day = '$am_day'
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

		for ($i = 0; $i <= 23; $i++) {
			$m_KWH[$i] = number_format2($m_KWH[$i],4);
			$m_KWH_TOT[$i] = number_format2($m_KWH_TOT[$i],4);
		}

		$fmt_KWH_SUMMARY = number_format2($KWH_SUMMARY,4);

		//計算百分佔比
		$KWH_SUMMARY_PERCENT = 0;
		if ($KWH_SUMMARY_TOT <> 0)
			$KWH_SUMMARY_PERCENT = round(($KWH_SUMMARY/$KWH_SUMMARY_TOT)*100,4);

		$fmt_KWH_SUMMARY_TOT = number_format2($KWH_SUMMARY_TOT,4);

$show_analysis.=<<<EOT
			<tr class="text-center">
			<th scope="row" class="text-left text-nowrap">$seq. $description</th>
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
				<td class="weight">$fmt_KWH_SUMMARY</td>
				<td class="weight">$KWH_SUMMARY_PERCENT</td>
			</tr>
EOT;		

			
		

	}


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


$mess_title = "分電表用電日報表";


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
			<div class="mytable field_container3 size12" style="width:100%;">
				<div class="myrow">
					<div class="mycell weight" style="width: auto;padding:3px 7px 0 0;text-align:right;">請選擇用電日期 : </div> 
					<div class="mycell">
						<form method="post" id="modifyForm" name="modifyForm" enctype="multipart/form-data" action="javascript:void(null);">
						<div class="input-group date" id="get_date" style="width:420px;">
							<input type="text" class="form-control" id="report_date" name="report_date" value="$report_date" style="color:#000;" />
							<span class="input-group-addon input-group-text">
								<i class="far fa-calendar-alt"></i>
							</span>
							<button class="btn btn-success" type="button" onclick="chdatetime(this.form);" style="padding: 5px 10px;margin:0 10px 0 5px;"><i class="fas fa-check"></i>&nbsp;變更</button>
							&nbsp;&nbsp;&nbsp;&nbsp;
							<a role="button" class="btn btn-primary" href="/index.php?ch=amcase_day_summary_excel&site_db=$site_db&case_id=$case_id&current_year=$am_year&current_month=$am_month&current_day=$am_day&fm=$fm"><i class="fas fa-file-export"></i>&nbsp;匯出Excel檔</a>
						</div>
						<script type="text/javascript">
							$(function () {
								$('#get_date').datetimepicker({
									locale: 'zh-tw'
									,format:"YYYY-MM-DD"
									,allowInputToggle: true
								});
							});
						</script>
						</form>
					</div> 
				</div>
			</div>
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
			<div class="mycell text-center" style="width:100%;padding: 10px 10px 0 10px;vertical-align: bottom;">
				<div class="mytable field_container3" style="width:100%;">
					<div class="myrow">
						<div class="mycell" style="width: auto;padding:5px 0;">請選擇用電日期 : </div> 
					</div>
					<div class="myrow">
						<div class="mycell">
							<form method="post" id="modifyForm" name="modifyForm" enctype="multipart/form-data" action="javascript:void(null);">
							<div class="input-group date w-100" id="get_date">
								<input type="text" class="form-control" id="report_date" name="report_date" value="$report_date" style="color:#000;" />
								<span class="input-group-addon input-group-text">
									<i class="far fa-calendar-alt"></i>
								</span>
								<button class="btn btn-success" type="button" onclick="chdatetime(this.form);" style="padding: 5px 10px;margin:0 10px 0 5px;"><i class="fas fa-check"></i>&nbsp;變更</button>
							</div>
							<script type="text/javascript">
								$(function () {
									$('#get_date').datetimepicker({
										locale: 'zh-tw'
										,format:"YYYY-MM-DD"
										,allowInputToggle: true
									});
								});
							</script>
							</form>
						</div> 
					</div>
				</div>
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
	

	function chdatetime(thisform) {
		var mdate = $('#report_date').val();
		window.location = '/index.php?ch=$ch&current_date='+mdate+'&case_id=$case_id&t=用電日報表&fm=$fm';
		return false;
	}	
	
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