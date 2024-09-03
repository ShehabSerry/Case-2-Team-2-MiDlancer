<?php
include 'mail.php';
$error="";

if(isset($_SESSION['freelancer_id']) || isset($_SESSION['user_id'])) // anti logged in users AUTH
    header("Location: home.php");

if(isset($_POST['submit'])){
    $name = htmlspecialchars(strip_tags(mysqli_real_escape_string($connect, $_POST['user_name'])));
    $email = htmlspecialchars(strip_tags(mysqli_real_escape_string($connect, $_POST['email'])));
    $phone = htmlspecialchars(strip_tags(mysqli_real_escape_string($connect, $_POST['phone_number'])));
    $password = htmlspecialchars(mysqli_real_escape_string($connect, $_POST['password']));
    $confirm_pass= htmlspecialchars($_POST['confirm_pass']);
    $passwordhashing = password_hash($password, PASSWORD_DEFAULT);
    $nationality = $_POST['nationality']; // from a clean DropDwn
    $lowercase = preg_match('@[a-z]@',$password);
    $uppercase = preg_match('@[A-Z]@',$password);
    $numbers = preg_match('@[0-9]@',$password);
    $select = "SELECT * FROM `user` WHERE `email` ='$email' ";
    $run_select = mysqli_query($connect,$select);
    $rows = mysqli_num_rows($run_select);
    
    if($rows>0)
        $error= "This email is already taken";
    elseif ($lowercase <1 || $uppercase <1 ||   $numbers<1)
        $error= "Password must contain at least 1 uppercase , 1 lowercase and number";
    elseif ($password !=$confirm_pass)
        $error= "Password doesn't match confirmed password";
    elseif (strlen($phone)!=11) // >>> 11 DOESN'T COVER ALL Arab countries <<<
        $error= "Please enter a valid phone number";
    elseif (empty($_POST['CHK-TOS']))
        $error= "You must read and accept TOS";
    else{
        $rand=rand(10000,99999);
        $_SESSION['rand']=$rand;
        $_SESSION['user_name']=$name;
        $_SESSION['email']=$email;
        $_SESSION['phone_number']=$phone;
        $_SESSION['password'] = $passwordhashing;
        $_SESSION['nationality']=$nationality;
        $_SESSION['time'] = time(); // we start calc'ing from this point
        $massage="
        <body style='font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #fffffa; color: #00000a; line-height: 1.6;'>
            <div style='background-color: #080a74; padding: 20px; text-align: center; color: #fffffa;'>
                <h1 style='color: #fffffa;'>Complete Your Registration</h1>
            </div>
            <div style='padding: 20px; background-color: #f7faffd3; color: #00000a; border-radius: 25px; box-shadow: -2px 13px 32px 0px rgba(0, 0, 0, 0.378); transition: all 0.5s; margin-top: 5%; margin-bottom: 5%;'>
                <p style='color: #00000a;'>Dear <span style='color: #080a74;'>$name</span>,</p>
                <p style='color: #00000a;'>Thank you for registering with MiDlancer! Please use the OTP below to verify your email address and complete your registration:</p>
                <div style='text-align: center;'>
                    <p style='text-align: center; font-size: 24px; font-weight: bold; color: #080a74; background-color: #f6d673; padding: 10px; border-radius: 5px; display: inline-block;'>$rand</p>
                </div>
                <p style='color: #00000a;'>If you did not request this registration, please ignore this email.</p>
                <p style='color: #00000a;'>Best regards,<br>The MiDlancer Team</p>
            </div>
            <div style='background-color: #f6d673; padding: 20px; text-align: center; color: #080a74; border-bottom-left-radius: 25px; border-bottom-right-radius: 25px;'>
                <p style='color: #080a74;'>For support and updates, please visit our website or contact us via email.</p>
                <p style='color: #080a74;'>Email: <a href='mailto:MiDlancerTeam@gmail.com' style='color: #080a74;'>MiDlancerTeam@gmail.com</a></p>
            </div>
        </body>
        ";
        $mail->setFrom('MiDlancerTeam@gmail.com', 'MiDlancer');
        $mail->addAddress($email);      
        $mail->isHTML(true);                               
        $mail->Subject = 'Account Activation code';
        $mail->Body=($massage);                 
        $mail->send(); 
        header("Location: otpuser.php");
    }
}
$select_nationality = "SELECT * FROM `nationality`";
$run_select_nationality = mysqli_query($connect, $select_nationality);
?>

<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!----link bootsrap-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <!-- link css -->
  <link rel='stylesheet' type='text/css' media="screen" href="css/clSignup.css" />

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

  <title>Client Sign-up</title>
  <link href="./imgs/logo.png" rel="icon">


</head>

<body>

  <div class="container-main">

    <div class="wrapper">    
      <a href="choose.php" class="close"><i class="fa-solid fa-x "></i></a>

      <div class="from-wraapper  Sign-in">
        <form method="post">
          <h2>Client Sign-Up</h2>


          <div class="input-group">
            <input type="text" required name="user_name"  value="<?php echo isset($_POST['user_name']) ? $_POST['user_name'] : ''; ?>" >
            <label for="">Name</label>
          </div>


          <div class="input-group">
            <input type="email" required name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
            <label for="">Email</label>
          </div>

          <div class="input-group">
              <input type="number" required name="phone_number" value="<?php echo isset($_POST['phone_number']) ? $_POST['phone_number'] : ''; ?>" >
              <label for="">Phone Number</label>
          </div>

          <div class="input-group">
            <select name="nationality" id="nationality">
                    <?php foreach ($run_select_nationality as $data) { ?>
                      <option value="" disabled selected hidden> Nationality </option>
                      <option value="<?php echo $data['nationality_id']; ?>"><?php echo $data['nationality']; ?></option>
                    <?php } ?>
                     </select>
                     <label for="" ></label>
          </div>

          <div class="input-group">
            <input type="password" required name="password">
            <label for="">Password</label>
          </div>
          <div class="input-group">
            <input type="password" required name="confirm_pass">
            <label for="">Confirm Password</label>
          </div>
        </div>
        
        <div class="terms">
          <!-- <input type="checkbox" id="terms" name="termsandconditions" value="Terms" class="terms"> -->
          <input class="form-check-input" type="checkbox" value="1" name="CHK-TOS" id="flexCheckDefault" required>
          <label class="form-check-label ms-2" for="flexCheckDefault">
           <a href="terms.html" target="_blank" > Terms and Conditions </a>
          </label>
    
        
          <!-- <p class="c">Terms and Conditions</p> -->
           
          
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

       <div class="signUp-link">
        <a class="Already" href="login_client.php">Already have an account?</a>
<!--    <p> <a href="user_sign_up.php" class="signUpBtn-link">signup</a> </p>-->
      </div> 
      </form>
    </div>
  </div>


  <script src="main.js"></script>
  <script>
     document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const errorElements = {
        user_name: document.createElement('div'),
        email: document.createElement('div'),
        phone_number: document.createElement('div'),
        password: document.createElement('div'),
        confirm_pass: document.createElement('div'),
        nationality: document.createElement('div'),
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
            case 'user_name':
                if (!value) errorMessage = 'Name is required';
                break;
            case 'email':
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(value)) errorMessage = 'Invalid email format';
                break;
            case 'phone_number':
                if (value.length !== 11) errorMessage = 'Phone number must be 11 digits';
                break;
            case 'password':
                const lowerCase = /[a-z]/.test(value);
                const upperCase = /[A-Z]/.test(value);
                const number = /[0-9]/.test(value);
                if (!lowerCase || !upperCase || !number) errorMessage = 'Password must contain at least 1 uppercase, 1 lowercase, and 1 number';
                break;
            case 'confirm_pass':
                if (value !== document.querySelector('[name="password"]').value) errorMessage = 'Passwords do not match';
                break;
            case 'nationality':
                if (!value) errorMessage = 'Nationality selection is required';
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







