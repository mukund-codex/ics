<?php
//  session_start();
	include_once 'include/config.php';
	include_once 'include/admin-functions.php';
    $admin = new AdminFunctions();
    $course_id = $_POST['course_id'];
    $courses_name = $_POST['courses_name'];
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


         //sub category 
    $sqlsubcategory = $admin->query("SELECT * FROM `dc_subtype_courses_list` WHERE coruses_id='$course_id'");

    $subcat ='<option value="Select">Select Sub Courses</option>';
    while($row1 = $admin->fetch($sqlsubcategory))
    {   
        $subcat .='<option value="'.$row1['courses_subtype_id'].'">'.strip_tags($row1['courses_subtype']).'</option>';
    }

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
      
        include_once "include/pagination.php";
        $pagination = new Pagination();
        $paginationArr = $pagination->generatePagination($pageURL, $pageNo, $total_pages, $linkParam);
       
        // carousel image;
        $sqlCI = "Select * From dc_carousel_images where coruses_id='".$course_id."'";
        $results3 = $admin->query($sqlCI);

       
        $addURL_CI = 'carousel-images-add.php';
        $deleteURL_CI = 'carousel-images-delete.php';
        $x = (10*$pageNo)-9;
            $html .=  "<thead>";
            $html .=  "<tr>";
            $html .=   "<th>#</th>";
            $html .=    "<th>Category</th>";
            $html .=  " <th>Image</th>";
            $html .=  " <th>Created Date</th>";
            $html .=   "<th>Updated Date</th>";
            $html .=  " <th>Action</th>";
            $html .= " </tr>";
            $html .= " </thead>";
            $html .=   "<tbody >";
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
        $html.="</tbody>";
        //end of carousel image

         // Title & Description
         $sqlTD = "Select * From dc_title_descrption where coruses_id='".$course_id."'";
         $resultsTD = $admin->query($sqlTD);
         
         $addURL_TD = 'add-title-description.php';
         $deleteURL_TD = 'delete-title-description.php';
         $y = (10*$pageNo)-9;
            $title_des .=  "<thead>";
            $title_des .=  "<tr>";
            $title_des .=   "<th>#</th>";
            $title_des .=    "<th>Course</th>";
            $title_des .=  " <th>Title</th>";
            $title_des .=  " <th>Description</th>";
            $title_des .=  " <th>Created Date</th>";
            $title_des .=   "<th>Updated Date</th>";
            $title_des .=  " <th>Action</th>";
            $title_des .= " </tr>";
            $title_des .= " </thead>";
            $title_des.="</tbody>";
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
         $title_des.="</tbody>";
         //end of Title & Description




        // of Department

        //if courses have not sub courses then run this sql
      
        //$sqlCI = "Select * From dc_carousel_images where category='".$courses_name."'";
       
        // $sqlDept = "SELECT dp.*, bt.tabs as department_name , ct.category as coursesname ,st.courses_subtype as subcorname
        // FROM dc_departments dp ,dc_subtype_courses_list as st
        // JOIN dc_boxed_tabs bt ON dp.department_id = bt.department_id 
        // JOIN dc_category ct ON dp.category_type = ct.coruses_id  
        // JOIN dc_subtype_courses_list st ON dp.courses_subtype_id  = st.courses_subtype_id
        // where dp.category_type='".$course_id."' ";
        $sqlTitle1 = "SELECT COUNT(coruses_id) as count1 FROM `dc_subtype_courses_list` where coruses_id= '".$course_id."' ";
        $resultTitle1 = $admin->query($sqlTitle1);
        $rowcount = $admin->fetch($resultTitle1);
         if($rowcount['count1'] <= 0){
            $sqlDept = "SELECT dp.*, bt.tabs as department_name , ct.category as coursesname FROM dc_departments dp JOIN dc_boxed_tabs bt ON dp.department_id = bt.department_id JOIN dc_category ct ON dp.category_type = ct.coruses_id  where  dp.category_type='".$course_id."'";
            $resultsDept = $admin->query($sqlDept);

                $addURL_Dept = 'department-add.php';
                $deleteURL_Dept = 'department-delete.php';
                $x = (10*$pageNo)-9;
                $dept .=  "<thead>";
                $dept .=  "<tr>";
                $dept .=   "<th>#</th>";
                $dept .=    "<th>Course</th>";
                $dept .=  " <th>Tab</th>";
                $dept .=  " <th>Description</th>";
                $dept .=  " <th>pdf</th>";
                $dept .=  " <th>Created Date</th>";
                $dept .=   "<th>Updated Date</th>";
                $dept .=  " <th>Action</th>";
                $dept .= " </tr>";
                $dept .= " </thead>";
                $dept.="<tbody>";    
                while($row = $admin->fetch($resultsDept)){
                    // $file_name = str_replace('', '-', strtolower( pathinfo($row['image'], PATHINFO_FILENAME)));
                    // $ext = pathinfo($row['image'], PATHINFO_EXTENSION);
                                        
                    
                    $dept .= '<tr>';
                    $dept .=  '<td>'. $x++.'</td>';
                    $dept .=  '<td>'.$row['coursesname'].'</td>';
                    $dept .=  '<td>'.$row['department_name'].'</td>';
                    $dept .=  '<td>'.$row['text'].'</td>';
                    $dept .=  '<td>'.$row['pdf'].'</td>';
                    $dept .=  '<td>'. $row['created_at'].'</td>';
                    $dept .=  '<td>'. $row['updated_at'].'</td>';
                    $dept.= '<td>
                    <a href="'.$addURL_Dept.'?edit&id='.$row['id'].'"
                        name="edit" class="" title="Click to edit this row"><i
                            class="icon-pencil"></i></a>
                    <a class="" href="'.$deleteURL_Dept.'?id='.$row['id'].'"
                        onclick="return confirm(\'Are you sure you want to delete?\');"
                        title="Click to delete this row, this action cannot be undone."><i
                            class="icon-remove3"></i></a>
                </td>';
                    $dept.='<tr>';    
                
                    
                                        
                }
        $dept.="</tbody>";    
         }else{
            $sqlDept =  "SELECT dp.*, bt.tabs as department_name , ct.category as coursesname ,st.courses_subtype as subcorname FROM dc_departments dp JOIN dc_boxed_tabs bt ON dp.department_id = bt.department_id JOIN dc_category ct ON dp.category_type = ct.coruses_id JOIN dc_subtype_courses_list st ON dp.courses_subtype_id = st.courses_subtype_id   where dp.category_type='".$course_id."'";
         $resultsDept = $admin->query($sqlDept);

        $addURL_Dept = 'department-add.php';
        $deleteURL_Dept = 'department-delete.php';
        $x = (10*$pageNo)-9;
        $dept .=  "<thead>";
        $dept .=  "<tr>";
        $dept .=   "<th>#</th>";
        $dept .=    "<th>Courses</th>";
        $dept .=    "<th>Sub Courses</th>";
        $dept .=  " <th>Tab</th>";
        $dept .=  " <th>Description</th>";
        $dept .=  " <th>pdf</th>";
        $dept .=  " <th>Created Date</th>";
        $dept .=   "<th>Updated Date</th>";
        $dept .=  " <th>Action</th>";
        $dept .= " </tr>";
        $dept .= " </thead>";
        $dept.="<tbody>";
        while($row = $admin->fetch($resultsDept)){
            // $file_name = str_replace('', '-', strtolower( pathinfo($row['image'], PATHINFO_FILENAME)));
            // $ext = pathinfo($row['image'], PATHINFO_EXTENSION);
                                
            
            $dept .= '<tr>';
            $dept .=  '<td>'. $x++.'</td>';
            $dept .=  '<td>'.strip_tags($row['coursesname']).'</td>';
            $dept .=  '<td>'.strip_tags($row['subcorname']).'</td>';
            $dept .=  '<td>'.$row['department_name'].'</td>';
            $dept .=  '<td>'.$row['text'].'</td>';
            $dept .=  '<td>'.$row['pdf'].'</td>';
            $dept .=  '<td>'. $row['created_at'].'</td>';
            $dept .=  '<td>'. $row['updated_at'].'</td>';
            $dept.= '<td>
            <a href="'.$addURL_Dept.'?edit&id='.$row['id'].'"
                name="edit" class="" title="Click to edit this row"><i
                    class="icon-pencil"></i></a>
            <a class="" href="'.$deleteURL_Dept.'?id='.$row['id'].'"
                onclick="return confirm(\'Are you sure you want to delete?\');"
                title="Click to delete this row, this action cannot be undone."><i
                    class="icon-remove3"></i></a>
        </td>';
            $dept.='<tr>';    
                                 
        }
        $dept.="</tbody>";
        }

        

       
       
        //end of Department


          // Department Images
          $addURL_DI = 'department_image-add.php';
          $deleteURL_DI = 'department_image-delete.php';
       if($rowcount['count1'] <= 0){
          $sqlDI = "SELECT bt.tabs,dt.category,dt.image,dt.created_at,dt.id FROM `dc_boxed_tabs` as bt , `dc_departments_images` as dt where bt.`department_id` = dt.`tabs` AND dt.category='".$course_id."' ";
          $resultsDI  = $admin->query($sqlDI);

      
          
          $x = (10*$pageNo)-9;
          $dept_image .=  "<thead>";
          $dept_image .=  "<tr>";
          $dept_image .=   "<th>#</th>";
          $dept_image .=    "<th>Course</th>";
          $dept_image .=  " <th>Tab</th>";
          $dept_image .=  " <th>Description</th>";
          $dept_image .=  " <th>Created Date</th>";
          $dept_image .=  " <th>Action</th>";
          $dept_image .= " </tr>";
          $dept_image .= " </thead>";
          $dept_image.="<tbody>";    
          while($row = $admin->fetch($resultsDI)){
              $file_name = str_replace('', '-', strtolower( pathinfo($row['image'], PATHINFO_FILENAME)));
              $ext = pathinfo($row['image'], PATHINFO_EXTENSION);
                                  
              
              $dept_image .= '<tr>';
              $dept_image .=  '<td>'. $x++.'</td>';
              $dept_image .=  '<td>'.strip_tags($row['category']).'</td>';
              $dept_image .=  '<td>'.strip_tags($row['tabs']).'</td>';
              $dept_image .=  '<td><img src="../img/Department/'.$file_name.'_crop.'.$ext.'"
              width="100" /></td>';
              $dept_image .=  '<td>'. $row['created_at'].'</td>';
              $dept_image.= '<td>
              <a href="'.$addURL_DI.'?edit&id='.$row['id'].'"
                  name="edit" class="" title="Click to edit this row"><i
                      class="icon-pencil"></i></a>
              <a class="" href="'.$deleteURL_DI.'?id='.$row['id'].'"
                  onclick="return confirm(\'Are you sure you want to delete?\');"
                  title="Click to delete this row, this action cannot be undone."><i
                      class="icon-remove3"></i></a>
          </td>';
              $dept_image.='<tr>';    
              
                                  
          }
          $dept_image.='</tbody>';   
       }else{
          $sqlDI = "SELECT dp.*, bt.tabs as tab , ct.category as coursesname ,st.courses_subtype as subcorname FROM dc_departments_images dp JOIN dc_boxed_tabs bt ON dp.tabs = bt.department_id JOIN dc_category ct ON dp.category = ct.coruses_id JOIN dc_subtype_courses_list st ON dp.courses_subtype_id = st.courses_subtype_id   where dp.category='$course_id' ";
          $resultsDI  = $admin->query($sqlDI);

      
        
          $x = (10*$pageNo)-9;
          $dept_image .=  "<thead>";
          $dept_image .=  "<tr>";
          $dept_image .=   "<th>#</th>";
          $dept_image .=    "<th>Course</th>";
          $dept_image .=    "<th>Sub Course</th>";
          $dept_image .=  " <th>Tab</th>";
          $dept_image .=  " <th>Description</th>";
          $dept_image .=  " <th>Created Date</th>";
          $dept_image .=  " <th>Action</th>";
          $dept_image .= " </tr>";
          $dept_image .= " </thead>";
          $dept_image.="<tbody>";    
          while($row = $admin->fetch($resultsDI)){
              $file_name = str_replace('', '-', strtolower( pathinfo($row['image'], PATHINFO_FILENAME)));
              $ext = pathinfo($row['image'], PATHINFO_EXTENSION);
                                  
              
              $dept_image .= '<tr>';
              $dept_image .=  '<td>'. $x++.'</td>';
              $dept_image .=  '<td>'.strip_tags($row['coursesname']).'</td>';
              $dept_image .=  '<td>'.strip_tags($row['subcorname']).'</td>';
              $dept_image .=  '<td>'.strip_tags($row['tab']).'</td>';
              $dept_image .=  '<td><img src="../img/Department/'.$file_name.'_crop.'.$ext.'"
              width="100" /></td>';
              $dept_image .=  '<td>'. $row['created_at'].'</td>';
              $dept_image.= '<td>
              <a href="'.$addURL_DI.'?edit&id='.$row['id'].'"
                  name="edit" class="" title="Click to edit this row"><i
                      class="icon-pencil"></i></a>
              <a class="" href="'.$deleteURL_DI.'?id='.$row['id'].'"
                  onclick="return confirm(\'Are you sure you want to delete?\');"
                  title="Click to delete this row, this action cannot be undone."><i
                      class="icon-remove3"></i></a>
          </td>';
              $dept_image.='<tr>';    
              
                                  
          }
          $dept_image.='</tbody>';   
       }

      //end of Department Images

       
        
    //    echo json_encode(array('carouselDetail'=>$html , 'titleDes'=>$title_des , 'department' => $dept , 'dept_image'=> $dept_image));

    echo json_encode(array('subcat'=> $subcat,'carouselDetail'=>$html , 'titleDes'=>$title_des, 'department' => $dept,'dept_image'=> $dept_image));
   
   

?>