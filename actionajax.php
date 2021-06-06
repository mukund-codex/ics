<?php

//echo '<li class="new"> City not Found</li>';

include('site-config.php');

// $sql = "SELECT * FROM `dc_home_carousel` ORDER BY id ASC";


if (isset($_POST['search'])) {

    $output = "";
    $search = $_POST['search'];
   
    $query = "SELECT * FROM dc_subtype_courses_list WHERE courses_subtype  LIKE '%$search%' ";
    $resultsubcourses = $func->query($query);

    $output = '<ul class="list-unstyled">';		

    if ($resultsubcourses->num_rows > 0) {

        while ($rowsubcourses = $func->fetch($resultsubcourses)) {
            if($rowsubcourses['courses_category'] == 'UG'){
                $output .= '<span><li class="new" ><a href=../ics/department.php?courses='.$rowsubcourses['coruses_id'].'&sub_courses='.$rowsubcourses['courses_subtype_id'].'>'.ucwords(strip_tags($rowsubcourses['courses_subtype'])).'</a></li></span>';

            }else if($rowsubcourses['courses_category'] == 'PG'){
                $output .= '<span><li class="new" ><a href=../ics/department.php?courses='.$rowsubcourses['coruses_id'].'&sub_courses='.$rowsubcourses['courses_subtype_id'].'>'.ucwords(strip_tags($rowsubcourses['courses_subtype'])).'</a></li></span>';

            }else if($rowsubcourses['courses_category'] == 'Other'){
                $output .= '<span><li class="new" ><a href=../ics/department.php?courses='.$rowsubcourses['coruses_id'].'&sub_courses='.$rowsubcourses['courses_subtype_id'].'>'.ucwords(strip_tags($rowsubcourses['courses_subtype'])).'</a></li></span>';

            }
        }
    }else if($resultsubcourses->num_rows <= 0){
        $query2 = "SELECT * FROM dc_category WHERE category  LIKE '%$search%' ";
        $result = $func->query($query2);

       

        while ($row = $func->fetch($result)) {
            $id = $row['coruses_id'];
            $sqlcount = "SELECT COUNT(coruses_id) as countid FROM `dc_subtype_courses_list` WHERE coruses_id = '$id'";
            $resultcount = $func->query($sqlcount);
            $row1 = $func->fetch($resultcount);
            if($row1['countid'] > 0 )
            {
                if($row['sub_category'] == 'UG'){
                    $output .= '<span><li class="new" ><a href=../ics/undergraduate-courses.php?courses='.$row['coruses_id'].'>'.ucwords(strip_tags($row['category'])).'</a></li></span>';
    
                }else if($row['sub_category'] == 'PG'){
                    $output .= '<span><li class="new" ><a href=../ics/postgraduate-courses.php?courses='.$row['coruses_id'].'>'.ucwords(strip_tags($row['category'])).'</a></li></span>';
    
                }else if($row['sub_category'] == 'Other'){
                    $output .= '<span><li class="new" ><a href=../ics/othergraduate-courses.php?courses='.$row['coruses_id'].'>'.ucwords(strip_tags($row['category'])).'</a></li></span>';
    
                }
            }else{
                if($row['sub_category'] == 'UG'){
                    $output .= '<span><li class="new" ><a href=../ics/department.php?courses='.$row['coruses_id'].'>'.ucwords(strip_tags($row['category'])).'</a></li></span>';
    
                }else if($row['sub_category'] == 'PG'){
                    $output .= '<span><li class="new" ><a href=../ics/department.php?courses='.$row['coruses_id'].'>'.ucwords(strip_tags($row['category'])).'</a></li></span>';
    
                }else if($row['sub_category'] == 'Other'){
                    $output .= '<span><li class="new" ><a href=../ics/department.php?courses='.$row['coruses_id'].'>'.ucwords(strip_tags($row['category'])).'</a></li></span>';
    
                }
            }

            
        }

    }else{
          $output .= '<li class="new" ><a href="#"> search not Found</a></li>';
    }
    
    $output .= '</ul>';
    echo $output;
}

?>