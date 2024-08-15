<?php

include("mail.php");

$select="SELECT * FROM `project`";
$run=mysqli_query($connect, $select);
$select_career = "SELECT * FROM `career`";
$run_select_career = mysqli_query($connect, $select_career);

// if(isset($_GET['user_id'])){
// $user_id=$_SESSION['user_id'];
// $user_id=$_GET['user_id'];
$user_id=1;
$select_user="SELECT * FROM `user` WHERE `user_id`= $user_id";
$run_select_user=mysqli_query($connect, $select_user);

if(isset($_POST['submit'])){
    $name=mysqli_real_escape_string($connect, $_POST['project_name']);
    $description=mysqli_real_escape_string($connect, $_POST['description']);
    $total_hours=mysqli_real_escape_string($connect, $_POST['total_hours']);
    $deadline=mysqli_real_escape_string($connect, $_POST['deadline_date']);
    $career_id=mysqli_real_escape_string($connect, $_POST['career']);
    $dead= strtotime($deadline);
    $current_date= time();
    $post=mysqli_real_escape_string($connect, $_POST['posting']);

    if(empty($name) || empty($description) || empty($total_hours) || empty($deadline)){
        echo "Please fill in the required data!";
    }elseif($dead <= $current_date){
        echo "Please enter new date!";
    }else{
        $dead=date("Y-m-d",$dead);
    }
    if($post=='1'){
        $insert="INSERT INTO `project` VALUES (NULL,'$name','$description','$total_hours','$dead',$user_id,NULL,1)";
        $run_insert= mysqli_query($connect, $insert);
        header('location:my_projects_client.php');

        $select_email="SELECT `email` FROM `freelancer` WHERE `career_id`= $career_id AND `premium`= 1 AND `hidden`= 0";
        $run_select_email=mysqli_query($connect, $select_email);

        $fetch=mysqli_fetch_assoc($run_select_email);
        $email=$fetch['email'];
        if(mysqli_num_rows($run_select_email)>0){
            //$mail = new PHPMailer();
            foreach($run_select_email as $row){
                $to= $row['email'];
                $subject= "New Job Opportunity: $name";
                $message= "Dear Freelancer, <br> <br> A New job opportunity in the $name with $description with total hours $total_hours has been posted. You have been given the opportunity to apply first. Please visit our website to apply.";
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
        // echo "1";
    }else{
        $insert="INSERT INTO `project` VALUES (NULL,'$name','$description','$total_hours','$dead',$user_id,NULL,0)";
        $run_insert= mysqli_query($connect, $insert);
        header('location:my_projects_client.php');
        // echo "0";
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
</head>

<body>
<div class="background">
    <div class="container-main">
        <div class="wrapper">
            
      <a href="user_sign_up.php" class="close"><i class="fa-solid fa-x "></i></a>
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

                    <div class="radio">
                        <label for="checkbox">Post</label>
                        <input type="radio" name="posting" value="1" id="checkbox">

                        <label for="checkbox">Don't Post</label>
                        <input type="radio" name="posting" value="0" id="checkbox">
                    </div>

                    <div class="input-group">
                        <select name="career" id="career">
                            <?php foreach ($run_select_career as $data) { ?>
                                <option value="" disabled selected hidden> Career</option>
                                <option value="<?php echo $data['career_id']; ?>"><?php echo $data['career_path']; ?></option>
                            <?php } ?>
                        </select>
                    </div>

            </div>
            <div class="">
                
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

                        <!-- <div class="button">
                            <button class="cssbuttons-io-button addto";>
                              <a href="#" class="butt" style="text-decoration: none;">ADD MEMBER</a>
                              <div class="icon">
                                <svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                  <path d="M0 0h24v24H0z" fill="none"></path>
                                  <path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z"
                                    fill="currentColor"></path>
                                </svg>
                              </div>
                            </button>
                          </div> -->
                    </div>
                
                <script src="main.js"></script>
</body>

</html>
