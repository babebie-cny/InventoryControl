<?php
 include("../include/config.php"); 
 include("../include/common.php"); 

 $oDB = new DBI();
 
 if (isset($_GET['data'])) {
  $oLogin = new LoginManager();

  $encodedData = $_GET['data'];

  // ถอดรหัส Base64
  $decodedJsonData = base64_decode($encodedData);

  // ถอดรหัส JSON
  $data = json_decode($decodedJsonData, true); // true ทำให้ข้อมูลกลายเป็นอาร์เรย์แอสโซซิเอทีฟ

  $sUser = $data['userid'];
  $data_bsi = $oDB->QueryRow("SELECT * FROM tbl_user_login WHERE id='" . $sUser . "'", DBI_ASSOC);

	$sUser = $data_bsi['user'];
	$sPass = $data_bsi['pass'];

    $oLogin->SetDBConnection($oDB);
    if ($oLogin->Login($sUser, $sPass)) {

    } else {
      $oLogin->Logout();
    }
}

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

  <script src="../alte/plugins/jquery/jquery.min.js"></script>
  
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
    <section class="content">
      <div class="container-fluid"> 
        <div class="row">
          <div class="col-12">


            <!-- Default box -->
            <div class="card">

            <div class="card-header" style="display: flex; align-items: center; width: 100%;">
                <h3 class="card-title">Equipment SAP List</h3> 
                <div class="card-tools" style="margin-left: auto; margin-right: 1px;" >
                <a href="register_nonsap_form.php">
                    <button class="btn btn-block btn-success" >
                        <i class="fas fa-plus-circle" style="margin-right:5px"></i> Create Non SAP
                    </button>
                </a>    
                </div>
            </div>

              <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
              <thead>
						<tr>
              <th>No</th>
              <th>Asset</th>
							<th>Status</th>
							<th>Description1</th>
							<th>Manufacturer</th>
							<th>Serial No</th>
							<th>Room</th>
							<th>Location</th>
							<th>Location Name</th>
							<th>Name</th>
							<th>Sername</th>
						</tr>
					</thead>
                </table>
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
    $("#example12").DataTable({
      "responsive": true, "lengthChange": true, "autoWidth": false,
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
<script type="text/javascript" language="javascript" >
			$(document).ready(function() {
				var dataTable = $('#example1').DataTable( {
					"processing": true,
					"serverSide": true,
          "responsive": true, "lengthChange": true, "autoWidth": false, 'lengthMenu': [[25, 50, 75, -1], [25, 50, 75, 100]],
          // "pageLength": 20,
    			"ajax":{
						url :"sap_fetchdata.php", // json datasource
						type: "post",  // method  , by default get
						error: function(){  // error handling
							$(".movies-grid-error").html("");
							$("#movies-grid").append('<tbody class="movies-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
							$("#movies-grid_processing").css("display","none")
						}
					}
				});
			} );
		</script>

</body>
</html>
