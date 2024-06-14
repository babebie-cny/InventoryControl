<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="author" content="Kodinger">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Login | Inventoty Control</title>
    <link rel="stylesheet" href="css/bootmy.css">
    <link rel="stylesheet" type="text/css" href="css/my-login.css">

    <!-- Bootstrap iCon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

    <style>
    @import url('https://fonts.googleapis.com/css2?family=Prompt:wght@300&display=swap');

    body {
        font-family: 'Prompt', sans-serif;

        /* background-image: url('https://shop.vive.co.th/wp-content/uploads/2021/03/tipco-set-1-1.jpg'); */
        background-position: center;
        background-size: cover;
        background-repeat: no-repeat;
    }

    .noBorder {
        border-radius: 0% !important;
        border: none !important;
        outline: none !important;
    }

    .loginLeftImage {
        /* background-image: url('../img/realTipco.jpg'); */
        background-color: rgba(0, 0, 0, 0);
        background-repeat: no-repeat;
        background-size: cover;
        animation: bgMove 55s linear infinite;
    }

    .loginRightBackground {
        background: rgba(0,0,0,0.4);
        background-position: center;
        background-size: cover;
        background-repeat: no-repeat;
    }

    .btn_fact {
        background: rgb(42, 0, 255);
        background: linear-gradient(90deg, rgba(42, 0, 255, 1) 0%, rgba(0, 255, 238, 1) 100%);
        background-size: 400% 400%;

        -webkit-animation: xmas_btn_ani 8s ease infinite;
        -o-animation: xmas_btn_ani 8s ease infinite;
        animation: xmas_btn_ani 8s ease infinite;
        transition: 6s;
    }

    .btn_fact:hover {
        background: rgb(58, 145, 80);
        background: linear-gradient(90deg, rgba(58, 145, 80, 1) 0%, rgba(110, 184, 179, 1) 100%);
        background-size: 400% 400%;
        -webkit-animation: xmas_btn_ani 6s ease infinite;
        -o-animation: xmas_btn_ani 6s ease infinite;
        animation: xmas_btn_ani 6s ease infinite;
    }

    .background-video {
        width: 100vw;
        height: 100vh;
        object-fit: cover;
        position: fixed;
        left: 0;
        top: 0;
        z-index: -1;
    }

    @keyframes bgMove {
        0% {
            background-position: 0% 50%;
        }

        50% {
            background-position: 100% 50%;
        }

        100% {
            background-position: 0% 50%;
        }
    }

    @-webkit-keyframes xmas_btn_ani {
        0% {
            background-position: 0% 50%
        }

        50% {
            background-position: 100% 50%
        }

        100% {
            background-position: 0% 50%
        }
    }

    @-o-keyframes xmas_btn_ani {
        0% {
            background-position: 0% 50%
        }

        50% {
            background-position: 100% 50%
        }

        100% {
            background-position: 0% 50%
        }
    }

    @keyframes xmas_btn_ani {
        0% {
            background-position: 0% 50%
        }

        50% {
            background-position: 100% 50%
        }

        100% {
            background-position: 0% 50%
        }
    }
    </style>
</head>
<?php
include('../include/config.php');
include('../include/common.php');

// Read parameters
$sACT =  isset($_REQUEST['act']) ? $_REQUEST['act'] : '';

// Config page
define('FORM_PAGE', 'login.htm');
define('RESULT_PAGE', 'login_result.htm');
define('LOGOUT_PAGE', 'logout_result.htm');

$oDB = new DBI();
$oTmp = new TemplateEngine();
$oLogin = new LoginManager();

if ($sACT == 'login') {
	$sUser = base64_encode($_POST['user']);
	$sPass = base64_encode($_POST['pass']);
	
	$oLogin->SetDBConnection($oDB);
	if (!$oLogin->Login($sUser, $sPass)) {
		//$oTmp->assign('message', '! ชื่อผู้ใช้งานหรือรหัสผิดพลาด กรุณาลองใหม่อีกครั้งหรือขอความช่วยเหลือ โทร.9132');
        Redirect('../index.php?result=worng');
		
	} elseif ($oLogin->IsAdmin()) {
		//$oTmp->assign('message', 'ยินดีต้อนรับเข้าสู่ TVS-Engineering');
		Redirect('../index.php');

	} else {
		$oLogin->Logout();
		//$oTmp->assign('message', '* ชื่อผู้ใช้งานนี่ยังไม่ได้รับสิทธิ์ให้เข้าใช้งานระบบ กรุณายืนยันตัวตนจากอีเมล์ที่ท่านได้รับจากระบบหรือขอความช่วยเหลือที่ โทร.9132 ขอบคุณครับ');
	}
	
} elseif ($sACT == 'logout') {
	$oLogin->Logout();
	//Redirect('home.php');
	
	$oTmp->assign('message', ' สักครู่... กำลังออกจากระบบ.');
	$oTmp->assign('message_status', '3');
	//$oTmp->display(LOGOUT_PAGE);
	
} elseif ($sACT == 'tvonline') {
	$oLogin->Logout();
	Redirect('tvonline_index.php');
	
} else {
	if ($sUserID) {
		Redirect('home.php');
	} else {
		$oTmp->assign('message', 'กรุณาลงชื่อก่อนเข้าใช้งานระบบ ขอบคุณ.');
		//$oTmp->display(FORM_PAGE);
	}
}
// echo $_SESSION["au_privilege"]["Administrator"];
$oDB->Close();
?>

<body>
    <video id="bgVid" class="background-video" autoplay loop poster="../img/notLogin.jpg">
        <source src="../video/loginVidBG_3c.mp4" type="video/mp4">
    </video>

    <div class="container-fluid px-0">
        <div class="row no-gutters">
            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 d-none d-sm-none d-md-none d-lg-none d-xl-block">
                <div class="card noBorder loginLeftImage w-100 vh-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="mt-auto ml-3 text-white"
                            style="filter: drop-shadow(5px 5px 5px rgba(0, 0, 0, 0.7));">Copyright &copy; 2021-2022
                            &mdash; Operations and Maintenance CATV</h5>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6">
                <div class="card noBorder loginRightBackground w-100 vh-100">
                    <div class="card-body d-flex align-items-center">
                        <form method="POST" class="my-login-validation" novalidate="">
                            <div class="row d-flex justify-content-center">
                                <div class="col-12 d-flex justify-content-center">
                                    <img class="img-fluid" style=" filter: drop-shadow(7px 7px 7px rgba(0, 0, 0, 1));"
                                        src="../img/newNarLogo.png" alt="">
                                </div>
                                <div class="col-0 col-xl-3 offest-3"></div>
                                <div class="col-8 col-md-8 col-xl-6 offest-3">
                                    <div class="form-group mt-4">
                                        <label for="name" class="text-white font-weight-bold">Username</label>
                                        <input id="user" type="text" class="form-control shadow-sm" name="user" value="" required
                                            autofocus>
                                        <div class="invalid-feedback font-weight-bold">
                                            User is invalid
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 offest-4"></div>
                                <div class="col-xl-3 offest-4"></div>

                                <div class="col-8 col-md-8 col-xl-6">
                                    <div class="form-group">
                                        <label for="password" class="text-white font-weight-bold">Password</label>
                                        <input id="pass" type="password" class="form-control shadow-sm" name="pass" required
                                            data-eye>
                                        <div class="invalid-feedback font-weight-bold">
                                            Password is required
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 offest-3"></div>
                                <div class="col-8 col-md-8 col-xl-6">
                                    <div class="form-group">
                                        <div class="custom-checkbox custom-control">
                                            <input type="checkbox" name="remember" id="remember"
                                                class="custom-control-input">
                                            <!-- <label for="remember" class="custom-control-label">Remember Me</label> -->
                                        </div>
                                    </div>

                                    <div class="form-group m-0">
                                        <button type="submit"
                                            class="btn btn_fact btn-block text-white font-weight-bold shadow-sm">
                                            <i class="bi bi-box-arrow-in-right"></i> Login
                                        </button>
                                        <input name="act" type="hidden" id="act" value="login" />
                                    </div>
                                    <div class="mt-4 text-center font-weight-bold">
                                        <a href="../index.php" class="text-decoration-none text-white"><i
                                                class="bi bi-box-arrow-in-left"></i> หน้าหลัก</a>
                                    </div>
                                    <div class="mt-2 text-center d-block d-sm-block d-md-block d-lg-block d-xl-none">
                                        <h6 class="mt-3 text-dark"
                                            style="filter: drop-shadow(5px 5px 5px rgba(0, 0, 0, 0.5));">Copyright
                                            &copy; 2022 &mdash; Operations and Maintenance CATV</h6>
                                    </div>
                                </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="js/invalidation.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.minCJ.js"></script>
    <script src="js/my-login.js"></script>
    <script>
    var vid = document.getElementById("bgVid");
    vid.volume = 0;
    vid.play();
    </script>
</body>

</html>