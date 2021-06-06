<?php

	// include_once 'include/config.php';
	// include_once 'include/admin-functions.php';
	// $admin = new AdminFunctions();
	include('database.php');
	include('SaveImage.class.php');
	include('include/classes/CSRF.class.php');
	error_reporting(0);
	/*
	 * AdminFunctions
	 * v1 - updated loginSession(), logoutSession(), adminLogin()
	 */
	class AdminFunctions extends Database {
		private $userType = 'admin';

		// === LOGIN BEGINS ===
		function loginSession($userId, $userFirstName, $userLastName, $userType,$role) {
			/* DEPRECATED $_SESSION[SITE_NAME] = array(
				$this->userType."UserId" => $userId,
				$this->userType."UserFirstName" => $userFirstName,
				$this->userType."UserLastName" => $userLastName,
				$this->userType."UserType" => $this->userType
			); DEPRECATED */
			$_SESSION[SITE_NAME][$this->userType."UserId"] = $userId;
			$_SESSION[SITE_NAME][$this->userType."UserFirstName"] = $userFirstName;
			$_SESSION[SITE_NAME][$this->userType."UserLastName"] = $userLastName;
			$_SESSION[SITE_NAME][$this->userType."UserType"] = $this->userType;
			$_SESSION[SITE_NAME][$this->userType."role"] = $role;
			/*switch($userType){
				case:'admin'{
					break;
				}
				case:'supplier'{
					break;
				}
				case:'warehouse'{
					break;
				}
				
			}*/
		}
		
		
		function logoutSession() {
			if(isset($_SESSION[SITE_NAME])){
				if(isset($_SESSION[SITE_NAME][$this->userType."UserId"])){
					unset($_SESSION[SITE_NAME][$this->userType."UserId"]);
				}
				if(isset($_SESSION[SITE_NAME][$this->userType."UserFirstName"])){
					unset($_SESSION[SITE_NAME][$this->userType."UserFirstName"]);
				}
				if(isset($_SESSION[SITE_NAME][$this->userType."UserLastName"])){
					unset($_SESSION[SITE_NAME][$this->userType."UserLastName"]);
				}
				if(isset($_SESSION[SITE_NAME][$this->userType."UserType"])){
					unset($_SESSION[SITE_NAME][$this->userType."UserType"]);
				}
				return true;
			} else {
				return false;
			}
		}
		function adminLogin($data, $successURL, $failURL = "admin-login.php?failed") {
			$username = $this->escape_string($this->strip_all($data['username']));
			$password = $this->escape_string($this->strip_all($data['password']));
			$query = "select * from ".PREFIX."admin where username='".$username."'";
			$result = $this->query($query);

			if($this->num_rows($result) == 1) { // only one unique user should be present in the system
				$row = $this->fetch($result);
				if(password_verify($password, $row['password'])) {
					$this->loginSession($row['id'], $row['fname'], $row['lname'], $this->userType,$row['role']);
					$this->close_connection();
					header("location: ".$successURL);
					exit;
				} else {
					$this->close_connection();
					header("location: ".$failURL);
					exit;
				}
			} else {
				$this->close_connection();
				header("location: ".$failURL);
				exit;
			}
		}
		/* function sessionExists(){
			if( isset($_SESSION[SITE_NAME]) && 
				isset($_SESSION[SITE_NAME][$this->userType.'UserId']) && 
				isset($_SESSION[SITE_NAME][$this->userType.'UserType']) && 
				!empty($_SESSION[SITE_NAME][$this->userType.'UserId']) &&
				$_SESSION[SITE_NAME][$this->userType.'UserType']==$this->userType){

				return $loggedInUserDetailsArr = $this->getLoggedInUserDetails();
				// return true; // DEPRECATED
			} else {
				return false;
			}
		} */
		function sessionExists(){
			if($this->isUserLoggedIn()){
				return $loggedInUserDetailsArr = $this->getLoggedInUserDetails();
				// return true; // DEPRECATED
			} else {
				return false;
			}
		}
		function isUserLoggedIn(){
			if( isset($_SESSION[SITE_NAME]) && 
				isset($_SESSION[SITE_NAME][$this->userType.'UserId']) && 
				isset($_SESSION[SITE_NAME][$this->userType.'UserType']) && 
				!empty($_SESSION[SITE_NAME][$this->userType.'UserId']) &&
				$_SESSION[SITE_NAME][$this->userType.'UserType']==$this->userType){
				return true;
			} else {
				return false;
			}
		}
		function getSystemUserType() {
			return $this->userType;
		}
		function getLoggedInUserDetails(){
			$loggedInID = $this->escape_string($this->strip_all($_SESSION[SITE_NAME][$this->userType.'UserId']));
			$loggedInUserDetailsArr = $this->getUniqueUserById($loggedInID);
			return $loggedInUserDetailsArr;
		}
		function getUniqueUserById($userId) {
			$userId = $this->escape_string($this->strip_all($userId));
			$query = "select * from ".PREFIX."admin where id='".$userId."'";
			$sql = $this->query($query);
			return $this->fetch($sql);
		}
		// === LOGIN ENDS ====

		// == EXTRA FUNCTIONS STARTS ==
		function getValidatedPermalink($permalink){ // v2
			$permalink = trim($permalink, '()');
			$replace_keywords = array("-:-", "-:", ":-", " : ", " :", ": ", ":",
				"-@-", "-@", "@-", " @ ", " @", "@ ", "@", 
				"-.-", "-.", ".-", " . ", " .", ". ", ".", 
				"-\\-", "-\\", "\\-", " \\ ", " \\", "\\ ", "\\",
				"-/-", "-/", "/-", " / ", " /", "/ ", "/", 
				"-&-", "-&", "&-", " & ", " &", "& ", "&", 
				"-,-", "-,", ",-", " , ", " ,", ", ", ",", 
				" ", "\r", "\n", 
				"---", "--", " - ", " -", "- ",
				"-#-", "-#", "#-", " # ", " #", "# ", "#",
				"-$-", "-$", "$-", " $ ", " $", "$ ", "$",
				"-%-", "-%", "%-", " % ", " %", "% ", "%",
				"-^-", "-^", "^-", " ^ ", " ^", "^ ", "^",
				"-*-", "-*", "*-", " * ", " *", "* ", "*",
				"-(-", "-(", "(-", " ( ", " (", "( ", "(",
				"-)-", "-)", ")-", " ) ", " )", ") ", ")",
				"-;-", "-;", ";-", " ; ", " ;", "; ", ";",
				"-'-", "-'", "'-", " ' ", " '", "' ", "'",
				'-"-', '-"', '"-', ' " ', ' "', '" ', '"',
				"-?-", "-?", "?-", " ? ", " ?", "? ", "?",
				"-+-", "-+", "+-", " + ", " +", "+ ", "+",
				"-!-", "-!", "!-", " ! ", " !", "! ", "!");
			$escapedPermalink = str_replace($replace_keywords, '-', $permalink); 
			return strtolower($escapedPermalink);
		}
		function getUniquePermalink($permalink,$tableName,$main_menu,$newPermalink='',$num=1) {
			if($newPermalink=='') {
				$checkPerma = $permalink;
			} else {
				$checkPerma = $newPermalink;
			}
			$sql = $this->query("select * from ".PREFIX.$tableName." where permalink='$checkPerma' and main_menu='$main_menu'");
			if($this->num_rows($sql)>0) {
				$count = $num+1;
				$newPermalink = $permalink.$count;
				return $this->getUniquePermalink($permalink,$tableName,$main_menu,$newPermalink,$count);
			} else {
				return $checkPerma;
			}
		}
		function getActiveLabel($isActive){
			if($isActive){
				return 'Yes';
			} else {
				return 'No';
			}
		}
		function getImageUrl($imageFor, $fileName, $imageSuffix){
			$image_name = strtolower(pathinfo($fileName, PATHINFO_FILENAME));
			$image_ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
			switch($imageFor){
				case "headeraboutusimage" :
				case "headersanstha":
					$fileDir = "../img/headers/";
				case "ugc-sc" : 
					$fileDir = "../img/StudentCo-Curricular/undergraduate/";
				case "pgc-sc" : 
					$fileDir = "../img/StudentCo-Curricular/postgraduate/";
				case "ugc-sa" : 
					$fileDir = "../img/StudentAcademic/undergraduate/";
				case "pgc-sa" : 
					$fileDir = "../img/StudentAcademic/postgraduate/";
				case "pdf" :
					$fileDir = "../img/pdf/";
					break;
				case "department":
					$fileDir = "../img/Department/";
					break;
				case "banner":
					$fileDir = "../img/banner/";
					break;
				case "career":
					$fileDir = "../images/career/";
					break;
				case "products":
					$fileDir = "../img/products/";
					break;
				case "category":
					$fileDir = "../img/category/";
					break;
				case "sub_category":
					$fileDir = "../img/sub_category/";
					break;
				case "our-philosophy":
					$fileDir = "../images/our-philosophy/";
					break;
				case "team-testimonial":
					$fileDir = "../images/team-testimonial/";
					break;
				case "news":
					$fileDir = "../images/news/";
					break;
				case "csr-objectives":
					$fileDir = "../images/csr-objectives/";
					break;
				case "team":
					$fileDir = "../images/team/";
					break;
				case "vendor-guideline":
					$fileDir = "../images/vendor-guideline/";
					break;
				case "service":
					$fileDir = "../images/service/";
					break;
				case "our_presence":
					$fileDir = "../images/our_presence/";
					break;
				default:
					return false;
					break;
			}
			$imageUrl = $fileDir.$image_name."_".$imageSuffix.".".$image_ext;
			if(file_exists($imageUrl)){
				return $imageUrl;
				// $imageUrl = BASE_URL.'/'.$imageUrl;
			} else {
				return false;
				// $imageUrl = BASE_URL."/images/no_img.jpg";
			}
		}
		function unlinkImage($imageFor, $fileName, $imageSuffix){
			$imagePath = $this->getImageUrl($imageFor, $fileName, $imageSuffix);
			$status = false;
			if($imagePath!==false){
				$status = unlink($imagePath);
			}
			return $status;
		}
		function checkUserPermissions($permission,$loggedInUserDetailsArr) {
			$userPermissionsArray = explode(',',$loggedInUserDetailsArr['permissions']);
			if(!in_array($permission,$userPermissionsArray) and $loggedInUserDetailsArr['user_role']!='super') {
				header("location: dashboard.php");
				exit;
			}
		}
		
		// === BANNER STARTS ===
		function getAllBanners() {
			$query = "select * from ".PREFIX."banner_master";
			$sql = $this->query($query);
			return $sql;
		}


		//
		function getAllBoxesTabs() {
			$query = "select * from ".PREFIX."boxed_tabs";
			// $query = "select * from ".PREFIX."selected_tabs";
			$sql = $this->query($query);
			return $sql;
		}


		function removeSelectedTabs() {
		
			$course_id = $_SESSION["course_id"];
			$arr = [];
			$arr1 = [];
			$arrCategory = [];
			$arrCheckingCategory = [];
			
			//get all tabs
			$query1 = "select * from ".PREFIX."boxed_tabs";
			$tabs = $this->query($query1);
			
			//selected tabs
			$query2 = "select * from ".PREFIX."selected_tabs";
			$removeSelectedtabs = $this->query($query2);

			//active tabs
			$query3 = "select * from ".PREFIX."category where coruses_id = '$course_id' " ;
			$removeActivetabs = $this->query($query3);
			// echo $query3;exit;

			while($row = $this->fetch($removeActivetabs))
			{
					array_push($arrCheckingCategory,$row['category']); //BMS
				
			}
			// echo $query3;exit;
			
			//looping for getting all tab id 
			while($row = $this->fetch($tabs))
			{
				if($row['tabs']){
					array_push($arr,$row['department_id']);
				}
				
				
			}
			
			if($removeSelectedtabs->num_rows <= 0){
				
				return   $arr;
			}else{
				
				//combination of selected tabs
				while($row = $this->fetch($removeSelectedtabs))
				{
					//make associative array
					//echo $removeSelectedtabs[$row['selected_tabs']];
					if($row['selected_tabs']){
						if(strtolower($arrCheckingCategory[0]) == strtolower($row['selected_category'])){
							array_push($arr1,$row['selected_tabs']);
							array_push($arrCategory,$row['selected_category']);
						}
					
					}
	
				}

				$GLOBALS['arrCategory'] = $arrCategory;
				// $_SESSION["course_name"] = $arrCheckingCategory[0];

				$removedSelectedElementArr  = array_diff($arr,$arr1);
				//print_r( $removedSelectedElementArr);exit;
				return $removedSelectedElementArr;
			}
		
		}

	
		//Department Data functions starts

        function addDepartmentData($data, $file) {
			//print_r($data);exit();
			// if(!empty($data['category_name'])){
			// 	$category = $this->escape_string($this->strip_all($data['category_name']));
			// }else{
			// 	$category = $this->escape_string($this->strip_all($data['category']));
			// }
			$sub_courses_id =  $_SESSION["sub_courses_id"];
			//  $sub_courses_name = $_SESSION["sub_courses_name"]  ;
		
			$course_id = $_SESSION["course_id"] ;
		//	$courses_name  = $_SESSION["course_name"] ;


			$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a>";
			$text = $this->escape_string($this->strip_selected($data['text'],$allowTags));


			$image_text = $this->escape_string($this->strip_all($data['image_text']));
			//$pdf = $this->escape_string($this->strip_all($data['pdf']));
			$department_id = $this->escape_string($this->strip_all($data['tabs']));
            $date = date("Y-m-d H:i:s");

			$SaveImage = new SaveImage();
		

			$imgDir_pdf = '../img/pdf/';

			if(isset($file['pdf']['name']) && !empty($file['pdf']['name'])){
				$imageName_pdf = str_replace( " ", "-", $file['pdf']['name'] );
				$file_name_pdf = strtolower( pathinfo($imageName_pdf, PATHINFO_FILENAME));
				$file_name_pdf = $this->getValidatedPermalink($file_name_pdf);
				//$image_name_pdf = $SaveImage->uploadFileFromForm($file['pdf'], 1366, $cropData_pdf, $imgDir_pdf, $file_name_pdf.'-'.time().'-1');
				$image_name_pdf = $SaveImage->uploadFileFromForm($file['pdf'],$imgDir_pdf,$file_name_pdf);

			} else {
				$image_name_pdf = '';
			}
			//$category = $_SESSION["course_id"] ;
		
			$sqlTitle1 = "SELECT COUNT(coruses_id) as count1 FROM `dc_subtype_courses_list` where coruses_id= '$course_id ' ";
			//echo $sqlTitle1;exit();
			$resultTitle1 = $this->query($sqlTitle1);
			$rowcount = $this->fetch($resultTitle1);

			$count = $rowcount['count1'];
			
			$query = "insert into ".PREFIX."departments (department_id,  text, pdf,category_type,courses_subtype_id, created_at) values($department_id, '$text','$image_name_pdf','$course_id','$sub_courses_id', '$date') ";
			//echo $query;exit();	
			if($count <= 0){
				$query2 = "insert into ".PREFIX."selected_tabs (selected_tabs, selected_category) values('$department_id','$course_id') ";

			}else{
				$query2 = "insert into ".PREFIX."courses_selected_tabs (selected_tabs, selected_category,sub_courses_id) values('$department_id','$course_id','$sub_courses_id') ";

			}

			 //echo $query2;exit();
			
			$this->query($query2);
			
			return $this->query($query);
			
		}

		function getUniqueDepartmentDataById($id) {
			$id = $id;
			$query = "SELECT dp.*, bt.tabs as department_name FROM ".PREFIX."departments dp JOIN dc_boxed_tabs bt ON dp.department_id = bt.id WHERE dp.id = ".$id."";
			//echo $query;exit();
			$sql = $this->query($query);
			return $this->fetch($sql);
		}

		function updateDepartmentData($data, $file) {
			// print_r($data);
			// print_r($file);exit();
		
			$id = $this->escape_string($this->strip_all($data['id']));;
        	$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a>";
			$text = $this->escape_string($this->strip_selected($data['text'],$allowTags));
			$image_text = $this->escape_string($this->strip_all($data['image_text']));
		//	$category = $this->escape_string($this->strip_all($data['category']));
			$department_id = $this->escape_string($this->strip_all($data['tabs']));
            $date = date("Y-m-d H:i:s");

			$SaveImage = new SaveImage();
			
		
		
			$imgDir_pdf = '../img/pdf/';

			if(isset($file['pdf']['name']) && !empty($file['pdf']['name'])){
				$imageName_pdf = str_replace( " ", "-", $file['pdf']['name'] );
				$file_name_pdf = strtolower( pathinfo($imageName_pdf, PATHINFO_FILENAME));
				$file_name_pdf = $this->getValidatedPermalink($file_name_pdf);
				$Detail = $this->getUniqueDepartmentDataById($id);
		
				$this->unlinkImage("", $Detail['pdf'], "large");
				$this->unlinkImage("", $Detail['pdf'], "crop");
				//$image_name_pdf = $SaveImage->uploadFileFromForm($file['pdf'], 1366, $cropData_pdf, $imgDir_pdf, $file_name_pdf.'-'.time().'-1');
				$image_name_pdf = $SaveImage->uploadFileFromForm($file['pdf'],$imgDir_pdf,$file_name_pdf);
				$this->query(( "update ".PREFIX."departments set image = '$image_name' ,text='$text', image_text ='$image_text', pdf='$image_name_pdf',updated_at='$date' where id = ".$id.""));


			} else {
				$image_name_pdf = '';
			}
            
			// echo $image_name;
			// echo $image_name_pdf;
			
			// exit();
			$category = $_SESSION["course_name"] ;
			$query = "update ".PREFIX."departments set image = '$image_name' ,text='$text', image_text ='$image_text', pdf='$image_name_pdf',updated_at='$date' where id = ".$id."";
			// echo $query;exit();
			return $this->query($query);
		}

		//deapartment image upload add

		function addDepartmentDataImages($data,$file){
		//	$category = $this->escape_string($this->strip_all($data['category']));
			// $dept_description = $this->escape_string($this->strip_all($data['dept_discp']));
			// $dept_title = $this->escape_string($this->strip_all($data['dept_title']));
			//$pdf = $this->escape_string($this->strip_all($data['pdf']));
			


			$sub_courses_id =  $_SESSION["sub_courses_id"];
			$course_id = $_SESSION["course_id"] ;
			$department_id = $this->escape_string($this->strip_all($data['tabs']));
            $date = date("Y-m-d H:i:s");
			$category = $_SESSION["course_name"] ;
			$SaveImage = new SaveImage();
			$imgDir = '../img/Department/';
			if(isset($file['image']['name']) && !empty($file['image']['name'])){
				$imageName = str_replace( " ", "-", $file['image']['name'] );
				$file_name = strtolower( pathinfo($imageName, PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$cropData = $this->strip_all($data['cropData1']);
				// echo $cropData;exit();
				$image_name = $SaveImage->uploadCroppedImageFileFromForm($file['image'], 1366, $cropData, $imgDir, $file_name.'-'.time().'-1');
			} else {
				$image_name = '';
			}

			
			$query = "insert into ".PREFIX."departments_images (category,courses_subtype_id ,tabs , image, created_at) values('$course_id' ,'$sub_courses_id','$department_id', '$image_name','$date') ";
			 //echo $query;exit();
			return $this->query($query);
		}

		function getUniqueDepartmentDataImagesById($id){
			$id = $this->escape_string($this->strip_all($id));
			
			$query = "select * from ".PREFIX."departments_images where id='$id'";
			//echo $query;exit();
			$sql = $this->query($query);
			return $this->fetch($sql);
		}

	
		function updateDepartmentDataImages($data,$file) {
		//	print_r($data);exit();
			$id = $this->escape_string($this->strip_all($data['id']));
			//$category = $this->escape_string($this->strip_all($data['category']));
			// $dept_description = $this->escape_string($this->strip_all($data['dept_discp']));
			// $dept_title = $this->escape_string($this->strip_all($data['dept_title']));
			$category = $_SESSION["course_name"] ;
			$SaveImage = new SaveImage();
			$imgDir = '../img/Department/';
			if(isset($file['image']['name']) && !empty($file['image']['name'])) {
				$imageName = str_replace( " ", "-", $file['image']['name'] );
				$file_name = strtolower( pathinfo($imageName, PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$Detail = $this->getUniqueBannerById($id);
				$cropData = $this->strip_all($data['cropData1']);
				$this->unlinkImage("", $Detail['image'], "large");
				$this->unlinkImage("", $Detail['image'], "crop");
				$image_name = $SaveImage->uploadCroppedImageFileFromForm($file['image'], 1366, $cropData, $imgDir, $file_name.'-'.time().'-1');
				$this->query("update ".PREFIX."departments_images set image ='$image_name'  where id='$id' ");
			}
			//$query = "update ".PREFIX."departments_images set dept_discp = '$dept_description',  dept_title = '$dept_title' where id='$id' ";
			return;
	
			//return $this->query($query);
		}

		function deleteDepartmentData($id) {
			$id = $this->escape_string($this->strip_all($id));
			$Detail = $this->getUniqueDepartmentDataById($id);
			$this->unlinkImage("department", $Detail['image'], "large");
			$this->unlinkImage("department", $Detail['image'], "crop");

			// $this->unlinkImage("pdf", $Detail['pdf'], "large");
			// $this->unlinkImage("pdf", $Detail['pdf'], "crop");
			$query = "delete from ".PREFIX."departments_images where id='$id'";
			$this->query($query);
			return true;
		}

		//carousel

		function addDepartmentCarosel($data,$file,$type){
			//	$category = $this->escape_string($this->strip_all($data['category']));
				// $dept_description = $this->escape_string($this->strip_all($data['dept_discp']));
				// $dept_title = $this->escape_string($this->strip_all($data['dept_title']));
				//$pdf = $this->escape_string($this->strip_all($data['pdf']));
				//$department_id = $this->escape_string($this->strip_all($data['tabs']));
				$date = date("Y-m-d H:i:s");
				$course_id = $_SESSION["course_id"] ;
				$category = $_SESSION["course_name"] ;
				$SaveImage = new SaveImage();
				$imgDir = '../img/Department/';
				if(isset($file['image']['name']) && !empty($file['image']['name'])){
					$imageName = str_replace( " ", "-", $file['image']['name'] );
					$file_name = strtolower( pathinfo($imageName, PATHINFO_FILENAME));
					$file_name = $this->getValidatedPermalink($file_name);
					$cropData = $this->strip_all($data['cropData1']);
					// echo $cropData;exit();
					$image_name = $SaveImage->uploadCroppedImageFileFromForm($file['image'], 1366, $cropData, $imgDir, $file_name.'-'.time().'-1');
				} else {
					$image_name = '';
				}
	
				
				$query = "insert into ".PREFIX."carousel_images (courses_category,coruses_id,category,image, created_at) values('$type','$course_id','$category' , '$image_name','$date') ";
				 //echo $query;exit();
				return $this->query($query);
			}
	
			function getUniqueDepartmentCaroselById($id){
				$id = $this->escape_string($this->strip_all($id));
				
				$query = "select * from ".PREFIX."carousel_images where id='$id'";
				//echo $query;exit();
				$sql = $this->query($query);
				return $this->fetch($sql);
			}
	
		
			function updateDepartmentCarosel($data,$file) {
			//	print_r($data);exit();
				$id = $this->escape_string($this->strip_all($data['id']));
				//$category = $this->escape_string($this->strip_all($data['category']));
				// $dept_description = $this->escape_string($this->strip_all($data['dept_discp']));
				// $dept_title = $this->escape_string($this->strip_all($data['dept_title']));
				 $category = $_SESSION["course_name"] ;
				$SaveImage = new SaveImage();
				$imgDir = '../img/Department/';
				if(isset($file['image']['name']) && !empty($file['image']['name'])) {
					$imageName = str_replace( " ", "-", $file['image']['name'] );
					$file_name = strtolower( pathinfo($imageName, PATHINFO_FILENAME));
					$file_name = $this->getValidatedPermalink($file_name);
					$Detail = $this->getUniqueBannerById($id);
					$cropData = $this->strip_all($data['cropData1']);
					$this->unlinkImage("", $Detail['image'], "large");
					$this->unlinkImage("", $Detail['image'], "crop");
					$image_name = $SaveImage->uploadCroppedImageFileFromForm($file['image'], 1366, $cropData, $imgDir, $file_name.'-'.time().'-1');
					$this->query("update ".PREFIX."carousel_images set image ='$image_name'  where id='$id' ");
				}
				//$query = "update ".PREFIX."departments_images set dept_discp = '$dept_description',  dept_title = '$dept_title' where id='$id' ";
				return;
		
				//return $this->query($query);
			}
	
			function deleteDepartmentCarosel($id) {
				$id = $this->escape_string($this->strip_all($id));
				$Detail = $this->getUniqueDepartmentDataById($id);
				$this->unlinkImage("department", $Detail['image'], "large");
				$this->unlinkImage("department", $Detail['image'], "crop");
	
				$this->unlinkImage("pdf", $Detail['pdf'], "large");
				$this->unlinkImage("pdf", $Detail['pdf'], "crop");
				$query = "delete from ".PREFIX."carousel_images where id='$id'";
				$this->query($query);
				return true;
			}
		//end of caorsel



		//sub courses type carsoel image
		
		function addDepartmentSubCoursesCarosel($data,$file){
			//	$category = $this->escape_string($this->strip_all($data['category']));
				// $dept_description = $this->escape_string($this->strip_all($data['dept_discp']));
				// $dept_title = $this->escape_string($this->strip_all($data['dept_title']));
				//$pdf = $this->escape_string($this->strip_all($data['pdf']));
				//$department_id = $this->escape_string($this->strip_all($data['tabs']));
				$date = date("Y-m-d H:i:s");
				$course_id = $_SESSION["course_id"] ;
				$category = $_SESSION["course_name"] ;
				$courses_subtype_id =  $_SESSION["sub_courses_id"] ;
				$sub_courses_name =  $_SESSION["sub_courses_name"] ;
				$SaveImage = new SaveImage();
				$imgDir = '../img/Department/subcoursestype/';
				if(isset($file['image']['name']) && !empty($file['image']['name'])){
					$imageName = str_replace( " ", "-", $file['image']['name'] );
					$file_name = strtolower( pathinfo($imageName, PATHINFO_FILENAME));
					$file_name = $this->getValidatedPermalink($file_name);
					$cropData = $this->strip_all($data['cropData1']);
					// echo $cropData;exit();
					$image_name = $SaveImage->uploadCroppedImageFileFromForm($file['image'], 1366, $cropData, $imgDir, $file_name.'-'.time().'-1');
				} else {
					$image_name = '';
				}
	
				
				$query = "insert into ".PREFIX."sub_coruses_carousel_images (coruses_id,courses_subtype_id,category,image, created_at) values('$course_id','$courses_subtype_id','$sub_courses_name' , '$image_name','$date') ";
				 //echo $query;exit();
				return $this->query($query);
			}
	
			function getUniqueDepartmentSubCoursesCaroselById($id){
				$id = $this->escape_string($this->strip_all($id));
				
				$query = "select * from ".PREFIX."sub_coruses_carousel_images where id='$id'";
				//echo $query;exit();
				$sql = $this->query($query);
				return $this->fetch($sql);
			}
	
		
			function updateDepartmentSubCoursesCarosel($data,$file) {
			//	print_r($data);exit();
				$id = $this->escape_string($this->strip_all($data['id']));
				//$category = $this->escape_string($this->strip_all($data['category']));
				// $dept_description = $this->escape_string($this->strip_all($data['dept_discp']));
				// $dept_title = $this->escape_string($this->strip_all($data['dept_title']));
				 $category = $_SESSION["course_name"] ;
				$SaveImage = new SaveImage();
				$imgDir = '../img/Department/subcoursestype/';
				if(isset($file['image']['name']) && !empty($file['image']['name'])) {
					$imageName = str_replace( " ", "-", $file['image']['name'] );
					$file_name = strtolower( pathinfo($imageName, PATHINFO_FILENAME));
					$file_name = $this->getValidatedPermalink($file_name);
					$Detail = $this->getUniqueBannerById($id);
					$cropData = $this->strip_all($data['cropData1']);
					$this->unlinkImage("", $Detail['image'], "large");
					$this->unlinkImage("", $Detail['image'], "crop");
					$image_name = $SaveImage->uploadCroppedImageFileFromForm($file['image'], 1366, $cropData, $imgDir, $file_name.'-'.time().'-1');
					$this->query("update ".PREFIX."sub_coruses_carousel_images set image ='$image_name'  where id='$id' ");
				}
				//$query = "update ".PREFIX."departments_images set dept_discp = '$dept_description',  dept_title = '$dept_title' where id='$id' ";
				return;
		
				//return $this->query($query);
			}
	
			function deleteDepartmentSubCoursesCarosel($id) {
				$id = $this->escape_string($this->strip_all($id));
				$Detail = $this->getUniqueDepartmentSubCoursesCaroselById($id);
				$this->unlinkImage("department", $Detail['image'], "large");
				$this->unlinkImage("department", $Detail['image'], "crop");
	
				$this->unlinkImage("pdf", $Detail['pdf'], "large");
				$this->unlinkImage("pdf", $Detail['pdf'], "crop");
				$query = "delete from ".PREFIX."sub_coruses_carousel_images where id='$id'";
				$this->query($query);
				return true;
			}
	

		//end of sub type cacrousel


		// sub courses  title $ des
		function addDepartmentSubTypeTitleDes($data){
			$course_id = $_SESSION["course_id"] ;
			$category = $_SESSION["course_name"] ;
			$courses_subtype_id =  $_SESSION["sub_courses_id"] ;
			$sub_courses_name =  $_SESSION["sub_courses_name"] ;
			$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a>";

			$dept_description = $this->escape_string($this->strip_selected($data['description'],$allowTags));
			$dept_title = $this->escape_string($this->strip_selected($data['title'],$allowTags));
            $date = date("Y-m-d H:i:s");
           
			$query = "insert into ".PREFIX."sub_coursestitle_descrption (coruses_id,courses_subtype_id,category_type, title, description ,created_at) 
			values('$course_id','$courses_subtype_id','$category' , '$dept_title','$dept_description','$date') ";
			 //echo $query;exit();
			return $this->query($query);
		}

		function getUniqueDepartmentSubTypeTitleDesById($id){
			$id = $this->escape_string($this->strip_all($id));
			$category = $_SESSION["course_name"] ;
			$query = "select * from ".PREFIX."sub_coursestitle_descrption where id='$id'";
			//echo $query;exit();
			$sql = $this->query($query);
			return $this->fetch($sql);
		}

	
		function updateDepartmentSubTypeTitleDes($data) {
			$course_id =  $_SESSION["course_id"] ;
			//$course_name =  $_SESSION["course_name"] ;
			$id = $this->escape_string($this->strip_all($data['id']));
			//$category = $this->escape_string($this->strip_all($data['category_name']));
			$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a>";

			$dept_description = $this->escape_string($this->strip_selected($data['description'],$allowTags));
			$dept_title = $this->escape_string($this->strip_selected($data['title'],$allowTags));
			$date = date("Y-m-d H:i:s");
			$category = $_SESSION["course_name"] ;
			$query = "update ".PREFIX."sub_coursestitle_descrption set description = '$dept_description',  title = '$dept_title'  where id='$id' ";
			//echo $query;exit;
	
			return $this->query($query);
		}

      
		function deleteDepartmentSubTypeTitleDes($id) {
			
			$id = $this->escape_string($this->strip_all($id));
			$query = "delete from ".PREFIX."sub_coursestitle_descrption where id='$id'";
			$this->query($query);
			return true;
		}


		// end of sub courses title $des


		// title $ des
		function addDepartmentTitleDes($data,$type){
			$course_id =  $_SESSION["course_id"] ;
			$course_name =  $_SESSION["course_name"] ;
			//$category = $this->escape_string($this->strip_all($data['category_name']));
			$category = $_SESSION["course_name"] ;
			$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a>";

			$dept_description = $this->escape_string($this->strip_selected($data['description'],$allowTags));
			$dept_title = $this->escape_string($this->strip_selected($data['title'],$allowTags));
			
            $date = date("Y-m-d H:i:s");
           
			$query = "insert into ".PREFIX."title_descrption (courses_category,coruses_id,category_type, title, description ,created_at) 
			values('$type','$course_id','$category' , '$dept_title','$dept_description','$date') ";
			 //echo $query;exit();
			return $this->query($query);
		}

		function getUniqueDepartmentTitleDesById($id){
			$id = $this->escape_string($this->strip_all($id));
			$category = $_SESSION["course_name"] ;
			$query = "select * from ".PREFIX."title_descrption where id='$id'";
			//echo $query;exit();
			$sql = $this->query($query);
			return $this->fetch($sql);
		}

	
		function updateDepartmentTitleDes($data) {
			$course_id =  $_SESSION["course_id"] ;
			//$course_name =  $_SESSION["course_name"] ;
			$id = $this->escape_string($this->strip_all($course_id));
			//$category = $this->escape_string($this->strip_all($data['category_name']));
			$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a>";

			$dept_description = $this->escape_string($this->strip_selected($data['description'],$allowTags));
			$dept_title = $this->escape_string($this->strip_selected($data['title'],$allowTags));
			$date = date("Y-m-d H:i:s");
			$category = $_SESSION["course_name"] ;
			$query = "update ".PREFIX."title_descrption set description = '$dept_description',  title = '$dept_title' , updated_at = '$date' where coruses_id='$course_id' ";

	
			return $this->query($query);
		}

      
		function deleteDepartmentTitleDes($id) {
			
			$id = $this->escape_string($this->strip_all($id));
			$query = "delete from ".PREFIX."title_descrption where id='$id'";
			$this->query($query);
			return true;
		}


		// end of title $des

		//course subtype
		function getUniqueCourseSubtypeById($id) {
			$id = $this->escape_string($this->strip_all($id));
			
			$query = "select * from ".PREFIX."subtype_courses_images where id='$id'";
			//echo $query;exit();
			$sql = $this->query($query);
			return $this->fetch($sql);
		}

		function addCourseSubtype($data,$file,$type) {
			//echo "deeeeee1";
			$maincourseid = $_SESSION["course_id"];
			//echo "deeeeee".$maincourseid;exit;
			// $title = $this->escape_string($this->strip_all($data['title']));
			// $sub_title = $this->escape_string($this->strip_all($data['sub_title']));
			
			$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a>";
			$sub_title = $this->escape_string($this->strip_selected($data['sub_title'],$allowTags));

			// $link = $this->escape_string($this->strip_all($data['link']));
			// $type = $this->escape_string($this->strip_all($data['type']));
			// $display_order = $this->escape_string($this->strip_all($data['display_order']));


			$date = date("Y-m-d H:i:s");
			$SaveImage = new SaveImage();
			$imgDir = '../img/coursesubtype/';
			if(isset($file['coursesubtype_img']['name']) && !empty($file['coursesubtype_img']['name'])){
				$imageName = str_replace( " ", "-", $file['coursesubtype_img']['name'] );
				$file_name = strtolower( pathinfo($imageName, PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$cropData = $this->strip_all($data['cropData1']);
				$image_name = $SaveImage->uploadCroppedImageFileFromForm($file['coursesubtype_img'], 1366, $cropData, $imgDir, $file_name.'-'.time().'-1');
			} else {
				$image_name = '';
			}

			// $query = "insert into ".PREFIX."subtype_courses_images (coursesubtype_img,title,sub_title,display_order,created) values ('$image_name', '$title', '$sub_title', '$display_order','$date')";
			$md5generatenumber =  $this->random_md5_string(5);
			$query = "insert into ".PREFIX."subtype_courses_images (courses_category,coruses_id,courses_subtype_id,courses_subtype,coursesubtype_img) values ('$type','$maincourseid','$md5generatenumber' , '$sub_title','$image_name')";
			
			$query2 = "insert into ".PREFIX."subtype_courses_list (courses_category,coruses_id,courses_subtype_id,courses_subtype) values ('$type','$maincourseid','$md5generatenumber' ,'$sub_title')";
			//echo $query;exit;
			$this->query($query2);
			
			return $this->query($query);
		}
		
		function updateCourseSubtype($data,$file) {

			$id = $this->escape_string($this->strip_all($data['id']));
			//$active = $this->escape_string($this->strip_all($data['active']));
			// $title = $this->escape_string($this->strip_all($data['title']));
			// $sub_title = $this->escape_string($this->strip_all($data['sub_title']));


			// $allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a>";
			// $title = $this->escape_string($this->strip_selected($data['title'],$allowTags));

			$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a>";
			$sub_title = $this->escape_string($this->strip_selected($data['sub_title'],$allowTags));

			//$link = $this->escape_string($this->strip_all($data['link']));
			$display_order = $this->escape_string($this->strip_all($data['display_order']));
			$SaveImage = new SaveImage();
			$imgDir = '../img/coursesubtype/';
			if(isset($file['coursesubtype_img']['name']) && !empty($file['coursesubtype_img']['name'])) {
				$imageName = str_replace( " ", "-", $file['coursesubtype_img']['name'] );
				$file_name = strtolower( pathinfo($imageName, PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$Detail = $this->getUniqueBannerById($id);
				$cropData = $this->strip_all($data['cropData1']);
				$this->unlinkImage("", $Detail['coursesubtype_img'], "large");
				$this->unlinkImage("", $Detail['coursesubtype_img'], "crop");
				$image_name = $SaveImage->uploadCroppedImageFileFromForm($file['coursesubtype_img'], 1366, $cropData, $imgDir, $file_name.'-'.time().'-1');
				$this->query("update ".PREFIX."subtype_courses_images set coursesubtype_img= '$image_name',courses_subtype='$sub_title', where id='$id'");
			}

			 $query = "update ".PREFIX."subtype_courses_images set courses_subtype='$sub_title' where id='$id'";
			// print_r($query);exit();

			//echo $query;exit();
			return $this->query($query);
		}

		function deleteCourseSubtype($id) {
			$maincourseid = $_SESSION["course_id"];
			$id = $this->escape_string($this->strip_all($id));
			$Detail = $this->getUniqueBannerById($id);
			$this->unlinkImage("banner", $Detail['image_name'], "large");
			$this->unlinkImage("banner", $Detail['image_name'], "crop");
			$query = "delete from ".PREFIX."subtype_courses_images where id='$id'";
			$query2 = "delete from ".PREFIX."subtype_courses_list where coruses_id='$maincourseid'";
			$this->query($query);
			$this->query($query2);
			return true;
		}
		//course subtypes

		//Department Data functions ends



		/**
		 * UndergraduateCourses Page And PostGraduaet
		 */
		function addUndergraduateCoursesDataImages($data,$file,$type){
            $date = date("Y-m-d H:i:s");
		
			$SaveImage = new SaveImage();
			if($type == "UGC"){
				$imgDir = '../img/Undergraduate/';
			}else{
				$imgDir = '../img/Postgraduate/';
			}
			
			if(isset($file['image']['name']) && !empty($file['image']['name'])){
				$imageName = str_replace( " ", "-", $file['image']['name'] );
				$file_name = strtolower( pathinfo($imageName, PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$cropData = $this->strip_all($data['cropData1']);
				// echo $cropData;exit();
				$image_name = $SaveImage->uploadCroppedImageFileFromForm($file['image'], 1366, $cropData, $imgDir, $file_name.'-'.time().'-1');
			} else {
				$image_name = '';
			}

           
			$query = "insert into ".PREFIX."ugraduate_courses_images ( courses_category , image, created_at) values('$type' , '$image_name',  '$date') ";
			//echo $query;exit();
			return $this->query($query);
		}

		function getUniqueUndergraduateCoursesDataImagesById($id,$type){
			$id = $this->escape_string($this->strip_all($id));
			
			$query = "select * from ".PREFIX."ugraduate_courses_images where id='$id' AND courses_category = '$type'";
			//echo $query;exit();
			$sql = $this->query($query);
			return $this->fetch($sql);
		}

		function updateUndergraduateCoursesDataImages($data,$file,$type){
			$date = date("Y-m-d H:i:s");
			$id = $this->escape_string($this->strip_all($data['id']));

			$SaveImage = new SaveImage();
			if($type == 'UGC'){
				$imgDir = '../img/Undergraduate/';
			}else{
				$imgDir = '../img/Postgraduate/';
			}
		
			if(isset($file['image']['name']) && !empty($file['image']['name'])) {
				$imageName = str_replace( " ", "-", $file['image']['name'] );
				$file_name = strtolower( pathinfo($imageName, PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$Detail = $this->getUniqueBannerById($id);
				$cropData = $this->strip_all($data['cropData1']);
				$this->unlinkImage("", $Detail['image'], "large");
				$this->unlinkImage("", $Detail['image'], "crop");
				$image_name = $SaveImage->uploadCroppedImageFileFromForm($file['image'], 1366, $cropData, $imgDir, $file_name.'-'.time().'-1');
				$this->query("update ".PREFIX."ugraduate_courses_images set image ='$image_name' ,updated_at = '$date'  where id='$id' AND courses_category = '$type'");
			}
			//$query = "update ".PREFIX."ugraduate_courses_images set dept_discp = '$dept_description',  dept_title = '$dept_title' where id='$id' ";

	
			//return $this->query($query);
		}

		function deleteUndergraduateCoursesData($id,$type) {
			$id = $this->escape_string($this->strip_all($id));
			$Detail = $this->getUniqueUndergraduateCoursesDataImagesById($id , $type);
			$this->unlinkImage("Undergraduate", $Detail['image'], "large");
			$this->unlinkImage("Undergraduate", $Detail['image'], "crop");
			$query = "delete from ".PREFIX."ugraduate_courses_images where id='$id' AND courses_category = '$type' ";
			//echo $query;exit;
			$this->query($query);
			return true;
		}
		//end of undergradugate


		

		/**
		 * header 
		 */
		function addHeaderDataImages($data,$file){
            $date = date("Y-m-d H:i:s");
			$imgDir = '../img/headers/';
			$SaveImage = new SaveImage();
			
			
			if(isset($file['image']['name']) && !empty($file['image']['name'])){
				$imageName = str_replace( " ", "-", $file['image']['name'] );
				$file_name = strtolower( pathinfo($imageName, PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$cropData = $this->strip_all($data['cropData1']);
				// echo $cropData;exit();
				$image_name = $SaveImage->uploadCroppedImageFileFromForm($file['image'], 1366, $cropData, $imgDir, $file_name.'-'.time().'-1');
			} else {
				$image_name = '';
			}

           
			$query = "insert into ".PREFIX."header_aboutus_image (  image, created_at) values('$image_name',  '$date') ";
			//echo $query;exit();
			return $this->query($query);
		}

		function getUniqueHeaderDataImagesById($id){
			$id = $this->escape_string($this->strip_all($id));
			
			$query = "select * from ".PREFIX."header_aboutus_image where id='$id' ";
			//echo $query;exit();
			$sql = $this->query($query);
			return $this->fetch($sql);
		}

		function updateHeaderDataImages($data,$file){
			$date = date("Y-m-d H:i:s");
			$id = $this->escape_string($this->strip_all($data['id']));

			
			$imgDir = '../img/headers/';
			$SaveImage = new SaveImage();
			if(isset($file['image']['name']) && !empty($file['image']['name'])) {
				$imageName = str_replace( " ", "-", $file['image']['name'] );
				$file_name = strtolower( pathinfo($imageName, PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$Detail = $this->getUniqueBannerById($id);
				$cropData = $this->strip_all($data['cropData1']);
				$this->unlinkImage("", $Detail['image'], "large");
				$this->unlinkImage("", $Detail['image'], "crop");
				$image_name = $SaveImage->uploadCroppedImageFileFromForm($file['image'], 1366, $cropData, $imgDir, $file_name.'-'.time().'-1');
				$this->query("update ".PREFIX."header_aboutus_image set image ='$image_name' ,updated_at = '$date'  where id='$id'");
			}
			//$query = "update ".PREFIX."ugraduate_courses_images set dept_discp = '$dept_description',  dept_title = '$dept_title' where id='$id' ";

	
			//return $this->query($query);
		}

		function deleteHeaderDataImage($id) {
			$id = $this->escape_string($this->strip_all($id));
			$Detail = $this->getUniqueHeaderDataImagesById($id);
			$this->unlinkImage("headeraboutusimage", $Detail['image'], "large");
			$this->unlinkImage("headeraboutusimage", $Detail['image'], "crop");
			$query = "delete from ".PREFIX."ugraduate_courses_images where id='$id' ";
			// echo $query;exit;
			$this->query($query);
			return true;
		}
		//end of header
		


	
		//student co-cirrculir
		function addStdCOCircDataImages($data,$file){
            $date = date("Y-m-d H:i:s");
		
			$SaveImage = new SaveImage();
			$imgDir = '../img/Undergraduate/';
			if(isset($file['image']['name']) && !empty($file['image']['name'])){
				$imageName = str_replace( " ", "-", $file['image']['name'] );
				$file_name = strtolower( pathinfo($imageName, PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$cropData = $this->strip_all($data['cropData1']);
				// echo $cropData;exit();
				$image_name = $SaveImage->uploadCroppedImageFileFromForm($file['image'], 1366, $cropData, $imgDir, $file_name.'-'.time().'-1');
			} else {
				$image_name = '';
			}

           
			$query = "insert into ".PREFIX."ugraduate_courses_images ( courses_category , image, created_at) values('UGC' , '$image_name',  '$date') ";
			//echo $query;exit();
			return $this->query($query);
		}

		function getUniqueStdCOCircDataImagesById($id){
			$id = $this->escape_string($this->strip_all($id));
			
			$query = "select * from ".PREFIX."ugraduate_courses_images where id='$id'";
			//echo $query;exit();
			$sql = $this->query($query);
			return $this->fetch($sql);
		}

		function updateStdCOCircDataImages($data,$file){
			$date = date("Y-m-d H:i:s");
			$id = $this->escape_string($this->strip_all($data['id']));

			$SaveImage = new SaveImage();
			$imgDir = '../img/Undergraduate/';
			if(isset($file['image']['name']) && !empty($file['image']['name'])) {
				$imageName = str_replace( " ", "-", $file['image']['name'] );
				$file_name = strtolower( pathinfo($imageName, PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$Detail = $this->getUniqueBannerById($id);
				$cropData = $this->strip_all($data['cropData1']);
				$this->unlinkImage("", $Detail['image'], "large");
				$this->unlinkImage("", $Detail['image'], "crop");
				$image_name = $SaveImage->uploadCroppedImageFileFromForm($file['image'], 1366, $cropData, $imgDir, $file_name.'-'.time().'-1');
				$this->query("update ".PREFIX."ugraduate_courses_images set image ='$image_name' ,updated_at = '$date'  where id='$id' ");
			}
			//$query = "update ".PREFIX."ugraduate_courses_images set dept_discp = '$dept_description',  dept_title = '$dept_title' where id='$id' ";

	
			// return $this->query($query);
		}

		function deleteStdCOCircData($id) {
			$id = $this->escape_string($this->strip_all($id));
			$Detail = $this->getUniqueUndergraduateCoursesDataImagesById($id);
			$this->unlinkImage("Undergraduate", $Detail['image'], "large");
			$this->unlinkImage("Undergraduate", $Detail['image'], "crop");
			$query = "delete from ".PREFIX."ugraduate_courses_images where id='$id'";
			$this->query($query);
			return true;
		}
		
		//end

		 /**
		  * end of Undergraduate Courses Page
		  */



		  /**
		 * PostgraduateCourses Page
		 */
		function addPostgraduateCoursesDataImages($data,$file){
            $date = date("Y-m-d H:i:s");

			$SaveImage = new SaveImage();
			$imgDir = '../img/Postgraduate/';
			if(isset($file['image']['name']) && !empty($file['image']['name'])){
				$imageName = str_replace( " ", "-", $file['image']['name'] );
				$file_name = strtolower( pathinfo($imageName, PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$cropData = $this->strip_all($data['cropData1']);
				// echo $cropData;exit();
				$image_name = $SaveImage->uploadCroppedImageFileFromForm($file['image'], 1366, $cropData, $imgDir, $file_name.'-'.time().'-1');
			} else {
				$image_name = '';
			}

           
			$query = "insert into ".PREFIX."ugraduate_courses_images ( courses_category, image, created_at) values('PGC' , '$image_name',  '$date') ";
			 //echo $query;exit();
			return $this->query($query);
		}

		function getUniquePostgraduateCoursesDataImagesById($id){
			$id = $this->escape_string($this->strip_all($id));
			
			$query = "select * from ".PREFIX."ugraduate_courses_images where id='$id'";
			//echo $query;exit();
			$sql = $this->query($query);
			return $this->fetch($sql);
		}

		function updatePostgraduateCoursesDataImages($data,$file){
			$id = $this->escape_string($this->strip_all($data['id']));

			$SaveImage = new SaveImage();
			$imgDir = '../img/Undergraduate/';
			if(isset($file['image']['name']) && !empty($file['image']['name'])) {
				$imageName = str_replace( " ", "-", $file['image']['name'] );
				$file_name = strtolower( pathinfo($imageName, PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$Detail = $this->getUniqueBannerById($id);
				$cropData = $this->strip_all($data['cropData1']);
				$this->unlinkImage("", $Detail['image'], "large");
				$this->unlinkImage("", $Detail['image'], "crop");
				$image_name = $SaveImage->uploadCroppedImageFileFromForm($file['image'], 1366, $cropData, $imgDir, $file_name.'-'.time().'-1');
				$this->query("update ".PREFIX."pgraduate_courses_images set image ='$image_name'  where id='$id' ");
			}
			//$query = "update ".PREFIX."ugraduate_courses_images set dept_discp = '$dept_description',  dept_title = '$dept_title' where id='$id' ";

	
			// return $this->query($query);
		}

		 /**
		  * end of postgraduate Courses Page
		  */

		function getUniqueBannerById($id) {
			$id = $this->escape_string($this->strip_all($id));
			
			$query = "select * from ".PREFIX."banner_master where id='$id'";
			//echo $query;exit();
			$sql = $this->query($query);
			return $this->fetch($sql);
		}

		function addBanner($data,$file) {
			
			// $title = $this->escape_string($this->strip_all($data['title']));
			// $sub_title = $this->escape_string($this->strip_all($data['sub_title']));


			$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a>";
			$title = $this->escape_string($this->strip_selected($data['title'],$allowTags));

			$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a>";
			$sub_title = $this->escape_string($this->strip_selected($data['sub_title'],$allowTags));

			// $link = $this->escape_string($this->strip_all($data['link']));
			// $type = $this->escape_string($this->strip_all($data['type']));
			// $display_order = $this->escape_string($this->strip_all($data['display_order']));


			$date = date("Y-m-d H:i:s");
			$SaveImage = new SaveImage();
			$imgDir = '../img/banner/';
			if(isset($file['banner_img']['name']) && !empty($file['banner_img']['name'])){
				$imageName = str_replace( " ", "-", $file['banner_img']['name'] );
				$file_name = strtolower( pathinfo($imageName, PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$cropData = $this->strip_all($data['cropData1']);
				$image_name = $SaveImage->uploadCroppedImageFileFromForm($file['banner_img'], 1366, $cropData, $imgDir, $file_name.'-'.time().'-1');
			} else {
				$image_name = '';
			}

			// $query = "insert into ".PREFIX."banner_master (banner_img,title,sub_title,display_order,created) values ('$image_name', '$title', '$sub_title', '$display_order','$date')";

			$query = "insert into ".PREFIX."banner_master (banner_img,title,sub_title,created) values ('$image_name', '$title', '$sub_title', '$date')";
			return $this->query($query);
		}
		
		function updateBanner($data,$file) {

			$id = $this->escape_string($this->strip_all($data['id']));
			//$active = $this->escape_string($this->strip_all($data['active']));
			// $title = $this->escape_string($this->strip_all($data['title']));
			// $sub_title = $this->escape_string($this->strip_all($data['sub_title']));


			$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a>";
			$title = $this->escape_string($this->strip_selected($data['title'],$allowTags));

			$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a>";
			$sub_title = $this->escape_string($this->strip_selected($data['sub_title'],$allowTags));

			//$link = $this->escape_string($this->strip_all($data['link']));
			$display_order = $this->escape_string($this->strip_all($data['display_order']));
			$SaveImage = new SaveImage();
			$imgDir = '../img/banner/';
			if(isset($file['banner_img']['name']) && !empty($file['banner_img']['name'])) {
				$imageName = str_replace( " ", "-", $file['banner_img']['name'] );
				$file_name = strtolower( pathinfo($imageName, PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$Detail = $this->getUniqueBannerById($id);
				$cropData = $this->strip_all($data['cropData1']);
				$this->unlinkImage("", $Detail['banner_img'], "large");
				$this->unlinkImage("", $Detail['banner_img'], "crop");
				$image_name = $SaveImage->uploadCroppedImageFileFromForm($file['banner_img'], 1366, $cropData, $imgDir, $file_name.'-'.time().'-1');
				$this->query("update ".PREFIX."banner_master set banner_img= '$image_name',title='$title',sub_title='$sub_title', display_order='$display_order' where id='$id'");
			}

			 $query = "update ".PREFIX."banner_master set title='$title',sub_title='$sub_title', display_order='$display_order' where id='$id'";
			// print_r($query);exit();

			//echo $query;exit();
			return $this->query($query);
		}

		function deleteBanner($id) {
			$id = $this->escape_string($this->strip_all($id));
			$Detail = $this->getUniqueBannerById($id);
			$this->unlinkImage("banner", $Detail['image_name'], "large");
			$this->unlinkImage("banner", $Detail['image_name'], "crop");
			$query = "delete from ".PREFIX."banner_master where id='$id'";
			$this->query($query);
			return true;
		}
		// Banner end



		//conatct detail

		function getUniqueContactById($id) {
			$id = $this->escape_string($this->strip_all($id));
			
			$query = "select * from ".PREFIX."contact_detail where id='$id'";
			//echo $query;exit();
			$sql = $this->query($query);
			return $this->fetch($sql);
		}

		function addContact($data) {
			
			$pos_title = $this->escape_string($this->strip_all($data['pos_title']));
			$prof_name = $this->escape_string($this->strip_all($data['prof_name']));
			$phone = $this->escape_string($this->strip_all($data['phone']));
			$email = $this->escape_string($this->strip_all($data['email']));
			$alt_phone = $this->escape_string($this->strip_all($data['alt_phone']));
			
			

			$query = "insert into ".PREFIX."contact_detail (pos_title, prof_name, phone, email, alt_phone) 
			values ('$pos_title', '$prof_name', '$phone', '$email','$alt_phone')";
			return $this->query($query);
		}
		
		function updateContact($data) {
			$date = date("Y-m-d H:i:s");
			$id = $this->escape_string($this->strip_all($data['id']));

			$pos_title = $this->escape_string($this->strip_all($data['pos_title']));
			$prof_name = $this->escape_string($this->strip_all($data['prof_name']));
			$phone = $this->escape_string($this->strip_all($data['phone']));
			$email = $this->escape_string($this->strip_all($data['email']));
			$alt_phone = $this->escape_string($this->strip_all($data['alt_phone']));
			
			 $query = "update ".PREFIX."contact_detail set 
			 pos_title='$pos_title',prof_name='$prof_name', phone='$phone' ,email = '$email', alt_phone = '$alt_phone',updated_at = '$date' where id='$id'";
			// print_r($query);exit();

			//echo $query;exit();
			return $this->query($query);
		}

		function deleteContact($id) {
			$id = $this->escape_string($this->strip_all($id));
			$query = "delete from ".PREFIX."contact_detail where id='$id'";
			$this->query($query);
			return true;
		}

		//end of conatct detail

		//Faculty
		function getUniqueFacultyById($id , $type) {
			$id = $this->escape_string($this->strip_all($id));
			
			$query = "select * From ".PREFIX."faculty where id='$id' AND courses_category = '".$type."' ";
			//echo $query;exit();
			$sql = $this->query($query);
			return $this->fetch($sql);
		}

		function addfaculty($data,$type) {
			$course_id =  $_SESSION["course_id"] ;
			$course_name =  $_SESSION["course_name"] ;
			$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a>";
			$faculty_name = $this->escape_string($this->strip_selected($data['faculty_name'],$allowTags));
			$faculty_dept = $this->escape_string($this->strip_selected($data['faculty_dept'],$allowTags));
			$faculty_desgi = $this->escape_string($this->strip_selected($data['faculty_desgi'],$allowTags));

			//$title = $this->escape_string($this->strip_all($data['title']));
			// $link = $this->escape_string($this->strip_all($data['link']));
			// $type = $this->escape_string($this->strip_all($data['type']));
			$query = "insert into ".PREFIX."faculty (coruses_id,coruses_name,name, department, designation, courses_category) values ('$course_id','$course_name','$faculty_name', '$faculty_dept', '$faculty_desgi', '$type')";
			//echo $query;exit;
			return $this->query($query);
		}

		function updatefaculty($data) {
			$course_id =  $_SESSION["course_id"] ;
			$date = date("Y-m-d H:i:s");
			$id = $this->escape_string($this->strip_all($course_id ));
			//$active = $this->escape_string($this->strip_all($data['active']));
			$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a>";
			$faculty_name = $this->escape_string($this->strip_selected($data['faculty_name'],$allowTags));
			$faculty_dept = $this->escape_string($this->strip_selected($data['faculty_dept'],$allowTags));
			$faculty_desgi = $this->escape_string($this->strip_selected($data['faculty_desgi'],$allowTags));

			 $query = "update ".PREFIX."faculty set name='$faculty_name',department='$faculty_dept', designation='$faculty_desgi' , updated_at = '$date' where coruses_id='$id'";
			// print_r($query);exit();

			// echo $query;exit();
			return $this->query($query);
		}

		function deletefaculty($id , $type) {
			//$course_id =  $_SESSION["course_id"] ;
			$id = $this->escape_string($this->strip_all($id));
			$Detail = $this->getUniqueFacultyById($id , $type);
			$query = "delete from ".PREFIX."faculty where id='$id'";
			$this->query($query);
			return true;
		}

		//end of Faculty


		
		//header about sanstha 
		function getUniqueAboutSansthaById($id) {
			$id = $this->escape_string($this->strip_all($id));
			
			$query = "select * From ".PREFIX."header_aboutus_sanstha where id='$id'  ";
			//echo $query;exit();
			$sql = $this->query($query);
			return $this->fetch($sql);
		}

		function addAboutSanstha($data,$file) {
			$date = date("Y-m-d H:i:s");
			$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a>";
			$title = $this->escape_string($this->strip_selected($data['title'],$allowTags));

			//$pdf = $this->escape_string($this->strip_all($data['pdf']));
			$link = $this->escape_string($this->strip_all($data['link']));
	
			$SaveImage = new SaveImage();
			$imgDir_pdf = '../img/headers/';

			if(isset($file['pdf']['name']) && !empty($file['pdf']['name'])){
				$imageName_pdf = str_replace( " ", "-", $file['pdf']['name'] );
				$file_name_pdf = strtolower( pathinfo($imageName_pdf, PATHINFO_FILENAME));
				$file_name_pdf = $this->getValidatedPermalink($file_name_pdf);
				$Detail = $this->getUniqueAboutSansthaById($id);
		
				//  $this->unlinkImage("", $Detail['pdf'], "large");
				// $this->unlinkImage("", $Detail['pdf'], "crop");
				//$image_name_pdf = $SaveImage->uploadFileFromForm($file['pdf'], 1366, $cropData_pdf, $imgDir_pdf, $file_name_pdf.'-'.time().'-1');
				$image_name_pdf = $SaveImage->uploadFileFromForm($file['pdf'],$imgDir_pdf,$file_name_pdf);

			} else {
				$image_name_pdf = '';
			}
			
			$query = "insert into ".PREFIX."header_aboutus_sanstha (title, link, pdf, created_at) values ('$title', '$link', '$image_name_pdf',  '$date')";
			//echo $query;exit;
			return $this->query($query);
		}

		function updateAboutSanstha($data,$file) {
			$date = date("Y-m-d H:i:s");
			$SaveImage = new SaveImage();
			$imgDir_pdf = '../img/headers/';
			$id = $this->escape_string($this->strip_all($data['id']));
			//$active = $this->escape_string($this->strip_all($data['active']));
			$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a>";
			$title = $this->escape_string($this->strip_selected($data['title'],$allowTags));
			$pdf = $this->escape_string($this->strip_all($data['pdf']));
			$link = $this->escape_string($this->strip_all($data['link']));
			if(isset($file['pdf']['name']) && !empty($file['pdf']['name'])){
				$imageName_pdf = str_replace( " ", "-", $file['pdf']['name'] );
				$file_name_pdf = strtolower( pathinfo($imageName_pdf, PATHINFO_FILENAME));
				$file_name_pdf = $this->getValidatedPermalink($file_name_pdf);
				$Detail = $this->getUniqueAboutSansthaById($id);
		
				//  $this->unlinkImage("", $Detail['pdf'], "large");
				// $this->unlinkImage("", $Detail['pdf'], "crop");
				//$image_name_pdf = $SaveImage->uploadFileFromForm($file['pdf'], 1366, $cropData_pdf, $imgDir_pdf, $file_name_pdf.'-'.time().'-1');
				$image_name_pdf = $SaveImage->uploadFileFromForm($file['pdf'],$imgDir_pdf,$file_name_pdf);
				$this->query("update ".PREFIX."header_aboutus_sanstha set title='$title',link='$link', pdf='$image_name_pdf' , updated_at = '$date' where id='$id'");
			}

			 $query = "update ".PREFIX."header_aboutus_sanstha set title='$title',link='$link' ,updated_at = '$date' where id='$id'";
			// print_r($query);exit();

			// echo $query;exit();
			return $this->query($query);
		}

		function deleteAboutSanstha($id) {
			$id = $this->escape_string($this->strip_all($id));
			$Detail = $this->getUniqueAboutSansthaById($id);
			$this->unlinkImage("headersanstha", $Detail['pdf'], "large");
			$this->unlinkImage("headersanstha", $Detail['pdf'], "crop");
			$query = "delete from ".PREFIX."header_aboutus_sanstha where id='$id'";
			$this->query($query);
			return true;
		}

		//end of header about sanstha 



		//header announcements
		function getUniqueannouncementsById($id) {
			$id = $this->escape_string($this->strip_all($id));
			
			$query = "select * From ".PREFIX."announcements where id='$id'  ";
			//echo $query;exit();
			$sql = $this->query($query);
			return $this->fetch($sql);
		}

		function addannouncements($data,$file) {
			$date = date("Y-m-d H:i:s");
			$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a>";
			$title = $this->escape_string($this->strip_selected($data['title'],$allowTags));

			//$pdf = $this->escape_string($this->strip_all($data['pdf']));
			$link = $this->escape_string($this->strip_all($data['link']));
	
			$SaveImage = new SaveImage();
			$imgDir_pdf = '../img/headers/announcements/';

			if(isset($file['pdf']['name']) && !empty($file['pdf']['name'])){
				$imageName_pdf = str_replace( " ", "-", $file['pdf']['name'] );
				$file_name_pdf = strtolower( pathinfo($imageName_pdf, PATHINFO_FILENAME));
				$file_name_pdf = $this->getValidatedPermalink($file_name_pdf);
				$Detail = $this->getUniqueannouncementsById($id);
		
				//  $this->unlinkImage("", $Detail['pdf'], "large");
				// $this->unlinkImage("", $Detail['pdf'], "crop");
				//$image_name_pdf = $SaveImage->uploadFileFromForm($file['pdf'], 1366, $cropData_pdf, $imgDir_pdf, $file_name_pdf.'-'.time().'-1');
				$image_name_pdf = $SaveImage->uploadFileFromForm($file['pdf'],$imgDir_pdf,$file_name_pdf);

			} else {
				$image_name_pdf = '';
			}
			
			$query = "insert into ".PREFIX."announcements (title, link, pdf, created_at) values ('$title', '$link', '$image_name_pdf',  '$date')";
			//echo $query;exit;
			return $this->query($query);
		}

		function updateannouncements($data,$file) {
			$date = date("Y-m-d H:i:s");
			$SaveImage = new SaveImage();
			$imgDir_pdf = '../img/headers/announcements/';
			$id = $this->escape_string($this->strip_all($data['id']));
			//$active = $this->escape_string($this->strip_all($data['active']));
			$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a>";
			$title = $this->escape_string($this->strip_selected($data['title'],$allowTags));
			$pdf = $this->escape_string($this->strip_all($data['pdf']));
			$link = $this->escape_string($this->strip_all($data['link']));
			if(isset($file['pdf']['name']) && !empty($file['pdf']['name'])){
				$imageName_pdf = str_replace( " ", "-", $file['pdf']['name'] );
				$file_name_pdf = strtolower( pathinfo($imageName_pdf, PATHINFO_FILENAME));
				$file_name_pdf = $this->getValidatedPermalink($file_name_pdf);
				$Detail = $this->getUniqueannouncementsById($id);
		
				//  $this->unlinkImage("", $Detail['pdf'], "large");
				// $this->unlinkImage("", $Detail['pdf'], "crop");
				//$image_name_pdf = $SaveImage->uploadFileFromForm($file['pdf'], 1366, $cropData_pdf, $imgDir_pdf, $file_name_pdf.'-'.time().'-1');
				$image_name_pdf = $SaveImage->uploadFileFromForm($file['pdf'],$imgDir_pdf,$file_name_pdf);
				$this->query("update ".PREFIX."announcements set title='$title', pdf='$image_name_pdf' , updated_at = '$date' where id='$id'");
			}else{
				$image_name_pdf = NULL;
			}

			 $query = "update ".PREFIX."announcements set title='$title',link='$link', pdf='$image_name_pdf'  ,updated_at = '$date' where id='$id'";
			// print_r($query);exit();

			// echo $query;exit();
			return $this->query($query);
		}

		function deleteannouncements($id) {
			$id = $this->escape_string($this->strip_all($id));
			$Detail = $this->getUniqueannouncementsById($id);
			$this->unlinkImage("announcements", $Detail['pdf'], "large");
			$this->unlinkImage("announcements", $Detail['pdf'], "crop");
			$query = "delete from ".PREFIX."announcements where id='$id'";
			$this->query($query);
			return true;
		}

		//end of header announcements



		//header Governance & Administration
		function getUniqueGovernanceAdministrationById($id,$category) {
			$id = $this->escape_string($this->strip_all($id));
			 $category = $this->escape_string($this->strip_all(trim($category)));
			$tablename;
			if($category == "Governing Body"){

				$tablename = "header_governingbody";

			}else if($category== "Board of Studies"){

				$tablename = "header_boardofstudies";

			}else if($category== "Finance Committee"){

				$tablename = "header_financecommittee";

			}else if($category== "College Devlopment Committee"){

				$tablename = "header_collegedevelopment";

			}else{
				$tablename = "header_academic_council";
			}
			 
			$query = "select * From ".PREFIX.$tablename." where id='$id' and type = '".$category."'";
			//echo $query;exit();
			$sql = $this->query($query);
			return $this->fetch($sql);
		}

		function addGovernanceAdministration($data,$file) {
			$date = date("Y-m-d H:i:s");
			$gover_admin = $this->escape_string($this->strip_all($data['gover_admin']));
			$tablename ;
			if($gover_admin == "Governing Body"){

				$tablename = "header_governingbody";

			}else if($gover_admin== "Board of Studies"){

				$tablename = "header_boardofstudies";

			}else if($gover_admin== "Finance Committee"){

				$tablename = "header_financecommittee";

			}else if($gover_admin== "College Devlopment Committee"){

				$tablename = "header_collegedevelopment";

			}else{
				$tablename = "header_academic_council";  
			}
			 
			//$title = $this->escape_string($this->strip_all($data['title']));

			$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a>";
			$title = $this->escape_string($this->strip_selected($data['title'],$allowTags));
			//$pdf = $this->escape_string($this->strip_all($data['pdf']));
			$link = $this->escape_string($this->strip_all($data['link']));
	
			$SaveImage = new SaveImage();
			$imgDir_pdf = '../img/headers/';

			if(isset($file['pdf']['name']) && !empty($file['pdf']['name'])){
				$imageName_pdf = str_replace( " ", "-", $file['pdf']['name'] );
				$file_name_pdf = strtolower( pathinfo($imageName_pdf, PATHINFO_FILENAME));
				$file_name_pdf = $this->getValidatedPermalink($file_name_pdf);
				//$Detail = $this->getUniqueGovernanceAdministrationById($id);
		
				//  $this->unlinkImage("", $Detail['pdf'], "large");
				// $this->unlinkImage("", $Detail['pdf'], "crop");
				//$image_name_pdf = $SaveImage->uploadFileFromForm($file['pdf'], 1366, $cropData_pdf, $imgDir_pdf, $file_name_pdf.'-'.time().'-1');
				$image_name_pdf = $SaveImage->uploadFileFromForm($file['pdf'],$imgDir_pdf,$file_name_pdf);

			} else {
				$image_name_pdf = '';
			}
			
			$query = "insert into ".PREFIX.$tablename." (type,title, link, pdf, created_at) values ('$gover_admin','$title', '$link', '$image_name_pdf',  '$date')";
			//echo $query;exit;
			return $this->query($query);
		}

		function updateGovernanceAdministration($data,$file ,$category) {
			$date = date("Y-m-d H:i:s");
			$gover_admin = $this->escape_string($this->strip_all($category));
			
			$tablename ;
			if($gover_admin == "Governing Body"){

				$tablename = "header_governingbody";

			}else if($gover_admin== "Board of Studies"){

				$tablename = "header_boardofstudies";

			}else if($gover_admin== "Finance Committee"){

				$tablename = "header_financecommittee";

			}else if($gover_admin== "College Devlopment Committee"){

				$tablename = "header_collegedevelopment";

			}else{
				$tablename = "header_academic_council";
			}
			$SaveImage = new SaveImage();
			$imgDir_pdf = '../img/headers/';
			$id = $this->escape_string($this->strip_all($data['id']));
			//$active = $this->escape_string($this->strip_all($data['active']));
			$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a>";
			$title = $this->escape_string($this->strip_selected($data['title'],$allowTags));
			$pdf = $this->escape_string($this->strip_all($data['pdf']));
			$link = $this->escape_string($this->strip_all($data['link']));
			if(isset($file['pdf']['name']) && !empty($file['pdf']['name'])){
				$imageName_pdf = str_replace( " ", "-", $file['pdf']['name'] );
				$file_name_pdf = strtolower( pathinfo($imageName_pdf, PATHINFO_FILENAME));
				$file_name_pdf = $this->getValidatedPermalink($file_name_pdf);
			//	$Detail = $this->getUniqueGovernanceAdministrationById($id);
		
				//  $this->unlinkImage("", $Detail['pdf'], "large");
				// $this->unlinkImage("", $Detail['pdf'], "crop");
				//$image_name_pdf = $SaveImage->uploadFileFromForm($file['pdf'], 1366, $cropData_pdf, $imgDir_pdf, $file_name_pdf.'-'.time().'-1');
				$image_name_pdf = $SaveImage->uploadFileFromForm($file['pdf'],$imgDir_pdf,$file_name_pdf);
				$this->query("update ".PREFIX.$tablename." set title='$title',link='$link', pdf='$image_name_pdf' , updated_at = '$date' where id='$id' and type = '".$category."'");
			}

			 $query = "update ".PREFIX.$tablename." set title='$title',link='$link' ,updated_at = '$date' where id='$id' and type = '".$category."'";
			 //print_r($query);exit();

		//	echo $query;exit();
			return $this->query($query);
		}

		function deleteGovernanceAdministration($id,$category) {
			$id = $this->escape_string($this->strip_all($id));
			$category = $this->escape_string($this->strip_all(trim($category)));
			$tablename;
			if($category == "Governing Body"){

				$tablename = "header_governingbody";

			}else if($category== "Board of Studies"){

				$tablename = "header_boardofstudies";

			}else if($category== "Finance Committee"){

				$tablename = "header_financecommittee";

			}else if($category== "College Devlopment Committee"){

				$tablename = "header_collegedevelopment";

			}else{
				$tablename = "header_academic_council";
			
			}

			$Detail = $this->getUniqueGovernanceAdministrationById($id,$category);
			$this->unlinkImage("goveradmin", $Detail['pdf'], "large");
			$this->unlinkImage("goveradmin", $Detail['pdf'], "crop");
			$query = "delete from ".PREFIX.$tablename." where id='$id' and type = '".$category."'";
			$this->query($query);
			return true;
		}

		//end of header Governance & Administration

		//header Academic
		function getUniqueAcademicById($id,$category) {
			$id = $this->escape_string($this->strip_all($id));
			 $category = $this->escape_string($this->strip_all(trim($category)));
			$tablename;
			if($category == "Academic"){

				$tablename = "header_academic";

			}else if($category== "Department"){

				$tablename = "header_department";

			}else{
				//empty
			}
			 
			$query = "select * From ".PREFIX.$tablename." where id='$id' and type = '".$category."'";
			//echo $query;exit();
			$sql = $this->query($query);
			return $this->fetch($sql);
		}

		function addAcademic($data,$file) {
			$date = date("Y-m-d H:i:s");
			$gover_admin = $this->escape_string($this->strip_all($data['gover_admin']));
			//echo $gover_admin;exit;
			$tablename ;
			if($gover_admin == "Academic"){

            $tablename = "header_academic";

            }else if($gover_admin== "Department"){

            $tablename = "header_department";

            }else{
            //empty
            }
			 
			$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a>";
			$title = $this->escape_string($this->strip_selected($data['title'],$allowTags));
			//$pdf = $this->escape_string($this->strip_all($data['pdf']));
			$link = $this->escape_string($this->strip_all($data['link']));
	
			$SaveImage = new SaveImage();
			$imgDir_pdf = '../img/headers/';

			if(isset($file['pdf']['name']) && !empty($file['pdf']['name'])){
				$imageName_pdf = str_replace( " ", "-", $file['pdf']['name'] );
				$file_name_pdf = strtolower( pathinfo($imageName_pdf, PATHINFO_FILENAME));
				$file_name_pdf = $this->getValidatedPermalink($file_name_pdf);
				//$Detail = $this->getUniqueAcademicById($id);
		
				//  $this->unlinkImage("", $Detail['pdf'], "large");
				// $this->unlinkImage("", $Detail['pdf'], "crop");
				//$image_name_pdf = $SaveImage->uploadFileFromForm($file['pdf'], 1366, $cropData_pdf, $imgDir_pdf, $file_name_pdf.'-'.time().'-1');
				$image_name_pdf = $SaveImage->uploadFileFromForm($file['pdf'],$imgDir_pdf,$file_name_pdf);

			} else {
				$image_name_pdf = '';
			}
			
			$query = "insert into ".PREFIX.$tablename." (type,title, link, pdf, created_at) values ('$gover_admin','$title', '$link', '$image_name_pdf',  '$date')";
			//echo $query;exit;
			return $this->query($query);
		}

		function updateAcademic($data,$file ,$category) {
			$date = date("Y-m-d H:i:s");
			$gover_admin = $this->escape_string($this->strip_all($category));
			
			$tablename ;
			if($gover_admin == "Academic"){

            $tablename = "header_academic";

            }else if($gover_admin== "Department"){

            $tablename = "header_department";

            }else{
            //empty
            }
			$SaveImage = new SaveImage();
			$imgDir_pdf = '../img/headers/';
			$id = $this->escape_string($this->strip_all($data['id']));
			//$active = $this->escape_string($this->strip_all($data['active']));
			$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a>";
			$title = $this->escape_string($this->strip_selected($data['title'],$allowTags));
			$pdf = $this->escape_string($this->strip_all($data['pdf']));
			$link = $this->escape_string($this->strip_all($data['link']));
			if(isset($file['pdf']['name']) && !empty($file['pdf']['name'])){
				$imageName_pdf = str_replace( " ", "-", $file['pdf']['name'] );
				$file_name_pdf = strtolower( pathinfo($imageName_pdf, PATHINFO_FILENAME));
				$file_name_pdf = $this->getValidatedPermalink($file_name_pdf);
				//$Detail = $this->getUniqueAcademicById($id);
		
				//  $this->unlinkImage("", $Detail['pdf'], "large");
				// $this->unlinkImage("", $Detail['pdf'], "crop");
				//$image_name_pdf = $SaveImage->uploadFileFromForm($file['pdf'], 1366, $cropData_pdf, $imgDir_pdf, $file_name_pdf.'-'.time().'-1');
				$image_name_pdf = $SaveImage->uploadFileFromForm($file['pdf'],$imgDir_pdf,$file_name_pdf);
				$this->query("update ".PREFIX.$tablename." set title='$title',link='$link', pdf='$image_name_pdf' , updated_at = '$date' where id='$id' and type = '".$category."'");
			}

			 $query = "update ".PREFIX.$tablename." set title='$title',link='$link' ,updated_at = '$date' where id='$id' and type = '".$category."'";
			 //print_r($query);exit();

		//	echo $query;exit();
			return $this->query($query);
		}

		function deleteAcademic($id,$category) {
			$id = $this->escape_string($this->strip_all($id));
			$category = $this->escape_string($this->strip_all(trim($category)));
			$tablename;
			if($category == "Academic"){

			$tablename = "header_academic";

			}else if($category== "Department"){

			$tablename = "header_department";

			}else{
			//empty
			}

			$Detail = $this->getUniqueAcademicById($id,$category);
			$this->unlinkImage("goveradmin", $Detail['pdf'], "large");
			$this->unlinkImage("goveradmin", $Detail['pdf'], "crop");
			$query = "delete from ".PREFIX.$tablename." where id='$id' and type = '".$category."'";
			$this->query($query);
			return true;
		}

		//end of header Academic


		//header IQAC
		function getUniqueIQACById($id,$category) {
			$id = $this->escape_string($this->strip_all($id));
			 $category = $this->escape_string($this->strip_all(trim($category)));
			$tablename;
			if($category == "IQAC"){

				$tablename = "header_iqac";

			}else if($category== "AQAR"){

				$tablename = "header_aqar";

			}else if($category== "MOM"){

				$tablename = "header_mom";

			}else if($category== "NAAC"){

            $tablename = "header_naac";

            }else if($category== "Download"){

            $tablename = "header_download";

            }else{
				//empty
			}
			 
			$query = "select * From ".PREFIX.$tablename." where id='$id' and type = '".$category."'";
			//echo $query;exit();
			$sql = $this->query($query);
			return $this->fetch($sql);
		}

		function addIQAC($data,$file) {
			$date = date("Y-m-d H:i:s");
			$gover_admin = $this->escape_string($this->strip_all($data['gover_admin']));
			$tablename ;
			if($gover_admin == "IQAC"){

            $tablename = "header_iqac";

            }else if($gover_admin== "AQAR"){

            $tablename = "header_aqar";

            }else if($gover_admin== "MOM"){

            $tablename = "header_mom";

            }else if($gover_admin== "NAAC"){

            $tablename = "header_naac";

            }else if($gover_admin== "Download"){

            $tablename = "header_download";

            }else{
            //empty
            }
			 
			$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a>";
			$title = $this->escape_string($this->strip_selected($data['title'],$allowTags));
			//$pdf = $this->escape_string($this->strip_all($data['pdf']));
			$link = $this->escape_string($this->strip_all($data['link']));
	
			$SaveImage = new SaveImage();
			$imgDir_pdf = '../img/headers/';

			if(isset($file['pdf']['name']) && !empty($file['pdf']['name'])){
				$imageName_pdf = str_replace( " ", "-", $file['pdf']['name'] );
				$file_name_pdf = strtolower( pathinfo($imageName_pdf, PATHINFO_FILENAME));
				$file_name_pdf = $this->getValidatedPermalink($file_name_pdf);
				//$Detail = $this->getUniqueIQACById($id);
		
				//  $this->unlinkImage("", $Detail['pdf'], "large");
				// $this->unlinkImage("", $Detail['pdf'], "crop");
				//$image_name_pdf = $SaveImage->uploadFileFromForm($file['pdf'], 1366, $cropData_pdf, $imgDir_pdf, $file_name_pdf.'-'.time().'-1');
				$image_name_pdf = $SaveImage->uploadFileFromForm($file['pdf'],$imgDir_pdf,$file_name_pdf);

			} else {
				$image_name_pdf = '';
			}
			
			$query = "insert into ".PREFIX.$tablename." (type,title, link, pdf, created_at) values ('$gover_admin','$title', '$link', '$image_name_pdf',  '$date')";
			//echo $query;exit;
			return $this->query($query);
		}

		function updateIQAC($data,$file ,$category) {
			$date = date("Y-m-d H:i:s");
			$gover_admin = $this->escape_string($this->strip_all($category));
			
			$tablename ;
			if($gover_admin == "IQAC"){

            $tablename = "header_iqac";

            }else if($gover_admin== "AQAR"){

            $tablename = "header_aqar";

            }else if($gover_admin== "MOM"){

            $tablename = "header_mom";

            }else if($gover_admin== "NAAC"){

            $tablename = "header_naac";

            }else if($gover_admin== "Download"){

            $tablename = "header_download";

            }else{
            //empty
            }

			$SaveImage = new SaveImage();
			$imgDir_pdf = '../img/headers/';
			$id = $this->escape_string($this->strip_all($data['id']));
			//$active = $this->escape_string($this->strip_all($data['active']));
			$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a>";
$title = $this->escape_string($this->strip_selected($data['title'],$allowTags));
			$pdf = $this->escape_string($this->strip_all($data['pdf']));
			$link = $this->escape_string($this->strip_all($data['link']));
			if(isset($file['pdf']['name']) && !empty($file['pdf']['name'])){
				$imageName_pdf = str_replace( " ", "-", $file['pdf']['name'] );
				$file_name_pdf = strtolower( pathinfo($imageName_pdf, PATHINFO_FILENAME));
				$file_name_pdf = $this->getValidatedPermalink($file_name_pdf);
				//$Detail = $this->getUniqueIQACById($id);
		
				//  $this->unlinkImage("", $Detail['pdf'], "large");
				// $this->unlinkImage("", $Detail['pdf'], "crop");
				//$image_name_pdf = $SaveImage->uploadFileFromForm($file['pdf'], 1366, $cropData_pdf, $imgDir_pdf, $file_name_pdf.'-'.time().'-1');
				$image_name_pdf = $SaveImage->uploadFileFromForm($file['pdf'],$imgDir_pdf,$file_name_pdf);
				$this->query("update ".PREFIX.$tablename." set title='$title',link='$link', pdf='$image_name_pdf' , updated_at = '$date' where id='$id' and type = '".$category."'");
			}

			 $query = "update ".PREFIX.$tablename." set title='$title',link='$link' ,updated_at = '$date' where id='$id' and type = '".$category."'";
			 //print_r($query);exit();

		//	echo $query;exit();
			return $this->query($query);
		}

		function deleteIQAC($id,$category) {
			$id = $this->escape_string($this->strip_all($id));
			$category = $this->escape_string($this->strip_all(trim($category)));
			$tablename;
			if($category == "IQAC"){

				$tablename = "header_iqac";

			}else if($category== "AQAR"){

				$tablename = "header_aqar";

			}else if($category== "MOM"){

				$tablename = "header_mom";

			}else if($category== "NAAC"){

            $tablename = "header_naac";

            }else if($category== "Download"){

            $tablename = "header_download";

            }else{
				//empty
			}

			$Detail = $this->getUniqueIQACById($id,$category);
			$this->unlinkImage("goveradmin1", $Detail['pdf'], "large");
			$this->unlinkImage("goveradmin1", $Detail['pdf'], "crop");
			$query = "delete from ".PREFIX.$tablename." where id='$id' and type = '".$category."'";
			$this->query($query);
			return true;
		}

		//end of header IQAC


		//header Examination
		function getUniqueExaminationById($id,$category) {
			$id = $this->escape_string($this->strip_all($id));
			 $category = $this->escape_string($this->strip_all(trim($category)));
			$tablename;
			if($category == "Rules and Regulations"){

				$tablename = "header_rulesregulation";

			}else if($category== "Others"){

				$tablename = "header_others";

			}else{
				//empty
			}
			 
			$query = "select * From ".PREFIX.$tablename." where id='$id' and type = '".$category."'";
			//echo $query;exit();
			$sql = $this->query($query);
			return $this->fetch($sql);
		}

		function addExamination($data,$file) {
			$date = date("Y-m-d H:i:s");
			$gover_admin = $this->escape_string($this->strip_all($data['gover_admin']));
			$tablename ;
			if($gover_admin == "Rules and Regulations"){

            $tablename = "header_rulesregulation";

            }else if($gover_admin== "Others"){

            $tablename = "header_others";

            }else{
            //empty
            }
			 
			$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a>";
$title = $this->escape_string($this->strip_selected($data['title'],$allowTags));
			//$pdf = $this->escape_string($this->strip_all($data['pdf']));
			$link = $this->escape_string($this->strip_all($data['link']));
	
			$SaveImage = new SaveImage();
			$imgDir_pdf = '../img/headers/';

			if(isset($file['pdf']['name']) && !empty($file['pdf']['name'])){
				$imageName_pdf = str_replace( " ", "-", $file['pdf']['name'] );
				$file_name_pdf = strtolower( pathinfo($imageName_pdf, PATHINFO_FILENAME));
				$file_name_pdf = $this->getValidatedPermalink($file_name_pdf);
				//$Detail = $this->getUniqueExaminationById($id);
		
				//  $this->unlinkImage("", $Detail['pdf'], "large");
				// $this->unlinkImage("", $Detail['pdf'], "crop");
				//$image_name_pdf = $SaveImage->uploadFileFromForm($file['pdf'], 1366, $cropData_pdf, $imgDir_pdf, $file_name_pdf.'-'.time().'-1');
				$image_name_pdf = $SaveImage->uploadFileFromForm($file['pdf'],$imgDir_pdf,$file_name_pdf);

			} else {
				$image_name_pdf = '';
			}
			
			$query = "insert into ".PREFIX.$tablename." (type,title, link, pdf, created_at) values ('$gover_admin','$title', '$link', '$image_name_pdf',  '$date')";
			//echo $query;exit;
			return $this->query($query);
		}

		function updateExamination($data,$file ,$category) {
			$date = date("Y-m-d H:i:s");
			$gover_admin = $this->escape_string($this->strip_all($category));
			
			$tablename ;
			if($gover_admin == "Rules and Regulations"){

            $tablename = "header_rulesregulation";

            }else if($gover_admin== "Others"){

            $tablename = "header_others";

            }else{
            //empty
            }

			$SaveImage = new SaveImage();
			$id = $this->escape_string($this->strip_all($data['id']));
			$imgDir_pdf = '../img/headers/';
			//$active = $this->escape_string($this->strip_all($data['active']));
			$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a>";
$title = $this->escape_string($this->strip_selected($data['title'],$allowTags));
			$pdf = $this->escape_string($this->strip_all($data['pdf']));
			$link = $this->escape_string($this->strip_all($data['link']));
			if(isset($file['pdf']['name']) && !empty($file['pdf']['name'])){
				$imageName_pdf = str_replace( " ", "-", $file['pdf']['name'] );
				$file_name_pdf = strtolower( pathinfo($imageName_pdf, PATHINFO_FILENAME));
				$file_name_pdf = $this->getValidatedPermalink($file_name_pdf);
			//	$Detail = $this->getUniqueExaminationById($id);
		
				//  $this->unlinkImage("", $Detail['pdf'], "large");
				// $this->unlinkImage("", $Detail['pdf'], "crop");
				//$image_name_pdf = $SaveImage->uploadFileFromForm($file['pdf'], 1366, $cropData_pdf, $imgDir_pdf, $file_name_pdf.'-'.time().'-1');
				$image_name_pdf = $SaveImage->uploadFileFromForm($file['pdf'],$imgDir_pdf,$file_name_pdf);
				$this->query("update ".PREFIX.$tablename." set title='$title',link='$link', pdf='$image_name_pdf' , updated_at = '$date' where id='$id' and type = '".$category."'");
			}

			 $query = "update ".PREFIX.$tablename." set title='$title',link='$link' ,updated_at = '$date' where id='$id' and type = '".$category."'";
			 //print_r($query);exit();

		//	echo $query;exit();
			return $this->query($query);
		}

		function deleteExamination($id,$category) {
			$id = $this->escape_string($this->strip_all($id));
			$category = $this->escape_string($this->strip_all(trim($category)));
			$tablename;
			if($category == "Rules and Regulations"){

            $tablename = "header_rulesregulation";

            }else if($category== "Others"){

            $tablename = "header_others";

            }else{
            //empty
            }

			$Detail = $this->getUniqueExaminationById($id,$category);
			$this->unlinkImage("goveradmin", $Detail['pdf'], "large");
			$this->unlinkImage("goveradmin", $Detail['pdf'], "crop");
			$query = "delete from ".PREFIX.$tablename." where id='$id' and type = '".$category."'";
			$this->query($query);
			return true;
		}

		//end of header Examination


		//header Admission
		function getUniqueAdmissionById($id,$category) {
			$id = $this->escape_string($this->strip_all($id));
			 $category = $this->escape_string($this->strip_all(trim($category)));
			$tablename;
			if($category == "Code of Conduct"){

				$tablename = "header_codeofcontent";
                
			}else if($category== "Anti-Ragging Cell"){

            $tablename = "header_antiraggingcell";

            }else if($category== "Others"){

				$tablename = "header_othersadmission";

			}else{
				//empty
			}
			 
			$query = "select * From ".PREFIX.$tablename." where id='$id' and type = '".$category."'";
			//echo $query;exit();
			$sql = $this->query($query);
			return $this->fetch($sql);
		}

		function addAdmission($data,$file) {
			$date = date("Y-m-d H:i:s");
			$gover_admin = $this->escape_string($this->strip_all($data['gover_admin']));
			$tablename ;
			if($gover_admin == "Code of Conduct"){

            $tablename = "header_codeofcontent";

            }else if($gover_admin== "Anti-Ragging Cell"){

            $tablename = "header_antiraggingcell";

            }else if($gover_admin== "Others"){

            $tablename = "header_othersadmission";

            }else{
            //empty
            }
			 
			$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a>";
$title = $this->escape_string($this->strip_selected($data['title'],$allowTags));
			//$pdf = $this->escape_string($this->strip_all($data['pdf']));
			$link = $this->escape_string($this->strip_all($data['link']));
	
			$SaveImage = new SaveImage();
			$imgDir_pdf = '../img/headers/';

			if(isset($file['pdf']['name']) && !empty($file['pdf']['name'])){
				$imageName_pdf = str_replace( " ", "-", $file['pdf']['name'] );
				$file_name_pdf = strtolower( pathinfo($imageName_pdf, PATHINFO_FILENAME));
				$file_name_pdf = $this->getValidatedPermalink($file_name_pdf);
				//$Detail = $this->getUniqueAdmissionById($id);
		
				//  $this->unlinkImage("", $Detail['pdf'], "large");
				// $this->unlinkImage("", $Detail['pdf'], "crop");
				//$image_name_pdf = $SaveImage->uploadFileFromForm($file['pdf'], 1366, $cropData_pdf, $imgDir_pdf, $file_name_pdf.'-'.time().'-1');
				$image_name_pdf = $SaveImage->uploadFileFromForm($file['pdf'],$imgDir_pdf,$file_name_pdf);

			} else {
				$image_name_pdf = '';
			}
			
			$query = "insert into ".PREFIX.$tablename." (type,title, link, pdf, created_at) values ('$gover_admin','$title', '$link', '$image_name_pdf',  '$date')";
			//echo $query;exit;
			return $this->query($query);
		}

		function updateAdmission($data,$file ,$category) {
			$date = date("Y-m-d H:i:s");
			$gover_admin = $this->escape_string($this->strip_all($category));
			
			$tablename ;
			if($gover_admin == "Code of Conduct"){

            $tablename = "header_codeofcontent";

            }else if($gover_admin== "Anti-Ragging Cell"){

            $tablename = "header_antiraggingcell";

            }else if($gover_admin== "Others"){

            $tablename = "header_othersadmission";

            }else{
            //empty
            }

			$SaveImage = new SaveImage();
			$imgDir_pdf = '../img/headers/';
			$id = $this->escape_string($this->strip_all($data['id']));
			//$active = $this->escape_string($this->strip_all($data['active']));
			$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a>";
$title = $this->escape_string($this->strip_selected($data['title'],$allowTags));
			$pdf = $this->escape_string($this->strip_all($data['pdf']));
			$link = $this->escape_string($this->strip_all($data['link']));
			if(isset($file['pdf']['name']) && !empty($file['pdf']['name'])){
				$imageName_pdf = str_replace( " ", "-", $file['pdf']['name'] );
				$file_name_pdf = strtolower( pathinfo($imageName_pdf, PATHINFO_FILENAME));
				$file_name_pdf = $this->getValidatedPermalink($file_name_pdf);
				//$Detail = $this->getUniqueAdmissionById($id);
		
				//  $this->unlinkImage("", $Detail['pdf'], "large");
				// $this->unlinkImage("", $Detail['pdf'], "crop");
				//$image_name_pdf = $SaveImage->uploadFileFromForm($file['pdf'], 1366, $cropData_pdf, $imgDir_pdf, $file_name_pdf.'-'.time().'-1');
				$image_name_pdf = $SaveImage->uploadFileFromForm($file['pdf'],$imgDir_pdf,$file_name_pdf);
				$this->query("update ".PREFIX.$tablename." set title='$title',link='$link', pdf='$image_name_pdf' , updated_at = '$date' where id='$id' and type = '".$category."'");
			}

			 $query = "update ".PREFIX.$tablename." set title='$title',link='$link' ,updated_at = '$date' where id='$id' and type = '".$category."'";
			 //print_r($query);exit();

		//	echo $query;exit();
			return $this->query($query);
		}

		function deleteAdmission($id,$category) {
			$id = $this->escape_string($this->strip_all($id));
			$category = $this->escape_string($this->strip_all(trim($category)));
			$tablename;
			if($category == "Code of Conduct"){

            $tablename = "header_codeofcontent";

            }else if($category== "Anti-Ragging Cell"){

            $tablename = "header_antiraggingcell";

            }else if($category== "Others"){

            $tablename = "header_othersadmission";

            }else{
            //empty
            }
			$Detail = $this->getUniqueAdmissionById($id,$category);
			$this->unlinkImage("goveradmin", $Detail['pdf'], "large");
			$this->unlinkImage("goveradmin", $Detail['pdf'], "crop");
			$query = "delete from ".PREFIX.$tablename." where id='$id' and type = '".$category."'";
			$this->query($query);
			return true;
		}

		//end of header Admission



		//header Footer
		function getUniqueFooterById($id,$category) {
			$id = $this->escape_string($this->strip_all($id));
			 $category = $this->escape_string($this->strip_all(trim($category)));
			$tablename;
			if($category == "Quick Link"){

				$tablename = "footer_quick_link";
                
			}else if($category== "Our Institute"){

            $tablename = "footer_our_inst";

            }else if($category== "Admission"){

				$tablename = "footer_admission";

			}else{
				//empty
			}
			 
			$query = "select * From ".PREFIX.$tablename." where id='$id' and type = '".$category."'";
			//echo $query;exit();
			$sql = $this->query($query);
			return $this->fetch($sql);
		}

		function addFooter($data,$file) {
			$date = date("Y-m-d H:i:s");
			$gover_admin = $this->escape_string($this->strip_all($data['gover_admin']));
			$tablename ;
			if($gover_admin == "Quick Link"){

				$tablename = "footer_quick_link";
                
			}else if($gover_admin== "Our Institute"){

            $tablename = "footer_our_inst";

            }else if($gover_admin== "Admission"){

				$tablename = "footer_admission";

			}else{
				//empty
			}
			 
			
			$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a>";
			$title = $this->escape_string($this->strip_selected($data['title'],$allowTags));
			//$pdf = $this->escape_string($this->strip_all($data['pdf']));
			$link = $this->escape_string($this->strip_all($data['link']));
	
			$SaveImage = new SaveImage();
			$imgDir_pdf = '../img/headers/';

			if(isset($file['pdf']['name']) && !empty($file['pdf']['name'])){
				$imageName_pdf = str_replace( " ", "-", $file['pdf']['name'] );
				$file_name_pdf = strtolower( pathinfo($imageName_pdf, PATHINFO_FILENAME));
				$file_name_pdf = $this->getValidatedPermalink($file_name_pdf);
				//$Detail = $this->getUniqueAdmissionById($id);
		
				//  $this->unlinkImage("", $Detail['pdf'], "large");
				// $this->unlinkImage("", $Detail['pdf'], "crop");
				//$image_name_pdf = $SaveImage->uploadFileFromForm($file['pdf'], 1366, $cropData_pdf, $imgDir_pdf, $file_name_pdf.'-'.time().'-1');
				$image_name_pdf = $SaveImage->uploadFileFromForm($file['pdf'],$imgDir_pdf,$file_name_pdf);

			} else {
				$image_name_pdf = '';
			}
			
			$query = "insert into ".PREFIX.$tablename." (type,title, link, pdf, created_at) values ('$gover_admin','$title', '$link', '$image_name_pdf',  '$date')";
			//echo $query;exit;
			return $this->query($query);
		}

		function updateFooter($data,$file ,$category) {
			$date = date("Y-m-d H:i:s");
			$gover_admin = $this->escape_string($this->strip_all($category));
			
			$tablename ;
			if($gover_admin == "Quick Link"){

				$tablename = "footer_quick_link";
                
			}else if($gover_admin== "Our Institute"){

            $tablename = "footer_our_inst";

            }else if($gover_admin== "Admission"){

				$tablename = "footer_admission";

			}else{
				//empty
			}
			 

			$SaveImage = new SaveImage();
			$imgDir_pdf = '../img/headers/';
			$id = $this->escape_string($this->strip_all($data['id']));
			//$active = $this->escape_string($this->strip_all($data['active']));
			
			$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a>";
			$title = $this->escape_string($this->strip_selected($data['title'],$allowTags));
			$pdf = $this->escape_string($this->strip_all($data['pdf']));
			$link = $this->escape_string($this->strip_all($data['link']));
			if(isset($file['pdf']['name']) && !empty($file['pdf']['name'])){
				$imageName_pdf = str_replace( " ", "-", $file['pdf']['name'] );
				$file_name_pdf = strtolower( pathinfo($imageName_pdf, PATHINFO_FILENAME));
				$file_name_pdf = $this->getValidatedPermalink($file_name_pdf);
				//$Detail = $this->getUniqueAdmissionById($id);
		
				//  $this->unlinkImage("", $Detail['pdf'], "large");
				// $this->unlinkImage("", $Detail['pdf'], "crop");
				//$image_name_pdf = $SaveImage->uploadFileFromForm($file['pdf'], 1366, $cropData_pdf, $imgDir_pdf, $file_name_pdf.'-'.time().'-1');
				$image_name_pdf = $SaveImage->uploadFileFromForm($file['pdf'],$imgDir_pdf,$file_name_pdf);
				$this->query("update ".PREFIX.$tablename." set title='$title',link='$link', pdf='$image_name_pdf' , updated_at = '$date' where id='$id' and type = '".$category."'");
			}

			 $query = "update ".PREFIX.$tablename." set title='$title',link='$link' ,updated_at = '$date' where id='$id' and type = '".$category."'";
			 //print_r($query);exit();

		//	echo $query;exit();
			return $this->query($query);
		}

		function deleteFooter($id,$category) {
			$id = $this->escape_string($this->strip_all($id));
			$category = $this->escape_string($this->strip_all(trim($category)));
			$tablename;
			if($category == "Quick Link"){

				$tablename = "footer_quick_link";
                
			}else if($category== "Our Institute"){

            $tablename = "footer_our_inst";

            }else if($category== "Admission"){

				$tablename = "footer_admission";

			}else{
				//empty
			}
			 
			$Detail = $this->getUniqueFooterById($id,$category);
			$this->unlinkImage("goveradmin", $Detail['pdf'], "large");
			$this->unlinkImage("goveradmin", $Detail['pdf'], "crop");
			$query = "delete from ".PREFIX.$tablename." where id='$id' and type = '".$category."'";
			$this->query($query);
			return true;
		}

		//end of Footer


		//header StudentCorner
		function getUniqueStudentCornerById($id,$category) {
			$id = $this->escape_string($this->strip_all($id));
			 $category = $this->escape_string($this->strip_all(trim($category)));
			$tablename;
			if($category == "Important Link"){

				$tablename = "header_implink";
                
			}else if($category== "Others"){

				$tablename = "header_otherstudent";

			}else{
				//empty
			}
			 
			$query = "select * From ".PREFIX.$tablename." where id='$id' and type = '".$category."'";
			//echo $query;exit();
			$sql = $this->query($query);
			return $this->fetch($sql);
		}

		function addStudentCorner($data,$file) {
			$date = date("Y-m-d H:i:s");
			$gover_admin = $this->escape_string($this->strip_all($data['gover_admin']));
			$tablename ;
			if($gover_admin == "Important Link"){

            $tablename = "header_implink";

            }else if($gover_admin== "Others"){

            $tablename = "header_otherstudent";

            }else{
            //empty
            }
			 
			$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a>";
$title = $this->escape_string($this->strip_selected($data['title'],$allowTags));
			//$pdf = $this->escape_string($this->strip_all($data['pdf']));
			$link = $this->escape_string($this->strip_all($data['link']));
	
			$SaveImage = new SaveImage();
			$imgDir_pdf = '../img/headers/';

			if(isset($file['pdf']['name']) && !empty($file['pdf']['name'])){
				$imageName_pdf = str_replace( " ", "-", $file['pdf']['name'] );
				$file_name_pdf = strtolower( pathinfo($imageName_pdf, PATHINFO_FILENAME));
				$file_name_pdf = $this->getValidatedPermalink($file_name_pdf);
				//$Detail = $this->getUniqueStudentCornerById($id);
		
				//  $this->unlinkImage("", $Detail['pdf'], "large");
				// $this->unlinkImage("", $Detail['pdf'], "crop");
				//$image_name_pdf = $SaveImage->uploadFileFromForm($file['pdf'], 1366, $cropData_pdf, $imgDir_pdf, $file_name_pdf.'-'.time().'-1');
				$image_name_pdf = $SaveImage->uploadFileFromForm($file['pdf'],$imgDir_pdf,$file_name_pdf);

			} else {
				$image_name_pdf = '';
			}
			
			$query = "insert into ".PREFIX.$tablename." (type,title, link, pdf, created_at) values ('$gover_admin','$title', '$link', '$image_name_pdf',  '$date')";
			//echo $query;exit;
			return $this->query($query);
		}

		function updateStudentCorner($data,$file ,$category) {
			$date = date("Y-m-d H:i:s");
			$gover_admin = $this->escape_string($this->strip_all($category));
			
			$tablename ;
			if($gover_admin == "Important Link"){

            $tablename = "header_implink";

            }else if($gover_admin== "Others"){

            $tablename = "header_otherstudent";

            }else{
            //empty
            }

			$SaveImage = new SaveImage();
			$imgDir_pdf = '../img/headers/';
			$id = $this->escape_string($this->strip_all($data['id']));
			//$active = $this->escape_string($this->strip_all($data['active']));
			$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a>";
$title = $this->escape_string($this->strip_selected($data['title'],$allowTags));
			$pdf = $this->escape_string($this->strip_all($data['pdf']));
			$link = $this->escape_string($this->strip_all($data['link']));
			if(isset($file['pdf']['name']) && !empty($file['pdf']['name'])){
				$imageName_pdf = str_replace( " ", "-", $file['pdf']['name'] );
				$file_name_pdf = strtolower( pathinfo($imageName_pdf, PATHINFO_FILENAME));
				$file_name_pdf = $this->getValidatedPermalink($file_name_pdf);
			//	$Detail = $this->getUniqueStudentCornerById($id);
		
				//  $this->unlinkImage("", $Detail['pdf'], "large");
				// $this->unlinkImage("", $Detail['pdf'], "crop");
				//$image_name_pdf = $SaveImage->uploadFileFromForm($file['pdf'], 1366, $cropData_pdf, $imgDir_pdf, $file_name_pdf.'-'.time().'-1');
				$image_name_pdf = $SaveImage->uploadFileFromForm($file['pdf'],$imgDir_pdf,$file_name_pdf);
				$this->query("update ".PREFIX.$tablename." set title='$title',link='$link', pdf='$image_name_pdf' , updated_at = '$date' where id='$id' and type = '".$category."'");
			}

			 $query = "update ".PREFIX.$tablename." set title='$title',link='$link' ,updated_at = '$date' where id='$id' and type = '".$category."'";
			 //print_r($query);exit();

		//	echo $query;exit();
			return $this->query($query);
		}

		function deleteStudentCorner($id,$category) {
			$id = $this->escape_string($this->strip_all($id));
			$category = $this->escape_string($this->strip_all(trim($category)));
			$tablename;
			if($category == "Important Link"){

            $tablename = "header_implink";

            }else if($category== "Others"){

            $tablename = "header_otherstudent";

            }else{
            //empty
            }
			$Detail = $this->getUniqueStudentCornerById($id,$category);
			$this->unlinkImage("goveradmin1", $Detail['pdf'], "large");
			$this->unlinkImage("goveradmin1", $Detail['pdf'], "crop");
			$query = "delete from ".PREFIX.$tablename." where id='$id' and type = '".$category."'";
			$this->query($query);
			return true;
		}

		//end of header StudentCorner
		

		//Laboratory
		function getUniqueLaboratoryById($id , $type) {
			$id = $this->escape_string($this->strip_all($id));
			
			$query = "select * From ".PREFIX."laboratory where id='$id' AND courses_category = '".$type."' ";
			//echo $query;exit();
			$sql = $this->query($query);
			return $this->fetch($sql);
		}

		function addLaboratory($data,$type) {
			$course_id =  $_SESSION["course_id"] ;
			$course_name =  $_SESSION["course_name"] ;
			$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a>";
			$lab_name = $this->escape_string($this->strip_selected($data['lab_name'],$allowTags));
			$lab_incharge = $this->escape_string($this->strip_selected($data['lab_incharge'],$allowTags));
			$lab_contactno = $this->escape_string($this->strip_selected($data['lab_contactno'],$allowTags));
	
			// $link = $this->escape_string($this->strip_all($data['link']));
			// $type = $this->escape_string($this->strip_all($data['type']));
			$query = "insert into ".PREFIX."laboratory (coruses_id,coruses_name,lab_name, lab_incharge, lab_contactno, courses_category) 
			values ('$course_id','$course_name','$lab_name', '$lab_incharge', '$lab_contactno', '$type')";
			//echo $query;exit;
			return $this->query($query);
		}

		function updateLaboratory($data) {
			$course_id =  $_SESSION["course_id"] ;
			$date = date("Y-m-d H:i:s");
			$id = $this->escape_string($this->strip_all($course_id));
			//$active = $this->escape_string($this->strip_all($data['active']));
			$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a>";
			$lab_name = $this->escape_string($this->strip_selected($data['lab_name'],$allowTags));
			$lab_incharge = $this->escape_string($this->strip_selected($data['lab_incharge'],$allowTags));
			$lab_contactno = $this->escape_string($this->strip_selected($data['lab_contactno'],$allowTags));
	
			

			 $query = "update ".PREFIX."laboratory set lab_name='$lab_name',lab_incharge='$lab_incharge', lab_contactno='$lab_contactno' , updated_at = '$date' where coruses_id='$course_id'";
			// print_r($query);exit();

			// echo $query;exit();
			return $this->query($query);
		}

		function deleteLaboratory($id , $type) {
			$course_id =  $_SESSION["course_id"] ;
			$id = $this->escape_string($this->strip_all($id));
			$Detail = $this->getUniqueLaboratoryById($id , $type);
			$query = "delete from ".PREFIX."laboratory where id='$id'";
			$this->query($query);
			return true;
		}
		//end of Laboratory




		//student academic   for both
		function getUniqueStudentAcademicById($id , $type) {
			$id = $this->escape_string($this->strip_all($id));
			
			$query = "select * from ".PREFIX."student_academic where id='$id' AND courses_category = '$type'";
			//echo $query;exit();
			$sql = $this->query($query);
			return $this->fetch($sql);
		}

		function addStudentAcademic($data,$file,$type) {
			$course_id =  $_SESSION["course_id"] ;
			$course_name =  $_SESSION["course_name"] ;
			$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a>";
			$title = $this->escape_string($this->strip_selected($data['title'],$allowTags));
			//$sub_title = $this->escape_string($this->strip_all($data['sub_title']));
			// $link = $this->escape_string($this->strip_all($data['link']));
			// $type = $this->escape_string($this->strip_all($data['type']));
			//$display_order = $this->escape_string($this->strip_all($data['display_order']));
			$date = date("Y-m-d H:i:s");
			$SaveImage = new SaveImage();
			if($type == "UGC"){
				$imgDir = '../img/StudentAcademic/undergraduate/';
			}else{
				$imgDir = '../img/StudentAcademic/postgraduate/';
			}
		
			if(isset($file['stdacd_img']['name']) && !empty($file['stdacd_img']['name'])){
				$imageName = str_replace( " ", "-", $file['stdacd_img']['name'] );
				$file_name = strtolower( pathinfo($imageName, PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$cropData = $this->strip_all($data['cropData1']);
				$image_name = $SaveImage->uploadCroppedImageFileFromForm($file['stdacd_img'], 1366, $cropData, $imgDir, $file_name.'-'.time().'-1');
			} else {
				$image_name = '';
			}

			$query = "insert into ".PREFIX."student_academic (coruses_id,coruses_name,courses_category, title, image) values ('$course_id','$course_name','$type', '$title', '$image_name')";
			//echo $query;exit;
			return $this->query($query);
		}
		
		function updateStudentAcademic($data,$file,$type ) {
			$course_id =  $_SESSION["course_id"] ;
			$date = date("Y-m-d H:i:s");
			$id = $this->escape_string($this->strip_all($course_id));
			//$active = $this->escape_string($this->strip_all($data['active']));
		
			$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a>";
			$title = $this->escape_string($this->strip_selected($data['title'],$allowTags));
			//$sub_title = $this->escape_string($this->strip_all($data['sub_title']));
			//$link = $this->escape_string($this->strip_all($data['link']));
			//$display_order = $this->escape_string($this->strip_all($data['display_order']));
			$SaveImage = new SaveImage();
			if($type == "UGC"){
				$imgDir = '../img/StudentAcademic/undergraduate/';
			}else{
				$imgDir = '../img/StudentAcademic/postgraduate/';
			}

			
			if(isset($file['stdacd_img']['name']) && !empty($file['stdacd_img']['name'])) {
				$imageName = str_replace( " ", "-", $file['stdacd_img']['name'] );
				$file_name = strtolower( pathinfo($imageName, PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$Detail = $this->getUniqueStudentAcademicById($id , $type);
				$cropData = $this->strip_all($data['cropData1']);
				$this->unlinkImage("", $Detail['stdacd_img'], "large");
				$this->unlinkImage("", $Detail['stdacd_img'], "crop");
				$image_name = $SaveImage->uploadCroppedImageFileFromForm($file['stdacd_img'], 1366, $cropData, $imgDir, $file_name.'-'.time().'-1');
				$this->query("update ".PREFIX."student_academic set image= '$image_name',title='$title',updated_at='$date' where coruses_id='$course_id' AND courses_category = '$type'");
			}

			 $query = "update ".PREFIX."student_academic set title='$title',updated_at='$date' where coruses_id='$course_id' AND courses_category = '$type'";
			// print_r($query);exit();

			//echo $query;exit();
			return $this->query($query);
		}

		function deleteStudentAcademic($id, $type , $std_type) {
			$id = $this->escape_string($this->strip_all($id));
			$Detail = $this->getUniqueStudentAcademicById($id , $type);
			$this->unlinkImage(strtolower($type)."-".$std_type, $Detail['image'], "large");
			$this->unlinkImage(strtolower($type)."-".$std_type, $Detail['image'], "crop");
			$query = "delete from ".PREFIX."student_academic where id='$id' AND courses_category = '$type' ";
			$this->query($query);
			return true;
		}

		//end of student student academic


		//student co-curricular for both   
		function getUniqueStudentCurricularById($id , $type) {
			$id = $this->escape_string($this->strip_all($id));
			
			$query = "select * from ".PREFIX."student_curricular where id='$id' AND courses_category = '$type'";
			//echo $query;exit();
			$sql = $this->query($query);
			return $this->fetch($sql);
		}

		function addStudentStudentCurricular($data,$file,$type) {
			$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a>";
			$title = $this->escape_string($this->strip_selected($data['title'],$allowTags));

			
			$course_id =  $_SESSION["course_id"] ;
			$course_name =  $_SESSION["course_name"] ;

			// $link = $this->escape_string($this->strip_all($data['link']));
			// $type = $this->escape_string($this->strip_all($data['type']));
			 //$display_order = $this->escape_string($this->strip_all($data['display_order']));
			$date = date("Y-m-d H:i:s");
			$SaveImage = new SaveImage();
			if($type == 'UGC'){
				$imgDir = '../img/StudentCo-Curricular/undergraduate/';
			}else{
				$imgDir = '../img/StudentCo-Curricular/postgraduate/';
			}
		
			if(isset($file['stdcirrcular_img']['name']) && !empty($file['stdcirrcular_img']['name'])){
				$imageName = str_replace( " ", "-", $file['stdcirrcular_img']['name'] );
				$file_name = strtolower( pathinfo($imageName, PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$cropData = $this->strip_all($data['cropData1']);
				$image_name = $SaveImage->uploadCroppedImageFileFromForm($file['stdcirrcular_img'], 1366, $cropData, $imgDir, $file_name.'-'.time().'-1');
			} else {
				$image_name = '';
			}

			$query = "insert into ".PREFIX."student_curricular (coruses_id,coruses_name,courses_category, title, image) values ('$course_id','$course_name','$type', '$title', '$image_name')";
				//echo $query;exit;
			return $this->query($query);
		}
		
		function updateStudentCurricular($data,$file,$type) {
			$date = date("Y-m-d H:i:s");
			$id = $this->escape_string($this->strip_all($data['id']));
			//$active = $this->escape_string($this->strip_all($data['active']));
			$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a>";
			$title = $this->escape_string($this->strip_selected($data['title'],$allowTags));
			//$sub_title = $this->escape_string($this->strip_all($data['sub_title']));
			//$link = $this->escape_string($this->strip_all($data['link']));
			//$display_order = $this->escape_string($this->strip_all($data['display_order']));
			$SaveImage = new SaveImage();
			if($type == 'UGC'){
				$imgDir = '../img/StudentCo-Curricular/undergraduate/';
			}else{
				$imgDir = '../img/StudentCo-Curricular/postgraduate/';
			}
		
			if(isset($file['stdcirrcular_img']['name']) && !empty($file['stdcirrcular_img']['name'])) {
				$imageName = str_replace( " ", "-", $file['stdcirrcular_img']['name'] );
				$file_name = strtolower( pathinfo($imageName, PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$Detail = $this->getUniqueStudentCurricularById($id , $type);
				$cropData = $this->strip_all($data['cropData1']);
				$this->unlinkImage("", $Detail['stdcirrcular_img'], "large");
				$this->unlinkImage("", $Detail['stdcirrcular_img'], "crop");
				$image_name = $SaveImage->uploadCroppedImageFileFromForm($file['stdcirrcular_img'], 1366, $cropData, $imgDir, $file_name.'-'.time().'-1');
				$this->query("update ".PREFIX."student_curricular set image= '$image_name',title='$title',updated_at='$date' where id='$id' AND  courses_category = '$type'");
			}

			 $query = "update ".PREFIX."student_curricular set title='$title',updated_at='$date' where id='$id' AND  courses_category = '$type'";
			// print_r($query);exit();

			//echo $query;exit();
			return $this->query($query);
		}

		function deleteStudentCurricular($id , $type , $std_type) {
			$id = $this->escape_string($this->strip_all($id));
			$Detail = $this->getUniqueStudentCurricularById($id , $type);
			$this->unlinkImage(strtolower($type)."-".$std_type , $Detail['image'], "large"); // UGC-SC
			$this->unlinkImage(strtolower($type)."-".$std_type , $Detail['image'], "crop");
			$query = "delete from ".PREFIX."student_curricular where id='$id' AND  courses_category = '$type' ";
			$this->query($query);
			return true;
		}

		//end of student student co-curricular


		// Welcome Content
		function getUniqueWelcomeById($id){
			$id = $this->escape_string($this->strip_all($id));
			$sql = "SELECT `image_name` FROM ".PREFIX."home_page WHERE `id`='".$id."'";
			$this->query($sql);
		}
		function updateHomePage($data,$file){
			$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a>";
			$id = $this->escape_string($this->strip_all($data['id']));
			//$link = $this->escape_string($this->strip_all($data['link']));
			$title = $this->escape_string($this->strip_selected($data['title'],$allowTags));
			
			$SaveImage = new SaveImage();
			$imgDir = '../img/';
			if(isset($file['image_name']['name']) && !empty($file['image_name']['name'])) {
				$imageName = str_replace( " ", "-", $file['banner_img']['name'] );
				$file_name = strtolower( pathinfo($imageName, PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$Detail = $this->getUniqueBannerById($id);
				$cropData = $this->strip_all($data['cropData1']);
				$this->unlinkImage("", $Detail['image_name'], "large");
				$this->unlinkImage("", $Detail['image_name'], "crop");
				$image_name = $SaveImage->uploadCroppedImageFileFromForm($file['image_name'], 441, $cropData, $imgDir, $file_name.'-'.time().'-1');
				$this->query("update ".PREFIX."home_page set image_name='$image_name' where id='$id'");
			}
			$query = "update ".PREFIX."home_page set title='$title' where id='$id'";
			$this->query($query);
		}
		
		// Welcome Content End
		// About Us Content
		function getUniqueAboutUsById($id){
			$id = $this->escape_string($this->strip_all($id));
			$sql = "SELECT `image_name` FROM ".PREFIX."about_us WHERE `id`='".$id."'";
			$this->query($sql);
		}
		function updateAboutUsPage($data,$file){
			$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a>";
			$id = $this->escape_string($this->strip_all($data['id']));
			$desc1 = $this->escape_string($this->strip_selected($data['desc1'],$allowTags));
			$desc2 = $this->escape_string($this->strip_selected($data['desc2'],$allowTags));
			
			$SaveImage = new SaveImage();
			$imgDir = '../img/';
			if(isset($file['image_name']['name']) && !empty($file['image_name']['name'])) {
				$imageName = str_replace( " ", "-", $file['image_name']['name'] );
				$file_name = strtolower( pathinfo($imageName, PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$Detail = $this->getUniqueAboutUsById($id);
				$cropData = $this->strip_all($data['cropData1']);
				$this->unlinkImage("", $Detail['image_name'], "large");
				$this->unlinkImage("", $Detail['image_name'], "crop");
				$image_name = $SaveImage->uploadCroppedImageFileFromForm($file['image_name'], 387, $cropData, $imgDir, $file_name.'-'.time().'-1');
				$this->query("update ".PREFIX."about_us set image_name='$image_name' ");
			}
			$query = "update ".PREFIX."about_us set desc1='$desc1',desc2='$desc2' ";
			$this->query($query);
		}
		
		// About Us Content End
		
		// Feature Master
		
		
		function getUniqueFeatureById($id) {
			$id = $this->escape_string($this->strip_all($id));
			$query = "select * from ".PREFIX."feature_master where id='".$id."'";
			$sql = $this->query($query);
			return $this->fetch($sql);
		}
		function updateFeatureMaster($data,$file) {
			$id = $this->escape_string($this->strip_all($data['id']));
			$feature_name = $this->escape_string($this->strip_all($data['feature_name']));
			$display_order = $this->escape_string($this->strip_all($data['display_order']));
			$query = "update ".PREFIX."feature_master set feature_name='".$feature_name."', display_order='".$display_order."' where id='".$id."'";
			$this->query($query);
		}
		// Feature Master
		
		// Package Mastger
		function getUniquePackageById($id) {
			$id = $this->escape_string($this->strip_all($id));
			$query = "select * from ".PREFIX."package_master where id='".$id."'";
			$sql = $this->query($query);
			return $this->fetch($sql);
		}
		function updatePackageMaster($data,$file) {
			
			$id = $this->escape_string($this->strip_all($data['id']));
			$package_name = $this->escape_string($this->strip_all($data['package_name']));
			$display_order = $this->escape_string($this->strip_all($data['display_order']));
			
			$query = "update ".PREFIX."package_master set package_name='".$package_name."', display_order='".$display_order."' where id='".$id."'";
			$this->query($query);
		}
		// Package Master
		
		// === CATEGORY STARTS ===
		function getUniqueCategoryById($id) {
			$id = $this->escape_string($this->strip_all($id));
			$query = "select * from ".PREFIX."category_master where id='".$id."'";
			$sql = $this->query($query);
			return $this->fetch($sql);
		}
		function getAllCategories() {
			$query = "select * from ".PREFIX."category_master where active='Yes'";
			$sql = $this->query($query);
			return $sql;
		}
		function getAllPackages() {
			$query = "select * from ".PREFIX."package_master order by display_order ASC";
			$sql = $this->query($query);
			return $sql;
		}
		function getAllFeatures() {
			$query = "select * from ".PREFIX."feature_master order by display_order ASC";
			$sql = $this->query($query);
			return $sql;
		}
		function addCategory($data,$file){
			
			$category_name = $this->escape_string($this->strip_all($data['category_name']));
			$active = $this->escape_string($this->strip_all($data['active']));
			$display_order = $this->escape_string($this->strip_all($data['display_order']));
			$date = date("Y-m-d H:i:s");
			/* $SaveImage = new SaveImage();
			$imgDir = '../img/category/';
			if(isset($file['image_name']['name']) && !empty($file['image_name']['name'])){
				$imageName = str_replace( " ", "-", $file['image_name']['name'] );
				$file_name = strtolower( pathinfo($imageName, PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$cropData = $this->strip_all($data['cropData1']);
				$image_name = $SaveImage->uploadCroppedImageFileFromForm($file['image_name'], 240, $cropData, $imgDir, $file_name.'-'.time().'-1');
			} else {
				$image_name = '';
			}  */
			
			$query = "insert into ".PREFIX."category_master(category_name, active, display_order,created) values ('".$category_name."', '".$active."', '".$display_order."', '".$date."')";
			$this->query($query);

			//$category_id = $this->last_insert_id();

			
		}
		function updateCategory($data,$file) {
			
			$id = $this->escape_string($this->strip_all($data['id']));
			$category_name = $this->escape_string($this->strip_all($data['category_name']));
			$active = $this->escape_string($this->strip_all($data['active']));
			$display_order = $this->escape_string($this->strip_all($data['display_order']));
			
			$Detail = $this->getUniqueCategoryById($id);
			$SaveImage = new SaveImage();
			$imgDir = '../img/banner/';
			if(isset($file['image_name']['name']) && !empty($file['image_name']['name'])) {
				$cropData = $this->strip_all($data['cropData1']);
				$imageName = str_replace( " ", "-", $file['image_name']['name'] );
				$file_name = strtolower( pathinfo($imageName, PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$this->unlinkImage("category", $Detail['image_name'], "large");
				$this->unlinkImage("category", $Detail['image_name'], "crop");
				$image_name = $SaveImage->uploadCroppedImageFileFromForm($file['image_name'], 269, $cropData, $imgDir, $file_name.'-'.time().'-1');
				$this->query("update ".PREFIX."category_master set image='$image_name' where id='$id'");
			} 
			
			
			$query = "update ".PREFIX."category_master set category_name='".$category_name."', active='".$active."', display_order='".$display_order."' where id='".$id."'";
			$this->query($query);

			$category_id = $id;

		}
		function deleteCategory($id) {
			$id = $this->escape_string($this->strip_all($id));

			$query = "delete from ".PREFIX."category_master where id='".$id."'";
			$this->query($query);
			/* $sql = $this->query("select id from ".PREFIX."sub_category_master where category_id='$id'");
			while($result = $this->fetch($sql)) {
				$this->deleteSubCategory($result['id']);
			}
			$sql = $this->query("select id from ".PREFIX."product_master where category_id='$id'");
			while($detail = $this->fetch($sql)) {
				$product_id = $detail['id'];
				$this->deleteProduct($product_id);
			} */
			
		}
		

		
		// === CATEGORY ENDS ===
		// === SUB CATEGORY STARTS ===
		function getUniqueSubCategoryById($id) {
			$id = $this->escape_string($this->strip_all($id));
			$query = "select * from ".PREFIX."sub_category_master where id='".$id."'";
			$sql = $this->query($query);
			return $this->fetch($sql);
		}
		
		
		function getAllSubCategories($category_id) {
			$category_id = $this->escape_string($this->strip_all($category_id));
			$query = "select * from ".PREFIX."sub_category_master where category_id='$category_id' and active='Yes'";
			$sql = $this->query($query);
			return $sql;
		}
		function addSubCategory($data,$file){
			$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a>";
			$description = $this->escape_string($this->strip_selected($data['description'],$allowTags));
			$category_name = $this->escape_string($this->strip_all($data['name']));
			$active = $this->escape_string($this->strip_all($data['active']));
			$category_id = $this->escape_string($this->strip_all($data['category_id']));
			$category = $this->getUniqueCategoryById($category_id);
			$permalink = $this->getValidatedPermalink($category_name);
			$catParma = $this->getValidatedPermalink($category['category_name']);
			$display_order = $this->getValidatedPermalink($data['display_order']);
			
			$permalink = $catParma.'/'.$permalink;
			$SaveImage = new SaveImage();
			$imgDir = '../img/cat-banner/';
			if(isset($file['image_name']['name']) && !empty($file['image_name']['name'])){
				$imageName = str_replace( " ", "-", $file['image_name']['name'] );
				$file_name = strtolower( pathinfo($imageName, PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$cropData = $this->strip_all($data['cropData1']);
				$image_name = $SaveImage->uploadCroppedImageFileFromForm($file['image_name'], 1350, $cropData, $imgDir, $file_name.'-'.time().'-1');
			} else {
				$image_name = '';
			} 
			$query = "insert into ".PREFIX."sub_category_master(image_name, category_id, sub_category_name, permalink, active, display_order,description) values ('".$image_name."','".$category_id."', '".$category_name."', '".$permalink."', '".$active."','".$display_order."','".$description."')";
			$this->query($query);
		}
		function updateSubCategory($data,$file) {
			$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a>";
			$description = $this->escape_string($this->strip_selected($data['description'],$allowTags));
			$id = $this->escape_string($this->strip_all($data['id']));
			$category_name = $this->escape_string($this->strip_all($data['name']));
			$active = $this->escape_string($this->strip_all($data['active']));
			$category_id = $this->escape_string($this->strip_all($data['category_id']));
			$category = $this->getUniqueCategoryById($category_id);
			$permalink = $this->getValidatedPermalink($category_name);
			$catParma = $this->getValidatedPermalink($category['category_name']);
			$display_order = $this->getValidatedPermalink($data['display_order']);
			
			$permalink = $catParma.'/'.$permalink;
			$Detail = $this->getUniqueSubCategoryById($id);
			$SaveImage = new SaveImage();
			$imgDir = '../img/cat-banner/';
			if(isset($file['image_name']['name']) && !empty($file['image_name']['name'])) {
				$cropData = $this->strip_all($data['cropData1']);
				$imageName = str_replace( " ", "-", $file['image_name']['name'] );
				$file_name = strtolower( pathinfo($imageName, PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$this->unlinkImage("cat-banner", $Detail['image_name'], "large");
				$this->unlinkImage("cat-banner", $Detail['image_name'], "crop");
				$image_name = $SaveImage->uploadCroppedImageFileFromForm($file['image_name'], 1350, $cropData, $imgDir, $file_name.'-'.time().'-1');
				$this->query("update ".PREFIX."sub_category_master set image_name='$image_name' where id='$id'");
			} 
			$query = "update ".PREFIX."sub_category_master set sub_category_name='".$category_name."', permalink='".$permalink."', active='".$active."',display_order='".$display_order."',description='".$description."' where id='".$id."'";
			$this->query($query);
		}
		function deleteSubCategory($id) {
			$id = $this->escape_string($this->strip_all($id));

			$query = "delete from ".PREFIX."sub_category_master where id='".$id."'";
			$this->query($query);
			
		}
		
		// === SUB CATEGORY ENDS ===
		// Gallery Review 
		function updateGalleryContent($data){
			$id = $this->escape_string($this->strip_all($data['id']));
			$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a><center>";
			$description = $this->escape_string($this->strip_selected($data['description'],$allowTags));
			$title = $this->escape_string($this->strip_all($data['title']));
			$query = "update ".PREFIX."gallery_content set description='".$description."',title='".$title."' where id='".$id."'";
			$this->query($query);
		}

		function updateTermsCondition($data){
			$id = $this->escape_string($this->strip_all($data['id']));
			$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a><center>";
			$description = $this->escape_string($this->strip_selected($data['description'],$allowTags));
		
			$query = "update ".PREFIX."terms_n_conditions set description='".$description."' where id='".$id."'";
			$this->query($query);
		}


		function homeAllTitleChange($data){
			$content_id = $this->escape_string($this->strip_all($data['content_id']));
		
			$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a><center>";
			$chgtitle = $this->escape_string($this->strip_selected($data['chgtitle'] , $allowTags));
		
			$query = "update ".PREFIX."home_all_title_changes_tbl_link set head_title='".$chgtitle."' where content_id='".$content_id."'";

			//echo $query;exit;
			$this->query($query);
		}

		


		function addGallery($data,$file) {
			$display_order = $this->escape_string($this->strip_all($data['display_order']));
			$date = date("Y-m-d H:i:s");
			$SaveImage = new SaveImage();
			$imgDir = '../img/gallery/';
			if(isset($file['image_name']['name']) && !empty($file['image_name']['name'])){
				$file_name = strtolower( pathinfo($file['image_name']['name'], PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$cropData = $this->strip_all($data['cropData1']);
				$image_name = $SaveImage->uploadCroppedImageFileFromForm($file['image_name'], 699, $cropData, $imgDir, $file_name.'-'.time().'-1');
			} else {
				$image_name = '';
			}
			$query = "insert into ".PREFIX."gallery(image_name,display_order,created) values ('$image_name', '$display_order','$date')";
			return $this->query($query);
		}
		function updateGallery($data,$file) {
			$id = $this->escape_string($this->strip_all($data['id']));
			$display_order = $this->escape_string($this->strip_all($data['display_order']));
			$SaveImage = new SaveImage();
			$imgDir = '../img/gallery/';
			if(isset($file['image_name']['name']) && !empty($file['image_name']['name'])){
				$Detail = $this->getUniqueGalleryById($id);
				$this->unlinkImage("gallery", $Detail['image_name'], "large");
				$this->unlinkImage("gallery", $Detail['image_name'], "crop");
				$file_name = strtolower( pathinfo($file['image_name']['name'], PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$cropData = $this->strip_all($data['cropData1']);
				$image_name = $SaveImage->uploadCroppedImageFileFromForm($file['image_name'], 699, $cropData, $imgDir, $file_name.'-'.time().'-1');
				$this->query("update ".PREFIX."gallery set image_name='".$image_name."' where id='".$id."'");
			} 
			$query = "update ".PREFIX."gallery set display_order='".$display_order."' where id='".$id."'";
			return $this->query($query);
		} 
		function getUniqueGalleryById($id) {
			$id = $this->escape_string($this->strip_all($id));
			$query = "Select * from ".PREFIX."gallery where id='".$id."' ";
			return $this->fetch($this->query($query));
		}
		function deleteGallery($id) {
			$id = $this->escape_string($this->strip_all($id));
			$Detail = $this->getUniqueGalleryById($id);
			$imgDir = '../img/gallery/';
			$this->unlinkImage("gallery", $Detail['image_name'], "large");
			$this->unlinkImage("gallery", $Detail['image_name'], "crop");
			$query = "delete from ".PREFIX."gallery where id='$id'";
			$this->query($query);
			return true;
		}
		function addClientReview($data,$file) {
			//$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a><hr>";
			//$review = $this->escape_string($this->strip_selected($data['review'],$allowTags));
			$review =$this->escape_string($this->strip_all($data['review']));
			$name = $this->escape_string($this->strip_all($data['name']));
			$display_order = $this->escape_string($this->strip_all($data['display_order']));
			$date = date("Y-m-d H:i:s");
			$SaveImage = new SaveImage();
			$imgDir = '../img/';
			if(isset($file['image_name']['name']) && !empty($file['image_name']['name'])){
				$file_name = strtolower( pathinfo($file['image_name']['name'], PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$cropData = $this->strip_all($data['cropData1']);
				$image_name = $SaveImage->uploadCroppedImageFileFromForm($file['image_name'], 200, $cropData, $imgDir, $file_name.'-'.time().'-1');
			} else {
				$image_name = '';
			}
			$query = "insert into ".PREFIX."client_reviews(name,image_name,review,display_order,created) values ('$name', '$image_name','$review','$display_order','$date')";
			return $this->query($query);
		}
		function updateClientReview($data,$file) {
		//	$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a><hr>";
		//	$review = $this->escape_string($this->strip_selected($data['review'],$allowTags));
			$review =$this->escape_string($this->strip_all($data['review']));
			$id = $this->escape_string($this->strip_all($data['id']));
			$name = $this->escape_string($this->strip_all($data['name']));
			$display_order = $this->escape_string($this->strip_all($data['display_order']));
			$SaveImage = new SaveImage();
			$imgDir = '../img/';
			if(isset($file['image_name']['name']) && !empty($file['image_name']['name'])){
				$Detail = $this->getUniqueGalleryById($id);
				$this->unlinkImage("gallery", $Detail['image_name'], "large");
				$this->unlinkImage("gallery", $Detail['image_name'], "crop");
				$file_name = strtolower( pathinfo($file['image_name']['name'], PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$cropData = $this->strip_all($data['cropData1']);
				$image_name = $SaveImage->uploadCroppedImageFileFromForm($file['image_name'], 200, $cropData, $imgDir, $file_name.'-'.time().'-1');
				$this->query("update ".PREFIX."client_reviews set image_name='".$image_name."' where id='".$id."'");
			} 
			$query = "update ".PREFIX."client_reviews set name='".$name."',review='".$review."', display_order='".$display_order."' where id='".$id."'";
			return $this->query($query);
		} 
		function getUniqueClientReviewById($id){
			$id = $this->escape_string($this->strip_all($id));
			$query = "Select * from ".PREFIX."client_reviews where id='".$id."' ";
			return $this->fetch($this->query($query));
		}
		function deleteClientReviews($id) {
			$id = $this->escape_string($this->strip_all($id));
			$Detail = $this->getUniqueClientReviewById($id);
			$imgDir = '../img/';
			$this->unlinkImage("", $Detail['image_name'], "large");
			$this->unlinkImage("", $Detail['image_name'], "crop");
			$query = "delete from ".PREFIX."client_reviews where id='$id'";
			$this->query($query);
			return true;
		}
		
		// Gallery Review
		// Home Content
		function getUniqueHowWeDoById($id) {
			$id = $this->escape_string($this->strip_all($id));
			$query = "Select * from ".PREFIX."how_we_do where id='".$id."' ";
			return $this->fetch($this->query($query));
		}

		
		function updateHowWeDo($data,$file) {
			$id = $this->escape_string($this->strip_all($data['id']));
			$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a><hr>";
			$description = $this->escape_string($this->strip_selected($data['description'],$allowTags));
			$title = $this->escape_string($this->strip_all($data['title']));
			$display_order = $this->escape_string($this->strip_all($data['display_order']));
			$SaveImage = new SaveImage();
			$imgDir = '../img/';
			if(isset($file['image_name']['name']) && !empty($file['image_name']['name'])){
				$Detail = $this->getUniqueHowWeDoById($id);
				$this->unlinkImage("", $Detail['image_name'], "large");
				$this->unlinkImage("", $Detail['image_name'], "crop");
				$file_name = strtolower( pathinfo($file['image_name']['name'], PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$cropData = $this->strip_all($data['cropData1']);
				$image_name = $SaveImage->uploadCroppedImageFileFromForm($file['image_name'], 60, $cropData, $imgDir, $file_name.'-'.time().'-1');
				$this->query("update ".PREFIX."how_we_do set image_name='".$image_name."' where id='".$id."'");
			} 
			$query = "update ".PREFIX."how_we_do set title='".$title."',description='".$description."', display_order='".$display_order."' where id='".$id."'";
			return $this->query($query);
		}


		function getUniqueHomeCarouselById($id) {
			$id = $this->escape_string($this->strip_all($id));
			$query = "Select * from ".PREFIX."home_carousel where id='".$id."' ";
			return $this->fetch($this->query($query));
		}

		//undergraduate
		function getUndergraduateById($id) {
			$id = $this->escape_string($this->strip_all($id));
			$query = "Select * from ".PREFIX."undergraduate_images where id='".$id."' ";
			return $this->fetch($this->query($query));
		}

		//postgraduate
		function getPostgraduateById($id) {
			$id = $this->escape_string($this->strip_all($id));
			$query = "Select * from ".PREFIX."postgraduate_images where id='".$id."' ";
			return $this->fetch($this->query($query));
		}


		//Undergraduate
		function getUniqueUndergraduateImagesById($id) {
			$id = $this->escape_string($this->strip_all($id));
			$query = "Select * from ".PREFIX."undergraduate_images where id='".$id."' ";
			return $this->fetch($this->query($query));
		}

		// post unique id
		function getUniquePostgraduateImagesById($id) {
			$id = $this->escape_string($this->strip_all($id));
			$query = "Select * from ".PREFIX."postgraduate_images where id='".$id."' ";
			return $this->fetch($this->query($query));
		}

		//infra
		function getInfrastructureById($id) {
			$id = $this->escape_string($this->strip_all($id));
			$query = "Select * from ".PREFIX."infrastructure_images where id='".$id."' ";
			return $this->fetch($this->query($query));
		}
		

		//achivement
		function addHomeCarousel($data,$file) {
			// $title = $this->escape_string($this->strip_all($data['title']));
			// $sub_title = $this->escape_string($this->strip_all($data['sub_title']));
			$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a>";
$title = $this->escape_string($this->strip_selected($data['title'],$allowTags));

//$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a>";
$sub_title = $this->escape_string($this->strip_selected($data['sub_title'],$allowTags));
			//$link = $this->escape_string($this->strip_all($data['link']));
			$display_order = $this->escape_string($this->strip_all($data['display_order']));
			$date = date("Y-m-d H:i:s");
			$SaveImage = new SaveImage();
			$imgDir = '../img/achievements/';
			if(isset($file['image_name']['name']) && !empty($file['image_name']['name'])){
				$file_name = strtolower( pathinfo($file['image_name']['name'], PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$cropData = $this->strip_all($data['cropData1']);
				$image_name = $SaveImage->uploadCroppedImageFileFromForm($file['image_name'], 1280, $cropData, $imgDir, $file_name.'-'.time().'-1');
			} else {
				$image_name = '';
			}
			$query = "insert into ".PREFIX."home_carousel(title,sub_title,image_name,display_order,created) values ('$title','$sub_title','$image_name', '$display_order','$date')";
			return $this->query($query);
		}

		//add undergraduate
		function addUndergraduateImages($data,$file ){
			$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a>";
			$title = $this->escape_string($this->strip_selected($data['title'],$allowTags));

			$sub_title = $this->escape_string($this->strip_selected($data['sub_title'],$allowTags));
			// $link = $this->escape_string($this->strip_all($data['link']));
			$display_order = $this->escape_string($this->strip_all($data['display_order']));
			$date = date("Y-m-d H:i:s");
			$SaveImage = new SaveImage();
			$imgDir = '../img/Undergraduate/';
			if(isset($file['image_name']['name']) && !empty($file['image_name']['name'])){
				$file_name = strtolower( pathinfo($file['image_name']['name'], PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				
				$cropData = $this->strip_all($data['cropData1']);
				$image_name = $SaveImage->uploadCroppedImageFileFromForm($file['image_name'], 800 , $cropData, $imgDir, $file_name.'-'.time().'-1');
				// echo $image_name;exit();
			} else {
				$image_name = '';
			}
			$md5generatenumber =  $this->random_md5_string(5);

			$query = "insert into ".PREFIX."undergraduate_images(coruses_id,title,sub_title,undergraduate_image,created) values ('$md5generatenumber ','$title','$sub_title','$image_name','$date')";
	
			$this->query($query);

			//$lastInsertId =  $this->last_insert_id() ;
		
			
			$category = "insert into ".PREFIX."category(coruses_id,category,sub_category) values ('$md5generatenumber ','$title','UG')";

			 return $this->query($category);
		}


		function random_md5_string($length) {
			return substr(md5(time()), 0, $length);
		}

		//postgraduate
		function addPostgraduateImages($data,$file){
			$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a>";
            $title = $this->escape_string($this->strip_selected($data['title'],$allowTags));

            $sub_title = $this->escape_string($this->strip_selected($data['sub_title'],$allowTags));
			// $link = $this->escape_string($this->strip_all($data['link']));
			$display_order = $this->escape_string($this->strip_all($data['display_order']));
			$date = date("Y-m-d H:i:s");
			$SaveImage = new SaveImage();
			$imgDir = '../img/Postgraduate/';
			if(isset($file['image_name']['name']) && !empty($file['image_name']['name'])){
				$file_name = strtolower( pathinfo($file['image_name']['name'], PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				
				$cropData = $this->strip_all($data['cropData1']);
				$image_name = $SaveImage->uploadCroppedImageFileFromForm($file['image_name'], 800 , $cropData, $imgDir, $file_name.'-'.time().'-1');
				// echo $image_name;exit();
			} else {
				$image_name = '';
			}
			$md5generatenumber =  $this->random_md5_string(5);
			$query = "insert into ".PREFIX."postgraduate_images(coruses_id,title,sub_title,postgraduate_image,created) values ('$md5generatenumber','$title','$sub_title','$image_name', '$date')";

			$this->query($query);

			// $lastInsertId =  $this->last_insert_id() ;

			$category = "insert into ".PREFIX."category(coruses_id,category,sub_category) values ('$md5generatenumber ','$title','PG')";
		
			//$this->query($category);
			// $last_id = $conn->insert_id;
			return $this->query($category);
		}
		

		//Indra add
		function addInfrastructureImages($data,$file){
			$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a>";
$title = $this->escape_string($this->strip_selected($data['title'],$allowTags));

$sub_title = $this->escape_string($this->strip_selected($data['sub_title'],$allowTags));
			// $link = $this->escape_string($this->strip_all($data['link']));
			$display_order = $this->escape_string($this->strip_all($data['display_order']));
			$date = date("Y-m-d H:i:s");
			$SaveImage = new SaveImage();
			$imgDir = '../img/Infrastructure/';
			if(isset($file['image_name']['name']) && !empty($file['image_name']['name'])){
				$file_name = strtolower( pathinfo($file['image_name']['name'], PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				
				$cropData = $this->strip_all($data['cropData1']);
				$image_name = $SaveImage->uploadCroppedImageFileFromForm($file['image_name'], 1440, $cropData, $imgDir, $file_name.'-'.time().'-1');
				// echo $image_name;exit();
			} else {
				$image_name = '';
			}
			$query = "insert into ".PREFIX."infrastructure_images(title,sub_title,Infra_image,created) values ('$title','$sub_title','$image_name', '$date')";


			return $this->query($query);
		}
		


		function updateHomeCarousel($data,$file) {
			$id = $this->escape_string($this->strip_all($data['id']));
			$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a>";
$title = $this->escape_string($this->strip_selected($data['title'],$allowTags));

$sub_title = $this->escape_string($this->strip_selected($data['sub_title'],$allowTags));
			$link = $this->escape_string($this->strip_all($data['link']));
			$display_order = $this->escape_string($this->strip_all($data['display_order']));
			$SaveImage = new SaveImage();
			$imgDir = '../img/achievements/';
			if(isset($file['image_name']['name']) && !empty($file['image_name']['name'])){
				$Detail = $this->getUniqueHomeCarouselById($id);
				$this->unlinkImage("", $Detail['image_name'], "large");
				$this->unlinkImage("", $Detail['image_name'], "crop");
				$file_name = strtolower( pathinfo($file['image_name']['name'], PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$cropData = $this->strip_all($data['cropData1']);
				$image_name = $SaveImage->uploadCroppedImageFileFromForm($file['image_name'], 48, $cropData, $imgDir, $file_name.'-'.time().'-1');
				$this->query("update ".PREFIX."home_carousel set image_name='".$image_name."' where id='".$id."'");
			} 
			$query = "update ".PREFIX."home_carousel set title='".$title."',sub_title='".$sub_title."',display_order='".$display_order."' where id='".$id."'";
		//	$q1 = "update ".PREFIX."home_carousel set image_name='".$image_name."' where id='".$id."'";
			//echo  $query ;
			//echo  $q1 ;exit();
			return $this->query($query);
		} 


		//Undergraduate
		function updateUndergraduateImages($data,$file) {
			$id = $this->escape_string($this->strip_all($data['id']));
			$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a>";
$title = $this->escape_string($this->strip_selected($data['title'],$allowTags));

$sub_title = $this->escape_string($this->strip_selected($data['sub_title'],$allowTags));
			$link = $this->escape_string($this->strip_all($data['link']));
			$display_order = $this->escape_string($this->strip_all($data['display_order']));
			$SaveImage = new SaveImage();
			$imgDir = '../img/Undergraduate/';
			if(isset($file['image_name']['name']) && !empty($file['image_name']['name'])){
				$Detail = $this->getUndergraduateById($id);
				$this->unlinkImage("", $Detail['image_name'], "large");
				$this->unlinkImage("", $Detail['image_name'], "crop");
				$file_name = strtolower( pathinfo($file['image_name']['name'], PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$cropData = $this->strip_all($data['cropData1']);
				$image_name = $SaveImage->uploadCroppedImageFileFromForm($file['image_name'], 1280 , $cropData, $imgDir, $file_name.'-'.time().'-1');
				$this->query("update ".PREFIX."undergraduate_images set undergraduate_image='".$image_name."' where id='".$id."'");
				
					$category = "update ".PREFIX."category set category='".$title."', where coruses_id = '".$id."'  AND sub_category ='UG' ";
					$this->query($category);
			} 
			// $query = "update ".PREFIX."undergraduate_images set title='".$title."',sub_title='".$sub_title."',display_order='".$display_order."' where id='".$id."'";
			$query = "update ".PREFIX."undergraduate_images set title='".$title."',sub_title='".$sub_title."' where id='".$id."'";
			
			// $category2 = "update ".PREFIX."category` SET `category`='' WHERE 1" ;
			$category = "update ".PREFIX."category set category='".$title."'  where coruses_id = '".$id."' AND sub_category ='UG'";
			//echo $category;exit;
			$this->query($category);
			return $this->query($query);

			
		} 


		//postgraduate
		function updatePostgraduateImages($data,$file) {
			$id = $this->escape_string($this->strip_all($data['id']));
			$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a>";
$title = $this->escape_string($this->strip_selected($data['title'],$allowTags));

$sub_title = $this->escape_string($this->strip_selected($data['sub_title'],$allowTags));
			$link = $this->escape_string($this->strip_all($data['link']));
			$display_order = $this->escape_string($this->strip_all($data['display_order']));
			$SaveImage = new SaveImage();
			$imgDir = '../img/Postgraduate/';
			if(isset($file['image_name']['name']) && !empty($file['image_name']['name'])){
				$Detail = $this->getPostgraduateById($id);
				$this->unlinkImage("", $Detail['postgraduate_image'], "large");
				$this->unlinkImage("", $Detail['postgraduate_image'], "crop");
				$file_name = strtolower( pathinfo($file['image_name']['name'], PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$cropData = $this->strip_all($data['cropData1']);
				$image_name = $SaveImage->uploadCroppedImageFileFromForm($file['image_name'], 800 , $cropData, $imgDir, $file_name.'-'.time().'-1');
				$this->query("update ".PREFIX."postgraduate_images set image_name='".$image_name."' ,title='".$title."',sub_title='".$sub_title."'where id='".$id."'");

				$this->query("update ".PREFIX."category set category='".$title."'  where coruses_id = '".$id."'");
			} 
			// $query = "update ".PREFIX."postgraduate_images set title='".$title."' ,sub_title='".$sub_title."',display_order='".$display_order."' where id='".$id."'";
			$query = "update ".PREFIX."postgraduate_images set title='".$title."' ,sub_title='".$sub_title."' where id='".$id."'";

			$category = "update ".PREFIX."category set category='".$title."'  where coruses_id = '".$id."' AND sub_category ='PG'";
			//echo $category;exit;
			$this->query($category);
			return $this->query($query);
		} 

		//infra updated
		function updateInfrastructureImages($data,$file) {
			$id = $this->escape_string($this->strip_all($data['id']));
			$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a>";
			$title = $this->escape_string($this->strip_selected($data['title'],$allowTags));

			$sub_title = $this->escape_string($this->strip_selected($data['sub_title'],$allowTags));
			$link = $this->escape_string($this->strip_all($data['link']));
			$display_order = $this->escape_string($this->strip_all($data['display_order']));
			$SaveImage = new SaveImage();
			$imgDir = '../img/Infrastructure/';
			if(isset($file['image_name']['name']) && !empty($file['image_name']['name'])){
				$Detail = $this->getPostgraduateById($id);
				$this->unlinkImage("", $Detail['Infra_image'], "large");
				$this->unlinkImage("", $Detail['Infra_image'], "crop");
				$file_name = strtolower( pathinfo($file['image_name']['name'], PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$cropData = $this->strip_all($data['cropData1']);
				$image_name = $SaveImage->uploadCroppedImageFileFromForm($file['image_name'], 1440, $cropData, $imgDir, $file_name.'-'.time().'-1');
				$this->query("update ".PREFIX."infrastructure_images set Infra_image='".$image_name."',title='".$title."',sub_title='".$sub_title."' where id='".$id."'");
			} 
			// $query = "update ".PREFIX."infrastructure_images set title='".$title."',sub_title='".$sub_title."',display_order='".$display_order."' where id='".$id."'";
			$query = "update ".PREFIX."infrastructure_images set title='".$title."',sub_title='".$sub_title."' where id='".$id."'";

			return $this->query($query);
		} 

		function deleteHomeCarousel($id) {
			$id = $this->escape_string($this->strip_all($id));
			$Detail = $this->getUniqueHomeCarouselById($id);
			$imgDir = '../img/';
			$this->unlinkImage("", $Detail['image_name'], "large");
			$this->unlinkImage("", $Detail['image_name'], "crop");
			$query = "delete from ".PREFIX."home_carousel where id='$id'";
			$this->query($query);
			return true;
		}


		//delete undergraduate
		function deleteUndergraduateCourses($id) {
			$id = $this->escape_string($this->strip_all($id));
			$Detail = $this->getUniqueUndergraduateImagesById($id);
			// print_r($Detail);exit();category='".$title."'  where coruses_id = '".$id."'
			$imgDir = '../img/Undergraduate/';
			$this->unlinkImage("", $Detail['undergraduate_image'], "large");
			$this->unlinkImage("", $Detail['undergraduate_image'], "crop");
			$query = "delete from ".PREFIX."undergraduate_images where id='$id'  ";
			$category = "delete from ".PREFIX."category  where  coruses_id = '".$Detail['coruses_id']."' AND sub_category ='UG'";
			// echo $category;exit;
			$this->query($category);
			$this->query($query);
			return true;
		}

		//delete postgradute
		function deletePostgraduateCourses($id) {
			$id = $this->escape_string($this->strip_all($id));
			$Detail = $this->getUniquePostgraduateImagesById($id);
			// print_r($Detail);exit();
			$imgDir = '../img/Postgraduate/';
			$this->unlinkImage("", $Detail['postgraduate_image'], "large");
			$this->unlinkImage("", $Detail['postgraduate_image'], "crop");
			$query = "delete from ".PREFIX."postgraduate_images where id='$id' ";
			$category = "delete from ".PREFIX."category  where  coruses_id = '".$Detail['coruses_id']."' AND sub_category ='PG'";
			$this->query($category);	
			$this->query($query);
			return true;
		}

		function deleteInfrastructure($id) {
			$id = $this->escape_string($this->strip_all($id));
			$Detail = $this->getInfrastructureById($id);
			// print_r($Detail);exit();
			$imgDir = '../img/Infrastructure';
			$this->unlinkImage("", $Detail['Infra_image'], "large");
			$this->unlinkImage("", $Detail['Infra_image'], "crop");
			$query = "delete from ".PREFIX."infrastructure_images where id='$id'";
			$this->query($query);
			return true;
		}


		

		function updateAboutUs($data, $file){
			$id = $this->escape_string($this->strip_all($data['id']));
			$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a>";
			$description = $this->escape_string($this->strip_selected($data['description'],$allowTags));
			// $link = $this->escape_string($this->strip_all($data['video_link']));
			$image = $this->getImageForAboutUs($id);
			$SaveImage = new SaveImage();
			$imgDir = '../img/aboutus/';
			if(isset($file['thumbnail']['name']) && !empty($file['thumbnail']['name'])){
				$imageName = str_replace( " ", "-", $file['thumbnail']['name'] );
				$file_name = strtolower( pathinfo($imageName, PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$cropData = $this->strip_all($data['cropData1']);
				$image_name = $SaveImage->uploadCroppedImageFileFromForm($file['thumbnail'], 800, $cropData, $imgDir, $file_name.'-'.time().'-1');
			} else {
				$image_name = $image ;
			}
			//echo $image_name;exit;
			$query = "update ".PREFIX."gallery_content set description='".$description."', image = '".$image_name."' where id='".$id."'";
			

			$this->query($query);
		}


		//logo
		function updateLogo($data, $file){
			$id = $this->escape_string($this->strip_all($data['id']));
			$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a>";
			$description = $this->escape_string($this->strip_selected($data['description'],$allowTags));
			// $link = $this->escape_string($this->strip_all($data['video_link']));
			$image = $this->getImageForLogo($id);
			$arrPervImage = explode("__",$image);
			$logo = $arrPervImage[0];
			$banner = $arrPervImage[1];
			
			$SaveImage = new SaveImage();
			$imgDir = '../img/collegelogo/';
			if(isset($file['college_logo']['name']) && !empty($file['college_logo']['name'])){
				$imageName = str_replace( " ", "-", $file['college_logo']['name'] );
				$file_name = strtolower( pathinfo($imageName, PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$cropData = $this->strip_all($data['cropData1']);
				$image_name = $SaveImage->uploadCroppedImageFileFromForm($file['college_logo'], 800, $cropData, $imgDir, $file_name.'-'.time().'-1');
			} else {
				$image_name = $logo ;
			}


			//banner
			$imgDirBanner = '../img/collegelogo/';
			if(isset($file['college_banner']['name']) && !empty($file['college_banner']['name'])){
				$imageName_B = str_replace( " ", "-", $file['college_banner']['name'] );
				$file_name_B = strtolower( pathinfo($imageName_B, PATHINFO_FILENAME));
				$file_name_B = $this->getValidatedPermalink($file_name_B);
				$cropData_B = $this->strip_all($data['cropData1']);
				$image_name_B = $SaveImage->uploadCroppedImageFileFromForm($file['college_banner'], 800, $cropData_B, $imgDirBanner, $file_name_B.'-'.time().'-1');
			} else {
				$image_name_B = $banner ;
			}

			
			$query = "update ".PREFIX."header_college_logo set college_logo='".$image_name."', college_banner = '".$image_name_B."' where id='".$id."'";
			
			//echo $query;exit;
			$this->query($query);
		}

		function getImageForAboutUs($id){
			$query = "select * from  ".PREFIX."gallery_content  where id='".$id."'";
			$image = $this->query($query);
			$dbImage;
			while($row = $this->fetch($image)){
					$dbImage = $row['image'];
			}
			return $dbImage;
		}

		//logo
		function getImageForLogo($id){
			$query = "select * from  ".PREFIX."header_college_logo  where id='".$id."'";
			$image = $this->query($query);
			$imageLogo;
			$imageBanner;
			while($row = $this->fetch($image)){
					$imageLogo = $row['college_logo'];
					$imageBanner = $row['college_banner'];
			}
			return $imageLogo."__".$imageBanner;
		}

		
		function updateHomeDetailingContent($data){
			$id = $this->escape_string($this->strip_all($data['id']));
			$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a>";
			$description = $this->escape_string($this->strip_selected($data['detailing'],$allowTags));
			
			$query = "update ".PREFIX."gallery_content set description='".$description."' where id='".$id."'";
			$this->query($query);
		}
		
		

		//Home Content Other Coursers
			//add Other
		function addOtherImages($data,$file){
			// $title = $this->escape_string($this->strip_all($data['title']));
			// $sub_title = $this->escape_string($this->strip_all($data['sub_title']));
			$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a>";
            $title = $this->escape_string($this->strip_selected($data['title'],$allowTags));

            $sub_title = $this->escape_string($this->strip_selected($data['sub_title'],$allowTags));
			// $link = $this->escape_string($this->strip_all($data['link']));
			$display_order = $this->escape_string($this->strip_all($data['display_order']));
			$date = date("Y-m-d H:i:s");
			$SaveImage = new SaveImage();
			$imgDir = '../img/Other/';
			if(isset($file['image_name']['name']) && !empty($file['image_name']['name'])){
				$file_name = strtolower( pathinfo($file['image_name']['name'], PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				
				$cropData = $this->strip_all($data['cropData1']);
				$image_name = $SaveImage->uploadCroppedImageFileFromForm($file['image_name'], 800 , $cropData, $imgDir, $file_name.'-'.time().'-1');
				// echo $image_name;exit();
			} else {
				$image_name = '';
			}
			$md5generatenumber =  $this->random_md5_string(5);

			$query = "insert into ".PREFIX."other_images(coruses_id,title,sub_title,other_image,created) values ('$md5generatenumber','$title','$sub_title','$image_name','$date')";
	
			$this->query($query);

			// $lastInsertId =  $this->last_insert_id() ;
		
			$category = "insert into ".PREFIX."category(coruses_id,category,sub_category) values ('$md5generatenumber ','$title','Other')";

			return $this->query($category);
		}
	
	
	
	
		function updateOtherImages($data,$file) {
				$id = $this->escape_string($this->strip_all($data['id']));
				$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a>";
$title = $this->escape_string($this->strip_selected($data['title'],$allowTags));

$sub_title = $this->escape_string($this->strip_selected($data['sub_title'],$allowTags));
				//$link = $this->escape_string($this->strip_all($data['link']));
			//	$display_order = $this->escape_string($this->strip_all($data['display_order']));
				$SaveImage = new SaveImage();
				$imgDir = '../img/Other/';
				if(isset($file['image_name']['name']) && !empty($file['image_name']['name'])){
					$Detail = $this->getOtherById($id);
					$this->unlinkImage("", $Detail['image_name'], "large");
					$this->unlinkImage("", $Detail['image_name'], "crop");
					$file_name = strtolower( pathinfo($file['image_name']['name'], PATHINFO_FILENAME));
					$file_name = $this->getValidatedPermalink($file_name);
					$cropData = $this->strip_all($data['cropData1']);
					$image_name = $SaveImage->uploadCroppedImageFileFromForm($file['image_name'], 1280 , $cropData, $imgDir, $file_name.'-'.time().'-1');
					$this->query("update ".PREFIX."Other_images set Other_image='".$image_name."' where id='".$id."'");
					
						$category = "update ".PREFIX."category set category='".$title."', where coruses_id = '".$id."'  AND sub_category ='Other' ";
						$this->query($category);
				} 
				// $query = "update ".PREFIX."other_images set title='".$title."',sub_title='".$sub_title."',display_order='".$display_order."' where id='".$id."'";
				$query = "update ".PREFIX."other_images set title='".$title."',sub_title='".$sub_title."' where id='".$id."'";
	
				// $category2 = "update ".PREFIX."category` SET `category`='' WHERE 1" ;
				$category = "update ".PREFIX."category set category='".$title."'  where coruses_id = '".$id."' AND sub_category ='Other'";
				//echo $category;exit;
				$this->query($category);
				return $this->query($query);
	
				
			} 
	
	
			function getUniqueOtherImagesById($id) {
				$id = $this->escape_string($this->strip_all($id));
				$query = "Select * from ".PREFIX."other_images where id='".$id."' ";
				return $this->fetch($this->query($query));
			}
	
	
			function deleteOtherCourses($id) {
				$id = $this->escape_string($this->strip_all($id));
				$Detail = $this->getUniqueOtherImagesById($id);
				// print_r($Detail);exit();category='".$title."'  where coruses_id = '".$id."'
				$imgDir = '../img/Other/';
				$this->unlinkImage("", $Detail['other_image'], "large");
				$this->unlinkImage("", $Detail['other_image'], "crop");
				$query = "delete from ".PREFIX."other_images where id='$id'  ";
				$category = "delete from ".PREFIX."category  where  coruses_id = '".$Detail['coruses_id']."' AND sub_category ='Other'";
				$this->query($category);
				$this->query($query);
				return true;
			}
		//Home Content Other Coruses

		// Home Content
		// === Contact Us === 
		
		function updateContactUsPage($data){
			$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a><hr>";
			$registered_office = $this->escape_string($this->strip_selected($data['registered_office'],$allowTags));
			$workshop = $this->escape_string($this->strip_selected($data['workshop'],$allowTags));
			$phone = $this->escape_string($this->strip_all($data['phone']));
			$email = $this->escape_string($this->strip_all($data['email']));
			$map_link = $this->escape_string($this->strip_all($data['map_link']));
			
			
			$query = "update ".PREFIX."contactus set phone='".$phone."', email='".$email."',map_link='".$map_link."',registered_office='".$registered_office."',workshop='".$workshop."'";
			$this->query($query);
			
		}
		function deleteContactForm($id) {
			$id = $this->escape_string($this->strip_all($id));
			$query = "delete from ".PREFIX."contact_form where id='$id'";
			$this->query($query);
			return true;
		}
		// Social Links
		function updateSocialLinks($data){
			$facebook = $this->escape_string($this->strip_all($data['facebook']));
			$twitter = $this->escape_string($this->strip_all($data['twitter']));
			$linkedIn = $this->escape_string($this->strip_all($data['linkedIn']));
			$youtube = $this->escape_string($this->strip_all($data['youtube']));
			$query = "update ".PREFIX."footer set facebook='".$facebook."',twitter='".$twitter."',linkedIn='".$linkedIn."',youtube='".$youtube."' ";
			return $this->query($query);
		}
		
		// Social Links
		
		/** * Function to update FAQ section */
		function updateFAQs($data){
			$this->deleteAllFAQs();
			if(sizeof($data['category'])>0) {
				$j=0;
				foreach($data['category'] as $key=>$value) {
					if($data['category'][$key]!=''){
						$category = $this->escape_string($this->strip_all($data['category'][$key]));
						$question = $this->escape_string($this->strip_all($data['question'][$key]));
						$answer = $this->escape_string($this->strip_all($data['answer'][$key]));
						$display_order = $this->escape_string($this->strip_all($data['display_order'][$key]));
						$this->query("insert into ".PREFIX."faqs (category, question, answer, display_order) values ('".$category."','".$question."','".$answer."','".$display_order."')");
						$j++;
					}
				}
			}
		}

		/** * Function to delete all questions and answers of FAQ section */
		function deleteAllFAQs(){
			return $this->query("truncate table ".PREFIX."faqs");
		}

		function getFAQs(){
			return $this->query("select * from ".PREFIX."faqs order by id DESC");
		}

		// === DISCOUNT COUPON STARTS ===
		function getAllDiscountCoupons() {
			$query = "select * from ".PREFIX."discount_coupon_master";
			$sql = $this->query($query);
			return $sql;
		}

		function getUniqueDiscountCouponById($id) {
			$id = $this->escape_string($this->strip_all($id));
			$query = "select * from ".PREFIX."discount_coupon_master where id='$id'";
			$sql = $this->query($query);
			return $this->fetch($sql);
		}

		function addDiscountCoupon($data) {
			$coupon_code = $this->escape_string($this->strip_all($data['coupon_code']));
			$coupon_type = $this->escape_string($this->strip_all($data['coupon_type']));
			$coupon_value = $this->escape_string($this->strip_all($data['coupon_value']));
			$valid_from = $this->escape_string($this->strip_all($data['valid_from']));
			$valid_to = $this->escape_string($this->strip_all($data['valid_to']));
			$coupon_usage = $this->escape_string($this->strip_all($data['coupon_usage']));
			$minimum_purchase_amount = $this->escape_string($this->strip_all($data['minimum_purchase_amount']));
			$special_coupon = $this->escape_string($this->strip_all($data['special_coupon']));
			$active = $this->escape_string($this->strip_all($data['active']));

			$query = "insert into ".PREFIX."discount_coupon_master (coupon_code, coupon_type, coupon_value, valid_from, valid_to, coupon_usage, minimum_purchase_amount, special_coupon, active) values ('$coupon_code', '$coupon_type', '$coupon_value', '$valid_from', '$valid_to', '$coupon_usage', '$minimum_purchase_amount', '$special_coupon', '$active')";
			return $this->query($query);
		}

		function updateDiscountCoupon($data) {
			$coupon_code = $this->escape_string($this->strip_all($data['coupon_code']));
			$coupon_type = $this->escape_string($this->strip_all($data['coupon_type']));
			$coupon_value = $this->escape_string($this->strip_all($data['coupon_value']));
			$valid_from = $this->escape_string($this->strip_all($data['valid_from']));
			$valid_to = $this->escape_string($this->strip_all($data['valid_to']));
			$coupon_usage = $this->escape_string($this->strip_all($data['coupon_usage']));
			$minimum_purchase_amount = $this->escape_string($this->strip_all($data['minimum_purchase_amount']));
			$special_coupon = $this->escape_string($this->strip_all($data['special_coupon']));
			$active = $this->escape_string($this->strip_all($data['active']));
			$id = $this->escape_string($this->strip_all($data['id']));

			$query = "update ".PREFIX."discount_coupon_master set coupon_code='$coupon_code', coupon_type='$coupon_type', coupon_value='$coupon_value', valid_from='$valid_from', valid_to='$valid_to', coupon_usage='$coupon_usage', minimum_purchase_amount='$minimum_purchase_amount', special_coupon='$special_coupon', active='$active' where id='$id'";
			return $this->query($query);
		}

		function deleteDiscountCoupon($id) {
			$id = $this->escape_string($this->strip_all($id));
			$query = "delete from ".PREFIX."discount_coupon_master where id='$id'";
			$this->query($query);
			return true;
		}

		// === Contact Us End ===
		
		/*===================== Vendor Subscription Start =====================*/
		
		/** * Function to get unique subscription details */
		function getUniqueSubscriptionById($id) {
			$id 	= $this->escape_string($this->strip_all($id));
			$query 	= "select * from ".PREFIX."subscription_master where id='".$id."'";
			$sql 	= $this->query($query);
			return $this->fetch($sql);
		}
		
		/** * Function to get all subscriptions with details */
		function getAllSubscriptions() {
			$query 	= "select * from ".PREFIX."subscription_master";
			return $this->query($query);
		}
		
		/** * Function to get all subscription features */
		function getAllSubscriptionFeatures() {
			$query 	= "select * from ".PREFIX."subscription_features_master";
			return $this->query($query);
		}
		
		/** * Function to get all active subscriptions with details */
		function getAllActiveSubscriptions() {
			$query 	= "select * from ".PREFIX."subscription_master where active = 'Yes'";
			return $this->query($query);
		}
		
		/** * Function to add new subscription details */
		function addSubscription($data){
			$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a><hr>";
			$category           = $this->escape_string($this->strip_all($data['category']));
			$package_name 		= $this->escape_string($this->strip_all($data['package_name']));
			//$duration 	        = $this->escape_string($this->strip_all($data['validity_period']));
			//$validity_period    = $duration*60;
			$package_price	 	= $this->escape_string($this->strip_all($data['package_price']));
			$active 			= $this->escape_string($this->strip_all($data['active']));			
			$interior_feature   = $this->escape_string($this->strip_selected($data['interior_feature'],$allowTags));
			$exterior_feature   = $this->escape_string($this->strip_selected($data['exterior_feature'],$allowTags));
			$engine_bay_feature   = $this->escape_string($this->strip_selected($data['engine_bay_feature'],$allowTags));
			$duration_from   = $this->escape_string($this->strip_all($data['duration_from']));
			$duration_to   = $this->escape_string($this->strip_all($data['duration_to']));

			if(empty($package_price)){
				$package_price	= 0;
			}
			
			$replace_keywords 	= array("-:-", "-:", ":-", " : ", " :", ": ", ":",
				"-@-", "-@", "@-", " @ ", " @", "@ ", "@", 
				"-.-", "-.", ".-", " . ", " .", ". ", ".", 
				"-\\-", "-\\", "\\-", " \\ ", " \\", "\\ ", "\\",
				"-/-", "-/", "/-", " / ", " /", "/ ", "/", 
				"-&-", "-&", "&-", " & ", " &", "& ", "&", 
				"-,-", "-,", ",-", " , ", " ,", ", ", ",", 
				" ",
				"---", "--", " - ", " -", "- ",
				"-#-", "-#", "#-", " # ", " #", "# ", "#",
				"-$-", "-$", "$-", " $ ", " $", "$ ", "$",
				"-%-", "-%", "%-", " % ", " %", "% ", "%",
				"-^-", "-^", "^-", " ^ ", " ^", "^ ", "^",
				"-*-", "-*", "*-", " * ", " *", "* ", "*",
				"-(-", "-(", "(-", " ( ", " (", "( ", "(",
				"-)-", "-)", ")-", " ) ", " )", ") ", ")",
				"-!-", "-!", "!-", " ! ", " !", "! ", "!");
			$menu_names			= str_replace($replace_keywords,'-',$package_name); 
			$permalink			= strtolower($menu_names);
			
			$query = "insert into ".PREFIX."subscription_master(category, package_name, package_price, interior_feature, exterior_feature, engine_bay_feature, permalink, active, duration_from, duration_to) values ('".$category."','".$package_name."', '".$package_price."','".$interior_feature."', '".$exterior_feature."', '".$engine_bay_feature."', '".$permalink."', '".$active."', '".$duration_from."', '".$duration_to."')";
			return $this->query($query);
		}
		
		/** * Function to update existing subscription details */
		function updateSubscription($data) {
			$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a><hr>";
			$id 				= $this->escape_string($this->strip_all($data['id']));			
			$category           = $this->escape_string($this->strip_all($data['category']));
			$package_name 		= $this->escape_string($this->strip_all($data['package_name']));
			//$duration 	        = $this->escape_string($this->strip_all($data['validity_period']));
			//$validity_period    = $duration * 60;
			$package_price	 	= $this->escape_string($this->strip_all($data['package_price']));
			$active 			= $this->escape_string($this->strip_all($data['active']));
			$interior_feature   = $this->escape_string($this->strip_selected($data['interior_feature'],$allowTags));
			$exterior_feature   = $this->escape_string($this->strip_selected($data['exterior_feature'],$allowTags));
			$engine_bay_feature   = $this->escape_string($this->strip_selected($data['engine_bay_feature'],$allowTags));
			$duration_from   = $this->escape_string($this->strip_all($data['duration_from'])) * 60;
			$duration_to   = $this->escape_string($this->strip_all($data['duration_to'])) * 60;
			
			if(empty($package_price)){
				$package_price	= 0;
			}
			
			$replace_keywords 	= array("-:-", "-:", ":-", " : ", " :", ": ", ":",
				"-@-", "-@", "@-", " @ ", " @", "@ ", "@", 
				"-.-", "-.", ".-", " . ", " .", ". ", ".", 
				"-\\-", "-\\", "\\-", " \\ ", " \\", "\\ ", "\\",
				"-/-", "-/", "/-", " / ", " /", "/ ", "/", 
				"-&-", "-&", "&-", " & ", " &", "& ", "&", 
				"-,-", "-,", ",-", " , ", " ,", ", ", ",", 
				" ",
				"---", "--", " - ", " -", "- ",
				"-#-", "-#", "#-", " # ", " #", "# ", "#",
				"-$-", "-$", "$-", " $ ", " $", "$ ", "$",
				"-%-", "-%", "%-", " % ", " %", "% ", "%",
				"-^-", "-^", "^-", " ^ ", " ^", "^ ", "^",
				"-*-", "-*", "*-", " * ", " *", "* ", "*",
				"-(-", "-(", "(-", " ( ", " (", "( ", "(",
				"-)-", "-)", ")-", " ) ", " )", ") ", ")",
				"-!-", "-!", "!-", " ! ", " !", "! ", "!");
			$menu_names			= str_replace($replace_keywords,'-',$package_name); 
			$permalink			= strtolower($menu_names);
			//validity_period='".$validity_period."',
			$query = "update ".PREFIX."subscription_master set category = '".$category."', package_name='".$package_name."', package_price='".$package_price."',interior_feature='".$interior_feature."', exterior_feature='".$exterior_feature."', engine_bay_feature='".$engine_bay_feature."', permalink='".$permalink."', active='".$active."', duration_from='".$duration_from."', duration_to='".$duration_to."' where id='".$id."'";
			return $this->query($query);
		}
		
		//get unique subscription feature by id
		function getUniqueSubscriptionFeatureById($id) {
			$id 	= $this->escape_string($this->strip_all($id));
			$query 	= "select * from ".PREFIX."subscription_features_master where id='".$id."'";
			$sql 	= $this->query($query);
			return $this->fetch($sql);
		}

		//delete unqiue subscription feature by id
		function deleteSubscriptionFeature($id) {
			$id = $this->escape_string($this->strip_all($id));
			
			$query = "delete from ".PREFIX."subscription_features_master where id='".$id."'";
			return $this->query($query);
		}

		/** * Function to add new subscription details */
		function updateSubscriptionFeatures($data){
			$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a><hr>";
			$category = $this->escape_string($this->strip_all($data['category']));
			$package_name = $this->escape_string($this->strip_all($data['package_name']));
			$feature_category = $this->escape_string($this->strip_all($data['feature_category']));
			$feature = $this->escape_string($this->strip_selected($data['feature'],$allowTags));
			$id = $this->escape_string($this->strip_all($data['id']));
			//echo "UPDATE ".PREFIX."subscription_features_master SET category = '".$category."', package_name = '".$package_name."', feature_category = '".$feature_category."', feature = '".$feature."' where id = '".$id."'";exit;
			$query = "UPDATE ".PREFIX."subscription_features_master SET category = '".$category."', package_name = '".$package_name."', feature_category = '".$feature_category."', feature = '".$feature."' where id = '".$id."'";
			return $this->query($query);

		}
		
		/** * Function to delete existing subscription details */
		function deleteSubscription($id) {
			$id = $this->escape_string($this->strip_all($id));
			
			$query = "delete from ".PREFIX."subscription_master where id='".$id."'";
			return $this->query($query);
		}
		
		function addSubscriptionFeatures($data){
			//print_r($data);exit;
			$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a><hr>";
			$category = $this->escape_string($this->strip_all($data['category']));
			$package_name = $this->escape_string($this->strip_all($data['package_name']));
			$feature_category = $this->escape_string($this->strip_all($data['feature_category']));
			$feature = $this->escape_string($this->strip_selected($data['feature'],$allowTags));
			
			$query = "INSERT INTO ".PREFIX."subscription_features_master (category, package_name, feature_category, feature) value('".$category."', '".$package_name."', '".$feature_category."', '".$feature."')";
			//echo $query;exit;
			return $this->query($query);
		}

		function addQuickwashDetails($data, $file){
			$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a><hr>";
			$category = $this->escape_string($this->strip_all($data['category']));
			$time = $this->escape_string($this->strip_all($data['timemins']));
			$main_features = $this->escape_string($this->strip_selected($data['main_feature'], $allowTags));
			$interior_feature = $this->escape_string($this->strip_selected($data['interior_feature'], $allowTags));
			$exterior_feature = $this->escape_string($this->strip_selected($data['exterior_feature'], $allowTags));
			$price = $this->escape_string($this->strip_all($data['price']));
			//$image = $this->escape_string($this->strip_all($file['image']));

			$SaveImage = new SaveImage();
			$imgDir = '../img/quick-wash/';
			if(isset($file['image_name']['name']) && !empty($file['image_name']['name'])){
				$file_name = strtolower( pathinfo($file['image_name']['name'], PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$cropData = $this->strip_all($data['cropData1']);
				$image_name = $SaveImage->uploadCroppedImageFileFromForm($file['image_name'], 454, $cropData, $imgDir, $file_name.'-'.time().'-1');
			} else {
				$image_name = '';
			}

			$query = "INSERT INTO ".PREFIX."quick_wash_master (category, time, main_features, interior_feature, exterior_feature, price, image) value('".$category."', '".$time."', '".$main_features."', '".$interior_feature."', '".$exterior_feature."', '".$price."', '".$image_name."')";
			return $this->query($query);
		}
		
		function getUniqueQuickWashById($id){
			$id = $this->escape_string($this->strip_all($id));
			$query = "SELECT * FROM ".PREFIX."quick_wash_master WHERE id='".$id."'";
			return $this->fetch($this->query($query));
		}
		
		function updateQuickWash($data, $file){
			$id = $this->escape_string($this->strip_all($data['id']));
			$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a><hr>";
			$category = $this->escape_string($this->strip_all($data['category']));
			$time = $this->escape_string($this->strip_all($data['timemins']));
			$main_features = $this->escape_string($this->strip_selected($data['main_feature'], $allowTags));
			$interior_feature = $this->escape_string($this->strip_selected($data['interior_feature'], $allowTags));
			$exterior_feature = $this->escape_string($this->strip_selected($data['exterior_feature'], $allowTags));
			$price = $this->escape_string($this->strip_all($data['price']));

			$SaveImage = new SaveImage();
			$imgDir = '../img/quick-wash/';
			if(isset($file['image_name']['name']) && !empty($file['image_name']['name'])){
				$file_name = strtolower( pathinfo($file['image_name']['name'], PATHINFO_FILENAME));
				$file_name = $this->getValidatedPermalink($file_name);
				$Detail = $this->getUniqueQuickWashById($id);
				$this->unlinkImage("", $Detail['banner_img'], "large");
				$this->unlinkImage("", $Detail['banner_img'], "crop");
				$cropData = $this->strip_all($data['cropData1']);
				$image_name = $SaveImage->uploadCroppedImageFileFromForm($file['image_name'], 454, $cropData, $imgDir, $file_name.'-'.time().'-1');
			} else {
				$image_name = '';
			}

			$query = "UPDATE ".PREFIX."quick_wash_master SET category = '".$category."', time = '".$time."', main_features = '".$main_features."', interior_feature = '".$interior_feature."', exterior_feature = '".$exterior_feature."', price = '".$price."'";
		}

		function deleteQuickWashById($id){
			$id = $this->escape_string($this->strip_all($id));

			$query = "delete from ".PREFIX."quick_wash_master where id='".$id."'";
			$this->query($query);
		}
		/*===================== Vendor Subscription End =====================*/	
		
		

		/*===================== For all vision,mission,goal =====================*/	
		function addForAll($data, $file , $type , $category){
			$course_id =  $_SESSION["course_id"] ;
			$course_name =  $_SESSION["course_name"] ;
			
			$id = $this->escape_string($this->strip_all($data['id']));
			$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a>";
			$description = '';
			// $link = $this->escape_string($this->strip_all($data['video_link']));
			if($type == 'addvision'){
				$description = $this->escape_string($this->strip_selected($data['vision'],$allowTags));
				$tblname1 = 'ourvision';
			}else if($type == 'addmission'){
				$description = $this->escape_string($this->strip_selected($data['mission'],$allowTags));
				$tblname1 = 'ourmission';
			}elseif($type == "addgoal"){
				$description = $this->escape_string($this->strip_selected($data['goal'],$allowTags));
				$tblname1 = 'ourgoal';
			}else{
				// //updategoal 
				// $description = $this->escape_string($this->strip_selected($data['description2'],$allowTags));
				// $tblname = 'ourgoal';
			}

		
		    //insert opreations 	
			$query ="INSERT INTO ".PREFIX.$tblname1." (`coruses_id`, `courses_name`, `description`, `courses_category`) 
			           VALUES ('$course_id','$course_name','$description','$category')";
					 //  echo $query;exit;
			$this->query($query);
		}


		function updateForAll($data, $file , $type , $category){
			$id = $this->escape_string($this->strip_all($data['id']));
			$allowTags = "<strong><em><b><p><u><ul><li><ol><s><sub><sup><h1><img><h2><h3><h4><h5><h6><div><i><span><br><table><tr><th><td><thead><tbody><a>";
			$description = '';
			// $link = $this->escape_string($this->strip_all($data['video_link']));
			if($type == 'updatevision'){
				$description = $this->escape_string($this->strip_selected($data['vision'],$allowTags));
				$tblname2 = 'ourvision';
			}else if($type == 'updatemission'){
				$description = $this->escape_string($this->strip_selected($data['mission'],$allowTags));
				$tblname2 = 'ourmission';
			}elseif($type == "updategoal"){
				$description = $this->escape_string($this->strip_selected($data['goal'],$allowTags));
				$tblname2 = 'ourgoal';
			}else{
				//updategoal 
				// $description = $this->escape_string($this->strip_selected($data['description2'],$allowTags));
				// $tblname = 'ourgoal';
			}

			
			
			$query = "update ".PREFIX.$tblname2." set description='".$description."' where id='".$id."' AND courses_category = '".$category."'";
			$this->query($query);
		}


        function getUniqueAllById($id , $type, $category) {
			$id = $this->escape_string($this->strip_all($id));

            $tblname;
			if($type == 'getvision'){
				$tblname3 = 'ourvision';
			}else if($type == 'getmission'){
				$tblname3 = 'ourmission';
			}elseif($type == "getgoal"){
				$tblname3 = 'ourgoal';
			}else{
				//updategoal 
				// $description = $this->escape_string($this->strip_selected($data['description2'],$allowTags));
				// $tblname = 'ourgoal';
			}

			
			$query = "select * From ".PREFIX.$tblname3."  where id='$id' AND courses_category = '".$category."' ";
			//echo $query;exit();
			$sql = $this->query($query);
			return $this->fetch($sql);
		}

		function deleteForAll($id , $type, $category) {
			$tblname;
			if($type == 'deletevision'){
				// echo $type;exit;
				$tblname4 = 'ourvision';
			}else if($type == 'deletemission'){
				$tblname4 = 'ourmission';
			}elseif($type == "deletegoal"){
				$tblname4 = 'ourgoal';
			}else{
				//updategoal 
				// $description = $this->escape_string($this->strip_selected($data['description2'],$allowTags));
				// $tblname = 'ourgoal';
			}
			
			//$course_id =  $_SESSION["course_id"] ;
			$id = $this->escape_string($this->strip_all($id));
			//$Detail = $this->getUniqueAllById($id , $type , $category );
			$query = "delete from ".PREFIX.$tblname4."  where id='$id' AND courses_category = '".$category."'" ;
			// echo $query;exit;
			$this->query($query);
			return true;
		}

		/////////////////////////////////////////////////////////////////////////////////

			
		
	} 
?>