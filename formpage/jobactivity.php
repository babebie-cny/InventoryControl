<?php
include "../include/config.php";
include "../include/common.php";

$sUserID = isset($_SESSION['au_member_id']) ? $_SESSION['au_member_id'] : '';
$sACT = isset($_REQUEST['act']) ? $_REQUEST['act'] : '';

$sStatus = isset($_REQUEST['status']) ? $_REQUEST['status'] : '';
$sID = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';

$oDB = new DBI();

if ($sUserID) {
    $dataUserinfo = $oDB->QueryRow("SELECT * FROM tbl_user_login WHERE id='" . $sUserID . "'", DBI_ASSOC);
    $dataUserinfo['pic_url'] = USERIMG_URL . $dataUserinfo['picture'];
}

$targetRespon = $_SESSION['au_member_id'];

if(false){
    echo "UserID : " . $_SESSION['au_member_id'] . " | DebugMode is ON!" . "\r";
}
//Activity
// 1 = Regist Equipment
// 2 = Move Between Floor
// 3 = Incoming Equipment
// 4 = Outgoing Equipment
// 5 = Return Partner
// 6  = Write Off

//Status
// 1 = Review Request
// 2 = Appove Request
// 3 = Approved
// 4 = Rejected

function checkWorkflow($workflowValue)
{
    //$workflowValue = strval($workflowValue);

    if ($workflowValue == '1') {
        $workflowString = 'Regist Equipment';

    } elseif ($workflowValue == '2') {

        $workflowString = 'Move Between Floor';

    } elseif ($workflowValue == '3') {

        $workflowString = 'Incoming Equipment';

    } elseif ($workflowValue == '4') {

        $workflowString = 'Outgoing Equipment';

    } elseif ($workflowValue == '5') {

        $workflowString = 'Return Partner';

    } elseif ($workflowValue == '6') {

        $workflowString = 'Write Off';

    } else {
        $workflowString = 'shiranai shiranai boku wa nanimo shiranai';
    }
    return $workflowString;
}

function checkStatus($statusValue)
{
    if ($statusValue == '1') {
        $statusString = '<span class="badge  badge-warning w-100"><i class="bi bi-eye"></i> Review Request</span>';
    } elseif ($statusValue == '2') {
        $statusString = '<span class="badge  badge-warning w-100"><i class="bi bi-hourglass-split"></i> Appove Request</span>';
    } elseif ($statusValue == '3') {
        $statusString = '<span class="badge  badge-success w-100"><i class="bi bi-check2-circle"></i> Approved</span>';
    } elseif ($statusValue == '4') {
        $statusString = '<span class="badge  badge-danger w-100"><i class="bi bi-x-octagon"></i> Rejected</span>';
    }

    return $statusString;
}

function checkActivity($ActivityValue)
{
    if ($ActivityValue == '1') {
        $ActivityValue = 'Review Data';

    } elseif ($ActivityValue == '2') {

        $ActivityValue = 'Approve';

    } else {
        $ActivityValue = 'Unknown';
    }

    return $ActivityValue;
}

function isAction($Status, $id)
{
    if ($Status == '1') {
        echo '<td>' . '<a href="equipment_approve_form.php?act=view&id='.$id.'" class="btn btn-info w-75"><i class="bi bi-box-arrow-up-right"></i> View Info</a>' . '</td>';
    } else if ($Status == '2') {
        echo '<td>' . '<a href="equipment_approve_form.php?act=view&id='.$id.'" class="btn btn-info w-75"><i class="bi bi-box-arrow-up-right"></i> View Info</a>' . '</td>';
    } else if ($Status == '3') {
        echo '<td>' . '<a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" class="btn btn-secondary w-75 disabled" disabled><i class="bi bi-check-square"></i> Done</a>' . '</td>';
    } else if ($Status == '4') {
        echo '<td>' . '<a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" class="btn btn-secondary w-75 disabled" disabled><i class="bi bi-check-square"></i> Done</a>' . '</td>';
    }
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
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../alte/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../alte/dist/css/adminlte.min.css">

    <!--Style ตาราง -->
    <link rel="stylesheet" href="../alte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../alte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../alte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

    <style>
    .table>tbody>tr>td {
        vertical-align: middle;
    }
    
    .customHeader{
        background-image: url("./img/h-activity-bg.png");
        background-size: cover;
    }
    </style>

</head>

<body class="hold-transition sidebar-mini sidebar-collapse">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar Head หลัก-->
        <?php include "../formpage/l_head_m1.php";?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container Menu ทั้งหมด-->
        <?php include "../formpage/l_menu.php";?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) Head รอง-->
            <?php //include("../formpage/l_head_sub.php"); ?>

            <!-- Main content รายละเอียด-->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-12 col-12 col-lg-12">


                            <!-- Default box -->
                            <div class="card my-3 shadow-sm">

                                <div class="card-header customHeader text-white font-weight-bold">Job Activity
                                   

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                            title="Collapse">
                                            <!-- <i class="fas fa-minus"></i> -->
                                        </button>
                                        <!-- <button type="button" class="btn btn-tool" data-card-widget="remove"
                                            title="Remove"> -->
                                            <!-- <i class="fas fa-times"></i> -->
                                        </button>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped align-middle">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Date</th>
                                                <th>Workflow</th>
                                                <th>Activity</th>
                                                <th>Status</th>
                                                <th>Title/Detail</th>
                                                <th>User Request</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

<?php
$axSql = $oDB->Query("SELECT * , tbl_activity.id AS jobID FROM tbl_activity
LEFT JOIN tbl_user_login
ON tbl_user_login.id = tbl_activity.user_insert
WHERE user_insert = '$targetRespon' or approver = '$targetRespon'
ORDER BY insert_date asc"
);



$rownum = 1;
while ($asResult = $axSql->FetchRow(DBI_ASSOC)) {

    $asResult["insertname"] = $oDB->QueryOne("SELECT CONCAT(firstname,' ', lastname)  FROM tbl_user_login WHERE id='".$asResult["user_insert"]."' ");
    
    echo '<tr>';
    echo '<td>' . $asResult["jobID"] . '</td>';

    echo '<td>' . $asResult["insert_date"] . '</td>';

    echo '<td>' . checkWorkflow($asResult["workflow"]) . '</td>';

    echo '<td>' . checkActivity($asResult["activity"]) . '</td>';

    echo '<td>' . checkStatus($asResult["status"]) . '</td>';

    echo '<td>' . $asResult["title"] . '</td>';

    echo '<td>' . $asResult["insertname"] . '</td>';

    isAction($asResult["status"], $asResult["jobID"]);

    echo '</tr>';

    $rownum = $rownum + 1;
}
?>




                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>ID</th>
                                                <th>Date</th>
                                                <th>Workflow</th>
                                                <th>Activity</th>
                                                <th>Status</th>
                                                <th>Title/Detail</th>
                                                <th>User Request</th>
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
        <?php include "../formpage/l_footer.php";?>

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
            "order": [[1, 'desc']],
            // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
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