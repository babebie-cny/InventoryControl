<?php
 include("../include/config.php"); 
 include("../include/common.php"); 

$sUserID = isset($_SESSION['au_member_id']) ? $_SESSION['au_member_id'] : '';
$sACT =  isset($_REQUEST['act']) ? $_REQUEST['act'] : '';

$sStatus = isset($_REQUEST['status']) ? $_REQUEST['status'] : '';
$sID =  isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
$eID =  isset($_REQUEST['sid']) ? $_REQUEST['sid'] : '';

$oDB = new DBI();

if ($sUserID) {
	$dataUserinfo = $oDB->QueryRow("SELECT * FROM tbl_user_login WHERE id='".$sUserID."'", DBI_ASSOC);
	$dataUserinfo['pic_url'] = USERIMG_URL.$dataUserinfo['picture'];
}

$axSql = $oDB->QueryRow("SELECT * FROM tbl_equipment_sap WHERE id='".$eID."' ", DBI_ASSOC);
//$axSql['pic_url'] = USERIMG_URL.$axSql['picture'];

$axSql_group_equipment= $oDB->Query("SELECT * FROM tbl_group_equipment"); 
while ($asResult = $axSql_group_equipment->FetchRow(DBI_ASSOC)) {
  $asGroupEquipment[] = $asResult ;
}

$axSql_equipment_name= $oDB->Query("SELECT * FROM tbl_equipment_name"); 
while ($asResult = $axSql_equipment_name->FetchRow(DBI_ASSOC)) {
  $asEquipmentName[] = $asResult ;
}

$axSql_building= $oDB->Query("SELECT * FROM tbl_building"); 
while ($asResult = $axSql_building->FetchRow(DBI_ASSOC)) {
  $asBuilding[] = $asResult ;
}

$axSql_floor= $oDB->Query("SELECT * FROM tbl_floor"); 
while ($asResult = $axSql_floor->FetchRow(DBI_ASSOC)) {
  $asFloor[] = $asResult ;
}

$axSql_room= $oDB->Query("SELECT * FROM tbl_room"); 
while ($asResult = $axSql_room->FetchRow(DBI_ASSOC)) {
  $asRoom[] = $asResult ;
}

$axSql_rack= $oDB->Query("SELECT * FROM tbl_rack"); 
while ($asResult = $axSql_rack->FetchRow(DBI_ASSOC)) {
  $asRack[] = $asResult ;
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

  <!--Bootsratp icon -->
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
            <h1>Register Equipment Form</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Register Equipment Form</li>
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
            <div class="col-md-6">
              <div class="form-group">
                  <label>SAP ID</label>
                  <input type="input" name="du_sap_id" id="du_sap_id"   value="<?php echo isset($axSql['id']) ? $axSql['id'] : '';?>" class="form-control" placeholder="SAP ID..." readonly>
              </div>
					</div>
            <div class="col-md-6">
              <div class="form-group">
                  <label>Asset Code</label>
                  <input type="input" name="du_asset_code" id="du_asset_code" value="<?php echo isset($axSql['asset']) ? $axSql['asset'] : '';?>" class="form-control" placeholder="Asset Code..." readonly>
              </div>
					</div>

				  </div>

          <div class="row">	
          <div class="col-md-6">
              <div class="form-group">
                  <label>Group Equipment</label>
                  <select class="form-control" name="du_group_equipment_id" id="du_group_equipment_id">
                    <option>Choose Group Equipment</option>
                    <?php foreach($asGroupEquipment as $sGroupEquipment) { ?>    
                    <option value="<?php echo $sGroupEquipment['id'] ?>"><?php echo $sGroupEquipment['class_name'] ?></option>
                <?php } ?>    
                  </select>
              </div>
					  </div>
            <div class="col-md-6">
              <div class="form-group">
                  <label>Serial Code</label>
                  <input type="input" name="du_serial_code" id="du_serial_code"   value="<?php echo isset($axSql['serial_no']) ? $axSql['serial_no'] : '';?>" class="form-control" placeholder="Serial No..." re>
              </div>
					  </div>
				  </div>

          <div class="row">	
          <div class="col-md-6">
              <div class="form-group">
                  <label>Exiting Asset</label>
                  <input type="input" name="du_owner" id="du_owner"   value="<?php echo isset($axSql['owner']) ? $axSql['owner'] : '';?>" class="form-control" placeholder="Exiting Asset..." re>
              </div>
					</div>
            <div class="col-md-6">
              <div class="form-group">
                  <label>Model</label>
                  <input type="input" name="du_model" id="du_model"   value="<?php echo isset($axSql['model']) ? $axSql['model'] : '';?>" class="form-control" placeholder="Model..." re>
              </div>
					  </div>
				  </div>

          <div class="row">	
            <div class="col-md-6">
              <div class="form-group">
                  <label>Building</label>
                  <select class="form-control" name="du_building_id" id="du_building_id">
                    <option>Choose Building</option>
                    <?php foreach($asBuilding as $sBuilding) { ?>    
                    <option value="<?php echo $sBuilding['id'] ?>"><?php echo $sBuilding['building_name'] ?></option>
                <?php } ?>    
                  </select>
              </div>
					</div>
            <div class="col-md-6">
              <div class="form-group">
                  <label>Floor</label>
                  <select class="form-control" name="du_floor_id" id="du_floor_id">
                    <option>Choose Floor</option>
                    <?php foreach($asFloor as $sFloor) { ?>    
                    <option value="<?php echo $sFloor['id'] ?>"><?php echo $sFloor['floor_name'] ?></option>
                <?php } ?>    
                  </select>
              </div>
					  </div>
				  </div>

          <div class="row">	
            <div class="col-md-6">
              <div class="form-group">
                  <label>Room</label>
                  <select class="form-control" name="du_room_id" id="du_room_id">
                    <option>Choose Room</option>
                    <?php foreach($asRoom as $sRoom) { ?>    
                    <option value="<?php echo $sRoom['id'] ?>"><?php echo $sRoom['room_name'] ?></option>
                <?php } ?>    
                  </select>
              </div>
					</div>
            <div class="col-md-6">
              <div class="form-group">
                  <label>Rack</label>
                  <select class="form-control" name="du_rack_id" id="du_rack_id">
                    <option>Choose Rack</option>
                    <?php foreach($asRack as $sRack) { ?>    
                    <option value="<?php echo $sRack['id'] ?>"><?php echo $sRack['rack_name'] ?></option>
                <?php } ?>    
                  </select>
              </div>
					  </div>
				  </div>

          <div class="row">	
            <div class="col-md-6">
              <div class="form-group">
                  <label>Size</label>
                  <input type="input" name="du_size" id="du_size"   value="<?php echo isset($axSql['size']) ? $axSql['size'] : '';?>" class="form-control" placeholder="Size..." re>
              </div>
					</div>
            <div class="col-md-6">
              <div class="form-group">
                  <label>Power Consumption</label>
                  <input type="input" name="du_power_consumption" id="du_power_consumption"   value="<?php echo isset($axSql['power_consumption']) ? $axSql['power_consumption'] : '';?>" class="form-control" placeholder="Power Consumption..." re>
              </div>
					  </div>
				  </div>

          <div class="row">	
            <div class="col-md-6">
              <div class="form-group">
                  <label>Acq Value Balance</label>
                  <input type="input" name="du_acq_value_balance" id="du_acq_value_balance"   value="<?php echo isset($axSql['acq_value_balance']) ? $axSql['acq_value_balance'] : '';?>" class="form-control" placeholder="Acq Value Balance..." re>
              </div>
					</div>
            <div class="col-md-6">
              <div class="form-group">
                  <label>Netbk.Val FYE</label>
                  <input type="input" name="du_netbk_val_fye" id="du_netbk_val_fye"   value="<?php echo isset($axSql['netbk_val_fye']) ? $axSql['netbk_val_fye'] : '';?>" class="form-control" placeholder="Netbk.Val FYE..." re>
              </div>
					  </div>
				  </div>

          <div class="row">	
            <div class="col-md-6">
              <div class="form-group">
                  <label>Owner SAP</label>
                  <input type="input" name="du_owner" id="du_owner"   value="<?php echo isset($axSql['owner']) ? $axSql['owner'] : '';?>" class="form-control" placeholder="Owner..." re>
              </div>
					</div>
				  </div>         
          </div>


          <!-- right column -->
          <div class="col-md-4">
          <div class="row">	
            <div class="col-md-12 d-none d-sm-none d-md-none d-lg-block">
            <div class="form-group">
                <img class="img-fluid pad rounded shadow" src="./img/register.png" alt="Photo">
					  </div>
            </div>
            </div>
          </div>

          <div class="col-md-12">
          <div class="card-footer">
          <div class="row">
          <div class="col-md-4 col-lg-2 col-sm-12">
          <button type="submit" class="btn btn-success btn-block mr-1 my-1" onClick="this.form.action='register_form_confirm.php'"><i class="bi bi-check-square"></i> Save Equipment Data</button>
          </div>
          <div class="col-md-4 col-lg-2 col-sm-12">	
          <button type="submit" class="btn btn-danger btn-block mr-1 my-1"><i class="bi bi-x-square"></i> Cancel</button>	
          </div>
          <div class="col-md-4 col-lg-2 col-sm-12">
          <!-- <button type="button" class="btn btn-primary btn-block mr-1 my-1"><i class="bi bi-save"></i> Draft Equipment Data</button>	 -->
          </div>
        
          <!-- <input type="button" value="Save Draft" onClick="this.form.action='a.php'; submit()"> -->
          <!-- <input type="button" value="Save" onClick="this.form.action='b.php'; submit()"> -->
          </div>
					<?php //if ($action != 'add') { ?>
					<!-- <input name="du_id" type="hidden" id="du_id" value="1" /> -->
					<?php // } ?>
					<input name="act" type="hidden" id="act" value="add" />
					</div>
          </div>

          <?php

if($sACT=='add') {

$_POST['du_insert_date'] = 'SYSDATE()';
$_POST['du_user_insert'] = $sUserID;

// $oData = new DBDataUpdater($oDB, $oTable);
// $oData->ReadFrom($_POST);

$asSetData = array();
foreach($_POST as $sKey => $sVal) {
  if ((substr($sKey, 0, 3) == 'du_') && ($sVal != '')) {
    $sKey = substr($sKey, 3);
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
   $inSql = "INSERT INTO tbl_equipment_draft (".$sField.") VALUES (".$sValue.")";
   $oDB->Execute($inSql);
   
}

?>
          

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

</body>
</html>
