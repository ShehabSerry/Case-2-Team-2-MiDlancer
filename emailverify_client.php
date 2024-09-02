<?php
include 'mail.php';
$error="";
if(isset($_SESSION['user_id']))
    header("home.php");

if (isset($_POST['submit']))
{
    $_SESSION['email']=  htmlspecialchars(strip_tags($_POST['email']));
    $email = mysqli_real_escape_string($connect, $_POST['email']); 
    $old_time=time(); // TIME AS IT IS
    $_SESSION['time']=$old_time;
    $select="SELECT *FROM `user` WHERE `email`='$email'";
    $runselect=mysqli_query($connect,$select);

    if(mysqli_num_rows($runselect)>0)
    {
        $fetch=mysqli_fetch_assoc($runselect);
        $user_name=$fetch['user_name'];
        $rand=rand(10000,99999);
        $email_content = "
        <body style='font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #fffffa; color: #00000a; line-height: 1.6;'>
            <div style='background-color: #080a74; padding: 20px; text-align: center; color: #fffffa;'>
                <h1 style='color: #fffffa;'>Password Reset Request</h1>
            </div>
            <div style='padding: 20px; background-color: #f7faffd3; color: #00000a; border-radius: 25px; box-shadow: -2px 13px 32px 0px rgba(0, 0, 0, 0.378); transition: all 0.5s; margin-top: 5%; margin-bottom: 5%;'>
                <p style='color: #00000a;'>Dear $user_name,</p>
                <p style='color: #00000a;'>We received a request to reset your password. Your verification code is:</p>
                <div style='text-align: center;'>
                    <h2 style='color: #080a74; background-color: #f6d673; padding: 10px; border-radius: 5px; font-weight: bold; text-align: center; display: inline-block;'>$rand</h2>
                </div>
                <p style='color: #00000a;'>Please enter this code on the password reset page to proceed.</p>
                <p style='color: #00000a;'>If you did not request a password reset, please ignore this email. Your account remains secure.</p>
                <p style='color: #00000a;'>Thank you for using MiDlancer!</p>
                <p style='color: #00000a;'>Best regards,<br>The MiDlancer Team</p>
            </div>
            <div style='background-color: #f6d673; color: #080a74; padding: 20px; text-align: center; border-bottom-left-radius: 25px; border-bottom-right-radius: 25px;'>
                <p style='color: #080a74;'>For support and updates, please visit our website or contact us via email.</p>
                <p style='color: #080a74;'>Email: <a href='mailto:MiDlancerTeam@gmail.com' style='color: #080a74;'>MiDlancerTeam@gmail.com</a></p>
            </div>
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
    else
       $error= "Email is incorrect";
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
    <link href="./imgs/logo.png" rel="icon">
  </head>

  <body> 
    
<div class="background">
    <div class="container-main">
      <div class="wrapper">
          <div class="from-wraapper  Sign-in">
          <a href="./login_client.php" class="close"><i class="fa-solid fa-x "></i></a>
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
