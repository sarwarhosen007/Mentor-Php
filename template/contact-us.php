<!--Contact-->
    <section id ="contact" class="section-padding">
      <div class="container">
        <div class="row">
          <div class="header-section text-center">
            <h2>Contact Us</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Exercitationem nesciunt vitae,<br> maiores, magni dolorum aliquam.</p>
            <hr class="bottom-line">
          </div>
          <?php
          $messageNotification = "";
                if (isset($_POST['SendMessage']) && ($_SERVER['REQUEST_METHOD']=='POST')) {
                    if (isset($_POST['name']) && !empty($_POST['name']) && isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['subject']) && !empty($_POST['subject']) && isset($_POST['message']) && !empty($_POST['message'])) {

                        $name = $_POST['name'];
                        $email = $_POST['email'];
                        $subject = $_POST['subject'];
                        $message = $_POST['message'];

                        $sqlMessage = "INSERT INTO message(name,email,subject,message_body) VALUES('$name','$email','$subject','$message')";
                        if(mysqli_query($conn, $sqlMessage)){

                                 $mailMessage = "Name: $name \n\n Message Body: $message";
                              if (mail("sarwarhosen007@gmail.com", $subject, $message,$email)){
                                     $messageNotification = 
                                      '<div class="alert alert-success alert-dismissable notification">
                                          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                          <strong>Success!</strong> The Message Sent Successfully.
                                       </div>';
                              }

                         }else{
                               $messageNotification = mysqli_error($conn);
                              
                         } 
                       
                    }else{
                        $messageNotification = '<div class="alert alert-info alert-dismissable notification">
                          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                           <strong><b>Error!</b> Message Not Sent!</strong>
                            </div>';
                    }
                }

           ?>


           <?php echo $messageNotification; ?> 
           
          <form action="index.php" method="post" role="form" class="contactForm">
              <div class="col-md-6 col-sm-6 col-xs-12 left">
                <div class="form-group">
                    <input type="text" name="name" class="form-control form" id="name" placeholder="Your Name" data-rule="minlen:4" data-msg="Please enter at least 4 chars" />
                    <div class="validation"></div>
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" data-rule="email" data-msg="Please enter a valid email" />
                    <div class="validation"></div>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" data-rule="minlen:4" data-msg="Please enter at least 8 chars of subject" />
                    <div class="validation"></div>
                </div>
              </div>
              
              <div class="col-md-6 col-sm-6 col-xs-12 right">
                <div class="form-group">
                    <textarea class="form-control" name="message" rows="5" data-rule="required" data-msg="Please write something for us" placeholder="Message"></textarea>
                    <div class="validation"></div>
                </div>
              </div>
              
              <div class="col-xs-12">
                <!-- Button -->
                <button type="submit" id="submit" name="SendMessage" class="form contact-form-button light-form-button oswald light">SEND EMAIL</button>
              </div>
          </form>
          
        </div>
      </div>
    </section>
    <!--/ Contact-->