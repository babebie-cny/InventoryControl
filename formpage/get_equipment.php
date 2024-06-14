<?php
header('Content-Type: application/json');
include("../include/config.php");
include("../include/common.php");

// CheckUserLogin_Fornt();

$sUserID = isset($_SESSION['au_member_id']) ? $_SESSION['au_member_id'] : '';
$sACT =  isset($_REQUEST['act']) ? $_REQUEST['act'] : '';

$sStatus = isset($_REQUEST['status']) ? $_REQUEST['status'] : '';
$sID =  isset($_REQUEST['id']) ? $_REQUEST['id'] : '';

$oDB = new DBI();

$id = isset($_GET['id']) ? $_GET['id'] : '';
// $id = "SIGPBSI23030001, RACKBSI23040003, RACKBSI23040005";

if ($id=='na'){
    $axSql = $oDB->Query("SELECT equipment_code, serial_no, asset_code, owner FROM tbl_equipment WHERE approve_status='A' ");
    $equipment_arr = array();
    if ($axSql) {
    while ($asResult = $axSql->FetchRow(DBI_ASSOC)) {
        $equipment_arr[] = $asResult;
    }
    echo json_encode($equipment_arr);
    }    

}elseif ($id) {
    $deviceList = explode(", ", $id);
    $deviceListFormatted = "'" . implode("', '", $deviceList) . "'";
    $sTBR = $oDB->Query("SELECT equipment_code, serial_no, asset_code, owner FROM tbl_equipment WHERE equipment_code IN ($deviceListFormatted)");
    $equipment_id_arr = array();
    if ($sTBR) {
        while ($asResult = $sTBR->FetchRow(DBI_ASSOC)) {
            $equipment_id_arr[] = $asResult;
        }
        echo json_encode($equipment_id_arr);
        }

    }
?>
