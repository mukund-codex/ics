<?php

include_once 'database/dbcon.php';

$database = new Database();
$query = "select * from dc_banner_master";
$result = $database->query($query);
if($database->num_rows($result) == 1) {
    $row = $database->fetch($result);
    print_r($row);
}

?>
