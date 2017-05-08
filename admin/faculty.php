<?php 
 $curentPage = "faculty";
 include 'template/head.php';
 include 'config/updateDb.php';
 $jsonFacultyString = getJSONFromDB("select * from faculty where id ='".$_GET['editId']."'");
 $FacultyAllData = json_decode($jsonFacultyString);

?>
     <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Faculty Control Area
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-user"></i> Faculty
                            </li>
                        </ol>
                    </div>
                </div>
                <?php
                $jsonFacultySubtitleString = getJSONFromDB("select * from section_subtitle where sectionName ='Faculty'");
               $FacultyData = json_decode($jsonFacultySubtitleString);
 
                     $success = $error = "";
                    if ( isset($_POST['submit']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
                        if (isset($_POST['subtitle'])
                            && (!empty($_POST['subtitle']))) {
                            $subtitle = $_POST['subtitle'];

                            $subSql = "UPDATE section_subtitle SET subtitle = '$subtitle' WHERE sectionName = 'Faculty'";

                            if(updateDB($subSql)==1){
                               $success = '<div class="alert alert-success alert-dismissable notification">
                                   <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                   <strong><b>success!</b> Data updated successfully!</strong>
                                 </div>'; 
                            }
                        }else{
                            $error = '<div class="alert alert-info alert-dismissable notification">
                                   <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                   <strong><b>Error!</b> Data not updated!</strong>
                                 </div>';

                        }
                    }

                 ?>
                <div class="row">
                    <?php echo $success; ?>
                    <?php echo $error; ?>
                    <div class="col-lg-6">
                        <form action="" method="post">
                            <div class="form-group">
                              <label for="section_title">Edit Faculty Subtitle:</label>
                              <textarea class="form-control" name="subtitle" rows="5" id="FacultySubtitle"><?php  

                                if (isset($_POST['subtitle'])) {
                                    echo $_POST['subtitle'];
                                }else{
                                    echo $FacultyData[0]->subtitle;
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
                         
                        $message = array();

                        if ( isset($_POST['addNewFaculty']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
                              
                               if (isset($_POST['name']) && isset($_POST['position']) && isset($_POST['details']) && !empty($_POST['name']) && !empty($_POST['position']) && !empty($_POST['details'])) {
                                     
                                     $name           = $_POST['name'];
                                     $position       = $_POST['position'];
                                     $details        = $_POST['details'];
                                     $status         = $_POST['status'];

                                     if (isset($_FILES['facultyImage']['name'])) {
                                          $target_dir = "image/";
                                      $target_file = $target_dir . basename($_FILES["facultyImage"]["name"]);
                                      $uploadOk = 1;
                                      $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
                                      // Check if image file is a actual image or fake image
                                          $check = getimagesize($_FILES["facultyImage"]["tmp_name"]);
                                          if($check !== false) {
                                              //echo "File is an image - " . $check["mime"] . ".";
                                              $uploadOk = 1;
                                          } else {
                                              $message[] = "File is not an image.";
                                              $uploadOk = 0;
                                          }

                                      // Check if file already exists
                                      if (file_exists($target_file)) {
                                          $message[] =  "Sorry, file already exists.";
                                          $uploadOk = 0;
                                      }
                                      // Check file size
                                      if ($_FILES["facultyImage"]["size"] > 500000) {
                                          $message .= "Sorry, your file is too large.";
                                          $uploadOk = 0;
                                      }
                                      // Allow certain file formats
                                      if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                                      && $imageFileType != "gif" ) {
                                          $message[]= "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                                          $uploadOk = 0;
                                      }
                                      // Check if $uploadOk is set to 0 by an error
                                      if ($uploadOk == 0) {
                                          $message[]=  "Sorry, your file was not uploaded.";
                                      // if everything is ok, try to upload file
                                      } else {
                                          if (move_uploaded_file($_FILES["facultyImage"]["tmp_name"], $target_file)) {
                                              $facultyImage =$target_file;
                                          } else {
                                              $message[]=  "Sorry, there was an error uploading your file.";
                                          }
                                      }
                                     }
                                     //print_r($_FILES["facultyImage"]["tmp_name"]);   
                                     $sql = "INSERT into faculty (name,position,details,status,image_url) values('$name','$position','$details','$status','$facultyImage')"
                                     ;
                                     if(mysqli_query($conn, $sql)){
                                            $addNewmessage = 
                                        '<div class="alert alert-success alert-dismissable notification">
                                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                            <strong>Success!</strong> The Value Insertered Successfully.
                                         </div>';

                                     }else{
                                           $addNewmessage = mysqli_error($conn);
                                          
                                    } 
                                }else{
                                   $addNewmessage = 
                                        '<div class="alert alert-success alert-dismissable notification">
                                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                            <strong>Warning!</strong> Insert Value First.
                                         </div>';
                                          
                                    } 
                                   
                           }
                        $UpdateMessage = "";

                        if (isset($_GET['editId'])) {

                            if (isset($_POST['updateFaculty'])) {
                                     
                                 if (isset($_POST['name']) && isset($_POST['position']) && isset($_POST['details']) && !empty($_POST['name']) && !empty($_POST['position']) && !empty($_POST['details'])) {

                                     $name     = $_POST['name'];
                                     $position = $_POST['position'];
                                     $details  = $_POST['details'];
                                     $status   = $_POST['status'];

                                     $sqlUpdate = "UPDATE faculty SET name='$name',position='$position', details='$details', status='$status' WHERE id='".$_GET['editId']."'";

                                     if(updateDB($sqlUpdate)==1){
                                        
                                       $UpdateMessage = '<div class="alert alert-success alert-dismissable notification">
                                           <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                           <strong><b>success!</b> Data updated successfully!</strong>
                                         </div>'; 
                                         
                                    }else{

                                         $UpdateMessage = '<div class="alert alert-danger alert-dismissable notification">
                                           <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                           <strong><b>Info!</b> Not updated!</strong>
                                         </div>'; 
                                      }

                                }
                            }
                        } 
                    ?>
                <div class="row">
                    <div class="col-lg-6"> 
                       <h2 style="color: red; ">Add new Faculty Member</h2>
                      <?php
                         echo $addNewmessage;
                         echo $UpdateMessage;
                       
                      ?>
                      <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                          <label for="name"><?php echo isset($_GET['editId'])? 'Edit':'Add' ?> Name:</label>
                          <input type="text" class="form-control" id="name" placeholder="Enter Faculty Name!" value="<?php if (isset($_GET['editId'])){
                                       if (isset($_POST['name'])) {
                                            echo $_POST['name'];
                                       }else{
                                         echo $FacultyAllData[0]->name;
                                       }
                                    }
                                ?>" name="name">
                        </div>
                        <div class="form-group">
                          <label for="percent"><?php echo isset($_GET['editId'])? 'Edit':'Add' ?> Position:</label>
                          <input type="text" class="form-control" id="positon" placeholder="Enter Position!" value="<?php if (isset($_GET['editId'])){
                                       if (isset($_POST['position'])) {
                                            echo $_POST['position'];
                                       }else{
                                         echo $FacultyAllData[0]->position;
                                       }
                                    }
                                ?>" name="position">
                        </div>

                        <div class="form-group">
                        
                             <img  src="<?php echo isset($_GET['editId'])? $FacultyAllData[0]->image_url:'image/default.png' ?>" class="img-thumbnail" alt="Cinque Terre" width="100" height="100" id="output">
                          
                            
                        </div> 
                        <div class="form-group">
                          <label for="image"><?php echo isset($_GET['editId'])? 'Edit':'Add' ?> Image</label>
                           <input type="file" name="facultyImage" id="facultyImage" onchange="loadFile(event)">
                        </div>
                          <div class="form-group">
                          <label for="icon"><?php echo isset($_GET['editId'])? 'Edit':'Add' ?> Details:</label>
                          <textarea class="form-control" name="details" rows="5" id="details
                          "><?php if (isset($_GET['editId'])) {
                                      if (isset($_POST['details'])) {
                                           echo $_POST['details'];
                                      }else{
                                           echo $FacultyAllData[0]->details;
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
                        <button type="submit" name="<?php echo isset($_GET['editId'])? 'updateFaculty':'addNewFaculty' ?>" class="btn btn-success"><?php echo isset($_GET['editId'])? 'Update':'Submit' ?></button>
                        <?php if (isset($_GET['editId'])){ ?>
                            <a href="faculty.php" class="btn btn-info">Cancle</a>
                       <?php } ?>
                            
                         
                      </form>
                    </div>
                    <div class="col-lg-6">
                        <?php 
                            $jsonFacultyString = getJSONFromDB("select * from faculty");
                            $Faculty = json_decode($jsonFacultyString);

                            include 'config/mysqlDb.php';
                            $deleSuccess = "";
                            if (isset($_POST['delete_id'])) {
                                $sqlDelete = "DELETE FROM faculty WHERE id='".$_POST['delete_id']."'";
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
                                <th>Name</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                            <?php for ($i=0; $i <sizeof($Faculty); $i++) { ?>
                              <tr>
                                <td><?php echo ($i+1) ?></td>
                                <td><?php echo $Faculty[$i]->name; ?></td>
                                <td>
                                  <a href="faculty.php?editId=<?php echo $Faculty[$i]->id; ?>" class="btn btn-success">Edit</a>
                                  <a href="faculty.php?deleteId=<?php echo $Faculty[$i]->id; ?>" class="btn btn-danger delete_data" id="<?php echo $Faculty[$i]->id; ?>" >Delete</a>
                                  <select name="statusChange" id="">
                                     <?php 
                                        if ($Faculty[$i]->status == 'on') { ?>
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