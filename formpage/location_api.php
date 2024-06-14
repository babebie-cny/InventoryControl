<?php
 include("../include/config.php"); 
 include("../include/common.php"); 

 $oDB = new DBI();

 if (isset($_POST['function']) && $_POST['function'] == 'du_building_id') {
    $id = $_POST['id_building'];

    $axSql_floor= $oDB->Query("SELECT * FROM tbl_floor WHERE building_id = '$id'  "); 
    while ($asResult = $axSql_floor->FetchRow(DBI_ASSOC)) {
        // $asResult['floor_name'] = $oDB->QueryOne("SELECT floor_name FROM tbl_floor WHERE id='".$asResult["floor_id"]."' ");
        // $asResult['id'] = $oDB->QueryOne("SELECT id FROM tbl_floor WHERE id='".$asResult["floor_id"]."' ");
        $asFloor[] = $asResult ;
    }
        echo '<option>Choose Floor</option>';
        foreach($asFloor as $sFloor) {     
        echo '<option value="'.$sFloor['id'].'"> '.$sFloor['floor_name'].' </option>';
    } 
    exit();
 }

 if (isset($_POST['function']) && $_POST['function'] == 'du_floor_id') {
    $id = $_POST['id_floor'];
    // $id1 = $_POST['id_building'];

    $axSql_room= $oDB->Query("SELECT * FROM tbl_room WHERE floor_id = '$id'  "); 
    while ($asResult = $axSql_room->FetchRow(DBI_ASSOC)) {
        // $asResult['room_name'] = $oDB->QueryOne("SELECT room_name FROM tbl_room WHERE id='".$asResult["room_id"]."' ");
        // $asResult['id'] = $oDB->QueryOne("SELECT id FROM tbl_room WHERE id='".$asResult["room_id"]."' ");
        $asRoom[] = $asResult ;
    }
        echo '<option>Choose Room</option>';
        foreach($asRoom as $sRoom) {     
        echo '<option value="'.$sRoom['id'].'"> '.$sRoom['room_name'].' </option>';
    } 
    exit();
 }

 if (isset($_POST['function']) && $_POST['function'] == 'du_room_id') {
    $id = $_POST['id_room'];

    $axSql_rack= $oDB->Query("SELECT * FROM tbl_rack WHERE room_id = '$id' "); 
    while ($asResult = $axSql_rack->FetchRow(DBI_ASSOC)) {
        // $asResult['room_name'] = $oDB->QueryOne("SELECT room_name FROM tbl_room WHERE id='".$asResult["room_id"]."' ");
        // $asResult['id'] = $oDB->QueryOne("SELECT id FROM tbl_room WHERE id='".$asResult["room_id"]."' ");
        $asRack[] = $asResult ;
    }
        echo '<option>Choose Rack</option>';
        foreach($asRack as $sRack) {     
        echo '<option value="'.$sRack['id'].'"> '.$sRack['rack_name'].' </option>';
    } 
    exit();
 }


?>