<?php
	include_once 'include/config.php';
	include_once 'include/admin-functions.php';
	$admin = new AdminFunctions();
	// $pageName = "Product Types"; 
	// $pageURL = 'product-types-delete.php';
	$parentPageURL = 'welcome.php';

	if(!$loggedInUserDetailsArr = $admin->sessionExists()){
		header("location: admin-login.php");
		exit();
	}
	if(isset($_GET['id'])){
		$id = $admin->escape_string($admin->strip_all($_GET['id']));
		if(!isset($id) || empty($id)){
			header("location:".$parentPageURL."?deletefail");
			exit;
		}

		//delete from database
		$result = $admin->deletePostgraduateCourses($id);

		/**
		 * Delete Item From underG  or PostGraduate same to in 
		 */
		header("location:".$parentPageURL."?deletesuccess");
	}
?>