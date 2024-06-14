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
                <h3 class="card-title">Register Equipment Draft</h3>
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
        <div class="col-md-6">
            <div class="callout callout-warning">
            <h5>Sad ID</h5>
            <p><?php echo $_REQUEST['du_sap_id'];?><input type="hidden" name="du1_sap_id" id="du1_sap_id" value="<?php echo $_REQUEST['du_sap_id'];?>" ></p>
            </div>
            </div>
            <div class="col-md-6">
            <div class="callout callout-warning">
            <h5>Group Equipment</h5>
            <p><?php echo $_REQUEST['du_group_equipment'];?><input type="hidden" name="du1_group_equipment" id="du1_group_equipment" value="<?php echo $_REQUEST['du_group_equipment'];?>" ></p>
            </div>
            </div>
            </div>

            <div class="row">
            <div class="col-md-6">
            <div class="callout callout-warning">
            <h5>Name</h5>
            <p><?php echo $_REQUEST['du_name'];?><input type="hidden" name="du1_name" id="du1_name" value="<?php echo $_REQUEST['du_name'];?>" ></p>
            </div>
            </div>
            <div class="col-md-3">
            <div class="callout callout-warning">
            <h5>Serial Code</h5>
            <p><?php echo $_REQUEST['du_serial_code'];?><input type="hidden" name="du1_serial_code" id="du1_serial_code" value="<?php echo $_REQUEST['du_serial_code'];?>" ></p>
            </div>
            </div>
            <div class="col-md-3">
            <div class="callout callout-warning">
            <h5>Asset Code</h5>
            <p><?php echo $_REQUEST['du_asset_code'];?><input type="hidden" name="du1_asset_code" id="du1_asset_code" value="<?php echo $_REQUEST['du_asset_code'];?>" ></p>
            </div>
            </div>
            </div>
		
        <div class="row">
            <div class="col-md-4">
            <div class="callout callout-warning">
            <h5>Model</h5>
            <p><?php echo $_REQUEST['du_model'];?><input type="hidden" name="du1_model" id="du1_model" value="<?php echo $_REQUEST['du_model'];?>" ></p>
            </div>
            </div>
            <div class="col-md-4">
            <div class="callout callout-warning">
            <h5>Buildings</h5>
            <p><?php echo $_REQUEST['du_building_id'];?><input type="hidden" name="du1_building_id" id="du1_building_id" value="<?php echo $_REQUEST['du_building_id'];?>" ></p>
            </div>
            </div>
            <div class="col-md-4">
            <div class="callout callout-warning">
            <h5>Floor</h5>
            <p><?php echo $_REQUEST['du_floor_id'];?><input type="hidden" name="du1_floor_id" id="du1_floor_id" value="<?php echo $_REQUEST['du_floor_id'];?>" ></p>
            </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
            <div class="callout callout-warning">
            <h5>Room</h5>
            <p><?php echo $_REQUEST['du_room_id'];?><input type="hidden" name="du1_room_id" id="du1_room_id" value="<?php echo $_REQUEST['du_room_id'];?>" ></p>
            </div>
            </div>
            <div class="col-md-4">
            <div class="callout callout-warning">
            <h5>Rack</h5>
            <p><?php echo $_REQUEST['du_rack_id'];?><input type="hidden" name="du1_rack_id" id="du1_rack_id" value="<?php echo $_REQUEST['du_rack_id'];?>" ></p>
            </div>
            </div>
            <div class="col-md-4">
            <div class="callout callout-warning">
            <h5>Size</h5>
            <p><?php echo $_REQUEST['du_size'];?><input type="hidden" name="du1_size" id="du1_size" value="<?php echo $_REQUEST['du_size'];?>" ></p>
            </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
            <div class="callout callout-warning">
            <h5>Power</h5>
            <p><?php echo $_REQUEST['du_power'];?><input type="hidden" name="du1_power" id="du1_power" value="<?php echo $_REQUEST['du_power'];?>" ></p>
            </div>
            </div>
            <div class="col-md-4">
            <div class="callout callout-warning">
            <h5>Consumption</h5>
            <p><?php echo $_REQUEST['du_consumption'];?><input type="hidden" name="du1_consumption" id="du1_consumption" value="<?php echo $_REQUEST['du_consumption'];?>" ></p>
            </div>
            </div>
            <div class="col-md-4">
            <div class="callout callout-warning">
            <h5>Price</h5>
            <p><?php echo $_REQUEST['du_price'];?><input type="hidden" name="du1_price" id="du1_price" value="<?php echo $_REQUEST['du_price'];?>" ></p>
            </div>
            </div>
        </div>

        <div class="row">
        <div class="col-md-6">
            <div class="callout callout-warning">
            <h5>Owner</h5>
            <p><?php echo $_REQUEST['du_owner'];?><input type="hidden" name="du1_owner" id="du1_owner" value="<?php echo $_REQUEST['du_owner'];?>" ></p>
            </div>
            </div>
            <div class="col-md-6">
            <div class="callout callout-warning">
            <h5>Equipment</h5>
            <p><?php echo $_REQUEST['du_equipment_owner'];?><input type="hidden" name="du1_equipment_owner" id="du1_equipment_owner" value="<?php echo $_REQUEST['du_equipment_owner'];?>" ></p>
            </div>
            </div>
        </div>
        
<?php        

?>


		<!--Second Half-->			
		</div>  <!--Div Row-->

          <div class="card-footer">
          <button type="submit" class="btn btn-primary">Save</button>	
          <!-- <button type="submit" class="btn btn-success">Save</button>	 -->
          <!-- <input type="button" value="Save Draft" onClick="this.form.action='a.php'; submit()"> -->
          <!-- <input type="button" value="Save" onClick="this.form.action='b.php'; submit()"> -->
          
					<?php //if ($action != 'add') { ?>
					<!-- <input name="du_id" type="hidden" id="du_id" value="1" /> -->
					<?php// } ?>
					<input name="act" type="hidden" id="act" value="add1" />
					</div>
					
<?php

if($sACT=='add1') {

$_POST['du1_insert_date'] = 'SYSDATE()';
$_POST['du1_user_insert'] = $sUserID;

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
   $sSql1 = "INSERT INTO tbl_equipment_draft (".$sField.") VALUES (".$sValue.")";
   $query = mysqli_query($con, $sSql1);
   redirect("request_register_draft_list.php");

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
