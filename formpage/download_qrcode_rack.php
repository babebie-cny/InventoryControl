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

$sID = $_GET["id"];
$sRackName = $oDB->QueryOne("SELECT rack_name FROM tbl_rack WHERE id='" . $sID . "' ");

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

  <script src="js/html5-qrcode.min.js"></script>
  <script src="js/html2canvas.min.js"></script>

  <style>
    .card {
      margin-top: 3rem;
      margin-bottom: 3rem;
    }

    .qr-code {
      padding: 1rem;
    }

    .qr-code h3 {
      font-weight: bold;
    }

    .gridview_tb {
      display: grid;
      grid-template-columns: auto 400px;
      gap: 1px;
      justify-content: center;
      /* width: 300px; */
    }

    @media print {
      @page {
        size: A4;
        margin-top: -80px;
        margin-left: 40px;
        padding: 0;
      }

      body *:not(#card-qr):not(#card-qr *) {
        visibility: visible;
      }

      .main-footer,
      #btn_print {
        display: none;
      }

      #btn_setting {
        display: none;
      }

      #card-qr {
        position: absolute;
        left: 125px;
        top: 35px;
        /* bottom: 0; */
      }

      /* .pagebreak {
            page-break-after: always;
          } */
    }
  </style>
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
      <section class="content">
        <div class="container-fluid">
          <button type="button" style="margin-top: 10px; margin-bottom: 0px" id="btn_setting" class="btn btn-info" data-toggle="modal" data-target="#myModal">Setting</button>
          <!-- <button type="button" class="btn btn-secondary mx-1 " data-bs-toggle="modal" data-bs-target="#fact"><i class="bi bi-calendar3"></i></button> -->
          <div class="row align-items-center">
            <div class="col-12 mx-auto">
              <div id="card-qr" class="card text-center">
                <div class="card-body d-flex flex-column align-items-center">
                  <div id="qr-code" class="qr-code"></div>
                  <!-- <div class="pagebreak"> </div>   -->
                  <!-- <div class="col-12" id="previewImg" hidden></div> -->
                  <button onclick="window.print()" type="button" id="btn_print" class="btn btn-primary">Print</button>
                  <!-- <button onclick="" type="button" id="exp_to_excel" class="btn btn-success" style="margin-top: 0.5rem">Export to Excel</button> -->
                </div>
              </div>
            </div>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
            <!-- <section class="reader">
                <div id="qr-reader" style="width:350px"></div>
            </section>     
            <section class="output">            
                <div id="qr-reader-results"></div>            
            </section> -->
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

  <script>
    var qr_code_element = document.querySelector(".qr-code")
    var div_element = document.createElement("div");
    div_element.className = "gridview_tb";
    qr_code_element.appendChild(div_element);
    var code = "<?php echo $sRackName; ?>".slice(0, 15);
    var code2 = "<?php echo $sRackName; ?>".slice(0, 26);
    // alert(code2);
    <?php
    if (!empty($sRackName)) {
      echo 'document.getElementsByClassName("gridview_tb").innerHTML = generate(code,code2)';
    }
    ?>

    if ("allQR" in localStorage) {
      var code = localStorage.getItem("allQR").split(",")
      var code2 = localStorage.getItem("allAsset").split(",")
      for (let i = 0; i < code.length; i++) {
        // if((i%4) == 0) {
        //   document.createElement("div").setAttribute("class","pagebreak")
        // }
        // console.log(code[i]);
        var div_element = document.createElement("div");
        div_element.className = "gridview_tb";
        qr_code_element.appendChild(div_element);
        document.getElementsByClassName("gridview_tb").innerHTML = generate(code[i], code2[i]);
      }
    }
    localStorage.clear();

    // console.log(typeof localStorage.getItem("allAssetQR")); //check data in console
    // var code = localStorage.getItem("allAssetQR").split(","); // string to array
    // console.log(code); 

    // //Time To Loop
    // for (let i = 0; i < code.length; i++) {
    // // console.log(code[i]);
    // document.getElementsByClassName("qr-code").innerHTML = generate(code[i]);   

    function generate(data, data2) {
      div_element.style = "";
      var qrcode = new QRCode(div_element, {
        text: `${data}`,
        width: 150,
        height: 150,
        colorDark: "#000000",
        colorLight: "#ffffff",
        correctLevel: QRCode.CorrectLevel.H
      });

      // let headQR_div = document.createElement("div");
      // headQR_div.setAttribute("style", "margin-left: 1.5rem")
      // let company = document.createElement("h1");
      // company.innerText = "TVG";
      // headQR_div.appendChild(company);
      // div_element.appendChild(headQR_div);

      // let headQR_div = document.createElement("div");
      // headQR_div.setAttribute("style", "margin-left: -2.0rem; margin-top: -1.00rem; font-weight: bolder; font-size: 10px; font-family:Verdana, Geneva, Tahoma, sans-serif");
      // headQR_div.innerText = "<?php //echo $sRackName ?>";
      // div_element.appendChild(headQR_div);

      // let infoQR_div = document.createElement("div");
      // infoQR_div.setAttribute("style","margin-left: 1rem")
      // let detail = document.createElement("h6");
      // detail.setAttribute("style","text-align: left;");
      // detail.innerText = "Z420 WORK STATION";
      // infoQR_div.appendChild(detail);
      // div_element.appendChild(infoQR_div);

      let equipment_code = document.createElement("h1")
      equipment_code.innerText = data2;
      equipment_code.setAttribute("style", "margin-left: 0.0rem; margin-top: 4.00rem; font-weight: bolder; font-size:30px; font-family:Verdana, Geneva, Tahoma, sans-serif");
      // equipment_code.style = "grid-column-start: 1;grid-column-end: 3;text-align: left; margin-top: -0.3rem; font-weight: bold; font-size: 28px; font-family:Verdana, Geneva, Tahoma, sans-serif";
      div_element.appendChild(equipment_code);

      const list = div_element;
      if (list.hasChildNodes()) {
        list.children[1].setAttribute("style", "grid-row-start: 1; grid-row-end: 3;");
        list.removeChild(list.children[0]);
      }

      // document.createElement("div").appendChild(document.createElement("br"));

      // let download = document.createElement("button");
      // qr_code_element.appendChild(download);

      // let download_link = document.createElement("a");
      // download_link.setAttribute("download", "qr_code.png");
      // download_link.innerText = "Download";
      // download.appendChild(download_link);

      // let qr_code_img = document.querySelector(".qr-code img");
      // let qr_code_canvas = document.querySelector("canvas");

      // if (qr_code_img.getAttribute("src") == null) {
      //     setTimeout(() => {
      //     download_link.setAttribute("href", `${qr_code_canvas.toDataURL()}`);
      //     }, 300);
      // } 
      // else {
      //     setTimeout(() => {
      //     download_link.setAttribute("href", `${qr_code_img.getAttribute("src")}`);
      //     }, 300);
      // }  

      document.getElementById("btn_print").addEventListener("click", function() {
        html2canvas(document.getElementById("qr-code"), {
          allowTaint: true,
          useCORS: true
        })
      });
    }
  </script>

  <?php $dataPrint = $oDB->QueryRow("SELECT * FROM tbl_print_setting WHERE user_insert='9999'", DBI_ASSOC);
  $qr_height = $dataPrint['qr_height'];
  $qr_width = $dataPrint['qr_width'];
  $company_position = $dataPrint['company_position'];
  $company_size = $dataPrint['company_size'];
  $ec_size = $dataPrint['ec_size'];

  ?>

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <form role="form" action="" method="post">
          <div class="modal-header">
            <h4 class="modal-title">PRINT SETTING</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <label for="inputName">QRcode Setting</label>
            <div class="row">
              <div class="col-md-6">

                <div class="form-group">
                  <label for="inputName">Height (<?php echo $qr_height; ?> px)</label>
                  <input type="input" name="qr_height" id="qr_height" class="form-control">
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label for="inputEmail">Width (<?php echo $qr_width; ?> px)</label>
                  <input type="input" name="qr_width" id="qr_width" class="form-control">
                </div>
              </div>
            </div>
          </div>

          <div class="modal-body">
            <label for="inputName">Company Setting</label>
            <div class="row">
              <div class="col-md-6">

                <div class="form-group">
                  <label for="inputName">Left Position (<?php echo $company_position; ?> rem)</label>
                  <input type="input" name="company_position" id="company_position" class="form-control">
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label for="inputEmail">Size (<?php echo $company_size; ?> px)</label>
                  <input type="input" name="company_size" id="company_size" class="form-control">
                </div>
              </div>
            </div>
          </div>

          <div class="modal-body">
            <label for="inputName">Equipment Code Setting</label>
            <div class="row">

              <div class="col-md-6">
                <div class="form-group">
                  <label for="inputEmail">Size (<?php echo $ec_size; ?> px)</label>
                  <input type="input" name="ec_size" id="ec_size" class="form-control">
                </div>
              </div>
            </div>
          </div>

          <div class="modal-footer">
            <input type='submit' class="btn btn-default" value='OK'>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Modal -->

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
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis", ]
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