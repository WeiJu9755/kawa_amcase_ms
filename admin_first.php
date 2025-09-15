<?php


$pro_id = $_GET['pro_id'];
$t = $_GET['t'];
if (!empty($t))
	$mt = "-".$t;
	
$m_location		= "/website/smarty/templates/".$site_db."/".$templates;
$m_pub_modal	= "/website/smarty/templates/".$site_db."/pub_modal";

	
//程式分類
$ch = empty($_GET['ch']) ? 'default' : $_GET['ch'];
switch($ch) {
	case 'add':
		$title = "新增資料";
		$sid = "view01";
		$modal = $m_pub_modal."/green/amcase_ms/amcase_add.php";
		include $modal;
		$smarty->assign('show_center',$show_center);
		$smarty->assign('xajax_javascript', $xajax->getJavascript('/xajax/'));
		break;
	case 'edit':
		$title = "資料編輯";
		$sid = "view01";
		$modal = $m_pub_modal."/green/amcase_ms/amcase_modify.php";
		include $modal;
		$smarty->assign('show_center',$show_center);
		$smarty->assign('xajax_javascript', $xajax->getJavascript('/xajax/'));
		break;
	case 'view':
		$title = "預覽資料";
		if (empty($sid))
			$sid = "pjhome01";
		$modal = $m_pub_modal."/green/amcase_ms/amcase_view.php";
		include $modal;
		$smarty->assign('show_center',$show_center);
		break;
	case 'view2':
		$title = "預覽資料";
		if (empty($sid))
			$sid = "pjhome01";
		$modal = $m_pub_modal."/green/amcase_ms/amcase_view2.php";
		include $modal;
		$smarty->assign('show_center',$show_center);
		break;
	case 'analysis1':
	case 'analysis2':
	case 'analysis3':
	case 'analysis3a':
	case 'analysis4':
	case 'analysis5':
	case 'analysis6':
	case 'analysis7':
	case 'analysis8':
	case 'analysis9':
	case 'analysis10':
	case 'analysis10_view':
		$title = "預覽資料";
		if (empty($sid))
			$sid = "pjhome01";
		$modal = $m_pub_modal."/green/amcase_ms/amcase_analysis_menu.php";
		include $modal;
		$smarty->assign('show_center',$show_center);
		break;
	case 'test':
		$title = "預覽資料";
		if (empty($sid))
			$sid = "view01";
		$modal = $m_pub_modal."/green/amcase_ms/monitoring_test.php";
		include $modal;
		$smarty->assign('show_center',$show_center);
		break;
	case 'amdevice':
		//各項控制設備設定
		$title = getlang("設備設定");
		$modal = $m_pub_modal."/green/amcase_ms/amdevice.php";
		include $modal;
		$smarty->assign('show_center',$show_center);
		$smarty->assign('xajax_javascript', $xajax->getJavascript('/xajax/'));
		break;
	case 'amdevice_add':
		//主要控制設備新增
		$title = "新增資料";
		$sid = "view01";
		$modal = $m_pub_modal."/green/amcase_ms/amdevice_add.php";
		include $modal;
		$smarty->assign('show_center',$show_center);
		$smarty->assign('xajax_javascript', $xajax->getJavascript('/xajax/'));
		break;
	case 'amdevice_edit':
		//控制設備修改
		$title = "資料編輯";
		$sid = "view01";
		$modal = $m_pub_modal."/green/amcase_ms/amdevice_modify.php";
		include $modal;
		$smarty->assign('show_center',$show_center);
		$smarty->assign('xajax_javascript', $xajax->getJavascript('/xajax/'));
		break;
	case 'ammeter_add':
		//設備amMeter新增
		$title = "新增資料";
		$sid = "view01";
		$modal = $m_pub_modal."/green/amcase_ms/ammeter_add.php";
		include $modal;
		$smarty->assign('show_center',$show_center);
		$smarty->assign('xajax_javascript', $xajax->getJavascript('/xajax/'));
		break;
	case 'ammeter_edit':
		//設備amMeter修改
		$title = "資料編輯";
		$sid = "view01";
		$modal = $m_pub_modal."/green/amcase_ms/ammeter_modify.php";
		include $modal;
		$smarty->assign('show_center',$show_center);
		$smarty->assign('xajax_javascript', $xajax->getJavascript('/xajax/'));
		break;
	case 'ammeter_node':
		//amMeter Node
		$title = "電表量測節點";
		$sid = "view01";
		$modal = $m_pub_modal."/green/amcase_ms/ammeter_node.php";
		include $modal;
		$smarty->assign('show_center',$show_center);
		//$smarty->assign('xajax_javascript', $xajax->getJavascript('/xajax/'));
		break;
	case 'ammeter_node_edit':
		//設備amMeter修改
		$title = "資料編輯";
		$sid = "view01";
		$modal = $m_pub_modal."/green/amcase_ms/ammeter_node_modify.php";
		include $modal;
		$smarty->assign('show_center',$show_center);
		$smarty->assign('xajax_javascript', $xajax->getJavascript('/xajax/'));
		break;
	case 'ammeter_copy':
		//複製設備amMeter
		$title = "複製設備";
		$sid = "view01";
		$modal = $m_pub_modal."/green/amcase_ms/ammeter_copy.php";
		include $modal;
		$smarty->assign('show_center',$show_center);
		$smarty->assign('xajax_javascript', $xajax->getJavascript('/xajax/'));
		break;
	case 'attach':
		$title = "圖文檔案";
		$sid = "view01";
		$modal = $m_pub_modal."/green/amcase_ms/attach.php";
		include $modal;
		$smarty->assign('show_center',$show_center);
		$smarty->assign('xajax_javascript', $xajax->getJavascript('/xajax/'));
		break;
	case 'ammeter_export_excel':
		$title = "匯出Excel";
		if (empty($sid))
			$sid = "view01";
		$modal = $m_pub_modal."/green/amcase_ms/ammeter_export_excel.php";
		include $modal;
		$smarty->assign('show_center',$show_center);
		break;
	case 'ammeter_import_excel':
		$title = "匯入Excel";
		if (empty($sid))
			$sid = "view01";
		$modal = $m_pub_modal."/green/amcase_ms/ammeter_import_excel.php";
		include $modal;
		$smarty->assign('show_center',$show_center);
		break;
	case 'uploadexcel':
		$title = "匯入Excel";
		$sid = "view01";
		$modal = $m_pub_modal."/green/amcase_ms/uploadexcel.php";
		include $modal;
		$smarty->assign('show_center',$show_center);
		break;
	case 'amnode':
		$title = "量測節點設定";
		$modal = $m_pub_modal."/green/amcase_ms/amnode.php";
		include $modal;
		$smarty->assign('show_center',$show_center);
		break;
	case 'amcase_month_summary':
		if (empty($sid))
			$sid = "view01";
		$modal = $m_pub_modal."/green/amcase_ms/amcase_month_summary.php";
		include $modal;
		$smarty->assign('show_center',$show_center);
		break;
	case 'amcase_month_summary_excel':
		if (empty($sid))
			$sid = "view01";
		$modal = $m_pub_modal."/green/amcase_ms/amcase_month_summary_excel.php";
		include $modal;
		$smarty->assign('show_center',$show_center);
		break;
	case 'amcase_day_summary':
		if (empty($sid))
			$sid = "view01";
		$modal = $m_pub_modal."/green/amcase_ms/amcase_day_summary.php";
		include $modal;
		$smarty->assign('show_center',$show_center);
		break;
	case 'amcase_day_summary_excel':
		if (empty($sid))
			$sid = "view01";
		$modal = $m_pub_modal."/green/amcase_ms/amcase_day_summary_excel.php";
		include $modal;
		$smarty->assign('show_center',$show_center);
		break;
	case 'amcase_hour_summary':
		if (empty($sid))
			$sid = "view01";
		$modal = $m_pub_modal."/green/amcase_ms/amcase_hour_summary.php";
		include $modal;
		$smarty->assign('show_center',$show_center);
		break;
	case 'amcase_hour_summary2':
		if (empty($sid))
			$sid = "view01";
		$modal = $m_pub_modal."/green/amcase_ms/amcase_hour_summary2.php";
		include $modal;
		$smarty->assign('show_center',$show_center);
		break;
	case 'amcase_hour_summary_excel':
		if (empty($sid))
			$sid = "view01";
		$modal = $m_pub_modal."/green/amcase_ms/amcase_hour_summary_excel.php";
		include $modal;
		$smarty->assign('show_center',$show_center);
		break;
	case 'amcase_hour_summary_excel2':
		if (empty($sid))
			$sid = "view01";
		$modal = $m_pub_modal."/green/amcase_ms/amcase_hour_summary_excel2.php";
		include $modal;
		$smarty->assign('show_center',$show_center);
		break;
	case 'report_year_summary':
		if (empty($sid))
			$sid = "view01";
		$modal = $m_pub_modal."/green/amcase_ms/report_year_summary.php";
		include $modal;
		$smarty->assign('show_center',$show_center);
		break;
	case 'report_month_list':
		if (empty($sid))
			$sid = "view01";
		$modal = $m_pub_modal."/green/amcase_ms/report_month_list.php";
		include $modal;
		$smarty->assign('show_center',$show_center);
		break;
	case 'report_month_list_excel':
		if (empty($sid))
			$sid = "view01";
		$modal = $m_pub_modal."/green/amcase_ms/report_month_list_excel.php";
		include $modal;
		$smarty->assign('show_center',$show_center);
		break;
	case 'report_day_list':
		if (empty($sid))
			$sid = "view01";
		$modal = $m_pub_modal."/green/amcase_ms/report_day_list.php";
		include $modal;
		$smarty->assign('show_center',$show_center);
		break;
	case 'report_day_list_excel':
		if (empty($sid))
			$sid = "view01";
		$modal = $m_pub_modal."/green/amcase_ms/report_day_list_excel.php";
		include $modal;
		$smarty->assign('show_center',$show_center);
		break;
	case 'grPA310_list':
		if (empty($sid))
			$sid = "pjhome01";
		$modal = $m_pub_modal."/green/amcase_ms/grPA310_list.php";
		include $modal;
		$smarty->assign('show_center',$show_center);
		break;
	case 'grPA310_year_summary':
		if (empty($sid))
			$sid = "view01";
		$modal = $m_pub_modal."/green/amcase_ms/grPA310_year_summary.php";
		include $modal;
		$smarty->assign('show_center',$show_center);
		break;
	case 'grPA310_month_summary':
		if (empty($sid))
			$sid = "view01";
		$modal = $m_pub_modal."/green/amcase_ms/grPA310_month_summary.php";
		include $modal;
		$smarty->assign('show_center',$show_center);
		break;
	case 'grPA310_day_summary':
		if (empty($sid))
			$sid = "view01";
		$modal = $m_pub_modal."/green/amcase_ms/grPA310_day_summary.php";
		include $modal;
		$smarty->assign('show_center',$show_center);
		break;
	case 'grPA60_list':
		if (empty($sid))
			$sid = "pjhome01";
		$modal = $m_pub_modal."/green/amcase_ms/grPA60_list.php";
		include $modal;
		$smarty->assign('show_center',$show_center);
		break;
	case 'report_warning_list':
		if (empty($sid))
			$sid = "view01";
		$modal = $m_pub_modal."/green/amcase_ms/report_warning_list.php";
		include $modal;
		$smarty->assign('show_center',$show_center);
		break;
	case 'amcase_kw_event':
		if (empty($sid))
			$sid = "view01";
		$modal = $m_pub_modal."/green/amcase_ms/amcase_kw_event.php";
		include $modal;
		$smarty->assign('show_center',$show_center);
		break;
	default:
		$title = getlang("案場管理");
		$modal = $m_pub_modal."/green/amcase_ms/amcase.php";
		include $modal;
		$smarty->assign('show_center',$show_center);
		$smarty->assign('xajax_javascript', $xajax->getJavascript('/xajax/'));
		break;
};

	
?>