<?php
include_once 'include/config.php';
include_once 'include/admin-functions.php';
$admin = new AdminFunctions();
$content_id = $_POST['content_id'];
$sql = $admin->query("SELECT * FROM `dc_home_all_title_changes_tbl_link` WHERE content_id= '$content_id' ");
$row = $admin->fetch($sql);
echo $row['head_title'];

?>