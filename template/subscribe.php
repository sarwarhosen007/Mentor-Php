<?php 
    
 $addNewmessage = "";

 if (isset($_POST['Subscribe']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
     if (isset($_POST['email']) && !empty($_POST['email'])) {
         $email = $_POST['email'];
         $date = date("Y m d");
          

         $sql = "INSERT INTO subscriber (email,date) VALUES ('$email','$date')";

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
                  <strong>Warning!</strong> Insert Email First.
               </div>';
                
          }
 }
?>

<!--Cta-->
    <section id="cta-2">
      <div class="container">
        <div class="row">
            <?php echo $addNewmessage; ?>
            <div class="col-lg-12">
              <h2 class="text-center">Subscribe Now</h2>
              <p class="cta-2-txt">Sign up for our free weekly software design courses, we’ll send them right to your inbox.</p>
             <div class="cta-2-form text-center">
              <form action="" method="post" id="workshop-newsletter-form">
                    <input name="email" placeholder="Enter Your Email Address" type="email">
                    <input class="cta-2-form-submit-btn" value="Subscribe" name="Subscribe" type="submit">
                </form>
             </div>   
            </div>
        </div>
      </div>
    </section>
    <!--/ Cta-->