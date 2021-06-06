<?php 
// $data = $func->getAllBanners();
$sql = "SELECT * FROM `dc_header_aboutus_image` ORDER BY id ASC";
$result = $func->query($sql);

$sqlHAD = "SELECT * FROM `dc_header_aboutus_sanstha` ORDER BY id ASC";
$resultHAD = $func->query($sqlHAD);


//G&A
$sqlGB = "SELECT * FROM `dc_header_governingbody` ORDER BY id ASC";
$resultGB = $func->query($sqlGB);

$sqlBOS = "SELECT * FROM `dc_header_boardofstudies` ORDER BY id ASC";
$resultBOS = $func->query($sqlBOS);

$sqlFC = "SELECT * FROM `dc_header_financecommittee` ORDER BY id ASC";
$resultFC = $func->query($sqlFC);

$sqlCD = "SELECT * FROM `dc_header_collegedevelopment` ORDER BY id ASC";
$resultCD = $func->query($sqlCD);

$sqlAC = "SELECT * FROM `dc_header_academic_council` ORDER BY id ASC";
$resultAC = $func->query($sqlAC);



//Academics
$sqlHA = "SELECT * FROM `dc_header_academic` ORDER BY id ASC";
$resultHA = $func->query($sqlHA);

$sqlHD = "SELECT * FROM `dc_header_department` ORDER BY id ASC";
$resultHD = $func->query($sqlHD);



//IQAC

$sqliqac = "SELECT * FROM `dc_header_iqac` ORDER BY id ASC";
$resultiqac = $func->query($sqliqac);

$sqlaqar = "SELECT * FROM `dc_header_aqar` ORDER BY id ASC";
$resultaqar = $func->query($sqlaqar);

$sqlmom = "SELECT * FROM `dc_header_mom` ORDER BY id ASC";
$resultmom = $func->query($sqlmom);

$sqlnaac = "SELECT * FROM `dc_header_naac` ORDER BY id ASC";
$resultnaac = $func->query($sqlnaac);

$sqldown = "SELECT * FROM `dc_header_download` ORDER BY id ASC";
$resultdown = $func->query($sqldown);







//Examination
$sqlR = "SELECT * FROM `dc_header_rulesregulation` ORDER BY id ASC";
$resultR = $func->query($sqlR);

$sqlHO = "SELECT * FROM `dc_header_others` ORDER BY id ASC";
$resultHO = $func->query($sqlHO);



//Admission
$sqlCOC = "SELECT * FROM `dc_header_codeofcontent` ORDER BY id ASC";
$resultCOC = $func->query($sqlCOC);

$sqlARC = "SELECT * FROM `dc_header_antiraggingcell` ORDER BY id ASC";
$resultARC = $func->query($sqlARC);

$sqlOA = "SELECT * FROM `dc_header_othersadmission` ORDER BY id ASC";
$resultOA = $func->query($sqlOA);




//student corner
$sqlinplink = "SELECT * FROM `dc_header_implink` ORDER BY id ASC";
$resultinplink = $func->query($sqlinplink);

$sqlOS = "SELECT * FROM `dc_header_otherstudent` ORDER BY id ASC";
$resultOS = $func->query($sqlOS);

//logo 

$sqllogo = "select * from dc_header_college_logo order by id asc";
$resultlogo = $func->query($sqllogo);
// print_r($resultAnnouncements);exit;

//ac
$sqlAnnouncements = "SELECT * FROM `dc_announcements` ORDER BY id ASC";
$resultAnnouncements = $func->query($sqlAnnouncements);



?>



<header id="topnavbar" style="border-bottom: 1px solid #e7e7e7;background-color:#515151">
    <div class="container" style="width:90%">
        <div class="row">
            <div class="col-md-12">
                <div class="menu-extras">
                    <div class="menu-item custom-search">
                        <div class="open-search-form">
                            <a href="#">
                                <i class="hc-search"></i>
                            </a>
                        </div>
                    </div>
                    <div class="menu-item toggle-nav">
                        <!-- Mobile menu toggle-->
                        <a class="menu-toggle" href="#">
                            <div class="toggle-inner"></div>
                        </a>
                        <!-- End mobile menu toggle-->
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2 col-sm-6 col-xs-12" style="height:60px;">
                        <div class="btn-container text-left mb-15" style="padding-top: 4px;"><a class="btn btn-dark"
                                target='_blank' href="../ics/dashboard/admin-login.php">Admin Login<span
                                    class="btn-icon btn-icon-animated" style="font-size: large;"><i
                                        class="hc-user"></i></span></a>
                        </div>
                        <!-- <a href="#"> <h3 style="font-size:15px; color:#fff;"> <strong style="padding: 10px;padding-bottom: 15px;background-color: #E43129;"> Admin Login  </strong>  </h3></a>  -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<header id="topnavbar" style="padding-top:10px;padding-bottom:10px;border-bottom: 1px solid #e7e7e7;">
    <div class="container" style="width:90%">
    <?php 
        while($row = $func->fetch($resultlogo)){ 
        $file_name_college_logo = str_replace('', '-', strtolower( pathinfo($row['college_logo'], PATHINFO_FILENAME)));
        $ext_college_logo = pathinfo($row['college_logo'], PATHINFO_EXTENSION); 

        $file_name_college_banner = str_replace('', '-', strtolower( pathinfo($row['college_banner'], PATHINFO_FILENAME)));
        $ext_college_banner = pathinfo($row['college_banner'], PATHINFO_EXTENSION); 
    ?>
        <div class="row">
            <div class="col-md-2 col-sm-3 col-xs-3">
                <img src="img/collegelogo/<?php echo $file_name_college_logo.'_crop.'.$ext_college_logo ?>" class="logo-img" width="70%" />
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-8 col-sm-9 col-xs-9 has-megamenu">
                <img src="img/collegelogo/<?php echo $file_name_college_banner.'_crop.'.$ext_college_banner ?>" width="100%" />
            </div>
        </div>
        <?php } ?>
    </div>
</header>

<header id="topnavbar" style="border-bottom: 1px solid #e7e7e7;background-color:#515151">
    <div class="container" style="width:90%">
        <div class="row">
            <div class="col-md-2 col-sm-6 col-xs-6">
                <h3 class="header-class" style="font-size:15px; color:#fff;padding-left:8%;"> <strong>
                        Announcements</strong> </h3>
            </div>
            <div class="col-md-9 col-sm-6 col-xs-6 has-megamenu">
                <h3>
                    <marquee style="color:#fff; font-size:15px;font-weight:300"> 
                    <?php 
                          while($row = $func->fetch($resultAnnouncements)){ 
                            $file_name = str_replace('', '-', strtolower( pathinfo($row['pdf'], PATHINFO_FILENAME)));
                            $ext = pathinfo($row['pdf'], PATHINFO_EXTENSION); 
                           
                        ?>
                    <a href="<?php echo (!empty($file_name)==1) ? 'img/headers/announcements/'.$file_name.'.'.$ext : $row['link']?>" target="_blank"><?php echo $row['title']; ?></a> 
                     &nbsp;&nbsp;&nbsp;&nbsp; 
                     <?php } ?>
                    
                    </marquee>
                </h3>
            </div>
        </div>
    </div>
</header>

<header id="topnav">
    <div class="container" style="width:100%">
        <!-- Logo container-->
        <!-- <div class="logo">
            <a href="index-2.html">
                <img class="logo-light" src="images/logo_light.png" alt="">
                <img src="images/logo_dark.png" alt="">
            </a>
        </div> -->
        <!-- End Logo container-->
        <div class="row">
            <div class="col-md-12">
                <div class="menu-extras">
                    <div class="menu-item custom-display">
                        <div class="open-search-form">
                            <a href="#">
                                <i class="hc-search"></i>
                            </a>
                        </div>
                    </div>
                    <div class="menu-item toggle-nav">
                        <a class="menu-toggle" href="#">
                            <div class="toggle-inner"></div>
                        </a>
                    </div>
                </div>
                
                <div id="navigation">
                    <ul class="navigation-menu nav">
                        <li class="">
                            <a href="index.php">Home</a>
                        </li>

                        <li class="menu-item-has-children has-megamenu">
                            <a href="#">About Us</a>
                            <ul class="submenu megamenu" style="width:50%;">

                                <li class="menu-item-has-children">
                                    <?php 
                          while($row = $func->fetch($result)){ 
                            $file_name = str_replace('', '-', strtolower( pathinfo($row['image'], PATHINFO_FILENAME)));
                            $ext = pathinfo($row['image'], PATHINFO_EXTENSION); 
                        ?>

                                    <center>
                                        <img alt="">
                                        <img src="img/headers/<?php echo $file_name.'_crop.'.$ext ?>" width="90%" />
                                    </center>

                                    <?php } ?>
                                </li>
                                <li class="menu-item-has-children">
                                    <span>About Sanstha</span>
                                    <ul class="sub-menu">
                        <?php 
                          while($row = $func->fetch($resultHAD)){ 
                            $file_name = str_replace('', '-', strtolower( pathinfo($row['pdf'], PATHINFO_FILENAME)));
                            $ext = pathinfo($row['pdf'], PATHINFO_EXTENSION); 
                            if(!empty($file_name) == 1) {
                        ?>
                                        <li>
                                            <a href="img/headers/<?php echo $file_name.'.'.$ext ?>"
                                                target="_blank"><?php  echo $row['title']; ?></a>
                                        </li>

                        <?php 
                                    
                            }
                            if($row['link']){
                        ?>
                                        <li>
                                            <a href="<?php echo $row['link']; ?>"
                                                target="_blank"><?php  echo $row['title']; ?></a>
                                        </li>
                        <?php
                            }else if(!$row['link'] && !$file_name){
                        ?>
                                        <li>
                                            <a href="#"><?php  echo $row['title']; ?></a>
                                        </li>
                                        <?php
                        }
                        
                        } ?>

                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <li class="menu-item-has-children has-megamenu">
                            <a href="#">Governance & Administration</a>
                            <ul class="submenu megamenu">
                                <li class="menu-item-has-children">
                                    <span>Governing Body</span>
                                    <ul class="sub-menu">
                                    <?php 
                          while($row = $func->fetch($resultGB)){ 
                            $file_name = str_replace('', '-', strtolower( pathinfo($row['pdf'], PATHINFO_FILENAME)));
                            $ext = pathinfo($row['pdf'], PATHINFO_EXTENSION); 
                            if(!empty($file_name) == 1) {
                        ?>
                                        <li>
                                            <a href="img/headers/<?php echo $file_name.'.'.$ext ?>"
                                                target="_blank"><?php  echo $row['title']; ?></a>
                                        </li>

                        <?php 
                                    
                            }
                            if($row['link']){
                        ?>
                                        <li>
                                            <a href="<?php echo $row['link']; ?>"
                                                target="_blank"><?php  echo $row['title']; ?></a>
                                        </li>
                        <?php
                            }else if(!$row['link'] && !$file_name){
                        ?>
                                        <li>
                                            <a href="#"><?php  echo $row['title']; ?></a>
                                        </li>
                                        <?php
                        }
                        
                        } ?>

                                    </ul>
                                </li>
                                <li class="menu-item-has-children">
                                    <span>Board of Studies</span>
                                    <ul class="sub-menu">
                                    <?php 
                          while($row = $func->fetch($resultBOS)){ 
                            $file_name = str_replace('', '-', strtolower( pathinfo($row['pdf'], PATHINFO_FILENAME)));
                            $ext = pathinfo($row['pdf'], PATHINFO_EXTENSION); 
                            if(!empty($file_name) == 1) {
                        ?>
                                        <li>
                                            <a href="img/headers/<?php echo $file_name.'.'.$ext ?>"
                                                target="_blank"><?php  echo $row['title']; ?></a>
                                        </li>

                        <?php 
                                    
                            }
                            if($row['link']){
                        ?>
                                        <li>
                                            <a href="<?php echo $row['link']; ?>"
                                                target="_blank"><?php  echo $row['title']; ?></a>
                                        </li>
                        <?php
                            }else if(!$row['link'] && !$file_name){
                        ?>
                                        <li>
                                            <a href="#"><?php  echo $row['title']; ?></a>
                                        </li>
                                        <?php
                        }
                        
                        } ?>

                                    </ul>
                                </li>
                                <li class="menu-item-has-children">
                                    <span>Finance Committee</span>
                                    <ul class="sub-menu">
                                    <?php 
                          while($row = $func->fetch($resultFC)){ 
                            $file_name = str_replace('', '-', strtolower( pathinfo($row['pdf'], PATHINFO_FILENAME)));
                            $ext = pathinfo($row['pdf'], PATHINFO_EXTENSION); 
                            if(!empty($file_name) == 1) {
                        ?>
                                        <li>
                                            <a href="img/headers/<?php echo $file_name.'.'.$ext ?>"
                                                target="_blank"><?php  echo $row['title']; ?></a>
                                        </li>

                        <?php 
                                    
                            }
                            if($row['link']){
                        ?>
                                        <li>
                                            <a href="<?php echo $row['link']; ?>"
                                                target="_blank"><?php  echo $row['title']; ?></a>
                                        </li>
                        <?php
                            }else if(!$row['link'] && !$file_name){
                        ?>
                                        <li>
                                            <a href="#"><?php  echo $row['title']; ?></a>
                                        </li>
                                        <?php
                        }
                        
                        } ?>

                                    </ul>
                                </li>
                                <li class="menu-item-has-children">
                                    <span>College Devlopment Committee</span>
                                    <ul class="sub-menu">
                                    <?php 
                          while($row = $func->fetch($resultCD)){ 
                            $file_name = str_replace('', '-', strtolower( pathinfo($row['pdf'], PATHINFO_FILENAME)));
                            $ext = pathinfo($row['pdf'], PATHINFO_EXTENSION); 
                            if(!empty($file_name) == 1) {
                        ?>
                                        <li>
                                            <a href="img/headers/<?php echo $file_name.'.'.$ext ?>"
                                                target="_blank"><?php  echo $row['title']; ?></a>
                                        </li>

                        <?php 
                                    
                            }
                            if($row['link']){
                        ?>
                                        <li>
                                            <a href="<?php echo $row['link']; ?>"
                                                target="_blank"><?php  echo $row['title']; ?></a>
                                        </li>
                        <?php
                            }else if(!$row['link'] && !$file_name){
                        ?>
                                        <li>
                                            <a href="#"><?php  echo $row['title']; ?></a>
                                        </li>
                                        <?php
                        }
                        
                        } ?>

                                    </ul>
                                </li>
                                <li class="menu-item-has-children">
                                    <span>Academic Council</span>
                                    <ul class="sub-menu">
                                    <?php 
                          while($row = $func->fetch($resultAC)){ 
                            $file_name = str_replace('', '-', strtolower( pathinfo($row['pdf'], PATHINFO_FILENAME)));
                            $ext = pathinfo($row['pdf'], PATHINFO_EXTENSION); 
                            if(!empty($file_name) == 1) {
                        ?>
                                        <li>
                                            <a href="img/headers/<?php echo $file_name.'.'.$ext ?>"
                                                target="_blank"><?php  echo $row['title']; ?></a>
                                        </li>

                        <?php 
                                    
                            }
                            if($row['link']){
                        ?>
                                        <li>
                                            <a href="<?php echo $row['link']; ?>"
                                                target="_blank"><?php  echo $row['title']; ?></a>
                                        </li>
                        <?php
                            }else if(!$row['link'] && !$file_name){
                        ?>
                                        <li>
                                            <a href="#"><?php  echo $row['title']; ?></a>
                                        </li>
                                        <?php
                        }
                        
                        } ?>

                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-item-has-children has-megamenu">
                            <a href="#">Academics</a>
                            <ul class="submenu megamenu">
                                <li class="menu-item-has-children">
                                    <!-- <span>Academic</span> -->
                                    <ul class="sub-menu">
                                    <?php 
                          while($row = $func->fetch($resultHA)){ 
                            $file_name = str_replace('', '-', strtolower( pathinfo($row['pdf'], PATHINFO_FILENAME)));
                            $ext = pathinfo($row['pdf'], PATHINFO_EXTENSION); 
                            if(!empty($file_name) == 1) {
                        ?>
                                        <li>
                                            <a href="img/headers/<?php echo $file_name.'.'.$ext ?>"
                                                target="_blank"><?php  echo $row['title']; ?></a>
                                        </li>

                        <?php 
                                    
                            }
                            if($row['link']){
                        ?>
                                        <li>
                                            <a href="<?php echo $row['link']; ?>"
                                                target="_blank"><?php  echo $row['title']; ?></a>
                                        </li>
                        <?php
                            }else if(!$row['link'] && !$file_name){
                        ?>
                                        <li>
                                            <a href="#"><?php  echo $row['title']; ?></a>
                                        </li>
                                        <?php
                        }
                        
                        } ?>

                                    </ul>
                                </li>
                                <li class="menu-item-has-children">
                                    <span>Departments</span>
                                    <ul class="sub-menu">
                                    <?php 
                          while($row = $func->fetch($resultHD)){ 
                            $file_name = str_replace('', '-', strtolower( pathinfo($row['pdf'], PATHINFO_FILENAME)));
                            $ext = pathinfo($row['pdf'], PATHINFO_EXTENSION); 
                            if(!empty($file_name) == 1) {
                        ?>
                                        <li>
                                            <a href="img/headers/<?php echo $file_name.'.'.$ext ?>"
                                                target="_blank"><?php  echo $row['title']; ?></a>
                                        </li>

                        <?php 
                                    
                            }
                            if($row['link']){
                        ?>
                                        <li>
                                            <a href="<?php echo $row['link']; ?>"
                                                target="_blank"><?php  echo $row['title']; ?></a>
                                        </li>
                        <?php
                            }else if(!$row['link'] && !$file_name){
                        ?>
                                        <li>
                                            <a href="#"><?php  echo $row['title']; ?></a>
                                        </li>
                                        <?php
                        }
                        
                        } ?>

                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-item-has-children has-megamenu">
                            <a href="#">IQAC</a>
                            <ul class="submenu megamenu">
                                <li class="menu-item-has-children">
                                    <!-- <span>Departments</span> -->
                                    <ul class="sub-menu">
                                    <?php 
                          while($row = $func->fetch($resultiqac)){ 
                            $file_name = str_replace('', '-', strtolower( pathinfo($row['pdf'], PATHINFO_FILENAME)));
                            $ext = pathinfo($row['pdf'], PATHINFO_EXTENSION); 
                            if(!empty($file_name) == 1) {
                        ?>
                                        <li>
                                            <a href="img/headers/<?php echo $file_name.'.'.$ext ?>"
                                                target="_blank"><?php  echo $row['title']; ?></a>
                                        </li>

                        <?php 
                                    
                            }
                            if($row['link']){
                        ?>
                                        <li>
                                            <a href="<?php echo $row['link']; ?>"
                                                target="_blank"><?php  echo $row['title']; ?></a>
                                        </li>
                        <?php
                            }else if(!$row['link'] && !$file_name){
                        ?>
                                        <li>
                                            <a href="#"><?php  echo $row['title']; ?></a>
                                        </li>
                                        <?php
                        }
                        
                        } ?>

                                    </ul>
                                </li>
                                <li class="menu-item-has-children">
                                    <span>AQAR</span>
                                    <ul class="sub-menu">
                                    <?php 
                          while($row = $func->fetch($resultaqar)){ 
                            $file_name = str_replace('', '-', strtolower( pathinfo($row['pdf'], PATHINFO_FILENAME)));
                            $ext = pathinfo($row['pdf'], PATHINFO_EXTENSION); 
                            if(!empty($file_name) == 1) {
                        ?>
                                        <li>
                                            <a href="img/headers/<?php echo $file_name.'.'.$ext ?>"
                                                target="_blank"><?php  echo $row['title']; ?></a>
                                        </li>

                        <?php 
                                    
                            }
                            if($row['link']){
                        ?>
                                        <li>
                                            <a href="<?php echo $row['link']; ?>"
                                                target="_blank"><?php  echo $row['title']; ?></a>
                                        </li>
                        <?php
                            }else if(!$row['link'] && !$file_name){
                        ?>
                                        <li>
                                            <a href="#"><?php  echo $row['title']; ?></a>
                                        </li>
                                        <?php
                        }
                        
                        } ?>

                                    </ul>
                                </li>
                                <li class="menu-item-has-children">
                                    <span>MOM</span>
                                    <ul class="sub-menu">
                                    <?php 
                          while($row = $func->fetch($resultmom)){ 
                            $file_name = str_replace('', '-', strtolower( pathinfo($row['pdf'], PATHINFO_FILENAME)));
                            $ext = pathinfo($row['pdf'], PATHINFO_EXTENSION); 
                            if(!empty($file_name) == 1) {
                        ?>
                                        <li>
                                            <a href="img/headers/<?php echo $file_name.'.'.$ext ?>"
                                                target="_blank"><?php  echo $row['title']; ?></a>
                                        </li>

                        <?php 
                                    
                            }
                            if($row['link']){
                        ?>
                                        <li>
                                            <a href="<?php echo $row['link']; ?>"
                                                target="_blank"><?php  echo $row['title']; ?></a>
                                        </li>
                        <?php
                            }else if(!$row['link'] && !$file_name){
                        ?>
                                        <li>
                                            <a href="#"><?php  echo $row['title']; ?></a>
                                        </li>
                                        <?php
                        }
                        
                        } ?>

                                    </ul>
                                </li>
                                <li class="menu-item-has-children">
                                    <span>NAAC</span>
                                    <ul class="sub-menu">
                                    <?php 
                          while($row = $func->fetch($resultnaac)){ 
                            $file_name = str_replace('', '-', strtolower( pathinfo($row['pdf'], PATHINFO_FILENAME)));
                            $ext = pathinfo($row['pdf'], PATHINFO_EXTENSION); 
                            if(!empty($file_name) == 1) {
                        ?>
                                        <li>
                                            <a href="img/headers/<?php echo $file_name.'.'.$ext ?>"
                                                target="_blank"><?php  echo $row['title']; ?></a>
                                        </li>

                        <?php 
                                    
                            }
                            if($row['link']){
                        ?>
                                        <li>
                                            <a href="<?php echo $row['link']; ?>"
                                                target="_blank"><?php  echo $row['title']; ?></a>
                                        </li>
                        <?php
                            }else if(!$row['link'] && !$file_name){
                        ?>
                                        <li>
                                            <a href="#"><?php  echo $row['title']; ?></a>
                                        </li>
                                        <?php
                        }
                        
                        } ?>

                                    </ul>
                                </li>
                                <li class="menu-item-has-children">
                                    <span>Downloads</span>
                                    <ul class="sub-menu">
                                    <?php 
                          while($row = $func->fetch($resultdown)){ 
                            $file_name = str_replace('', '-', strtolower( pathinfo($row['pdf'], PATHINFO_FILENAME)));
                            $ext = pathinfo($row['pdf'], PATHINFO_EXTENSION); 
                            if(!empty($file_name) == 1) {
                        ?>
                                        <li>
                                            <a href="img/headers/<?php echo $file_name.'.'.$ext ?>"
                                                target="_blank"><?php  echo $row['title']; ?></a>
                                        </li>

                        <?php 
                                    
                            }
                            if($row['link']){
                        ?>
                                        <li>
                                            <a href="<?php echo $row['link']; ?>"
                                                target="_blank"><?php  echo $row['title']; ?></a>
                                        </li>
                        <?php
                            }else if(!$row['link'] && !$file_name){
                        ?>
                                        <li>
                                            <a href="#"><?php  echo $row['title']; ?></a>
                                        </li>
                                        <?php
                        }
                        
                        } ?>

                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-item-has-children has-megamenu">
                            <a href="#">Examination</a>
                            <ul class="submenu megamenu" style="width:100%;">
                                <li class="menu-item-has-children">
                                    <!-- <span>Departments</span> -->
                                    <ul class="sub-menu">
                                    <?php 
                          while($row = $func->fetch($resultHO)){ 
                            $file_name = str_replace('', '-', strtolower( pathinfo($row['pdf'], PATHINFO_FILENAME)));
                            $ext = pathinfo($row['pdf'], PATHINFO_EXTENSION); 
                            if(!empty($file_name) == 1) {
                        ?>
                                        <li>
                                            <a href="img/headers/<?php echo $file_name.'.'.$ext ?>"
                                                target="_blank"><?php  echo $row['title']; ?></a>
                                        </li>

                        <?php 
                                    
                            }
                            if($row['link']){
                        ?>
                                        <li>
                                            <a href="<?php echo $row['link']; ?>"
                                                target="_blank"><?php  echo $row['title']; ?></a>
                                        </li>
                        <?php
                            }else if(!$row['link'] && !$file_name){
                        ?>
                                        <li>
                                            <a href="#"><?php  echo $row['title']; ?></a>
                                        </li>
                                        <?php
                        }
                        
                        } ?>

                                    </ul>
                                </li>
                                <li class="menu-item-has-children">
                                    <span>Rules And Regulations</span>
                                    <ul class="sub-menu">
                                    <?php 
                          while($row = $func->fetch($resultR)){ 
                            $file_name = str_replace('', '-', strtolower( pathinfo($row['pdf'], PATHINFO_FILENAME)));
                            $ext = pathinfo($row['pdf'], PATHINFO_EXTENSION); 
                            if(!empty($file_name) == 1) {
                        ?>
                                        <li>
                                            <a href="img/headers/<?php echo $file_name.'.'.$ext ?>"
                                                target="_blank"><?php  echo $row['title']; ?></a>
                                        </li>

                        <?php 
                                    
                            }
                            if($row['link']){
                        ?>
                                        <li>
                                            <a href="<?php echo $row['link']; ?>"
                                                target="_blank"><?php  echo $row['title']; ?></a>
                                        </li>
                        <?php
                            }else if(!$row['link'] && !$file_name){
                        ?>
                                        <li>
                                            <a href="#"><?php  echo $row['title']; ?></a>
                                        </li>
                                        <?php
                        }
                        
                        } ?>

                                    </ul>
                                </li>

                            </ul>
                        </li>
                        <li class="menu-item-has-children has-megamenu">
                            <a href="#">Admission</a>
                            <ul class="submenu megamenu" style="width:100%;">
                                <li class="menu-item-has-children">
                                    <!-- <span>Departments</span> -->
                                    <ul class="sub-menu">
                                    <?php 
                          while($row = $func->fetch($resultOA)){ 
                            $file_name = str_replace('', '-', strtolower( pathinfo($row['pdf'], PATHINFO_FILENAME)));
                            $ext = pathinfo($row['pdf'], PATHINFO_EXTENSION); 
                            if(!empty($file_name) == 1) {
                        ?>
                                        <li>
                                            <a href="img/headers/<?php echo $file_name.'.'.$ext ?>"
                                                target="_blank"><?php  echo $row['title']; ?></a>
                                        </li>

                        <?php 
                                    
                            }
                            if($row['link']){
                        ?>
                                        <li>
                                            <a href="<?php echo $row['link']; ?>"
                                                target="_blank"><?php  echo $row['title']; ?></a>
                                        </li>
                        <?php
                            }else if(!$row['link'] && !$file_name){
                        ?>
                                        <li>
                                            <a href="#"><?php  echo $row['title']; ?></a>
                                        </li>
                                        <?php
                        }
                        
                        } ?>

                                    </ul>
                                </li>
                                <li class="menu-item-has-children">
                                    <span>Code Of Conduct</span>
                                    <ul class="sub-menu">
                                    <?php 
                          while($row = $func->fetch($resultCOC)){ 
                            $file_name = str_replace('', '-', strtolower( pathinfo($row['pdf'], PATHINFO_FILENAME)));
                            $ext = pathinfo($row['pdf'], PATHINFO_EXTENSION); 
                            if(!empty($file_name) == 1) {
                        ?>
                                        <li>
                                            <a href="img/headers/<?php echo $file_name.'.'.$ext ?>"
                                                target="_blank"><?php  echo $row['title']; ?></a>
                                        </li>

                        <?php 
                                    
                            }
                            if($row['link']){
                        ?>
                                        <li>
                                            <a href="<?php echo $row['link']; ?>"
                                                target="_blank"><?php  echo $row['title']; ?></a>
                                        </li>
                        <?php
                            }else if(!$row['link'] && !$file_name){
                        ?>
                                        <li>
                                            <a href="#"><?php  echo $row['title']; ?></a>
                                        </li>
                                        <?php
                        }
                        
                        } ?>

                                    </ul>
                                </li>
                                <li class="menu-item-has-children">
                                    <span>Anti-Ragging Cell</span>
                                    <ul class="sub-menu">
                                    <?php 
                          while($row = $func->fetch($resultARC)){ 
                            $file_name = str_replace('', '-', strtolower( pathinfo($row['pdf'], PATHINFO_FILENAME)));
                            $ext = pathinfo($row['pdf'], PATHINFO_EXTENSION); 
                            if(!empty($file_name) == 1) {
                        ?>
                                        <li>
                                            <a href="img/headers/<?php echo $file_name.'.'.$ext ?>"
                                                target="_blank"><?php  echo $row['title']; ?></a>
                                        </li>

                        <?php 
                                    
                            }
                            if($row['link']){
                        ?>
                                        <li>
                                            <a href="<?php echo $row['link']; ?>"
                                                target="_blank"><?php  echo $row['title']; ?></a>
                                        </li>
                        <?php
                            }else if(!$row['link'] && !$file_name){
                        ?>
                                        <li>
                                            <a href="#"><?php  echo $row['title']; ?></a>
                                        </li>
                                        <?php
                        }
                        
                        } ?>

                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-item-has-children has-megamenu">
                            <a href="#">Student Corner</a>
                            <ul class="submenu megamenu" style="width:100%;">
                                <li class="menu-item-has-children">
                                    <!-- <span>Departments</span> -->
                                    <ul class="sub-menu">
                                    <?php 
                          while($row = $func->fetch($resultOS)){ 
                            $file_name = str_replace('', '-', strtolower( pathinfo($row['pdf'], PATHINFO_FILENAME)));
                            $ext = pathinfo($row['pdf'], PATHINFO_EXTENSION); 
                            if(!empty($file_name) == 1) {
                        ?>
                                        <li>
                                            <a href="img/headers/<?php echo $file_name.'.'.$ext ?>"
                                                target="_blank"><?php  echo $row['title']; ?></a>
                                        </li>

                        <?php 
                                    
                            }
                            if($row['link']){
                        ?>
                                        <li>
                                            <a href="<?php echo $row['link']; ?>"
                                                target="_blank"><?php  echo $row['title']; ?></a>
                                        </li>
                        <?php
                            }else if(!$row['link'] && !$file_name){
                        ?>
                                        <li>
                                            <a href="#"><?php  echo $row['title']; ?></a>
                                        </li>
                                        <?php
                        }
                        
                        } ?>

                                    </ul>
                                </li>
                                <li class="menu-item-has-children">
                                    <span>Important Links</span>
                                    <ul class="sub-menu">
                                    <?php 
                          while($row = $func->fetch($resultinplink)){ 
                            $file_name = str_replace('', '-', strtolower( pathinfo($row['pdf'], PATHINFO_FILENAME)));
                            $ext = pathinfo($row['pdf'], PATHINFO_EXTENSION); 
                            if(!empty($file_name) == 1) {
                        ?>
                                        <li>
                                            <a href="img/headers/<?php echo $file_name.'.'.$ext ?>"
                                                target="_blank"><?php  echo $row['title']; ?></a>
                                        </li>

                        <?php 
                                    
                            }
                            if($row['link']){
                        ?>
                                        <li>
                                            <a href="<?php echo $row['link']; ?>"
                                                target="_blank"><?php  echo $row['title']; ?></a>
                                        </li>
                        <?php
                            }else if(!$row['link'] && !$file_name){
                        ?>
                                        <li>
                                            <a href="#"><?php  echo $row['title']; ?></a>
                                        </li>
                                        <?php
                        }
                        
                        } ?>

                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="has-megamenu">
                            <a href="#">Alumni</a>

                        </li>
                        <li class="has-megamenu">
                            <a href="contact-us.php">Contact Us</a>

                        </li>

                        <li class="has-megamenu">
                            <a href="#">Photo Gallery</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>