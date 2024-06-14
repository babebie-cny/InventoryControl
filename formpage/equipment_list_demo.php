<?php
error_reporting( error_reporting() & ~E_NOTICE );
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
  <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/plugins/fontawesome-free/css/all.min.css"> -->
  <!-- Theme style -->
  <!-- <link rel="stylesheet" href="../alte/dist/css/adminlte.min.css"> -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css">

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

    <!-- Main content รายละเอียด-->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">


            <!-- Default box -->
            <div class="card">

              <div class="card-header">
                <h3 class="card-title">Equipment List</h3> 

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
              <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                  <th>No</th>
                  <th>Equipment ID</th>
                  <th>Name</th>
                  <th>Serial Number</th>
                  <th>Asset Code</th>
                  <th>Building</th>
                  <th>Floor</th>
                  <th>QR Code</th>
                  <th>Check</th>
                  </tr>
                  </thead>
                  <tbody>					  
                  <tr>
                    <td>1</td>
                    <td>AULR220700001</td>
                    <td>Brdcst-A/VPatchPanel</td>
                    <td>ZIP-93014700108</td>
                    <td>008900003638</td>
                    <td>Tipco</td>
                    <td>Floor 4</td>
                    <td><a class="btn btn-app bg-secondary"><i class="fas fa-barcode"></i> QR Code</a></td>
                    <td><div class="form-check">
                                    <input class="form-check-input" type="checkbox">
                                  </div></td>
                  </tr>
                  <tr>
                    <td>2</td>
                    <td>LERI220700022</td>
                    <td>Brdcst-A/VPatchPanel</td>
                    <td>ZJ15090060</td>
                    <td>008900003642</td>
                    <td>Ramintra</td>
                    <td>Floor 5</td>
                    <td><a class="btn btn-app bg-secondary"><i class="fas fa-barcode"></i> QR Code</a></td>
                    <td><div class="form-check">
                                    <input class="form-check-input" type="checkbox">
                                  </div></td>
                  </tr>
                  <tr>
                    <td>3</td>
                    <td>VIDO220600017</td>
                    <td>Brdcst-A/VPatchPanel</td>
                    <td>YASY01010</td>
                    <td>008900003652</td>
                    <td>Tipco</td>
                    <td>Floor 6</td>
                    <td><a class="btn btn-app bg-secondary"><i class="fas fa-barcode"></i> QR Code</a></td>
                    <td><div class="form-check">
                                    <input class="form-check-input" type="checkbox">
                                  </div></td>
                  </tr>

                  </tbody>
                  <tfoot>
                  <tr>
                  <th>No</th>
                  <th>Equipment ID</th>
                  <th>Name</th>
                  <th>Serial Number</th>
                  <th>Asset Code</th>
                  <th>Building</th>
                  <th>Floor</th>
                  <th>QR Code</th>
                  <th>Check</th>
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
