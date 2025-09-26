<?php


//error_reporting(1);
//ini_set('display_errors', '1');


//載入公用函數
@include_once '/website/include/pub_function.php';

include_once("/website/class/".$site_db."_info_class.php");

$m_pub_modal	= "/website/smarty/templates/".$site_db."/pub_modal";


$case_id = "C1";


//$date = date('Y-m-d H:i:s');
$this_year = date('Y');
$this_month = date('m');
$today = date('d');


$KWH_min_value = (float)$row_web['min_value'];
$KWH_base_value = (float)$row_web['base_value'];
$KWH_max_value = (float)$row_web['max_value'];
$KWH_limit_value = (float)$row_web['limit_value'];

$mDB = "";
$mDB = new MywebDB();

$mDB2 = "";
$mDB2 = new MywebDB();


//讀取電力計設備(主要是PA310)

$Qry="SELECT a.*,c.caption
,(select KWH from grPA310_logs_by_month where case_id = '$case_id' and dm_year = '$this_year' and dm_month = '$this_month' limit 1) AS month_KWH
FROM grPA310_recording_by_minute a
LEFT JOIN ammeter_node b ON b.auto_seq = a.seq
LEFT JOIN ammeter c ON c.case_id = b.case_id AND c.router_id = b.router_id AND c.ammeter_id = b.ammeter_id
WHERE a.case_id = '$case_id'
ORDER BY a.auto_seq DESC LIMIT 1";

//echo $Qry."<br>";
//exit;


$mDB->query($Qry);

$show_devices = "";

$auto_seq_array = array();


$Watts = getlang("瓦數");
$kilowatt = getlang("仟瓦");
$Reading = getlang("讀表");
$Offline = getlang("已離線");
$Voltage = getlang("電壓");
$monthly_degree = getlang("本月度數");
$Current = getlang("電流");
$Power_factor = getlang("功率因數");
$Kilowatts_hours = getlang("仟瓦小時");
$switch = getlang("開關");
$Warning = getlang("警示");
$Total_watts = getlang("總瓦數");


$KWH_tot = 0;

$grdoport_total = $mDB->rowCount();
if ($grdoport_total > 0) {
    while ($PA310_row=$mDB->fetchRow(2)) {
		
		$p_auto_seq = $PA310_row['port_seq'];
		$p_caption = $PA310_row['caption'];
		$p_port_no = $PA310_row['port_no'];
		$p_node_no = $PA310_row['node_no'];
		$p_ctype = $PA310_row['ctype'];
		$p_notes = $PA310_row['notes'];

		//電壓-N
		$Vln_a = round($PA310_row['Vln_a'],2);
		$Vln_b = round($PA310_row['Vln_b'],2);
		$Vln_c = round($PA310_row['Vln_c'],2);
		$Vln_avg = round($PA310_row['Vln_avg'],2);
		//電壓-B
		$Vll_ab = round($PA310_row['Vll_ab'],2);
		$Vll_bc = round($PA310_row['Vll_bc'],2);
		$Vll_ca = round($PA310_row['Vll_ca'],2);
		$Vll_avg = round($PA310_row['Vll_avg'],2);
		//電流
		$I_a = round($PA310_row['I_a'],2);
		$I_b = round($PA310_row['I_b'],2);
		$I_c = round($PA310_row['I_c'],2);
		$I_avg = round($PA310_row['I_avg'],2);
		//實功率 KW
		$kW_a = round($PA310_row['kW_a'],2);
		$kW_b = round($PA310_row['kW_b'],2);
		$kW_c = round($PA310_row['kW_c'],2);
		$kW_total = round($PA310_row['kW_total'],2);

		//乏功率 KVAR
		$kVar_a = round($PA310_row['kVar_a'],2);
		$kVar_b = round($PA310_row['kVar_b'],2);
		$kVar_c = round($PA310_row['kVar_c'],2);
		$kVar_total = round($PA310_row['kVar_total'],2);
		//視在功率 KVA
		$kVA_a = round($PA310_row['kVA_a'],2);
		$kVA_b = round($PA310_row['kVA_b'],2);
		$kVA_c = round($PA310_row['kVA_c'],2);
		$kVA_total = round($PA310_row['kVA_total'],2);
		//功率因數 PF
		$PF_signed_a = round($PA310_row['PF_signed_a']*100,1)."%";
		$PF_signed_b = round($PA310_row['PF_signed_b']*100,1)."%";
		$PF_signed_c = round($PA310_row['PF_signed_c']*100,1)."%";
		$PF_signed_avg = round($PA310_row['PF_signed_avg']*100,1)."%";
		//Angle V 
		$PhaseAngle_V_a = round($PA310_row['PhaseAngle_V_a'],2);
		$PhaseAngle_V_b = round($PA310_row['PhaseAngle_V_b'],2);
		$PhaseAngle_V_c = round($PA310_row['PhaseAngle_V_c'],2);
		//Angle I
		$PhaseAngle_I_a = round($PA310_row['PhaseAngle_I_a'],2);
		$PhaseAngle_I_b = round($PA310_row['PhaseAngle_I_b'],2);
		$PhaseAngle_I_c = round($PA310_row['PhaseAngle_I_c'],2);

		$kWh_deliver = round($PA310_row['kWh_deliver'],4);
		$kWh_receiver = round($PA310_row['kWh_receiver'],4);

		$kvarh_lagging = round($PA310_row['kvarh_lagging'],4);
		$kvarh_leading = round($PA310_row['kvarh_leading'],4);

		$kVAh = round($PA310_row['kVAh'],4);
		$FREQ = round($PA310_row['FREQ'],2);

		
		$total_wh = $total_wh + $kW_total;
		
		
		$rec_datetime = $PA310_row['rec_datetime'];
		$show_rec_datetime = date("Y-m-d H:i",strtotime($rec_datetime)); 
		
		$month_KWH = round($PA310_row['month_KWH'],2);
		$fmt_month_KWH = number_format($month_KWH,2);

		if (empty($month_KWH))
			$month_KWH = 0;

		
		$min_value = $PA310_row['min_value'];
		$base_value = $PA310_row['base_value'];
		$max_value = $PA310_row['max_value'];
		$limit_value = $PA310_row['limit_value'];
		
		//$p_online = $PA310_row['online'];
		$p_online = "Y";
		
	
			
				$show_dm_port = $p_ctype."-".$p_port_no."-".$p_node_no;

				$auto_seq_array[] = $p_auto_seq;
		
				$PA310_card_id = "PA310_card_".$p_auto_seq;
				
				$PA310_dev_id = "PA310_".$p_auto_seq;
				$PA310_bg_id = "PA310_bg_".$p_auto_seq;


				$rec_datetime_id = "rec_datetime_".$p_auto_seq;
								
				
				
				$online_id = "online_".$p_auto_seq;
				$online_img = "online_img_".$p_auto_seq;
				
				
				$thumbnail_bgcolor = "";
				if ($p_online <> "Y") {
					$thumbnail_bgcolor = "background-color:#ddd";
				} else {
				
					if ($month_KWH >= $KWH_max_value) {
						$thumbnail_bgcolor = "background-color:#EB2F02";
					} else if (($month_KWH >= $KWH_base_value) && ($month_KWH < $KWH_max_value)) {
						$thumbnail_bgcolor = "background-color:yellow";
					}
				
				}
				
				$show_online_disabled = "display_none";
				$opacity_online = "0.9";
				if ($p_online <> "Y") {
					$show_online_disabled = "";
					$opacity_online = "0.4";
				}
				
				
				$meter_container_kwh = "meter_container_kwh_".$p_auto_seq;
				$meter_container_kwh_id = "#meter_container_kwh_".$p_auto_seq;

				$meter_container = "meter_container_".$p_auto_seq;
				$meter_container_id = "#meter_container_".$p_auto_seq;
				
				
		
$show_devices.=<<<EOT
<div class="inline" style="width:100%;max-width:900px;padding: 0 10px;margin:0;">
	<div id="$online_id" class="$show_online_disabled" style="position:relative; z-index:99;float:left;margin: 1px -36px -32px 6px; width:32px; height:32px;"><img id="$online_img" src="/images/png/disconnected.png" width="32" title="$Offline"></div>
	<div id="$PA310_card_id" class="card card-default shadow_halo2" style="opacity: $opacity_online;">
		<div class="card-header card-header-custom">
			<div class="details size16 weight" title="$p_caption">$p_caption</div>
			<div class="text-nowrap size12 weight text-left">$Reading : $show_rec_datetime</div>
			<div class="badge badge-light size12 weight" style="float:right;margin: -21px 1px 0 0;padding: 1px 5px;">$p_auto_seq</div>
		</div>
		<div id="$PA310_bg_id" class="card-body" style="$thumbnail_bgcolor;">
			<div class="container-fluid" style="padding: 0;">
				<div class="row">
					<div class="col-sm-12 col-md-7 col-lg-7 col-xl-7">
						<div class="container-fluid" style="width:100%;padding: 0;">
							<div class="row">
								<div class="col-sm-12 col-md-4 col-lg-4 col-xl-4" style="padding: 0 3px;">
									<table class="table table-sm table-bordered" style="width:100%;margin: 0 0 5px 0;">
										<thead class="bg-green white weight">
											<tr>
												<th colspan="2" scope="col">電壓-N (V)</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<th scope="row" style="width:40%;">RS相</th>
												<td class="myVal1 weight" style="width:60%;">$Vln_a</td>
											</tr>
											<tr>
												<th scope="row">ST相</th>
												<td class="myVal1 weight">$Vln_b</td>
											</tr>
											<tr>
												<th scope="row">TR相</th>
												<td class="myVal1 weight">$Vln_c</td>
											</tr>
											<tr>
												<th scope="row">平均</th>
												<td class="myVal1 red weight">$Vln_avg</td>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="col-sm-12 col-md-4 col-lg-4 col-xl-4" style="padding: 0 3px;">
									<table class="table table-sm table-bordered" style="width:100%;margin: 0 0 5px 0;">
										<thead class="bg-green white weight">
											<tr>
												<th colspan="2" scope="col">電壓-B (V)</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<th scope="row" style="width:40%;">RS相</th>
												<td class="myVal1 weight" style="width:60%;">$Vll_ab</td>
											</tr>
											<tr>
												<th scope="row">ST相</th>
												<td class="myVal1 weight">$Vll_bc</td>
											</tr>
											<tr>
												<th scope="row">TR相</th>
												<td class="myVal1 weight">$Vll_ca</td>
											</tr>
											<tr>
												<th scope="row">平均</th>
												<td class="myVal1 red weight">$Vll_avg</td>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="col-sm-12 col-md-4 col-lg-4 col-xl-4" style="padding: 0 3px;">
									<table class="table table-sm table-bordered" style="width:100%;margin: 0 0 5px 0;">
										<thead class="bg-green white weight">
											<tr>
												<th colspan="2" scope="col">電流 (A)</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<th scope="row" style="width:40%;">R相</th>
												<td class="myVal1 weight" style="width:60%;">$I_a</td>
											</tr>
											<tr>
												<th scope="row">S相</th>
												<td class="myVal1 weight">$I_b</td>
											</tr>
											<tr>
												<th scope="row">T相</th>
												<td class="myVal1 weight">$I_c</td>
											</tr>
											<tr>
												<th scope="row">平均</th>
												<td class="myVal1 red weight">$I_avg</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12 col-md-4 col-lg-4 col-xl-4" style="padding: 0 3px;">
									<table class="table table-sm table-bordered" style="width:100%;margin: 0 0 5px 0;">
										<thead class="bg-green white weight">
											<tr>
												<th colspan="2" scope="col">實功率 (kW)</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<th scope="row" style="width:40%;">A</th>
												<td class="myVal1 weight" style="width:60%;">$kW_a</td>
											</tr>
											<tr>
												<th scope="row">B</th>
												<td class="myVal1 weight">$kW_b</td>
											</tr>
											<tr>
												<th scope="row">C</th>
												<td class="myVal1 weight">$kW_c</td>
											</tr>
											<tr>
												<th scope="row">TOTAL</th>
												<td class="myVal1 red weight">$kW_total</td>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="col-sm-12 col-md-4 col-lg-4 col-xl-4" style="padding: 0 3px;">
									<table class="table table-sm table-bordered" style="width:100%;margin: 0 0 5px 0;">
										<thead class="bg-green white weight">
											<tr>
												<th colspan="2" scope="col">乏功率 (kVar)</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<th scope="row" style="width:40%;">A</th>
												<td class="myVal1 weight" style="width:60%;">$kVar_a</td>
											</tr>
											<tr>
												<th scope="row">B</th>
												<td class="myVal1 weight">$kVar_b</td>
											</tr>
											<tr>
												<th scope="row">C</th>
												<td class="myVal1 weight">$kVar_c</td>
											</tr>
											<tr>
												<th scope="row">TOTAL</th>
												<td class="myVal1 red weight">$kVar_total</td>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="col-sm-12 col-md-4 col-lg-4 col-xl-4" style="padding: 0 3px;">
									<table class="table table-sm table-bordered" style="width:100%;margin: 0 0 5px 0;">
										<thead class="bg-green white weight">
											<tr>
												<th colspan="2" scope="col">視在功率 (kVA)</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<th scope="row" style="width:40%;">A</th>
												<td class="myVal1 weight" style="width:60%;">$kVA_a</td>
											</tr>
											<tr>
												<th scope="row">B</th>
												<td class="myVal1 weight">$kVA_b</td>
											</tr>
											<tr>
												<th scope="row">C</th>
												<td class="myVal1 weight">$kVA_c</td>
											</tr>
											<tr>
												<th scope="row">TOTAL</th>
												<td class="myVal1 red weight">$kVA_total</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12 col-md-4 col-lg-4 col-xl-4" style="padding: 0 3px;">
									<table class="table table-sm table-bordered" style="width:100%;margin: 0 0 5px 0;">
										<thead class="bg-green white weight">
											<tr>
												<th colspan="2" scope="col">功率因數 (PF)</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<th scope="row" style="width:40%;">A</th>
												<td class="myVal1 weight" style="width:60%;">$PF_signed_a</td>
											</tr>
											<tr>
												<th scope="row">B</th>
												<td class="myVal1 weight">$PF_signed_b</td>
											</tr>
											<tr>
												<th scope="row">C</th>
												<td class="myVal1 weight">$PF_signed_c</td>
											</tr>
											<tr>
												<th scope="row">平均</th>
												<td class="myVal1 red weight">$PF_signed_avg</td>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="col-sm-12 col-md-4 col-lg-4 col-xl-4" style="padding: 0 3px;">
									<table class="table table-sm table-bordered" style="width:100%;margin: 0 0 5px 0;">
										<thead class="bg-green white weight">
											<tr>
												<th colspan="2" scope="col">電壓角度</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<th scope="row" style="width:40%;">A</th>
												<td class="myVal1 weight" style="width:60%;">$PhaseAngle_V_a</td>
											</tr>
											<tr>
												<th scope="row">B</th>
												<td class="myVal1 weight">$PhaseAngle_V_b</td>
											</tr>
											<tr>
												<th scope="row">C</th>
												<td class="myVal1 weight">$PhaseAngle_V_c</td>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="col-sm-12 col-md-4 col-lg-4 col-xl-4" style="padding: 0 3px;">
									<table class="table table-sm table-bordered" style="width:100%;margin: 0 0 5px 0;">
										<thead class="bg-green white weight">
											<tr>
												<th colspan="2" scope="col">電流角度</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<th scope="row" style="width:40%;">A</th>
												<td class="myVal1 weight" style="width:60%;">$PhaseAngle_I_a</td>
											</tr>
											<tr>
												<th scope="row">B</th>
												<td class="myVal1 weight">$PhaseAngle_I_b</td>
											</tr>
											<tr>
												<th scope="row">C</th>
												<td class="myVal1 weight">$PhaseAngle_I_c</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12" style="padding: 0 0 10px 3px;">
									<div id="$meter_container_kwh" style="width: 99%; height: 100px;margin: 0;padding: 5px;border: 1px solid #000;"></div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-12 col-md-5 col-lg-5 col-xl-5">
						<table class="table table-sm table-bordered" style="width:100%;margin: 0 0 5px 0;">
							<thead class="bg-green white weight">
								<tr>
									<th scope="col">kWh+</th>
									<th scope="col">kWh-</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td class="myVal1 weight" style="width:50%;">$kWh_deliver</td>
									<td class="myVal1 weight" style="width:50%;">$kWh_receiver</td>
								</tr>
							</tbody>
						</table>
						<table class="table table-sm table-bordered" style="width:100%;margin: 0 0 5px 0;">
							<thead class="bg-green white weight">
								<tr>
									<th scope="col">kVarh+</th>
									<th scope="col">kVarh-</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td class="myVal1 weight" style="width:50%;">$kvarh_lagging</td>
									<td class="myVal1 weight" style="width:50%;">$kvarh_leading</td>
								</tr>
							</tbody>
						</table>
						<table class="table table-sm table-bordered" style="width:100%;margin: 0 0 5px 0;">
							<thead class="bg-green white weight">
								<tr>
									<th scope="col">KVAH</th>
									<th scope="col">頻率</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td class="myVal1 weight" style="width:50%;">$kVAh</td>
									<td class="myVal1 weight" style="width:50%;">$FREQ</td>
								</tr>
							</tbody>
						</table>
						<div class="text-center" style="padding: 20px 0 0 0;">
							<span class="size14 weight">本月累積用電度數</span>
						</div>
						<div class="text-center vbottom" style="padding: 0;">
							<span class="size24 red weight">$fmt_month_KWH</span>&nbsp;&nbsp;<span class="size12 weight">kWh</span>
						</div>
						<div id="$meter_container" style="width: 100%; height: 300px;margin: 0 auto;"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
$(function () {
    $('$meter_container_id').highcharts({
        chart: {
            type: 'gauge',
            plotBackgroundColor: null,
            plotBackgroundImage: null,
            plotBorderWidth: 0,
            plotShadow: false,
			backgroundColor: 'rgba(0,0,0,0)'
        },
        title: {
            text: ''
        },
		credits: {
			enabled: false
		},
        pane: {
            startAngle: -150,
            endAngle: 150,
            background: [{
                backgroundColor: {
                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                    stops: [
                        [0, '#FFF'],
                        [1, '#333']
                    ]
                },
                borderWidth: 0,
                outerRadius: '109%'
            }, {
                backgroundColor: {
                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                    stops: [
                        [0, '#333'],
                        [1, '#FFF']
                    ]
                },
                borderWidth: 1,
                outerRadius: '107%'
            }, {
                // default background
            }, {
                backgroundColor: '#DDD',
                borderWidth: 0,
                outerRadius: '105%',
                innerRadius: '103%'
            }]
        },
        // the value axis
        yAxis: {
            min: 0,
            max: $KWH_limit_value,
            minorTickInterval: 'auto',
            minorTickWidth: 1,
            minorTickLength: 10,
            minorTickPosition: 'inside',
            minorTickColor: '#666',
            tickPixelInterval: 30,
            tickWidth: 2,
            tickPosition: 'inside',
            tickLength: 10,
            tickColor: '#666',
            labels: {
                step: 2,
                rotation: 'auto'
            },
            title: {
                text: 'kWh'
            },
            plotBands: [{
                from: $KWH_min_value,
                to: $KWH_base_value,
                color: '#55BF3B' // green
            }, {
                from: $KWH_base_value,
                to: $KWH_max_value,
                color: '#DDDF0D' // yellow
            }, {
                from: $KWH_max_value,
                to: $KWH_limit_value,
                color: '#DF5353' // red
            }]
        },
        series: [{
            name: 'Speed',
            data: [$month_KWH],
            tooltip: {
                valueSuffix: 'KWh'
            }
        }]
    });
	

});

</script>
EOT;


				$month_max_kwh = 0;

				$alist_kwh = array();

				/*
				$Qry2 = "SELECT dm_day,SUM(KWH) AS DAY_KWH FROM grPA310_KW_quarter
				WHERE case_id = '$case_id' AND seq = '$p_auto_seq' AND dm_year = '$this_year' AND dm_month = '$this_month'
				GROUP BY case_id,dm_year,dm_month,dm_day
				ORDER BY case_id,dm_year,dm_month,dm_day";
				*/

				$Qry2 = "SELECT dm_day,KWH  as DAY_KWH FROM grPA310_logs_by_day
				WHERE case_id = '$case_id' and dm_year = '$this_year' and dm_month = '$this_month'
				ORDER BY case_id,dm_year,dm_month";



				$mDB2->query($Qry2);

				$m_kwh = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);

				if ($mDB2->rowCount() > 0) {
					while ($row2=$mDB2->fetchRow(2)) {

						$day=$row2['dm_day'];
						$DAY_KWH=$row2['DAY_KWH'];
						$m_kwh[$day-1] = round(floatval($DAY_KWH),2);

						if ($DAY_KWH > $month_max_kwh)
							$month_max_kwh = round($DAY_KWH,2);

					}
				}


				$s_data = array();
				$bool = false;
				for ($i = 30; $i >= 0; $i--) {
					if ($m_kwh[$i] == 0) {
						if ($bool == true)
							$s_data[] = 0;
						else
							$s_data[] = "";
					} else {
						$s_data[] = $m_kwh[$i];
						$bool = true;
					}
				}
				if (!$bool)
					$s_data = array('','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',0);
				
				
				$Message_01 = getlang("用電度數");
				
				$alist_kwh[]=array(
					"type"=>"line"
					,"name"=>"$Message_01"
					,"data"=>array_reverse($s_data)
				);
				

				$series_data_kwh = json_encode($alist_kwh);

$show_devices.=<<<EOT
<script>

//用電度數

var series_data_kwh = JSON.parse('$series_data_kwh');

$(function () {
    $('$meter_container_kwh_id').highcharts({
        title: {
			text: ''
		},
		chart: {
			spacingBottom: 0,
			marginBottom: 0,
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
			title: {
				text: '<span class="font_a size12 weight">kWh</span>'
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
		labels: {
			items: [{
				html: '',
				style: {
					left: '50px',
					top: '1px',
					color: (Highcharts.theme && Highcharts.theme.textColor) || 'black'
				}
			}]
		},
		credits: {
			enabled: false
		},
		scrollbar: {
		  enabled: true
		},
        series: series_data_kwh
    }, function (chart) {
    });
});


</script>
EOT;





			
	}
}


$mDB2->remove();
$mDB->remove();


$home = getlang("回首頁");
$goback = getlang("回上頁");
$meter = getlang("總電表即時資訊");
$Quantity = getlang("數量");
$Update_status = getlang("更新設備即時狀態");



$a_array = implode(",", $auto_seq_array);


$grPA310_reading_ontime = "/smarty/templates/".$site_db."/pub_modal/green/grPA310_ms/grPA310_reading_ontime.php";


//$show_close_btn = "<span style=\"float:right;\"><a href=\"javascript:history.go(-1);\">$goback</a></span>";


$show_top_tools=<<<EOT
	<div class="mytable" style="width:100%;background-color:#fff;padding: 20px 10px 0 10px;opacity: 0.9;">
		<div class="myrow">
			<div class="mycell" style="width:20%;padding: 10px;vertical-align: bottom;">
				<button type="button" class="btn btn-light float-left " onclick="history.go(-1);"><i class="bi bi-chevron-left"></i>&nbsp;回上頁</button>
			</div>
			<div class="mycell" style="width:60%;padding: 10px 5px;text-align:center;">
				<h3><b>$meter</b></h3>
			</div>
			<div class="mycell" style="width:20%;text-align:right;padding: 10px;vertical-align: bottom;">
			</div>
		</div>
	</div>
	<hr class="half-rule" style="margin: 0 0 20px 0;padding:0;border-color:$panel_bgcolor;">
EOT;




$fmt_KWH_tot = number_format(round($KWH_tot,2),2);

$show_refresh_controllable = "disabled";
if (($powerkey=="A") || ($super_admin=="Y")) {
	$show_refresh_controllable = "";
}


$PA310_list=<<<EOT
	$show_top_tools
	<div class="text-center" style="width:100%;">
		$show_devices
	</div>
EOT;


$show_center=<<<EOT
<script src="/js/highstock.js"></script>
<script src="/js/highcharts-more.js"></script>




<style>

.myVal1 {
	width:100%;
	font-size:1.2em;
	text-align:center;
}
.myVal3 {
	width:100%;
	font-size:1.8em;
	text-align:center;
	vertical-align: text-bottom;
}


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

</style>

<div style="width:100%;margin: 0 auto 50px auto;">
	$PA310_list
</div>

EOT;

?>