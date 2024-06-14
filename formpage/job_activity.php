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
	$dataUserinfo = $oDB->QueryRow("SELECT * FROM tbl_user_login WHERE id='".$sUserID."'", DBI_ASSOC);
	$dataUserinfo['pic_url'] = USERIMG_URL.$dataUserinfo['picture'];
}

function checkStatus($statusValue)
{
    if ($statusValue == 'A') {
        $statusString = '<span class="badge  badge-success w-75"><i class="bi bi-check2-circle"></i> Approved</span>';
    } elseif ($statusValue == 'N') {
        $statusString = '<span class="badge  badge-warning w-75"><i class="bi bi-hourglass-split"></i> Appove Request</span>';
    } elseif ($statusValue == '3') {
      $statusString = '<span class="badge  badge-warning w-75"><i class="bi bi-eye"></i> Review Request</span>';
    } elseif ($statusValue == 'R') {
        $statusString = '<span class="badge  badge-danger w-75"><i class="bi bi-x-octagon"></i> Rejected</span>';
    }

    return $statusString;
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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">


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
                <h3 class="card-title">Job Activity List</h3> 

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
                  <th>Date</th>
                  <th>Workflow</th>
                  <th>Activity</th>
                  <th>Detail</th>
                  <th>Approver</th>
                  <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
<?php
					  
$axSql= $oDB->Query("SELECT * FROM tbl_job_activity WHERE user_insert ='".$sUserID."' ");
					$rownum= 1;			
			while($asResult = $axSql->FetchRow(DBI_ASSOC))   {
        $asResult["workflowname"] = $oDB->QueryOne("SELECT workflow_name FROM tbl_workflow WHERE id='".$asResult["workflow"]."' ");
        $asResult["equipment_code"] = $oDB->QueryOne("SELECT equipment_code FROM tbl_register_approve WHERE id='".$asResult["approve_id"]."' ");
        $asResult["sap_id"] = $oDB->QueryOne("SELECT sap_id FROM tbl_register_approve WHERE id='".$asResult["approve_id"]."' ");
        $asResult["ac"] = $oDB->QueryOne("SELECT status_approve FROM tbl_register_approve WHERE id='".$asResult["approve_id"]."' ");
        $asResult["groupapprove"] = $oDB->QueryOne("SELECT n1.au_name FROM tbl_authen n1 INNER JOIN tbl_register_approve n2 WHERE n1.au_id=n2.group_approve AND n2.id= '".$asResult["approve_id"]."'  ");
        $asResult["groupapprove_id"] = $oDB->QueryOne("SELECT n1.au_id FROM tbl_authen n1 INNER JOIN tbl_register_approve n2 WHERE n1.au_id=n2.group_approve AND n2.id= '".$asResult["approve_id"]."'  ");
        $SAP_ID = $asResult["sap_id"] ;
        if ($SAP_ID) {
          $asResult["workflowname"];
        }else{
          $asResult["workflowname"] = $asResult["workflowname"]." (Non-SAP)";
        }
?>
        <tr>
          <td><?php echo $rownum;?></td>
					<td><?php echo date("d-m-Y",strtotime($asResult["insert_date"]));?></td>
          <td><?php echo $asResult["workflowname"];?> </td>       
					<td><span> <?php echo checkStatus($asResult["ac"]);?></span></td>
					<td><?php echo $asResult["title"];?></td>

					<td><?php echo $asResult["groupapprove"];?>
            <a style="margin-left: 5px;" data-toggle="dropdown" class="btn btn-primary btn-xs" href="#" ><i class="fas fa-user"></i></a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
              <?php $axSql_groupapprove= $oDB->Query("SELECT user_id FROM tbl_permission WHERE au_id ='".$asResult["groupapprove_id"]."' ");
                  while($asResult_groupapprove = $axSql_groupapprove->FetchRow(DBI_ASSOC))   {
                ?>
              <div  class="dropdown-item">
                  <!-- Message Start -->
                  <div class="media">
                    <div class="media-body">
                      <h3 class="dropdown-item-title">
                      <?php echo $oDB->QueryOne("SELECT CONCAT(firstname, ' ',lastname) FROM tbl_user_login WHERE id='".$asResult_groupapprove["user_id"]."' ");?>
                        <span class="float-right text-sm text-muted"><i class="fas fa-user"></i></span>
                      </h3>
                      <!-- <p class="text-sm">Call me whenever you can...</p> -->
                    </div>
                  </div>
                  <!-- Message End -->
                  </div>
                <div class="dropdown-divider"></div>
                <?php } ?>
            </div>
          </td>

					<td>     
          <a href="job_activity_detail.php?act=view&id=<?php echo $asResult["approve_id"];?>&wf=<?php echo $asResult["workflow"];?>" class="btn btn-info w-75"><i class="bi bi-box-arrow-up-right"></i> View Info</a>
          </td>
          <?php $rownum = $rownum+1; ?>

        </tr>
<?php } ?>

                  </tbody>
                  <tfoot>
                  <tr>
                  <th>No</th>
                  <th>Date</th>
                  <th>Workflow</th>
                  <th>Activity</th>
                  <th>Detail</th>
                  <th>Approver</th>
                  <th>Action</th>
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
