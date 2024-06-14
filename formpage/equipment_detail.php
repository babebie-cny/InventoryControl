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
      <?php //include("../formpage/l_head_sub.php"); 
      ?>

      <?php
      if ($sACT == 'view') {
        $dataEquipment = $oDB->QueryRow("SELECT * FROM tbl_equipment WHERE id='" . $sID . "'", DBI_ASSOC);
        $dataEquipment['group_equipment'] = $oDB->QueryOne("SELECT class_name FROM tbl_group_equipment WHERE id=" . $dataEquipment['group_equipment_id'] . " ");
        $dataEquipment['building'] = $oDB->QueryOne("SELECT building_name FROM tbl_building WHERE id=" . $dataEquipment['building_id'] . " ");
        $dataEquipment['floor'] = $oDB->QueryOne("SELECT floor_name FROM tbl_floor WHERE id=" . $dataEquipment['floor_id'] . " ");
        $dataEquipment['room'] = $oDB->QueryOne("SELECT room_name FROM tbl_room WHERE id=" . $dataEquipment['room_id'] . " ");
        $dataEquipment['rack'] = $oDB->QueryOne("SELECT rack_name FROM tbl_rack WHERE id=" . $dataEquipment['rack_id'] . " ");
        $dataEquipment['groupapprove'] = $oDB->QueryOne("SELECT n1.au_name FROM tbl_authen n1 INNER JOIN tbl_equipment n2 WHERE n1.au_id=n2.group_approve AND n2.id= '" . $sID . "'  ");
        $dataEquipment['approver'] = $oDB->QueryOne("SELECT CONCAT(n2.firstname,' ',n2.lastname) FROM tbl_equipment n1 INNER JOIN tbl_user_login n2 WHERE n1.approver=n2.id AND n1.id= '" . $sID . "'  ");
        $dataEquipment['createuser'] = $oDB->QueryOne("SELECT CONCAT(n2.firstname,' ',n2.lastname) FROM tbl_equipment n1 INNER JOIN tbl_user_login n2 WHERE n1.user_insert = n2.id AND n1.id='" . $sID . "' ");
        $dataEquipment['updateuser'] = $oDB->QueryOne("SELECT CONCAT(n2.firstname,' ',n2.lastname) FROM tbl_equipment n1 INNER JOIN tbl_user_login n2 WHERE n1.user_update = n2.id AND n1.id='" . $sID . "' ");
        if (!$dataEquipment['sap_id']) {
          $head_title = " (Non-SAP)";
        }
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
                  <h3 class="card-title">Equipment Detail<?php echo $head_title; ?></h3>

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
                      <div class="table-responsive">
                        <table class="table">
                          <tr>
                            <th style="width:30%">Equipment Code :</th>
                            <td><?php echo $dataEquipment['equipment_code'] ?></td>
                          </tr>
                        </table>
                      </div>
                    </div>
                    <?php if($dataEquipment['sap_id']){ ?>
                    <div class="col-md-6">
                      <div class="table-responsive">
                        <table class="table">
                          <tr>
                            <th style="width:30%">SAP ID :</th>
                            <td><?php echo $dataEquipment['sap_id'] ?></td>
                          </tr>
                        </table>
                      </div>
                    </div>
                    <?php } ?>
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                      <div class="table-responsive">
                        <table class="table">
                          <tr>
                            <th style="width:30%">Group Equipment :</th>
                            <td><?php echo $dataEquipment['group_equipment'] ?></td>
                          </tr>
                        </table>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="table-responsive">
                        <table class="table">
                          <tr>
                            <th style="width:30%">Parent Asset :</th>
                            <td><?php echo $dataEquipment['parent_asset'] ?></td>
                          </tr>
                        </table>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                      <div class="table-responsive">
                        <table class="table">
                          <tr>
                            <th style="width:30%">Asset Code :</th>
                            <td><?php echo $dataEquipment['asset_code'] ?></td>
                          </tr>
                        </table>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="table-responsive">
                        <table class="table">
                          <tr>
                            <th style="width:30%">Serial Number :</th>
                            <td><?php echo $dataEquipment['serial_no'] ?></td>
                          </tr>
                        </table>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                      <div class="table-responsive">
                        <table class="table">
                          <tr>
                            <th style="width:30%">Building :</th>
                            <td><?php echo $dataEquipment['building'] ?></td>
                          </tr>
                        </table>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="table-responsive">
                        <table class="table">
                          <tr>
                            <th style="width:30%">Floor :</th>
                            <td><?php echo $dataEquipment['floor'] ?></td>
                          </tr>
                        </table>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                      <div class="table-responsive">
                        <table class="table">
                          <tr>
                            <th style="width:30%">Room :</th>
                            <td><?php echo $dataEquipment['room'] ?></td>
                          </tr>
                        </table>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="table-responsive">
                        <table class="table">
                          <tr>
                            <th style="width:30%">Rack :</th>
                            <td><?php echo $dataEquipment['rack'] ?></td>
                          </tr>
                        </table>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                      <div class="table-responsive">
                        <table class="table">
                          <tr>
                            <th style="width:30%">Model :</th>
                            <td><?php echo $dataEquipment['model'] ?></td>
                          </tr>
                        </table>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="table-responsive">
                        <table class="table">
                          <tr>
                            <th style="width:30%">Size :</th>
                            <td><?php echo $dataEquipment['size'] ?></td>
                          </tr>
                        </table>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                      <div class="table-responsive">
                        <table class="table">
                          <tr>
                            <th style="width:30%">Power Consumption :</th>
                            <td><?php echo $dataEquipment['power_consumption'] ?></td>
                          </tr>
                        </table>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="table-responsive">
                        <table class="table">
                          <tr>
                            <th style="width:30%">Owner :</th>
                            <td><?php echo $dataEquipment['owner'] ?></td>
                          </tr>
                        </table>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                      <div class="table-responsive">
                        <table class="table">
                          <tr>
                            <th style="width:30%">Group Approve :</th>
                            <td><?php echo $dataEquipment['groupapprove'] ?></td>
                          </tr>
                        </table>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="table-responsive">
                        <table class="table">
                          <tr>
                            <th style="width:30%">Approve :</th>
                            <td><span class="info-box-number"><i class="fas fa-user"></i><?php echo ' ' . $dataEquipment['approver'] . ' <i style="margin-left: 10px;" class="fas fa-clock"></i> ' . $dataEquipment['approve_date']; ?></span></td>
                          </tr>
                        </table>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                      <div class="table-responsive">
                        <table class="table">
                          <tr>
                            <th style="width:30%">User Request :</th>
                            <td><span class="info-box-number"><i class="fas fa-user"></i><?php echo ' ' . $dataEquipment['createuser'] . ' <i style="margin-left: 10px;" class="fas fa-clock"></i> ' . $dataEquipment['insert_date']; ?></span></td>
                          </tr>
                        </table>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="table-responsive">
                        <table class="table">
                          <tr>
                            <th style="width:30%">User Update :</th>
                            <?php if ($dataEquipment['updateuser']) { ?>
                              <td><span class="info-box-number"><i class="fas fa-user"></i><?php echo ' ' . $dataEquipment['updateuser'] . ' <i style="margin-left: 10px;" class="fas fa-clock"></i> ' . $dataEquipment['update_date']; ?></span></td>
                            <?php } else { ?>
                              <td><span class="info-box-number"><?php echo 'N/A'; ?></span></td>
                            <?php } ?>
                          </tr>
                        </table>
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
    $(function() {
      $("#example1").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
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