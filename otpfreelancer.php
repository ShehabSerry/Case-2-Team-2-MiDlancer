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
    $join_date=$_SESSION['fl_join_date'];
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
            <body style='font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #fffffa; color: #00000a; line-height: 1.6;'>
                <div style='background-color: #080a74; padding: 20px; text-align: center; color: #fffffa;'>
                    <h1 style='color: #fffffa;'>Welcome to MiDlancer, <span style='color: #f6d673;'>$name</span>!</h1>
                </div>
                <div style='padding: 20px; background-color: #f7faffd3; color: #00000a; border-radius: 25px; box-shadow: -2px 13px 32px 0px rgba(0, 0, 0, 0.378); transition: all 0.5s; margin-top: 5%; margin-bottom: 5%;'>
                    <p style='color: #00000a;'>Dear <span style='color: #080a74; background-color: #f6d673; padding: 2px 4px; border-radius: 3px;'>$name</span>,</p>
                    <p style='color: #00000a;'>Thank you for joining MiDlancer as a freelancer! We are excited to have you on board.</p>
                    <p style='color: #00000a;'>Here are some things you can do to get started:</p>
                    <ul>
                        <li style='color: #00000a;'>Customize your profile to showcase your skills and experience.</li>
                        <li style='color: #00000a;'>Post updates on your wall to engage with potential clients.</li>
                        <li style='color: #00000a;'>Apply for job listings that match your expertise.</li>
                        <li style='color: #00000a;'>Subscribe to our premium plan for $25/month to unlock additional features.</li>
                        <li style='color: #00000a;'>Check out other freelancers' profiles to network and collaborate.</li>
                    </ul>
                    <p style='color: #00000a;'>If you have any questions or need assistance, feel free to reach out to our support team at any time.</p>
                    <p style='color: #080a74; padding: 2px 4px; border-radius: 3px;'>Happy MiDlancing!</p>
                    <p style='color: #00000a;'>Best regards,<br>The MiDlancer Team</p>
                </div>
                <div style='background-color: #f6d673; color: #080a74; padding: 20px; text-align: center; border-bottom-left-radius: 25px; border-bottom-right-radius: 25px;'>
                    <p style='color: #080a74;'>For support and updates, please visit our website or contact us via email.</p>
                    <p style='color: #080a74;'>Email: <a href='mailto:MiDlancerTeam@gmail.com' style='color: #080a74;'>MiDlancerTeam@gmail.com</a></p>
                </div>
            </body>
            "; // FRONT may style this up


            $mail->setFrom('MiDlancerTeam@gmail.com', 'MiDlancer');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Welcome Aboard';
            $mail->Body = ($email_content);
            $mail->send();

            $insert = "INSERT INTO `freelancer` VALUES(NULL,'$name','$email','$phone','$passwordhashing','$birthdate','$national_id', 'defaultprofile.png', '$job_title', NULL, NULL, NULL, NULL, NULL,NULL,0,0,0,0,'$career',1,5,'$join_date')";
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