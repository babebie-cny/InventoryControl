<?php
 include("../include/config.php"); 
 include("../include/common.php"); 

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

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>General Form</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">General Form</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          
          <div class="col-md-6">
          <div class="row">	
            <div class="col-md-12">
            <div class="card-body">
                <img class="img-fluid pad" src="./img/register.png" width="80%" height="80%" alt="Photo">
            </div>
					  </div>
				  </div>
          <div class="row">	
            <div class="col-md-12">
              <div class="form-group">
                  <label>User Name</label>
                  <input type="text" name="du_user" id="du_user" value="<?php echo base64_decode(isset($asData['user']) ? $asData['user'] : '');?>" class="form-control" placeholder="User ..." required>
              </div>
					</div>
				  </div>
          <div class="row">	
            <div class="col-md-12">
              <div class="form-group">
                  <label>User Name</label>
                    <input type="text" name="du_user" id="du_user" value="<?php echo base64_decode(isset($asData['user']) ? $asData['user'] : '');?>" class="form-control" placeholder="User ..." required>
              </div>
					  </div>
				  </div>

          </div>

          <!-- right column -->
          <div class="col-md-6">
          <div class="row">	
            <div class="col-md-12">
              <div class="form-group">
                <label>User Name</label>
                <input type="text" name="du_user" id="du_user" value="<?php echo base64_decode(isset($asData['user']) ? $asData['user'] : '');?>" class="form-control" placeholder="User ..." required>
              </div>
					  </div>
				  </div>
          <div class="row">	
            <div class="col-md-12">
              <div class="form-group">
                <label>User Name</label>
                <input type="text" name="du_user" id="du_user" value="<?php echo base64_decode(isset($asData['user']) ? $asData['user'] : '');?>" class="form-control" placeholder="User ..." required>
              </div>
					    </div>
				    </div>
          </div>

        </div>
        <!-- /.row -->
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
