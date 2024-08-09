<?php
include 'mail.php';
$error="";
$rand=$_SESSION['otp'];
$email=$_SESSION['email'];
$old_time=$_SESSION['time'];


if(isset($_POST['submit'])){
    $otp= $_POST['otp'];
    $current_time=time(); 


     if(empty($_POST['otp']))
     {
          $error= "can't be left empty";
   
     
    }elseif($current_time>$old_time){
        unset($_SESSION['otp']);
        $error= "expired otp";

}elseif($rand==$otp){
          header("location:forgotpass_client.php");
}
     else{
 $error= "Incorrect OTP";
    }
}

if (isset($_POST['resend'])){
    $email=$_SESSION['email'];
//    

    $select="SELECT *FROM `user` WHERE `email`='$email'";
    $runselect=mysqli_query($connect,$select);
    $fetch=mysqli_fetch_assoc($runselect);
    $user_name=$fetch['user_name'];
    

     if(mysqli_num_rows($runselect)>0){
$rand=rand(10000,99999);

$email_content = "
<body>
<p>dear $user_name your verification code is $rand </p>
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

          header("location:forget_pass_otp.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>forgot password verification</title>
</head>
<body>
<h1>Verification Code</h1>

<?php if($error)
echo $error;?>
<form method="POST">
<input type="number" name="otp">
<p>Didnt recieve the verificatio code?</p>
<button  type="submit" name="resend">resend</button>
<br>

<button  type="submit" name="submit">Verify</button>

</form>
    
</body>
</html>
