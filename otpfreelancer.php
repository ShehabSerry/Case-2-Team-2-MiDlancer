<?php
    include 'mail.php';
    $error = '';
if(isset($_SESSION['rand'])) {
    $rand = $_SESSION['rand'];
    $name = $_SESSION['freelancer_name'];
    $email = $_SESSION['email'];
    $phone = $_SESSION['phone_number'];
    $birthdate = $_SESSION['birthdate'];
    $national_id = $_SESSION['national_id'];
    $passwordhashing = $_SESSION['password'];
    $job_title = $_SESSION['job_title'];
    $career = $_SESSION['career'];
    $time = $_SESSION['time']; // start point from prev

    if (isset($_POST['submit'])) {
        $otp = $_POST['otp1'] . $_POST['otp2'] . $_POST['otp3'] . $_POST['otp4'] . $_POST['otp5'];
        $current_time = time(); // end point now
        if (empty($_POST['otp1'] . $_POST['otp2'] . $_POST['otp3'] . $_POST['otp4'] . $_POST['otp5'])) {
            $error = "can't be left empty";
        } else if ($current_time - $time > 60) { // assuming 60
            $error = "OTP expired";
        } else if ($otp != $rand) {
            $error = "OTP is incorrect";
        } else {
            $email_content = "
            <body>
            <p>Dear $name, Welcome Aboard! Thank you for registering with us!</p> </p>
            </body>
            "; // FRONT may style this up


            $mail->setFrom('MiDlancerTeam@gmail.com', 'MiDlancer');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Welcome Aboard';
            $mail->Body = ($email_content);
            $mail->send();

            $insert = "INSERT INTO `freelancer` VALUES(NULL,'$name','$email','$phone','$passwordhashing','$birthdate','$national_id', 'defaultprofile.png', '$job_title', NULL, NULL, NULL, NULL, NULL,NULL, 0, 0, 0, $career, 1)";
            //$insert="INSERT INTO `freelancer` VALUES(NULL,'$name','$email','$phone','$passwordhashing','$birthdate','$national_id', 'defaultprofile.png', '$job_title', AVAILHRS, PRICEMIN1, LNK, LNK, BIO, 0, 0, 0, $career, 1)"; all start as beg
            $run_insert = mysqli_query($connect, $insert);
            header("location:login_freelancer.php");
        }
    }
    if (isset($_POST['resend'])) {
        $email = $_SESSION['email'];
        $user_name = $name;
        $rand = rand(10000, 99999);

        $email_content = "
    <body>
    <p>Dear $name, we've resent you a new verification code, your code is $rand </p> <!-- FRONT NEEDED MAILER BODY -->
    </body>
    ";

        $_SESSION['rand'] = $rand;

        $old_time = time();
        $_SESSION['time'] = $old_time; // new start point, next press is END point, calc diff, shouldn't exceed 60 (may change)
        $mail->setFrom('MiDlancerTeam@gmail.com', 'MiDlancer');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Account Activation Code';
        $mail->Body = ($email_content);
        $mail->send();
        // $insert="INSERT INTO `user` VALUES(NULL,'$name','$email','$phone','$passwordhashing',NULL,NULL,'$nationality')";
        // $run_insert=mysqli_query($connect,$insert);
        header("location:otpfreelancer.php");
    }
}
else
{
    $error = "NOT AUTHORISED";
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
    <div class="wrapper">
    <div class="form">
        <h1>Verification Code</h1>
        <p>sent to your E-mail</p>
        <!-- cardinfo -->
        <div class="otp-card-inputs">
        <form method="POST">
    
            <input type="text" maxlength="1" autofocus name="otp1">
            <input type="text" disabled maxlength="1" name="otp2">
            <input type="text" disabled maxlength="1" name="otp3">
            <input type="text" disabled maxlength="1" name="otp4">
            <input type="text" disabled maxlength="1" name="otp5">
        </div>
        <div class="tany">
            <p>Didn't get the otp? </p>
            <button  type="submit" name="resend" class="resbtn">resend</button>
        </div>
        <?php if(!empty($error)) { ?>
                  <div class="alert alert-warning" role="alert">
                      <?php echo $error ?>
                  </div>
              <?php } ?>
        <br>
        <div class="buttons ">
   <button name="submit" class="cssbuttons-io-button">Get started
      <!-- <a href="#">Get started</a> -->
      <div class="icon">
          <svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path d="M0 0h24v24H0z" fill="none"></path>
              <path
                  d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z"
                  fill="currentColor"></path>
          </svg>
      </div>
  </button>
  </div>    
    </div>

    </div>
    <script src="js/otp.js"></script>
</body>

</html>