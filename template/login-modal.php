<?php

session_start();

require 'admin/config/selectData.php';


$jsonAdminDataString = getJSONFromDB("select * from admin_login");

$AdminData = json_decode($jsonAdminDataString);

$error = $username = $check = "";

if ( isset($_POST['submit']) && ($_SERVER['REQUEST_METHOD'] == 'POST')) {
   if (isset($_POST['username']) && isset($_POST['password']) && !empty($_POST['username']) && !empty($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        $usernameFromDb = $AdminData[0]->email;
        $passwordFromDb = $AdminData[0]->password;

        if (($username == $usernameFromDb) && ($password == $passwordFromDb)) {
           $_SESSION['adminEmail'] = $usernameFromDb;
           header("Location: admin/index.php");
        }else{
              
           $error = '<div class="alert alert-danger alert-dismissable notification">
                      <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                      <strong>Error!</strong> Username and Password not match. 
                    </div>';
            }
     
   }else{
    $error = '<div class="alert alert-info alert-dismissable notification">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
              <strong>Error!</strong> Please first set Username and Password.
            </div>';
   }
}

?>

<!--Modal box-->
    <div class="modal fade" id="login" role="dialog">
      <div class="modal-dialog modal-sm">
      
        <!-- Modal content no 1-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title text-center form-title">Login</h4>
          </div>
          <div class="modal-body padtrbl">

            <div class="login-box-body">
               <?php echo $error; ?>
              <p class="login-box-msg">Sign in to start your session</p>
              <div class="form-group">
                <form name="" id="loginForm" action="" method="post">

                 <div class="form-group has-feedback"> 
                      <input class="form-control" name="username" placeholder="Username or Email"  id="loginid" type="text"/> 
            <span style="display:none;font-weight:bold; position:absolute;color: red;position: absolute;padding:4px;font-size: 11px;background-color:rgba(128, 128, 128, 0.26);z-index: 17;  right: 27px; top: 5px;" id="span_loginid"></span><!---Alredy exists  ! -->
                      <span class="fa fa-user form-control-feedback"></span>
                  </div>
                  <div class="form-group has-feedback">
                      <input class="form-control" name="password" placeholder="Password" id="loginpsw" type="password" autocomplete="off" />
            <span style="display:none;font-weight:bold; position:absolute;color: grey;position: absolute;padding:4px;font-size: 11px;background-color:rgba(128, 128, 128, 0.26);z-index: 17;  right: 27px; top: 5px;" id="span_loginpsw"></span><!---Alredy exists  ! -->
                      <span class="fa fa-lock form-control-feedback"></span>
                  </div>
                  <div class="row">
                      <div class="col-xs-12">
                          <div class="checkbox icheck">
                              <label>
                                <input type="checkbox" id="loginrem" > Remember Me
                              </label>
                          </div>
                      </div>
                      <div class="col-xs-12">
                          <button type="submit" name="submit" class="btn btn-green btn-block btn-flat" onclick="userlogin()">Sign In</button>
                      </div>
                  </div>

                </form>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
    <!--/ Modal box-->