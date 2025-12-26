<?php
include('layout/header.php');

if (isset($_POST['contact']) && isset($_POST['name']) && $_POST['name'] != null) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $insertquery = "INSERT INTO contact (name, email, subject, message) VALUES ('$name','$email','$subject','$message')";
    $data=mysqli_query($conn,$insertquery);
    if($data){
       $msg="Your message has been sent!";
    }
}
echo "<script>
if (window.history.replaceState) {
  window.history.replaceState(null, null, window.location.href);
}
</script>";
?>
 <!-- Contact Start -->
    <div class="container-fluid">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Contact Us</span></h2>
        <div class="row px-xl-5">
            <div class="col-lg-7 mb-5">
                 <?Php if(isset($data)&& $data!=null){?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                  <?php echo $msg ?>
                    <button type="button" class="close" data-dismiss="alert">&times;</button>                  
                </div>
            <?php } ?>
                <div class="bg-light p-30">
                    <form action="contact.php" method="post">
                        <div class="control-group mb-3">
                            <input type="text" class="form-control" name="name" placeholder="Your Name" required/>
                        </div>
                        <div class="control-group mb-3">
                            <input type="email" class="form-control" name="email" placeholder="Your Email" required/>
                        </div>
                        <div class="control-group mb-3">
                            <input type="text" class="form-control" name="subject" placeholder="Subject" required/>
                        </div>
                        <div class="control-group mb-3">
                            <textarea class="form-control" rows="8" name="message" placeholder="Message" required></textarea>
                        </div>
                        <div>
                            <button class="btn btn-primary py-2 px-4" type="submit" name="contact">Send
                                Message</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-5 mb-5">
                <div class="bg-light p-30 mb-30">
                    <iframe style="width: 100%; height: 315px;"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3001156.4288297426!2d-78.01371936852176!3d42.72876761954724!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4ccc4bf0f123a5a9%3A0xddcfc6c1de189567!2sNew%20York%2C%20USA!5e0!3m2!1sen!2sbd!4v1603794290143!5m2!1sen!2sbd"
                    frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                </div>
                <div class="bg-light p-30 mb-3">
                    <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>123 Street, New York, USA</p>
                    <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>info@example.com</p>
                    <p class="mb-2"><i class="fa fa-phone-alt text-primary mr-3"></i>+012 345 67890</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->
<?php 
include('layout/footer.php');
?>