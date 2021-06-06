<?php
	include_once 'include/config.php';
	include_once 'include/admin-functions.php';
    $admin = new AdminFunctions();
    $graduate_value=$_POST['a'];
    // echo "SELECT * FROM `dc_category` WHERE sub_category='$graduate_value'";
    $sql = $admin->query("SELECT * FROM `dc_category` WHERE sub_category='$graduate_value'");
//    $_SESSION["course_name"] ;
    echo '<option value="Select">Select Courses</option>';
    while($row = $admin->fetch($sql))
    {   
        echo '<option value="'.$row['coruses_id'].'">'.$row['category'].'</option>';
    }

?>