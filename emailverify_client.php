<?php
include 'mail.php';
$error="";

if (isset($_POST['submit'])){
    $_SESSION['email']=$_POST['email'];
    $email = mysqli_real_escape_string($connect, $_POST['email']); 
    $old_time=time(); // TIME AS IT IS
    $_SESSION['time']=$old_time;
    $select="SELECT *FROM `user` WHERE `email`='$email'";
    $runselect=mysqli_query($connect,$select);
   


     if(mysqli_num_rows($runselect)>0){
        $fetch=mysqli_fetch_assoc($runselect);
        $user_name=$fetch['user_name'];
$rand=rand(10000,99999);           
$email_content = "
<body>
<p>dear $user_name your verification code is $rand </p>
</body>
";
$_SESSION["otp"]=$rand;

global $mail;
$mail->setFrom('MiDlancerTeam@gmail.com', 'MiDlancer');
$mail->addAddress($email);      
$mail->isHTML(true);                               
$mail->Subject = 'Password Reset OTP';            
$mail->Body=($email_content);                  
$mail->send(); 

header("location:forget_pass_otp_client.php");

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
    
<div class="background">
    <div class="container-main">
      <div class="wrapper">
          <div class="from-wraapper  Sign-in">
          <a href="user_sign_up.php" class="close"><i class="fa-solid fa-x "></i></a>
          <form method="POST">
          <h2>Email Verification</h2>
         
        

          
          <div class="input-group">
              <input type="email" required name="email">
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

          </form>
          </div>
          </div>
  </div>   
</div>
    <script src="main.js"></script>
  </body>

</html>