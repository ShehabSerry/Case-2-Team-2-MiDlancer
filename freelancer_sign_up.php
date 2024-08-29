<?php
include 'mail.php';
$select_all = "SELECT * FROM `career`";
$run_select_all = mysqli_query($connect, $select_all);
$error ='';

if (isset($_POST['submit'])) {
    $name = htmlspecialchars(strip_tags(mysqli_real_escape_string($connect, $_POST['freelancer_name']))); // Rawan, please implement this (where it matters)
    $email = $_POST['email'];
    $phone = $_POST['phone_number'];
    $birthdate = $_POST['birthdate'];
    $join_date = date("Y-m-d");
    $birthdateSEC = strtotime($birthdate);
    $formatted_birthdate = date("Y-m-d", $birthdateSEC); // Format birthdate correctly
    $validDateSec = strtotime('-16 year'); // 16 years ago SEC

    $national_id = $_POST['national_id'];
    $password = $_POST['password'];
    $confirm_pass = $_POST['confirm_pass'];
    $passwordhashing = password_hash($password, PASSWORD_DEFAULT);
    $job_title = $_POST['job_title'];
    $career = $_POST['career'];

    // Password validation
    $lowercase = preg_match('@[a-z]@', $password);
    $uppercase = preg_match('@[A-Z]@', $password);
    $numbers = preg_match('@[0-9]@', $password);

    $eg_prefix = ['010', '011', '012', '015'];
    $phone_prefix = substr($phone, 0, 3);

    // Check if email already exists
    $select = "SELECT `email` FROM `freelancer` WHERE `email` ='$email'";
    $run_select = mysqli_query($connect, $select);
    $rows = mysqli_num_rows($run_select);

    $selectNID = "SELECT `national_id` FROM `freelancer` WHERE `national_id` ='$national_id'";
    $run_selectNID = mysqli_query($connect, $selectNID);
    // $rowsNID = mysqli_num_rows($run_selectNID);

    $selectPN = "SELECT `phone_number` FROM `freelancer` WHERE `phone_number` ='$phone'";
    $run_selectPN = mysqli_query($connect, $selectPN);
    $rowsPN = mysqli_num_rows($run_selectPN);

    if (empty($name) || empty($email) || empty($password) || empty($confirm_pass) || empty($phone) || empty($birthdate) || empty($job_title) || empty($career))
        $error = "Please fill the required data";
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        $error = "Invalid email format";
    else if ($rows > 0) {
        $error = "This email is already taken";
        // } elseif ($rowsNID > 0){
        //     $error = "This NID is already in use, login instead";
    } elseif (strlen($phone) != 11 || !in_array($phone_prefix, $eg_prefix)) {
        $error = "Please enter a valid Egyptian phone number";
    } elseif ($rowsPN > 0) {
        $error = "This Phone number is already in use";
    } elseif ($lowercase < 1 || $uppercase < 1 || $numbers < 1) {
        $error = "Password must contain at least 1 uppercase, 1 lowercase, and 1 number";
    } elseif ($password != $confirm_pass) {
        $error = "Password doesn't match confirmed password";

    } elseif (strlen($national_id) !== 14) {
        $error = "Invalid national ID format";
    } else {
        $cen = substr($national_id, 0, 1); // Extract century digit
        $year = substr($national_id, 1, 2); // Extract year part
        $month = substr($national_id, 3, 2); // Extract month part
        $day = substr($national_id, 5, 2); // Extract day part

        // Adjust year based on century digit
        $full_year = ($cen == 2 ? "19" : "20") . $year;



        // Check if the birthdate matches the National ID details
        if ($full_year != date("Y", strtotime($formatted_birthdate))) {
            $error = "Birth year does not match National ID";
        } elseif ($month != date("m", strtotime($formatted_birthdate))) {
            $error = "Birth month does not match National ID";
        } elseif ($day != date("d", strtotime($formatted_birthdate))) {
            $error = "Birth day does not match National ID";
        } elseif ($validDateSec < $birthdateSEC ) { // gotta be older (smaller number) than valid SEC, bigger UNIX = younger
            $error = "Freelancers must be 16 years or older";
        } else {
            // Continue with OTP and email sending
            $rand = rand(10000, 99999);
            $_SESSION['rand'] = $rand;
            $_SESSION['freelancer_name'] = $name;
            $_SESSION['email'] = $email;
            $_SESSION['phone_number'] = $phone;
            $_SESSION['birthdate'] = $formatted_birthdate; // Store the formatted birthdate
            $_SESSION['national_id'] = $national_id;
            $_SESSION['password'] = $passwordhashing;
            $_SESSION['job_title'] = $job_title;
            $_SESSION['career'] = $career;
            $_SESSION['time'] = time();
            $_SESSION['fl_join_date'] = $join_date;
            $message = "Your OTP is $rand"; // FRONT MAY STYLE THIS UP IN THE FUTURE
            $mail->setFrom('MiDlancerTeam@gmail.com', 'MiDlancer');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Account Activation code';
            $mail->Body = $message;
            $mail->send();

            header("location:otpfreelancer.php");
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- bs -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <!-- link css -->
    <link rel='stylesheet' type='text/css' ' media="screen" href="css/signin.css"/>
    <title>Sign-up fl</title>
</head>

<body>
<div class="background">
    <div class="container-main">
        <div class="wrapper">
            <a href="choose.php" class="close"><i class="fa-solid fa-x "></i></a>
            <div class="from-wraapper  Sign-in">
                <form method="post">
                    <?php if(!empty($error)) { ?>
                        <div class="alert alert-warning" role="alert">
                            <?php echo $error ?>
                        </div>
                    <?php } ?> <!-- TEMP STYLE SHOULD WAIT FOR FRONT -->
                    <h2>Freelancer Sign-Up</h2>

                    <div class="input-group">
                        <input type="text" required name="freelancer_name"  value="<?php echo isset($_POST['freelancer_name']) ? $_POST['freelancer_name'] : ''; ?>" >
                        <label for="">Name</label>
                    </div>


                    <div class="input-group">
                        <input type="email" required name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
                        <label for="">Email</label>
                    </div>

                    <div class="input-group">
                        <input type="text" required name="phone_number" pattern="[0-9]{11}" value="<?php echo isset($_POST['phone_number']) ? $_POST['phone_number'] : ''; ?>">
                        <label for="">Phone Number</label>
                    </div>
                    <div class="input-group">
                        <input type="password" required name="password" value="<?php if (isset($_POST['password'],$_POST['confirm_pass']) && $_POST['password'] == $_POST['confirm_pass']) echo $_POST['password']?>">
                        <label for="">Password</label>
                    </div>
                    <div class="input-group">
                        <input type="password" required name="confirm_pass" value="<?php if (isset($_POST['password'],$_POST['confirm_pass']) && $_POST['password'] == $_POST['confirm_pass']) echo $_POST['confirm_pass']?>">
                        <label for="">Confirm Password</label>
                    </div>
                    <div class="date d-flex mt-3">
                        <div class="input-group.w-50.me-2">
                            <!-- <input type="date" required name="birthdate"> -->
                            <input type="date" placeholder="Birthdate" name="birthdate" required value="<?php echo isset($_POST['birthdate']) ? $_POST['birthdate'] : ''; ?>">
                            <label for="">Birth Date</label>
                        </div>
                    </div>
                    <div class="input-group">
                        <input type="number" required name="national_id" value="<?php echo isset($_POST['national_id']) ? $_POST['national_id'] : ''; ?>">
                        <label for="">National Id</label>
                    </div>
                    <div class="input-group">
                        <input type="text" required name="job_title" value="<?php echo isset($_POST['job_title']) ? $_POST['job_title'] : ''; ?>">
                        <label for="">Job Title</label>
                    </div>


                    <div class="input-group">
                        <select name="career" id="career" value="<?php echo isset($_POST['career']) ? $_POST['career'] : ''; ?>">
                            <?php foreach ($run_select_all as $data) { ?>
                                <option value="" disabled selected hidden> Career</option>
                                <option value="<?php echo $data['career_id']; ?>" <?php echo (isset($_POST['career']) && $_POST['career'] == $data['career_id']) ? 'selected' : ''; ?>>
                                    <?php echo $data['career_path']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="terms">
          <!-- <input type="checkbox" id="terms" name="termsandconditions" value="Terms" class="terms"> -->
          <input class="form-check-input" type="checkbox" value="1" name="CHK-TOS" id="flexCheckDefault" required>
          <label class="form-check-label ms-2" for="flexCheckDefault">
           <a href="terms.html" target="_blank" > Terms and Conditions </a>
          </label>
    
        
          <!-- <p class="c">Terms and Conditions</p> -->
           
          
        </div>

                    <!--------------check box-->
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
                        <a class="Already" href="login_freelancer.php">Already have an account?</a>
                        <!--    <p> <a href="freelancer_sign_up.php" class="signUpBtn-link">signup</a> </p>--> <!-- I don't think that it should say signup here fr -->

                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="main.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const errorElements = {
                freelancer_name: document.createElement('div'),
                email: document.createElement('div'),
                phone_number: document.createElement('div'),
                password: document.createElement('div'),
                confirm_pass: document.createElement('div'),
                birthdate: document.createElement('div'),
                national_id: document.createElement('div'),
                job_title: document.createElement('div'),
                career: document.createElement('div')
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
                    case 'freelancer_name':
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
                    case 'birthdate':
                        const birthdate = new Date(value);
                        const today = new Date();
                        const age = today.getFullYear() - birthdate.getFullYear();
                        if (age < 16) errorMessage = 'Freelancers must be 16 years or older';
                        break;
                    case 'national_id':
                        if (value.length !== 14) errorMessage = 'National ID must be 14 digits';
                        break;
                    case 'job_title':
                        if (!value) errorMessage = 'Job title is required';
                        break;
                    case 'career':
                        if (!value) errorMessage = 'Career selection is required';
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
