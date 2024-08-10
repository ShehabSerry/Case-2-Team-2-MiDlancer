<?php
include ("connection.php");
$error="";
$id = $_SESSION['user_id'];


$select="SELECT * FROM `user` WHERE `user_id` = '$id'";
    $run_select=mysqli_query($connect,$select);
    $fetch=mysqli_fetch_assoc($run_select);
    $fetcholdpass=$fetch['password'];
  
    if(isset($_POST['edit'])){
        $old_password=$_POST['old_password'];
        $new_password=$_POST['new_password'];
        $confirm_password=$_POST['confirm_password'];
        // if(password_verify($old_password,$fetcholdpass)){
            if(($old_password==$fetcholdpass)){
            if($new_password == $confirm_password){
                // $new_hashed=password_hash($new_password,PASSWORD_DEFAULT);
                // $update="UPDATE `user` SET `password`='$new_hashed' WHERE `user_id`=$id";
                $update="UPDATE `user` SET `password`='$new_password' WHERE `user_id`=$id";
                $run_update=mysqli_query($connect,$update);
                echo "done";
                
                header("location: ");
            }else {
                $error = "New password doesn't match confirm password";
            } 
        }else{
            $error= "Old password is wrong";
        }
    
    }





?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>change password</title>
</head>
<body>
    <h1>Change Password</h1>
    <?php
    if($error){
        echo $error;
    } ?>

    <form method="post">
    <p>Old password</p>
    <input type="password" name="old_password">

        <p>New password</p>
<input type="password" name="new_password">

<p>Confirm new password</p>
<input type="password" name="confirm_password">
<a href="login_client.php" > 
    <button type="submit" name="edit">Submit</button>
</a>

    </form>
</body>
</html>