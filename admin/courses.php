<?php 
 $curentPage = "courses";
 include 'template/head.php';
 include 'config/updateDb.php';

 $jsonCoursesSubtitleString = getJSONFromDB("select * from section_subtitle where sectionName ='Courses'");
$CoursessData = json_decode($jsonCoursesSubtitleString);

 $jsonCoursesString = getJSONFromDB("select * from courses where id ='".$_GET['editId']."'");
 $CoursesAllData = json_decode($jsonCoursesString);

?>
     <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Course Control Area!
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i> Courses
                            </li>
                        </ol>
                    </div>
                </div>
                <?php

                     $message = "";

                    if ( isset($_POST['submit']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
                        if (isset($_POST['subtitle'])
                            && (!empty($_POST['subtitle']))) {
                            $subtitle = $_POST['subtitle'];

                            $subSql = "UPDATE section_subtitle SET subtitle = '$subtitle' WHERE sectionName = 'Courses'";

                            if(updateDB($subSql)==1){
                               $message = '<div class="alert alert-success alert-dismissable notification">
                                   <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                   <strong><b>success!</b> Data updated successfully!</strong>
                                 </div>'; 
                            }
                        }else{
                            $message = '<div class="alert alert-info alert-dismissable notification">
                                   <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                   <strong><b>Error!</b> Data not updated!</strong>
                                 </div>';

                        }
                    }

                 ?>
                <div class="row">
                    <?php echo $message; ?> 
                    <div class="col-lg-6">
                        <form action="" method="post">
                            <div class="form-group">
                              <label for="section_title">Edit Courses Subtitle:</label>
                              <textarea class="form-control" name="subtitle" rows="5" id="coursesSubtitle"><?php  

                                if (isset($_POST['subtitle'])) {
                                    echo $_POST['subtitle'];
                                }else{
                                    echo $CoursessData[0]->subtitle;
                                }
                                ?></textarea>
                            </div>
                            <button type="submit" name="submit" class="btn btn-info">Update</button>
                        </form>   
                    </div>
                </div>
                <!-- /.row -->
                <?php 
                $addNewmessage = "";
                     

                        include 'config/mysqlDb.php';
                         
                         $message = "";

                        if ( isset($_POST['addNewCourse']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
                              
                               if (isset($_POST['title']) && isset($_POST['details'])  && !empty($_POST['title']) && !empty($_POST['details'])) {
                                     
                                     $title           = $_POST['title'];
                                     $details         = $_POST['details'];
                                     $status          = $_POST['status'];

                                     if (isset($_FILES['courseImage']['name'])) {
                                          $target_dir = "image/";
                                      $target_file = $target_dir . basename($_FILES["courseImage"]["name"]);
                                      $uploadOk = 1;
                                      $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
                                      // Check if image file is a actual image or fake image
                                          $check = getimagesize($_FILES["courseImage"]["tmp_name"]);
                                          if($check !== false) {
                                              //echo "File is an image - " . $check["mime"] . ".";
                                              $uploadOk = 1;
                                          } else {
                                               
                                              $message= 
                                              '<div class="alert alert-info alert-dismissable notification">
                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                <strong>Warning!</strong> File is not an image.
                                             </div>';
                                              
                                              $uploadOk = 0;
                                          }

                                      // Check if file already exists
                                      if (file_exists($target_file)) {
                                          
                                          $message= 
                                              '<div class="alert alert-info alert-dismissable notification">
                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                <strong>Warning!</strong> Sorry, file already exists.
                                             </div>';
                                              
                                          $uploadOk = 0;
                                      }
                                      // Check file size
                                      if ($_FILES["courseImage"]["size"] > 500000) {
                                           
                                          $message= 
                                              '<div class="alert alert-info alert-dismissable notification">
                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                <strong>Warning!</strong> Sorry, your file is too large.
                                             </div>';
                                             
                                          $uploadOk = 0;
                                      }
                                      // Allow certain file formats
                                      if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                                      && $imageFileType != "gif" ) { 
                                        $message= 
                                              '<div class="alert alert-info alert-dismissable notification">
                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                <strong>Warning!</strong> Sorry, only JPG, JPEG, PNG & GIF files are allowed.
                                             </div>';
                                              
                                          $uploadOk = 0;
                                      }
                                      // Check if $uploadOk is set to 0 by an error
                                      if ($uploadOk == 0) {
                                          
                                          $message= $message;
                                              
                                      // if everything is ok, try to upload file
                                      } else {
                                          if (move_uploaded_file($_FILES["courseImage"]["tmp_name"], $target_file)) {
                                              $courseImage =$target_file;
                                              //print_r($_FILES["facultyImage"]["tmp_name"]);   
                                               $sql = "INSERT into courses (title,details,image_url,status) values('$title','$details','$courseImage','$status')";
                                               if(mysqli_query($conn, $sql)){
                                                      $message = 
                                                  '<div class="alert alert-success alert-dismissable notification">
                                                      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                      <strong>Success!</strong> The Value Insertered Successfully.
                                                   </div>';

                                               }else{
                                                     $message = mysqli_error($conn);
                                                    
                                              }
                                          } else {
                                              $message= 
                                              '<div class="alert alert-info alert-dismissable notification">
                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                <strong>Warning!</strong> Sorry, there was an error uploading your file.
                                             </div>';
                                          }
                                      }
                                           
                                     }
                                      
                                }else{
                                   $message = 
                                        '<div class="alert alert-success alert-dismissable notification">
                                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                            <strong>Warning!</strong> Insert Value First.
                                         </div>';
                                          
                                    }      
                           }
                           $UpdateMessage = "";

                        if (isset($_GET['editId'])) {

                            if (isset($_POST['updateCourse'])) {
                                     
                                 if (isset($_POST['title']) && isset($_POST['details']) && isset($_FILES['courseImage']['name']) && !empty($_POST['title']) && !empty($_POST['details'])) {

                                      $target_dir = "image/";

                                     $title      = $_POST['title'];
                                     $details    = $_POST['details'];
                                     $status     = $_POST['status'];

                                     $target_file = $target_dir . basename($_FILES["courseImage"]["name"]);

                                      if (move_uploaded_file($_FILES["courseImage"]["tmp_name"], $target_file)) {
                                              $courseImage =$target_file;

                                              $sqlUpdate = "UPDATE courses SET title='$title', details='$details', status='$status', image_url='$courseImage' WHERE id='".$_GET['editId']."'";

                                              if(updateDB($sqlUpdate)==1){
                                                    
                                                   $UpdateMessage = '<div class="alert alert-success alert-dismissable notification">
                                                       <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                       <strong><b>success!</b> Data updated successfully!</strong>
                                                     </div>';
                                                     unset($_GET['editId']);     
                                                }else{

                                                     $UpdateMessage = '<div class="alert alert-danger alert-dismissable notification">
                                                       <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                       <strong><b>Info!</b> Not updated!</strong>
                                                     </div>'; 
                                                  }
                                              }
                                }
                            }
                        } 
                           ?>
                <div class="row">
                    <div class="col-lg-6"> 
                       <h2 style="color: red; ">Add new Course</h2>
                      <?php
                         echo $message;
                         echo $UpdateMessage;
                         //print_r($message);
                      ?>
                      <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                          <label for="title"><?php echo isset($_GET['editId'])? 'Edit':'Add' ?> Course Name:</label>
                          <input type="text" class="form-control" id="title" placeholder="Enter Course Name!" value="<?php if (isset($_GET['editId'])){
                                       if (isset($_POST['title'])) {
                                            echo $_POST['title'];
                                       }else{
                                         echo $CoursesAllData[0]->title;
                                       }
                                    }
                                ?>" name="title">
                        </div>
                        <div class="form-group">
                        
                             <img  src="<?php echo isset($_GET['editId'])? $CoursesAllData[0]->image_url:'image/default.png' ?>" class="img-thumbnail" alt="Cinque Terre" width="100" height="100" id="output">
                          
                            
                        </div> 
                        <div class="form-group">
                          <label for="image"><?php echo isset($_GET['editId'])? 'Edit':'Add' ?> Featured Image</label>
                           <input type="file" name="courseImage" id="courseImage" onchange="loadFile(event)">
                        </div>
                        <div class="form-group">
                          <label for="details"><?php echo isset($_GET['editId'])? 'Edit':'Add' ?> Course Details:</label>
                          <textarea class="form-control" name="details" rows="5" id="details
                          "><?php if (isset($_GET['editId'])) {
                                      if (isset($_POST['details'])) {
                                           echo $_POST['details'];
                                      }else{
                                           echo $CoursesAllData[0]->details;
                                    }
                                     
                                }
                                ?></textarea>
                          
                        </div>
                        <div class="form-group">
                        <label for="status">Select anyone:</label>
                            <select name="status" id="status">
                                <option value="on" selected="">Show In The Site</option>
                                <option value="off">Hide In The Site</option>
                            </select>
                        </div>
                        <button type="submit" name="<?php echo isset($_GET['editId'])? 'updateCourse':'addNewCourse' ?>" class="btn btn-success"><?php echo isset($_GET['editId'])? 'Update':'Submit' ?></button>
                        <?php if (isset($_GET['editId'])){ ?>
                            <a href="courses.php" class="btn btn-info">Cancle</a>
                       <?php } ?>
                            
                         
                      </form>
                    </div>
                    <div class="col-lg-6">
                        <?php 
                            $jsonCourseString = getJSONFromDB("select * from courses");
                            $Courses = json_decode($jsonCourseString);

                            include 'config/mysqlDb.php';
                            $deleSuccess = "";
                            if (isset($_POST['delete_id'])) {
                                $sqlDelete = "DELETE FROM courses WHERE id='".$_POST['delete_id']."'";
                                if(mysqli_query($conn, $sqlDelete)){
                                    $deleSuccess = '<div class="alert alert-success alert-dismissable notification">
                                               <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                               <strong><b>success!</b> Data successfully Deleted!</strong>
                                             </div>';
                                }else{
                                    $deleSuccess =  mysqli_error($conn);  
                                }
                            }

                        ?>
                        <table class="table table-bordered">
                            <thead>
                              <tr>
                                <th>No</th>
                                <th>Course Name</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                            <?php for ($i=0; $i <sizeof($Courses); $i++) { ?>
                              <tr>
                                <td><?php echo ($i+1) ?></td>
                                <td><?php echo $Courses[$i]->title; ?></td>
                                <td>
                                  <a href="courses.php?editId=<?php echo $Courses[$i]->id; ?>" class="btn btn-success">Edit</a>
                                  <a href="courses.php?deleteId=<?php echo $Courses[$i]->id; ?>" class="btn btn-danger delete_data" id="<?php echo $Courses[$i]->id; ?>" >Delete</a>
                                  <select name="statusChange" id="">
                                     <?php 
                                        if ($Courses[$i]->status == 'on') { ?>
                                            <option value="on">Show</option>
                                        <?php }else{ ?>
                                            <option value="off">Hide</option>
                                       <?php } ?>
                                  </select>
                                </td>
                              </tr>   
                              <?php } ?> 
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
<?php include 'template/footer.php'; ?>