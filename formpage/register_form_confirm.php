<?php
include("../include/config.php");
include("../include/common.php");

CheckUserLogin_Fornt();

$sUserID = isset($_SESSION['au_member_id']) ? $_SESSION['au_member_id'] : '';
$sACT =  isset($_REQUEST['act']) ? $_REQUEST['act'] : '';

$sStatus = isset($_REQUEST['status']) ? $_REQUEST['status'] : '';
$sID =  isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
$eID =  isset($_REQUEST['sid']) ? $_REQUEST['sid'] : '';

$oDB = new DBI();

if ($sUserID) {
  $dataUserinfo = $oDB->QueryRow("SELECT * FROM tbl_user_login WHERE id='" . $sUserID . "'", DBI_ASSOC);
  $dataUserinfo['pic_url'] = USERIMG_URL . $dataUserinfo['picture'];
  $dataUserinfo['team_name'] = $oDB->QueryOne("SELECT team_code FROM tbl_team WHERE id='" . $dataUserinfo["team_id"] . "' ");
}

// หา equipment code
$axSql_groupequipment = $oDB->QueryRow("SELECT class_name, class_sub FROM tbl_group_equipment WHERE id='" . $_REQUEST['du_group_equipment_id'] . "' ", DBI_ASSOC);
$cs = $axSql_groupequipment['class_sub']; // หาตัวย่อ equipment code
$sTeam = $dataUserinfo['team_name'];
$sYear = date("y");
$sMonth = date("m");
$sLike = '____' . $sYear;  // เงื่อนไข Like

// $axSql= $oDB->Query("SELECT * FROM tbl_equipment WHERE equipment_code Like '%____22%' AND id= (SELECT MAX(id) FROM tbl_equipment ) ORDER BY equipment_code ASC");
$axSql = $oDB->Query("SELECT MAX(CAST(right(equipment_code,4) as int)) as eqint FROM tbl_equipment WHERE equipment_code Like '%$sLike%' ");
$rownum = 1;
while ($asResult = $axSql->FetchRow(DBI_ASSOC)) {
  $sEqu = $asResult['eqint'];
  $sNewNum = intval($sEqu) + 1;
  $sInt = sprintf("%04d", $sNewNum);
}

$emc = $cs . $sTeam . $sYear . $sMonth . $sInt;
if ($cs == "") {
  $emc = "";
}

// หา exiting Asset
$sAC = $_REQUEST['du_asset_code'];
$sACE = $_REQUEST['du_asset_code'] . '-%';
$axSR = $oDB->QueryOne("SELECT asset_code FROM tbl_equipment WHERE asset_code = '$sAC' ");
$axSRsub = $oDB->QueryOne("SELECT exiting_asset FROM tbl_equipment WHERE exiting_asset Like '$sACE' ");

if (($axSR) and ($axSRsub)) {  // กรณี มีทั้ง 2 อย่าง

  $axEXC = $oDB->Query("SELECT  MAX(CAST(MID(exiting_asset,LOCATE('-', exiting_asset)+1) as int))  as aex  FROM tbl_equipment WHERE exiting_asset Like '$sACE'   ");
  $rownum = 1;
  while ($asResultEXC = $axEXC->FetchRow(DBI_ASSOC)) {
    $sEqu = $asResultEXC['aex'];
    $sEqu = intval($sEqu) + 1;
    $exc = $sAC . '-' . $sEqu;
  }
} else if (($axSR) and (!$axSRsub)) {  // กรณี มีอย่างเดียว
  $exc = $sAC . '-1';
} else {
  $exc = $sAC;
}

if (!$_REQUEST['du_sap_id']){
  $head_title = "(Non-SAP)" ;
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
  <link rel="stylesheet" href="../alte/plugins/toastr/toastr.min.css">

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

      <!-- Main content รายละเอียด-->

      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Register Equipment Confirm <?php echo $head_title; ?></h1>
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
          <form name="dataform" id="dataform" action="" method="post" enctype="multipart/form-data">
            <div class="row">

              <!-- left column -->
              <div class="col-md-8">
                <div class="row">
                  <div class="col-md-3">
                    <div class="callout callout-warning">
                      <h5>Serial Number</h5>
                      <p><?php echo $_REQUEST['du_serial_no']; ?><input type="hidden" name="du1_serial_no" id="du1_serial_no" value="<?php echo $_REQUEST['du_serial_no']; ?>"></p>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="callout callout-warning">
                      <h5>Group Equipment</h5>
                      <p><?php echo $axSql_groupequipment['class_name']; ?><input type="hidden" name="du1_group_equipment_id" id="du1_group_equipment_id" value="<?php echo $_REQUEST['du_group_equipment_id']; ?>"></p>
                    </div>
                  </div>
                  <?php if ($_REQUEST['du_sap_id']){ ?>
                  <div class="col-md-3">
                    <div class="callout callout-warning">
                      <h5>SAP ID</h5>
                      <p><?php echo $_REQUEST['du_sap_id']; ?> <input type="hidden" name="du1_sap_id" id="du1_sap_id" value="<?php echo $_REQUEST['du_sap_id']; ?>"></p>
                    </div>
                  </div>
                  <?php } ?>

                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="callout callout-warning">
                      <h5>Asset Code</h5>
                      <p><?php echo $_REQUEST['du_asset_code']; ?><input type="hidden" name="du1_asset_code" id="du1_asset_code" value="<?php echo $_REQUEST['du_asset_code']; ?>"></p>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="callout callout-warning">
                      <h5>Parent Asset</h5>
                      <p><?php echo $_REQUEST['du_parent_asset']; ?><input type="hidden" name="du1_parent_asset" id="du1_parent_asset" value="<?php echo $_REQUEST['du_parent_asset']; ?>"></p>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-4">
                    <div class="callout callout-warning">
                      <h5>Model</h5>
                      <p><?php echo $_REQUEST['du_model']; ?><input type="hidden" name="du1_model" id="du1_model" value="<?php echo $_REQUEST['du_model']; ?>"></p>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="callout callout-warning">
                      <h5>Buildings</h5>
                      <?php $axSql_building = $oDB->QueryRow("SELECT building_name FROM tbl_building WHERE id='" . $_REQUEST['du_building_id'] . "' ", DBI_ASSOC); ?>
                      <p><?php echo $axSql_building['building_name']; ?><input type="hidden" name="du1_building_id" id="du1_building_id" value="<?php echo $_REQUEST['du_building_id']; ?>"></p>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="callout callout-warning">
                      <h5>Floor</h5>
                      <?php $axSql_floor = $oDB->QueryRow("SELECT floor_name FROM tbl_floor WHERE id='" . $_REQUEST['du_floor_id'] . "' ", DBI_ASSOC); ?>
                      <p><?php echo $axSql_floor['floor_name']; ?><input type="hidden" name="du1_floor_id" id="du1_floor_id" value="<?php echo $_REQUEST['du_floor_id']; ?>"></p>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-4">
                    <div class="callout callout-warning">
                      <h5>Room</h5>
                      <?php $axSql_room = $oDB->QueryRow("SELECT room_name FROM tbl_room WHERE id='" . $_REQUEST['du_room_id'] . "' ", DBI_ASSOC); ?>
                      <p><?php echo $axSql_room['room_name']; ?><input type="hidden" name="du1_room_id" id="du1_room_id" value="<?php echo $_REQUEST['du_room_id']; ?>"></p>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="callout callout-warning">
                      <h5>Rack</h5>
                      <?php $axSql_rack = $oDB->QueryRow("SELECT rack_name FROM tbl_location WHERE id='" . $_REQUEST['du_rack_id'] . "' ", DBI_ASSOC); ?>
                      <p><?php echo $axSql_rack['rack_name']; ?><input type="hidden" name="du1_rack_id" id="du1_rack_id" value="<?php echo $_REQUEST['du_rack_id']; ?>"></p>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="callout callout-warning">
                      <h5>Size</h5>
                      <p><?php echo $_REQUEST['du_size']; ?><input type="hidden" name="du1_size" id="du1_size" value="<?php echo $_REQUEST['du_size']; ?>"></p>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-4">
                    <div class="callout callout-warning">
                      <h5>Power Consumption (Watt)</h5>
                      <p><?php echo $_REQUEST['du_power_consumption']; ?><input type="hidden" name="du1_power_consumption" id="du1_power_consumption" value="<?php echo $_REQUEST['du_power_consumption']; ?>"></p>
                    </div>
                  </div>
                  <div class="col-md-8">
                    <div class="callout callout-warning">
                      <h5>Owner</h5>
                      <p><?php echo $_REQUEST['du_owner']; ?><input type="hidden" name="du1_owner" id="du1_owner" value="<?php echo $_REQUEST['du_owner']; ?>"></p>
                    </div>
                  </div>
                </div>


              </div>


              <!-- right column -->
              <div class="col-md-4">
                <div class="row">
                  <div class="col-md-12">
                    <div class="card-body">
                      <img class="img-fluid pad" src="./img/register.png" alt="Photo">
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-12">
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Send To Approve</button>
                  <!-- <input type="button" value="Save Draft" onClick="this.form.action='a.php'; submit()"> -->
                  <!-- <input type="button" value="Save" onClick="this.form.action='b.php'; submit()"> -->

                  <?php //if ($action != 'add') { 
                  ?>
                  <!-- <input name="du_id" type="hidden" id="du_id" value="1" /> -->
                  <?php // } 
                  ?>
                  <input name="act" type="hidden" id="act" value="confirm" />
                </div>
              </div>



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

  <!-- Toastr -->
  <script src="../alte/plugins/toastr/toastr.min.js"></script>

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
  <script type="text/javascript">
    function alertSuccess(massage, url) {
      toastr.options = {
        "timeOut": "1000"
      };
      $(function() {
        toastr.options.onHidden = function() {
          window.location.href = url;
        }
        toastr.success(massage, 'Success')
      })
    }

    function alertError(massage) {
      toastr.options = {
        "timeOut": "1000"
      };
      toastr.error(massage, 'Error')
    }
  </script>

  <?php

  if ($sACT == 'confirm') {

    $_POST['du1_insert_date'] = 'SYSDATE()';
    $_POST['du1_user_insert'] = $sUserID;
    $Assetcode = 'Asset Code : ' . $_POST['du1_asset_code'];
    $_POST['du1_group_approve'] = 4;

    // $oData = new DBDataUpdater($oDB, $oTable);
    // $oData->ReadFrom($_POST);

    $asSetData = array();
    foreach ($_POST as $sKey => $sVal) {
      if ((substr($sKey, 0, 4) == 'du1_') && ($sVal != '')) {
        $sKey = substr($sKey, 4);
        $asSetData[$sKey] = $sVal;
      }
    }

    $sField = '';
    $sValue = '';
    foreach ($asSetData as $sKey => $sVal) {
      if (in_array($sKey, array('insert_date'))) {
        $sValue .= $sVal . ',';
      } else {
        $sValue .= '\'' . $sVal . '\',';
      }
      $sField .= $sKey . ',';
    }
    $sField = substr($sField, 0, -1);
    $sValue = substr($sValue, 0, -1);

    $inSql = "INSERT INTO tbl_register_approve (" . $sField . ") VALUES (" . $sValue . ")";
    if ($oDB->Execute($inSql)) {
      
      // $approve_id = $oDB->QueryOne("SELECT id FROM tbl_register_approve WHERE sap_id='" . $_REQUEST['du1_sap_id'] . "' AND equipment_code='" . $_REQUEST['du1_equipment_code'] . "' ");
      $approve_id = $oDB->QueryOne("SELECT id FROM tbl_register_approve WHERE user_insert='" . $sUserID . "' ORDER BY id DESC  LIMIT 1;");

      $Createlogdata = "INSERT INTO tbl_job_activity (user_insert, workflow, title, approve_id, insert_date) VALUES ($sUserID,'1', '$Assetcode','$approve_id',SYSDATE())";
      $oDB->Execute($Createlogdata);

      $UpdateSql = "UPDATE tbl_register_draft SET approve_status = 'A' WHERE id=" . $sID;
      $oDB->Execute($UpdateSql);

      $tb_id = $oDB->QueryOne("SELECT MAX(id) FROM tbl_register_approve");
      $Createlogdata = "INSERT INTO tbl_datalog (log_id, log_table, user_insert, workflow, activity) VALUES ('$tb_id', 'tbl_register_approve', '$sUserID', '1', 'Register Equipment Approve Request' )";
      $oDB->Execute($Createlogdata);

      echo '
    <script type="text/javascript">
    alertSuccess("Sent To Approve Data","job_activity.php")
    </script>
    ';
      //  Redirect('่job_activity.php');
    } else {
      echo '
    <script type="text/javascript">
    alertError("Error Sent To Approve Data")
    </script>
    ';
    }
  }

  ?>

</body>

</html>