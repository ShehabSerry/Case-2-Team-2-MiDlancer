<?php
include("connection.php");
$error="";


if(isset($_POST['login'])){

    $email = mysqli_real_escape_string($connect, $_POST['email']); 
    $password = mysqli_real_escape_string($connect, $_POST['password']); 

    if (empty($email))
    {
        $error = "Email can't be left empty"; 
    }

    if (empty($password))
    {
        $error = "Password can't be left empty";
    }

    else
    {
        $selectemail = "SELECT * FROM `user` WHERE `email` = '$email'";
        $runselect = mysqli_query($connect, $selectemail);

        if ($runselect)
        {
            if (mysqli_num_rows($runselect) > 0)
            // {
            //     $data = mysqli_fetch_assoc($runselect);
            //     $hashedPass = $data['password'];
            //     if (password_verify($password, $hashedPass))
                {
                    $_SESSION['user_id'] = $data['user_id'];
                    header("Location:connection.php");
                }
                else
                {
                    $error ="Incorrect Password"; 
                }
            }
            else
            {
                $error ="Email isn't registered"; 
            }
        }
    }
// }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
</head>
<body>
<h1>Login</h1>
<?php if($error){
    echo $error; } ?>
                

<form method="POST" action="">
<input type="email" name="email" class="input" placeholder="Email" >
<input type="password" name="password" class="input" placeholder="Password">
<a href="">Forget Password?</a>  <!--lesa el forget pass mt3mlsh missing href -->
<p class="haveaccount">Don't have an account?<a href="">Sign up</a></p>  <!--missing href -->
<button type="submit" name="login">Login</button>
</form>
</body>
</html>