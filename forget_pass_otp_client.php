<?php
include 'mail.php';
$error="";

if(isset($_SESSION['otp']))
{
    $rand=$_SESSION['otp'];
    $email=$_SESSION['email'];
    $old_time=$_SESSION['time']; // first click from before START POINT
    if (isset($_POST['submit']))
    {
        if (!isset($_POST['otp1'], $_POST['otp2'], $_POST['otp3'], $_POST['otp4'], $_POST['otp5']))
            $error = "Please fill all OTP fields";
        else
        {
            $otp = $_POST['otp1'] . $_POST['otp2'] . $_POST['otp3'] . $_POST['otp4'] . $_POST['otp5'];
            $current_time = time();

            if ($rand == $otp) // tarek's notice from C1
            {
                if ($current_time - $old_time > 60) // BACK - ASSUME 60 SECONDS - MAY CHANGE
                    $error = "Expired OTP";
                else
                    header("location:forgotpass_client.php");
            }
            else
                $error = "Incorrect OTP";
        }
    }

    if (isset($_POST['resend']))
    {
        $email = $_SESSION['email'];
        $select = "SELECT *FROM `user` WHERE `email`='$email'";
        $runselect = mysqli_query($connect, $select);

        if (mysqli_num_rows($runselect) > 0)
        {
            $fetch = mysqli_fetch_assoc($runselect);
            $user_name = $fetch['user_name'];
            $rand = rand(10000, 99999);
            $email_content = "
            <body style='font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #fffffa; color: #00000a; line-height: 1.6;'>
                <div style='background-color: #080a74; padding: 20px; text-align: center; color: #fffffa;'>
                    <h1 style='color: #fffffa;'>Password Reset Request - Resent Code</h1>
                </div>
                <div style='padding: 20px; background-color: #f7faffd3; color: #00000a; border-radius: 25px; box-shadow: -2px 13px 32px 0px rgba(0, 0, 0, 0.378); transition: all 0.5s; margin-top: 5%; margin-bottom: 5%;'>
                    <p style='color: #00000a;'>Dear $user_name,</p>
                    <p style='color: #00000a;'>We received a request to reset your password. Your verification code is:</p>
                    <div style='text-align: center;'>
                        <h2 style='color: #080a74; text-align: center; background-color: #f6d673; padding: 10px; border-radius: 5px; font-weight: bold; display: inline-block'>$rand</h2>
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
            $_SESSION['otp'] = $rand;
            $old_time = time(); // new start point
            $_SESSION['time'] = $old_time;
            $mail->setFrom('MiDlancerTeam@gmail.com', 'MiDlancer');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset OTP';
            $mail->Body = ($email_content);
            $mail->send();

            header("location:forget_pass_otp_client.php");
        }
    }
}
else
{
    $error = "NOT AUTHORISED";
    header("Location: login_client.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- bs -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="css/otp.css">
    <link href="./imgs/logo.png" rel="icon">
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
        <br>
        <?php if(!empty($error)) { ?>
            <div class="alert alert-warning" role="alert">
                <?php echo $error ?>
            </div>
        <?php } ?>
<!--        <button  type="submit" name="submit" class="verify">Verify</button>-->
            <div class="buttons ">
                <button name="submit" class="cssbuttons-io-button">Verify
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
