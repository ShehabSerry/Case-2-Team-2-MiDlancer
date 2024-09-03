<?php
include 'mail.php';
$error="";
if(!isset($_SESSION['f_email'])) // hopin on page uninvited - empty handed
    header("Location: home.php"); // possibly login >redirect> home  (if logged in)

$email=$_SESSION['f_email']; // came clean from prev page

if(isset($_POST['submit'])) {
    $select = "SELECT * FROM `freelancer` WHERE `email`='$email'";
    $runSelect = mysqli_query($connect, $select);
    $fetch = mysqli_fetch_assoc($runSelect);
    $freelancer_name = $fetch['freelancer_name'];
    $new_pass = htmlspecialchars(mysqli_real_escape_string($connect, $_POST['new_pass']));
    $confirm_pass = htmlspecialchars(mysqli_real_escape_string($connect, $_POST['confirm_pass']));

    $uppercase = preg_match('@[A-Z]@', $new_pass);
    $lowercase = preg_match('@[a-z]@', $new_pass);
    $number = preg_match('@[0-9]@', $new_pass);
    $character = preg_match('@[^/w]@', $new_pass);

    if (empty($new_pass) || empty($confirm_pass))
        $error= "You must enter a new password";
    else if (!$uppercase || !$lowercase || !$number || !$character)
        $error = "Password must contain uppercase, lowercase, numbers, and special characters";
    else {
        if ($new_pass == $confirm_pass)
        {
            $newHashPass = password_hash($new_pass, PASSWORD_DEFAULT);

            $update = "UPDATE `freelancer` SET `password`='$newHashPass' WHERE `email`='$email'";
            $run_update = mysqli_query($connect, $update);

            if ($run_update)
            {
                $email_content = "
                <body style='font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #fffffa; color: #00000a; line-height: 1.6;'>
                    <div style='background-color: #080a74; padding: 20px; text-align: center; color: #fffffa;'>
                        <h1 style='color: #fffffa;'>Password Reset Successful</h1>
                    </div>
                    <div style='padding: 20px; background-color: #f7faffd3; color: #00000a; border-radius: 25px; box-shadow: -2px 13px 32px 0px rgba(0, 0, 0, 0.378); transition: all 0.5s; margin-top: 5%; margin-bottom: 5%;'>
                        <p style='color: #00000a;'>Dear $freelancer_name,</p>
                        <p style='color: #00000a;'>Your password has been reset successfully. You can now log in with your new password.</p>
                        <p style='color: #00000a;'>If you did not request this change, please contact our support team immediately.</p>
                        <p style='color: #00000a;'>Thank you for using MiDlancer!</p>
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
                $mail->Subject = 'Password Reset Successfully';
                $mail->Body = $email_content;
                $mail->send();

                unset($_SESSION['otp']);
                header("Location: login_freelancer.php");
                exit();
            } else
                $error = "Failed to update the password. Please try again.";
        } else
            $error = "New password doesn't match the confirm password.";
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

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <!-- link css -->
   <link rel='stylesheet' type='text/css'  media="screen" href="css/forgetpassword.css"/>
    <title>Forget Password</title>
    <link href="./imgs/logo.png" rel="icon">
  </head>

  <body> 
<div class="background">
    <div class="container-main">
      <div class="wrapper">
        
      <a href="login_freelancer.php" class="close"><i class="fa-solid fa-x "></i></a>
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
          <?php if(!empty($error)) { ?>
              <div class="alert alert-warning" role="alert">
                  <?php echo $error ?>
              </div>
          <?php } ?>
  <div class="buttons">
    <button class="Btn" name="submit">
SUBMIT
    </button>
  </div>
          </form>
          </div>
          </div>
  </div>   
</div>
    <script src="forgetpassword.js"></script>
    <script>document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    const newPasswordInput = document.querySelector('input[name="new_pass"]');
    const confirmPasswordInput = document.querySelector('input[name="confirm_pass"]');

   
    const newPasswordError = document.createElement('div');
    const confirmPasswordError = document.createElement('div');


    newPasswordError.className = 'error-message';
    confirmPasswordError.className = 'error-message';

 
    newPasswordInput.parentNode.insertBefore(newPasswordError, newPasswordInput.nextSibling);
    confirmPasswordInput.parentNode.insertBefore(confirmPasswordError, confirmPasswordInput.nextSibling);

    function validateField() {
        const newPassword = newPasswordInput.value.trim();
        const confirmPassword = confirmPasswordInput.value.trim();
        let valid = true;

      
        newPasswordError.textContent = '';
        confirmPasswordError.textContent = '';

       
        const uppercase = /[A-Z]/.test(newPassword);
        const lowercase = /[a-z]/.test(newPassword);
        const number = /[0-9]/.test(newPassword);
        const specialCharacter = /[^a-zA-Z0-9]/.test(newPassword);

        if (!newPassword) {
            newPasswordError.textContent = 'New password is required';
            valid = false;
        } else if (!uppercase || !lowercase || !number || !specialCharacter) {
            newPasswordError.textContent = 'Password must contain at least 1 uppercase, 1 lowercase, 1 number, and 1 special character.';
            valid = false;
        }

        if (!confirmPassword) {
            confirmPasswordError.textContent = 'Confirm password is required';
            valid = false;
        } else if (newPassword !== confirmPassword) {
            confirmPasswordError.textContent = "New password doesn't match confirm password";
            valid = false;
        }

        return valid;
    }

    newPasswordInput.addEventListener('blur', validateField);
    confirmPasswordInput.addEventListener('blur', validateField);

    newPasswordInput.addEventListener('input', validateField);
    confirmPasswordInput.addEventListener('input', validateField);

    form.addEventListener('submit', function (event) {
        if (!validateField()) {
            event.preventDefault();
        }
    });
});

        </script>
  </body>

</html>
