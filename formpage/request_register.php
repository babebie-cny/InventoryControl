<?php
 include("../include/config.php"); 
 include("../include/common.php"); 


$sACT = $_REQUEST['act'];
$sStatus = $_REQUEST['status'];
$sID =  isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
$eID =  isset($_REQUEST['sid']) ? $_REQUEST['sid'] : '';

$sql = "SELECT * FROM tbl_equipment_sap WHERE id=" .$eID or die("Error:" . mysqli_error());
//$sql = "SELECT * FROM tbl_equipment_sap WHERE id= 5 " or die("Error:" . mysqli_error());
$query = mysqli_query($con, $sql);
$asData = array();
while($result=mysqli_fetch_array($query, MYSQLI_ASSOC)) {

$asData = $result;
}


?>

<!DOCTYPE html>
<!-- saved from url=(0090)https://website357249.nicepage.io/Page-4.html?version=cdd5b8b4-a731-4350-8aa5-84cc127acf07 -->
<html class="u-responsive-xl"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <meta name="keywords" content="contact form, follow us">
    <meta name="description" content="">
    <meta name="page_type" content="np-template-header-footer-from-plugin">
    <title>Page 4</title>
    <link rel="stylesheet" href="./nicepage.css" media="screen">
    <script class="u-script" type="text/javascript" src="./jquery-1.9.1.min.js.download" defer=""></script>
    <script class="u-script" type="text/javascript" src="./nicepage.js.download" defer=""></script>
    <meta name="generator" content="Nicepage 3.13.2, nicepage.com">
    <link id="u-theme-google-font" rel="stylesheet" href="./css">
    <style class="u-style">.u-section-2 {
  background-image: none;
}
.u-section-2 .u-sheet-1 {
  min-height: 756px;
}
.u-section-2 .u-layout-wrap-1 {
  margin-top: 50px;
  margin-bottom: 50px;
}
.u-section-2 .u-image-1 {
  background-image: url("./img/register.png");
  min-height: 657px;
  background-position: 50% 50%;
}
.u-section-2 .u-container-layout-1 {
  padding: 30px;
}
.u-section-2 .u-layout-cell-2 {
  background-image: none;
  min-height: 657px;
}
.u-section-2 .u-container-layout-2 {
  padding: 30px;
}
.u-section-2 .u-text-1 {
  text-transform: none;
  font-size: 2.25rem;
  margin: 0;
}
.u-section-2 .u-form-1 {
  height: 334px;
  margin: 32px -60px 0 0;
}
.u-section-2 .u-btn-1 {
  background-image: none;
  border-style: solid;
}
.u-section-2 .u-text-2 {
  text-transform: none;
  font-size: 2.25rem;
  margin: 32px 209px 0 0;
}
.u-section-2 .u-social-icons-1 {
  white-space: nowrap;
  height: 32px;
  min-height: 16px;
  width: 188px;
  min-width: 124px;
  margin: 29px auto 0 0;
}
.u-section-2 .u-icon-1 {
  height: 100%;
}
.u-section-2 .u-icon-2 {
  height: 100%;
}
.u-section-2 .u-icon-3 {
  height: 100%;
}
.u-section-2 .u-icon-4 {
  height: 100%;
}
.u-section-2 .u-text-3 {
  font-style: italic;
  margin: 11px 0 0;
}
.u-section-2 .u-btn-2 {
  border-style: none none solid;
  font-style: italic;
  padding: 0;
}
@media (max-width: 1199px) {
  .u-section-2 .u-sheet-1 {
    min-height: 641px;
  }
  .u-section-2 .u-image-1 {
    min-height: 542px;
  }
  .u-section-2 .u-layout-cell-2 {
    min-height: 542px;
  }
  .u-section-2 .u-form-1 {
    margin-right: initial;
    margin-left: initial;
  }
  .u-section-2 .u-text-2 {
    margin-right: 102px;
  }
  .u-section-2 .u-social-icons-1 {
    width: 188px;
    margin-left: 0;
  }
}
@media (max-width: 991px) {
  .u-section-2 .u-sheet-1 {
    min-height: 514px;
  }
  .u-section-2 .u-image-1 {
    min-height: 415px;
  }
  .u-section-2 .u-layout-cell-2 {
    min-height: 100px;
  }
  .u-section-2 .u-text-2 {
    margin-right: 0;
  }
}
@media (max-width: 767px) {
  .u-section-2 .u-sheet-1 {
    min-height: 866px;
  }
  .u-section-2 .u-image-1 {
    min-height: 667px;
  }
  .u-section-2 .u-container-layout-1 {
    padding-left: 10px;
    padding-right: 10px;
  }
  .u-section-2 .u-container-layout-2 {
    padding-left: 10px;
    padding-right: 10px;
  }
}
@media (max-width: 575px) {
  .u-section-2 .u-sheet-1 {
    min-height: 619px;
  }
  .u-section-2 .u-image-1 {
    min-height: 420px;
  }
  .u-section-2 .u-text-1 {
    font-size: 1.5rem;
  }
  .u-section-2 .u-text-2 {
    font-size: 1.5rem;
  }
}</style>
    

    <meta property="og:title" content="Page 4">
    <meta property="og:type" content="website">
    <meta name="theme-color" content="#3a4998">
    <link rel="canonical" href="https://website357249.nicepage.io/Page-4.html">
    <meta property="og:url" content="https://website357249.nicepage.io/Page-4.html">
    <link rel="stylesheet" href="./cbbox.css" media="screen">
    <script type="text/javascript" src="./cbboxscript.js" defer=""></script>


  
</head>
  <body class="u-body">
<header class="u-clearfix u-header u-header" id="sec-da44"><div class="u-clearfix u-sheet u-valign-middle u-sheet-1">
        <a href="https://nicepage.com/" class="u-image u-logo u-image-1">
          <img src="./img/TVIlogo.png" class="u-logo-image u-logo-image-1" style="max-width: 90px;">
        </a>
        <nav class="u-menu u-menu-dropdown u-offcanvas u-menu-1 u-enable-responsive" data-responsive-from="XL">
          <div class="menu-collapse" style="font-size: 1rem; letter-spacing: 0px; font-weight: 500;" wfd-invisible="true">
            <a class="u-button-style u-custom-active-color u-custom-border u-custom-border-color u-custom-hover-color u-custom-left-right-menu-spacing u-custom-padding-bottom u-custom-text-active-color u-custom-text-color u-custom-text-hover-color u-custom-top-bottom-menu-spacing u-nav-link u-text-active-palette-1-base u-text-hover-palette-2-base" href="https://website357249.nicepage.io/Page-4.html?version=cdd5b8b4-a731-4350-8aa5-84cc127acf07#">
              <svg><use xlink:href="#menu-hamburger"></use></svg>
              <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><defs><symbol id="menu-hamburger" viewBox="0 0 16 16" style="width: 16px; height: 16px;"><rect y="1" width="16" height="2"></rect><rect y="7" width="16" height="2"></rect><rect y="13" width="16" height="2"></rect>
</symbol>
</defs></svg>
            </a>
          </div>
          
          <div class="u-custom-menu u-nav-container-collapse" wfd-invisible="true">
            <div class="u-black u-container-style u-inner-container-layout u-opacity u-opacity-95 u-sidenav">
              <div class="u-sidenav-overflow">
                <div class="u-menu-close"></div>
                <ul class="u-align-center u-nav u-popupmenu-items u-unstyled u-nav-2"><li class="u-nav-item"><a class="u-button-style u-nav-link" href="../index.php" data-page-id="358254" style="padding: 10px 20px;">หน้าหลัก</a>
                </li></ul>
                <ul class="u-align-center u-nav u-popupmenu-items u-unstyled u-nav-2"><li class="u-nav-item"><a class="u-button-style u-nav-link" href="./jobactivity.php" data-page-id="358254" style="padding: 10px 20px;">Job activity</a>
                </li></ul>
                <ul class="u-align-center u-nav u-popupmenu-items u-unstyled u-nav-2"><li class="u-nav-item"><a class="u-button-style u-nav-link" href="." data-page-id="358254" style="padding: 10px 20px;">Equipemt monitoring</a>
                </li></ul>
                <ul class="u-align-center u-nav u-popupmenu-items u-unstyled u-nav-2"><li class="u-nav-item"><a class="u-button-style u-nav-link" href="." data-page-id="358254" style="padding: 10px 20px;">Log monitoring</a>
                </li></ul>
              </div>
            </div>
            <div class="u-black u-menu-overlay u-opacity u-opacity-70" wfd-invisible="true"></div>
          </div>
        <style class="offcanvas-style">            .u-offcanvas .u-sidenav { flex-basis: 250px !important; }            .u-offcanvas:not(.u-menu-open-right) .u-sidenav { margin-left: -250px; }            .u-offcanvas.u-menu-open-right .u-sidenav { margin-right: -250px; }            @keyframes menu-shift-left    { from { left: 0;        } to { left: 250px;  } }            @keyframes menu-unshift-left  { from { left: 250px;  } to { left: 0;        } }            @keyframes menu-shift-right   { from { right: 0;       } to { right: 250px; } }            @keyframes menu-unshift-right { from { right: 250px; } to { right: 0;       } }            </style></nav>
      </div></header>
    
    <section class="u-clearfix u-expanded-width-xl u-section-2" id="sec-3d32">
      <div class="u-clearfix u-sheet u-sheet-1">
        <div class="u-clearfix u-expanded-width u-gutter-0 u-layout-wrap u-layout-wrap-1" style="margin-top:unset;">
          <div class="u-gutter-0 u-layout">
            <div class="u-layout-row">
              <div class="u-size-28">
                <div class="u-layout-col">
                  <div class="u-align-left u-container-style u-image u-layout-cell u-left-cell u-size-60 u-image-1" style="background-size: 100% auto;flex: unset;" data-image-width="800" data-image-height="784">
                    <div class="u-container-layout u-container-layout-1"></div>
                  </div>
                </div>
              </div>
              <div class="u-size-32">
                <div class="u-layout-row">
                  <div class="u-container-style u-layout-cell u-right-cell u-size-60 u-layout-cell-2">
                    <div class="u-container-layout u-container-layout-2">
                      <h2 class="u-text u-text-grey-70 u-text-1">Register Equipment Form</h2>
                      <div class="u-expanded-width u-form u-form-1">
                        <form action="https://nicepage.com/editor/Forms/Process" method="POST" class="u-block-25d6-21 u-clearfix u-form-spacing-25 u-form-vertical u-inner-form" source="email"><!-- hidden inputs for siteId and pageId -->
                          <input type="hidden" id="siteId" name="siteId" value="357249">
                          <input type="hidden" id="pageId" name="pageId" value="358254">
                          <div class="u-form-group u-form-name">
                            <label for="name-e4cc" class="u-form-control-hidden u-label">group_Name</label>
                            <input type="text" placeholder="หมวดอุปกรณ์" id="name-e4cc" name="group_Name" class="u-border-no-bottom u-border-no-left u-border-no-right u-border-no-top u-grey-5 u-input u-input-rectangle" required="">
                          </div><!-- always visible -->
                          <div class="u-form-group u-form-name">
                            <label for="name-e4cc" class="u-form-control-hidden u-label">Name</label>
                            <input type="text" placeholder="ชื่ออุปกรณ์" id="name-e4cc" name="name" class="u-border-no-bottom u-border-no-left u-border-no-right u-border-no-top u-grey-5 u-input u-input-rectangle" required="">
                          </div><!-- always visible -->
                          <div class="u-form-group u-form-name">
                            <label for="name-e4cc" class="u-form-control-hidden u-label">Asset_code</label>
                            <input type="text" placeholder="Asset code" id="name-e4cc" name="Asset_code" value="<?php echo isset($asData['asset']) ? $asData['asset'] : '';?>" class="u-border-no-bottom u-border-no-left u-border-no-right u-border-no-top u-grey-5 u-input u-input-rectangle" required="">
                          </div><!-- always visible -->
                          <div class="u-form-group u-form-name">
                            <label for="name-e4cc" class="u-form-control-hidden u-label">series_code</label>
                            <input type="text" placeholder="series code" id="name-e4cc" name="series_code" value="<?php echo isset($asData['serial_no']) ? $asData['serial_no'] : '';?>" class="u-border-no-bottom u-border-no-left u-border-no-right u-border-no-top u-grey-5 u-input u-input-rectangle" required="">
                          </div><!-- always visible -->
                          <div class="u-form-group u-form-message">
                            <label for="message-e4cc" class="u-form-control-hidden u-label">detail</label>
                            <textarea placeholder="รายละเอียดอุปกรณ์" rows="4" cols="50" id="detail" name="message" class="u-border-no-bottom u-border-no-left u-border-no-right u-border-no-top u-grey-5 u-input u-input-rectangle" required=""></textarea>
                          </div>
                          <div class="u-form-group u-form-name">
                            <label for="name-e4cc" class="u-form-control-hidden u-label">status_item</label>
                            <input type="text" placeholder="สถานะอุปกรณ์" id="name-e4cc" name="status_item" class="u-border-no-bottom u-border-no-left u-border-no-right u-border-no-top u-grey-5 u-input u-input-rectangle" required="">
                          </div><!-- always visible -->
                          <div class="u-form-group u-form-name">
                            <label for="name-e4cc" class="u-form-control-hidden u-label">address_item</label>
                            <input type="text" placeholder="ตำแหน่งอุปกรณ์" id="name-e4cc" name="address_item" class="u-border-no-bottom u-border-no-left u-border-no-right u-border-no-top u-grey-5 u-input u-input-rectangle" required="">
                          </div><!-- always visible -->
                          <div class="u-form-email u-form-group">
                            <label for="email-e4cc" class="u-form-control-hidden u-label">job_assing</label>
                            <div class="custom-select" style="width:100%;">
                              <select name="job_assing">
                                <option value="0">ผู้ตรวจสอบ</option>
                                <option value="1">Audi</option>
                                <option value="2">BMW</option>
                                <option value="3">Citroen</option>
                                <option value="4">Ford</option>
                                <option value="5">Honda</option>>
                              </select>
                            </div>
                            <!-- <input type="email" placeholder="ผู้รับผิดชอบ" id="email-e4cc" name="owner" class="u-border-no-bottom u-border-no-left u-border-no-right u-border-no-top u-grey-5 u-input u-input-rectangle" required=""> -->
                            
                          </div>
                          <div class="u-form-group u-form-message">
                            <label for="message-e4cc" class="u-form-control-hidden u-label">more_detail</label>
                            <textarea placeholder="รายละเอียดเพิ่มเติม" rows="4" cols="50" id="message-e4cc" name="more_detail" class="u-border-no-bottom u-border-no-left u-border-no-right u-border-no-top u-grey-5 u-input u-input-rectangle" required=""></textarea>
                          </div>
                          <div class="u-form-group u-form-name">
                            <label for="name-e4cc" class="u-form-control-hidden u-label">existing_item_detail</label>
                            <input type="text" placeholder="อุปกรณ์ซ้ำซ่อนเพิ่มเติม" id="name-e4cc" name="existing_item_detail" class="u-border-no-bottom u-border-no-left u-border-no-right u-border-no-top u-grey-5 u-input u-input-rectangle" required="">
                          </div><!-- always visible -->
                          <div class="u-form-group u-form-submit" style="  text-align: center;">
                            <a href="https://website357249.nicepage.io/Page-4.html?version=cdd5b8b4-a731-4350-8aa5-84cc127acf07#" class="u-border-2 u-border-grey-dark-1 u-btn u-btn-round u-btn-submit u-button-style u-none u-radius-30 u-btn-1">Save Draft</a>
                            <input type="submit" value="submit" class="u-form-control-hidden u-grey-5">
                            <a href="https://website357249.nicepage.io/Page-4.html?version=cdd5b8b4-a731-4350-8aa5-84cc127acf07#" class="u-border-2 u-border-grey-dark-1 u-btn u-btn-round u-btn-submit u-button-style u-none u-radius-30 u-btn-1" style="background-color: #21fb1de0 !important" >Submit</a>
                            <input type="submit" value="submit" class="u-form-control-hidden u-grey-5">
                          </div>
                          
                          <div class="u-form-send-message u-form-send-success"> Thank you! Your message has been sent. </div>
                          <div class="u-form-send-error u-form-send-message"> Unable to send your message. Please fix errors then try again. </div>
                          <input type="hidden" value="" name="recaptchaResponse">
                        </form>
                      </div>
                     
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    
    
<footer class="u-align-center u-clearfix u-footer u-grey-80 u-footer" id="sec-4ef6"><div class="u-clearfix u-sheet u-sheet-1">
        <p class="u-small-text u-text u-text-variant u-text-1">Copyright © — Operations and Maintenance CATV</p>
      </div></footer>


    
</body></html>