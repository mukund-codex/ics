<?php
	include_once 'include/config.php';
	include_once 'include/admin-functions.php';
	$admin = new AdminFunctions();
	$pageName = "Header Content";
	$pageURL = 'headercontent-master.php';


	$addURL = 'header-aboutus-image-add.php';
	$deleteURL = 'header-aboutus-image-delete.php';
	$tableName = 'header_aboutus_image';


    $addURL_HAD = 'about-sanstha-add.php';
	$deleteURL_HAD = 'about-sanstha-delete.php';
	$tableName_HAD = 'header_aboutus_sanstha';


	$addURL_GA = 'header-governance-administration-add.php';
	$deleteURL_GA = 'header-governance-administration-delete.php';


	$addURL_academics = 'header-academics-add.php';
	$deleteURL_academics = 'header-academics-delete.php';

	$addURL_IQAC = 'header-iqac-add.php';
	$deleteURL_IQAC = 'header-iqac-delete.php';

	$addURL_Examination = 'header-examination-add.php';
	$deleteURL_Examination = 'header-examination-delete.php';

	$addURL_Admission = 'header-admission-add.php';
	$deleteURL_Admission = 'header-admission-delete.php';

	$addURL_Student_Corner = 'header-studentcorner-add.php';
	$deleteURL_Student_Corner = 'header-studentcorner-delete.php';

    $addURL_Announcements = 'header_announcements-add.php';
	$deleteURL_Announcements = 'header_announcements-delete.php';
    $tableName_announcements = 'announcements';

    


	//$tableName_GA = 'header_aboutus_sanstha';


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


    if(isset($_POST['update'])) {
		$id = trim($admin->escape_string($admin->strip_all($_POST['id'])));
		$result = $admin->updateLogo($_POST, $_FILES);
		header("location:".$pageURL."?updatesuccess");
		exit;
	}


	include_once "include/pagination.php";
	$pagination = new Pagination();
	$paginationArr = $pagination->generatePagination($pageURL, $pageNo, $total_pages, $linkParam);

	// $sql = "SELECT * FROM ".PREFIX.$tableName." order by created DESC LIMIT ".$paginationArr['start'].", ".$paginationArr['limit']."";
	$sql = "SELECT * FROM ".PREFIX.$tableName." ";
	$results = $admin->query($sql);


    $sqlHAD = "SELECT * FROM ".PREFIX.$tableName_HAD." ";
	$resultsHAD = $admin->query($sqlHAD);

    //logo
    $sqlannouncements = "SELECT * FROM ".PREFIX.$tableName_announcements." ";
	$resultsannouncements = $admin->query($sqlannouncements);

	//Governance & Administration
	$sqlUnion = "SELECT * FROM `dc_header_governingbody` 
	UNION
	SELECT * FROM `dc_header_boardofstudies` 
	UNION
	SELECT * FROM `dc_header_financecommittee`  
	UNION
	SELECT * FROM `dc_header_collegedevelopment` 
	UNION
	SELECT * FROM `dc_header_academic_council`

	";
	$resultUnion = $admin->query($sqlUnion);


	//Academics
	$sqlAcademics = "SELECT * FROM `dc_header_academic` 
	UNION
	SELECT * FROM `dc_header_department` ";
	$resultAcademics = $admin->query($sqlAcademics);


	//  IQAC 
	$sqlIQAC = "SELECT * FROM `dc_header_iqac` 
	UNION
	SELECT * FROM `dc_header_aqar` 
	UNION
	SELECT * FROM `dc_header_mom`  
	UNION
	SELECT * FROM `dc_header_naac` 
	UNION
	SELECT * FROM `dc_header_download` 

	";
	$resultIQAC = $admin->query($sqlIQAC);

	//Examination
	$sqlExamination = "SELECT * FROM `dc_header_rulesregulation` 
	UNION
	SELECT * FROM `dc_header_others` ";
	$resultExamination = $admin->query($sqlExamination);

	//Admission
	$sqlAdmission = "SELECT * FROM `dc_header_codeofcontent` 
	UNION
	SELECT * FROM `dc_header_antiraggingcell`
	UNION
	SELECT * FROM `dc_header_othersadmission` ";
	$resultAdmission = $admin->query($sqlAdmission);


	//studenr corner
	$sqlStdCorner = "SELECT * FROM `dc_header_implink` 
	UNION
	SELECT * FROM `dc_header_otherstudent` ";
	$resultStdCorner = $admin->query($sqlStdCorner);

    //logo
    $qry = $admin->query("SELECT * FROM ".PREFIX."header_college_logo where id='1'");
	$data = $admin->fetch($qry);

	
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
                    <li><a href="banner-master.php">Home</a></li>
                    <li class="active"><?php echo $pageName; ?></li>
                </ul>
            </div>

            <?php
		if(isset($_GET['updatesuccess'])){ ?>
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <i class="icon-checkmark"></i> Banner Content successfully updated.
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



            <!--Logo -->
            <form role="form" action="" method="post" id="formWelcome" enctype="multipart/form-data">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h6 class="panel-title"><i class="icon-library"></i>Header Logo</h6>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="row">
                           
                                <div class="col-sm-12">
                                    <label>College Logo</label>
                                    <input type="file" id="college_logo" class="form-control"
                                        accept="image/jpeg,image/png,image/jpg" name="college_logo"
                                        <?php if(!isset($_GET['edit'])) {  } ?> id=""
                                        data-image-index="0" />
                                    <span class="help-text">

                                        Allowed file types: <strong>png jpg jpeg</strong>.<br>
                                        Images must be exactly <strong>938x938</strong> pixels.
                                    </span>
                                    <br>
                                    <?php 
                                      
										$file_name = str_replace('', '-', strtolower( pathinfo($data['college_logo'], PATHINFO_FILENAME)));
										$ext = pathinfo($data['college_logo'], PATHINFO_EXTENSION);
									?>
                                    <img src="../img/collegelogo/<?php echo $file_name.'_crop.'.$ext ?>" width="100" />
                                    <?php
									 ?>
                                </div>
                            </div><br>
                            <div class="row">
                            <div class="col-sm-12">
                            <label>College Banner</label>
                                    <input type="file" id="college_banner" class="form-control"
                                        accept="image/jpeg,image/png,image/jpg" name="college_banner"
                                        <?php if(!isset($_GET['edit'])) {  } ?> id=""
                                        data-image-index="0" />
                                    <span class="help-text">

                                        Allowed file types: <strong>png jpg jpeg</strong>.<br>
                                        Images must be exactly <strong>1000x169</strong> pixels.
                                    </span>
                                    <br>
                                    <?php 
                                      
										$file_name = str_replace('', '-', strtolower( pathinfo($data['college_banner'], PATHINFO_FILENAME)));
										$ext = pathinfo($data['college_banner'], PATHINFO_EXTENSION);
									?>
                                    <img src="../img/collegelogo/<?php echo $file_name.'_crop.'.$ext ?>" width="100" />
                                    <?php
									 ?>
                                     </div>
                            </div><br>
                            <input type="hidden" name="<?php echo $token_id; ?>" value="<?php echo $token_value; ?>" />
                            <input type="hidden" name="id" value="<?php echo $data['id'];  ?>">
                            <button type="submit" name="update" class="btn btn-danger" style="float:right">Update
                                <?php echo $pageName; ?></button>
                        </div>
                    </div>

                </div>
            </form>
            <!-- end of Logo -->



             <!-- strat Announcements -->

             <div class="panel panel-default">
                <div class="panel-heading">
                    <h6 class="panel-title"><i class="icon-stats"></i>Announcements</h6>
                </div>
                <div class="panel-body">
                    <a href="<?php echo $addURL_Announcements; ?>" class="label label-primary pull-right">Add
                    Announcements</a>
                    <?php 
					
					//doubt
					$activeCount = $admin->num_rows($admin->query("SELECT * FROM ".PREFIX."announcements"));
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
                                    <th>Title</th>
                                    <th>Link</th>
                                    <th>PDF</th>

                                    <th>Created Date</th>
                                    <th>Updated Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
							$x = (10*$pageNo)-9;
							while($row = $admin->fetch($resultsannouncements)){
								// $file_name = str_replace('', '-', strtolower( pathinfo($row['image'], PATHINFO_FILENAME)));
								// $ext = pathinfo($row['image'], PATHINFO_EXTENSION);
?>
                                <tr>
                                    <td><?php echo $x++; ?></td>
                                    <td><?php echo $row['title'] ?></td>
                                    <td><?php echo $row['link'] ?></td>
                                    <td><?php echo $row['pdf'] ?></td>

                                    <td><?php echo $row['created_at']; ?></td>
                                    <td><?php echo $row['updated_at']; ?></td>
                                    <td>
                                        <a href="<?php echo $addURL_Announcements; ?>?edit&id=<?php echo $row['id'] ?>"
                                            name="edit" class="" title="Click to edit this row"><i
                                                class="icon-pencil"></i></a>
                                        <a class="" href="<?php echo $deleteURL_Announcements; ?>?id=<?php echo $row['id']; ?>"
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
            <!-- end of Announcements -->
            </br>



            <div class="panel panel-default">
                <div class="panel-heading">
                    <h6 class="panel-title"><i class="icon-stats"></i> About us Images</h6>
                </div>
                <div class="panel-body">
                    <a href="<?php echo $addURL; ?>" class="label label-primary pull-right">Add
                        <?php echo $pageName; ?></a>
                    <?php 
					
					$activeCount = $admin->num_rows($admin->query("SELECT * FROM ".PREFIX."banner_master"));
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
                                    <th>Image</th>
                                    <th>Created date</th>
                                    <th>Updated date</th>

                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
							$x = (10*$pageNo)-9;
							while($row = $admin->fetch($results)){
								$file_name = str_replace('', '-', strtolower( pathinfo($row['image'], PATHINFO_FILENAME)));
								$ext = pathinfo($row['image'], PATHINFO_EXTENSION);
?>
                                <tr>
                                    <td><?php echo $x++; ?></td>
                                    <td><img src="../img/headers/<?php echo $file_name.'_crop.'.$ext ?>" width="100" />
                                    </td>
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


            <!-- strat Sanstha -->

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h6 class="panel-title"><i class="icon-stats"></i>About Sanstha</h6>
                </div>
                <div class="panel-body">
                    <a href="<?php echo $addURL_HAD; ?>" class="label label-primary pull-right">Add
                        About Sanstha</a>
                    <?php 
					
					//doubt
					$activeCount = $admin->num_rows($admin->query("SELECT * FROM ".PREFIX."header_aboutus_sanstha"));
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
                                    <th>Title</th>
                                    <th>Link</th>
                                    <th>PDF</th>

                                    <th>Created Date</th>
                                    <th>Updated Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
							$x = (10*$pageNo)-9;
							while($row = $admin->fetch($resultsHAD)){
								// $file_name = str_replace('', '-', strtolower( pathinfo($row['image'], PATHINFO_FILENAME)));
								// $ext = pathinfo($row['image'], PATHINFO_EXTENSION);
?>
                                <tr>
                                    <td><?php echo $x++; ?></td>
                                    <td><?php echo $row['title'] ?></td>
                                    <td><?php echo $row['link'] ?></td>
                                    <td><?php echo $row['pdf'] ?></td>

                                    <td><?php echo $row['created_at']; ?></td>
                                    <td><?php echo $row['updated_at']; ?></td>
                                    <td>
                                        <a href="<?php echo $addURL_HAD; ?>?edit&id=<?php echo $row['id'] ?>"
                                            name="edit" class="" title="Click to edit this row"><i
                                                class="icon-pencil"></i></a>
                                        <a class="" href="<?php echo $deleteURL_HAD; ?>?id=<?php echo $row['id']; ?>"
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
            <!-- end of Sanstha -->
            </br>


            <!-- strat Governance & Administration -->

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h6 class="panel-title"><i class="icon-stats"></i>Governance & Administration</h6>
                </div>
                <div class="panel-body">
                    <a href="<?php echo $addURL_GA; ?>" class="label label-primary pull-right">Add
                        Governance & Administration</a>
                    <?php 
					
					//doubt
					$activeCount = $admin->num_rows($admin->query("SELECT * FROM ".PREFIX."header_aboutus_sanstha"));
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
									<th>Type</th>
                                    <th>Title</th>
                                    <th>Link</th>
                                    <th>PDF</th>
                                    <th>Created Date</th>
                                    <th>Updated Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
							$x = (10*$pageNo)-9;
							while($row = $admin->fetch($resultUnion)){
								// $file_name = str_replace('', '-', strtolower( pathinfo($row['image'], PATHINFO_FILENAME)));
								// $ext = pathinfo($row['image'], PATHINFO_EXTENSION);
?>
                                <tr>
                                    <td><?php echo $x++; ?></td>
									<td><?php echo $row['type'] ?></td>
                                    <td><?php echo $row['title'] ?></td>
                                    <td><?php echo $row['link'] ?></td>
                                    <td><?php echo $row['pdf'] ?></td>
                                    <td><?php echo $row['created_at']; ?></td>
                                    <td><?php echo $row['updated_at']; ?></td>
                                    <td>
                                        <a href="<?php echo $addURL_GA; ?>?edit&category=<?php echo $row['type'];?>&id=<?php echo $row['id']; ?>"
                                            name="edit" class="" title="Click to edit this row"><i
                                                class="icon-pencil"></i></a>
                                        <a class="" href="<?php echo $deleteURL_GA; ?>?category=<?php echo $row['type'];?>&id=<?php echo $row['id']; ?>"
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
            <!-- end of Governance & Administration -->
            </br>



			
            <!-- strat Academics -->

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h6 class="panel-title"><i class="icon-stats"></i>Academics</h6>
                </div>
                <div class="panel-body">
                    <a href="<?php echo $addURL_academics; ?>" class="label label-primary pull-right">Add
                        Academics</a>
                    <?php 
					
					//doubt
					$activeCount = $admin->num_rows($admin->query("SELECT * FROM ".PREFIX."header_aboutus_sanstha"));
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
									<th>Type</th>
                                    <th>Title</th>
                                    <th>Link</th>
                                    <th>PDF</th>
                                    <th>Created Date</th>
                                    <th>Updated Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
							$x = (10*$pageNo)-9;
							while($row = $admin->fetch($resultAcademics)){
								// $file_name = str_replace('', '-', strtolower( pathinfo($row['image'], PATHINFO_FILENAME)));
								// $ext = pathinfo($row['image'], PATHINFO_EXTENSION);
?>
                                <tr>
                                    <td><?php echo $x++; ?></td>
									<td><?php echo $row['type'] ?></td>
                                    <td><?php echo $row['title'] ?></td>
                                    <td><?php echo $row['link'] ?></td>
                                    <td><?php echo $row['pdf'] ?></td>
                                    <td><?php echo $row['created_at']; ?></td>
                                    <td><?php echo $row['updated_at']; ?></td>
                                    <td>
                                        <a href="<?php echo $addURL_academics; ?>?edit&category=<?php echo $row['type'];?>&id=<?php echo $row['id']; ?>"
                                            name="edit" class="" title="Click to edit this row"><i
                                                class="icon-pencil"></i></a>
                                        <a class="" href="<?php echo $deleteURL_academics; ?>?category=<?php echo $row['type'];?>&id=<?php echo $row['id']; ?>"
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
            <!-- end of Academics -->
            </br>




		
			
            <!-- strat IQAC -->

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h6 class="panel-title"><i class="icon-stats"></i>IQAC</h6>
                </div>
                <div class="panel-body">
                    <a href="<?php echo $addURL_IQAC; ?>" class="label label-primary pull-right">Add
                        IQAC</a>
                    <?php 
					
					//doubt
					$activeCount = $admin->num_rows($admin->query("SELECT * FROM ".PREFIX."header_aboutus_sanstha"));
					//echo $activeCount;
					if($activeCount<7){
					?>

                    <?php 
					}?>
                    <br /><br />
                    <div class="datatable-selectable-data" style="overflow-x:auto;">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
									<th>Type</th>
                                    <th>Title</th>
                                    <th>Link</th>
                                    <th>PDF</th>
                                    <th>Created Date</th>
                                    <th>Updated Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
							$x = (10*$pageNo)-9;
							while($row = $admin->fetch($resultIQAC)){
								// $file_name = str_replace('', '-', strtolower( pathinfo($row['image'], PATHINFO_FILENAME)));
								// $ext = pathinfo($row['image'], PATHINFO_EXTENSION);
?>
                                <tr>
                                    <td><?php echo $x++; ?></td>
									<td><?php echo $row['type'] ?></td>
                                    <td><?php echo $row['title'] ?></td>
                                    <td><?php echo $row['link'] ?></td>
                                    <td><?php echo $row['pdf'] ?></td>
                                    <td><?php echo $row['created_at']; ?></td>
                                    <td><?php echo $row['updated_at']; ?></td>
                                    <td>
                                        <a href="<?php echo $addURL_IQAC; ?>?edit&category=<?php echo $row['type'];?>&id=<?php echo $row['id']; ?>"
                                            name="edit" class="" title="Click to edit this row"><i
                                                class="icon-pencil"></i></a>
                                        <a class="" href="<?php echo $deleteURL_IQAC; ?>?category=<?php echo $row['type'];?>&id=<?php echo $row['id']; ?>"
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
            <!-- end of IQAC -->
            </br>



			
			
            <!-- strat Examination -->

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h6 class="panel-title"><i class="icon-stats"></i>Examination</h6>
                </div>
                <div class="panel-body">
                    <a href="<?php echo $addURL_Examination; ?>" class="label label-primary pull-right">Add
                        Examination</a>
                    <?php 
					
					//doubt
					$activeCount = $admin->num_rows($admin->query("SELECT * FROM ".PREFIX."header_aboutus_sanstha"));
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
									<th>Type</th>
                                    <th>Title</th>
                                    <th>Link</th>
                                    <th>PDF</th>
                                    <th>Created Date</th>
                                    <th>Updated Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
							$x = (10*$pageNo)-9;
							while($row = $admin->fetch($resultExamination)){
								// $file_name = str_replace('', '-', strtolower( pathinfo($row['image'], PATHINFO_FILENAME)));
								// $ext = pathinfo($row['image'], PATHINFO_EXTENSION);
?>
                                <tr>
                                    <td><?php echo $x++; ?></td>
									<td><?php echo $row['type'] ?></td>
                                    <td><?php echo $row['title'] ?></td>
                                    <td><?php echo $row['link'] ?></td>
                                    <td><?php echo $row['pdf'] ?></td>
                                    <td><?php echo $row['created_at']; ?></td>
                                    <td><?php echo $row['updated_at']; ?></td>
                                    <td>
                                        <a href="<?php echo $addURL_Examination; ?>?edit&category=<?php echo $row['type'];?>&id=<?php echo $row['id']; ?>"
                                            name="edit" class="" title="Click to edit this row"><i
                                                class="icon-pencil"></i></a>
                                        <a class="" href="<?php echo $deleteURL_Examination; ?>?category=<?php echo $row['type'];?>&id=<?php echo $row['id']; ?>"
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
            <!-- end of Examination -->
            </br>


			
			
            <!-- strat Admission -->

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h6 class="panel-title"><i class="icon-stats"></i>Admission</h6>
                </div>
                <div class="panel-body">
                    <a href="<?php echo $addURL_Admission; ?>" class="label label-primary pull-right">Add
                        Admission</a>
                    <?php 
					
					//doubt
					$activeCount = $admin->num_rows($admin->query("SELECT * FROM ".PREFIX."header_aboutus_sanstha"));
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
									<th>Type</th>
                                    <th>Title</th>
                                    <th>Link</th>
                                    <th>PDF</th>
                                    <th>Created Date</th>
                                    <th>Updated Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
							$x = (10*$pageNo)-9;
							while($row = $admin->fetch($resultAdmission)){
								// $file_name = str_replace('', '-', strtolower( pathinfo($row['image'], PATHINFO_FILENAME)));
								// $ext = pathinfo($row['image'], PATHINFO_EXTENSION);
?>
                                <tr>
                                    <td><?php echo $x++; ?></td>
									<td><?php echo $row['type'] ?></td>
                                    <td><?php echo $row['title'] ?></td>
                                    <td><?php echo $row['link'] ?></td>
                                    <td><?php echo $row['pdf'] ?></td>
                                    <td><?php echo $row['created_at']; ?></td>
                                    <td><?php echo $row['updated_at']; ?></td>
                                    <td>
                                        <a href="<?php echo $addURL_Admission; ?>?edit&category=<?php echo $row['type'];?>&id=<?php echo $row['id']; ?>"
                                            name="edit" class="" title="Click to edit this row"><i
                                                class="icon-pencil"></i></a>
                                        <a class="" href="<?php echo $deleteURL_Admission; ?>?category=<?php echo $row['type'];?>&id=<?php echo $row['id']; ?>"
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
            <!-- end of Admission -->
            </br>


			
			
            <!-- strat Student Corner -->

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h6 class="panel-title"><i class="icon-stats"></i>Student Corner</h6>
                </div>
                <div class="panel-body">
                    <a href="<?php echo $addURL_Student_Corner; ?>" class="label label-primary pull-right">Add
                        Student Corner</a>
                    <?php 
					
					//doubt
					$activeCount = $admin->num_rows($admin->query("SELECT * FROM ".PREFIX."header_aboutus_sanstha"));
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
									<th>Type</th>
                                    <th>Title</th>
                                    <th>Link</th>
                                    <th>PDF</th>
                                    <th>Created Date</th>
                                    <th>Updated Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
							$x = (10*$pageNo)-9;
							while($row = $admin->fetch($resultStdCorner)){
								// $file_name = str_replace('', '-', strtolower( pathinfo($row['image'], PATHINFO_FILENAME)));
								// $ext = pathinfo($row['image'], PATHINFO_EXTENSION);
?>
                                <tr>
                                    <td><?php echo $x++; ?></td>
									<td><?php echo $row['type'] ?></td>
                                    <td><?php echo $row['title'] ?></td>
                                    <td><?php echo $row['link'] ?></td>
                                    <td><?php echo $row['pdf'] ?></td>
                                    <td><?php echo $row['created_at']; ?></td>
                                    <td><?php echo $row['updated_at']; ?></td>
                                    <td>
                                        <a href="<?php echo $addURL_Student_Corner; ?>?edit&category=<?php echo $row['type'];?>&id=<?php echo $row['id']; ?>"
                                            name="edit" class="" title="Click to edit this row"><i
                                                class="icon-pencil"></i></a>
                                        <a class="" href="<?php echo $deleteURL_Student_Corner; ?>?category=<?php echo $row['type'];?>&id=<?php echo $row['id']; ?>"
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
            <!-- end of Student Corner -->
            </br>
           



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
    <script type="text/javascript" src="js/editor/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="js/editor/ckfinder/ckfinder.js"></script>
    <link href="css/crop-image/cropper.min.css" rel="stylesheet">
    <script src="js/crop-image/cropper.min.js"></script>
    <script src="js/crop-image/image-crop-app.js"></script>
    <script src="js/crop-image/image-crop-app1.js"></script>
    <script>
    $(document).ready(function() {
        $('.datatable-selectable-data table').dataTable({
            "order": [
                [0, 'asc']
            ],
        });
    });

    $('#college_logo').change(function() {
        // loadImageInModal(this);
        loadImagePreview(this, (938 / 938));
    });

    $('#college_banner').change(function() {
        // loadImageInModal(this);
        loadImagePreview1(this, (1000 / 169));
    });
    </script>
</body>

</html>