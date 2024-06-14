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
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Equipment SAP</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../alte/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../alte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../alte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../alte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="../alte/dist/css/adminlte.min.css">
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
        <div class="row">
          <div class="col-12">
            <!-- Default box -->
            <div class="card">
              <!-- /.card-header -->
              <div class="card-header">
                <h3 class="card-title">Equipment SAP List</h3>
              </div>
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                  <th>No</th>
                  <th>Company Code</th>
                  </tr>
                  </thead>
                  <tbody>
<?php
					  
$axSql= $oDB->Query("SELECT * FROM ted_nmr");
					$rownum= 1;			
			while($asResult = $axSql->FetchRow(DBI_ASSOC))   {
?>
					  
        <tr>
					  
          <td><?php echo $rownum;?></td>
          <td><?php echo $asResult["title"];?></td>
          <!-- <td><?php //echo $asResult["employee_id"];?></td> -->
					 <?php $rownum = $rownum+1; ?>
					  

        </tr>
<?php } ?>


                  </tbody>
                  <tfoot>
                  <tr>
                  <th>No</th>
                    <th>Company Code</th>
                  </tr>
                  </tfoot>
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
<script src="../alte/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
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
<script src="../alte/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../alte/dist/js/demo.js"></script>
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
