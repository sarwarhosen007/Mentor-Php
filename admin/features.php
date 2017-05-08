<?php 
 $curentPage = "features";
 include 'template/head.php';
 include 'config/updateDb.php';

 $jsonFeatureSubtitleString = getJSONFromDB("select * from section_subtitle where sectionName ='Features'");

$FeaturesData = json_decode($jsonFeatureSubtitleString);

$jsonFeatureDataString = getJSONFromDB("select * from features where id ='".$_GET['editId']."'");
$Features = json_decode($jsonFeatureDataString);


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
              
                      <?php 
                $addNewmessage = "";
                     

                        include 'config/mysqlDb.php';
                         
                        

                        if ( isset($_POST['addNewFeature']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
                              
                               if (isset($_POST['title']) && isset($_POST['icon']) && isset($_POST['body'])  && !empty($_POST['title']) && !empty($_POST['icon']) && !empty($_POST['body'])) {
                                     
                                     $title          = $_POST['title'];
                                     $icon           = $_POST['icon'];
                                     $body           = $_POST['body'];
                                     $status         = $_POST['status'];

                                     $sql = "INSERT into features (title,icon,body,status) values('$title','$icon','$body','$status')";
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

                            if (isset($_POST['updateNewFeature'])) {
                                     
                                 if (isset($_POST['title']) && isset($_POST['icon']) && isset($_POST['body'])  && !empty($_POST['title']) && !empty($_POST['icon']) && !empty($_POST['body'])) {

                                     $title         = $_POST['title'];
                                     $icon           = $_POST['icon'];
                                     $body           = $_POST['body'];
                                     $status           = $_POST['status'];

                                     $sqlUpdate = "UPDATE features SET title='$title', icon='$icon', body='$body',status='$status' WHERE id='".$_GET['editId']."'";

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
                       <h2 style="color: red; ">Add new Feature</h2>
                      <?php
                         echo $addNewmessage;
                         echo $UpdateMessage;
                         //print_r($message);
                      ?>
                      <form action="" method="post">
                        <div class="form-group">
                          <label for="title"><?php echo isset($_GET['editId'])? 'Edit':'Add' ?> New Features Title:</label>
                          <input type="text" class="form-control" id="title" placeholder="Enter Plan Name!" value="<?php if (isset($_GET['editId'])){
                                       if (isset($_POST['title'])) {
                                            echo $_POST['title'];
                                       }else{
                                         echo $Features[0]->title;
                                       }
                                    }
                                ?>" name="title">
                        </div>
                        <div class="form-group">
                          <label for="icon"><?php echo isset($_GET['editId'])? 'Edit':'Add New' ?> Feature Icon:</label>
                          <input type="text" class="form-control" id="icon" placeholder="Enter Icon Name!" value="<?php if (isset($_GET['editId'])){
                                       if (isset($_POST['icon'])) {
                                            echo $_POST['icon'];
                                       }else{
                                         echo $Features[0]->icon;
                                       }
                                    }
                                ?>" name="icon">
                        </div>
                        <div class="form-group">
                          <label for="body"><?php echo isset($_GET['editId'])? 'Edit':'Add New' ?>  Feature Body:</label>
                          <textarea class="form-control" name="body" rows="5" id="body
                          "><?php if (isset($_GET['editId'])) {
                                      if (isset($_POST['body'])) {
                                           echo $_POST['body'];
                                      }else{
                                           echo $Features[0]->body;
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
                        <button type="submit" name="<?php echo isset($_GET['editId'])? 'updateNewFeature':'addNewFeature' ?>" class="btn btn-success"><?php echo isset($_GET['editId'])? 'Update':'Submit' ?></button>
                        <?php if (isset($_GET['editId'])){ ?>
                            <a href="features.php" class="btn btn-info">Cancle</a>
                       <?php } ?>
                            
                         
                      </form>
                    </div>
                    <div class="col-lg-6">
                        <?php 
                            $jsonFeaturesString = getJSONFromDB("select * from features");
                            $FeaturesData = json_decode($jsonFeaturesString);

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

                        ?>
                        <table class="table table-bordered">
                            <thead>
                              <tr>
                                <th>No</th>
                                <th>Plan Name</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                            <?php for ($i=0; $i <sizeof($FeaturesData); $i++) { ?>
                              <tr>
                                <td><?php echo ($i+1) ?></td>
                                <td><?php echo $FeaturesData[$i]->title; ?></td>
                                <td>
                                  <a href="features.php?editId=<?php echo $FeaturesData[$i]->id; ?>" class="btn btn-success">Edit</a>
                                  <a href="features.php?deleteId=<?php echo $FeaturesData[$i]->id; ?>" class="btn btn-danger delete_data" id="<?php echo $FeaturesData[$i]->id; ?>" >Delete</a>
                                  <select name="statusChange" id="">
                                     <?php 
                                        if ($FeaturesData[$i]->status == 'on') { ?>
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

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
<?php include 'template/footer.php'; ?>