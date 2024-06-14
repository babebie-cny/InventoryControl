<?php
 include("../include/config.php"); 
 include("../include/common.php"); 

 CheckUserLogin_Fornt();
 
$sUserID = isset($_SESSION['au_member_id']) ? $_SESSION['au_member_id'] : '';
$sACT =  isset($_REQUEST['act']) ? $_REQUEST['act'] : '';

$sStatus = isset($_REQUEST['status']) ? $_REQUEST['status'] : '';
$sID =  isset($_REQUEST['id']) ? $_REQUEST['id'] : '';

$oDB = new DBI();

if ($sUserID) {
	$dataUserinfo = $oDB->QueryRow("SELECT * FROM tbl_user_login WHERE id='".$sUserID."'", DBI_ASSOC);
	$dataUserinfo['pic_url'] = USERIMG_URL.$dataUserinfo['picture'];
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

<?php 		
if ($sACT=='view'){
	//$sql = "SELECT * FROM tbl_equipment_sap WHERE id=" .$sID or die("Error:" . mysqli_error());
	$axSql = $oDB->QueryRow("SELECT * FROM tbl_equipment_sap WHERE id=" .$sID, DBI_ASSOC);
	//$axSql['pic_url'] = USERIMG_URL.$axSql['picture'];
}
?>
    
    <!-- Main content รายละเอียด-->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <!-- Default box -->
            <div class="card">

              <div class="card-header">
                <h3 class="card-title">Equipment SAP Detail</h3> 

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <!-- <i class="fas fa-minus"></i> -->
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                    <!-- <i class="fas fa-times"></i> -->
                  </button>
                </div>
              </div>

              <div class="card-body">

              <div class="row">
            <div class="col-md-6">
            <div class="callout callout-success">
            <h5>Company Code</h5>
            <p><?php echo isset($axSql['companycode']) ? $axSql['companycode'] : '';?></p>
            </div>
            </div>
            <div class="col-md-6">
            <div class="callout callout-success">
            <h5>Asset Class</h5>
            <p><?php echo isset($axSql['assetclass']) ? $axSql['assetclass'] : '';?></p>
            </div>
            </div>
            </div>

            <div class="row">
            <div class="col-md-6">
            <div class="callout callout-success">
            <h5>Asset Class Name</h5>
            <p><?php echo isset($axSql['assetclass_name']) ? $axSql['assetclass_name'] : '';?></p>
            </div>
            </div>
            <div class="col-md-6">
            <div class="callout callout-success">
            <h5>Asset</h5>
            <p><?php echo isset($axSql['asset']) ? $axSql['asset'] : '';?></p>
            </div>
            </div>            
            </div>

            <div class="row">
            <div class="col-md-6">
            <div class="callout callout-success">
            <h5>Subnumber</h5>
            <p><?php echo isset($axSql['subnumber']) ? $axSql['subnumber'] : '';?></p>
            </div>
            </div>
            <div class="col-md-6">
            <div class="callout callout-success">
            <h5>Serial No</h5>
            <p><?php echo isset($axSql['serial_no']) ? $axSql['serial_no'] : '';?></p>
            </div>
            </div>
            </div>

            <div class="row">
            <div class="col-md-6">
            <div class="callout callout-success">
            <h5>Base_UOM</h5>
            <p><?php echo isset($axSql['base_uom']) ? $axSql['base_uom'] : '';?></p>
            </div>
            </div>
            <div class="col-md-6">
            <div class="callout callout-success">
            <h5>Description 1</h5>
            <p><?php echo isset($axSql['descript1']) ? $axSql['descript1'] : '';?></p>
            </div>
            </div>
            </div>

            <div class="row">
            <div class="col-md-6">
            <div class="callout callout-success">
            <h5>Manufacturer</h5>
            <p><?php echo isset($axSql['manufacturer']) ? $axSql['manufacturer'] : '';?></p>
            </div>
            </div>
            <div class="col-md-6">
            <div class="callout callout-success">
            <h5>Note</h5>
            <p><?php echo isset($axSql['note']) ? $axSql['note'] : '';?></p>
            </div>
            </div>
            </div>

            <div class="row">
            <div class="col-md-6">
            <div class="callout callout-success">
            <h5>Quantity</h5>
            <p><?php echo isset($axSql['quantity']) ? $axSql['quantity'] : '-';?></p>
            </div>
            </div>
            <div class="col-md-6">
            <div class="callout callout-success">
            <h5>Inventory No</h5> 
            <p><?php echo isset($axSql['invent_no']) ? $axSql['invent_no'] : '';?></p>
            </div>
            </div>
            </div>

            <div class="row">
            <div class="col-md-6">
            <div class="callout callout-success">
            <h5>Initial ACQ</h5>
            <p><?php echo isset($axSql['initial_acq']) ? $axSql['initial_acq'] : '-';?></p>
            </div>
            </div>
            <div class="col-md-6">
            <div class="callout callout-success">
            <h5>Cap Date</h5>
            <p><?php echo isset($axSql['cap_date']) ? $axSql['cap_date'] : '';?></p>
            </div>
            </div>
            </div>

            <div class="row">
            <div class="col-md-6">
            <div class="callout callout-success">
            <h5>Cost Center</h5>
            <p><?php echo isset($axSql['costcenter']) ? $axSql['costcenter'] : '';?></p>
            </div>
            </div>
            <div class="col-md-6">
            <div class="callout callout-success">
            <h5>Deact Date</h5> 
            <p><?php echo isset($axSql['deact_date']) ? $axSql['deact_date'] : '';?></p>
            </div>
            </div>
            </div>

            <div class="row">
            <div class="col-md-6">
            <div class="callout callout-success">
            <h5>Employee ID</h5>
            <p><?php echo isset($axSql['employee_id']) ? $axSql['employee_id'] : '';?></p>
            </div>
            </div>
            <div class="col-md-6">
            <div class="callout callout-success">
            <h5>Room</h5>
            <p><?php echo isset($axSql['room']) ? $axSql['room'] : '';?></p>
            </div>
            </div>
            </div>

            <div class="row">
            <div class="col-md-6">
            <div class="callout callout-success">
            <h5>Location</h5> 
            <p><?php echo isset($axSql['location']) ? $axSql['location'] : '';?></p>
            </div>
            </div>
            <div class="col-md-6">
            <div class="callout callout-success">
            <h5>Location Name</h5>
            <p><?php echo isset($axSql['location_name']) ? $axSql['location_name'] : '';?></p>
            </div>
            </div>
            </div>

            <div class="row">
            <div class="col-md-6">
            <div class="callout callout-success">
            <h5>Fund</h5>
            <p><?php echo isset($axSql['fund']) ? $axSql['fund'] : '';?></p>
            </div>
            </div>
            <div class="col-md-6">
            <div class="callout callout-success">
            <h5>Funds CTR</h5> 
            <p><?php echo isset($axSql['funds_ctr']) ? $axSql['funds_ctr'] : '';?></p>
            </div>
            </div>
            </div>

            <div class="row">
            <div class="col-md-2">
            <div class="callout callout-success">
            <h5>Person No</h5>
            <p><?php echo isset($axSql['person_no']) ? $axSql['person_no'] : '';?></p>
            </div>
            </div>
            <div class="col-md-5">
            <div class="callout callout-success">
            <h5>Name</h5> 
            <p><?php echo isset($axSql['name']) ? $axSql['name'] : '';?></p>
            </div>
            </div>
            <div class="col-md-5">
            <div class="callout callout-success">
            <h5>Surname</h5>
            <p><?php echo isset($axSql['surname']) ? $axSql['surname'] : '';?></p>
            </div>
            </div>
            </div>

            <div class="row">
            <div class="col-md-6">
            <div class="callout callout-success">
            <h5>EVAL Group 1</h5> 
            <p><?php echo isset($axSql['evalgroup1']) ? $axSql['evalgroup1'] : '';?></p>
            </div>
            </div>
            <div class="col-md-6">
            <div class="callout callout-success">
            <h5>EVAL Group1 Name</h5>
            <p><?php echo isset($axSql['evalgroup1_name']) ? $axSql['evalgroup1_name'] : '';?></p>
            </div>
            </div>
            </div>

            <div class="row">
            <div class="col-md-6">
            <div class="callout callout-success">
            <h5>EVAL Group 2</h5> 
            <p><?php echo isset($axSql['evalgroup2']) ? $axSql['evalgroup2'] : '';?></p>
            </div>
            </div>
            <div class="col-md-6">
            <div class="callout callout-success">
            <h5>EVAL Group2 Name</h5>
            <p><?php echo isset($axSql['evalgroup2_name']) ? $axSql['evalgroup2_name'] : '';?></p>
            </div>
            </div>
            </div>

            <div class="row">
            <div class="col-md-6">
            <div class="callout callout-success">
            <h5>EVAL Group 3</h5> 
            <p><?php echo isset($axSql['evalgroup3']) ? $axSql['evalgroup3'] : '';?></p>
            </div>
            </div>
            <div class="col-md-6">
            <div class="callout callout-success">
            <h5>EVAL Group3 Name</h5>
            <p><?php echo isset($axSql['evalgroup3_name']) ? $axSql['evalgroup3_name'] : '';?></p>
            </div>
            </div>
            </div>

            <div class="row">
            <div class="col-md-6">
            <div class="callout callout-success">
            <h5>EVAL Group 4</h5> 
            <p><?php echo isset($axSql['evalgroup4']) ? $axSql['evalgroup4'] : '';?></p>
            </div>
            </div>
            <div class="col-md-6">
            <div class="callout callout-success">
            <h5>EVAL Group4 Name</h5>
            <p><?php echo isset($axSql['evalgroup4_name']) ? $axSql['evalgroup4_name'] : '';?></p>
            </div>
            </div>
            </div>

            <div class="row">
            <div class="col-md-6">
            <div class="callout callout-success">
            <h5>EVAL Group 5</h5> 
            <p><?php echo isset($axSql['evalgroup5']) ? $axSql['evalgroup5'] : '';?></p>
            </div>
            </div>
            <div class="col-md-6">
            <div class="callout callout-success">
            <h5>EVAL Group5 Name</h5>
            <p><?php echo isset($axSql['evalgroup5_name']) ? $axSql['evalgroup5_name'] : '';?></p>
            </div>
            </div>
            </div>

            <div class="row">
            <div class="col-md-4">
            <div class="callout callout-success">
            <h5>Vendor No</h5> 
            <p><?php echo isset($axSql['vendor_no']) ? $axSql['vendor_no'] : '';?></p>
            </div>
            </div>
            <div class="col-md-8">
            <div class="callout callout-success">
            <h5>Vendor Name</h5>
            <p><?php echo isset($axSql['vendor_name']) ? $axSql['vendor_name'] : '';?></p>
            </div>
            </div>
            </div>

            <div class="row">
            <div class="col-md-4">
            <div class="callout callout-success">
            <h5>ORIG Asset</h5> 
            <p><?php echo isset($axSql['orig_asset']) ? $axSql['orig_asset'] : '';?></p>
            </div>
            </div>
            <div class="col-md-4">
            <div class="callout callout-success">
            <h5>ORIG Asset SUBNO</h5>
            <p><?php echo isset($axSql['orig_asset_subno']) ? $axSql['orig_asset_subno'] : '';?></p>
            </div>
            </div>
            <div class="col-md-4">
            <div class="callout callout-success">
            <h5>ORIG ACQ Date</h5>
            <p><?php echo isset($axSql['orig_acq_date']) ? $axSql['orig_acq_date'] : '';?></p>
            </div>
            </div>
            </div>

            <div class="row">
            <div class="col-md-4">
            <div class="callout callout-success">
            <h5>ULIFE YRS</h5> 
            <p><?php echo isset($axSql['ulife_yrs']) ? $axSql['ulife_yrs'] : '';?></p>
            </div>
            </div>
            <div class="col-md-8">
            <div class="callout callout-success">
            <h5>ULIFE PRDS</h5>
            <p><?php echo isset($axSql['ulife_prds']) ? $axSql['ulife_prds'] : '';?></p>
            </div>
            </div>
            </div>

            <div class="card-footer">
					</div>
              </div>
              <!-- /.card-body -->

              
            </div>
            <!-- /.card -->
            

          </div>
        </div>
      </div>
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
