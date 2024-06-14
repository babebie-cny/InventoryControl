<?php
 include("../include/config.php"); 
 include("../include/common.php"); 

$sUserID = isset($_SESSION['au_member_id']) ? $_SESSION['au_member_id'] : '';
$sACT =  isset($_REQUEST['act']) ? $_REQUEST['act'] : '';

$sStatus = isset($_REQUEST['status']) ? $_REQUEST['status'] : '';
$sID =  isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
$eID =  isset($_REQUEST['sid']) ? $_REQUEST['sid'] : '';
$sWF =  isset($_REQUEST['wf']) ? $_REQUEST['wf'] : '';

$oDB = new DBI();

if ($sUserID) {
	$dataUserinfo = $oDB->QueryRow("SELECT * FROM tbl_user_login WHERE id='".$sUserID."'", DBI_ASSOC);
	$dataUserinfo['pic_url'] = USERIMG_URL.$dataUserinfo['picture'];
  $dataUserinfo['team_name'] = $oDB->QueryOne("SELECT team_code FROM tbl_team WHERE id='".$dataUserinfo["team_id"]."' ");
}
if ($sACT=='view'){
	$axSql = $oDB->QueryRow("SELECT * FROM tbl_register_approve WHERE id=" .$sID, DBI_ASSOC);
  $axSql['createuser'] = $oDB->QueryOne("SELECT CONCAT(n2.firstname,' ',n2.lastname) FROM tbl_register_approve n1 INNER JOIN tbl_user_login n2 WHERE n1.user_insert = n2.id AND n1.id='".$sID."' ");
  $axSql['updateuser'] = $oDB->QueryOne("SELECT CONCAT(n2.firstname,' ',n2.lastname) FROM tbl_register_approve n1 INNER JOIN tbl_user_login n2 WHERE n1.user_update = n2.id AND n1.id='".$sID."' ");
  $axSql['group_equipment'] = $oDB->QueryOne("SELECT class_name FROM tbl_group_equipment WHERE id='".$axSql['group_equipment_id']."' ");
  $axSql['building'] = $oDB->QueryOne("SELECT building_name FROM tbl_building WHERE id='".$axSql['building_id']."' ");
  $axSql['floor'] = $oDB->QueryOne("SELECT floor_name FROM tbl_floor WHERE id='".$axSql['floor_id']."' ");
  $axSql['room'] = $oDB->QueryOne("SELECT room_name FROM tbl_room WHERE id='".$axSql['room_id']."' ");
  $axSql['rack'] = $oDB->QueryOne("SELECT rack_name FROM tbl_rack WHERE id='".$axSql['rack_id']."' ");
  $axSql['groupapprove'] = $oDB->QueryOne("SELECT n1.au_name FROM tbl_authen n1 INNER JOIN tbl_register_approve n2 WHERE n1.au_id=n2.group_approve AND n2.id= '".$sID."'  ");
  $axSql['approver'] = $oDB->QueryOne("SELECT CONCAT(n2.firstname,' ',n2.lastname) FROM tbl_register_approve n1 INNER JOIN tbl_user_login n2 WHERE n1.approver=n2.id AND n1.id= '".$sID."'  ");
}

function checkStatus($statusValue)
{
    if ($statusValue == 'A') {
        $statusString = '<h3><span class="badge  badge-success w-100"><i class="bi bi-check2-circle"></i> Approved</span></h3>';
    } elseif ($statusValue == 'N') {
        $statusString = '<h3><span class="badge  badge-warning w-100"><i class="bi bi-hourglass-split"></i> Appove Request</span></h3>';
    } elseif ($statusValue == '3') {
      $statusString = '<h3><span class="badge  badge-warning w-100"><i class="bi bi-eye"></i> Review Request</span></h3>';
    } elseif ($statusValue == 'R') {
        $statusString = '<h3><span class="badge  badge-danger w-100"><i class="bi bi-x-octagon"></i> Rejected</span></h3>';
    }

    return $statusString;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Control</title>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../alte/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../alte/dist/css/adminlte.min.css">

  <!--Style ตาราง -->
  <link rel="stylesheet" href="../alte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../alte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../alte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="../alte/plugins/toastr/toastr.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

</head>
<body class="hold-transition sidebar-mini sidebar-collapse">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar Head หลัก-->
   <?php include("../formpage/l_head_m1.php"); ?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container Menu ทั้งหมด-->
  <?php include("../formpage/l_menu.php"); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) Head รอง-->
    <?php //include("../formpage/l_head_sub.php"); ?>
    
    <!-- Main content รายละเอียด-->

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Approve Details </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
      <form name="dataform" id="dataform" action="" method="post" enctype="multipart/form-data" >
        <div class="row">

          <!-- left column -->
          <div class="col-md-8">

          <div class="row">	
          <div class="col-md-12">
          <?php $as_approve = $oDB->QueryOne("SELECT status_approve FROM tbl_register_approve WHERE id='".$sID."' ");?>
              <p><?php echo checkStatus($as_approve);?></p>
            </div>
				  </div>

          <div class="row">	
          <div class="col-md-3">
              <div class="callout callout-warning">
              <h5>SAP ID</h5>
              <p><?php echo isset($axSql['sap_id']) ? $axSql['sap_id'] : '';?></p>
              </div>
            </div>
            <div class="col-md-3">
            <div class="callout callout-warning">
            <h5>Serial Number</h5>
            <p><?php echo isset($axSql['serial_no']) ? $axSql['serial_no'] : '';?></p>
            </div>
            </div>
            <div class="col-md-6">
              <div class="callout callout-warning">
              <h5>Group Equipment</h5>
              <p><?php echo isset($axSql['group_equipment']) ? $axSql['group_equipment'] : '';?></p>
            </div>
            </div>
				  </div>

          <div class="row">	
          <div class="col-md-6">
            <div class="callout callout-warning">
            <h5>Equipment Code</h5>
            <p><?php echo isset($axSql['equipment_code']) ? $axSql['equipment_code'] : '';?></p>
            </div>
            </div>
            <div class="col-md-3">
            <div class="callout callout-warning">
            <h5>Asset Code</h5>
            <p><?php echo isset($axSql['asset_code']) ? $axSql['asset_code'] : '';?></p>
            </div>
            </div>
            <div class="col-md-3">
            <div class="callout callout-warning">
            <h5>Parent Asset</h5>
            <p><?php echo isset($axSql['parent_asset']) ? $axSql['parent_asset'] : '';?></p>
            </div>
            </div>
				  </div>

          <div class="row">	
          <div class="col-md-4">
            <div class="callout callout-warning">
            <h5>Model</h5>
            <p><?php echo isset($axSql['model']) ? $axSql['model'] : '';?></p>
            </div>
            </div>
            <div class="col-md-4">
            <div class="callout callout-warning">
            <h5>Buildings</h5>
            <p><?php echo isset($axSql['building']) ? $axSql['building'] : '';?></p>
            </div>
            </div>
            <div class="col-md-4">
            <div class="callout callout-warning">
            <h5>Floor</h5>
            <p><?php echo isset($axSql['floor']) ? $axSql['floor'] : '';?></p>
            </div>
            </div>
				  </div>

          <div class="row">	
          <div class="col-md-4">
            <div class="callout callout-warning">
            <h5>Room</h5>
            <p><?php echo isset($axSql['room']) ? $axSql['room'] : '';?></p>
            </div>
            </div>
            <div class="col-md-4">
            <div class="callout callout-warning">
            <h5>Rack</h5>
            <p><?php echo isset($axSql['rack']) ? $axSql['rack'] : '';?></p>
            </div>
            </div>
            <div class="col-md-4">
            <div class="callout callout-warning">
            <h5>Size</h5>
            <p><?php echo isset($axSql['size']) ? $axSql['size'] : '';?></p>
            </div>
            </div>
				  </div>

          <div class="row">	
          <div class="col-md-6">
            <div class="callout callout-warning">
            <h5>Power Consumption (Watt)</h5>
            <p><?php echo isset($axSql['power_consumption']) ? $axSql['power_consumption'] : '';?></p>
            </div>
            </div>
            <div class="col-md-6">
            <div class="callout callout-warning">
            <h5>Owner</h5>
            <p><?php echo isset($axSql['owner']) ? $axSql['owner'] : '';?></p>
            </div>
            </div>
				  </div>

          <?php 
          $as_approve = $oDB->QueryOne("SELECT status_approve FROM tbl_register_approve WHERE id='".$sID."' ");
          if ($as_approve=='R') {
          ?>
            <div class="row">	
            <div class="col-md-12">
              <div class="callout callout-danger">
              <h5>Reject Massage</h5>
              <p><?php echo isset($axSql['reject_massage']) ? $axSql['reject_massage'] : '';?></p>
              </div>
              </div>
            </div>
            <?php } ?>
          
            <div class="row">	
          <div class="col-md-6">
            <div class="callout callout-success">
            <h5>Group Approve</h5>
            <p class="info-box-number"><?php echo isset($axSql['groupapprove']) ? $axSql['groupapprove'] : '';?></p>
            </div>
            </div>
            <div class="col-md-6">
            <div class="callout callout-success">
            <h5>Approver</h5>
            <?php if ($axSql['approver']) { ?>
            <span class="info-box-number"><i class="fas fa-user"></i><?php echo ' '.$axSql['approver']. ' <i style="margin-left: 10px;" class="fas fa-clock"></i> ' .$axSql['approve_date'];?></span>
            <?php }else{ ?>
              <p><?php echo "N/A";?></p>
              <?php } ?>
            </div>
            </div>
				  </div>

            <div class="row">	
            <div class="col-md-6">
            <div class="info-box">
              <span class="info-box-icon bg-info"><i class="fas fa-user"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">User Request</span>
                <span class="info-box-number"><i class="fas fa-user"></i><?php echo ' '.$axSql['createuser']. ' <i style="margin-left: 10px;" class="fas fa-clock"></i> ' .$axSql['insert_date'];?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            </div>
            <div class="col-md-6">
            <div class="info-box">
              <span class="info-box-icon bg-info"><i class="fas fa-user"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">User Update</span>
                <?php if ($axSql['updateuser']) { ?> 
                <span class="info-box-number"><i class="fas fa-user"></i><?php echo ' '.$axSql['updateuser']. ' <i style="margin-left: 10px;" class="fas fa-clock"></i> ' .$axSql['update_date'];?></span>

                <?php }else{ ?>
                  <span class="info-box-number"><?php echo "N/A";?></span>
                <?php } ?>

              </div>
              <!-- /.info-box-content -->
            </div>
            </div>
            </div>

        </div>


          <!-- right column -->
          <div class="col-md-4">
          <div class="row">	
            <div class="col-md-12">
            <div class="card-body">
                <img class="img-fluid pad" src="./img/register.png" alt="Photo">
            </div>
					  </div>
				  </div>
          </div>

          <div class="col-md-12">
          <div class="card-footer">
          <!-- <button type="submit" class="btn btn-primary">Send To Approve</button>	 -->
          <!-- <input type="button" value="Save Draft" onClick="this.form.action='a.php'; submit()"> -->
          <!-- <input type="button" value="Save" onClick="this.form.action='b.php'; submit()"> -->
          
					<?php //if ($action != 'add') { ?>
					<!-- <input name="du_id" type="hidden" id="du_id" value="1" /> -->
					<?php // } ?>
					<input name="act" type="hidden" id="act" value="update" />
					</div>
          </div>

          

        </div>
        <!-- /.row -->
      </form>  
      </div><!-- /.container-fluid -->
    </section>
    
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

    <!-- Footer-->
    <?php include("../formpage/l_footer.php"); ?>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../alte/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../alte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../alte/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../alte/dist/js/demo.js"></script>

<!-- Script ตาราง -->
<script src="../alte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../alte/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../alte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../alte/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../alte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../alte/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../alte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../alte/plugins/jszip/jszip.min.js"></script>
<script src="../alte/plugins/pdfmake/pdfmake.min.js"></script>
<script src="../alte/plugins/pdfmake/vfs_fonts.js"></script>
<script src="../alte/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../alte/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../alte/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<!-- Toastr -->
<script src="../alte/plugins/toastr/toastr.min.js"></script>

	<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "pageLength": 20,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "pageLength": 20,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>

<script type="text/javascript">
    function alertSuccess(massage,url){  
		  toastr.options = {"timeOut": "1000"} ;
        $(function() {
          toastr.options.onHidden = function(){
            window.location.href = url;
          }
          toastr.success(massage,'Success')
        })
  }
  function alertError(massage){  
		  toastr.options = {"timeOut": "1000"} ;
          toastr.error(massage,'Error')
  }
</script>
<?php

if($sACT=='update') {

$_POST['du1_insert_date'] = 'SYSDATE()';
$_POST['du1_user_insert'] = $sUserID;
$Assetcode ='Asset Code : '. $_POST['du1_asset_code'];
$SAP_ID = $_POST['du1_sap_id'];

// $oData = new DBDataUpdater($oDB, $oTable);
// $oData->ReadFrom($_POST);

$asSetData = array();
foreach($_POST as $sKey => $sVal) {
  if ((substr($sKey, 0, 4) == 'du1_') && ($sVal != '')) {
    $sKey = substr($sKey, 4);
    $asSetData[$sKey] = $sVal;
  }
}

  $sField = '';
  $sValue = '';
  foreach ($asSetData as $sKey => $sVal) {
    if (in_array($sKey, array('insert_date'))) {
      $sValue .= $sVal.',';
    } else {
      $sValue .= '\''.$sVal.'\',';
    }
    $sField .= $sKey.',';
  }
   $sField = substr($sField, 0, -1);
   $sValue = substr($sValue, 0, -1);
   //$sSql1 = "INSERT INTO tbl_equipment (".$sField.") VALUES (".$sValue.")";
   //$query = mysqli_query($con, $sSql1);

   $inSql = "INSERT INTO tbl_register_approve (".$sField.") VALUES (".$sValue.")";
   if ($oDB->Execute($inSql)){

    $inSql2 = "INSERT INTO tbl_job_activity (user_insert, sap_id, workflow, activity, title, involved_person) VALUES ($sUserID,'$SAP_ID','1','2', '$Assetcode','140')";
    $oDB->Execute($inSql2) ;
 
    $UpdateSql = "UPDATE tbl_equipment_draft SET status_draft = 'W' WHERE id=".$sID;
    $oDB->Execute($UpdateSql) ;
  
    echo '
    <script type="text/javascript">
    alertSuccess("Sent To Approve Data","equipment_list.php")
    </script>
    ';
  //  Redirect('equipment_list.php');
   }else{
    echo '
    <script type="text/javascript">
    alertError("Error Sent To Approve Data")
    </script>
    ';
   }
}

?>

</body>
</html>
