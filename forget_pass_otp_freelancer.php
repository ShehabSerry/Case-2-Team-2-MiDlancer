<?php
include 'mail.php';
$error="";
if(isset($_SESSION['f_otp']))
{
    $rand = $_SESSION['f_otp'];
    $email = $_SESSION['f_email'];
    $old_time = $_SESSION['time']; // START FROM PREV


    if (isset($_POST['submit'])) {
        $otp = $_POST['f_otp1'] . $_POST['f_otp2'] . $_POST['f_otp3'] . $_POST['f_otp4'] . $_POST['f_otp5'];
        $current_time = time(); // NOW


        if (empty($_POST['f_otp1'] . $_POST['f_otp2'] . $_POST['f_otp3'] . $_POST['f_otp4'] . $_POST['f_otp5'])) {
            $error = "can't be left empty";


        } elseif ($current_time - $old_time > 60) { // BACK - ASSUME 60 MAY CHANGE
            unset($_SESSION['f_otp']);
            $error = "expired otp";

        } elseif ($rand == $otp) {
            header("location:forgotpass_freelancer.php");
        } else {
            $error = "Incorrect OTP";
        }
    }

    if (isset($_POST['resend'])) {
        $email = $_SESSION['f_email'];
//    

        $select = "SELECT *FROM `freelancer` WHERE `email`='$email'";
        $runselect = mysqli_query($connect, $select);


        if (mysqli_num_rows($runselect) > 0) {
            $fetch = mysqli_fetch_assoc($runselect);
            $user_name = $fetch['freelancer_name'];
            $rand = rand(10000, 99999);

            $email_content = "
<body>
<p>dear $user_name your verification code is $rand </p>
</body>
";

            $_SESSION['f_otp'] = $rand;

            $old_time = time(); // NEW START POINT
            $_SESSION['time'] = $old_time;

        }


        $mail->setFrom('MiDlancerTeam@gmail.com', 'MiDlancer');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Password Reset OTP';
        $mail->Body = ($email_content);
        $mail->send();

        header("location:forget_pass_otp_freelancer.php");
    }
}
else
    $error = "Not Authorised";
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
    
            <input type="text" maxlength="1" autofocus name="f_otp1">
            <input type="text" disabled maxlength="1" name="f_otp2">
            <input type="text" disabled maxlength="1" name="f_otp3">
            <input type="text" disabled maxlength="1" name="f_otp4">
            <input type="text" disabled maxlength="1" name="f_otp5">
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





