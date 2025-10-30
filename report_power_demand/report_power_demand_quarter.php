<?php

require_once '/website/os/Mobile-Detect-2.8.34/Mobile_Detect.php';
$detect = new Mobile_Detect;


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





include_once("/website/class/".$site_db."_info_class.php");


$mDB = "";
$mDB = new MywebDB();


$cate_data = array();
$m_MAX_KW = array();
for ($i = 0; $i <= 96; $i++) {

	$cate_data[] = $i;
	$m_MAX_KW[] = 0;
}

$series_data_cate_data = json_encode($cate_data);


$show_analysis = "";

$Qry="SELECT seq,dm_year,dm_month,dm_day,dm_hour,dm_minutes,ROUND(MAX(AVG_KW),2) AS MAX_KW
FROM grPA310_KW_quarter
WHERE case_id = '$case_id' ".$date_query_str."
GROUP BY case_id,dm_year,dm_month,dm_day,dm_hour,dm_minutes
ORDER BY auto_seq DESC LIMIT 0,96";

$mDB->query($Qry);


$QUARTER_TOTAL_KW = 0;
$QUARTER_TOTAL_KW_PERCENT = 0;

$QUARTER_KW_alist = array();
$QUARTER_KW_data = array();
$QUARTER_KW_data2 = array();

//$PAGE_QUARTER_MAX_KW = $limit_kw;
$PAGE_QUARTER_MAX_KW = 0;



$rowCount = $mDB->rowCount();
if ($rowCount > 0) {


$show_analysis.=<<<EOT
<table class="table table-bordered">
	<thead>
		<tr class="text-center">
			<th scope="col" class="size14 bg-silver text-nowrap" style="padding: 10px 0;width:40px;"><b>電表序號</b></th>
			<th scope="col" class="size14 bg-silver text-nowrap" style="padding: 10px 0;width:30px;"><b>年</b></th>
			<th scope="col" class="size14 bg-silver text-nowrap" style="padding: 10px 0;width:30px;"><b>月</b></th>
			<th scope="col" class="size14 bg-silver text-nowrap" style="padding: 10px 0;width:30px;"><b>日</b></th>
			<th scope="col" class="size14 bg-silver text-nowrap" style="padding: 10px 0;width:30px;"><b>時</b></th>
			<th scope="col" class="size14 bg-silver text-nowrap" style="padding: 10px 0;width:30px;"><b>15分鐘</b></th>
			<th scope="col" class="size14 bg-silver text-nowrap" style="padding: 10px 0;width:100px;"><b>平均需量 KW</b></th>
		</tr>
	</thead>
	<tbody>
EOT;

	$KW_i = 0;

    while ($PA310_row=$mDB->fetchRow(2)) {
		
		$seq = $PA310_row['seq'];
		$dm_year = $PA310_row['dm_year'];
		$dm_month = $PA310_row['dm_month'];
		$dm_day = $PA310_row['dm_day'];
		$dm_hour = $PA310_row['dm_hour'];
		$dm_minutes = $PA310_row['dm_minutes'];

		$MAX_KW = $PA310_row['MAX_KW'];

		$m_MAX_KW[$dm_hour] = (float)$MAX_KW;

$show_analysis.=<<<EOT
		<tr class="text-center">
			<th scope="row">$seq</th>
			<td>$dm_year</td>
			<td>$dm_month</td>
			<td>$dm_day</td>
			<td>$dm_hour</td>
			<td>$dm_minutes</td>
			<td>$MAX_KW</td>
		</tr>
EOT;


		$KW_i++;

		$TOTAL_KW = round((float)$PA310_row['MAX_KW'],2);

		/*
		if ($KW_i == 1) {
			$QUARTER_TOTAL_KW = $TOTAL_KW;
			if ($max_kw <> 0)
				$QUARTER_TOTAL_KW_PERCENT = round($TOTAL_KW/$max_kw*100,1)."%";
		}
			*/

		//$rec_datetime = $PA310_row['rec_datetime'];
		$dm_hour = str_pad($PA310_row['dm_hour'],2,'0',STR_PAD_LEFT);
		$dm_minutes = str_pad($PA310_row['dm_minutes'],2,'0',STR_PAD_LEFT);

		$QUARTER_KW_data[] = array($dm_hour.":".$dm_minutes,$TOTAL_KW);
		$QUARTER_KW_data2[] = array($dm_hour.":".$dm_minutes);

		if ($PAGE_QUARTER_MAX_KW < $TOTAL_KW) {
			$PAGE_QUARTER_MAX_KW = $TOTAL_KW;
			if ($max_kw <> 0)
				$QUARTER_TOTAL_KW_PERCENT = round($PAGE_QUARTER_MAX_KW/$max_kw*100,1)."%";
		}


	}

$show_analysis.=<<<EOT
	</tbody>
</table>
EOT;


}


$mDB->remove();



$QUARTER_KW_alist[]=array(
	"type"=>"line"
	,"name"=>"KW"
	,"data"=>array_reverse($QUARTER_KW_data)
	,"zones"=>array(
		array(
			"value"=>0,
			"color"=>'#f7a35c'
		),
		array(
			"value"=>$base_kw,
			"color"=>'#0080FF'
		),
		array(
			"value"=>$max_kw,
			"color"=>'#FFBF00'
		),
		array(
			"color"=>'#ff0000'
		)
	)
);





$series_QUARTER_KW_alist = json_encode($QUARTER_KW_alist);
$categories_QUARTER_KW_data = json_encode(array_reverse($QUARTER_KW_data2));




/*
$alist_hour = array();


$s_data = array();
$bool = false;
for ($i = 24; $i >= 0; $i--) {
	if ($m_MAX_KW[$i] == 0) {
		if ($bool == true)
			$s_data[] = 0;
		else
			$s_data[] = "";
	} else {
		$s_data[] = $m_MAX_KW[$i];
		$bool = true;
	}
}
if (!$bool) {
	for ($i = 0; $i <= 23; $i++) {
		if ($i == 23) {
			$s_data[] = 0;
		} else {
			$s_data[] = "";
		}
	}
}

$alist_hour[]=array(
	"type"=>"line"
	,"name"=>"平均需量 KW"
	,"data"=>array_reverse($s_data)
);


$series_data_alist_hour = json_encode($alist_hour);

*/



if (!empty($t)) {
	$mess_title = $t;
} else {
	
	if (!($detect->isMobile() || $detect->isTablet()))
		$t = $mess_title;
}


$show_close_btn = "<span style=\"float:right;\"><a href=\"javascript:history.go(-1);\">$goback</a></span>";



$thisurl = "/?ch=grPA310_day_summary&fm=$fm";


$show_filter=<<<EOT
			<form method="get" id="inqueryForm" name="inqueryForm" enctype="multipart/form-data" action="javascript:void(null);">
			<div class="container-fluid text-center" style="width:100%;padding: 10px;">
				<div class="row h-100">
				<div class="col-xs-12 col-md-6 text-right" style="padding:2px 20px 15px 0;">
					<div class="inline size12" style="vertical-align: top;padding-top:9px;"><b>日期 : </b></div>
					<div class="inline">
						<div class="input-group" id="choice_date" style="width:160px;">
							<input type="text" class="form-control" name="choice_date" value="$choice_date"/>
							<div class="input-group-append input-group-addon">
								<i class="far fa-calendar-alt input-group-text" style="cursor: pointer;"></i>
							</div>
						</div>
						<script type="text/javascript">
							$(function () {
								$('#choice_date').datetimepicker({
									locale: 'zh-tw'
									,format:"YYYY-MM-DD"
									,allowInputToggle: true
								});
								$("#choice_date").on("dp.change", function (e) {
									$('#inquery').click();
								});
							});
						</script>
					</div>
				</div>
				<div class="col-xs-12 col-md-6 text-left" style="padding:2px 0 15px 20px;">
					<input type="hidden" name="fm" value="$fm" />
					<input type="hidden" name="t" value="$t" />
					<input type="hidden" name="ch" value="$ch" />
					<input type="hidden" name="auto_seq" value="$auto_seq" />
					<div class="btn-group" role="group">
						<button id="inquery" class="btn btn-info" type="button" onclick="CheckValue(this.form);"/><i class="fas fa-search"></i>&nbsp;$Inquire</button>
						<button class="btn btn-info" type="button" onclick="window.location.href='$thisurl';"/><i class="fas fa-undo"></i>&nbsp;Reset</button>
						<!--
						<a role="button" class="btn btn-success" href="/index.php?ch=grPA310_day_summary_excel&choice_date=$choice_date&end_date=$end_date&auto_seq=$o_auto_seq&caption=$url_caption&fm=$fm"><i class="far fa-file-excel"></i>&nbsp;$Export_Excel</a>
						-->
					</div>
				</div>
				</div>
			</div>
			</form>
EOT;



$show_top_tools=<<<EOT
	<div class="mytable" style="width:100%;background-color:#fff;padding: 20px 10px 0 10px;opacity: 0.9;">
		<div class="myrow">
			<div class="mycell" style="width:20%;padding: 10px;vertical-align: bottom;">
				<a role="button" class="btn btn-light float-left " href="/index.php?case_id=$case_id&fm=analysis"><i class="bi bi-chevron-left"></i>&nbsp;回上頁</a>
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
<div class="mytable" style="width:100%;max-width:1400px;margin: 0 auto;background-color:#fff;padding: 0 10px;">
	<div class="myrow">
		<div class="mycell" style="width:100%;padding: 0;vertical-align: bottom;">
			<div style="width:auto;min-height:500px;margin: 0 auto;padding:20px;">
				<div style="position:relative;margin: 0;">
					$show_filter
				</div>
				<div style="width:100%;">
					<div id="QUARTER_TOTAL_KW" class="text-center size20 blue weight mt-3">$PAGE_QUARTER_MAX_KW KW &nbsp;&nbsp; $QUARTER_TOTAL_KW_PERCENT</div>
					<div id="quarter_immediate_kw" style="width: 100%; height: 350px; margin:30px auto;padding: 20px 10px;"></div>
					$show_analysis
				</div>
			</div>
		</div>
	</div>
</div>
EOT;
	
} else {

$show_report=<<<EOT
<div style="width:100%;">
	$show_top_tools
	<div style="width:100%;max-width:1000px;min-height:500px;margin: 0 auto;padding:20px;background-color:#fff;">
		<div style="position:relative;margin: 0;">
			$show_filter
		</div>
		<div style="width:100%;overflow-x: auto;">
			<div style="width:100%;min-width:1000px;">
				<div id="QUARTER_TOTAL_KW" class="text-center size20 blue weight mt-3">$PAGE_QUARTER_MAX_KW KW &nbsp;&nbsp; $QUARTER_TOTAL_KW_PERCENT</div>
				<div id="quarter_immediate_kw" style="width: 100%; height: 350px; margin:30px auto;padding: 20px 10px;"></div>
				$show_analysis
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

function CheckValue(thisform) {
	var ch = thisform.ch.value;
	var t = thisform.t.value;
	var fm = thisform.fm.value;
	var auto_seq = thisform.auto_seq.value;
	var choice_date = thisform.choice_date.value;
	
	var url = '/?ch='+ch+'&t='+t+'&auto_seq='+auto_seq+'&choice_date='+choice_date+'&fm='+fm;
	
    window.location = url;
    return false;
}
	
function allReset() {
	var all_Inputs = $("input[type=text]");
	all_Inputs.val("");
    return false;
}

	
</script>


<script>

var series_QUARTER_KW_alist = JSON.parse('$series_QUARTER_KW_alist');
var categories_QUARTER_KW_data = JSON.parse('$categories_QUARTER_KW_data');


$(function () {

	var chart = Highcharts.chart('quarter_immediate_kw', {
        title: {
			text: ''
		},
		chart: {
			events: {
			  load: function() {
				$('.highcharts-scrollbar').hide();
			  }
			}
		  },
		  legend: {                                                                    
            enabled: false                                                           
		},
		yAxis: {
			
			plotLines:[{
				label:{
					text: '<span style="color:red;">契約需量 $max_kw KW</span>'
				},
				color:'red',          			//線的顏色，定義為紅色
				dashStyle:'solid',				//標示線的樣式，預設值是solid（實線）
				value:'$max_kw',        				//定義在哪個值上顯示標示線，這裡是在x軸上刻度為value的值處垂直畫一條線
				width:2                 		//標示線的寬度，3px
			},{
				label:{
					text: '<span style="color:green;">警示需量 $base_kw KW</span>'
				},
				color:'green',          		//線的顏色，定義為紅色
				dashStyle:'solid',				//標示線的樣式，預設值是solid（實線）
				value:'$base_kw',        				//定義在哪個值上顯示標示線，這裡是在x軸上刻度為value的值處垂直畫一條線
				width:2                			//標示線的寬度，3px
			}]
			,title: {
				text: '<span class="font_a size12 weight">KW</span>'
			}
			,max: '$PAGE_QUARTER_MAX_KW'
			,min: '$min_kw'
		},
		xAxis: {
			categories: categories_QUARTER_KW_data,
			tickInterval: 5,
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
		series: series_QUARTER_KW_alist
    }, function (chart) { // on complete
	});

});


</script>

EOT;

?>