<?php
 include("../include/config.php"); 
 include("../include/common.php"); 


$sACT = $_REQUEST['act'];
$sStatus = $_REQUEST['status'];
$sID =  isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
$eID =  isset($_REQUEST['sid']) ? $_REQUEST['sid'] : '';

$sql = "SELECT * FROM tbl_equipment_sap WHERE id=" .$eID or die("Error:" . mysqli_error());
//$sql = "SELECT * FROM tbl_equipment_sap WHERE id= 5 " or die("Error:" . mysqli_error());
$query = mysqli_query($con, $sql);
$asData = array();
while($result=mysqli_fetch_array($query, MYSQLI_ASSOC)) {

$asData = $result;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Equipment SAP</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="alte/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="alte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="alte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="alte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="alte/dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini sidebar-collapse">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="request_register_draft_list.php" class="nav-link">Draft List</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="equipment_list.php" class="nav-link">Equipment List</a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
      <div class="card-header">
                <h3 class="card-title">Register Equipment Form</h3>
              </div>
        <div class="row">
          <div class="col-12">
            <div class="card card-primary">
              <!-- /.card-header -->
              <!-- form start -->
              <form name="dataform" id="dataform" action="" method="post" enctype="multipart/form-data" >

        <div class="row">
        <div class="col-4">
		<!--First Half-->			
    <div class="card-body">
                <img class="img-fluid pad" src="./img/register.png" alt="Photo">
              </div>
					</div>

        <div class="col-8">
		<!--First Half-->			
        <div class="card-body">
        <div class="row">
        <div class="col-6">
            <div class="form-group">
              <label>SAD ID</label>
              <input type="input" name="du_sap_id" id="du_sap_id" <?php echo $d_email ?>  value="<?php echo isset($asData['sap_id']) ? $asData['sap_id'] : '';?>" class="form-control" placeholder="SAP ID..." re>
            </div>
            </div>
            <div class="col-6">
            <div class="form-group">
              <label>Group Equipment</label>
              <input type="input" name="du_group_equipment" id="du_group_equipment" <?php echo $d_email ?>  value="<?php echo isset($asData['group_equipment']) ? $asData['group_equipment'] : '';?>" class="form-control" placeholder="Group Equipment..." re>
            </div>
            </div>
            </div>

            <div class="row">
            <div class="col-6">
            <div class="form-group">
              <label>Name</label>
              <input type="input" name="du_name" id="du_name" <?php echo $d_email ?>  value="<?php echo isset($asData['name']) ? $asData['name'] : '';?>" class="form-control" placeholder="Name..." re>
            </div>
					</div>
          <div class="col-6">
            <div class="form-group">
              <label>Serial Code</label>
              <input type="input" name="du_serial_code" id="du_serial_code" <?php echo $d_email ?>  value="<?php echo isset($asData['serial_no']) ? $asData['serial_no'] : '';?>" class="form-control" placeholder="Serial No..." re>
            </div>
					</div>
        </div>
		
        <div class="row">
          <div class="col-6">
            <div class="form-group">
              <label>Asset Code</label>
              <input type="input" name="du_asset_code" id="du_asset_code" <?php echo $d_email ?>  value="<?php echo isset($asData['asset']) ? $asData['asset'] : '';?>" class="form-control" placeholder="Asset Code...">
            </div>
					</div>
          <div class="col-6">
            <div class="form-group">
              <label>Model</label>
              <input type="input" name="du_model" id="du_model" <?php echo $d_email ?>  value="<?php echo isset($asData['model']) ? $asData['model'] : '';?>" class="form-control" placeholder="Model..." re>
            </div>
					</div>
        </div>
		
        <div class="row">
          <div class="col-6">
            <div class="form-group">
              <label>Building</label>
              <input type="input" name="du_building_id" id="du_building_id" <?php echo $d_email ?>  value="<?php echo isset($asData['location_name']) ? $asData['location_name'] : '';?>" class="form-control" placeholder="Building..." re>
            </div>
					</div>
          <div class="col-6">
            <div class="form-group">
              <label>Floor</label>
              <input type="input" name="du_floor_id" id="du_floor_id" <?php echo $d_email ?>  value="<?php echo isset($asData['floor_id']) ? $asData['floor_id'] : '';?>" class="form-control" placeholder="Floor..." re>
            </div>
					</div>
        </div>

        <div class="row">
            <div class="col-6">
            <div class="form-group">
              <label>Room</label>
              <input type="input" name="du_room_id" id="du_room_id" <?php echo $d_email ?>  value="<?php echo isset($asData['room_id']) ? $asData['room_id'] : '';?>" class="form-control" placeholder="Room..." re>
            </div>
					</div>
          <div class="col-6">
            <div class="form-group">
              <label>Rack</label>
              <input type="input" name="du_rack_id" id="du_rack_id" <?php echo $d_email ?>  value="<?php echo isset($asData['rack_id']) ? $asData['rack_id'] : '';?>" class="form-control" placeholder="Rack..." re>
            </div>
					</div>
        </div>

        <div class="row">
          <div class="col-6">
            <div class="form-group">
              <label>Size</label>
              <input type="input" name="du_size" id="du_size" <?php echo $d_email ?>  value="<?php echo isset($asData['size']) ? $asData['size'] : '';?>" class="form-control" placeholder="Size..." re>
            </div>
					</div>
          <div class="col-6">
            <div class="form-group">
              <label>Power</label>
              <input type="input" name="du_power" id="du_power" <?php echo $d_email ?>  value="<?php echo isset($asData['power']) ? $asData['power'] : '';?>" class="form-control" placeholder="Power..." re>
            </div>
					</div>
        </div>

        <div class="row">
          <div class="col-6">
            <div class="form-group">
              <label>Consumption</label>
              <input type="input" name="du_consumption" id="du_consumption" <?php echo $d_email ?>  value="<?php echo isset($asData['consumption']) ? $asData['consumption'] : '';?>" class="form-control" placeholder="Consumption..." re>
            </div>
					</div>
          <div class="col-6">
            <div class="form-group">
              <label>Price</label>
              <input type="input" name="du_price" id="du_price" <?php echo $d_email ?>  value="<?php echo isset($asData['price']) ? $asData['price'] : '';?>" class="form-control" placeholder="Price..." re>
            </div>
					</div>
        </div>

        <div class="row">
            <div class="col-6">
            <div class="form-group">
              <label>Owner</label>
              <input type="input" name="du_owner" id="du_owner" <?php echo $d_email ?>  value="<?php echo isset($asData['owner']) ? $asData['owner'] : '';?>" class="form-control" placeholder="Owner..." re>
            </div>
					</div>
          <div class="col-6">
            <div class="form-group">
              <label>Equipment Owner</label>
              <input type="input" name="du_equipment_owner" id="du_equipment_owner" <?php echo $d_email ?>  value="<?php echo isset($asData['equipment_owner']) ? $asData['equipment_owner'] : '';?>" class="form-control" placeholder="Equipment Owner..." re>
            </div>
					</div>
        </div>
        
		<!--Second Half-->			
		</div>  <!--Div Row-->

          <div class="card-footer">
          <button type="submit" class="btn btn-primary" onClick="this.form.action='request_register_draft.php'">Draft Equipment Data</button>	
          <button type="submit" class="btn btn-success">Save Equipment Data</button>	
          <!-- <input type="button" value="Save Draft" onClick="this.form.action='a.php'; submit()"> -->
          <!-- <input type="button" value="Save" onClick="this.form.action='b.php'; submit()"> -->
          
					<?php //if ($action != 'add') { ?>
					<!-- <input name="du_id" type="hidden" id="du_id" value="1" /> -->
					<?php// } ?>
					<input name="act" type="hidden" id="act" value="add" />
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
   $sSql1 = "INSERT INTO tbl_equipment (".$sField.") VALUES (".$sValue.")";
   $query = mysqli_query($con, $sSql1);

}

?>

              </form>
              
          </div>
          </div>
        </div>
      </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.1.0
    </div>
    <strong>Copyright &copy; 2021-2022 <a href="https://adminlte.io"></a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="alte/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="alte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="alte/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="alte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="alte/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="alte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="alte/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="alte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="alte/plugins/jszip/jszip.min.js"></script>
<script src="alte/plugins/pdfmake/pdfmake.min.js"></script>
<script src="alte/plugins/pdfmake/vfs_fonts.js"></script>
<script src="alte/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="alte/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="alte/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="alte/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="alte/dist/js/demo.js"></script>
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
