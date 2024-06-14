<?php
 include("../include/config.php"); 
 include("../include/common.php"); 

$oDB = new DBI();

$requestData= $_REQUEST;

$columns = array( 
  0=>'id', 
  1=>'asset', 
  2=>'Status', 
  3=>'descript1', 
  4=>'manufacturer',
  5=>'serial_no',
  6=>'room',
  7=>'location',
  8=>'location_name',
  9=>'name',
  10=>'surname'
  );
  
  $totalData = $oDB->QueryOne("SELECT COUNT(*) FROM tbl_equipment_sap ") ;
  $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

  if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
    $sql = "SELECT id, asset, descript1, manufacturer, serial_no, room, location, location_name, name, surname";
    $sql.=" FROM tbl_equipment_sap WHERE 1=1";
    $sql.=" AND ( id LIKE '%".$requestData['search']['value']."%' ";    
    $sql.=" OR asset LIKE '%".$requestData['search']['value']."%' ";
    $sql.=" OR descript1 LIKE '%".$requestData['search']['value']."%' ";
    $sql.=" OR manufacturer LIKE '%".$requestData['search']['value']."%' ";
    $sql.=" OR serial_no LIKE '%".$requestData['search']['value']."%' ";
    $sql.=" OR room LIKE '%".$requestData['search']['value']."%' ";
    $sql.=" OR location LIKE '%".$requestData['search']['value']."%' ";
    $sql.=" OR location_name LIKE '%".$requestData['search']['value']."%' ";
    $sql.=" OR name LIKE '%".$requestData['search']['value']."%' ";
    $sql.=" OR surname LIKE '%".$requestData['search']['value']."%' )";

    $sql_count = "SELECT COUNT(*)";
    $sql_count.=" FROM tbl_equipment_sap WHERE 1=1";
    $sql_count.=" AND ( id LIKE '%".$requestData['search']['value']."%' ";    
    $sql_count.=" OR asset LIKE '%".$requestData['search']['value']."%' ";
    $sql_count.=" OR descript1 LIKE '%".$requestData['search']['value']."%' ";
    $sql_count.=" OR manufacturer LIKE '%".$requestData['search']['value']."%' ";
    $sql_count.=" OR serial_no LIKE '%".$requestData['search']['value']."%' ";
    $sql_count.=" OR room LIKE '%".$requestData['search']['value']."%' ";
    $sql_count.=" OR location LIKE '%".$requestData['search']['value']."%' ";
    $sql_count.=" OR location_name LIKE '%".$requestData['search']['value']."%' ";
    $sql_count.=" OR name LIKE '%".$requestData['search']['value']."%' ";
    $sql_count.=" OR surname LIKE '%".$requestData['search']['value']."%' )";

    $totalFiltered = $oDB->QueryOne($sql_count) ;
    $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
    
  }else{

    $sql = "SELECT * ";
    $sql.=" FROM tbl_equipment_sap";

    $totalFiltered = $oDB->QueryOne("SELECT COUNT(*) FROM tbl_equipment_sap ") ;

    $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
  }

  $query=$oDB->Query($sql);

  $data = array();

    while($row = $query->FetchRow(DBI_ASSOC))   {
    // while( $row=mysqli_fetch_array($query) ) {  // preparing an array
    $nestedData=array(); 
    $nestedData[] = $row["id"];
    $nestedData[] = '<a href="sap_detail.php?act=view&id='.$row["id"].' ">'.$row["asset"].'</a>';
    $sSAP_EXT = $oDB->QueryRow("SELECT id FROM tbl_equipment WHERE sap_id='".$row["id"]."'", DBI_ASSOC);
    if ($sSAP_EXT) { 
    $nestedData[] = '<span class="badge badge-pill badge-secondary"><i style="margin-right:5px" class="fas fa-times-circle"></i> Registered </span>';
    }else{ 
    $nestedData[] =  '<span class="badge badge-pill badge-success"><i style="margin-right:5px" class="far fa-check-circle"></i> Not Registered </span>' ;
    } 

    $nestedData[] = $row["descript1"];
    $nestedData[] = $row["manufacturer"];
    $nestedData[] = $row["serial_no"];
    $nestedData[] = $row["room"];
    $nestedData[] = $row["location"];
    $nestedData[] = $row["location_name"];
    $nestedData[] = $row["name"];
    $nestedData[] = $row["surname"];
    
    $data[] = $nestedData;
  }

  $json_data = array(
    "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
    "recordsTotal"    => intval( $totalData ),  // total number of records
    "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
    "data"            => $data   // total data array
    );

echo json_encode($json_data);  // send data as json format

  ?>

