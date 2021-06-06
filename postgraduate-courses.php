<?php 
include('site-config.php');
$type = "PGC";
$courses = trim($_GET['courses']);
$filtercourses = $courses;
$sql = "SELECT * FROM `dc_ugraduate_courses_images` where courses_category='$type' ORDER BY created_at ASC";
$resultimage = $func->query($sql);

// $sqlD = "SELECT * FROM `dc_courses_description`  where course_type='PG' ";
// $resultD = $func->query($sqlD);

$sqlForTitleDes = "SELECT  * FROM `dc_title_descrption` where coruses_id= '$filtercourses'  ";
$resultTitleDes = $func->query($sqlForTitleDes);
$rowtitledis = $func->fetch($resultTitleDes);




$sqlV = "SELECT * FROM `dc_ourvision`  where courses_category='PG' and coruses_id = '$filtercourses'";
$resultV = $func->query($sqlV);
$rowV = $func->fetch($resultV);

$sqlM = "SELECT * FROM `dc_ourmission`  where courses_category='PG' and coruses_id = '$filtercourses'";
$resultM = $func->query($sqlM);
$rowM = $func->fetch($resultM);

$sqlG = "SELECT * FROM `dc_ourgoal`  where courses_category='PG' and coruses_id = '$filtercourses'";
$resultG = $func->query($sqlG);
$rowG = $func->fetch($resultG);

//done

$sqlF = "SELECT * FROM `dc_faculty`  where courses_category='PG' ORDER BY id ASC";
$resultF = $func->query($sqlF);


$sqlL = "SELECT * FROM `dc_laboratory` where courses_category='PG' ORDER BY id ASC";
$resultL = $func->query($sqlL);

$sqlSA = "SELECT * FROM `dc_student_academic`  where courses_category='$type' ORDER BY id ASC";
$resultSA = $func->query($sqlSA);

$sqlSC = "SELECT * FROM `dc_student_curricular`  where courses_category='$type' ORDER BY id ASC";
$resultSC = $func->query($sqlSC);


$sqlForCI = "SELECT  * FROM `dc_carousel_images` where coruses_id= '$filtercourses' ";
$resultCI = $func->query($sqlForCI);


$sqlcimg = "SELECT * FROM `dc_subtype_courses_images`  where courses_category='PG' AND coruses_id = '$filtercourses'  ORDER BY id ASC";
$resultcimg = $func->query($sqlcimg);

?>

<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from themes.hody.co/html/dylan/shop-single.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 13 Feb 2021 11:07:15 GMT -->

<head>
    <title>Ics - ICS KHED | Postgraduate Courses</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="images/favicon.png">
    <link rel="stylesheet" href="css/bundle.css">
    <link rel="stylesheet" href="css/hody-icons.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="searchengine.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,500" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Quattrocento:400,700" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Tangerine:400" rel="stylesheet" type="text/css">
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <script>
    (function(i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function() {
            (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
        a = s.createElement(o),
            m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', '../../../www.google-analytics.com/analytics.js', 'ga');

    ga('create', 'UA-46276885-17', 'auto');
    ga('send', 'pageview');
    </script>

    <style>
    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    td,
    th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }

    tr:nth-child(even) {
        background-color: #dddddd;
    }
    </style>
</head>

<body>
    <!-- Preloader-->
    <div id="loader">
        <div class="centrize">
            <div class="v-center">
                <div id="mask">
                    <span></span>
                </div>
            </div>
        </div>
    </div>
    <!-- End Preloader-->
    <!-- Navigation Bar-->

    <?php include('common/header.php') ?>
    <section style="display:none;">
        <div class="flexslider" id="home-slider">
            <ul class="slides">
                <li>
                    <img src="https://icskhed.org/wp-content/uploads/2017/11/IMG_3249.jpg" alt="">
                    <div class="slide-wrap light">
                        <div class="slide-content">
                            <div class="container">
                                <!-- <h5 class="mb-15 serif">ICS KHED</h5> -->
                                <h1 style="color:#fff">ICS KHED</h1>
                                <!-- <h5 class="serif">A unique, goal-driven approach.</h5>
                <p class="mt-25"><a class="btn btn-dark-out" href="#">About Us</a><a class="btn btn-color" href="#">Our
                    Works</a>
                </p> -->
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <img src="https://icskhed.org/wp-content/uploads/2018/08/IMG-20180731-WA0008.jpg" alt="">
                    <div class="slide-wrap light">
                        <div class="slide-content">
                            <!-- <div class="container">
                <h5 class="mb-15 serif">We are creative.</h5>
                <h1>Smart Design.</h1>
                <h5 class="serif">A unique, goal-driven approach.</h5>
                <p class="mt-25"><a class="btn btn-dark-out" href="#">About Us</a><a class="btn btn-color" href="#">Our
                    Works</a>
                </p>
              </div> -->
                        </div>
                    </div>
                </li>
                <li>
                    <img src="https://icskhed.org/wp-content/uploads/2019/02/WhatsApp-Image-2019-01-30-at-15.44.13.jpeg"
                        alt="">
                    <div class="slide-wrap light">
                        <div class="slide-content">
                            <!-- <div class="container">
                <h5 class="mb-15 serif">We are creative.</h5>
                <h1>Smart Design.</h1>
                <h5 class="serif">A unique, goal-driven approach.</h5>
                <p class="mt-25"><a class="btn btn-dark-out" href="#">About Us</a><a class="btn btn-color" href="#">Our
                    Works</a>
                </p>
              </div> -->
                        </div>
                    </div>
                </li>
                <li>
                    <img src="https://icskhed.org/wp-content/uploads/2019/02/jNew.jpg" alt="">
                    <div class="slide-wrap light">
                        <div class="slide-content">
                            <!-- <div class="container">
                <h5 class="mb-15 serif">We are creative.</h5>
                <h1>Smart Design.</h1>
                <h5 class="serif">A unique, goal-driven approach.</h5>
                <p class="mt-25"><a class="btn btn-dark-out" href="#">About Us</a><a class="btn btn-color" href="#">Our
                    Works</a>
                </p>
              </div> -->
                        </div>
                    </div>
                </li>
                <li>
                    <img src="https://icskhed.org/wp-content/uploads/2015/03/IMG-20171007-WA0090.jpg" alt="">
                    <div class="slide-wrap light">
                        <div class="slide-content">
                            <!-- <div class="container">
                <h5 class="mb-15 serif">We are creative.</h5>
                <h1>Smart Design.</h1>
                <h5 class="serif">A unique, goal-driven approach.</h5>
                <p class="mt-25"><a class="btn btn-dark-out" href="#">About Us</a><a class="btn btn-color" href="#">Our
                    Works</a>
                </p>
              </div> -->
                        </div>
                    </div>
                </li>
                <li>
                    <img src="https://icskhed.org/wp-content/uploads/2018/11/IMG-20181127-WA0003.jpg" alt="">
                    <div class="slide-wrap light">
                        <div class="slide-content">
                            <!-- <div class="container">
                <h5 class="mb-15 serif">We are creative.</h5>
                <h1>Smart Design.</h1>
                <h5 class="serif">A unique, goal-driven approach.</h5>
                <p class="mt-25"><a class="btn btn-dark-out" href="#">About Us</a><a class="btn btn-color" href="#">Our
                    Works</a>
                </p>
              </div> -->
                        </div>
                    </div>
                </li>
                <li>
                    <img src="https://icskhed.org/wp-content/uploads/2017/12/DSC_8307.jpg" alt="">
                    <div class="slide-wrap light">
                        <div class="slide-content">
                            <!-- <div class="container">
                <h5 class="mb-15 serif">We are creative.</h5>
                <h1>Smart Design.</h1>
                <h5 class="serif">A unique, goal-driven approach.</h5>
                <p class="mt-25"><a class="btn btn-dark-out" href="#">About Us</a><a class="btn btn-color" href="#">Our
                    Works</a>
                </p>
              </div> -->
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </section>
    <!-- End Navigation Bar-->


    <!-- carousel title description ourvision ourmission ourgoal -->
    <section style="padding-bottom:20px;">
        <div class="container">
            <div class="single-product-details">
                <div class="row">
                    <div class="col-md-6">
                        <div class="flexslider nav-inside" id="product-slider">
                            <ul class="slides">
                                <?php
                                    while($row = $func->fetch($resultCI)){
                                      $file_name = str_replace('', '-', strtolower( pathinfo($row['image'], PATHINFO_FILENAME)));
                                    $ext = pathinfo($row['image'], PATHINFO_EXTENSION); 
                                  
                                  ?>

                                <li data-thumb="img/Department/<?php echo $file_name.'_crop.'.$ext ?>">
                                    <img src="img/Department/<?php echo $file_name.'_crop.'.$ext ?>" alt="">
                                </li>

                                <?php  }?>

                            </ul>
                        </div>
                    </div>
                    <div class="col-md-5 col-md-offset-1">
                        <div class="title m-0">

                        </div>
                        <div class="single-product-price">


                            <h2 class="product_title entry-title"><?php  echo $rowtitledis['title']; ?></h2>
                        </div>
                        <!-- <div class="single-product-price-details">
                <h3><del>$34.99</del><ins>$29.00</ins></h3>
              </div> -->
                        <!-- <div class="single-product-ratings"><span class="rating-stars">
                  <i class="hc-star full">
                  </i><i class="hc-star full">
                  </i><i class="hc-star full">
                  </i><i class="hc-star full">
                  </i><i class="hc-star-empty">
                  </i></span>
              </div> -->

                        <div class="single-product-desc">
                            <h5>Description</h5>

                            <p><?php echo $rowtitledis['description'];?></p>

                        </div>
                        <!-- <div class="single-product-list">
                                <div class="product_meta">
                                    <h5>Informations:</h5>
                                    <p><span>Categories:</span><a href="#">Hoodies</a>,<a href="#">Women</a>
                                    </p>
                                    <p><span>Tags:</span><a href="#">Casual</a>,<a href="#">Hoodie</a>
                                    </p>
                                </div>
                    </div> -->
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="product-tabs mt-50">
                    <ul class="nav nav-tabs boxed-tabs center-tabs" role="tablist">
                        <li class="active" role="presentation"><a href="#first-tab" role="tab" data-toggle="tab">Our
                                Vision</a>
                        </li>
                        <li role="presentation"><a href="#second-tab" role="tab" data-toggle="tab">Our Mission</a>
                        </li>
                        <li role="presentation"><a href="#third-tab" role="tab" data-toggle="tab">Our Goal</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="first-tab" role="tabpanel">

                            <p><?php echo $rowV['description'];?></p>

                        </div>
                        <div class="tab-pane" id="second-tab" role="tabpanel">

                            <p><?php echo $rowM['description'];?></p>

                        </div>
                        <div class="tab-pane" id="third-tab" role="tabpanel">

                            <p><?php echo $rowG['description'];?></p>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end of carousel title description ourvision ourmission ourgoal -->

    <!-- subCategory  -->
    <?php
  
    if($resultcimg->num_rows > 0){ ?>
    <section style="padding-top:30px;">
        <div class="container">
            <div class="title center">
                <h2> Sub Courses </h2>

            </div>
            <center>
                <h4 style="font-weight:700"> Sub Courses </h4>
            </center>
            <div class="wide three-col" id="works-grid">
                <?php while($row= $func->fetch($resultcimg)) 
                {
                  $file_name = str_replace('', '-', strtolower( pathinfo($row['coursesubtype_img'], PATHINFO_FILENAME)));
                  $ext = pathinfo($row['coursesubtype_img'], PATHINFO_EXTENSION); 
                //   $coruses_id = $row['coruses_id'];
                  
                  
                  ?>
                <div class="work-item branding">
                    <div class="work-detail">
                        <a
                            href="../ics/department.php?courses=<?php echo $row['coruses_id'];?>&sub_courses=<?php echo $row['courses_subtype_id'];?>">
                            <img src="img/coursesubtype/<?php echo $file_name.'_crop.'.$ext; ?>"
                                alt="No Images available">
                            <div class="work-info">
                                <div class="centrize">
                                    <div class="v-center">
                                        <h3><?php echo $row['courses_subtype'];?></h3>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <?php 
                  
              } 
              ?>
            </div>



        </div>
    </section>
    <?php } ?>

    <!-- subCategory -->


    <?php
  
    if($resultF->num_rows > 0){ ?>
    <section style="padding-top:0px;padding-bottom:50px;">
        <div class="container">
            <div class="title center">
                <h2> Faculty </h2>
            </div>
            <table>
                <tr>
                    <th>Name</th>
                    <th>Department</th>
                    <th>Designation</th>
                </tr>
                <?php
                while($row = $func->fetch($resultF)){
              ?>
                <tr>
                    <th><?php echo $row['name'];?></th>
                    <th><?php echo $row['department'];?></th>
                    <th><?php echo $row['designation']?></th>
                </tr>
                <?php  }
                ?>

            </table>
        </div>
    </section>
    <?php } ?>




    <?php
    
    if($resultL->num_rows > 0){ ?>
    <section style="padding-top:0px;padding-bottom:50px;">
        <div class="container">
            <div class="title center">
                <h2> Laboratory </h2>
            </div>
            <table>
                <tr>
                    <th>Name of Lab</th>
                    <th>Lab Incharge</th>
                    <th>Contact Number</th>
                </tr>
                <?php
                while($row = $func->fetch($resultL)){
              ?>
                <tr>
                    <th><?php echo $row['lab_name'];?></th>
                    <th><?php echo $row['lab_incharge'];?></th>
                    <th><?php echo $row['lab_contactno']?></th>
                </tr>
                <?php  }
                ?>

            </table>
        </div>
    </section>
    <?php } ?>




    <?php
   
    if($resultSC->num_rows > 0){ ?>
    <section style="padding-top:20px;padding-bottom:50px;">
        <div class="container">
            <div class="title center">
                <h2> Student Co-Curricular Activities </h2>
            </div>
            <div class="wide three-col" id="works-grid" style="position: relative; height: 526.376px;">
                <?php
                while($row = $func->fetch($resultSC)){
                  $file_name = str_replace('', '-', strtolower( pathinfo($row['image'], PATHINFO_FILENAME)));
                 $ext = pathinfo($row['image'], PATHINFO_EXTENSION); 
               
              ?>
                <div class="work-item branding" style="position: absolute; left: 0px; top: 0px;">
                    <div class="work-detail">
                        <a href="#">
                            <img src="img/StudentCo-Curricular/postgraduate/<?php echo $file_name.'_crop.'.$ext ?>"
                                alt="Arts">
                            <div class="work-info">
                                <div class="centrize">
                                    <div class="v-center">
                                        <h3><?php echo $row['title'];?></h3>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </section>
    <?php } ?>




    <?php
    
    if($resultSA->num_rows > 0){ ?>
    <section style="padding-top:30px;">
        <div class="container">
            <div class="title center">
                <h2> Student Academic Activities </h2>
            </div>
            <div class="wide three-col" id="works-grid" style="position: relative; height: 526.376px;">
                <?php
                while($row = $func->fetch($resultSA)){
                  $file_name = str_replace('', '-', strtolower( pathinfo($row['image'], PATHINFO_FILENAME)));
                 $ext = pathinfo($row['image'], PATHINFO_EXTENSION); 
               
              ?>
                <div class="work-item branding" style="position: absolute; left: 0px; top: 0px;">
                    <div class="work-detail">
                        <a href="#">
                            <img src="img/StudentAcademic/postgraduate/<?php echo $file_name.'_crop.'.$ext ?>"
                                alt="Arts">
                            <div class="work-info">
                                <div class="centrize">
                                    <div class="v-center">
                                        <h3><?php echo $row['title'];?></h3>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <?php } ?>

            </div>
        </div>
    </section>
    <?php } ?>


    <?php include('common/footer.php') ?>

    <div id="search-modal">
        <div class="centrize">
            <div class="v-center">
                <div class="container">
                    <div class="search-form">
                        <!-- Search Form-->
                        <form class="searchform">
                            <div class="input-group">
                                <input class="form-control" type="search" data-required="required" name="search"
                                    placeholder="Search..." value="" id="search"><span class="input-group-btn"><button
                                        class="btn btn-color" type="submit"><span><i class="hc-search"></i></span>
                                    </button>
                                </span>
                            </div>
                        </form>

                        <div id="citylist"></div>
                        <!-- End Search Form-->
                    </div>
                </div>
            </div>
        </div>
        <a id="close-search-modal" href="#">
            <i class="hc-close"></i>
        </a>
    </div>

    <div class="go-top">
        <a href="#top">
            <i class="hc-angle-up"></i>
        </a>
    </div>
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/bundle.js"></script>
    <script type="text/javascript" src="js/SmoothScroll.js"></script>
    <script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCNGOsBBZo9vf0Tw4w6aJiilSTFVfQ5GPI"></script>
    <script type="text/javascript" src="js/main.js"></script>
    <script type="text/javascript" src="sreachengine.js"></script>
</body>


<!-- Mirrored from themes.hody.co/html/dylan/shop-single.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 13 Feb 2021 11:07:58 GMT -->

</html>