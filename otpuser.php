<?php

include 'mail.php';

$error = "";
$rand=$_SESSION['rand'];
$name=$_SESSION['user_name'];
$email=$_SESSION['email'];
$phone=$_SESSION['phone_number'];
$passwordhashing=$_SESSION['password'];
$nationality=$_SESSION['nationality'];

if(isset($_POST['submit']))
{
    $otp= $_POST['otp1'].$_POST['otp2'].$_POST['otp3'].$_POST['otp4'].$_POST['otp5'];
    $current_time=time();

    if(empty($_POST['otp1'].$_POST['otp2'].$_POST['otp3'].$_POST['otp4'].$_POST['otp5']))
        $error= "Can't be left empty";
    else if ($current_time - $_SESSION['time'] > 60) // ASSUMING 60, COULD BE LESS - BACK DECIDE
        $error= "OTP expired";
    else if ($otp != $rand)
        $error= "Incorrect OTP";
    else
    {
        $email_content = "
        <body>
        <p>Dear $name, Welcome Aboard! Thank you for registering with us!</p>  <!--FRONT NEEDED-->
        </body>
        ";
        $mail->setFrom('MiDlancerTeam@gmail.com', 'MiDlancer');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Welcome Aboard';
        $mail->Body=($email_content);
        $mail->send();
        $insert="INSERT INTO `user` VALUES(NULL,'$name','$email','$phone','$passwordhashing',NULL,NULL,'$nationality')";
        $run_insert=mysqli_query($connect,$insert);
        header("location:login_client.php");
    }
}
if (isset($_POST['resend']))
{
     $email=$_SESSION['email'];

     $rand=rand(10000,99999);
 
     $email_content = "
     <body>
     <p>Dear $name, we've resent you a new verification code, your code is $rand </p>  <!--FRONT NEEDED-->
     </body>
     ";
     $_SESSION['rand'] = $rand;
     $old_time=time(); // new start point
     $_SESSION['time']=$old_time;

     $mail->setFrom('MiDlancerTeam@gmail.com', 'MiDlancer');
     $mail->addAddress($email);
     $mail->isHTML(true);
     $mail->Subject = 'Account Activation Code';
     $mail->Body=($email_content);
     $mail->send();
 }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>verification page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- bs -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <link rel="stylesheet" href="css/otp.css">
</head>

<body>
    <!-- eldiv elkbeer -->
    <div class="container-main">
    <div class="otp-card">
        <h1>Verification Code</h1>
        <p>sent to your E-mail</p>

        <!-- cardinfo -->
        <div class="otp-card-inputs">
        <form method="POST">
    
            <input type="text" maxlength="1" autofocus name="otp1">
            <input type="text" maxlength="1" name="otp2">
            <input type="text" maxlength="1" name="otp3">
            <input type="text" maxlength="1" name="otp4">
            <input type="text" maxlength="1" name="otp5">
        </div>
        <div class="tany">
            <p>Didn't get the otp? </p>
            <button  type="submit" name="resend" class="resbtn">resend</button>
        </div>
        <br>
          <?php if(!empty($error)) { ?>
                  <div class="alert alert-warning" role="alert">
                      <?php echo $error ?>
                  </div>
              <?php } ?>
        <button  type="submit" name="submit" class="verify">Verify</button>
        
    </div>

    </div>
    <script src="js/otp.js"></script>
</body>

</html>
