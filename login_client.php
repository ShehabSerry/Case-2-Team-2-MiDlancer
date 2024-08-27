<?php
include("connection.php");
$error="";

// $select="SELECT *FROM `user` WHERE `email`='$email'";
// $runselect=mysqli_query($connect,$select);
// $fetch=mysqli_fetch_assoc($runselect);


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
            {
              $data = mysqli_fetch_assoc($runselect);
              $hashedPass = $data['password'];
              if (password_verify($password, $hashedPass))
              {
                  $_SESSION['user_id'] = $data['user_id'];
                  $_SESSION['user_name'] = $data['user_name'];
                  header("Location: home.php"); 
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
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <!-- link css -->
   <link rel='stylesheet' type='text/css'  media="screen" href="css/login.css"/>
    <title>Login</title>
  </head>

  <body> 
<div class="background">
    <div class="container-main">
      <div class="wrapper">
          <a href="home.php" class="close"><i class="fa-solid fa-x"></i></a>
          <div class="from-wraapper  Sign-in">

          <form method="post">
          <h2>Login</h2>
         
          
          <div class="input-group">
              <input type="email" required name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
              <label for="">E-mail</label>
          </div>
          
          
          <div class="input-group">
              <input type="password" required  name="password">
              <label for="">Password</label>
          </div>
              <br>
              <?php if($error){

echo "<div class='alert alert-warning' role='alert'>$error</div>"; } ?>
          <div class="buttons">

      <button class="Btn" name="login">
          SUBMIT
      </button>
      <br>
    <a class="FRG " href="emailverify_client.php"">Forgot Password?</a>
    <br>
    <a class="DHA" href="user_sign_up.php">Dont have an account?</a>

  </div>
          <div class="signUp-link">
              <p> <a href="user_sign_up.php" class="signUpBtn-link"></a> </p>
          </div>
          </form>
          </div>
          </div>
  </div>   
</div>
    <script src="main.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const errorElements = {
            email: document.createElement('div'),
            password: document.createElement('div')
        };

        for (const field in errorElements) {
            const inputElement = document.querySelector(`[name="${field}"]`);
            const errorElement = errorElements[field];
            errorElement.className = 'error-message';
            inputElement.parentNode.appendChild(errorElement);

            inputElement.addEventListener('blur', function() {
                validateField(field);
            });

            inputElement.addEventListener('input', function() {
                validateField(field);
            });
        }

        function validateField(field) {
            const inputElement = document.querySelector(`[name="${field}"]`);
            const value = inputElement.value.trim();
            let errorMessage = '';

            switch (field) {
                case 'email':
                    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!value) errorMessage = 'Email is required';
                    else if (!emailPattern.test(value)) errorMessage = 'Invalid email format';
                    break;
                case 'password':
                    if (!value) errorMessage = 'Password is required';
                    break;
            }

            errorElements[field].textContent = errorMessage;
            return !errorMessage;
        }

        form.addEventListener('submit', function(event) {
            let isValid = true;
            for (const field in errorElements) {
                if (!validateField(field)) {
                    isValid = false;
                }
            }

            if (!isValid) {
                event.preventDefault();
            }
        });
    });
</script>

  </body>

</html>