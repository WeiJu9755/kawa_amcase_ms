<?php

require_once '/website/os/Mobile-Detect-2.8.34/Mobile_Detect.php';
$detect = new Mobile_Detect;


$case_id = "C1";


$home = getlang("回首頁");
$goback = getlang("回上頁");
$Export_Excel= getlang("匯出Excel");

$mess_title = getlang("每日用電總量分析表");

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

$Qry="SELECT seq,dm_year,dm_month,dm_day,dm_hour,ROUND(MAX(AVG_KW),4) AS MAX_KW
,ROUND(SUM(KWH),4) AS SUM_KWH,ROUND(SUM(KVAH),4) AS SUM_KVAH 
FROM grPA310_KW_quarter
WHERE case_id = '$case_id' ".$date_query_str."
GROUP BY case_id,dm_year,dm_month,dm_day,dm_hour
ORDER BY case_id,dm_year DESC,dm_month DESC,dm_day DESC,dm_hour DESC";

$mDB->query($Qry);

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
			<th scope="col" class="size14 bg-silver text-nowrap" style="padding: 10px 0;width:70px;"><b>最高 KW</b></th>
			<th scope="col" class="size14 bg-silver text-nowrap" style="padding: 10px 0;width:70px;"><b>千瓦小時 KWH</b></th>
			<th scope="col" class="size14 bg-silver text-nowrap" style="padding: 10px 0;width:70px;"><b>千伏安時 KVAH</b></th>
			<th scope="col" class="size14 bg-silver text-nowrap" style="padding: 10px 0;width:70px;"><b>功率因數 PF(%)</b></th>
		</tr>
	</thead>
	<tbody>
EOT;

    while ($PA310_row=$mDB->fetchRow(2)) {
		
		$seq = $PA310_row['seq'];
		$dm_year = $PA310_row['dm_year'];
		$dm_month = $PA310_row['dm_month'];
		$dm_day = $PA310_row['dm_day'];
		$dm_hour = $PA310_row['dm_hour'];

		$MAX_KW = $PA310_row['MAX_KW'];
		$SUM_KWH = $PA310_row['SUM_KWH'];
		$SUM_KVAH = $PA310_row['SUM_KVAH'];
		//$PF = round(($SUM_KWH / SQRT(POW($SUM_KWH,2)+POW($SUM_KVAH,2)))*100,2);

		$PF = round($SUM_KWH / $SUM_KVAH * 100,2);


		$m_MAX_KW[$dm_hour] = (float)$MAX_KW;
		$m_SUM_KWH[$dm_hour] = (float)$SUM_KWH;
		$m_SUM_KVAH[$dm_hour] = (float)$SUM_KVAH;


$show_analysis.=<<<EOT
		<tr class="text-center">
			<th scope="row">$seq</th>
			<td>$dm_year</td>
			<td>$dm_month</td>
			<td>$dm_day</td>
			<td>$dm_hour</td>
			<td>$MAX_KW</td>
			<td>$SUM_KWH</td>
			<td>$SUM_KVAH</td>
			<td>$PF</td>
		</tr>
EOT;

	}

$show_analysis.=<<<EOT
	</tbody>
</table>
EOT;


}


$mDB->remove();





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
	,"name"=>"最高 KW"
	,"data"=>array_reverse($s_data)
);


$s_data = array();
$bool = false;
for ($i = 24; $i >= 0; $i--) {
	if ($m_SUM_KWH[$i] == 0) {
		if ($bool == true)
			$s_data[] = 0;
		else
			$s_data[] = "";
	} else {
		$s_data[] = $m_SUM_KWH[$i];
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
	,"name"=>"千瓦小時 KWH"
	,"data"=>array_reverse($s_data)
);


$s_data = array();
$bool = false;
for ($i = 24; $i >= 0; $i--) {
	if ($m_SUM_KVAH[$i] == 0) {
		if ($bool == true)
			$s_data[] = 0;
		else
			$s_data[] = "";
	} else {
		$s_data[] = $m_SUM_KVAH[$i];
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
	,"name"=>"千伏安時 KVAH"
	,"data"=>array_reverse($s_data)
);



$series_data_alist_hour = json_encode($alist_hour);





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



if (!($detect->isMobile() || $detect->isTablet())) {

$show_report=<<<EOT
<div class="w-auto" style="position:fixed;top: 10px; right:10px;z-index: 9999;">
	<button id="close" class="btn btn-danger p-2 px-3" type="button" onclick="window.close();"><i class="bi bi-power"></i>&nbsp;關閉</button>
</div>
<h3 class="weight text-center p-3">$mess_title</h3>
<hr class="half-rule" style="margin: 0;padding:0;border-color:$panel_bgcolor;">
<div class="mytable" style="width:100%;max-width:1400px;margin: 0 auto;background-color:#fff;padding: 0 10px;">
	<div class="myrow">
		<div class="mycell" style="width:100%;padding: 0;vertical-align: bottom;">
			<div style="width:auto;min-height:500px;margin: 0 auto;padding:20px;">
				<div style="position:relative;margin: 0;">
					$show_filter
				</div>
				<div style="width:100%;">
					$show_analysis
					<div id="container_hour" style="width: 100%; height: 550px; margin:30px auto;padding: 20px 10px;"></div>
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
	<h3 class="weight text-left p-3">$mess_title</h3>
	<hr class="half-rule" style="margin: 0;padding:0;border-color:$panel_bgcolor;">
	<div style="width:100%;max-width:1000px;min-height:500px;margin: 0 auto;padding:20px;background-color:#fff;">
		<div style="position:relative;margin: 0;">
			$show_filter
		</div>
		<div style="width:100%;overflow-x: auto;">
			<div style="width:100%;min-width:1000px;">
				$show_analysis
				<div id="container_hour" style="width: 100%; height: 550px; margin:30px auto;padding: 20px 10px;"></div>
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
	$('#caption_list').bind('change', function () {
		var url = $(this).val(); // get selected value
		if (url) { // require a URL
			window.location = url; // redirect
		}
		return false;
	});
});

	
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

//一個月

var series_data_alist_hour = JSON.parse('$series_data_alist_hour');
var series_data_cate_data = JSON.parse('$series_data_cate_data');

$(function () {
    $('#container_hour').highcharts({
        title: {
			text: ''
		},
		legend: {
			enabled: true
		},
		yAxis: {
			title: {
				text: '<span class="font_a size12 weight"></span>'
			}
		},
		mapNavigation: {
		  enableMouseWheelZoom: false
		},
        xAxis: {
			categories: series_data_cate_data,
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
        series: series_data_alist_hour
    });
});


</script>

EOT;

?>