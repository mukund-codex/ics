<?php
    include('site-config.php');
    $data = $func->getAllBanners();
    $aboutus = $func->getGalleryContent();
   // $s = $func->getGalleryLastestContent();

    $sql = "SELECT * FROM `dc_home_carousel` ORDER BY id ASC";
    $result = $func->query($sql);
    $arr_result=array();
    while($row = $func->fetch($result)){  
      array_push($arr_result,$row);
    }

    $sqlUG = "SELECT * FROM `dc_undergraduate_images` ORDER BY id ASC";
    $resultUG = $func->query($sqlUG);

    $sqlPG = "SELECT * FROM `dc_postgraduate_images` ORDER BY id ASC";
    $resultPG = $func->query($sqlPG);

    $sqlOC = "SELECT * FROM `dc_other_images` ORDER BY id ASC";
    $resultOC = $func->query($sqlOC);

    $sqlINFA = "SELECT * FROM `dc_infrastructure_images` ORDER BY id ASC";
    $resultINFA = $func->query($sqlINFA);

    $arr  = array();
    $sqlHT = "SELECT * FROM `dc_home_all_title_changes_tbl_link` ORDER BY id ASC";
    $resultHT = $func->query($sqlHT);
    // $rowHTDisplay = $func->fetch($resultHT);
    while($row = $func->fetch($resultHT)){ 
        array_push($arr,$row['head_title']);
    }
   // print_r($arr) ;exit;

    


    
  
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Ics - ICS KHED</title>
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
    <section>
        <div class="flexslider" id="home-slider">
            <ul class="slides">
                <?php
        while($row = $func->fetch($data)){ 
          $file_name = str_replace('', '-', strtolower( pathinfo($row['banner_img'], PATHINFO_FILENAME)));
          $ext = pathinfo($row['banner_img'], PATHINFO_EXTENSION); 
      ?>
                <li>
                    <img src="img/banner/<?php echo $file_name.'_crop.'.$ext; ?>" alt="">
                    <div class="slide-wrap light">
                        <div class="slide-content">
                            <div class="container">
                                <!-- <h5 class="mb-15 serif">ICS KHED</h5> -->
                                <h1 style="color:#fff"><?php echo $row['title']; ?></h1>
                                <h4 class="serif" style="color:#fff"><?php echo $row['sub_title'] ;?></h4>
                                <!-- <p class="mt-25"><a class="btn btn-dark-out" href="#">About Us</a><a class="btn btn-color" href="#">Our
                    Works</a>
                </p> -->
                            </div>
                        </div>
                    </div>
                </li>
                <?php
        }
      ?>
            </ul>
        </div>
    </section>

    <!-- About Section -->
    <section style="background-color:#E8E7E5;padding-bottom:25px">
        <div class="container">
            <div class="section-content">
                <?php
         $row = $aboutus;
         $file_name = str_replace('', '-', strtolower( pathinfo($row['image'], PATHINFO_FILENAME)));
         $ext = pathinfo($row['image'], PATHINFO_EXTENSION); 
      ?>
                <div class="row">
                    <div class="col-sm-6 mb-25 mt-25">
                        <img src="img/aboutus/<?php echo $file_name.'_crop.'.$ext; ?>" />
                    </div>
                    <div class="col-sm-6 mb-25 mt-25">
                        <div class="title center">
                            <h2><?php echo $arr[0]?></h2>
                        </div>
                        <!-- <p>Welcome to I.C.S. College, one of the most prestigious institute of higher learning. This college was established in 1990 with noble goal 'Rashtrodhararth Sevamahe' i.e. service to rural India for development of nation. Today I am very happy to announce that we are on progressive steps towards our goal, mission & visionary objectives. In this eventful journey, the college has taken progressive initiatives to mature into a vibrant center of excellence.
            </p>
            <p>
            We believe that, education is not just about earning degrees & certificates. So we go beyond the confines of classroom & established curriculum to unlock the hidden potential of each student through various NSS, NCC camps, field study & study tours. The emphasis is on the analytical mind & scientific temper alongwith imparting of moral values that equip the student to combat whatever challenges they encounter. Read More <div class="post-info upper"><a class="small-link black-text" href="#"><span>Read More</span><i
                    class="hc-arrow-right"></i> </a> </div>
            </p> -->
                        <?php echo $row['description']; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Award Section -->
    <!-- Award Section -->
    <section style="padding-top:25px">
        <div class="container">
            <div class="title center">
                <h2><?php echo $arr[1]?></h2>
            </div>
            <?php  
      
      foreach ($arr_result as $value) {
        
        $file_name = str_replace('', '-', strtolower( pathinfo($value['image_name'], PATHINFO_FILENAME)));
        $ext = pathinfo($value['image_name'], PATHINFO_EXTENSION);  
      ?>
            <div class="col-sm-4">
                <div class="icon-box">
                    <img src="img/achievements/<?php echo $file_name.'_crop.'.$ext; ?>" width="50%">
                    <br>
                    <div class="ib-content">
                        <h4><?php echo $value['title'];?></h4>
                        <p><?php echo $value['sub_title'];?></p>
                    </div>
                </div>
            </div>
            <?php }
      ?>

        </div>
    </section>

    <!-- COurses now section -->

    <section style="padding-top:30px;">
        <div class="container">
            <div class="title center">
                <h2><?php echo $arr[2]?> </h2>

            </div>
            <center>
                <h4 style="font-weight:700"><?php echo $arr[3]?> </h4>
            </center>
            <div class="wide three-col" id="works-grid">
                <?php while($row= $func->fetch($resultUG)) 
                {
                  $file_name = str_replace('', '-', strtolower( pathinfo($row['undergraduate_image'], PATHINFO_FILENAME)));
                  $ext = pathinfo($row['undergraduate_image'], PATHINFO_EXTENSION); 
                  $coruses_id = $row['coruses_id'];
                  
                  $sqlcount = "SELECT COUNT(coruses_id) as countid FROM `dc_ourvision` WHERE coruses_id = '$coruses_id' AND courses_category='UG'";
                  $resultcount = $func->query($sqlcount);
                  $row1 = $func->fetch($resultcount);
                  if($row1['countid'] > 0 )
                  {
                  ?>
                <div class="work-item branding">
                    <div class="work-detail">
                        <a href="../ics/undergraduate-courses.php?courses=<?php echo $row['coruses_id'];?>">
                            <img src="img/Undergraduate/<?php echo $file_name.'_crop.'.$ext; ?>"
                                alt="No Images available">
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

                <?php 
                  }else{
                      ?>
                <div class="work-item branding">
                    <div class="work-detail">
                        <a href="../ics/department.php?courses=<?php echo $row['coruses_id'];?>">
                            <img src="img/Undergraduate/<?php echo $file_name.'_crop.'.$ext; ?>"
                                alt="No Images available">
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
                <?php 
                  }
              } 
              ?>
            </div>

            <!-- Postgraduate Courses -->
            <br style="padding-top:50px;">
            <center>
                <h4 style="font-weight:700"><?php echo $arr[4]?> </h4>
            </center>
            <div class="wide three-col" id="works-grid">
                <?php while($row= $func->fetch($resultPG)) 
                {
                  $file_name = str_replace('', '-', strtolower( pathinfo($row['postgraduate_image'], PATHINFO_FILENAME)));
                  $ext = pathinfo($row['postgraduate_image'], PATHINFO_EXTENSION); 
                  $coruses_id = $row['coruses_id'];
                  
                  $sqlcount = "SELECT COUNT(coruses_id) as countid FROM `dc_ourvision` WHERE coruses_id = '$coruses_id' AND courses_category='PG'";
                  $resultcount = $func->query($sqlcount);
                  $row1 = $func->fetch($resultcount);
                  if($row1['countid'] > 0 )
                  {
                  ?>
                <div class="work-item branding">
                    <div class="work-detail">
                        <a href="../ics/postgraduate-courses.php?courses=<?php echo $row['coruses_id'];?>">
                            <img src="img/Postgraduate/<?php echo $file_name.'_crop.'.$ext; ?>"
                                alt="No Images available">
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

                <?php 
                  }else{
                      ?>
                <div class="work-item branding">
                    <div class="work-detail">
                        <a href="../ics/department.php?courses=<?php echo $row['coruses_id'];?>">
                            <img src="img/Postgraduate/<?php echo $file_name.'_crop.'.$ext; ?>"
                                alt="No Images available">
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
                <?php 
                  }
              } 
              ?>
            </div>

        </div>
    </section>

    <!-- Postgraduate Courses -->






    <!--Other Courses Section -->


    <section style="background-color:#E8E7E5;padding-bottom:25px;">
        <div class="container">
            <div class="section-content">
                <div class="title center">
                    <h2><?php echo $arr[7]?> </h2>
                </div>

                <center>
                    <h4 style="font-weight:700;"><?php echo $arr[5]?> </h4>
                </center>
                <div class="wide two-col" id="works-grid">
                    <?php while($row= $func->fetch($resultOC)) {
          $file_name = str_replace('', '-', strtolower( pathinfo($row['other_image'], PATHINFO_FILENAME)));
          $ext = pathinfo($row['other_image'], PATHINFO_EXTENSION);  
          ?>
                    <div class="work-item branding">
                        <div class="work-detail">
                            <a href="../ics/othergraduate-courses.php?courses=<?php echo $row['coruses_id'];?>">
                                <img src="img/Other/<?php echo $file_name.'_crop.'.$ext; ?>" alt="MSC IT">
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
                    <?php  } ?>
                </div>

            </div>
    </section>
    <!--Other Courses Section -->


    <!-- Infrastructure-->

    <section style="background-color:#e8e7e5">
        <div class="container">
            <div class="title center">
                <h2> <?php echo $arr[6]?> </h2>
            </div>
            <div class="section-content">
                <div class="flexslider image-slider"
                    data-options="{&quot;animation&quot;: &quot;slide&quot;, &quot;directionNav&quot;: true}">
                    <ul class="slides">
                        <?php while($row= $func->fetch($resultINFA)) {
                        $file_name = str_replace('', '-', strtolower( pathinfo($row['Infra_image'], PATHINFO_FILENAME)));
                        $ext = pathinfo($row['Infra_image'], PATHINFO_EXTENSION);  
                        ?>
                        <li>
                            <img src="img/Infrastructure/<?php echo $file_name.'_crop.'.$ext; ?>" alt="">

                            <div class="slide-caption">
                                <div class="title">
                                    <h2><?php echo $row['title']?></h2>
                                </div>
                                <p class="mt-25 mb-25"><?php echo $row['sub_title'];?></p><a class="upper small-link"
                                    href="#"><span>Read More</span><i class="hc-arrow-right"></i></a>
                            </div>
                        </li>
                        <?php
                      }
                        ?>
                    </ul>
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

</html>