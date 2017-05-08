<?php 
 $curentPage = "index";
 include 'template/head.php';

?>
     <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Subscribe  Area
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-sun-o"></i> Subscribe
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

               <?php 
                  $jsonSubscribeString = getJSONFromDB("select * from subscriber");
                 $SubscribeAllData = json_decode($jsonSubscribeString);

                 include 'config/mysqlDb.php';
                            $deleSuccess = "";
                            if (isset($_POST['delete_id'])) {
                                $sqlDelete = "DELETE FROM subscriber WHERE id='".$_POST['delete_id']."'";
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
                <div class="row">
                     <div class="col-lg-6">
                         <h1 class="page-header">
                             All Subscriber List
                         </h1>
                        <div class="panel panel-primary">
                          <div class="panel-heading">List of Subscriber</div>
                          <div class="panel-body">
                              <table class="table table-hover">
                                <thead>
                                  <tr>
                                    <th>No</th>
                                    <th>Email</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                  </tr>
                                </thead>
                                <tbody>
                                   <?php for ($i=0; $i <sizeof($SubscribeAllData); $i++) { ?>
                                        <tr>
                                            <td><?php echo ($i+1) ?></td>
                                            <td><?php echo $SubscribeAllData[$i]->email; ?></td>
                                            <td><?php echo $SubscribeAllData[$i]->date; ?></td>
                                            <td>
                                                <a href="subscribe.php?deleteId=<?php echo $SubscribeAllData[$i]->id; ?>" class="btn btn-danger delete_data" id="<?php echo $SubscribeAllData[$i]->id; ?>" >Delete</a>
                                            </td>
                                        </tr>
                                   <?php } ?>
                                </tbody>
                              </table>
                          </div>
                          <ul class="pagination">
                            <li><a href="subscribe.php?selectId=">1</a></li>
                            <li class="active"><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#">4</a></li>
                            <li><a href="#">5</a></li>
                          </ul>
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