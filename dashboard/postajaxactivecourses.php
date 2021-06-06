<?php
//  session_start();
	include_once 'include/config.php';
	include_once 'include/admin-functions.php';
    $admin = new AdminFunctions();
    $course_id = $_POST['course_id'];
    $courses_name = strip_tags(($_POST['courses_name']));
    $_SESSION["course_id"] = $course_id;
    $_SESSION["course_name"] =  $courses_name ;
    $category;
    $sql = $admin->query("SELECT * FROM `dc_category` WHERE active= 1");
    while($row = $admin->fetch($sql))
    {
        $GLOBALS['count'] = $row['coruses_id'];
       
    }
    
    

         $activeid = $GLOBALS['count'];
        

         if($activeid){
            $sql = $admin->query("Update  `dc_category` set active=0 WHERE coruses_id='$activeid'");
         }else{
            $activeid = $course_id;
            $sql = $admin->query("Update  `dc_category` set active=1 WHERE coruses_id='$activeid'");
         }

        $sql = $admin->query("Update  `dc_category` set active=1 WHERE coruses_id='$course_id'");


        $pageURL = 'department-master.php';

        if(isset($_GET['page']) && !empty($_GET['page'])) {
            $pageNo = trim($admin->strip_all($_GET['page']));
        } else {
            $pageNo = 1;
        }
        $linkParam = "";
    
    
        $query = "SELECT COUNT(*) as num FROM dc_departments";
        $total_pages = $admin->fetch($admin->query($query));
        $total_pages = $total_pages['num'];
    
        $html = '';
        $title_des = '';
        $dept = '' ;
        $dept_image = '';
        $vision ='';
        $mission = "";
        $goal = "";
        $faculty="";
        $laboratory="";
        $curricular="";
        $academic = "";
      
        include_once "include/pagination.php";
        $pagination = new Pagination();
        $paginationArr = $pagination->generatePagination($pageURL, $pageNo, $total_pages, $linkParam);
       
        // carousel image;
        $sqlCI = "Select * From dc_carousel_images where category='".$courses_name."'";
        $results3 = $admin->query($sqlCI);

       
        $addURL_CI = 'postg-carousel-images-add.php';
        $deleteURL_CI = 'postg-carousel-images-delete.php';
        $x = (10*$pageNo)-9;
        while($row = $admin->fetch($results3)){
            $file_name = str_replace('', '-', strtolower( pathinfo($row['image'], PATHINFO_FILENAME)));
            $ext = pathinfo($row['image'], PATHINFO_EXTENSION);
                                
            
            $html .= '<tr>';
            $html .=  '<td>'. $x++.'</td>';
            $html .=  '<td>'.$row['category'].'</td>';
            $html .=  '<td><img src="../img/Department/'.$file_name.'_crop.'.$ext.'"
            width="100" /></td>';
            $html .=  '<td>'. $row['created_at'].'</td>';
            $html .=  '<td>'. $row['updated_at'].'</td>';
            $html.= '<td>
            <a href="'.$addURL_CI.'?edit&id='.$row['id'].'"
                name="edit" class="" title="Click to edit this row"><i
                    class="icon-pencil"></i></a>
            <a class="" href="'.$deleteURL_CI.'?id='.$row['id'].'"
                onclick="return confirm(\'Are you sure you want to delete?\');"
                title="Click to delete this row, this action cannot be undone."><i
                    class="icon-remove3"></i></a>
        </td>';
            $html.='<tr>';    
                                 
        }
        //end of carousel image

        //our vision 
        $sqlvision = "Select * From dc_ourvision where coruses_id='".$course_id."'";
        $resultsvision = $admin->query($sqlvision);

       
        $addURL_vision = 'postgraduate-vision-add.php';
        $deleteURL_vision = 'postgraduate-vision-delete.php';
        $y = (10*$pageNo)-9;
        while($row = $admin->fetch($resultsvision)){
            $vision .= '<tr>';
            $vision .=  '<td>'. $y++.'</td>';
            $vision .=  '<td>'.$row['courses_name'].'</td>';
            $vision .=  '<td>'.$row['description'].'</td>';
            $vision.= '<td>
            <a href="'.$addURL_vision.'?edit&id='.$row['id'].'"
                name="edit" class="" title="Click to edit this row"><i
                    class="icon-pencil"></i></a>
            <a class="" href="'.$deleteURL_vision.'?id='.$row['id'].'"
                onclick="return confirm(\'Are you sure you want to delete?\');"
                title="Click to delete this row, this action cannot be undone."><i
                    class="icon-remove3"></i></a>
        </td>';
            $vision.='<tr>';    
                                 
        }
        //end of vision

        //our mission 
        $sqlmission = "Select * From dc_ourmission where coruses_id='".$course_id."'";
        $resultsmission = $admin->query($sqlmission);

       
        $addURL_mission = 'postgraduate-mission-add.php';
        $deleteURL_mission = 'postgraduate-mission-add.php';
        $y = (10*$pageNo)-9;
        while($row = $admin->fetch($resultsmission)){
            $mission .= '<tr>';
            $mission .=  '<td>'. $y++.'</td>';
            $mission .=  '<td>'.$row['courses_name'].'</td>';
            $mission .=  '<td>'.$row['description'].'</td>';
            $mission.= '<td>
            <a href="'.$addURL_mission.'?edit&id='.$row['id'].'"
                name="edit" class="" title="Click to edit this row"><i
                    class="icon-pencil"></i></a>
            <a class="" href="'.$deleteURL_mission.'?id='.$row['id'].'"
                onclick="return confirm(\'Are you sure you want to delete?\');"
                title="Click to delete this row, this action cannot be undone."><i
                    class="icon-remove3"></i></a>
        </td>';
            $mission.='<tr>';    
                                 
        }
        //end of mission 

        //our goal 
        $sqlgoal = "Select * From dc_ourgoal where coruses_id='".$course_id."'";
        $resultsgoal = $admin->query($sqlgoal);

       
        $addURL_goal = 'postgraduate-goal-add.php';
        $deleteURL_goal = 'postgraduate-goal-add.php';
        $y = (10*$pageNo)-9;
        while($row = $admin->fetch($resultsgoal)){
            $goal .= '<tr>';
            $goal .=  '<td>'. $y++.'</td>';
            $goal .=  '<td>'.$row['courses_name'].'</td>';
            $goal .=  '<td>'.$row['description'].'</td>';

            $goal.= '<td>
            <a href="'.$addURL_goal.'?edit&id='.$row['id'].'"
                name="edit" class="" title="Click to edit this row"><i
                    class="icon-pencil"></i></a>
            <a class="" href="'.$deleteURL_goal.'?id='.$row['id'].'"
                onclick="return confirm(\'Are you sure you want to delete?\');"
                title="Click to delete this row, this action cannot be undone."><i
                    class="icon-remove3"></i></a>
        </td>';
            $goal.='<tr>';    
                                 
        }
        //end of goal 


         // Title & Description
         $sqlTD = "Select * From dc_title_descrption where coruses_id='".$course_id."'";
         $resultsTD = $admin->query($sqlTD);
 
        
         $addURL_TD = 'postg-add-title-description.php';
         $deleteURL_TD = 'postg-delete-title-description.php';
         $y = (10*$pageNo)-9;
         while($row = $admin->fetch($resultsTD)){
             $title_des .= '<tr>';
             $title_des .=  '<td>'. $y++.'</td>';
             $title_des .=  '<td>'.$row['category_type'].'</td>';
             $title_des .=  '<td>'.$row['title'].'</td>';
             $title_des .=  '<td>'.$row['description'].'</td>';
             $title_des .=  '<td>'. $row['created_at'].'</td>';
             $title_des .=  '<td>'. $row['updated_at'].'</td>';
             $title_des.= '<td>
             <a href="'.$addURL_TD.'?edit&id='.$row['id'].'"
                 name="edit" class="" title="Click to edit this row"><i
                     class="icon-pencil"></i></a>
             <a class="" href="'.$deleteURL_TD.'?id='.$row['id'].'"
                 onclick="return confirm(\'Are you sure you want to delete?\');"
                 title="Click to delete this row, this action cannot be undone."><i
                     class="icon-remove3"></i></a>
         </td>';
             $title_des.='<tr>';    
                                  
         }
         //end of Title & Description


         //Add Subtype For Courses
         $addURL_ST = 'postg-subtype-courses-images-add.php';
         $deleteURL_ST = 'postg-subtype-courses-images-delete.php';
         $sqlST = "SELECT `cat`.category,`sc`.* FROM `dc_subtype_courses_images` as sc ,`dc_category` as cat 
         WHERE sc.`coruses_id`= cat.`coruses_id` AND sc.`coruses_id`='".$course_id."' ";

        //  $sqlST = "Select * FROM dc_subtype_courses_images where coruses_id='".$course_id."' ";
         $results4 = $admin->query($sqlST);
         $z = (10*$pageNo)-9;
         while($row = $admin->fetch($results4)){
            $file_name = str_replace('', '-', strtolower( pathinfo($row['coursesubtype_img'], PATHINFO_FILENAME)));
            $ext = pathinfo($row['coursesubtype_img'], PATHINFO_EXTENSION);


           
                $courses_subtype .= '<tr>';
                $courses_subtype .=  '<td>'. $z++.'</td>';
                $courses_subtype .=  '<td>'.strip_tags($row['category']).'</td>';
                $courses_subtype .=  '<td>'.$row['courses_subtype'].'</td>';
                $courses_subtype .=  '<td><img src="../img/coursesubtype/'.$file_name.'_crop.'.$ext.'"
                width="100" /></td>';
                $courses_subtype .=  '<td>'. $row['created_at'].'</td>';
                $courses_subtype .=  '<td>'. $row['updated_at'].'</td>';
                $courses_subtype.= '<td>
                <a href="'.$addURL_ST.'?edit&id='.$row['id'].'"
                    name="edit" class="" title="Click to edit this row"><i
                        class="icon-pencil"></i></a>
                <a class="" href="'.$deleteURL_ST.'?id='.$row['id'].'"
                    onclick="return confirm(\'Are you sure you want to delete?\');"
                    title="Click to delete this row, this action cannot be undone."><i
                        class="icon-remove3"></i></a>
            </td>';
                $courses_subtype.='<tr>';    
                                        
         }
           

         //end of Add Subtype For Courses

         //Faculty
         $sqlfaculty = "Select * From dc_faculty where coruses_id='".$course_id."'";
         $resultsfaculty = $admin->query($sqlfaculty);
 
        
         $addURL_faculty = 'postg_faculty-add.php';
         $deleteURL_faculty = 'postg_faculty-delete.php';
         $y = (10*$pageNo)-9;
         while($row = $admin->fetch($resultsfaculty)){
             $faculty .= '<tr>';
             $faculty .=  '<td>'. $y++.'</td>';
             $faculty .=  '<td>'.$row['coruses_name'].'</td>';
             $faculty .=  '<td>'.$row['name'].'</td>';
             $faculty .=  '<td>'.$row['department'].'</td>';
             $faculty .=  '<td>'.$row['designation'].'</td>';
             $faculty .=  '<td>'. $row['created_at'].'</td>';
             $faculty .=  '<td>'. $row['updated_at'].'</td>';
             $faculty.= '<td>
             <a href="'.$addURL_faculty.'?edit&id='.$row['id'].'"
                 name="edit" class="" title="Click to edit this row"><i
                     class="icon-pencil"></i></a>
             <a class="" href="'.$deleteURL_faculty.'?id='.$row['id'].'"
                 onclick="return confirm(\'Are you sure you want to delete?\');"
                 title="Click to delete this row, this action cannot be undone."><i
                     class="icon-remove3"></i></a>
         </td>';
             $faculty.='<tr>';    
                                  
         }
         //end of Faculty

         //Laboratory
         $sqllab = "Select * From dc_laboratory where coruses_id='".$course_id."'";
         $resultslab = $admin->query($sqllab);
 
        
         $addURL_lab = 'postg_laboratory-add.php';
         $deleteURL_lab = 'postg_laboratory-delete.php';
         $y = (10*$pageNo)-9;
         while($row = $admin->fetch($resultslab)){
            $laboratory .= '<tr>';
            $laboratory .=  '<td>'. $y++.'</td>';
            $laboratory .=  '<td>'.$row['coruses_name'].'</td>';
            $laboratory .=  '<td>'.$row['lab_name'].'</td>';
            $laboratory .=  '<td>'.$row['lab_incharge'].'</td>';
            $laboratory .=  '<td>'.$row['lab_contactno'].'</td>';
            $laboratory .=  '<td>'. $row['created_at'].'</td>';
            $laboratory .=  '<td>'. $row['updated_at'].'</td>';
            $laboratory.= '<td>
             <a href="'.$addURL_lab.'?edit&id='.$row['id'].'"
                 name="edit" class="" title="Click to edit this row"><i
                     class="icon-pencil"></i></a>
             <a class="" href="'.$deleteURL_lab.'?id='.$row['id'].'"
                 onclick="return confirm(\'Are you sure you want to delete?\');"
                 title="Click to delete this row, this action cannot be undone."><i
                     class="icon-remove3"></i></a>
         </td>';
             $laboratory.='<tr>';    
                                  
         }
         //end of Laboratory

         //Student Co-Curricular Activities
   
        $sqlcurricular = "Select * From dc_student_curricular where coruses_id='".$course_id."' ";
        $resultscurricular = $admin->query($sqlcurricular);

       
        $addURL_curricular = 'postg-studentcurricular-add.php';
        $deleteURL_curricular = 'postg-studentcurricular-delete.php';
        $x = (10*$pageNo)-9;
        while($row = $admin->fetch($resultscurricular)){
            $file_name = str_replace('', '-', strtolower( pathinfo($row['image'], PATHINFO_FILENAME)));
            $ext = pathinfo($row['image'], PATHINFO_EXTENSION);
                                
            
            $curricular .= '<tr>';
            $curricular .=  '<td>'. $x++.'</td>';
            $curricular .=  '<td>'.$row['coruses_name'].'</td>';
            $curricular .=  '<td>'.$row['title'].'</td>';
            $curricular .=  '<td><img src="../img/StudentCo-Curricular/undergraduate/'.$file_name.'_crop.'.$ext.'"
            width="100" /></td>';
            $curricular .=  '<td>'. $row['created_at'].'</td>';
            $curricular .=  '<td>'. $row['updated_at'].'</td>';
            $curricular.= '<td>
            <a href="'.$addURL_curricular.'?edit&id='.$row['id'].'"
                name="edit" class="" title="Click to edit this row"><i
                    class="icon-pencil"></i></a>
            <a class="" href="'.$deleteURL_curricular.'?id='.$row['id'].'"
                onclick="return confirm(\'Are you sure you want to delete?\');"
                title="Click to delete this row, this action cannot be undone."><i
                    class="icon-remove3"></i></a>
        </td>';
            $curricular.='<tr>';    
                                 
        }
       
         //end of Student Co-Curricular Activities

         //Student Academic Activities
         $sqlacademic = "Select * From dc_student_academic where coruses_id='".$course_id."' ";
         $resultsacademic = $admin->query($sqlacademic);
 
        
         $addURL_academic = 'postg-studentacademic-add.php';
         $deleteURL_academic = 'postg-studentacademic-add.php';
         $x = (10*$pageNo)-9;
         while($row = $admin->fetch($resultsacademic)){
             $file_name = str_replace('', '-', strtolower( pathinfo($row['image'], PATHINFO_FILENAME)));
             $ext = pathinfo($row['image'], PATHINFO_EXTENSION);
                                 
             
             $academic .= '<tr>';
             $academic .=  '<td>'. $x++.'</td>';
             $academic .=  '<td>'.$row['coruses_name'].'</td>';
             $academic .=  '<td>'.$row['title'].'</td>';
             $academic .=  '<td><img src="../img/StudentAcademic/undergraduate/'.$file_name.'_crop.'.$ext.'"
             width="100" /></td>';
             $academic .=  '<td>'. $row['created_at'].'</td>';
             $academic .=  '<td>'. $row['updated_at'].'</td>';
             $academic.= '<td>
             <a href="'.$addURL_academic.'?edit&id='.$row['id'].'"
                 name="edit" class="" title="Click to edit this row"><i
                     class="icon-pencil"></i></a>
             <a class="" href="'.$deleteURL_academic.'?id='.$row['id'].'"
                 onclick="return confirm(\'Are you sure you want to delete?\');"
                 title="Click to delete this row, this action cannot be undone."><i
                     class="icon-remove3"></i></a>
         </td>';
             $academic.='<tr>';    
                                  
         }
         //end of Student Academic Activities

        
    //    echo json_encode(array('carouselDetail'=>$html , 'titleDes'=>$title_des , 'department' => $dept , 'dept_image'=> $dept_image));

    echo json_encode(array('carouselDetail'=>$html , 'titleDes'=>$title_des, 'courses_subtype' => $courses_subtype ,
     'uvision' => $vision,'umission' => $mission,'ugoal'=> $goal , 'ufaculty' =>  $faculty ,'ulab'=> $laboratory ,'ucocurricular' => $curricular,
     'uacademic' => $academic));
   
   

?>