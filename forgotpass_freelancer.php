<?php
include 'mail.php';
$error="";
$email=$_SESSION['email'];

if(isset($_POST['submit'])) {
    $select = "SELECT * FROM `freelancer` WHERE `email`='$email'";
    $runSelect = mysqli_query($connect, $select);
    $fetch = mysqli_fetch_assoc($runSelect);
    $freelancer_name = $fetch['freelancer_name'];
    $new_pass = $_POST['new_pass'];
    $confirm_pass = $_POST['confirm_pass'];

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


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot password</title>
</head>
<body>
<h1>forget password</h1>

<?php if ($error){
     echo $error; } ?>
<form method="post">
    <p>New password</p>
<input type="password"  name="new_pass">
<p>Confirm new password</p>
<input type="password"  name="confirm_pass">
<a href="login_freelancer.php"> <button type="submit"  name="submit">Submit</button> </a>
</form>
                
    
</body>
</html>