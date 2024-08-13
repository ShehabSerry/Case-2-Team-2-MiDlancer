<?php
include 'mail.php';
$error="";

if (isset($_POST['submit'])){
    $_SESSION['f_email']=$_POST['f_email'];
    $email = mysqli_real_escape_string($connect, $_POST['f_email']); 
    $old_time=time(); // START FROM PREV
    $_SESSION['time']=$old_time;



    $select="SELECT * FROM `freelancer` WHERE `email`='$email'";
    $runselect=mysqli_query($connect,$select);
   


     if(mysqli_num_rows($runselect)>0)
     {
        $fetch=mysqli_fetch_assoc($runselect);
        $freelancer_name=$fetch['freelancer_name'];
        $rand=rand(10000,99999);
        $email_content = "
                <body>
                <p>dear $freelancer_name your verification code is $rand </p>
                </body>";
        $_SESSION["f_otp"]=$rand;

        $mail->setFrom('MiDlancerTeam@gmail.com', 'MiDlancer');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Password Reset Successfully';
        $mail->Body = ($email_content);
        $mail->send();



         header("location:forget_pass_otp_freelancer.php");

      }    
      else{
       $error= "email not correct";
      }
    }




?>


<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
   <!----link bootsrap-->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

  <!-- link css -->
   <link rel='stylesheet' type='text/css'  media="screen" href="css/emailverify.css"/>
    <title>Email Verification</title>
  </head>

  <body> 
    <a href="" class="close"><i class="fa-solid fa-x "></i></a>
<div class="background">
    <div class="container-main">
      <div class="wrapper">
          <div class="from-wraapper  Sign-in">
          <form method="POST">
          <h2>Email Verification</h2>
         
        

          
          <div class="input-group">
              <input type="email" required name="f_email">
              <label for="">E-mail</label>
          </div>
          <?php   
          if($error){
            ?> <div class="alert alert-warning" role="alert"> 
              <?php
            echo $error;
            ?> </div>
          <?php } ?>


    </div>
   
    <div class="btns">
      <div class="buttons">
        <button class="cssbuttons-io-button addto" name="submit">
          <a href="#">Verify Email</a>
          <div class="icon">
            <svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path d="M0 0h24v24H0z" fill="none"></path>
              <path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z"
                fill="currentColor"></path>
            </svg>
          </div>
        </button>
      </div>
    </div>
          <div class="signUp-link">
              <p> <a href="freelancer_sign_up.php" class="signUpBtn-link"></a> </p>
          </div>
          </form>
          </div>
          </div>
  </div>   
</div>
    <script src="main.js"></script>
  </body>

</html>