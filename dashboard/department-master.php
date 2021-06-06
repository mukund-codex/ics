<?php

	include_once 'include/config.php';
	include_once 'include/admin-functions.php';
	$admin = new AdminFunctions();
	$pageName = "Department Details";

	$pageURL = 'department-master.php';
	$addURL = 'department-add.php';
	$deleteURL = 'department-delete.php';
	$tableName = 'departments';


	$pageURL_dept_image = 'department_image-master.php';
	$addURL_dept_image = 'department_image-add.php';
	$deleteURL_dept_image = 'department_image-delete.php';
	$tableName_dept_image = 'departments_images';

	//add-title-description.php

	$addURL_titledes = 'sub-courses-add-title-description.php';
	$deleteURL_titledes = 'sub-courses-delete-title-description.php';
	$tableName_titledes = 'sub_coursestitle_descrption';

    //carousel
	$addURL_CI = 'sub-coruses-carousel-images-add.php';
	$deleteURL_CI = 'sub-coruses-carousel-images-delete.php';
	$tableName_CI = 'sub_coruses_carousel_images';


    // //Add Subtype For Courses

    // $addURL_subtype = 'subtype-courses-images-add.php';
	// $deleteURL_subtype = 'subtype-courses-images-delete.php';
	// $tableName_subtype = 'subtype_courses_images';

	// $sql = "SELECT * FROM ".PREFIX.$tableName_dept_image." order by dept_title ASC";
	// $results = $admin->query($sql);

    // echo $_SESSION["course_name"] ;exit;
    



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

	// $sql = "SELECT * FROM ".PREFIX.$tableName." order by created DESC LIMIT ".$paginationArr['start'].", ".$paginationArr['limit']."";
	// $sql = "SELECT dp.*, bt.tabs as department_name FROM ".PREFIX.$tableName." dp JOIN dc_boxed_tabs bt ON dp.department_id = bt.department_id order by id DESC";
	// $results = $admin->query($sql);

    $a = $_SESSION["course_id"] ;

    $sqlTitle1 = "SELECT COUNT(coruses_id) as count1 FROM `dc_subtype_courses_list` where coruses_id= '$a' ";
    $resultTitle1 = $admin->query($sqlTitle1);
    $rowcount = $admin->fetch($resultTitle1);
    //echo $rowcount['count1'];exit;
    
	$sqlForDepGallery = "SELECT bt.tabs,dt.category,dt.image,dt.created_at,dt.id FROM `dc_boxed_tabs` as bt , `dc_departments_images` as dt where bt.`department_id` = dt.`tabs`";
	// print_r($sqlForDepGallery);exit();
	$results1 = $admin->query($sqlForDepGallery);

    $sqlTitleDes = "SELECT `td`.*,`cat`.category,`stl`.courses_subtype FROM `dc_sub_coursestitle_descrption` as td ,
    `dc_category` as cat,`dc_subtype_courses_list` as stl WHERE `td`.courses_subtype_id = `stl`.courses_subtype_id  AND `cat`.coruses_id = `stl`.coruses_id";
	$results2 = $admin->query($sqlTitleDes);

	$sqlCI = "SELECT `sci`.*,`cat`.category,`stl`.courses_subtype FROM `dc_sub_coruses_carousel_images` as sci ,
    `dc_category` as cat,`dc_subtype_courses_list` as stl WHERE `sci`.courses_subtype_id = `stl`.courses_subtype_id  AND `cat`.coruses_id = `stl`.coruses_id";
	$results3 = $admin->query($sqlCI);


    // $sqlCI = "SELECT `sci`.*,`cat`.category,`stl`.courses_subtype FROM `dc_sub_coruses_carousel_images` as sci ,
    // `dc_category` as cat,`dc_subtype_courses_list` as stl WHERE `sci`.courses_subtype_id = `stl`.courses_subtype_id  AND `cat`.coruses_id = `stl`.coruses_id";
	// $results3 = $admin->query($sqlCI);


   

   //for department
//    $sql = " SELECT dp.*, bt.tabs as department_name , `cat`.category ,`stl`.courses_subtype FROM `dc_departments` as dp, `dc_boxed_tabs` as bt, 
//    `dc_category` as cat,`dc_subtype_courses_list` as stl WHERE dp.department_id = bt.department_id AND
//     `cat`.coruses_id = `stl`.coruses_id";
//     $results = $admin->query($sql);


    //tabs
    $sql = "
            select dt.* , bt.tabs as tab,tc.category as couresname, slt.courses_subtype as subtype from dc_departments dt
            JOIN dc_boxed_tabs bt ON bt.department_id =dt.department_id
            JOIN dc_category tc ON tc.coruses_id = dt.category_type 
            LEFT JOIN dc_subtype_courses_list slt ON slt.coruses_id = dt.category_type 
            GROUP BY dt.id
            ";
	$results = $admin->query($sql);

    //dc_subtype_courses_list courses_subtype Solo courses_subtype_id coruses_id

	
    //tab gallery
    //SELECT ct.category as course,di.* FROM `dc_departments_images` di JOIN dc_category ct ON di.category = ct.coruses_id  
	// $sqlForDepGallery = "SELECT bt.tabs as department_name ,ct.category as couresname,dt.image,dt.created_at,dt.id FROM `dc_boxed_tabs` as bt , `dc_departments_images` as dt where bt.`department_id` = dt.`tabs`";
	// $results1 = $admin->query($sqlForDepGallery);

    
    $sqlForDepGallery =" select dt.* , bt.tabs as tab,tc.category as couresname, slt.courses_subtype as subtype from `dc_departments_images` dt
    JOIN dc_boxed_tabs bt ON bt.department_id =dt.tabs
    JOIN dc_category tc ON tc.coruses_id = dt.category 
    LEFT JOIN dc_subtype_courses_list slt ON slt.coruses_id = dt.category
    GROUP BY dt.id
    ";
	$results1 = $admin->query($sqlForDepGallery);
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
                    <option value="PG">PostGraduate</option>
                    <option value="Other">Other Courses</option>
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


            <div class="form-group" id="sub_category2">
                <label for="sel2">Select Sub Courses:</label>
                <select class="form-control" id="sub_courses_category" name="sub_courses_category" data-rel="chosen">
                    <option>Select Sub Courses</option>
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
					$activeCount = $admin->num_rows($admin->query("SELECT * FROM ".PREFIX."sub_coruses_carousel_images"));
					//echo $activeCount;
					if($activeCount<7){
					?>

                        <?php 
                        }?>
                    <br /><br />
                    <div class="datatable-selectable-data">
                        <table class="table" id="carosel_image">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Category</th>
                                    <th>Sub Category</th>
                                    <th>Image</th>
                                    <th>Created Date</th>
                                    <th>Updated Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody >
                                <?php
							$x = (10*$pageNo)-9;
							while($row = $admin->fetch($results3)){
								$file_name = str_replace('', '-', strtolower( pathinfo($row['image'], PATHINFO_FILENAME)));
								$ext = pathinfo($row['image'], PATHINFO_EXTENSION);
								
?>
                                <tr>
                                    <td><?php echo $x++; ?></td>
                                    <td><?php echo strip_tags($row['category']) ?></td>
                                    <td><?php echo strip_tags($row['courses_subtype']) ?></td>
								
                                    <td><img src="../img/Department/subcoursestype/<?php echo $file_name.'_crop.'.$ext ?>"
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
                        <table class="table" id="title_des">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Course</th>
                                    <th>Sub Course</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Created Date</th>
                                    <th>Updated Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody >
                                <?php
                                    $x = (10*$pageNo)-9;
                                    while($row = $admin->fetch($results2)){
                                        
                                ?>
                                <tr>
                                    <td><?php echo $x++; ?></td>
                                    <td><?php echo strip_tags($row['category']) ?></td>
                                    <td><?php echo strip_tags($row['courses_subtype']) ?></td>
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


            <div class="panel panel-default">
                <div class="panel-heading">
                    <h6 class="panel-title"><i class="icon-stats"></i> Department</h6>
                </div>
                <div class="panel-body">
                    <a href="<?php echo $addURL; ?>" class="label label-primary pull-right">Add
                        <?php echo $pageName; ?></a>
                    <?php 
					
					//doubt
					$activeCount = $admin->num_rows($admin->query("SELECT * FROM ".PREFIX."departments"));
					//echo $activeCount;
					if($activeCount<7){
					?>

                    <?php 
					}?>
                    <br /><br />
                    <div class="datatable-selectable-data" style="overflow-x:auto;">
                        <table class="table" id="department22">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Courses</th>
                                    <th>Sub Courses</th>                              
                                    <th>Tab</th>
                                    <th>Description</th>
                                    <th>pdf</th>
                                    <th>Created Date</th>
                                    <th>Updated Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody >
                                <?php
							$x = (10*$pageNo)-9;
							while($row = $admin->fetch($results)){
								$file_name = str_replace('', '-', strtolower( pathinfo($row['image'], PATHINFO_FILENAME)));
								$ext = pathinfo($row['image'], PATHINFO_EXTENSION);
?>
                                <tr>
                                    <td><?php echo $x++; ?></td>
                                    <td><?php echo strip_tags($row['couresname']); ?></td>

                                    <td><?php echo strip_tags($row['subtype']); ?></td>

                                    <td><?php echo strip_tags($row['tab']); ?></td>
                                 
                                
                                    <td><?php echo $row['text']; ?></td>

                                    <td><?php echo $row['pdf']; ?></td>
                                    <td><?php echo $row['created_at']; ?></td>
                                    <td><?php echo $row['updated_at']; ?></td>
                                    <td>
                                        <a href="<?php echo $addURL; ?>?edit&id=<?php echo $row['id'] ?>" name="edit"
                                            class="" title="Click to edit this row"><i class="icon-pencil"></i></a>
                                        <a class="" href="<?php echo $deleteURL; ?>?id=<?php echo $row['id']; ?>"
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

            <!-- department gallery -->
            <br />

			<div class="panel panel-default">
                <div class="panel-heading">
                    <h6 class="panel-title"><i class="icon-stats"></i> Department Images</h6>
                </div>
                <div class="panel-body">
                    <a href="<?php echo $addURL_dept_image; ?>" class="label label-primary pull-right">Add
                        <?php echo $pageName." "."Images"; ?></a>
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
                        <table class="table" id="department_image">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    
                                    <th>Category</th>
                                    <th>Sub Category</th>
									<th>Tabs</th>
                                    <th>Image</th>
                                    <th>Created Date</th>
                                    <!-- <th>Updated Date</th> -->
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody >
                                <?php
							$x = (10*$pageNo)-9;
							while($row = $admin->fetch($results1)){
								$file_name = str_replace('', '-', strtolower( pathinfo($row['image'], PATHINFO_FILENAME)));
								$ext = pathinfo($row['image'], PATHINFO_EXTENSION);
								
?>
                                <tr>
                                    <td><?php echo $x++; ?></td>
                                    <td><?php echo strip_tags($row['couresname']); ?></td>
                                    <td><?php echo strip_tags($row['subtype']); ?></td>
									<td><?php echo $row['tab'] ?></td>
                                    <td><img src="../img/Department/<?php echo $file_name.'_crop.'.$ext ?>"
                                            width="100" /></td>

                                    <td><?php echo $row['created_at']; ?></td>
                                    <!-- <td><?php echo $row['updated_at']; ?></td> -->
                                    <td>
                                        <a href="<?php echo $addURL_dept_image; ?>?edit&id=<?php echo $row['id'] ?>"
                                            name="edit" class="" title="Click to edit this row"><i
                                                class="icon-pencil"></i></a>
                                        <a class="" href="<?php echo $deleteURL; ?>?id=<?php echo $row['id']; ?>"
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

            $.ajax({
                type: "POST",
                url: "activecourses.php",
                data: {
                    "course_id": courses_id,
                    "courses_name": courses_name
                },

                success: function(response) {
                    let carousel = JSON.parse(response);
                   // console.log(carousel.department);
                    $("#sub_courses_category").html(carousel.subcat);
                    $("#carosel_image").empty().append(carousel.carouselDetail);
                    $("#title_des").empty().append(carousel.titleDes);
                    $("#department22").empty().append(carousel.department);
                    $("#department_image").empty().append(carousel.dept_image);
                    
                    // $('#carosel_image').val('').trigger('liszt:updated');

                }
            });


        });
    });


    $(function() {
        $("#sub_category2").click(function() {
            $("#sub_courses_category").change();

            var sub_courses_name = $('select[name=sub_courses_category] option:selected').text();
            var sub_courses_id = $('select[name=sub_courses_category] option:selected').val();

           // console.log(sub_courses_name+"   "+sub_courses_id);
            $.ajax({
                type: "POST",
                url: "activecourses2.php",
                data: {
                    "sub_courses_id": sub_courses_id,
                    "sub_courses_name": sub_courses_name
                },

                success: function(response) {
                    let res = JSON.parse(response);
                    // let res = response;
                //  console.log(res.carouselDetail1);

                     $("#carosel_image").empty().append(res.carouselDetail1);
                     $("#title_des").empty().append(res.subtitledes);
                     $("#department22").empty().append(res.department);
                    // $("#department_image").empty().append(carousel.dept_image);
                 
                    // $('#carosel_image').val('').trigger('liszt:updated');

                }
            });


        });
    });

    </script>
</body>

</html>