<?php
include 'connection.php';
// if(isset($_POST['request'])){
    // $project_id=$_GET['project_id'];
    // $freelancer_id=$_GET['freelancer_id'];
    
    // $project_id=$_GET['project_id'];
    $user_id=$_SESSION['user_id'];
    $select="SELECT * FROM `applicants` 
    JOIN `project` ON `applicants`.`project_id`= `project`.`project_id`
    JOIN `freelancer` ON `applicants`.`freelancer_id`= `freelancer`.`freelancer_id`
    JOIN `career` ON `freelancer`.`career_id`= `career`.`career_id`
    WHERE `project`.`user_id`=$user_id";
    $run_select=mysqli_query($connect, $select);
    $fetch_project=mysqli_fetch_assoc($run_select);
    // $project_name=$fetch_project['project_name'];

    // $freelancer_id=15;
    // $freelancer_id=$_GET['freelancer_id'];
    // $select_freelancer="SELECT * FROM `freelancer` join `career`on `freelancer`.`career_id`=`career`.`career_id` WHERE `freelancer_id`= $freelancer_id";
    // $run_select_freelancer=mysqli_query($connect, $select_freelancer);
    // $fetch_freelancer=mysqli_fetch_assoc($run_select);
    // $freelancer_name=$fetch_freelancer['freelancer_name'];
    // $job_title=$fetch_freelancer['job_title'];
    // $career_path=$fetch_freelancer['career_path'];


if(isset($_POST['accept'])){
    header('location:payment.php');
}elseif(isset($_GET['delete']) && $_GET['delete'] == 'true'){
    $project_id = $_GET['project_id'];
    $freelancer_id = $_GET['freelancer_id'];

    $delete="DELETE FROM `applicants` WHERE `project_id`= $project_id AND `freelancer_id`= $freelancer_id";
    if(mysqli_query($connect, $delete)){
        echo "Applicant has been removed.";
    } else {
        echo "Error: " . mysqli_error($connect);
    }
    
    // Redirect to the same page to refresh the list
    header('location:view_applicant.php');
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Applicants</title>
</head>
<body>
    <h1>Applicants</h1>
    <form method="POST">
        <?php foreach($run_select as $data){?>
                <?php echo $data['project_name'];?> <br>
                <?php echo $data['freelancer_name'];?> <br>
                <?php echo $data['job_title'];?> <br>
                <?php echo $data['career_path'];?> <br>

                <input type="hidden" value="<?php echo $data['project_id'];?>" name="project_id">
                <input type="hidden" value="<?php echo $data['freelancer_id'];?>" name="freelancer_id">
                <a href="freelancer_profile.php">View Profile</a>
                <button name="accept" type="submit">Accept</button>
                <a href="view_applicant.php?delete=true&project_id=<?php echo $data['project_id'];?>&freelancer_id=<?php echo $data['freelancer_id'];?>">Decline</a>
                <br><br>
            <?php }?>
    </form>
</body>
</html>