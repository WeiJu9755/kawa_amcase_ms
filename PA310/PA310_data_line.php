<?php


$site_db = $_GET['site_db'];
$case_id = $_GET['case_id'];

//$site_db = "green";
//$case_id = "C1";


include_once("/website/class/".$site_db."_info_class.php");


//讀取資料
$mDB = "";
$mDB=new MywebDB();


$Qry="
select
UNIX_TIMESTAMP(DATE_FORMAT(CONCAT(dm_year,'-',dm_month,'-',dm_day,' 23:59:59'),'%Y-%m-%d &H:%i:%s')) as uTIMESTAMP
,KWH 
from grPA310_logs_by_day
where case_id = '$case_id'
order by case_id,dm_year,dm_month,dm_day
";

$mDB->query($Qry);

$alist = array();
$total = $mDB->rowCount();
if ($total > 0) {
    //已找到符合資料
    while ($row=$mDB->fetchRow(2)) {
		$uTIMESTAMP=$row['uTIMESTAMP']*1000+28800000;
		$KWH = round($row['KWH'],2);

		$alist[]=array($uTIMESTAMP,$KWH);
		
	}
}
$mDB->remove();

echo json_encode($alist);

?>