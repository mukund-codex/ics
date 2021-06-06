<?php
	$basename = basename($_SERVER['REQUEST_URI']);
	$currentPage = pathinfo($_SERVER['PHP_SELF'], PATHINFO_BASENAME);
?>
<!-- Sidebar -->
<div class="sidebar collapse">
    <div class="sidebar-content">
		<!-- Main navigation -->
		<ul class="navigation">
			
		<!-- <li><a href="#" class="expand"><span>Header Contents</span> <i class="icon-paragraph-justify2"></i></a> -->
				<!-- <ul>
					<li><a href="aboutus1.php"><span>About Us</span></a></li>
					<li><a href="governance.php"><span>Governance & Administration</span></a></li>
					<li><a href="scademics.php"><span>Academics</span></a></li>
				
					<li><a href="iqac.php"><span>IQAC</span></a></li>
					<li><a href="examination.php"><span>Examination</span></a></li>
					<li><a href="addmission.php"><span>Admission</span></a></li>
					<li><a href="student.php"><span>Student Corner</span></a></li>
					
				</ul> -->
			<!-- </li> -->
			<li <?php if($currentPage=='headercontent-master.php') { echo 'class="active"'; }?>><a href="headercontent-master.php"><span>Header Content</span> <i class="icon-diamond"></i></a></li>
			<li <?php if($currentPage=='banner-master.php') { echo 'class="active"'; }?>><a href="banner-master.php"><span>Banner Master</span> <i class="icon-diamond"></i></a></li>
			<li <?php if($currentPage=='welcome.php') { echo 'class="active"'; }?>><a href="welcome.php"><span>Home Content</span> <i class="icon-diamond"></i></a></li>
			<li <?php if($currentPage=='homeallcontent.php') { echo 'class="active"'; }?>><a href="homeallcontent.php"><span>Home Content Only Title Change</span> <i class="icon-diamond"></i></a></li>
			<li <?php if($currentPage=='undergraduate-courses-master.php') { echo 'class="active"'; }?>><a href="undergraduate-courses-master.php"><span>Undergraduate Courses</span> <i class="icon-diamond"></i></a></li>
			<li <?php if($currentPage=='postgraduate-courses-master.php') { echo 'class="active"'; }?>><a href="postgraduate-courses-master.php"><span>Postgraduate Courses</span> <i class="icon-diamond"></i></a></li>
			<li <?php if($currentPage=='othergraduate-courses-master.php') { echo 'class="active"'; }?>><a href="othergraduate-courses-master.php"><span>Others Details</span> <i class="icon-diamond"></i></a></li>
			<li <?php if($currentPage=='department-master.php') { echo 'class="active"'; }?>><a href="department-master.php"><span>Department Master</span> <i class="icon-diamond"></i></a></li>
			<li <?php if($currentPage=='contact_form.php') { echo 'class="active"'; }?>><a href="contact_form.php"><span>Contact Us Form</span> <i class="icon-diamond"></i></a></li>
			<li <?php if($currentPage=='social-links.php') { echo 'class="active"'; }?>><a href="social-links.php"><span>Social Links</span> <i class="icon-diamond"></i></a></li>
			<li <?php if($currentPage=='footer-links.php') { echo 'class="active"'; }?>><a href="footer-links-master.php"><span>Footer Links</span> <i class="icon-diamond"></i></a></li>
			<li <?php if($currentPage=='terms-n-conditions.php') { echo 'class="active"'; }?>><a href="terms-n-conditions.php"><span>Terms & Conditions</span> <i class="icon-diamond"></i></a></li>
			
		</ul>
      <!-- /main navigation -->
	</div>
</div>
<!-- /sidebar -->
