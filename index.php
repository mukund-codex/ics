<?php
    include('site-config.php');
    $data = $func->getAllBanners();
    $aboutus = $func->getGalleryContent();
    $s = $func->getGalleryLastestContent();

    $sql = "SELECT * FROM `dc_home_carousel` ORDER BY display_order ASC";
    $result = $func->query($sql);

    $sqlUG = "SELECT * FROM `dc_undergraduate_images` ORDER BY display_order ASC";
    $resultUG = $func->query($sqlUG);

    $sqlPG = "SELECT * FROM `dc_postgraduate_images` ORDER BY display_order ASC";
    $resultPG = $func->query($sqlPG);

    $sqlINFA = "SELECT * FROM `dc_infrastructure_images` ORDER BY display_order ASC";
    $resultINFA = $func->query($sqlINFA);


    
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
                    <img src="img/banner/<?php echo $file_name.'_crop.'.$ext ?>" alt="">
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
                        <img src="img/achievements/<?php echo $file_name.'_crop.'.$ext ?>" />
                    </div>
                    <div class="col-sm-6 mb-25 mt-25">
                        <div class="title center">
                            <h2> About Us </h2>
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
    <section style="padding-top:25px">
        <div class="container">
            <div class="title center">
                <h2> Our Achievements </h2>
            </div>
            <?php while($row = $func->fetch($result)){  
          $file_name = str_replace('', '-', strtolower( pathinfo($row['image_name'], PATHINFO_FILENAME)));
          $ext = pathinfo($row['image_name'], PATHINFO_EXTENSION);   
          ?>
            <div class="col-sm-4">
                <div class="icon-box">
                    <img src="img/achievements/<?php echo $file_name.'_crop.'.$ext ?>" width=50%>
                    <div class="ib-content">
                    <br>
                        <h4><b><?php echo $row['title']; ?></b></h4>
                        <p><?php echo $row['sub_title']; ?></p>
                    </div>
                </div>
            </div>
            <?php 
       } 
     ?>
        </div>
    </section>

    <!-- COurses now section -->

    <section style="padding-top:30px;">
        <div class="container">
            <div class="title center">
                <h2> Courses Offered By Us </h2>
            </div>
            <center>
                <h4 style="font-weight:700"> Undergraduate Courses </h4>
            </center>
            <div class="wide three-col" id="works-grid">
                <?php while($row= $func->fetch($resultUG)) 
                {
                  $file_name = str_replace('', '-', strtolower( pathinfo($row['undergraduate_image'], PATHINFO_FILENAME)));
                  $ext = pathinfo($row['undergraduate_image'], PATHINFO_EXTENSION);  
                  ?>
                <div class="work-item branding">
                    <div class="work-detail">
                        <a href="../ics/department.php?courses=<?php echo $row['title'];?>">
                            <img src="img/Undergraduate/<?php echo $file_name.'_crop.'.$ext ?>"
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
              ?>
            </div>
            <br style="padding-top:50px;">
            <center>
                <h4 style="font-weight:700"> Postgraduate Courses </h4>
            </center>
            <?php while($row= $func->fetch($resultPG)) {
                        $file_name = str_replace('', '-', strtolower( pathinfo($row['postgraduate_image'], PATHINFO_FILENAME)));
                        $ext = pathinfo($row['postgraduate_image'], PATHINFO_EXTENSION);  
                        ?>
            <div class="wide three-col" id="works-grid">
                <div class="work-item branding">
                    <div class="work-detail">
                        <a href="../ics/department.php?courses=<?php echo $row['title'];?>">
                            <img src="img/Postgraduate/<?php echo $file_name.'_crop.'.$ext ?>" alt="MSC IT">
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

            </div>

            <?php
            }
            ?>

        </div>
    </section>

    <!-- Courses new section Ends -->

    <!--Courses Section -->
    <!-- <section style="background-color:#E8E7E5;padding-bottom:25px;">
    <div class="container">
      <div class="section-content">
        <div class="title center">
          <h2> Courses Offered By Us </h2>
        </div>
        <center>
          <h4 style="font-weight:700"> Undergraduate Courses </h4>
        </center>
        <br>
        <div class="row">
          <div class="col-sm-4 mb-25 mt-25">
          <center> <img src="img/arts-img3.jpg" /> </center>
            <center>
              <h5 style="font-weight:600;font-size:22px;"> Arts </h5>
            </center>
            <center> <a href="" > <h5 style="font-weight:700"> View Details </h5> </a> </center>
          </div>
          <div class="col-sm-4 mb-25 mt-25">
            <center><img src="img/science-img3.jpg" width="88%" /></center>
            <center>
              <h5 style="font-weight:600;font-size:22px;"> Science </h5>
            </center>
           <center> <a href="" > <h5 style="font-weight:700"> View Details </h5> </a> </center>
          </div>
          <div class="col-sm-4 mb-25 mt-25">
            <center><img src="img/commerce-img2.jpg" width="66%" /></center>
            <center>
              <h5 style="font-weight:600;font-size:22px;"> Commerce </h5>
            </center>
           <center> <a href="" > <h5 style="font-weight:700"> View Details </h5> </a> </center>
          </div>
          <div class="col-sm-4 mb-25 mt-25">
          <center><img src="img/it-img3.jpg" width=100%" /></center>
            <center>
              <h5 style="font-weight:600;font-size:22px;"> IT </h5>
            </center>
           <center> <a href="" > <h5 style="font-weight:700"> View Details </h5> </a> </center>
          </div>
          <div class="col-sm-4 mb-25 mt-25">
          <center><img src="img/cs-img1.jpg" width=100%" /></center>
            <center>
              <h5 style="font-weight:600;font-size:22px;"> CS </h5>
            </center>
           <center> <a href="" > <h5 style="font-weight:700"> View Details </h5> </a> </center>
          </div>
          <div class="col-sm-4 mb-25 mt-25">
          <center><img src="img/bms-img2.jpg" width=100%" /></center>
            <center>
              <h5 style="font-weight:600;font-size:22px;"> BMS </h5>
            </center>
           <center> <a href="" > <h5 style="font-weight:700"> View Details </h5> </a> </center>
          </div>
        </div>

        <br>

        <center>
          <h4 style="font-weight:700"> Postgraduate Courses </h4>
        </center>
        <div class="row">
          <div class="col-sm-4 mb-25 mt-25">
            <img src="images/portfolio-6.jpg" />
            <center>
              <h5 style="font-weight:600;font-size:22px;"> MSC IT </h5>
            </center>
           <center> <a href="" > <h5 style="font-weight:700"> View Details </h5> </a> </center>
          </div>
          <div class="col-sm-4 mb-25 mt-25">
            <img src="images/portfolio-6.jpg" />
            <center>
              <h5 style="font-weight:600;font-size:22px;"> MBA </h5>
            </center>
           <center> <a href="" > <h5 style="font-weight:700"> View Details </h5> </a> </center>
          </div>
          <div class="col-sm-4 mb-25 mt-25">
            <img src="images/portfolio-6.jpg" />
            <center>
              <h5 style="font-weight:600;font-size:22px;"> MCA </h5>
            </center>
           <center> <a href="" > <h5 style="font-weight:700"> View Details </h5> </a> </center>
          </div>
        </div>
      </div>
    </div>
  </section> -->

    <!-- Infrastructure -->

    <section style="background-color:#e8e7e5">
        <div class="container">
            <div class="title center">
                <h2> Infrastructure </h2>
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
                            <img src="img/Infrastructure/<?php echo $file_name.'_crop.'.$ext ?>" alt="">

                            <div class="slide-caption">
                                <div class="title">
                                    <h2><?php echo $row['title']?></h2>
                                </div>
                                <p class="mt-25 mb-25"><?php echo $row['sub_title']?></p><a class="upper small-link"
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

    <!-- <section class="grey-bg">
    <div class="container">
      <div class="title center">
        <h2> Infrastructure </h2>
      </div>
      <div class="row">
        <div class="owl-carousel"
          data-options="{&quot;items&quot;: 3, &quot;margin&quot;: 50, &quot;autoplay&quot;: true, &quot;dots&quot;: true}">
          <div class="card-post">
            <div class="post-media">
              <a href="#">
                <img src="images/blog-4.jpg" alt="Minimum Viable DevOps">
              </a>
            </div>
            <div class="post-body">
              <h3><a href="#">Canteen</a></h3>
              <p class="serif">Inspired Design. Nesciunt commodi fuga rem doloremque. Curabitur congue, dolor asperiores
                egestas varius, felis mi</p>
              <div class="post-info upper"><a class="small-link black-text" href="#"><span>Read More</span><i
                    class="hc-arrow-right"></i></a>
              </div>
            </div>
          </div>
          <div class="card-post">
            <div class="post-media">
              <a href="#">
                <img src="images/blog-1.jpg" alt="How to Get What You Want">
              </a>
            </div>
            <div class="post-body">
              <h3><a href="#">Library</a></h3>
              <p class="serif">Inspired Design. Nesciunt commodi fuga rem doloremque. Curabitur congue, dolor asperiores
                egestas varius, felis mi</p>
              <div class="post-info upper"><a class="small-link black-text" href="#"><span>Read More</span><i
                    class="hc-arrow-right"></i></a>
              </div>
            </div>
          </div>
          <div class="card-post">
            <div class="post-media">
              <a href="#">
                <img src="images/blog-5.jpg" alt="Answering Everything">
              </a>
            </div>
            <div class="post-body">
              <h3><a href="#">Sports</a></h3>
              <p class="serif">Inspired Design. Nesciunt commodi fuga rem doloremque. Curabitur congue, dolor asperiores
                egestas varius, felis mi</p>
              <div class="post-info upper"><a class="small-link black-text" href="#"><span>Read More</span><i
                    class="hc-arrow-right"></i></a>
              </div>
            </div>
          </div>
          <div class="card-post">
            <div class="post-media">
              <a href="#">
                <img src="images/blog-2.jpg" alt="Startup Rules">
              </a>
            </div>
            <div class="post-body">
              <h3><a href="#">Hostel</a></h3>
              <p class="serif">Inspired Design. Nesciunt commodi fuga rem doloremque. Curabitur congue, dolor asperiores
                egestas varius, felis mi</p>
              <div class="post-info upper"><a class="small-link black-text" href="#"><span>Read More</span><i
                    class="hc-arrow-right"></i></a>
              </div>
            </div>
          </div>
          <div class="card-post">
            <div class="post-media">
              <a href="#">
                <img src="images/blog-3.jpg" alt="Email Can Wait">
              </a>
            </div>
            <div class="post-body">
              <h3><a href="#">Laboratories</a></h3>
              <p class="serif">Inspired Design. Nesciunt commodi fuga rem doloremque. Curabitur congue, dolor asperiores
                egestas varius, felis mi</p>
              <div class="post-info upper"><a class="small-link black-text" href="#"><span>Read More</span><i
                    class="hc-arrow-right"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section> -->

    <!-- <section class="grey-bg">
    <div class="container">
      <div class="title center">
        <h2>Latest Posts.</h2>
        <h4>Checkout our latest blogs and news.</h4>
      </div>
      <div class="row">
        <div class="owl-carousel"
          data-options="{&quot;items&quot;: 3, &quot;margin&quot;: 50, &quot;autoplay&quot;: true, &quot;dots&quot;: true}">
          <div class="card-post">
            <div class="post-media">
              <a href="#">
                <img src="images/blog-4.jpg" alt="Minimum Viable DevOps">
              </a>
            </div>
            <div class="post-body"><span class="post-time">August 12, 2016</span>
              <h3><a href="#">Minimum Viable DevOps</a></h3>
              <p class="serif">Inspired Design. Nesciunt commodi fuga rem doloremque. Curabitur congue, dolor asperiores
                egestas varius, felis mi [..]</p>
              <div class="post-info upper"><a class="small-link black-text" href="#"><span>Read More</span><i
                    class="hc-arrow-right"></i></a>
              </div>
            </div>
          </div>
          <div class="card-post">
            <div class="post-media">
              <a href="#">
                <img src="images/blog-1.jpg" alt="How to Get What You Want">
              </a>
            </div>
            <div class="post-body"><span class="post-time">August 12, 2016</span>
              <h3><a href="#">How to Get What You Want</a></h3>
              <p class="serif">Inspired Design. Nesciunt commodi fuga rem doloremque. Curabitur congue, dolor asperiores
                egestas varius, felis mi [..]</p>
              <div class="post-info upper"><a class="small-link black-text" href="#"><span>Read More</span><i
                    class="hc-arrow-right"></i></a>
              </div>
            </div>
          </div>
          <div class="card-post">
            <div class="post-media">
              <a href="#">
                <img src="images/blog-5.jpg" alt="Answering Everything">
              </a>
            </div>
            <div class="post-body"><span class="post-time">August 12, 2016</span>
              <h3><a href="#">Answering Everything</a></h3>
              <p class="serif">Inspired Design. Nesciunt commodi fuga rem doloremque. Curabitur congue, dolor asperiores
                egestas varius, felis mi [..]</p>
              <div class="post-info upper"><a class="small-link black-text" href="#"><span>Read More</span><i
                    class="hc-arrow-right"></i></a>
              </div>
            </div>
          </div>
          <div class="card-post">
            <div class="post-media">
              <a href="#">
                <img src="images/blog-2.jpg" alt="Startup Rules">
              </a>
            </div>
            <div class="post-body"><span class="post-time">August 12, 2016</span>
              <h3><a href="#">Startup Rules</a></h3>
              <p class="serif">Inspired Design. Nesciunt commodi fuga rem doloremque. Curabitur congue, dolor asperiores
                egestas varius, felis mi [..]</p>
              <div class="post-info upper"><a class="small-link black-text" href="#"><span>Read More</span><i
                    class="hc-arrow-right"></i></a>
              </div>
            </div>
          </div>
          <div class="card-post">
            <div class="post-media">
              <a href="#">
                <img src="images/blog-3.jpg" alt="Email Can Wait">
              </a>
            </div>
            <div class="post-body"><span class="post-time">August 11, 2016</span>
              <h3><a href="#">Email Can Wait</a></h3>
              <p class="serif">Inspired Design. Nesciunt commodi fuga rem doloremque. Curabitur congue, dolor asperiores
                egestas varius, felis mi [..]</p>
              <div class="post-info upper"><a class="small-link black-text" href="#"><span>Read More</span><i
                    class="hc-arrow-right"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section> -->

    <?php include('common/footer.php') ?>

    <div id="search-modal">
        <div class="centrize">
            <div class="v-center">
                <div class="container">
                    <div class="search-form">
                        <!-- Search Form-->
                        <form class="searchform">
                            <div class="input-group">
                                <input class="form-control" type="search" data-required="required" name="s"
                                    placeholder="Search..." value=""><span class="input-group-btn"><button
                                        class="btn btn-color" type="submit"><span><i class="hc-search"></i></span>
                                    </button>
                                </span>
                            </div>
                        </form>
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
</body>

</html>