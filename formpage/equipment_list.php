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
                        <th>Sap ID</th>
                        <th>Equipment Code</th>
                        <th>Asset Code</th>
                        <th>Serial Number</th>
                        <th>Building</th>
                        <th>Floor</th>
                        <th>Room</th>
                        <th>Rack</th>
                        <th>Owner</th>
                        <th>QR Code</th>
                        <th>Check</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php

                      $axSql = $oDB->Query("SELECT * FROM tbl_equipment WHERE approve_status='A' ");
                      $rownum = 1;
                      while ($asResult = $axSql->FetchRow(DBI_ASSOC)) {
                        $asResult["building_id"] = $oDB->QueryOne("SELECT building_name FROM tbl_building WHERE id='" . $asResult["building_id"] . "' ");
                        $asResult["floor_id"] = $oDB->QueryOne("SELECT floor_name FROM tbl_floor WHERE id='" . $asResult["floor_id"] . "' ");
                        $asResult["room_id"] = $oDB->QueryOne("SELECT room_name FROM tbl_room WHERE id='" . $asResult["room_id"] . "' ");
                        $asResult["rack_id"] = $oDB->QueryOne("SELECT rack_name FROM tbl_location WHERE id='" . $asResult["rack_id"] . "' ");
                      ?>

                        <tr>
                          <td><?php echo $rownum; ?></td>
                          <td>
                            <?php if ($asResult["sap_id"]) {?>
                            <a class="btn btn-primary btn-xs" href="sap_detail_view.php?act=view&id=<?php echo $asResult["sap_id"]; ?>" target="_blank"><i style="margin-right: 5px;" class="fas fa-eye"></i> SAP </a>
                            <?php }else{ ?>
                            <a class="btn btn-info btn-xs" href="#"><i style="margin-right: 5px;" class="far fa-times-circle"></i> Non-SAP </a>
                            <?php } ?>
                          </td>
                          
                          <td><?php echo $asResult["equipment_code"]; ?> <a href="equipment_detail.php?act=view&id=<?php echo $asResult["id"]; ?>" target="_blank"><i class="fa fa-info-circle fa-lg"></i></a>
                            <?php if ($_SESSION["au_privilege"]["Approve_Register"]) { ?>
                              <a href="equipment_form.php?act=edit&id=<?php echo $asResult["id"]; ?>"> <i class="fas fa-edit" style=" margin-left: 5px;font-size: 18px; color:Teal"> </i><a>
                                <?php  } ?>
                          </td>
                          <td><?php echo $asResult["asset_code"]; ?></td>
                          <td><?php echo $asResult["serial_no"]; ?></td>
                          <td><?php echo $asResult["building_id"]; ?></td>
                          <td><?php echo $asResult["floor_id"]; ?></td>
                          <td><?php echo $asResult["room_id"]; ?></td>
                          <td><?php echo $asResult["rack_id"]; ?></td>
                          <td><?php echo $asResult["owner"]; ?></td>
                          <td><a href="download_qrcode.php?act=view&equip_code=<?php echo $asResult["equipment_code"]; ?>&id=<?php echo $asResult["sap_id"]; ?>" class="btn btn-secondary btn-xs" data-bs-toggle="modal" data-bs-target="#downloadQR"><i class="fas fa-barcode"></i> QR Code</a>
                            <!-- <a href="download_qrcode_rack.php?act=view&equip_code=<?php echo $asResult["equipment_code"]; ?>&id=<?php echo $asResult["sap_id"]; ?>" class="btn btn-info btn-xs" data-bs-toggle="modal" data-bs-target="#downloadQR"><i class="fas fa-barcode"></i> Rack</a> -->
                          </td>
                          <td>
                            <div class="form-check"><input class="form-check-input" type="checkbox"></div>
                          </td>
                          <?php $rownum = $rownum + 1; ?>

                        </tr>
                      <?php } ?>

                    </tbody>
                    <tfoot>
                      <tr>
                        <th>No</th>
                        <th>Sap ID</th>
                        <th>Equipment Code</th>
                        <th>Asset Code</th>
                        <th>Serial Number</th>
                        <th>Building</th>
                        <th>Floor</th>
                        <th>Room</th>
                        <th>Rack</th>
                        <th>Owner</th>
                        <th>QR Code</th>
                        <th>Check</th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
                <!-- /.card-body -->

              </div>
              <!-- /.card -->

              <!-- Modal -->
              <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title" id="exampleModalLabel">Modal title</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <form>
                        <div class="form-group ">
                          <label for="message-text" class="col-form-label">Message:</label>
                          <textarea class="form-control" id="message-text" rows="5"></textarea>
                        </div>
                      </form>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary" onclick="sendValue()">Send</button>
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
          <button type="button" id="select_gen_qr" class="btn btn-primary" style="margin-bottom: 1rem">Select Generate QR</button>
          <button type="button" id="all_gen_qr" class="btn btn-primary" style="margin-bottom: 1rem">All Generate QR</button>
          <button type="button" id="select_exp_to_excel" class="btn btn-success" style="margin-bottom: 1rem">Select Export to Excel</button>
          <button type="button" id="all_exp_to_excel" class="btn btn-success" style="margin-bottom: 1rem">All Export to Excel</button>
          <!-- <button type="button" id="all_exp_to_csv" class="btn btn-success" style="margin-bottom: 1rem">All Export to CSV</button> -->

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

  <script>
    $("#select_gen_qr").on('click', function() {
      var allCode = [];
      var assetCode = []

      $("#example1 tbody tr").each(function() {
        var currentRow = $(this);
        var target_value = currentRow.find("td:eq(2)").text();
        var target_value2 = currentRow.find("td:eq(3)").text();
        var result = target_value.replace(" Detail", "");
        var result2 = target_value2;
        if (currentRow.find(".form-check-input").is(":checked")) {
          allCode.push(result);
          assetCode.push(result2);
        }
      });
      localStorage.setItem("allQR", allCode);
      localStorage.setItem("allAsset", assetCode);
      console.log(allCode);
      console.log(assetCode);
      if (allCode.length > 0) {
        window.location.href = "download_qrcode.php";
      } else {
        localStorage.removeItem("allQR")
        localStorage.removeItem("allAsset")
      }
      const clist = document.getElementsByTagName("input");
      for (const el of clist) {
        el.checked = false;
      }
    });

    $("#all_gen_qr").on('click', function() {
      var allCode = [];
      var assetCode = []

      $("#example1 tbody tr").each(function() {
        var currentRow = $(this);
        var target_value = currentRow.find("td:eq(2)").text();
        var target_value2 = currentRow.find("td:eq(3)").text();
        var result = target_value.replace(" Detail", "");
        var result2 = target_value2;
        allCode.push(result);
        assetCode.push(result2)
      });
      localStorage.setItem("allQR", allCode);
      localStorage.setItem("allAsset", assetCode);
      window.location.href = "download_qrcode.php";
      console.log(allCode);
      console.log(assetCode);
    });

    //  
    $("#all_exp_to_excel").click(function() {
      var eqp_code = [];
      var ass_code = [];
      var clist = document.getElementsByClassName("form-check-input");
      for (const el of clist) {
        el.checked = true;
      }
      $("#example1 input[type=checkbox]:checked").each(function() {
        var row = $(this).closest("tr")[0];
        eqp_code.push((row.cells[2].innerText).replace(" Detail", ""));
        ass_code.push("'" + (row.cells[3].innerText));
      });
      console.log(eqp_code);
      console.log(ass_code);
      let table = document.createElement('table');
      table.id = "example2";
      // table.style = "visibility: hidden";
      let thead = document.createElement('thead');
      let tbody = document.createElement('tbody');
      table.appendChild(thead);
      table.appendChild(tbody);
      document.getElementById('content').appendChild(table);
      let row1 = document.createElement('tr');
      let heading1 = document.createElement('th');
      heading1.innerHTML = "Equipment Code";
      let heading2 = document.createElement('th');
      heading2.innerHTML = "Asset Code";
      row1.appendChild(heading1);
      row1.appendChild(heading2);
      thead.appendChild(row1)
      if (eqp_code.length > 0 && ass_code.length > 0) {
        for (let i = 0; i < eqp_code.length; i++) {
          let row2 = document.createElement('tr');
          let row2_data1 = document.createElement('td');
          row2_data1.innerHTML = eqp_code[i];
          let row2_data2 = document.createElement('td');
          row2_data2.innerHTML = ass_code[i];
          row2.appendChild(row2_data1);
          row2.appendChild(row2_data2);
          tbody.appendChild(row2);
        }
        var table2excel = new Table2Excel({
          defaultFileName: "Inventory"
        });
        table2excel.export(document.querySelectorAll("#example2"));
        $("#example2").remove();
      } else {
        $("#example2").remove();
      }
      var clist = document.getElementsByClassName("form-check-input");
      for (const el of clist) {
        el.checked = false;
      }
      // $("#example1").table2excel({
      //     exclude: ".noExl",
      //     name: "Worksheet",
      //     filename: "Inventory",
      //     fileext: ".xlsx"
      // }); 
    });

    $("#select_exp_to_excel").click(function() {
      var eqp_code = [];
      var ass_code = [];
      $("#example1 input[type=checkbox]:checked").each(function() {
        var row = $(this).closest("tr")[0];
        eqp_code.push((row.cells[2].innerText).replace(" Detail", ""));
        ass_code.push("'" + (row.cells[3].innerText));
      });
      console.log(eqp_code);
      console.log(ass_code);
      let table = document.createElement('table');
      table.id = "example2";
      // table.style = "visibility: hidden";
      let thead = document.createElement('thead');
      let tbody = document.createElement('tbody');
      table.appendChild(thead);
      table.appendChild(tbody);
      document.getElementById('content').appendChild(table);
      let row1 = document.createElement('tr');
      let heading1 = document.createElement('th');
      heading1.innerHTML = "Equipment Code";
      let heading2 = document.createElement('th');
      heading2.innerHTML = "Asset Code";
      row1.appendChild(heading1);
      row1.appendChild(heading2);
      thead.appendChild(row1)
      if (eqp_code.length > 0 && ass_code.length > 0) {
        for (let i = 0; i < eqp_code.length; i++) {
          let row2 = document.createElement('tr');
          let row2_data1 = document.createElement('td');
          row2_data1.innerHTML = eqp_code[i];
          let row2_data2 = document.createElement('td');
          row2_data2.innerHTML = ass_code[i];
          row2.appendChild(row2_data1);
          row2.appendChild(row2_data2);
          tbody.appendChild(row2);
        }
        var table2excel = new Table2Excel({
          defaultFileName: "Inventory"
        });
        table2excel.export(document.querySelectorAll("#example2"));
        $("#example2").remove();
      } else {
        $("#example2").remove();
      }
      const clist = document.getElementsByClassName("form-check-input");
      for (const el of clist) {
        el.checked = false;
      }
    });

    function htmlToCSV(html, filename) {
      var data = [];
      var rows = document.querySelectorAll("table tr");
      for (var i = 0; i < rows.length; i++) {
        var row = [],
          cols = rows[i].querySelectorAll("td, th");
        for (var j = 0; j < cols.length; j++) {
          row.push(cols[j].innerText);
        }
        data.push(row.join(","));
      }
      downloadCSVFile(data.join("\n"), filename);
    }

    function downloadCSVFile(csv, filename) {
      var csv_file, download_link;
      csv_file = new Blob([csv], {
        type: "text/csv"
      });
      download_link = document.createElement("a");
      download_link.download = filename;
      download_link.href = window.URL.createObjectURL(csv_file);
      download_link.style.display = "none";
      document.body.appendChild(download_link);
      download_link.click();
    }
    document.getElementById("all_exp_to_csv").addEventListener("click", function() {
      var html = document.querySelector("table").outerHTML;
      htmlToCSV(html, "Inventory.csv");
    });

    function sendValue() {
      var x = document.getElementById("message-text").value;
      console.log(x);
      $('#exampleModal').modal('hide');
      alert("Send Successfully")
      document.getElementById("message-text").value = "";
    }
  </script>

  <!-- Bootstrap 4 -->
  <script src="../alte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../alte/dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="../alte/dist/js/demo.js"></script>

  <!-- Script ตาราง -->
  <!-- <script src="../alte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script> -->
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