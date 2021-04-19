<?php
	include_once 'include/config.php';
	include_once 'include/admin-functions.php';
	$admin = new AdminFunctions();
	$pageName = "Contact Us Content";
	$pageURL = 'contact_us.php';
	$tableName = 'contactus';

	if(!$loggedInUserDetailsArr = $admin->sessionExists()){
		header("location: admin-login.php");
		exit();
	}

	
	$csrf = new csrf();
	$token_id = $csrf->get_token_id();
	$token_value = $csrf->get_token($token_id);

	if(isset($_POST['update'])) {
		if($csrf->check_valid('post')) {
			$id = trim($admin->escape_string($admin->strip_all($_POST['id'])));
			$result = $admin->updateContactUsPage($_POST);
			header("location:".$pageURL."?updatesuccess");
			exit;
		}
	}
	$sql = "select * from ".PREFIX.$tableName;
	$res = $admin->query($sql);
	$data = $admin->fetch($res);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo TITLE ?></title><link rel="shortcut icon" href="favicon.ico" type="image/x-icon"><link rel="icon" href="../img/logo.ico" type="image/x-icon">
	<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="css/londinium-theme.min.css" rel="stylesheet" type="text/css">
	<link href="css/styles.min.css" rel="stylesheet" type="text/css">
	<link href="css/icons.min.css" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
	
	<link href="css/font-awesome.min.css" rel="stylesheet">
	<link href="css/nanoscroller.css" rel="stylesheet">
	<link href="css/emoji.css" rel="stylesheet">
	<link href="css/cover.css" rel="stylesheet">
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
	<script type="text/javascript" src="js/additional-methods.js"></script>
	<script src="//cdn.ckeditor.com/4.5.5/full/ckeditor.js"></script>
	<link href="css/bootstrap-datetimepicker.css" rel="stylesheet">
	<script src="js/moment.min.js"></script>
	<script src="js/bootstrap-datetimepicker.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$("#form").validate({
				//ignore: [],
				//debug: false,
				rules: {
					
					image_name: {
						extension: 'jpg|png|jpeg'
					},
					title:{
						required:true
					},
					
				},
				messages: {
					/* video_name: {
						extension: 'Upload image with webm, mp4 or ogv extension'
					}, */
					
				}
			});
		});
	</script>
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
			<div class="page-ttle hidden-xs" style="float:left;">

					<?php echo 'Edit '.$pageName; ?>

			</div>
			<ul class="breadcrumb">
				<li><a href="banner-master.php">Home</a></li>
				<li><a href="<?php echo $parentPageURL; ?>"><?php echo $pageName; ?></a></li>
				<li class="active">

					<?php echo 'Edit '.$pageName; ?>

				</li>
			</ul>
		</div>

		
<?php
		if(isset($_GET['registersuccess'])){ ?>
			<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<i class="icon-checkmark3"></i> <?php echo $pageName; ?> successfully added.
			</div><br/>
<?php	} ?>
	
<?php
		if(isset($_GET['registerfail'])){ ?>
			<div class="alert alert-danger alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<i class="icon-close"></i> <strong><?php echo $pageName; ?> not added.</strong> <?php echo $admin->escape_string($admin->strip_all($_GET['msg'])); ?>.
			</div><br/>
<?php	} ?>

<?php
		if(isset($_GET['updatesuccess'])){ ?>
			<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<i class="icon-checkmark3"></i> <?php echo $pageName; ?> successfully updated.
			</div><br/>
<?php	} ?>
	
<?php
		if(isset($_GET['updatefail'])){ ?>
			<div class="alert alert-danger alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<i class="icon-close"></i> <strong><?php echo $pageName; ?> not updated.</strong> <?php echo $admin->escape_string($admin->strip_all($_GET['msg'])); ?>.
			</div><br/>
<?php	} ?>
			<form role="form" action="" method="post" id="form" enctype="multipart/form-data">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h6 class="panel-title"><i class="icon-library"></i> Contact Us Content</h6>
					</div>
					<div class="panel-body">
						<div class="form-group">
						<div class="row">
								
								<div class="col-sm-3">
									<label>Phone <span style="color:red">*</span> </label>
									<input  type="text" class="form-control" required placeholder="Phone" name="phone" value="<?php if(!empty($data['phone'])){ echo $data['phone']; }?>" />
								</div>
								<div class="col-sm-3">
									<label>Email <span style="color:red">*</span> </label>
									<input  type="text" class="form-control" required  name="email" placeholder="Email" value="<?php if(!empty($data['email'])){ echo $data['email']; }?>" />
								</div>
								<div class="col-sm-6">
									<label>Map Link <span style="color:red">*</span> </label>
									<input class="form-control" required placeholder="Map Link"  name="map_link" value="<?php if(!empty($data['map_link'])){ echo $data['map_link']; }?>" />
								</div>
							</div><br>
							<div class="row">
								<div class="col-sm-12">
									<label>Registered Office <span style="color:red">*</span> </label>
									<textarea col="5" rows="4"  class="form-control" required  name="registered_office" id="" /><?php if(!empty($data['registered_office'])){ echo $data['registered_office']; }?></textarea>
								</div>
								
							</div><br>
							<div class="row">
								<div class="col-sm-12">
									<label>Workshop <span style="color:red">*</span> </label>
									<textarea col="5" rows="4"  class="form-control" required  name="workshop" id="" /><?php if(!empty($data['workshop'])){ echo $data['workshop']; }?></textarea>
								</div>
								
							</div><br>
							
							
							
							
					</div>
				
				</div>
				
				<div class="form-actions text-right">
				<input type="hidden" name="<?php echo $token_id; ?>" value="<?php echo $token_value; ?>" />

					<input type="hidden" class="form-control" name="id" id="" required="required" value="<?php echo $data['id']; ?>"/>
					<button type="submit" name="update" id="update" class="btn btn-warning"><i class="icon-pencil"></i>Update <?php echo $pageName; ?></button>

				</div>
			</form>

<?php 	include "include/footer.php"; ?>
    
		</div>
	</div>

	<link href="css/crop-image/cropper.min.css" rel="stylesheet">
	<script src="js/crop-image/cropper.min.js"></script>
	<script src="js/crop-image/image-crop-app.js"></script>
	<script>
        //CKEDITOR.replace( 'text1' );
        $("form").submit( function(e) {
            var messageLength = CKEDITOR.instances['editor'].getData().replace(/<[^>]*>/gi, '').length;
            if( !messageLength ) {
                alert( 'Please enter a message' );
                e.preventDefault();
            }
        });
	$(document).ready(function(){
		$("#add-a-clone4").on("click", function(){
			// part 1: get the target
			var target = $("#clone-me4");
			// part 2: copy the target
			var newNode = target.clone(); // clone a node
			newNode.attr("id",""); // remove id from the cloned node
			newNode.find("input").val(""); // clear all fields
			newNode.find("select").val(""); // clear all fields
			// part 3: add a remove button
			var closeBtnNode = $('<div class="col-sm-1"><label>Remove</label><button type="button" class="btn btn-default form-control icon-close remove-row" ></button></div>');
			newNode.find(".remove-row-wrapper").html(closeBtnNode);
			// part 4: append the copy
			$("#clone-house4").append(newNode); // append the node to dom
			$(".remove-row").on("click", removeRow);
		});

		$(".remove-row").on("click", removeRow);

		function removeRow(){
			$(this).closest(".clone-row").remove();
		}
	});
	function validateInputArr(eleArr, errorMsg){
	var errArr = [];
	eleArr.each(function(index, ele){
	var eleObj = jQuery(ele);
	var eleVal = eleObj.val();
	if(eleVal){
	eleObj.closest("div").find('div.error').remove();
	} else {
	eleObj.closest("div").find('div.error').remove();
	eleObj.closest("div").append('<div class="error" style="color:red;">' + errorMsg + '</div>');
	errArr.push(index);
	}
	});
	return errArr;
	}

	function validateNumberArr(eleArr, errorMsg){
	var errArr = [];
	eleArr.each(function(index, ele){
	var eleObj = jQuery(ele);
	var eleVal = eleObj.val();
	if(eleVal==""){
		eleObj.closest("div").find('div.error').remove();
		eleObj.closest("div").append('<div class="error" style="color:red;">' + errorMsg + '</div>');
		errArr.push(index);	
	} else if(isNaN(eleVal))  {
		eleObj.closest("div").find('div.error').remove();
		eleObj.closest("div").append('<div class="error" style="color:red;">Please enter display order in number.</div>');
		errArr.push(index); 		
	} else {
		eleObj.closest("div").find('div.error').remove();
	}
	
	
	
	
	
	});
	return errArr;
	}
	$('#update').on('click', function(event) {
		var formData = $("#form").valid();
		var text1=$("input[name='video_link[]']");
		var display_order=$("input[name='display_order[]']");
		
		var text1Validate = validateInputArr(text1,"Please enter Video Link.");
		var displayOrderValidate = validateNumberArr(display_order,"Please enter Display Order.");
		if(formData  && text1Validate.length==0 && displayOrderValidate.length==0 ){
			 $("#form").submit();
		}else{
			return false;
		}
	});

	
    </script>
	<script>
	$(document).ready(function() {
		 $('input[type="file"]').change(function(){
			// loadImageInModal(this);
			loadImagePreview(this, (441 / 313));
		}); 
	});
	</script>
	<script type="text/javascript" src="js/editor/ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="js/editor/ckfinder/ckfinder.js"></script>
	<script type="text/javascript">
		$("form").submit( function(e) {
           var registered_office = CKEDITOR.instances['registered_office'].getData().replace(/<[^>]*>/gi, '').length;
           var workshop = CKEDITOR.instances['workshop'].getData().replace(/<[^>]*>/gi, '').length;
           if( !registered_office ) {
               alert( 'Please enter a registered office' );
               e.preventDefault();
           } 
		   if( !workshop ) {
               alert( 'Please enter a workshop' );
               e.preventDefault();
           }
       });
		var editor = CKEDITOR.replace( 'registered_office', {
			height: 100,
			filebrowserImageBrowseUrl : 'js/editor/ckfinder/ckfinder.html?type=Images',
			filebrowserImageUploadUrl : 'js/editor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
			toolbarGroups: [
				
				{"name":"document","groups":["mode"]},
				{"name":"clipboard","groups":["undo"]},
				{"name":"basicstyles","groups":["basicstyles"]},
				{"name":"links","groups":["links"]},
				{"name":"paragraph","groups":["list"]},
				{"name":"insert","groups":["insert"]},
				{"name":"insert","groups":["insert"]},
				{"name":"styles","groups":["styles"]},
				{"name":"paragraph","groups":["align"]},
				{"name":"about","groups":["about"]},
				{"name":"colors","tems": [ 'TextColor', 'BGColor' ] },
			],
			removeButtons: 'Iframe,Flash,Strike,Smiley,Subscript,Superscript,Anchor,Specialchar'
		} );
		var editor = CKEDITOR.replace( 'workshop', {
			height: 100,
			filebrowserImageBrowseUrl : 'js/editor/ckfinder/ckfinder.html?type=Images',
			filebrowserImageUploadUrl : 'js/editor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
			toolbarGroups: [
				
				{"name":"document","groups":["mode"]},
				{"name":"clipboard","groups":["undo"]},
				{"name":"basicstyles","groups":["basicstyles"]},
				{"name":"links","groups":["links"]},
				{"name":"paragraph","groups":["list"]},
				{"name":"insert","groups":["insert"]},
				{"name":"insert","groups":["insert"]},
				{"name":"styles","groups":["styles"]},
				{"name":"paragraph","groups":["align"]},
				{"name":"about","groups":["about"]},
				{"name":"colors","tems": [ 'TextColor', 'BGColor' ] },
			],
			removeButtons: 'Iframe,Flash,Strike,Smiley,Subscript,Superscript,Anchor,Specialchar'
		} );
	
		
		
		CKFinder.setupCKEditor( editor, '../' );
	</script>
</body>
</html>