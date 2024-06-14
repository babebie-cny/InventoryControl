<?php
include("../include/config.php");
include("../include/common.php");

CheckUserLogin_Fornt();

$sUserID = isset($_SESSION['au_member_id']) ? $_SESSION['au_member_id'] : '';
$sACT =  isset($_REQUEST['act']) ? $_REQUEST['act'] : '';
echo $sACT ;
$sStatus = isset($_REQUEST['status']) ? $_REQUEST['status'] : '';
$sID =  isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
$eID =  isset($_REQUEST['sid']) ? $_REQUEST['sid'] : '';

$oDB = new DBI();

if ($sUserID) {
  $dataUserinfo = $oDB->QueryRow("SELECT * FROM tbl_user_login WHERE id='" . $sUserID . "'", DBI_ASSOC);
  $dataUserinfo['pic_url'] = USERIMG_URL . $dataUserinfo['picture'];
}

$axSql_group_equipment = $oDB->Query("SELECT * FROM tbl_group_equipment");
while ($asResult = $axSql_group_equipment->FetchRow(DBI_ASSOC)) {
  $asGroupEquipment[] = $asResult;
}

$axSql_building = $oDB->Query("SELECT * FROM tbl_building");
while ($asResult = $axSql_building->FetchRow(DBI_ASSOC)) {
  $asBuilding[] = $asResult;
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

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

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
</head>

<?php

if ($sACT == 'new') {
  $axSql = $oDB->QueryRow("SELECT * FROM tbl_equipment_sap WHERE id='" . $eID . "' ", DBI_ASSOC);
  $axSql['owner'] = $axSql['name'] . " " . $axSql['surname'];
  $axSql['sap_id'] = $axSql['id'];
}
if ($sACT == 'add') {

  $_POST['du_insert_date'] = 'SYSDATE()';
  $_POST['du_user_insert'] = $sUserID;

  // $oData = new DBDataUpdater($oDB, $oTable);
  // $oData->ReadFrom($_POST);

  $asSetData = array();
  foreach ($_POST as $sKey => $sVal) {
    if ((substr($sKey, 0, 3) == 'du_') && ($sVal != '')) {
      $sKey = substr($sKey, 3);
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
  $inSql = "INSERT INTO tbl_register_draft (" . $sField . ") VALUES (" . $sValue . ")";
  if ($oDB->Execute($inSql)) {
    $tb_id = $oDB->QueryOne("SELECT MAX(id) FROM tbl_equipment_draft");
    $Createlogdata = "INSERT INTO tbl_datalog (log_id, log_table, user_insert, workflow, activity) VALUES ('$tb_id', 'tbl_register_draft', '$sUserID', '1', 'Create Register Equipment' )";
    $oDB->Execute($Createlogdata);
    echo '
    <script type="text/javascript">
    alertSuccess("Save Register Draft Equipment Data","register_draft_list.php")
    </script>
    ';
  } else {
    $asPost = array();
    foreach ($_POST as $sKey => $sVal) {
      if (substr($sKey, 0, 3) == 'du_') {
        $sKey = substr($sKey, 3);
        $asPost[$sKey] = $sVal;
      } else {
        $asPost[$sKey] = $sVal;
      }
    }
    echo '
    <script type="text/javascript">
    alertError("Error TO Save Register Draft Equipment Data")
    </script>
    ';
  }
} elseif ($sACT == 'edit') {

  $axSql = $oDB->QueryRow("SELECT * FROM tbl_register_draft WHERE id='" . $sID . "' ", DBI_ASSOC);
  $axSql['asset'] = $axSql['asset_code'];
  // $axSql['sap_id'] = $axSql['id'];

  $axSql_building = $oDB->Query("SELECT * FROM tbl_building");
  while ($asResult = $axSql_building->FetchRow(DBI_ASSOC)) {
    $asBuilding[] = $asResult;
  }

  $axSql_floor = $oDB->Query("SELECT * FROM tbl_floor WHERE building_id= '" . $axSql['building_id'] . "' ");
  while ($asResult = $axSql_floor->FetchRow(DBI_ASSOC)) {
    $asFloor[] = $asResult;
  }

  $axSql_room = $oDB->Query("SELECT * FROM tbl_room WHERE floor_id= '" . $axSql['floor_id'] . "' ");
  while ($asResult = $axSql_room->FetchRow(DBI_ASSOC)) {
    $asRoom[] = $asResult;
  }

  $axSql_rack = $oDB->Query("SELECT * FROM tbl_rack WHERE room_id= '" . $axSql['room_id'] . "' ");
  while ($asResult = $axSql_rack->FetchRow(DBI_ASSOC)) {
    $asRack[] = $asResult;
  }
} elseif ($sACT == 'update') {
  $_POST['du_update_date'] = 'SYSDATE()';
  $_POST['du_user_update'] = $sUserID;

  $asSetData = array();
  foreach ($_POST as $sKey => $sVal) {
    if ((substr($sKey, 0, 3) == 'du_') && ($sVal != '')) {
      $sKey = substr($sKey, 3);
      $asSetData[$sKey] = $sVal;
    }
  }
  $sSetDataUpdate = '';
  foreach ($asSetData as $sKey => $sVal) {
    if ($sKey != 'id') {
      if (in_array($sKey, array('id', 'update_date'))) {
        $sSetDataUpdate .= $sKey . '=' . $sVal . ',';
      } else {
        $sSetDataUpdate .= $sKey . '=' . '\'' . $sVal . '\',';
      }
    }
  }

  $sSetDataUpdate = substr($sSetDataUpdate, 0, -1);
  $sSql = "UPDATE tbl_register_draft SET " . $sSetDataUpdate . " WHERE id=" . $sID;

  if ($oDB->Execute($sSql)) {
    $tb_id = $sID;
    $Createlogdata = "INSERT INTO tbl_datalog (log_id, log_table, user_insert, workflow, activity) VALUES ('$tb_id', 'tbl_equipment_draft', '$sUserID', '1', 'Update Register Equipment Draft' )";
    $oDB->Execute($Createlogdata);
    echo '
  <script type="text/javascript">
  alertSuccess("Save Draft Equipment Data","register_draft_list.php")
  </script>
  ';
  } else {
    $asPost = array();
    foreach ($_POST as $sKey => $sVal) {
      if (substr($sKey, 0, 3) == 'du_') {
        $sKey = substr($sKey, 3);
        $asPost[$sKey] = $sVal;
      } else {
        $asPost[$sKey] = $sVal;
      }
    }
    echo '
  <script type="text/javascript">
  alertError("Error TO Save Draft Equipment Data")
  </script>
  ';
  }
}

?>

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
              <h1>Register Equipment Form</h1>
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
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>SAP ID</label>
                      <input type="input" name="du_sap_id" id="du_sap_id" value="<?php echo isset($axSql['sap_id']) ? $axSql['sap_id'] : ''; ?>" class="form-control" placeholder="SAP ID..." readonly>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Asset Code</label>
                      <input type="input" name="du_asset_code" id="du_asset_code" value="<?php echo isset($axSql['asset']) ? $axSql['asset'] : ''; ?>" class="form-control" placeholder="Asset Code..." readonly>
                    </div>
                  </div>

                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Group Equipment</label>
                      <select class="form-control" name="du_group_equipment_id" id="du_group_equipment_id" required>
                        <option value="">Choose Group Equipment</option>
                        <?php foreach ($asGroupEquipment as $sGroupEquipment) { ?>
                          <?php if ($axSql['group_equipment_id'] == $sGroupEquipment['id']) { ?>
                            <option value="<?php echo $sGroupEquipment['id'] ?>" selected><?php echo $sGroupEquipment['class_name'] ?></option>
                          <?php } else { ?>
                            <option value="<?php echo $sGroupEquipment['id'] ?>"><?php echo $sGroupEquipment['class_name'] ?></option>
                          <?php } ?>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Owner</label>
                      <input type="input" name="du_owner" id="du_owner" value="<?php echo isset($axSql['owner']) ? $axSql['owner'] : ''; ?>" class="form-control" placeholder="Owner..." readonly>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Serial Number</label>
                      <input type="input" name="du_serial_no" id="du_serial_no" value="<?php echo isset($axSql['serial_no']) ? $axSql['serial_no'] : ''; ?>" class="form-control" placeholder="Serial No...">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Model</label>
                      <input type="input" name="du_model" id="du_model" value="<?php echo isset($axSql['model']) ? $axSql['model'] : ''; ?>" class="form-control" placeholder="Model...">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Parent Asset(Asset Code Of Parent)</label>
                      <input type="input" name="du_parent_asset" id="du_parent_asset" value="<?php echo isset($axSql['parent_asset']) ? $axSql['parent_asset'] : ''; ?>" class="form-control" placeholder="Parent Asset...">
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Building</label>
                      <select class="form-control" name="du_building_id" id="du_building_id">
                        <option>Choose Building</option>
                        <?php foreach ($asBuilding as $sBuilding) { ?>
                          <?php if ($axSql['building_id'] == $sBuilding['id']) { ?>
                            <option value="<?php echo $sBuilding['id'] ?>" selected><?php echo $sBuilding['building_name'] ?></option>
                          <?php } else { ?>
                            <option value="<?php echo $sBuilding['id'] ?>"><?php echo $sBuilding['building_name'] ?></option>
                          <?php } ?>
                        <?php } ?>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Floor</label>
                      <select class="form-control" name="du_floor_id" id="du_floor_id">
                        <option>Choose Floor</option>
                        <?php foreach ($asFloor as $sFloor) { ?>
                          <?php if ($axSql['floor_id'] == $sFloor['id']) { ?>
                            <option value="<?php echo $sFloor['id'] ?>" selected><?php echo $sFloor['floor_name'] ?></option>
                          <?php } else { ?>
                            <option value="<?php echo $sFloor['id'] ?>"><?php echo $sFloor['floor_name'] ?></option>
                          <?php } ?>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Room</label>
                      <select class="form-control" name="du_room_id" id="du_room_id">
                        <option>Choose Room</option>
                        <?php foreach ($asRoom as $sRoom) { ?>
                          <?php if ($axSql['room_id'] == $sRoom['id']) { ?>
                            <option value="<?php echo $sRoom['id'] ?>" selected><?php echo $sRoom['room_name'] ?></option>
                          <?php } else { ?>
                            <option value="<?php echo $sRoom['id'] ?>"><?php echo $sRoom['room_name'] ?></option>
                          <?php } ?>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Rack</label>
                      <select class="form-control" name="du_rack_id" id="du_rack_id">
                        <option>Choose Rack</option>
                        <?php foreach ($asRack as $sRack) { ?>
                          <?php if ($axSql['rack_id'] == $sRack['id']) { ?>
                            <option value="<?php echo $sRack['id'] ?>" selected><?php echo $sRack['rack_name'] ?></option>
                          <?php } else { ?>
                            <option value="<?php echo $sRack['id'] ?>"><?php echo $sRack['rack_name'] ?></option>
                          <?php } ?>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label id="rack">Size (Length x Width x Height)</label>
                      <input type="input" name="du_size" id="du_size" value="<?php echo isset($axSql['size']) ? $axSql['size'] : ''; ?>" class="form-control" placeholder="L x W x H..." re>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Power Consumption (Watt)</label>
                      <input type="number" name="du_power_consumption" id="du_power_consumption" value="<?php echo isset($axSql['power_consumption']) ? $axSql['power_consumption'] : ''; ?>" class="form-control" placeholder="Power Consumption..." re>
                    </div>
                  </div>
                </div>

                <!-- <div class="row">	
            <div class="col-md-6">
              <div class="form-group">
                  <label>Acq Value Balance</label>
                  <input type="input" name="du_acq_value_balance" id="du_acq_value_balance" value="<?php echo isset($axSql['acq_value_balance']) ? $axSql['acq_value_balance'] : ''; ?>" class="form-control" placeholder="Acq Value Balance..." re>
              </div>
					</div>
            <div class="col-md-6">
              <div class="form-group">
                  <label>Netbk.Val FYE</label>
                  <input type="input" name="du_netbk_val_fye" id="du_netbk_val_fye" value="<?php echo isset($axSql['netbk_val_fye']) ? $axSql['netbk_val_fye'] : ''; ?>" class="form-control" placeholder="Netbk.Val FYE..." re>
              </div>
					  </div>
				  </div>
 -->
              </div>


              <!-- right column -->
              <div class="col-md-4">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <img class="img-fluid pad" src="./img/register.png" alt="Photo">
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-12">
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Save Draft Equipment Data</button>
                  <button type="submit" class="btn btn-success" onClick="this.form.action='register_form_confirm.php?id=<?php echo $sID; ?>'">Confirm Equipment Data</button>

                  <?php if ($sACT == 'new') { ?>
                    <input name="act" type="hidden" id="act" value="add" />
                  <?php } elseif ($sACT == 'edit') { ?>
                    <input name="act" type="hidden" id="act" value="update" />
                  <?php } ?>
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
    $('#du_building_id').change(function() {
      var id_building = $(this).val();
      console.log(id_building);
      $("#du_floor_id").empty();
      $('#du_floor_id').append(' <option > Choose Floor </option>')
      $("#du_room_id").empty();
      $('#du_room_id').append(' <option > Choose Room </option>')
      $("#du_rack_id").empty();
      $('#du_rack_id').append(' <option > Choose Rack </option>')
      $.ajax({
        type: "post",
        url: "location_api.php",
        data: {
          id_building: id_building,
          function: 'du_building_id'
        },
        success: function(data) {
          $('#du_floor_id').html(data);
          console.log(data);
        }
      });
    });
    $('#du_floor_id').change(function() {
      var id_floor = $(this).val();
      // var id_building = document.getElementById("du_building_id").value;
      $("#du_room_id").empty();
      $('#du_room_id').append(' <option > Choose Room </option>')
      $("#du_rack_id").empty();
      $('#du_rack_id').append(' <option > Choose Rack </option>')
      $.ajax({
        type: "post",
        url: "location_api.php",
        data: {
          id_floor: id_floor,
          function: 'du_floor_id'
        },
        success: function(data) {
          $('#du_room_id').html(data);
        }
      });
    });
    $('#du_room_id').change(function() {
      var id_room = $(this).val();
      $.ajax({
        type: "post",
        url: "location_api.php",
        data: {
          id_room: id_room,
          function: 'du_room_id'
        },
        success: function(data) {
          $('#du_rack_id').html(data);
        }
      });
    });
    $('#du_rack_id').change(function() {
      if ($(this).val() == "Choose Rack") {
        document.getElementById('rack').innerHTML = 'Size (Length x Width x Height)';
        document.getElementsByName('du_size')[0].placeholder = 'Length x Width x Height ...';
      } else {
        document.getElementById('rack').innerHTML = 'Size (U)';
        document.getElementsByName('du_size')[0].placeholder = 'Size...';
      }
    });
  </script>

</body>

</html>