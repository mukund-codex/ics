
<?php
//Admission
$sqlQL = "SELECT * FROM `dc_footer_quick_link` ORDER BY id ASC";
$resultQL = $func->query($sqlQL);

$sqlOI = "SELECT * FROM `dc_footer_our_inst` ORDER BY id ASC";
$resultOI = $func->query($sqlOI);

$sqlFA = "SELECT * FROM `dc_footer_admission` ORDER BY id ASC";
$resultFA = $func->query($sqlFA);

$sqlF = "SELECT * FROM `dc_footer` ORDER BY id ASC";
$resultF = $func->query($sqlF);

$sqlTC= "SELECT * FROM `dc_terms_n_conditions` ORDER BY id ASC";
$resultTC = $func->query($sqlTC);

?>

<footer id="footer-widgets">
    <div class="container">
      <div class="row">
        <div class="col-md-7 ov-h">
          <div class="row">
            <div class="col-sm-4 col-sm-6 col-xs-6">
              <div class="widget clearfix">
                <h5>Quick Links</h5>
                <div class="widget clearfix">
                  <div class="menu-footer-1-container">
                    <ul class="menu">
                    <?php 
                          while($row = $func->fetch($resultQL)){ 
                            $file_name = str_replace('', '-', strtolower( pathinfo($row['pdf'], PATHINFO_FILENAME)));
                            $ext = pathinfo($row['pdf'], PATHINFO_EXTENSION); 
                            if($file_name) {
                        ?>
                                        <li>
                                            <a href="img/headers/<?php echo $file_name.'.'.$ext ?>"
                                                target="_blank"><?php  echo $row['title']; ?></a>
                                        </li>

                        <?php 
                                    
                            }
                            if($row['link']){
                        ?>
                                        <li>
                                            <a href="<?php echo $row['link']; ?>"
                                                target="_blank"><?php  echo $row['title']; ?></a>
                                        </li>
                        <?php
                            }else if(!$row['link'] && !$file_name){
                        ?>
                                        <li>
                                            <a href="#"><?php  echo $row['title']; ?></a>
                                        </li>
                                        <?php
                        }
                        
                        } ?>

                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-4 col-sm-6 col-xs-6">
              <div class="widget clearfix">
                <h5>Admissions</h5>
                <ul>
                <?php 
                          while($row = $func->fetch($resultFA)){ 
                            $file_name = str_replace('', '-', strtolower( pathinfo($row['pdf'], PATHINFO_FILENAME)));
                            $ext = pathinfo($row['pdf'], PATHINFO_EXTENSION); 
                            if($file_name) {
                        ?>
                                        <li>
                                            <a href="img/headers/<?php echo $file_name.'.'.$ext ?>"
                                                target="_blank"><?php  echo $row['title']; ?></a>
                                        </li>

                        <?php 
                                    
                            }
                            if($row['link']){
                        ?>
                                        <li>
                                            <a href="<?php echo $row['link']; ?>"
                                                target="_blank"><?php  echo $row['title']; ?></a>
                                        </li>
                        <?php
                            }else if(!$row['link'] && !$file_name){
                        ?>
                                        <li>
                                            <a href="#"><?php  echo $row['title']; ?></a>
                                        </li>
                                        <?php
                        }
                        
                        } ?>

                </ul>
              </div>
            </div>
            <div class="col-sm-4 col-sm-6 col-xs-6">
              <div class="widget clearfix">
                <h5>Our Institute</h5>
                <ul>
                <?php 
                          while($row = $func->fetch($resultOI)){ 
                            $file_name = str_replace('', '-', strtolower( pathinfo($row['pdf'], PATHINFO_FILENAME)));
                            $ext = pathinfo($row['pdf'], PATHINFO_EXTENSION); 
                            if($file_name) {
                        ?>
                                        <li>
                                            <a href="img/headers/<?php echo $file_name.'.'.$ext ?>"
                                                target="_blank"><?php  echo $row['title']; ?></a>
                                        </li>

                        <?php 
                                    
                            }
                            if($row['link']){
                        ?>
                                        <li>
                                            <a href="<?php echo $row['link']; ?>"
                                                target="_blank"><?php  echo $row['title']; ?></a>
                                        </li>
                        <?php
                            }else if(!$row['link'] && !$file_name){
                        ?>
                                        <li>
                                            <a href="#"><?php  echo $row['title']; ?></a>
                                        </li>
                                        <?php
                        }
                        
                        } ?>

                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12 col-md-offset-1">
          <div class="row">
            <div class="col-md-12">
              <div class="widget clearfix">
                <h5>Downloads</h5>
                <ul>
                  <li><a href="#">E-Newsletter</a>
                  </li>
                </ul>
              </div>
              <div class="widget clearfix">
                <h5>Follow Us</h5>
                <ul class="social-list">
                    <?php
                      while($row = $func->fetch($resultF)){ 
                        
                        
                    ?>
                  <li class="social-item-facebook"><a target="_blank" href="<?php echo $row['facebook'] ; ?>"><i class="hc-facebook"></i></a>
                  </li>
                  <li class="social-item-twitter"><a target="_blank" href="<?php echo $row['twitter'] ; ?>"><i class="hc-twitter"></i></a>
                  </li>
                      <!-- Linked In  pending -->
                      <li class="social-item-twitter"><a target="_blank" href="<?php echo $row['linkedIn'] ; ?>"><i class="hc-linkedin"></i></a>
                  </li>
                 
                  <li class="social-item-youtube"><a target="_blank" href="<?php echo $row['youtube'] ; ?>"><i class="hc-youtube"></i></a>
                  </li>
                  <?php  } ?>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <footer id="footer">
    <div class="container">
      <div class="row">
        <div class="col-md-4 col-sm-6 col-xs-6">
          <div class="copy-text">
          <?php
                      while($row = $func->fetch($resultTC)){ 
                        
                        
                    ?>
            <p><?php echo $row['description'];?></p>
            <?php } ?>
          </div>
        </div>
        <div class="col-md-offset-4 col-md-4 col-sm-6 col-xs-6">
          <p>Developed by: </p>
        </div>
      </div>
    </div>
  </footer>