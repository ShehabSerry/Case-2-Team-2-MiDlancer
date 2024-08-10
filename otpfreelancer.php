<?php
include 'mail.php';

$rand=$_SESSION['rand'];
$name=$_SESSION['freelancer_name'];
    $email=$_SESSION['email'];
    $phone=$_SESSION['phone_number'];
    $birthdate=$_SESSION['birthdate'];
    $national_id=$_SESSION['national_id'];
    $passwordhashing=$_SESSION['password'];
    $job_title=$_SESSION['job_title'];
    $career=$_SESSION['career'];

    if(isset($_POST['submit'])){
     $otp= $_POST['otp1'].$_POST['otp2'].$_POST['otp3'].$_POST['otp4'].$_POST['otp5'];
     $current_time=time(); 
 
 
     
     if(empty($_POST['otp1'].$_POST['otp2'].$_POST['otp3'].$_POST['otp4'].$_POST['otp5']))
      {
           $error= "can't be left empty";

              
        
        $mail->setFrom('taskify49@gmail.com', 'Taskify');         
        $mail->addAddress($email);    
        $mail->isHTML(true);
        $mail->Subject = 'Password Reset OTP';            
        $mail->Body=($email_content);                  
        $mail->send();

$insert="INSERT INTO `freelancer` VALUES(NULL,'$name','$email','$phone','$passwordhashing','$birthdate','$national_id', NULL, '$job_title', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, $career, NULL)";
$run_insert=mysqli_query($connect,$insert);
        header("location:login_freelancer.php");
     }
}
if (isset($_POST['resend'])){
     $email=$_SESSION['email'];
 //    
 
     $select="SELECT *FROM `freelancer` WHERE `email`='$email'";
     $runselect=mysqli_query($connect,$select);
     $fetch=mysqli_fetch_assoc($runselect);
     $user_name=$fetch['freelancer_name'];
     
 
      if(mysqli_num_rows($runselect)>0){
 $rand=rand(10000,99999);
 
 $email_content = "
 <body>
 <p>dear $freelancer_name your verification code is $rand </p>
 </body>
 ";
 
 $_SESSION['otp'] = $rand;
 
      $old_time=time()+60; 
      $_SESSION['time']=$old_time;
      
           }    
 
 
 $mail->setFrom('taskify49@gmail.com', 'Taskify');         
 $mail->addAddress($email);    
 $mail->isHTML(true);
 $mail->Subject = 'Password Reset OTP';            
 $mail->Body=($email_content);                  
 $mail->send();
 
 $insert="INSERT INTO `user` VALUES(NULL,'$name','$email','$phone','$passwordhashing',NULL,NULL,'$nationality')";
 $run_insert=mysqli_query($connect,$insert);
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