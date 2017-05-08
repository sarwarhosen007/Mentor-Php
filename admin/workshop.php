<?php 
 $curentPage = "workshop";
 include 'template/head.php';
 include 'config/updateDb.php';

 $jsonWorkshopDataString = getJSONFromDB("select * from workshop where id ='".$_GET['editId']."'");
 $WorkshopAllData = json_decode($jsonWorkshopDataString);

?>
     <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                        Workshop Control Area
                            Upcoming Workshop
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i> Workshop
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
                <?php
                 $jsonWorkshopSubtitleString = getJSONFromDB("select * from section_subtitle where sectionName ='Workshop'");
                 $WorkshopData = json_decode($jsonWorkshopSubtitleString);

                     $success = $error = "";
                    if ( isset($_POST['submit']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
                        if (isset($_POST['subtitle'])
                            && (!empty($_POST['subtitle']))) {
                            $subtitle = $_POST['subtitle'];

                            $subSql = "UPDATE section_subtitle SET subtitle = '$subtitle' WHERE sectionName = 'Workshop'";

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
                              <label for="section_title">Edit Workshop Subtitle:</label>
                              <textarea class="form-control" name="subtitle" rows="5" id="featureSubtitle"><?php  

                                if (isset($_POST['subtitle'])) {
                                    echo $_POST['subtitle'];
                                }else{
                                    echo $WorkshopData[0]->subtitle;
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

                        if ( isset($_POST['addNewEducation']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
                               if (isset($_POST['title']) && isset($_POST['icon']) && isset($_POST['status']) && !empty($_POST['title']) && !empty($_POST['icon'])) {
                                     
                                     $title   = $_POST['title'];
                                     $icon = $_POST['icon'];
                                     $status = $_POST['status'];

                                     $sql = "INSERT into workshop (title,icon,status) values('$title','$icon','$status')";
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

                            if (isset($_POST['updateNewEducation'])  && $_SERVER['REQUEST_METHOD'] == 'POST') {
                                     
                                 if (isset($_POST['title']) && isset($_POST['icon']) && isset($_POST['status']) && !empty($_POST['title']) && !empty($_POST['icon']) & !empty($_POST['status'])) {

                                     $title   = $_POST['title'];
                                     $icon    = $_POST['icon'];
                                     $status  = $_POST['status'];

                                     $sqlUpdate = "UPDATE workshop SET title='$title',icon='$icon', status='$status' WHERE id='".$_GET['editId']."'";

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
                      <h2 style="color: red; ">Add new Upcoming Workshop</h2>
                      <?php
                         echo $addNewmessage;
                         echo $UpdateMessage;
                       
                      ?>
                      <form action="" method="post">
                        <div class="form-group">
                          <label for="title"><?php echo isset($_GET['editId'])?'Edit':'Add' ?> Workshop Title:</label>   
                          <input type="text" class="form-control" id="title" placeholder="Enter Column Title!" value="<?php echo isset($_GET['editId'])? $WorkshopAllData[0]->title :'' ?>" name="title">
                        </div>
                        <div class="form-group">
                          <label for="icon"><?php echo isset($_GET['editId'])?'Edit':'Add' ?> Workshop Icon:</label>
                          <input type="text" class="form-control" id="title" placeholder="Enter Column Title!" value="<?php echo isset($_GET['editId'])? $WorkshopAllData[0]->icon :'' ?>" name="icon">
                        </div>
                        <div class="form-group">
                        <label for="status">Select Anyone:</label>
                            <select name="status" id="status">
                                <option value="on" selected="">Show In The Site</option>
                                <option value="off">Hide In The Site</option>
                            </select>
                        </div>
                        
                        <button type="submit" name="<?php echo isset($_GET['editId'])? 'updateNewEducation':'addNewEducation' ?>" class="btn btn-success"><?php echo isset($_GET['editId'])? 'Update':'Submit' ?></button>
                        <?php if (isset($_GET['editId'])){ ?>
                            <a href="workshop.php" class="btn btn-info">Cancle</a>
                       <?php } ?>
                      </form>
                    </div>
                    <div class="col-lg-6">
                        <?php 

                            include 'config/mysqlDb.php';
                             $jsonWorkshopDataString = getJSONFromDB("select * from workshop");
                             $workshop = json_decode($jsonWorkshopDataString);
                            $deleSuccess = "";
                            if (isset($_POST['delete_id'])) {
                                $sqlDelete = "DELETE FROM workshop WHERE id='".$_POST['delete_id']."'";
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
                                <th>Workshop Title</th>
                                <th>Status</th>
                              </tr>
                            </thead>
                            <tbody>
                            <?php for ($i=0; $i <sizeof($workshop); $i++) { ?>
                              <tr>
                                <td><?php echo ($i+1) ?></td>
                                <td><?php echo $workshop[$i]->title; ?></td>
                                <td>
                                  <a href="workshop.php?editId=<?php echo $workshop[$i]->id; ?>" class="btn btn-success">Edit</a>
                                  <a href="workshop.php?deleteId=<?php echo $workshop[$i]->id; ?>" class="btn btn-danger delete_data" id="<?php echo $workshop[$i]->id; ?>" >Delete</a>
                                  <select name="statusChange" id="">
                                     <?php 
                                        if ($workshop[$i]->status == 'on') { ?>
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