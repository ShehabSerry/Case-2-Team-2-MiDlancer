<?php

include 'mail.php';

$error = "";
if(isset($_SESSION['rand']))
{
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
<body style='font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #fffffa; color: #00000a; line-height: 1.6;'>
    <div style='background-color: #080a74; padding: 20px; text-align: center; color: #fffffa;'>
        <h1 style='color: #fffffa;'>Welcome to MiDlancer, <span style='color: #f6d673;'>$name</span>!</h1>
    </div>
    <div style='padding: 20px; background-color: #f7faffd3; color: #00000a; border-radius: 25px; box-shadow: -2px 13px 32px 0px rgba(0, 0, 0, 0.378); transition: all 0.5s; margin-top: 5%; margin-bottom: 5%;'>
        <p style='color: #00000a;'>Dear <span style='color: #080a74; background-color: #f6d673; padding: 2px 4px; border-radius: 3px;'>$name</span>,</p>
        <p style='color: #00000a;'>Thank you for registering on MiDlancer as a client! We are thrilled to have you on board.</p>
        <p style='color: #00000a;'>Here are some things you can do to get started:</p>
        <ul>
            <li style='color: #00000a;'>Check out the <a style='color: #080a74; background-color: #f6d673; padding: 2px 4px; border-radius: 3px;'>Career</a> and <a style='color: #080a74; background-color: #f6d673; padding: 2px 4px; border-radius: 3px;'>Freelancers</a> pages.</li>
            <li style='color: #00000a;'>Hire freelancers to help you with your projects.</li>
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
";

            $mail->setFrom('MiDlancerTeam@gmail.com', 'MiDlancer');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Welcome Aboard';
            $mail->Body=($email_content);
            $mail->send();
            $insert="INSERT INTO `user` VALUES(NULL,'$name','$email','$phone','$passwordhashing','defaultprofile.png',NULL,'$nationality')";
            $run_insert=mysqli_query($connect,$insert);
            header("location:login_client.php");
        }
    }
    if (isset($_POST['resend']))
    {
        $email=$_SESSION['email'];

        $rand=rand(10000,99999);

        $email_content = "
        <body style='font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #fffffa; color: #00000a; line-height: 1.6;'>
            <div style='background-color: #080a74; padding: 20px; text-align: center; color: #fffffa;'>
                <h1 style='color: #fffffa;'>Complete Your Registration - Code Resent</h1>
            </div>
            <div style='padding: 20px; background-color: #f7faffd3; color: #00000a; border-radius: 25px; box-shadow: -2px 13px 32px 0px rgba(0, 0, 0, 0.378); transition: all 0.5s; margin-top: 5%; margin-bottom: 5%;'>
                <p style='color: #00000a;'>Dear <span style='color: #080a74;'>$name</span>,</p>
                <p style='color: #00000a;'>Thank you for registering with MiDlancer! Please use the OTP we've resent you the OTP, use it to verify your email address and complete your registration:</p>
                <div style='display: flex; justify-content: center;'>
                    <p style='text-align: center; font-size: 24px; font-weight: bold; color: #080a74; background-color: #f6d673; padding: 10px; border-radius: 5px; display: inline-block;'>$rand</p>
                </div>
                <p style='color: #00000a;'>If you did not request this registration, please ignore this email.</p>
                <p style='color: #00000a;'>Best regards,<br>The MiDlancer Team</p>
            </div>
            <div style='background-color: #f6d673; padding: 20px; text-align: center; color: #080a74; border-bottom-left-radius: 25px; border-bottom-right-radius: 25px;'>
                <p style='color: #080a74;'>For support and updates, please visit our website or contact us via email.</p>
                <p style='color: #080a74;'>Email: <a href='mailto:MiDlancerTeam@gmail.com' style='color: #080a74;'>MiDlancerTeam@gmail.com</a></p>
            </div>
        </body>";

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
<!--    <div class="container-main">-->
<!--    <div class="otp-card">-->
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
        <br>
          <?php if(!empty($error)) { ?>
                  <div class="alert alert-warning" role="alert">
                      <?php echo $error ?>
                  </div>
              <?php } ?>
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
