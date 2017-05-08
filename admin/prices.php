<?php 
 $curentPage = "prices";
 include 'template/head.php';
 include 'config/updateDb.php';

 $jsonPricesSubtitleString = getJSONFromDB("select * from section_subtitle where sectionName ='Prices'");
$PricessData = json_decode($jsonPricesSubtitleString);

 $jsonPricessDataString = getJSONFromDB("select * from prices where id ='".$_GET['editId']."'");
 $PricessAllData = json_decode($jsonPricessDataString);

?>
     <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Price Control Area!
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i> Prices
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

                            $subSql = "UPDATE section_subtitle SET subtitle = '$subtitle' WHERE sectionName = 'Prices'";

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
                              <label for="section_title">Edit Prices Subtitle:</label>
                              <textarea class="form-control" name="subtitle" rows="5" id="coursesSubtitle"><?php  

                                if (isset($_POST['subtitle'])) {
                                    echo $_POST['subtitle'];
                                }else{
                                    echo $PricessData[0]->subtitle;
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

                        if ( isset($_POST['addNewPrice']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
                              
                               if (isset($_POST['plan_name']) && isset($_POST['price'])  && !empty($_POST['plan_name']) && !empty($_POST['price'])) {
                                     
                                     $plan_name       = $_POST['plan_name'];
                                     $price           = $_POST['price'];
                                     $status          = $_POST['status'];

                                     $sql = "INSERT into prices (plan_name,price,status) values('$plan_name','$price','$status')";
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

                            if (isset($_POST['updatePrice'])) {
                                     
                                 if (isset($_POST['plan_name']) && isset($_POST['price'])  && !empty($_POST['plan_name']) && !empty($_POST['price'])) {

                                     $plan_name       = $_POST['plan_name'];
                                     $price           = $_POST['price'];
                                     $status          = $_POST['status'];

                                     $sqlUpdate = "UPDATE prices SET plan_name='$plan_name', price='$price', status='$status' WHERE id='".$_GET['editId']."'";

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
                       <h2 style="color: red; ">Add new Plan</h2>
                      <?php
                         echo $addNewmessage;
                         echo $UpdateMessage;
                         //print_r($message);
                      ?>
                      <form action="" method="post">
                        <div class="form-group">
                          <label for="title"><?php echo isset($_GET['editId'])? 'Edit':'Add' ?> Plan Name:</label>
                          <input type="text" class="form-control" id="plan_name" placeholder="Enter Plan Name!" value="<?php if (isset($_GET['editId'])){
                                       if (isset($_POST['plan_name'])) {
                                            echo $_POST['plan_name'];
                                       }else{
                                         echo $PricessAllData[0]->plan_name;
                                       }
                                    }
                                ?>" name="plan_name">
                        </div>
                        <div class="form-group">
                          <label for="price"><?php echo isset($_GET['editId'])? 'Edit':'Add' ?> Price:</label>
                          <input type="number" class="form-control" id="price" placeholder="Enter Price!" value="<?php if (isset($_GET['editId'])){
                                       if (isset($_POST['price'])) {
                                            echo $_POST['price'];
                                       }else{
                                         echo $PricessAllData[0]->price;
                                       }
                                    }
                                ?>" name="price">
                        </div>
                        <div class="form-group">
                        <label for="status">Select anyone:</label>
                            <select name="status" id="status">
                                <option value="on" selected="">Show In The Site</option>
                                <option value="off">Hide In The Site</option>
                            </select>
                        </div>
                        <button type="submit" name="<?php echo isset($_GET['editId'])? 'updatePrice':'addNewPrice' ?>" class="btn btn-success"><?php echo isset($_GET['editId'])? 'Update':'Submit' ?></button>
                        <?php if (isset($_GET['editId'])){ ?>
                            <a href="prices.php" class="btn btn-info">Cancle</a>
                       <?php } ?>
                            
                         
                      </form>
                    </div>
                    <div class="col-lg-6">
                        <?php 
                            $jsonPricesString = getJSONFromDB("select * from prices");
                            $Prices = json_decode($jsonPricesString);

                            include 'config/mysqlDb.php';
                            $deleSuccess = "";
                            if (isset($_POST['delete_id'])) {
                                $sqlDelete = "DELETE FROM prices WHERE id='".$_POST['delete_id']."'";
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
                            <?php for ($i=0; $i <sizeof($Prices); $i++) { ?>
                              <tr>
                                <td><?php echo ($i+1) ?></td>
                                <td><?php echo $Prices[$i]->plan_name; ?></td>
                                <td>
                                  <a href="prices.php?editId=<?php echo $Prices[$i]->id; ?>" class="btn btn-success">Edit</a>
                                  <a href="prices.php?deleteId=<?php echo $Prices[$i]->id; ?>" class="btn btn-danger delete_data" id="<?php echo $Prices[$i]->id; ?>" >Delete</a>
                                  <select name="statusChange" id="">
                                     <?php 
                                        if ($Prices[$i]->status == 'on') { ?>
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