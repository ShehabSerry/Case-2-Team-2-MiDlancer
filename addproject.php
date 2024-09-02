<?php

include("mail.php");

if(!isset($_SESSION['user_id']))
    header("Location: home.php");

$select="SELECT * FROM `project`";
$run=mysqli_query($connect, $select);
$select_career = "SELECT * FROM `career`";
$run_select_career = mysqli_query($connect, $select_career);

$user_id=$_SESSION['user_id'];

$select_user="SELECT * FROM `user` WHERE `user_id`= $user_id";
$run_select_user=mysqli_query($connect, $select_user);

if(isset($_POST['submit'])){
    $name=htmlspecialchars(strip_tags(mysqli_real_escape_string($connect, $_POST['project_name'])));
    $description=htmlspecialchars(strip_tags(mysqli_real_escape_string($connect, $_POST['description'])));
    $total_hours=htmlspecialchars(strip_tags(mysqli_real_escape_string($connect, $_POST['total_hours'])));
    $deadline=mysqli_real_escape_string($connect, $_POST['deadline_date']);
    $career_id=mysqli_real_escape_string($connect, $_POST['career']);
    $dead= strtotime($deadline);
    $current_date= time();
    $post=mysqli_real_escape_string($connect, $_POST['posting']);

    if(empty($name) || empty($description) || empty($total_hours) || empty($deadline)){
        echo "Please fill in the required data!";
    }elseif($dead <= $current_date){
        echo "Please enter new date!";
    }
    else if($post=='1'){
        $insert="INSERT INTO `project` VALUES (NULL,'$name','$description','$total_hours','$deadline',$user_id,1,1)";
        $run_insert= mysqli_query($connect, $insert);
        header('location:my_projects_client.php');

        $select_email="SELECT `email` FROM `freelancer` 
                    LEFT JOIN `subscription` ON `freelancer`.`freelancer_id` = `subscription`.`freelancer_id`
                    WHERE `career_id`= $career_id AND `plan_id` > 1 AND `hidden`= 0 AND `admin_hidden`= 0 ";
        $run_select_email=mysqli_query($connect, $select_email);

        $fetch=mysqli_fetch_assoc($run_select_email);
        $email=$fetch['email'];
        if(mysqli_num_rows($run_select_email)>0){
            //$mail = new PHPMailer();
            foreach($run_select_email as $row){
                $to= $row['email'];
                $subject= "New Job Opportunity: $name";
                $message= "
                <body style='font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #fffffa; color: #00000a; line-height: 1.6;'>
                    <div style='background-color: #080a74; padding: 20px; text-align: center; color: #fffffa;'>
                        <h1 style='color: #fffffa;'>New Job Opportunity Alert!</h1>
                    </div>
                    <div style='padding: 20px; background-color: #f7faffd3; color: #00000a; border-radius: 25px; box-shadow: -2px 13px 32px 0px rgba(0, 0, 0, 0.378); transition: all 0.5s; margin-top: 5%; margin-bottom: 5%;'>
                        <p style='color: #00000a;'>Dear Freelancer,</p>
                        <p style='color: #00000a;'>A new job opportunity titled <span style='color: #080a74; background-color: #f6d673; padding: 2px 4px; border-radius: 3px;'>$name</span> with the following description: <span style='color: #080a74; background-color: #f6d673; padding: 2px 4px; border-radius: 3px;'>$description</span> and a total of <span style='color: #080a74; background-color: #f6d673; padding: 2px 4px; border-radius: 3px;'>$total_hours</span> hours has been posted.</p>
                        <p style='color: #00000a;'>As a premium member, you are notified immediately when a job that matches your career is posted. This ensures you get the best chances at securing top jobs.</p>
                        <p style='color: #00000a;'>Please visit our website to apply and take advantage of this early access.</p>
                        <p style='color: #080a74; padding: 2px 4px; border-radius: 3px;'>Happy MiDlancing!</p>
                        <p style='color: #00000a;'>Best regards,<br>The MiDlancer Team</p>
                    </div>
                    <div style='background-color: #f6d673; color: #080a74; padding: 20px; text-align: center; border-bottom-left-radius: 25px; border-bottom-right-radius: 25px;'>
                        <p style='color: #080a74;'>For support and updates, please visit our website or contact us via email.</p>
                        <p style='color: #080a74;'>Email: <a href='mailto:MiDlancerTeam@gmail.com' style='color: #080a74;'>MiDlancerTeam@gmail.com</a></p>
                    </div>
                </body>
"; // FRONT STYLING NEEDED
                // $headers= "From: midlancerteam@gmail.com";
                global $mail;
                $mail->setFrom('MiDlancerTeam@gmail.com', 'MiDlancer');
                $mail->addAddress($to);
                $mail->isHTML(true);
                $mail->Subject= ($subject);
                $mail->Body=($message);
                $mail->send();
                $mail->clearAddresses();
            }
        }
    }else{
        $insert="INSERT INTO `project` VALUES (NULL,'$name','$description','$total_hours','$deadline',$user_id,1,0)";
        $run_insert= mysqli_query($connect, $insert);
        header('location:my_projects_client.php');
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
    <link rel='stylesheet' type='text/css'  media="screen" href="css/addproject.css"/>
    <title>Add Project</title>
    <link href="imgs/logo.png" rel="icon">
</head>

<body>
<div class="background">
    <div class="container-main">
        <div class="wrapper">
            
            <a href="my_projects_client.php" class="close"><i class="fa-solid fa-x "></i></a>
            <div class="from-wraapper  Sign-in">
                <form action="" method="post">
                    <h2>Add Project</h2>

                    <div class="input-group">
                        <input type="text" name="project_name" required>
                        <label> Project Name: </label>
                    </div>

                    <div class="input-group">
                        <input type="text" name="description" required>
                        <label> Description: </label>
                    </div>

                    <div class="nada">

                        <div class="input-group">
                            <input type="number" name="total_hours" required class="may" >
                            <label class="date"> Total hours: </label>
                        </div>


                        <div class="input-group">
                            <input  type="date" name="deadline_date" required class="may" id="me">
                            <label class="date"> Deadline: </label>
                        </div>
                    </div>

                   

                    <div class="input-group">
                        <select name="career" id="career">
                            <?php foreach ($run_select_career as $data) { ?>
                                <option value="" disabled selected hidden> Career</option>
                                <option value="<?php echo $data['career_id']; ?>"><?php echo $data['career_path']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="radio">
                        <label for="checkbox1">Post</label>
                        <input type="radio" name="posting" value="1" id="checkbox1">

                        <label for="checkbox2">Don't Post</label>
                        <input type="radio" name="posting" value="0" id="checkbox2">
                    </div>
                    <br>
            </div>
        
            <div class="button">
                <button name="submit" type="submit" class="cssbuttons-io-button addto">
                    <a href="#" class="butt" style="text-decoration: none;">SUBMIT</a>
                    <div class="icon">
                        <svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z"
                                    fill="currentColor"></path>
                        </svg>
                    </div>
                </button>

            </div>
        </div>
    </div>
</div>
    
    <script src="main.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const errorMessages = {
            project_name: "Project Name is required",
            description: "Description is required",
            total_hours: "Total hours is required and must be a positive number",
            deadline_date: "Deadline date is required and must be in the future"
        };

        const errorElements = {
            project_name: createErrorElement(),
            description: createErrorElement(),
            total_hours: createErrorElement(),
            deadline_date: createErrorElement()
        };

        for (const field in errorElements) {
            const inputElement = document.querySelector(`[name="${field}"]`);
            const errorElement = errorElements[field];
            inputElement.parentNode.appendChild(errorElement);

            inputElement.addEventListener('blur', () => validateField(field));
            inputElement.addEventListener('input', () => validateField(field));
        }

        function createErrorElement() {
            const errorElement = document.createElement('div');
            errorElement.className = 'error-message';
            return errorElement;
        }

        function validateField(field) {
            const inputElement = document.querySelector(`[name="${field}"]`);
            const value = inputElement.value.trim();
            let errorMessage = '';

            switch (field) {
                case 'project_name':
                case 'description':
                    if (!value) errorMessage = errorMessages[field];
                    break;
                case 'total_hours':
                    if (!value) errorMessage = errorMessages[field];
                    else if (isNaN(value) || value <= 0) errorMessage = "Total hours must be a positive number";
                    break;
                case 'deadline_date':
                    const deadlineDate = new Date(value);
                    const today = new Date();
                    if (!value) errorMessage = errorMessages[field];
                    else if (deadlineDate <= today) errorMessage = "Deadline must be in the future";
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
