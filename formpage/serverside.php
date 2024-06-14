<?php
include('condb.php');
// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

//ฟิลด์ที่จะเอามาแสดงและค้นหา
$columns = array( 
// datatable column index  => database column name
	0 =>'mov_id', 
	1 => 'mov_title',
	2=> 'mov_url',
	3=> 'mov_rating'
);

// getting total number records without any search
$sql = "SELECT mov_id, mov_title, mov_url, mov_rating ";
$sql.=" FROM movies";
$query=mysqli_query($condb, $sql) or die("movies-grid-data.php: get moviess");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT mov_id, mov_title, mov_url, mov_rating ";
$sql.=" FROM movies WHERE 1=1";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( mov_id LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR mov_title LIKE '".$requestData['search']['value']."%' ";

	$sql.=" OR mov_url LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR mov_rating LIKE '".$requestData['search']['value']."%' )";
}
$query=mysqli_query($condb, $sql) or die("movies-grid-data.php: get moviess");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($condb, $sql) or die("movies-grid-data.php: get moviess");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

	$nestedData[] = $row["mov_id"];
	$nestedData[] = $row["mov_title"];
	$nestedData[] = $row["mov_url"];
	$nestedData[] = $row["mov_rating"];
	
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