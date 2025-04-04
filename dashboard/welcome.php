<?php
	include_once 'include/config.php';
	include_once 'include/admin-functions.php';
	$admin = new AdminFunctions();
	$pageName = "Home Page Content";
	$pageURL = 'welcome.php';
	$addURL = 'home-carousel-add.php';
	$deleteURL = 'home-carousel-delete.php';
	$tableName = 'home_carousel';

    //undergraduate
    $pageName_UG = "Undergraduate";
    $addURL_UG = 'undergraduate-images-add.php';
	$delete_UG = 'undergraduate-images-delete.php';
	$tableName_UG = 'undergraduate_images';


    //postgraduate
    $pageName_PG = "Postgraduate";
   $addURL_PG = 'postgraduate-images-add.php';
	$deleteURL_PG = 'postgraduate-images-delete.php';
    $tableName_PG = 'postgraduate_images';

    $pageName_OI = "Other Courses";
    $addURL_OI = 'others-images-add.php';
     $deleteURL_OI = 'others-images-delete.php';
     $tableName_OI = 'other_images';


    //infrastructure
    $pageName_INFA = "Infrastructure";
    $addURL_INFA = 'Infrastructure-images-add.php';
	$deleteURL_INFA = 'Infrastructure-images-delete.php';
	 $tableName_INFA = 'infrastructure_images';

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

    //doubt
	$query = "SELECT COUNT(*) as num FROM ".PREFIX.$tableName_UG;


	$total_pages = $admin->fetch($admin->query($query));
	$total_pages = $total_pages['num'];
	
	if(isset($_POST['update'])) {
		$id = trim($admin->escape_string($admin->strip_all($_POST['id'])));
		$result = $admin->updateAboutUs($_POST, $_FILES);
		header("location:".$pageURL."?updatesuccess");
		exit;
	}
	// if(isset($_POST['update_detailing'])) {
	// 	$id = trim($admin->escape_string($admin->strip_all($_POST['id'])));
	// 	$result = $admin->updateHomeDetailingContent($_POST);
	// 	header("location:".$pageURL."?updatesuccess");
	// 	exit;
	// }

	include_once "include/pagination.php";
	$pagination = new Pagination();
	$paginationArr = $pagination->generatePagination($pageURL, $pageNo, $total_pages, $linkParam);
	$qry = $admin->query("SELECT * FROM ".PREFIX."gallery_content where id='1'");
	$data = $admin->fetch($qry);
	// $sql = "SELECT * FROM ".PREFIX.$tableName." order by created DESC LIMIT ".$paginationArr['start'].", ".$paginationArr['limit']."";
	$sql = "SELECT * FROM ".PREFIX.$tableName." order by display_order ASC";
	$results = $admin->query($sql);

    $sql_UG = "SELECT * FROM ".PREFIX.$tableName_UG." order by display_order ASC";
	$results_UG = $admin->query($sql_UG);

    $sql_PG = "SELECT * FROM ".PREFIX.$tableName_PG." order by display_order ASC";
	$results_PG = $admin->query($sql_PG);

    $sql_OI = "SELECT * FROM ".PREFIX.$tableName_OI." order by id ASC";
	$results_OI = $admin->query($sql_OI);

    $sql_INFA = "SELECT * FROM ".PREFIX.$tableName_INFA." order by display_order ASC";
	$results_INFA = $admin->query($sql_INFA);

    // $sql_IFRA = "SELECT * FROM ".PREFIX.$tableName_UG." order by display_order ASC";
	// $results_IFRA = $admin->query($sql_IFRA);

	

	
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
            <br />

            <?php
		if(isset($_GET['deletesuccess'])){ ?>
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <i class="icon-checkmark"></i> <?php echo $pageName; ?> successfully deleted.
            </div><br />
            <?php	} ?>
            <?php
		if(isset($_GET['updatesuccess'])){ ?>
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <i class="icon-checkmark"></i> Home Content successfully updated.
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
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h6 class="panel-title"><i class="icon-stats"></i> <?php echo 'Achievements'; ?></h6>
                </div>
                <div class="panel-body">

                    <a href="<?php echo $addURL; ?>" class="label label-primary pull-right">Add <?php echo 'Achievements'; ?>
                    </a>

                    <br /><br />
                    <div class="datatable-selectable-data">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Sub Title</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
							$x = (10*$pageNo)-9;
							
							while($row = $admin->fetch($results)){
								$file_name = str_replace('', '-', strtolower( pathinfo($row['image_name'], PATHINFO_FILENAME)));
								$ext = pathinfo($row['image_name'], PATHINFO_EXTENSION);
?>
                                <tr>
                                    <td><?php echo $x++; ?></td>
                                    <td><img src="../img/achievements/<?php echo $file_name.'_crop.'.$ext ?>"
                                            width="100" /></td>
                                    <td><?php echo $row['title'] ?></td>
                                    <td><?php echo $row['sub_title'] ?></td>
                                  

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
            <br>
            <!--about us -->
            <form role="form" action="" method="post" id="formWelcome" enctype="multipart/form-data">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h6 class="panel-title"><i class="icon-library"></i>About Us</h6>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="row">
                           
                                <div class="col-sm-12">
                                    <label>Thumbnail Image</label>
                                    <input type="file" id="img" class="form-control"
                                        accept="image/jpeg,image/png,image/jpg" name="thumbnail"
                                        <?php if(!isset($_GET['edit'])) {  } ?> id=""
                                        data-image-index="0" />
                                    <span class="help-text">

                                        Allowed file types: <strong>png jpg jpeg</strong>.<br>
                                        Images must be exactly <strong>800x533</strong> pixels.
                                    </span>
                                    <br>
                                    <?php 
                                      
										$file_name = str_replace('', '-', strtolower( pathinfo($data['image'], PATHINFO_FILENAME)));
										$ext = pathinfo($data['image'], PATHINFO_EXTENSION);
									?>
                                    <img src="../img/aboutus/<?php echo $file_name.'_crop.'.$ext ?>" width="100" />
                                    <?php
									 ?>
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col-sm-12">
                                    <label>Description <span style="color:red">*</span> </label>
                                    <textarea col="5" rows="4" class="form-control" required name="description"
                                        id="" /><?php if(!empty($data['description'])){ echo $data['description']; }?></textarea>
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
            <!-- end of about us -->
            <br />
            <!--undergraduate-->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h6 class="panel-title"><i class="icon-stats"></i> <?php echo $pageName_UG; ?></h6>
                </div>
                <div class="panel-body">

                    <a href="<?php echo $addURL_UG; ?>" class="label label-primary pull-right">Add
                        <?php echo $pageName_UG; ?>
                    </a>

                    <br /><br />
                    <div class="datatable-selectable-data-undergraduate">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Sub Title</th>
                                
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
							$x = (10*$pageNo)-9;
							
							while($row = $admin->fetch($results_UG)){
                                
								$file_name = str_replace('', '-', strtolower( pathinfo($row['undergraduate_image'], PATHINFO_FILENAME)));
                                
								$ext = pathinfo($row['undergraduate_image'], PATHINFO_EXTENSION);
?>
                                <tr>
                                    <td><?php echo $x++; ?></td>
                                    <td><img src="../img/Undergraduate/<?php echo $file_name.'_crop.'.$ext ?>"
                                            width="100" /></td>
                                    <td><?php echo $row['title'] ?></td>
                                    <td><?php echo $row['sub_title'] ?></td>
                                  

                                    <td>
                                        <a href="<?php echo $addURL_UG; ?>?edit&id=<?php echo $row['id'] ?>" name="edit"
                                            class="" title="Click to edit this row"><i class="icon-pencil"></i></a>
                                        <a class="" href="<?php echo $delete_UG; ?>?id=<?php echo $row['id']; ?>"
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
            <!--undergraduate-->
            </br>

            <!--postgraduate-->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h6 class="panel-title"><i class="icon-stats"></i> <?php echo $pageName_PG; ?></h6>
                </div>
                <div class="panel-body">

                    <a href="<?php echo $addURL_PG; ?>" class="label label-primary pull-right">Add
                        <?php echo $pageName_PG; ?>
                    </a>

                    <br /><br />
                    <div class="datatable-selectable-data-postgraduate">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Sub Title</th>
                               
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
							$x = (10*$pageNo)-9;
							
							while($row = $admin->fetch($results_PG)){
								$file_name = str_replace('', '-', strtolower( pathinfo($row['postgraduate_image'], PATHINFO_FILENAME)));
								$ext = pathinfo($row['postgraduate_image'], PATHINFO_EXTENSION);
?>
                                <tr>
                                    <td><?php echo $x++; ?></td>
                                    <td><img src="../img/Postgraduate/<?php echo $file_name.'_crop.'.$ext ?>"
                                            width="100" /></td>
                                    <td><?php echo $row['title'] ?></td>
                                    <td><?php echo $row['sub_title'] ?></td>
                                

                                    <td>
                                        <a href="<?php echo $addURL_PG; ?>?edit&id=<?php echo $row['id'] ?>" name="edit"
                                            class="" title="Click to edit this row"><i class="icon-pencil"></i></a>
                                        <a class="" href="<?php echo $deleteURL_PG; ?>?id=<?php echo $row['id']; ?>"
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
            <!--postgraduate-->



            <!--others-->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h6 class="panel-title"><i class="icon-stats"></i> <?php echo $pageName_OI; ?></h6>
                </div>
                <div class="panel-body">

                    <a href="<?php echo $addURL_OI; ?>" class="label label-primary pull-right">Add
                        <?php echo $pageName_OI; ?>
                    </a>

                    <br /><br />
                    <div class="datatable-selectable-data-postgraduate">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Sub Title</th>
                               
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
							$x = (10*$pageNo)-9;
							
							while($row = $admin->fetch($results_OI)){
								$file_name = str_replace('', '-', strtolower( pathinfo($row['other_image'], PATHINFO_FILENAME)));
								$ext = pathinfo($row['other_image'], PATHINFO_EXTENSION);
?>
                                <tr>
                                    <td><?php echo $x++; ?></td>
                                    <td><img src="../img/Other/<?php echo $file_name.'_crop.'.$ext ?>"
                                            width="100" /></td>
                                    <td><?php echo $row['title'] ?></td>
                                    <td><?php echo $row['sub_title'] ?></td>
                                

                                    <td>
                                        <a href="<?php echo $addURL_OI; ?>?edit&id=<?php echo $row['id'] ?>" name="edit"
                                            class="" title="Click to edit this row"><i class="icon-pencil"></i></a>
                                        <a class="" href="<?php echo $deleteURL_OI; ?>?id=<?php echo $row['id']; ?>"
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
            <!--Others-->


            </br>
            <!--infrastructure-->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h6 class="panel-title"><i class="icon-stats"></i> <?php echo $pageName_INFA; ?></h6>
                </div>
                <div class="panel-body">

                    <a href="<?php echo $addURL_INFA; ?>" class="label label-primary pull-right">Add
                        <?php echo $pageName_INFA; ?>
                    </a>

                    <br /><br />
                    <div class="datatable-selectable-data-infrastructure">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Sub Title</th>
                                  
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
							$x = (10*$pageNo)-9;
							
							while($row = $admin->fetch($results_INFA)){
								$file_name = str_replace('', '-', strtolower( pathinfo($row['Infra_image'], PATHINFO_FILENAME)));
								$ext = pathinfo($row['Infra_image'], PATHINFO_EXTENSION);
?>
                                <tr>
                                    <td><?php echo $x++; ?></td>
                                    <td><img src="../img/Infrastructure/<?php echo $file_name.'_crop.'.$ext ?>" width="100" />
                                    </td>
                                    <td><?php echo $row['title'] ?></td>
                                    <td><?php echo $row['sub_title'] ?></td>
                             

                                    <td>
                                        <a href="<?php echo $addURL_INFA; ?>?edit&id=<?php echo $row['id'] ?>" name="edit"
                                            class="" title="Click to edit this row"><i class="icon-pencil"></i></a>
                                        <a class="" href="<?php echo $deleteURL_INFA; ?>?id=<?php echo $row['id']; ?>"
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
            <!--infrastructure-->
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
    <script type="text/javascript" src="js/editor/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="js/editor/ckfinder/ckfinder.js"></script>
    <link href="css/crop-image/cropper.min.css" rel="stylesheet">
    <script src="js/crop-image/cropper.min.js"></script>
    <script src="js/crop-image/image-crop-app.js"></script>
    <script type="text/javascript">
    $('#img').change(function() {
        // loadImageInModal(this);
        loadImagePreview(this, (800 / 533));
    });
    $("#formWelcome").submit(function(e) {
        var messageLength = CKEDITOR.instances['description'].getData().replace(/<[^>]*>/gi, '').length;
        if (!messageLength) {
            alert('Please enter Description');
            e.preventDefault();
        }
    });
    $("#formdetailing").submit(function(e) {
        var messageLength = CKEDITOR.instances['detailing'].getData().replace(/<[^>]*>/gi, '').length;
        if (!messageLength) {
            alert('Please enter Description');
            e.preventDefault();
        }
    });
   
    var editor = CKEDITOR.replace('description', {
        height: 200,
        filebrowserImageBrowseUrl: 'js/editor/ckfinder/ckfinder.html?type=Images',
        filebrowserImageUploadUrl: 'js/editor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
        toolbarGroups: [

            {
                "name": "document",
                "groups": ["mode"]
            },
            {
                "name": "clipboard",
                "groups": ["undo"]
            },
            {
                "name": "basicstyles",
                "groups": ["basicstyles"]
            },
            {
                "name": "links",
                "groups": ["links"]
            },
            {
                "name": "paragraph",
                "groups": ["list"]
            },
            {
                "name": "insert",
                "groups": ["insert"]
            },
            {
                "name": "insert",
                "groups": ["insert"]
            },
            {
                "name": "styles",
                "groups": ["styles"]
            },
            {
                "name": "paragraph",
                "groups": ["align"]
            },
            {
                "name": "about",
                "groups": ["about"]
            },
            {
                "name": "colors",
                "tems": ['TextColor', 'BGColor']
            },
        ],
        removeButtons: 'Iframe,Flash,Strike,Smiley,Subscript,Superscript,Anchor,Specialchar'
    });

    CKFinder.setupCKEditor(editor, '../');
    </script>
    <script>
    $(document).ready(function() {
        $('.datatable-selectable-data table').dataTable({
            "order": [
                [0, 'asc']
            ],
        });
    });

    $(document).ready(function() {
        $('.datatable-selectable-data-undergraduate table').dataTable({
            "order": [
                [0, 'asc']
            ],
        });
    });


    $(document).ready(function() {
        $('.datatable-selectable-data-postgraduate table').dataTable({
            "order": [
                [0, 'asc']
            ],
        });
    });


    $(document).ready(function() {
        $('.datatable-selectable-data-infrastructure table').dataTable({
            "order": [
                [0, 'asc']
            ],
        });
    });
    </script>
</body>

</html>