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
  $dataUserinfo = $oDB->QueryRow("SELECT * FROM tbl_user_login WHERE id='" . $sUserID . "'", DBI_ASSOC);
  $dataUserinfo['pic_url'] = USERIMG_URL . $dataUserinfo['picture'];
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

  <!-- jQuery -->
  <script src="../alte/plugins/jquery/jquery.min.js"></script>
  <script src="js/table2excel.js"></script>
  <!-- <script src="js/jquery.table2excel.js"></script>
  <script src="js/jquery.table2excel.min.js" ></script> -->

</head>

<body id="body" class="hold-transition sidebar-mini sidebar-collapse">
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
      <?php //include("../formpage/l_head_sub.php"); 
      ?>

      <!-- Main content รายละเอียด-->
      <section id="content" class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">


              <!-- Default box -->
              <div class="card">

                <div class="card-header">
                  <h3 class="card-title">Rack Name List</h3>

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
                        <th>Building</th>
                        <th>Floor</th>
                        <th>Room</th>
                        <th>Rack Name</th>
                        <th>QR Code</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php

                      $axSql = $oDB->Query("SELECT * FROM tbl_rack WHERE approve_status='A' ORDER BY id ASC ");
                      $rownum = 1;
                      while ($asResult = $axSql->FetchRow(DBI_ASSOC)) {

                        // $asResult["rack_id"] = $oDB->QueryOne("SELECT rack_name FROM tbl_rack WHERE id='" . $asResult["rack_id"] . "' ");
                        $asResult["room"] = $oDB->QueryOne("SELECT room_name FROM tbl_room WHERE id='" . $asResult["room_id"] . "' ");
                        $asResult["floor_id"] = $oDB->QueryOne("SELECT floor_id FROM tbl_room WHERE id='" . $asResult["room_id"] . "' ");
                        $asResult["floor"] = $oDB->QueryOne("SELECT floor_name FROM tbl_floor WHERE id='" . $asResult["floor_id"] . "' ");
                        $asResult["building_id"] = $oDB->QueryOne("SELECT building_id FROM tbl_floor WHERE id='" . $asResult["floor_id"] . "' ");
                        $asResult["building"] = $oDB->QueryOne("SELECT building_name FROM tbl_building WHERE id='" . $asResult["building_id"] . "' ");
                      ?>

                        <tr>
                          <td><?php echo $rownum; ?></td>
                          <td><?php echo $asResult["building"]; ?></td>
                          <td><?php echo $asResult["floor"]; ?></td>
                          <td><?php echo $asResult["room"]; ?></td>
                          <td><?php echo $asResult["rack_name"]; ?></td>
                          <td>
                            <a href="download_qrcode_rack.php?act=view&id=<?php echo $asResult["id"]; ?>" class="btn btn-info btn-xs" data-bs-toggle="modal" data-bs-target="#downloadQR"><i class="fas fa-barcode"></i> Rack</a>
                          </td>
                          <?php $rownum = $rownum + 1; ?>

                        </tr>
                      <?php } ?>

                    </tbody>
                    <tfoot>
                      <tr>
                        <th>No</th>
                        <th>Building</th>
                        <th>Floor</th>
                        <th>Room</th>
                        <th>Rack Name</th>
                        <th>QR Code</th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
                <!-- /.card-body -->

              </div>
              <!-- /.card -->

              <!-- Modal -->

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
    $(function() {
      $("#example1").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "pageLength": 20,
        "buttons": ["csv", "excel", "pdf"]
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