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
        $selectemail = "SELECT * FROM `freelancer` WHERE `email` = '$email'";
        $runselect = mysqli_query($connect, $selectemail);

        if ($runselect)
        {
            if (mysqli_num_rows($runselect) > 0)
            {
                $data = mysqli_fetch_assoc($runselect);
                $hashedPass = $data['password'];
                if (password_verify($password, $hashedPass))
                {
                    $_SESSION['freelancer_id'] = $data['freelancer_id'];
                    $_SESSION['freelancer_name'] = $data['freelancer_name'];
                    header("Location: home.php"); //missing location "homepage"
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
        <link rel='stylesheet' type='text/css'  media="screen" href="css/login.css"/>
        <title>Login</title>
    </head>

    <body>
        <a href="" class="close"><i class="fa-solid fa-x "></i></a>
        <div class="background">
            <div class="container-main">
                <div class="wrapper">
                    <div class="from-wraapper  Sign-in">
                        <form method="post">
                        <h2>Login</h2>
                        <?php if($error){echo $error; } ?>

                        <div class="input-group">
                            <input type="email" required name="email">
                            <label for="">E-mail</label>
                        </div>

                        <div class="input-group">
                            <input type="password" required  name="password">
                            <label for="">Password</label>
                        </div>
                    </div>
                <div class="buttons">
                    <a class="FRG" href="emailverify_freelancer.php">Forgot Password?</a>
                    <button class="Btn" name="login">SUBMIT</button>
                    <a class="DHA" href="freelancer_sign_up.php">dont have an account?</a>
                </div>
                <div class="signUp-link">
                    <p> <a href="freelancer_sign_up.php" class="signUpBtn-link"></a> </p>
                </div>
                </form>
              </div>
            </div>
            </div>
            </div>
            <script src="main.js"></script>
    </body>
</html>