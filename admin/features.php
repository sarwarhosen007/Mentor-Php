<?php 
 $curentPage = "features";
 include 'template/head.php';

 include 'config/updateDb.php';

 $jsonFeatureSubtitleString = getJSONFromDB("select * from section_subtitle where sectionName ='Features'");

$FeaturesData = json_decode($jsonFeatureSubtitleString);

$jsonFeatureDataString = getJSONFromDB("select * from features");
$Features = json_decode($jsonFeatureDataString);
 

function featureTitle($editId){
    $jsonFeatureDataString = getJSONFromDB("SELECT feature_title FROM features WHERE id='".$editId."'");
    $Features = json_decode($jsonFeatureDataString);
    return $Features[0]->feature_title;
}

function featureIcon($editId){

    $jsonFeatureDataString = getJSONFromDB("SELECT feature_icon FROM features WHERE id='".$editId."'");
    $Features = json_decode($jsonFeatureDataString);
    return $Features[0]->feature_icon;
}

function featureBody($editId){

    $jsonFeatureDataString = getJSONFromDB("SELECT feature_body FROM features WHERE id='".$editId."'");
    $Features = json_decode($jsonFeatureDataString);
    return $Features[0]->feature_body;
}

$Updatesuccess = $Updateerror = "";

if (isset($_GET['editId'])) {

    if (isset($_POST['updateFeature'])) {
             
         if (isset($_POST['title']) && isset($_POST['icon']) && isset($_POST['featureBody']) && !empty($_POST['title']) && !empty($_POST['icon']) && !empty($_POST['featureBody'])) {

             $title = $_POST['title'];
             $icon = $_POST['icon'];
             $featureBody = $_POST['featureBody'];

             $sqlUpdate = "UPDATE features SET feature_title='$title',feature_icon='$icon', feature_body='$featureBody' WHERE id='".$_GET['editId']."'";

             if(updateDB($sqlUpdate)==1){
                
               $Updatesuccess = '<div class="alert alert-success alert-dismissable notification">
                   <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                   <strong><b>success!</b> Data updated successfully!</strong>
                 </div>'; 
                 
            }else{

                 $Updateerror = '<div class="alert alert-danger alert-dismissable notification">
                   <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                   <strong><b>Info!</b> Not updated!</strong>
                 </div>'; 
              }

        }
    }
}
include 'config/mysqlDb.php';
$deleSuccess = "";
if (isset($_POST['delete_id'])) {
    $sqlDelete = "DELETE FROM features WHERE id='".$_POST['delete_id']."'";
    if(mysqli_query($conn, $sqlDelete)){
        $deleSuccess = '<div class="alert alert-success alert-dismissable notification">
                   <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                   <strong><b>success!</b> Data successfully Deleted!</strong>
                 </div>';

    }else{
        $deleSuccess =  mysqli_error($conn);  
    }
}

 $statusSuccess = "";
/*if (isset($_POST['btnstatus'])) {

    $status = $_POST['btnstatus'];
    $status_id = $_GET['status_id'];

    if ($status == "active") {
        $sqlStatus = "UPDATE features SET status='deactive' WHERE id = '$status_id'";
        echo $sqlStatus;
        if(updateDB($sqlStatus)==1){
           $statusSuccess = '<div class="alert alert-success alert-dismissable notification">
                   <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                   <strong><b>success!</b> Successfully Deactive!</strong>
                 </div>';
        }
    }else{
        $sqlStatus = "UPDATE features SET status='active' WHERE id = '$status_id'";

        if(updateDB($sqlStatus)==1){
           $statusSuccess = '<div class="alert alert-success alert-dismissable notification">
                   <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                   <strong><b>success!</b> Successfully Active!</strong>
                 </div>';
        }
    }
      
}*/
?>
     <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Features Control Area
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i> Features
                            </li>
                        </ol>
                    </div>
                </div>
                <?php

                     
                     $success = $error = "";
                    if ( isset($_POST['submit']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
                        if (isset($_POST['subtitle'])
                            && (!empty($_POST['subtitle']))) {
                            $subtitle = $_POST['subtitle'];

                            $subSql = "UPDATE section_subtitle SET subtitle = '$subtitle' WHERE sectionName = 'Features'";

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
                              <label for="section_title">Edit Features Subtitle:</label>
                              <textarea class="form-control" name="subtitle" rows="5" id="featureSubtitle"><?php  

                                if (isset($_POST['subtitle'])) {
                                    echo $_POST['subtitle'];
                                }else{
                                    echo $FeaturesData[0]->subtitle;
                                }
                                ?></textarea>
                            </div>
                            <button type="submit" name="submit" class="btn btn-info">Update</button>
                        </form>   
                    </div>
                </div>
                <!-- /.row -->
                <hr>
                <div class="row">
                    <?php 
                    $AddNewerror = $addNewSuccess = "";
                     

                        include 'config/mysqlDb.php';

                        if ( isset($_POST['addNewFeature']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
                               if (isset($_POST['title']) && isset($_POST['icon']) && isset($_POST['featureBody']) && !empty($_POST['title']) && !empty($_POST['icon']) && !empty($_POST['featureBody'])) {
                                     
                                     $title = $_POST['title'];
                                     $icon = $_POST['icon'];
                                     $featureBody = $_POST['featureBody'];

                                     $sql = "INSERT into features (feature_title,feature_icon,feature_body,status) values('$title','$icon','$featureBody','deactive')";
                                     if(mysqli_query($conn, $sql)){
                                            $addNewSuccess = 
                                        '<div class="alert alert-success alert-dismissable notification">
                                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                            <strong>Success!</strong> The Value Insertered Successfully.
                                         </div>';

                                     }else{
                                           $AddNewerror = '<div class="alert alert-danger alert-dismissable notification">
                                           <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                           <strong><b>Error!</b> You Can not set empty value!</strong>
                                         </div>';
                                          
                                    } 
                                }
                                   
                           } 
                    ?>

                    <div class="col-lg-6">
                        <form action="" method="post">
                            <div class="form-group">
                            <?php echo $addNewSuccess; ?>
                            <?php echo $AddNewerror; ?>
                            <?php echo $Updatesuccess; ?>
                            <?php echo $Updateerror; ?>
                              <label for="Featuretitle">
                              <?php  if (isset($_GET['editId'])) {
                                  echo "Edit ";
                              }else{
                                  echo "Add New";
                                } ?>
                               Features Title:

                              </label>

                              <?php  if (isset($_GET['editId'])) { ?>
                                   <input type="text" class="form-control" name="title" id="featureTitle" value="<?php echo featureTitle($_GET['editId']); ?>">
                             <?php }else{ ?>
                                     <input type="text" class="form-control" name="title" id="featureTitle" placeholder="Enter Feature Title!">
                               <?php } ?>
                               
                            </div>
                            <div class="form-group">
                                <label for="FeatureIcon">
                                  <?php  if (isset($_GET['editId'])) {
                                      echo "Edit ";
                                  }else{
                                      echo "Add New";
                                    } ?>
                                   Feature Icon:

                                </label>

                                <?php  if (isset($_GET['editId'])) { ?>
                                   <input type="text" class="form-control" name="icon" id="featureIcon" value="<?php echo featureIcon($_GET['editId']); ?>">
                                <?php }else{ ?>
                                     <input type="text" class="form-control" name="icon" placeholder="Enter Feature Icon!">
                                <?php } ?>

                            </div>
                            <div class="form-group">
                               <label for="FeatureBody">
                                  <?php  if (isset($_GET['editId'])) {
                                      echo "Edit ";
                                  }else{
                                      echo "Add New";
                                    } ?>
                                   Feature Body:

                                </label>

                                  <?php  if (isset($_GET['editId'])) { ?>
                                    <textarea class="form-control" name="featureBody" rows="5" id="featureBody"><?php echo featureBody($_GET['editId']); ?></textarea>
                                <?php }else{ ?>
                                      <textarea class="form-control" name="featureBody" rows="5" id="featureBody"></textarea>
                                <?php } ?>
                            </div>
                               <button type="submit" name="<?php echo isset($_GET['editId'])? 'updateFeature':'addNewFeature' ?>" class="btn btn-success"><?php echo isset($_GET['editId'])? 'Update':'Submit' ?></button>
                                <?php if (isset($_GET['editId'])){ ?>
                                    <a href="features.php" class="btn btn-info">Cancle</a>
                               <?php } ?>
                        </form>   
                    </div>
                       
                     
                    <div class="col-lg-6">
                    <?php echo $deleSuccess; ?>
                    <?php echo $statusSuccess; ?>
                    <?php 
                     
                         $statusSuccess = "";
                            if (isset($_POST['btnstatus'])) {

                                $status = $_POST['btnstatus'];
                                $status_id = $_GET['status_id'];
                                 
                                if ($status == "active") {
                                    $sqlStatus = "UPDATE features SET status='deactive' WHERE id = '$status_id'";
                                    echo $sqlStatus;
                                    if(updateDB($sqlStatus)==1){
                                       $statusSuccess = '<div class="alert alert-success alert-dismissable notification">
                                               <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                               <strong><b>success!</b> Successfully Deactive!</strong>
                                             </div>';
                                    }
                                }else{
                                    $sqlStatus = "UPDATE features SET status='active' WHERE id = '$status_id'";

                                    if(updateDB($sqlStatus)==1){
                                       $statusSuccess = '<div class="alert alert-success alert-dismissable notification">
                                               <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                               <strong><b>success!</b> Successfully Active!</strong>
                                             </div>';
                                    }
                                }
                                  
                            }
                    
                     ?>

                        <table class="table table-bordered">
                            <thead>
                              <tr>
                                <th>No</th>
                                <th>Feature Title</th>
                                <th>Status</th>
                              </tr>
                            </thead>
                            <tbody>
                            <?php for ($i=0; $i <sizeof($Features); $i++) { ?>
                              <tr>
                                <td><?php echo ($i+1) ?></td>
                                <td><?php echo $Features[$i]->feature_title; ?></td>
                                <td>
                                  <a href="features.php?editId=<?php echo $Features[$i]->id; ?>" class="btn btn-default">Edit</a>
                                   <?php if ($Features[$i]->status == 'active') { ?>

        
                                            <a href="features.php?status='<?php echo $Features[$i]->status; ?>'&status_id='<?php echo $Features[$i]->id; ?>'" class="btn btn-primary btn-status" id="<?php echo $Features[$i]->status; ?>">Active
                                            </a>
                                             
                                        <?php }else{ ?>
                                               <a href="features.php?status='<?php echo $Features[$i]->status; ?>'&status_id='<?php echo $Features[$i]->id; ?>'" class="btn btn-default btn-status" id="<?php echo $Features[$i]->status; ?>">Deactive
                                            </a>
                                         <?php }
                                        
                                  
                                    ?>
                                   

                                  <a href="features.php?deleteId=<?php echo $Features[$i]->id; ?>" class="btn btn-danger delete_data" id="<?php echo $Features[$i]->id; ?>" >Delete</a>
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