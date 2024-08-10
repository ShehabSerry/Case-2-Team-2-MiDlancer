<?php
include 'mail.php';
$error="";
$email=$_SESSION['email'];

if(isset($_POST['submit'])) {
    $select = "SELECT * FROM `freelancer` WHERE `email`='$email'";
    $runSelect = mysqli_query($connect, $select);
    $fetch = mysqli_fetch_assoc($runSelect);
    $freelancer_name = $fetch['freelancer_name'];
    $new_pass = mysqli_real_escape_string($connect,$_POST['new_pass']);
    $confirm_pass = mysqli_real_escape_string($connect,$_POST['confirm_pass']);

    $uppercase = preg_match('@[A-Z]@', $new_pass);
    $lowercase = preg_match('@[a-z]@', $new_pass);
    $number = preg_match('@[0-9]@', $new_pass);
    $character = preg_match('@[^/w]@', $new_pass);

    if (empty($new_pass) || empty($confirm_pass)) {
        $error= "You must ust enter a new password";
    } else if ($uppercase < 1 || $lowercase < 1 || $number < 1 || $character < 1) {
        $error="Password must contain uppercase, lowercase, numbers, characters";
    } else {
        if ($new_pass == $confirm_pass) {
            $newHashPass = password_hash($new_pass, PASSWORD_DEFAULT);

            $update = "UPDATE `user` SET `password`='$newHashPass' WHERE `email`='$email'";
            $run_update = mysqli_query($connect, $update);


            if ($run_update) {
                $email_content = "
            
                    <h1>Password Reset Successful</h1>
                
                <p>dear $freelancer your password has been reset succesfully</p>
        </body>
        ";
        $mail->setFrom('taskify49@gmail.com', 'Taskify');          
        $mail->addAddress($email);      
        $mail->isHTML(true);
        $mail->Subject = 'Password Reset Successfully';             
        $mail->Body = ($email_content);                  
        $mail->send();

        unset($_SESSION['otp']); 
        header("Location:login_freelancer.php");
    } else {
        $error= "New password doesn't match confirm password";
    }
}
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
  <!-- link css -->
   <link rel='stylesheet' type='text/css'  media="screen" href="css/forgetpassword.css"/>
    <title>Forget Password</title>
  </head>

  <body> 
    <a href="" class="close"><i class="fa-solid fa-x "></i></a>
<div class="background">
    <div class="container-main">
      <div class="wrapper">
          <div class="from-wraapper  Sign-in">
          <form method="post">
          <h2>Forget Password</h2>
          
          <div class="input-group">
              <input type="password" required name="new_pass">
              <label for="">New Password</label>
          </div>
          
          
          <div class="input-group">
              <input type="password" required name="confirm_pass">
              <label for="">Confirm Password</label>
          </div> 
    </div>
   
  <div class="buttons">
    <button class="Btn" name="submit">
SUBMIT
    </button>
  </div>
          <div class="signUp-link">
              <p> <a href="user_sign_up.php" class="signUpBtn-link"></a> </p>
          </div>
          </form>
          </div>
          </div>
  </div>   
</div>
    <script src="forgetpassword.js"></script>
  </body>

</html>