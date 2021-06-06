<?php
 include('site-config.php');

//  $sql = "SELECT * FROM `dc_contact_detail` ORDER BY created_at ASC";
//  $result = $func->query($sql);

 $sql = "SELECT * FROM `dc_contact_detail` ORDER BY created_at ASC ";
 $result = $func->query($sql);
 $arr_result=array();
 while($row = $func->fetch($result)){  
   array_push($arr_result,$row);
 }

?>

<!DOCTYPE html>
<html lang="en">

  
<!-- Mirrored from themes.hody.co/html/dylan/page-contact-simple.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 13 Feb 2021 11:05:12 GMT -->
<head>
    <title>ICS | Contact Us</title>
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
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','../../../www.google-analytics.com/analytics.js','ga');
      
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
    
    <?php include('common/header.php'); ?>

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
          <img src="https://icskhed.org/wp-content/uploads/2019/02/WhatsApp-Image-2019-01-30-at-15.44.13.jpeg" alt="">
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
    <section class="p-0">
      <div class="container-fluid">
        <div class="row">
          <div class="full-width" id="map" data-title="We are here!" data-lat="40.773328" data-long="-73.960088"></div>
        </div>
      </div>
    </section>

    <section class="p-0">
      <div class="container-fluid">
        <div class="row row-flex">

        <?php  
          foreach ($arr_result as $value) {
            ?>
          <div class="col-md-3 hidden-sm hidden-xs">
          <div class="box-row grey-bg pt-100 pb-100">
                <h3><?php echo $value['pos_title'];?></h3>
                <hr>
                <h4><?php echo $value['prof_name'];?></h4>
                <p>Tel: <a href="tel:<?php echo $value['phone']; ?>"><?php echo $value['phone'];?></a></p>
                <p>Tel: <a href="tel:<?php echo $value['alt_phone']; ?>"><?php echo $value['alt_phone'];?></a></p>
                <p>Mail: <a href="mailto:<?php echo $value['email']; ?>"><?php echo $value['email'];?></a></p>
            </div>
          </div>
         <?php  } ?>
          
        </div>
      </div>
    </section>
    
    <?php include('common/footer.php'); ?>

    <div id="search-modal">
      <div class="centrize">
        <div class="v-center">
          <div class="container">
            <div class="search-form">
              <!-- Search Form-->
              <form class="searchform">
                <div class="input-group">
                  <input class="form-control" type="search" data-required="required" name="s" placeholder="Search..." value=""><span class="input-group-btn"><button class="btn btn-color" type="submit"><span><i class="hc-search"></i></span>
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
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCNGOsBBZo9vf0Tw4w6aJiilSTFVfQ5GPI"></script>
    <script type="text/javascript" src="js/main.js"></script>
  </body>


<!-- Mirrored from themes.hody.co/html/dylan/page-contact-simple.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 13 Feb 2021 11:05:12 GMT -->
</html>