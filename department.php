<?php
    include('site-config.php');
    $data = $data1 = $func->getAllBoxesTabs(); 
    $courses = trim($_GET['courses']);
    $sub_courses = trim($_GET['sub_courses']);
    // function Slug($string)
    // {
    //     return strtolower(trim(preg_replace('~[^0-9a-z]+~i', ' ', html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($string, ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), '-'));
    // }
    $filtercourses = $courses;
    $sqlTitle1 = "SELECT COUNT(coruses_id) as count1 FROM `dc_subtype_courses_list` where coruses_id= '$filtercourses' ";
    $resultTitle1 = $func->query($sqlTitle1);
    $rowcount = $func->fetch($resultTitle1);


   //sub_coruses_carousel_images
    $sqlForCI = "SELECT  * FROM `dc_sub_coruses_carousel_images` where coruses_id= '$filtercourses'  and courses_subtype_id='$sub_courses'";
    $resultCI = $func->query($sqlForCI);

    $sqlForCI1 = "SELECT  * FROM `dc_carousel_images` where coruses_id= '$filtercourses'";
    $resultCI1 = $func->query($sqlForCI1);
    //end of sub caor    

    //only fro title

    $sqlTitle = "SELECT * FROM `dc_subtype_courses_list` where coruses_id= '$filtercourses'  and courses_subtype_id='$sub_courses'";
    $resultTitle = $func->query($sqlTitle);

    $sqlTitle3 = "SELECT * FROM `dc_undergraduate_images` where coruses_id= '$filtercourses' ";
    $resultTitle3 = $func->query($sqlTitle3);
    //
    
    //description
    $sqlForTitleDes = "SELECT  * FROM `dc_title_descrption` where coruses_id= '$filtercourses' ";
    $resultTitleDes = $func->query($sqlForTitleDes);

    $sqlForTitleDes1 = "SELECT  * FROM `dc_sub_coursestitle_descrption` where coruses_id= '$filtercourses' and courses_subtype_id='$sub_courses' ";
    $resultTitleDes1 = $func->query($sqlForTitleDes1);
 
    //end of description

   

    $arrDepartmentId = [];
    $arrDepartmentSubId =[];
    //tabs
    $sqlFordetail = "SELECT * FROM `dc_boxed_tabs` as bt , `dc_departments` as dt where bt.`department_id` = dt.`department_id` AND dt.category_type= '$filtercourses' ";
    $resultsqlFordetail = $func->query($sqlFordetail);



    $sqlFordetail1 = "SELECT * FROM `dc_boxed_tabs` as bt , `dc_departments` as dt where bt.`department_id` = dt.`department_id` AND dt.category_type= '$filtercourses' AND dt.courses_subtype_id='$sub_courses' ";
    $resultsqlFordetail1 = $func->query($sqlFordetail1);
    // echo $sqlFordetail1;exit;



     //ends of tabs
    
   
    
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

    <!-- End Navigation Bar-->

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

    <section style="padding-top:50px;padding-bottom:20px;">
        <div class="title center" style="padding-bottom:50px;">
        <?php
        if($rowcount['count1'] > 0 ){

       
        while($row = $func->fetch($resultTitle)){
        //echo $row['description'];
        
        ?>
            <h2><?php  echo $row['courses_subtype']; ?></h2>
        <?php  
        } 
    }else{
        while($row2 = $func->fetch($resultTitle3)){
            //echo $row['description'];
            
            ?>
                <h2><?php  echo $row2['title']; ?></h2>
            <?php  
            } 
    }

        ?>
        </div>
        <br>
        <div class="container">
            <div class="single-product-details">
                <div class="row">
                    <div class="col-md-6">
                        <div class="flexslider nav-inside" id="product-slider">
                            <ul class="slides">
                              


                            <?php
                                    if($rowcount['count1'] > 0 ){

                                
                                    while($row = $func->fetch($resultCI)){
                                        $file_name = str_replace('', '-', strtolower( pathinfo($row['image'], PATHINFO_FILENAME)));
                                        $ext = pathinfo($row['image'], PATHINFO_EXTENSION); 
                                       ?>
                                    
                                    ?>
                                        <li data-thumb="./img/Department/subcoursestype/<?php echo $file_name.'_crop.'.$ext ?>">
                                            <img src="./img/Department/subcoursestype/<?php echo $file_name.'_crop.'.$ext ?>"
                                                alt="">
                                        </li>
                                    <?php  
                                    } 
                                }else{
                                    while($row2 = $func->fetch($resultCI1)){
                                        $file_name = str_replace('', '-', strtolower( pathinfo($row2['image'], PATHINFO_FILENAME)));
                                        $ext = pathinfo($row2['image'], PATHINFO_EXTENSION); 
                                        
                                        ?>
                                             <li data-thumb="./img/Department/<?php echo $file_name.'_crop.'.$ext ?>">
                                            <img src="./img/Department/<?php echo $file_name.'_crop.'.$ext ?>"
                                                alt="">
                                        </li>
                                        <?php  
                                        } 
                                }

                                    ?>

                            
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-5 col-md-offset-1">
                        <!--<div class="title m-0">-->
                        <!--    <h2 class="product_title entry-title">IT</h2>-->
                        <!--</div>-->
                        <div class="single-product-price">

                        </div>
                        <div class="single-product-desc">
                            <h5>Description</h5>
                                <?php
                                        if($rowcount['count1'] <= 0 ){

                                    
                                        while($row = $func->fetch($resultTitleDes)){
                                        //echo $row['description'];
                                        
                                        ?>
                                            <h2><?php  echo $row['description']; ?></h2>
                                        <?php  
                                        } 
                                    }else{
                                        while($row2 = $func->fetch($resultTitleDes1)){
                                            //echo $row['description'];
                                            
                                            ?>
                                                <h2><?php  echo $row2['description']; ?></h2>
                                            <?php  
                                            } 
                                    }
                                ?>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <section style="padding-top:0px;">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="title center">
                        <h2>Details</h2>
                    </div>
                    <div class="dylan-tabs mt-50">
                        <ul class="nav nav-tabs boxed-tabs center-tabs cols-12">
                        <?php
                            if($rowcount['count1'] <= 0 ){


                                    while($row = $func->fetch($resultsqlFordetail)){
                                    //echo $row['description'];
                                    array_push($arrDepartmentId,$row['department_id']);
                                    ?>
                                    <li class='<?php echo ($row['department_id'] == "1") ? "active" : " ";?>'>
                                    <a href="#boxed-tab-<?php echo $row['department_id'];?>" data-toggle="tab"
                                        aria-expanded="false"><span><?php echo $row['tabs'];?></span></a>

                                    </li>
                                    <?php  
                                    } 
                            }else{
                                while($row2 = $func->fetch($resultsqlFordetail1)){
                                //echo $row['description'];
                                array_push($arrDepartmentSubId,$row2['department_id']);
                                ?>
                            
                            <li class='<?php echo ($row2['department_id'] == "1") ? "active" : " ";?>'>
                                    <a href="#boxed-tab-<?php echo $row2['department_id'];?>" data-toggle="tab"
                                        aria-expanded="false"><span><?php echo $row2['tabs'];?></span></a>

                                    </li>  
                                <?php  
                                } 
                            }
                            ?>
                        </ul>
                    <!-- fffff -->

                            <!-- //tabs -->
                        <div class="tab-content text-center">
                        <?php
                        if($rowcount['count1'] <= 0 ){


                        for ($x = 0; $x <= 9; $x++) {
                            // $a = $arrDepartmentId[$x];
                        $sqlForTabInfo = "SELECT  * FROM `dc_departments` where category_type = '$filtercourses' AND department_id= ".$x." ";
                        $resultTabInfo = $func->query($sqlForTabInfo);
                        
                        while($row = $func->fetch($resultTabInfo)) {
                        ?>
        
                    <div class="tab-pane fade" id="boxed-tab-<?php echo $row['department_id']?>">
                                                    <!-- for text only -->
                        <p><?php echo $row['text']; ?></p>

                        <!-- End of for text only -->
                        <!-- pdf -->
                        <?php if($row['pdf']) {
                                $file_name = str_replace('', '-', strtolower( pathinfo($row['pdf'], PATHINFO_FILENAME)));
                                $ext = pathinfo($row['pdf'], PATHINFO_EXTENSION);
                        ?>
                        <embed src="./img/pdf/<?php echo $file_name.'.'.$ext ?>" width="400px" height="330px" />
                        <?php
                        } ?>
                        <!-- end of pdf -->

                        <!-- images -->

                        <div class="row">
                            <?php
                        $sqlForCI = "SELECT  * FROM `dc_departments_images` where category = '$filtercourses' AND tabs= ".$x." ";
                        $resultCI = $func->query($sqlForCI);
                        while($row = $func->fetch($resultCI)){
                            $file_name = str_replace('', '-', strtolower( pathinfo($row['image'], PATHINFO_FILENAME)));
                            $ext = pathinfo($row['image'], PATHINFO_EXTENSION);
                    
                    ?>

                            <div class="col-md-4">
                                <img src="./img/Department/<?php echo $file_name.'_crop.'.$ext  ?>">
                                <div class="title center">
                                    <!-- <h4>Laboratory</h4> -->
                                </div>
                            </div>
                            <?php 
                        
                        }
                        ?>
                        </div>

                        <!-- end of images -->

                    </div>
        <?php  
        } 
    }
}
else{
    for ($x = 0; $x <= 9; $x++) {
        // $a = $arrDepartmentId[$x];
        $sqlForTabInfo = "SELECT  * FROM `dc_departments` where category_type = '$filtercourses' AND courses_subtype_id='$sub_courses' AND department_id= ".$x." ";
        $resultTabInfo = $func->query($sqlForTabInfo);
        
        while($row = $func->fetch($resultTabInfo)) {
        ?>
     <div class="tab-pane fade" id="boxed-tab-<?php echo $row['department_id']?>">
                                        <!-- for text only -->
            <p><?php echo $row['text']; ?></p>

            <!-- End of for text only -->
            <!-- pdf -->
            <?php if($row['pdf']) {
                    $file_name = str_replace('', '-', strtolower( pathinfo($row['pdf'], PATHINFO_FILENAME)));
                    $ext = pathinfo($row['pdf'], PATHINFO_EXTENSION);
            ?>
            <embed src="./img/pdf/<?php echo $file_name.'.'.$ext ?>" width="400px" height="330px" />
            <?php
            } ?>
            <!-- end of pdf -->

            <!-- images -->

            <div class="row">
                <?php
            $sqlForCI = "SELECT  * FROM `dc_departments_images` where category = '$filtercourses' AND tabs= ".$x." ";
            $resultCI = $func->query($sqlForCI);
            while($row = $func->fetch($resultCI)){
                $file_name = str_replace('', '-', strtolower( pathinfo($row['image'], PATHINFO_FILENAME)));
                $ext = pathinfo($row['image'], PATHINFO_EXTENSION);
        
        ?>

                <div class="col-md-4">
                    <img src="./img/Department/<?php echo $file_name.'_crop.'.$ext  ?>">
                    <div class="title center">
                        <!-- <h4>Laboratory</h4> -->
                    </div>
                </div>
                <?php 
            
            }
            ?>
            </div>

            <!-- end of images -->
        </div>
   
    <?php  
      } 
    }
}
?>




                            <!-- <div class="tab-pane fade" id="boxed-tab-2">

                            </div> -->




                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>

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
                                    placeholder="Search..." value="" id="search" ><span class="input-group-btn"><button
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