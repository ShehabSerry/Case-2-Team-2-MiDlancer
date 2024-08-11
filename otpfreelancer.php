<?php
    include 'mail.php';
    $error = '';
    $rand=$_SESSION['rand'];
    $name=$_SESSION['freelancer_name'];
    $email=$_SESSION['email'];
    $phone=$_SESSION['phone_number'];
    $birthdate=$_SESSION['birthdate'];
    $national_id=$_SESSION['national_id'];
    $passwordhashing=$_SESSION['password'];
    $job_title=$_SESSION['job_title'];
    $career=$_SESSION['career'];
    $time = $_SESSION['time']; // start point from prev

    if(isset($_POST['submit'])){
     $otp= $_POST['otp1'].$_POST['otp2'].$_POST['otp3'].$_POST['otp4'].$_POST['otp5'];
     $current_time=time(); // end point now
     if(empty($_POST['otp1'].$_POST['otp2'].$_POST['otp3'].$_POST['otp4'].$_POST['otp5']))
      {
           $error= "can't be left empty";
           }
      else if ($current_time - $time > 60){ // assuming 60
           $error= "OTP expired";
        }else if ($otp != $rand) {
          $error= "OTP is incorrect";
          }
      else {
          $email_content = "
            <body>
            <p>dear $freelancer_name your verification code is $rand </p>
            </body>
            "; // FRONT may style this up


        $mail->setFrom('taskify49@gmail.com', 'MiDlancer');
        $mail->addAddress($email);    
        $mail->isHTML(true);
        $mail->Subject = 'OTP';
        $mail->Body=($email_content);                  
        $mail->send();

        $insert="INSERT INTO `freelancer` VALUES(NULL,'$name','$email','$phone','$passwordhashing','$birthdate','$national_id', 'defaultprofile.png', '$job_title', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, $career, 1)";
        //$insert="INSERT INTO `freelancer` VALUES(NULL,'$name','$email','$phone','$passwordhashing','$birthdate','$national_id', 'defaultprofile.png', '$job_title', AVAILHRS, PRICEMIN1, LNK, LNK, BIO, 0, 0, 0, $career, 1)"; all start as beg
        $run_insert=mysqli_query($connect,$insert);
        header("location:login_freelancer.php");
     }
}
if (isset($_POST['resend']))
{
    var_dump($_SESSION['email']);
    $email=$_SESSION['email'];
    $user_name=$name;
    $rand=rand(10000,99999);
 
    $email_content = "
    <body>
    <p>dear $freelancer_name your verification code is $rand </p>
    </body>
    ";
 
    $_SESSION['rand'] = $rand;
 
    $old_time=time();
    $_SESSION['time']=$old_time; // new start point, next press is END point, calc diff, shouldn't exceed 60 (may change)
    $mail->setFrom('taskify49@gmail.com', 'MiDlancer');
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = 'OTP';
    $mail->Body=($email_content);
    $mail->send();
    // $insert="INSERT INTO `user` VALUES(NULL,'$name','$email','$phone','$passwordhashing',NULL,NULL,'$nationality')";
    // $run_insert=mysqli_query($connect,$insert);
    header("location:otpfreelancer.php");
 }






?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>verification page</title>

    <link rel="stylesheet" href="css/otp.css">
</head>

<body>
    <!-- eldiv elkbeer -->
    <div class="container-main">
    <div class="otp-card">
        <h1>Verification Code</h1>
        <p>sent to your E-mail</p>
        <p><?php echo $error ?></p>

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
        <button  type="submit" name="submit" class="verify">Verify</button>
    </div>

    </div>
    <script src="js/otp.js"></script>
</body>

</html>