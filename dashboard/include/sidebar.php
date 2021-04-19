<?php
	$basename = basename($_SERVER['REQUEST_URI']);
	$currentPage = pathinfo($_SERVER['PHP_SELF'], PATHINFO_BASENAME);
?>
<!-- Sidebar -->
<div class="sidebar collapse">
    <div class="sidebar-content">
		<!-- Main navigation -->
		<ul class="navigation">
			
		
			<li <?php if($currentPage=='banner-master.php') { echo 'class="active"'; }?>><a href="banner-master.php"><span>Banner Master</span> <i class="icon-diamond"></i></a></li>
			<li <?php if($currentPage=='welcome.php') { echo 'class="active"'; }?>><a href="welcome.php"><span>Home Content</span> <i class="icon-diamond"></i></a></li>
			<li <?php if($currentPage=='department-master.php') { echo 'class="active"'; }?>><a href="department-master.php"><span>Department Master</span> <i class="icon-diamond"></i></a></li>
			<li <?php if($currentPage=='undergraduate-courses-master.php') { echo 'class="active"'; }?>><a href="undergraduate-courses-master.php"><span>Undergraduate Courses</span> <i class="icon-diamond"></i></a></li>
			<li <?php if($currentPage=='postgraduate-courses-master.php') { echo 'class="active"'; }?>><a href="postgraduate-courses-master.php"><span>Postgraduate Courses</span> <i class="icon-diamond"></i></a></li>
			<li <?php if($currentPage=='about_us.php') { echo 'class="active"'; }?>><a href="about_us.php"><span>About Us</span> <i class="icon-diamond"></i></a></li>
			<li <?php if($currentPage=='contact_us.php') { echo 'class="active"'; }?>><a href="contact_us.php"><span>Contact Us Content</span> <i class="icon-diamond"></i></a></li>
			<li <?php if($currentPage=='contact_form.php') { echo 'class="active"'; }?>><a href="contact_form.php"><span>Contact Us Form</span> <i class="icon-diamond"></i></a></li>
			<li <?php if($currentPage=='social-links.php') { echo 'class="active"'; }?>><a href="social-links.php"><span>Social Links</span> <i class="icon-diamond"></i></a></li>
			<li <?php if($currentPage=='manage-faqs.php') { echo 'class="active"'; }?>><a href="manage-faqs.php"><span>FAQs</span> <i class="icon-diamond"></i></a></li>
		
			<li <?php if($currentPage=='discount-coupon-master.php') { echo 'class="active"'; }?>><a href="discount-coupon-master.php"><span>Discount Coupon Master</span> <i class="icon-diamond"></i></a></li>
			<li <?php if($currentPage=='terms-n-conditions.php') { echo 'class="active"'; }?>><a href="terms-n-conditions.php"><span>Terms & Conditions</span> <i class="icon-diamond"></i></a></li>
			
		</ul>
      <!-- /main navigation -->
	</div>
</div>
<!-- /sidebar -->
