<?php
include 'mail.php';
$error="";

if (isset($_POST['submit'])){
    $_SESSION['f_email']=$_POST['f_email'];
    $email = mysqli_real_escape_string($connect, $_POST['f_email']); 
    $old_time=time()+60; 
    $_SESSION['time']=$old_time;



    $select="SELECT *FROM `freelancer` WHERE `email`='$email'";
    $runselect=mysqli_query($connect,$select);
   


     if(mysqli_num_rows($runselect)>0){
        $fetch=mysqli_fetch_assoc($runselect);
        $freelancer_name=$fetch['freelancer_name'];
$rand=rand(10000,99999);           
$email_content = "
<body>
<p>dear $freelancer_name your verification code is $rand </p>
</body>
";
$_SESSION["f_otp"]=$rand;


$mail->setFrom('taskify49@gmail.com', 'Taskify');         
 $mail->addAddress($email);      
 $mail->isHTML(true);                               
 $mail->Subject = 'Password Reset OTP';            
 $mail->Body=($email_content);                  
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
<meta charset="utf-8">
<meta http-equiv="X-UA-compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0 ">
<title>
    Verify email
</title>
<link re
rel="stylesheet" type="text/css" href="css/editpassword.css">
</head>

<body>
<div class="wrapper">
<div class="from-wraapper  Sign-in">
<form method="POST">
<h2>Verify Your Email</h2>
<?php  
if($error){
    echo $error;
}
?>
<p>email</p>
    <input type="email" name="f_email">
<br>


<button type="submit" name="submit">Submit</button>

</form>
</body>
</html>