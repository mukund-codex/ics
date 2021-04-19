<?php
	include_once 'include/config.php';
	include_once 'include/admin-functions.php';
	$admin = new AdminFunctions();
	$pageName = "Postgraduate Courses Content";

	$pageURL = 'department-master.php';
	$addURL = 'department-add.php';
	$deleteURL = 'department-delete.php';
	$tableName = 'departments';


	$pageURL_dept_image = 'department_image-master.php';
	$addURL_dept_image = 'department_image-add.php';
	$deleteURL_dept_image = 'department_image-delete.php';
	$tableName_dept_image = 'departments_images';

	$sql = "SELECT * FROM ".PREFIX.$tableName_dept_image." order by dept_title ASC";
	$results = $admin->query($sql);





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
	$sql = "SELECT dp.*, bt.tabs as department_name FROM ".PREFIX.$tableName." dp JOIN dc_boxed_tabs bt ON dp.department_id = bt.id order by id DESC";
	$results = $admin->query($sql);


	$sqlForDepGallery = "SELECT * FROM ".PREFIX.$tableName_dept_image."";
	// print_r($sqlForDepGallery);exit();
	$results1 = $admin->query($sqlForDepGallery);
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo TITLE ?></title><link rel="shortcut icon" href="favicon.ico" type="image/x-icon"><link rel="icon" href="favicon.ico" type="image/x-icon">
	<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="css/londinium-theme.min.css" rel="stylesheet" type="text/css">
	<link href="css/styles.min.css" rel="stylesheet" type="text/css">
	<link href="css/icons.min.css" rel="stylesheet" type="text/css">

	<link href="css/font-awesome.min.css" rel="stylesheet">
	<!--<link href="css/nanoscroller.css" rel="stylesheet">
	<link href="css/cover.css" rel="stylesheet">-->

	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
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
				<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<i class="icon-checkmark"></i> Department Content successfully updated.
			</div><br/>
	<?php	} ?>
	<?php
		if(isset($_GET['deletesuccess'])){ ?>
			<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<i class="icon-checkmark"></i> <?php echo $pageName; ?> successfully deleted.
			</div><br/>
	<?php	} ?>
	
	<?php
		if(isset($_GET['deletefail'])){ ?>
			<div class="alert alert-danger alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<i class="icon-close"></i> <strong><?php echo $pageName; ?> not deleted.</strong> Invalid Details.
			</div><br/>
	<?php	} ?>

			<br/>
			
			<div class="panel panel-default">
				<div class="panel-heading">
					<h6 class="panel-title"><i class="icon-stats"></i> Department</h6>
				</div>
				<div class="panel-body">
				<a href="<?php echo $addURL; ?>" class="label label-primary pull-right">Add <?php echo $pageName; ?></a>
					<?php 
					
					//doubt
					$activeCount = $admin->num_rows($admin->query("SELECT * FROM ".PREFIX."banner_master"));
					//echo $activeCount;
					if($activeCount<7){
					?>
					
					<?php 
					}?>
					<br/><br/>
					<div class="datatable-selectable-data">
						<table class="table">
							<thead>
								<tr>
									<th>#</th>
									<th>Department</th>
									<th>Text</th>
									<th>Image</th>
									<th>Image Text</th>
									<th>Pdf</th>
                                    <th>Created Date</th>
                                    <th>Updated Date</th>
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
                                    <td><?php echo $row['department_name'] ?></td>
                                    <td><?php echo $row['text'] ?></td>
									<td><img src="../img/Department/<?php echo $file_name.'_crop.'.$ext ?>" width="100" /></td>
									<td><?php echo $row['image_text'] ?></td>
									<td><?php echo $row['pdf'] ?></td>
									<td><?php echo $row['created_at']; ?></td>
                                    <td><?php echo $row['updated_at']; ?></td>
									<td>
										<a href="<?php echo $addURL; ?>?edit&id=<?php echo $row['id'] ?>" name="edit" class="" title="Click to edit this row"><i class="icon-pencil"></i></a>
										<a class="" href="<?php echo $deleteURL; ?>?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete?');" title="Click to delete this row, this action cannot be undone."><i class="icon-remove3"></i></a>
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
			<br/>
			
			<div class="panel panel-default">
				<div class="panel-heading">
					<h6 class="panel-title"><i class="icon-stats"></i> Department Images</h6>
				</div>
				<div class="panel-body">
				<a href="<?php echo $addURL_dept_image; ?>" class="label label-primary pull-right">Add <?php echo $pageName." "."Images"; ?></a>
					<?php 
					
					//doubt
					$activeCount = $admin->num_rows($admin->query("SELECT * FROM ".PREFIX."banner_master"));
					//echo $activeCount;
					if($activeCount<7){
					?>
					
					<?php 
					}?>
					<br/><br/>
					<div class="datatable-selectable-data">
						<table class="table">
							<thead>
								<tr>
									<th>#</th>
									<th>Category</th>
									<th>Title</th>
									<th>Image</th>
									<th>Description</th>
                                    <th>Created Date</th>
                                    <th>Updated Date</th>
                                    <th>Action</th>
								</tr>
							</thead>
							<tbody>
<?php
							$x = (10*$pageNo)-9;
							while($row = $admin->fetch($results1)){
								$file_name = str_replace('', '-', strtolower( pathinfo($row['image'], PATHINFO_FILENAME)));
								$ext = pathinfo($row['image'], PATHINFO_EXTENSION);
								
?>
								<tr>
									<td><?php echo $x++; ?></td>
                                    <td><?php echo $row['category'] ?></td>
									<td><?php echo $row['dept_title'] ?></td>
									<td><img src="../img/Department/Arts/<?php echo $file_name.'_crop.'.$ext ?>" width="100" /></td>
									<td><?php echo $row['dept_discp'] ?></td>
									<td><?php echo $row['created_at']; ?></td>
                                    <td><?php echo $row['updated_at']; ?></td>
									<td>
										<a href="<?php echo $addURL_dept_image; ?>?edit&id=<?php echo $row['id'] ?>" name="edit" class="" title="Click to edit this row"><i class="icon-pencil"></i></a>
										<a class="" href="<?php echo $deleteURL; ?>?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete?');" title="Click to delete this row, this action cannot be undone."><i class="icon-remove3"></i></a>
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
				"order": [[ 0, 'asc' ]],
			});
		});
	</script>
</body>
</html>