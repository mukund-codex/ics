<?php

	include_once 'include/config.php';
	include_once 'include/admin-functions.php';
	$admin = new AdminFunctions();
	$pageName = "UnderGraduate Details";

	 $pageURL = 'undergraduate-courses-master.php';
	// $addURL = 'department-add.php';
	// $deleteURL = 'department-delete.php';
	$tableName = 'departments';


  //faculty
	$tab_F = "Faculty";
    $addURL_F = 'faculty-add.php';
	$deleteURL_F = 'faculty-delete.php';
	$tableName_F = 'faculty';

	//Laboratory
	$tab_L = "Laboratory";
    $addURL_L = 'laboratory-add.php';
	$deleteURL_L = 'laboratory-delete.php';
	$tableName_L = 'laboratory';


    //Student Academic
    $tab_SA = "Student Academic Activities";
    $addURL_SA = 'studentacademic-add.php';
	$deleteURL_SA = 'studentacademic-delete.php';
	$tableName_SA = 'student_academic';

    //Student Co-Curricular
    $tab_SC = "Student Co-Curricular Activities";
    $addURL_SC = 'studentcurricular-add.php';
	$deleteURL_SC = 'studentcurricular-delete.php';
	$tableName_SC = 'student_curricular';

    //Vision 
	$tab_V = "Our Vision";
    $addURL_V = 'undergraduate-vision-add.php';
	$deleteURL_V = 'undergraduate-vision-delete.php';
	$tableName_V = 'ourvision';

    //Mission 
	$tab_M = "Our Mission";
    $addURL_M = 'undergraduate-mission-add.php';
	$deleteURL_M = 'undergraduate-mission-delete.php';
	$tableName_M = 'ourmission';


    //Goal
	$tab_G = "Our Goal";
    $addURL_G = 'undergraduate-goal-add.php';
	$deleteURL_G = 'undergraduate-goal-delete.php';
	$tableName_G = 'ourgoal';



	//add-title-description.php

	$addURL_titledes = 'add-title-description.php';
	$deleteURL_titledes = 'delete-title-description.php';
	$tableName_titledes = 'title_descrption';


	$addURL_CI = 'carousel-images-add.php';
	$deleteURL_CI = 'carousel-images-delete.php';
	$tableName_CI = 'carousel_images';


    //Add Subtype For Courses

    $addURL_subtype = 'subtype-courses-images-add.php';
	$deleteURL_subtype = 'subtype-courses-images-delete.php';
	$tableName_subtype = 'subtype_courses_images';





	if(!$loggedInUserDetailsArr = $admin->sessionExists()){
		header("location: admin-login.php");
		exit();
	}

	//include_once 'csrf.class.php';
	$csrf = new csrf();
	$token_id = $csrf->get_token_id();
	$token_value = $csrf->get_token($token_id);

	if(isset($_GET['page']) && !empty($_GET['page'])) {
		$pageNo = trim($admin->strip_all($_GET['page']));
	} else {
		$pageNo = 1;
	}
	$linkParam = "";


	$query = "SELECT COUNT(*) as num FROM ".PREFIX.$tableName;
	$total_pages = $admin->fetch($admin->query($query));
	$total_pages = $total_pages['num'];


	include_once "include/pagination.php";
	$pagination = new Pagination();
	$paginationArr = $pagination->generatePagination($pageURL, $pageNo, $total_pages, $linkParam);

	$sql = "SELECT dp.*, bt.tabs as department_name FROM ".PREFIX.$tableName." dp JOIN dc_boxed_tabs bt ON dp.department_id = bt.department_id order by id DESC";
	$results = $admin->query($sql);

	$sqlTitleDes = "Select * From dc_title_descrption where courses_category ='UG'";
	$results2 = $admin->query($sqlTitleDes);

	$sqlCI = "Select * From dc_carousel_images where courses_category ='UG'";
	$results3 = $admin->query($sqlCI);

    $sqlST = "SELECT `cat`.category,`sc`.* FROM `dc_subtype_courses_images` as sc ,`dc_category` as cat WHERE sc.`coruses_id`= cat.`coruses_id`  and sc.courses_category ='UG'";
	$results4 = $admin->query($sqlST);

    //Add Subtype For Courses

    
    // while($row = $admin->fetch($results4)){
    //     echo $row['courses_subtype'];
    // }

    // //print_r($results4);
    // exit;


    $type = "UG";
	$resFaculty = $admin->query("select * From ".PREFIX."faculty where courses_category = '$type' ");

	$resLab = $admin->query("select * From ".PREFIX."laboratory where courses_category = '$type' ");

    $sqlForDepSC = "SELECT * FROM ".PREFIX.$tableName_SC."  Where courses_category = 'UGC' ";
	$resultsSC = $admin->query($sqlForDepSC);

    $sqlForDepSA = "SELECT * FROM ".PREFIX.$tableName_SA."  Where courses_category = 'UGC' ";
	$resultsSA = $admin->query($sqlForDepSA);
     //courses_category	
    
     //vision
     $resVision = $admin->query("select * From ".PREFIX."ourvision where courses_category = '$type' ");

     //mission
     $resMission = $admin->query("select * From ".PREFIX."ourmission where courses_category = '$type' ");

     //goal 
     $resGoal = $admin->query("select * From ".PREFIX."ourgoal where courses_category = '$type' ");
    //  $d = "select * From ".PREFIX."ourgoal where courses_category = '$type' ";
    //  echo $d;exit;
    //  print_r($resGoal);
	
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo TITLE ?></title>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/londinium-theme.min.css" rel="stylesheet" type="text/css">
    <link href="css/styles.min.css" rel="stylesheet" type="text/css">
    <link href="css/icons.min.css" rel="stylesheet" type="text/css">

    <link href="css/font-awesome.min.css" rel="stylesheet">
    <!--<link href="css/nanoscroller.css" rel="stylesheet">
	<link href="css/cover.css" rel="stylesheet">-->

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=latin,cyrillic-ext"
        rel="stylesheet" type="text/css">
    <script type="text/javascript" src="js/jquery.1.10.1.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui.1.10.2.min.js"></script>
    <script type="text/javascript" src="js/plugins/charts/sparkline.min.js"></script>
    <script type="text/javascript" src="js/plugins/forms/uniform.min.js"></script>
    <script type="text/javascript" src="js/plugins/forms/select2.min.js"></script>
    <script type="text/javascript" src="js/plugins/forms/inputmask.js"></script>
    <script type="text/javascript" src="js/plugins/forms/autosize.js"></script>
    <script type="text/javascript" src="js/plugins/forms/inputlimit.min.js"></script>
    <script type="text/javascript" src="js/plugins/forms/listbox.js"></script>
    <script type="text/javascript" src="js/plugins/forms/multiselect.js"></script>
    <script type="text/javascript" src="js/plugins/forms/validate.min.js"></script>
    <script type="text/javascript" src="js/plugins/forms/tags.min.js"></script>
    <script type="text/javascript" src="js/plugins/forms/switch.min.js"></script>
    <script type="text/javascript" src="js/plugins/forms/uploader/plupload.full.min.js"></script>
    <script type="text/javascript" src="js/plugins/forms/uploader/plupload.queue.min.js"></script>
    <script type="text/javascript" src="js/plugins/forms/wysihtml5/wysihtml5.min.js"></script>
    <script type="text/javascript" src="js/plugins/forms/wysihtml5/toolbar.js"></script>
    <script type="text/javascript" src="js/plugins/interface/daterangepicker.js"></script>
    <script type="text/javascript" src="js/plugins/interface/fancybox.min.js"></script>
    <script type="text/javascript" src="js/plugins/interface/moment.js"></script>
    <script type="text/javascript" src="js/plugins/interface/jgrowl.min.js"></script>
    <script type="text/javascript" src="js/plugins/interface/datatables.min.js"></script>
    <script type="text/javascript" src="js/plugins/interface/colorpicker.js"></script>
    <script type="text/javascript" src="js/plugins/interface/fullcalendar.min.js"></script>
    <script type="text/javascript" src="js/plugins/interface/timepicker.min.js"></script>
    <script type="text/javascript" src="js/plugins/interface/collapsible.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/application.js"></script>
</head>

<body class="sidebar-wide">
    <?php include 'include/navbar.php' ?>

    <div class="page-container">

        <?php include 'include/sidebar.php' ?>

        <div class="page-content">

            <!--
			<div class="page-header">
				<div class="page-title">
					<h3>Dashboard <small>Welcome Eugene. 12 hours since last visit</small></h3>
				</div>
				<div id="reportrange" class="range">
					<div class="visible-xs header-element-toggle"><a class="btn btn-primary btn-icon"><i class="icon-calendar"></i></a></div>
					<div class="date-range"></div>
					<span class="label label-danger">9</span>
				</div>
			</div>
	    	-->

            <div class="breadcrumb-line">
                <div class="page-ttle hidden-xs" style="float:left;"><?php echo $pageName; ?></div>
                <ul class="breadcrumb">
                    <li><a href="Department-master.php">Home</a></li>
                    <li class="active"><?php echo $pageName; ?></li>
                </ul>
            </div>

            <?php
		if(isset($_GET['updatesuccess'])){ ?>
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <i class="icon-checkmark"></i> Department Content successfully updated.
            </div><br />
            <?php	} ?>
            <?php
		if(isset($_GET['deletesuccess'])){ ?>
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <i class="icon-checkmark"></i> <?php echo $pageName; ?> successfully deleted.
            </div><br />
            <?php	} ?>

            <?php
		if(isset($_GET['deletefail'])){ ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <i class="icon-close"></i> <strong><?php echo $pageName; ?> not deleted.</strong> Invalid Details.
            </div><br />
            <?php	} ?>

            <br />


            <!-- select category -->
         
            <div class="form-group">
                <label for="sel1">Select list:</label>
                <select class="form-control" id="graduate" name="graduate">
                    <option value="0">Select Graduate</option>
                    <option value="UG">UnderGraduate</option>
                
                </select>
            </div>

            <!-- /**show it according to uuper drwon */ -->
            <!-- //echo $_SESSION["course_name"] ;exit; -->
            <div class="form-group" id="sub_category1">
                <label for="sel1">Select Courses:</label>
                <select class="form-control" id="sub_category" name="sub_category" data-rel="chosen">
                    <option>Select Courses</option>
                </select>
            </div>


			

            <!-- end of  it -->

		

			<!-- carosel -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h6 class="panel-title"><i class="icon-stats"></i> Carousel Images</h6>
                </div>
                <div class="panel-body">
                    <a href="<?php echo $addURL_CI; ?>" class="label label-primary pull-right">Add
                        <?php echo $pageName." "."Carousel Images"; ?></a>
                    <?php 
					
					//doubt
					$activeCount = $admin->num_rows($admin->query("SELECT * FROM ".PREFIX."carousel_images"));
					//echo $activeCount;
					if($activeCount<7){
					?>

                    <?php 
					}?>
                    <br /><br />
                    <div class="datatable-selectable-data">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Courses</th>
                                    <th>Image</th>
                                    <th>Created Date</th>
                                    <th>Updated Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="carosel_image">
                                <?php
							$x = (10*$pageNo)-9;
							while($row = $admin->fetch($results3)){
								$file_name = str_replace('', '-', strtolower( pathinfo($row['image'], PATHINFO_FILENAME)));
								$ext = pathinfo($row['image'], PATHINFO_EXTENSION);
								
?>
                                <tr>
                                    <td><?php echo $x++; ?></td>
                                    <td><?php echo $row['category'] ?></td>
								
                                    <td><img src="../img/Department/<?php echo $file_name.'_crop.'.$ext ?>"
                                            width="100" /></td>

                                    <td><?php echo $row['created_at']; ?></td>
                                    <td><?php echo $row['updated_at']; ?></td>
                                    <td>
                                        <a href="<?php echo $addURL_CI; ?>?edit&id=<?php echo $row['id'] ?>"
                                            name="edit" class="" title="Click to edit this row"><i
                                                class="icon-pencil"></i></a>
                                        <a class="" href="<?php echo $deleteURL_CI; ?>?id=<?php echo $row['id']; ?>"
                                            onclick="return confirm('Are you sure you want to delete?');"
                                            title="Click to delete this row, this action cannot be undone."><i
                                                class="icon-remove3"></i></a>
                                    </td>

                                </tr>
                                <?php
							}
?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <br>
            <!-- End of Zoom images -->

            <!-- strat Our Vision -->

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h6 class="panel-title"><i class="icon-stats"></i>Our Vision</h6>
                </div>
                <div class="panel-body">
                    <a href="<?php echo $addURL_V; ?>" class="label label-primary pull-right">Add
                        <?php echo $tab_V; ?></a>
                    <?php 
					
					//doubt
					$activeCount = $admin->num_rows($admin->query("SELECT * FROM ".PREFIX.$tableName_V." "));
					//echo $activeCount;
					if($activeCount<7){
					?>

                    <?php 
					}?>
                    <br /><br />
                    <div class="datatable-selectable-data">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Courses</th>
                                    <th>Our Vision</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="vision">
                                <?php
							$x = (10*$pageNo)-9;
							while($row = $admin->fetch($resVision)){
								// $file_name = str_replace('', '-', strtolower( pathinfo($row['image'], PATHINFO_FILENAME)));
								// $ext = pathinfo($row['image'], PATHINFO_EXTENSION);
?>
                                <tr>
                                    <td><?php echo $x++; ?></td>
                                    <td><?php echo $row['courses_name'] ?></td>
                                    <td><?php echo $row['description'] ?></td>
							
                          
                                    <td>
                                        <a href="<?php echo $addURL_V; ?>?edit&id=<?php echo $row['id'] ?>" name="edit"
                                            class="" title="Click to edit this row"><i class="icon-pencil"></i></a>
                                        <a class="" href="<?php echo $deleteURL_V; ?>?id=<?php echo $row['id']; ?>"
                                            onclick="return confirm('Are you sure you want to delete?');"
                                            title="Click to delete this row, this action cannot be undone."><i
                                                class="icon-remove3"></i></a>
                                    </td>

                                </tr>
                                <?php
							}
?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- end of Our Vision -->
			</br>			


            <!-- strat Our mission -->

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h6 class="panel-title"><i class="icon-stats"></i>Our mission</h6>
                </div>
                <div class="panel-body">
                    <a href="<?php echo $addURL_M; ?>" class="label label-primary pull-right">Add
                        <?php echo $tab_M; ?></a>
                    <?php 
					
					//doubt
					$activeCount = $admin->num_rows($admin->query("SELECT * FROM ".PREFIX.$tableName_M." "));
					//echo $activeCount;
					if($activeCount<7){
					?>

                    <?php 
					}?>
                    <br /><br />
                    <div class="datatable-selectable-data">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Courses</th>
                                    <th>Our Mission</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="mission">
                                <?php
							$x = (10*$pageNo)-9;
							while($row = $admin->fetch($resMission)){
								// $file_name = str_replace('', '-', strtolower( pathinfo($row['image'], PATHINFO_FILENAME)));
								// $ext = pathinfo($row['image'], PATHINFO_EXTENSION);
?>
                                <tr>
                                    <td><?php echo $x++; ?></td>
                                    <td><?php echo $row['courses_name'] ?></td>
                                    <td><?php echo $row['description'] ?></td>
									
                                
                                    <td>
                                        <a href="<?php echo $addURL_M; ?>?edit&id=<?php echo $row['id'] ?>" name="edit"
                                            class="" title="Click to edit this row"><i class="icon-pencil"></i></a>
                                        <a class="" href="<?php echo $deleteURL_M; ?>?id=<?php echo $row['id']; ?>"
                                            onclick="return confirm('Are you sure you want to delete?');"
                                            title="Click to delete this row, this action cannot be undone."><i
                                                class="icon-remove3"></i></a>
                                    </td>

                                </tr>
                                <?php
							}
?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- end of Our mission -->
			</br>			


            <!-- strat Our Goal -->

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h6 class="panel-title"><i class="icon-stats"></i>Our Goal</h6>
                </div>
                <div class="panel-body">
                    <a href="<?php echo $addURL_G; ?>" class="label label-primary pull-right">Add
                        <?php echo $tab_G; ?></a>
                    <?php 
					
					//doubt
					$activeCount = $admin->num_rows($admin->query("SELECT * FROM ".PREFIX.$tableName_G." "));
					//echo $activeCount;
					if($activeCount<7){
					?>

                    <?php 
					}?>
                    <br /><br />
                    <div class="datatable-selectable-data">
                        <table class="table">
                            <thead>
                                <tr>
                                   <th>#</th>
                                    <th>Courses</th>
                                    <th>Our Goal</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="goal">
                                <?php
							$x = (10*$pageNo)-9;
							while($row = $admin->fetch($resGoal)){
								// $file_name = str_replace('', '-', strtolower( pathinfo($row['image'], PATHINFO_FILENAME)));
								// $ext = pathinfo($row['image'], PATHINFO_EXTENSION);
?>
                                <tr>
                                    <td><?php echo $x++; ?></td>
                                    <td><?php echo $row['courses_name'] ?></td>
                                    <td><?php echo $row['description'] ?></td>
                                    <td>
                                        <a href="<?php echo $addURL_G; ?>?edit&id=<?php echo $row['id'] ?>" name="edit"
                                            class="" title="Click to edit this row"><i class="icon-pencil"></i></a>
                                        <a class="" href="<?php echo $deleteURL_G; ?>?id=<?php echo $row['id']; ?>"
                                            onclick="return confirm('Are you sure you want to delete?');"
                                            title="Click to delete this row, this action cannot be undone."><i
                                                class="icon-remove3"></i></a>
                                    </td>

                                </tr>
                                <?php
							}
?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- end of Our Goal -->
			</br>			


            <!-- Add sub type -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h6 class="panel-title"><i class="icon-stats"></i> Add Subtype For Courses</h6>
                </div>
                <div class="panel-body">
                    <a href="<?php echo $addURL_subtype; ?>" class="label label-primary pull-right">Add
                        <?php echo "Coruses SubType Images"; ?></a>
                    <?php 
					
					//doubt
					$activeCount = $admin->num_rows($admin->query("SELECT * FROM ".PREFIX."subtype_courses_images"));
					//echo $activeCount;
					if($activeCount<7){
					?>

                    <?php 
					}?>
                    <br /><br />
                    <div class="datatable-selectable-data">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <!-- <th></th> -->
                                    <th>Courses</th>
                                    <th>Sub Category</th>
                                    <th>Image</th>
                                    <th>Created Date</th>
                                    <th>Updated Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="courses_st">
                                <?php
							$x = (10*$pageNo)-9;
							while($row = $admin->fetch($results4)){
								$file_name = str_replace('', '-', strtolower( pathinfo($row['coursesubtype_img'], PATHINFO_FILENAME)));
								$ext = pathinfo($row['coursesubtype_img'], PATHINFO_EXTENSION);
								
?>
                                <tr>
                                    <td><?php echo $x++; ?></td>
                                    <td><?php echo  strip_tags($row['category']); ?></td>
                                    <td><?php echo $row['courses_subtype']; ?></td>
								
                                    <td><img src="../img/coursesubtype/<?php echo $file_name.'_crop.'.$ext ?>"
                                            width="100" /></td>

                                    <td><?php echo $row['created_at']; ?></td>
                                    <td><?php echo $row['updated_at']; ?></td>
                                    <td>
                                        <a href="<?php echo $addURL_subtype; ?>?edit&id=<?php echo $row['id']; ?>"
                                            name="edit" class="" title="Click to edit this row"><i
                                                class="icon-pencil"></i></a>
                                        <a class="" href="<?php echo $deleteURL_subtype; ?>?id=<?php echo $row['id']; ?>"
                                            onclick="return confirm('Are you sure you want to delete?');"
                                            title="Click to delete this row, this action cannot be undone."><i
                                                class="icon-remove3"></i></a>
                                    </td>

                                </tr>
                                <?php
							}
?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <br>
            <!-- End of Add sub type -->


            <div class="panel panel-default">
                <div class="panel-heading">
                    <h6 class="panel-title"><i class="icon-stats"></i>Title & Description</h6>
                </div>
                <div class="panel-body">
                    <a href="<?php echo $addURL_titledes; ?>" class="label label-primary pull-right">Add
                        <?php echo $pageName." "."Title & Description"; ?></a>
                    <?php 
					
					$activeCount = $admin->num_rows($admin->query("SELECT * FROM ".PREFIX."title_descrption"));
					//echo $activeCount;
					if($activeCount<7){
					?>

                    <?php 
					}?>
                    <br /><br />
                    <div class="datatable-selectable-data">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Course</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Created Date</th>
                                    <th>Updated Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="title_des">
                                <?php
							$x = (10*$pageNo)-9;
							while($row = $admin->fetch($results2)){
								
								
?>
                                <tr>
                                    <td><?php echo $x++; ?></td>
                                    <td><?php echo $row['category_type'] ?></td>
                                    <td><?php echo $row['title'] ?></td>
                                    <td><?php echo $row['description'] ?></td>
                                    <td><?php echo $row['created_at']; ?></td>
                                    <td><?php echo $row['updated_at']; ?></td>
                                    <td>
                                        <a href="<?php echo $addURL_titledes; ?>?edit&id=<?php echo $row['id'] ?>"
                                            name="edit" class="" title="Click to edit this row"><i
                                                class="icon-pencil"></i></a>
                                        <a class="" href="<?php echo $deleteURL_titledes; ?>?id=<?php echo $row['id']; ?>"
                                            onclick="return confirm('Are you sure you want to delete?');"
                                            title="Click to delete this row, this action cannot be undone."><i
                                                class="icon-remove3"></i></a>
                                    </td>

                                </tr>
                                <?php
							}
?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <br>
            <!-- end of Department Images  accodring to category and tab boxes -->

            <!-- strat Faculty -->

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h6 class="panel-title"><i class="icon-stats"></i>Faculty</h6>
                </div>
                <div class="panel-body">
                    <a href="<?php echo $addURL_F; ?>" class="label label-primary pull-right">Add
                        <?php echo $tab_F; ?></a>
                    <?php 
					
					//doubt
					$activeCount = $admin->num_rows($admin->query("SELECT * FROM ".PREFIX."faculty"));
					//echo $activeCount;
					if($activeCount<7){
					?>

                    <?php 
					}?>
                    <br /><br />
                    <div class="datatable-selectable-data">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Courses</th>
                                    <th>Name</th>
                                    <th>Department</th>
									<th>Designation</th>
                                    <th>Created Date</th>
                                    <th>Updated Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="fac">
                                <?php
							$x = (10*$pageNo)-9;
							while($row = $admin->fetch($resFaculty)){
								// $file_name = str_replace('', '-', strtolower( pathinfo($row['image'], PATHINFO_FILENAME)));
								// $ext = pathinfo($row['image'], PATHINFO_EXTENSION);
?>
                                <tr>
                                    <td><?php echo $x++; ?></td>
                                    <td><?php echo $row['coruses_name'] ?></td>
                                    <td><?php echo $row['name'] ?></td>
									<td><?php echo $row['department'] ?></td>
                                    <td><?php echo $row['designation'] ?></td>
                                    <td><?php echo $row['created_at']; ?></td>
                                    <td><?php echo $row['updated_at']; ?></td>
                                    <td>
                                        <a href="<?php echo $addURL_F; ?>?edit&id=<?php echo $row['id'] ?>" name="edit"
                                            class="" title="Click to edit this row"><i class="icon-pencil"></i></a>
                                        <a class="" href="<?php echo $deleteURL_F; ?>?id=<?php echo $row['id']; ?>"
                                            onclick="return confirm('Are you sure you want to delete?');"
                                            title="Click to delete this row, this action cannot be undone."><i
                                                class="icon-remove3"></i></a>
                                    </td>

                                </tr>
                                <?php
							}
?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- end of Faculty -->
			</br>				



			<!-- strat Laboratory -->

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h6 class="panel-title"><i class="icon-stats"></i>Laboratory</h6>
                </div>
                <div class="panel-body">
                    <a href="<?php echo $addURL_L; ?>" class="label label-primary pull-right">Add
                        <?php echo $tab_L; ?></a>
                    <?php 
					
					//doubt
					$activeCount = $admin->num_rows($admin->query("SELECT * FROM ".PREFIX."laboratory"));
					//echo $activeCount;
					if($activeCount<7){
					?>

                    <?php 
					}?>
                    <br /><br />
                    <div class="datatable-selectable-data">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Courses</th>
                                    <th>Name of Lab</th>
                                    <th>Lab Incharge</th>
									<th>Contact Number</th>
                                    <th>Created Date</th>
                                    <th>Updated Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="lab">
                                <?php
							$x = (10*$pageNo)-9;
							while($row = $admin->fetch($resLab)){
// 								$file_name = str_replace('', '-', strtolower( pathinfo($row['image'], PATHINFO_FILENAME)));
// 								$ext = pathinfo($row['image'], PATHINFO_EXTENSION);
      ?>
                                <tr>
                                    <td><?php echo $x++; ?></td>
                                    <td><?php echo $row['coruses_name'] ?></td>
                                    <td><?php echo $row['lab_name'] ?></td>
                                    <td><?php echo $row['lab_incharge'] ?></td>
									<td><?php echo $row['lab_contactno'] ?></td>
                                    <td><?php echo $row['created_at']; ?></td>
                                    <td><?php echo $row['updated_at']; ?></td>
                                    <td>
                                        <a href="<?php echo $addURL_L; ?>?edit&id=<?php echo $row['id'] ?>" name="edit"
                                            class="" title="Click to edit this row"><i class="icon-pencil"></i></a>
                                        <a class="" href="<?php echo $deleteURL_L; ?>?id=<?php echo $row['id']; ?>"
                                            onclick="return confirm('Are you sure you want to delete?');"
                                            title="Click to delete this row, this action cannot be undone."><i
                                                class="icon-remove3"></i></a>
                                    </td>

                                </tr>
                                <?php
							}
?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- end of Laboratory -->
			</br>				



            <!-- Student Co-Curricular -->

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h6 class="panel-title"><i class="icon-stats"></i>Student Co-Curricular Activities</h6>
                </div>
                <div class="panel-body">
                    <a href="<?php echo $addURL_SC; ?>" class="label label-primary pull-right">Add
                        <?php echo $tab_SC; ?></a>
                    <?php 
					
					//doubt
					$activeCount = $admin->num_rows($admin->query("SELECT * FROM ".PREFIX."student_academic where courses_category = 'PGC'"));
					//echo $activeCount;
					if($activeCount<7){
					?>

                    <?php 
					}?>
                    <br /><br />
                    <div class="datatable-selectable-data">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Courses</th>
                                    <th>Image Title</th>
                                    <th>Image</th>
                                    <th>Created Date</th>
                                    <th>Updated Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="stud_cocirr">
                                <?php
							$x = (10*$pageNo)-9;
							while($row = $admin->fetch($resultsSC)){
								$file_name = str_replace('', '-', strtolower( pathinfo($row['image'], PATHINFO_FILENAME)));
								$ext = pathinfo($row['image'], PATHINFO_EXTENSION);
?>
                                <tr>
                                    <td><?php echo $x++; ?></td>
                                    <td><?php echo $row['coruses_name'] ?></td>
                                    <td><?php echo $row['title'] ?></td>
                                    <td><img src="../img/StudentCo-Curricular/undergraduate/<?php echo $file_name.'_crop.'.$ext ?>"
                                            width="100" /></td>
                                    <td><?php echo $row['created_at']; ?></td>
                                    <td><?php echo $row['updated_at']; ?></td>
                                    <td>
                                        <a href="<?php echo $addURL_SC; ?>?edit&id=<?php echo $row['id'] ?>" name="edit"
                                            class="" title="Click to edit this row"><i class="icon-pencil"></i></a>
                                        <a class="" href="<?php echo $deleteURL_SC; ?>?id=<?php echo $row['id']; ?>"
                                            onclick="return confirm('Are you sure you want to delete?');"
                                            title="Click to delete this row, this action cannot be undone."><i
                                                class="icon-remove3"></i></a>
                                    </td>

                                </tr>
                                <?php
							}
?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- End Student Co-Curricular gallery -->


			<br>			
            <!-- strat Student Academic Activities -->

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h6 class="panel-title"><i class="icon-stats"></i>Student Academic Activities</h6>
                </div>
                <div class="panel-body">
                    <a href="<?php echo $addURL_SA; ?>" class="label label-primary pull-right">Add
                        <?php echo $tab_SA; ?></a>
                    <?php 
					
					//doubt
					$activeCount = $admin->num_rows($admin->query("SELECT * FROM ".PREFIX."student_academic where courses_category = 'PGC'"));
					//echo $activeCount;
					if($activeCount<7){
					?>

                    <?php 
					}?>
                    <br /><br />
                    <div class="datatable-selectable-data">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Courses</th>
                                    <th>Image Title</th>
                                    <th>Image</th>
                                    <th>Created Date</th>
                                    <th>Updated Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="stud_academic">
                                <?php
							$x = (10*$pageNo)-9;
							while($row = $admin->fetch($resultsSA)){
								$file_name = str_replace('', '-', strtolower( pathinfo($row['image'], PATHINFO_FILENAME)));
								$ext = pathinfo($row['image'], PATHINFO_EXTENSION);
?>
                                <tr>
                                    <td><?php echo $x++; ?></td>
                                    <td><?php echo $row['coruses_name'] ?></td>
                                    <td><?php echo $row['title'] ?></td>
                                    <td><img src="../img/StudentAcademic/undergraduate/<?php echo $file_name.'_crop.'.$ext ?>"
                                            width="100" /></td>
                                    <td><?php echo $row['created_at']; ?></td>
                                    <td><?php echo $row['updated_at']; ?></td>
                                    <td>
                                        <a href="<?php echo $addURL_SA; ?>?edit&id=<?php echo $row['id'] ?>" name="edit"
                                            class="" title="Click to edit this row"><i class="icon-pencil"></i></a>
                                        <a class="" href="<?php echo $deleteURL_SA; ?>?id=<?php echo $row['id']; ?>"
                                            onclick="return confirm('Are you sure you want to delete?');"
                                            title="Click to delete this row, this action cannot be undone."><i
                                                class="icon-remove3"></i></a>
                                    </td>

                                </tr>
                                <?php
							}
?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- end of Student Academic Activities -->


           

            <div class="row">
                <div class="col-md-12 clearfix">
                    <nav class="pull-right">
                        <?php //echo $paginationArr['paginationHTML']; ?>
                    </nav>
                </div>
            </div>

            <?php 	include "include/footer.php"; ?>

        </div>

    </div>

    <link href="css/jquery.dataTables.min.css" rel="stylesheet">
	
    <script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
	

    <script>
    $(document).ready(function() {
        $('.datatable-selectable-data table').dataTable({
            "order": [
                [0, 'asc']
            ],
        });
    });

	// $(document).ready(function() {
       
    // });

    // $(document).ready(function() {
    //     $('.graduate').change({
    //         alert('erwrrwrwqrqwrwqrwqrrqwr');
    //     });
    // });


    $(document).ready(function() {
        $("#graduate").change(function() {
			
            var graduate = $(this).val();
            var graduate_value =  graduate;
			//sessionStorage.setItem("degree", graduate_value );

            $.ajax({
                type: "POST",
                url: "ajax.php",
                data: {"a" : graduate_value},
               
                success: function(response) {
				
                    $("#sub_category").html(response);
                
                }
            });

        });
    });



    $(function() {
        $("#sub_category1").click(function() {
            $("#sub_category").change();

            var courses_name = $('select[name=sub_category] option:selected').text();
            var courses_id = $('select[name=sub_category] option:selected').val();
            // var courses_subtype = $('#courses_subtype').val();
            
            $.ajax({
                type: "POST",
                url: "ajaxactivecourses.php",
                data: {
                    "course_id": courses_id,
                    "courses_name": courses_name
                },

                success: function(response) {
                    let res = JSON.parse(response);
                    //alert(courses_subtype);
                   // console.log(carousel.dept_image);

                   $("#carosel_image").empty().append(res.carouselDetail);
                   $("#title_des").empty().append(res.titleDes);
                   $("#vision").empty().append(res.uvision);
                   $("#mission").empty().append(res.umission);
                   $("#goal").empty().append(res.ugoal);
                   $("#courses_st").empty().append(res.courses_subtype);
                   $("#fac").empty().append(res.ufaculty);
                   $("#lab").empty().append(res.ulab);
                   $("#stud_cocirr").empty().append(res.ucocurricular);
                   $("#stud_academic").empty().append(res.uacademic);
                   
                 
                    // $('#carosel_image').val('').trigger('liszt:updated');

                }
            });


        });
    });

    </script>
</body>

</html>