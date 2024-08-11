<?php

include("connection.php");

$select="SELECT * FROM `project`";
$run=mysqli_query($connect, $select);

if(isset($_GET['user_id'])){
    $user_id=1;
    // $user_id=$_GET['user_id'];
    $select_user="SELECT * FROM `user` WHERE `user_id`= $user_id";
    $run_select_user=mysqli_query($connect, $select_user);

    if(isset($_POST['submit'])){
        $name=mysqli_real_escape_string($connect, $_POST['project_name']);
        $description=mysqli_real_escape_string($connect, $_POST['description']);
        $total_hours=mysqli_real_escape_string($connect, $_POST['total_hours']);
        $deadline=mysqli_real_escape_string($connect, $_POST['deadline_date']);
        $dead=strtotime($deadline);
        $current_date= time();
        $post=mysqli_real_escape_string($connect, $_POST['posting']);

        if(empty($name) || empty($description) || empty($total_hours) || empty($deadline)){
            echo "Please fill in the required data!";
        }elseif($deadline <= $current_date){
            echo "Please enter new date!";
        }else{
            $dead=date("Y-m-d",$dead);
        }
        if($post=='1'){
            $insert="INSERT INTO `project` VALUES (NULL, '$name', '$description', '$total_hours', '$dead', $user_id, NULL, 1)";
            $run_insert= mysqli_query($connect, $insert);
        header('location:job_posting.php');
        }else{
            $insert="INSERT INTO `project` VALUES (NULL, '$name', '$description', '$total_hours', '$dead', $user_id, NULL, 0)";
            $run_insert= mysqli_query($connect, $insert);
            header('location:wall.php');
        }
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Project</title>
</head>
<body>
    <h1>Add project</h1>
    <form method="POST">
        <input type="text" placeholder="Project Name" name="project_name" required><br>
        <input type="text" placeholder="Description" name="description" required><br>

        <input id="number" type="number" placeholder="Total Hours" name="total_hours" required><br>
        <input id="date" type="date" placeholder="Deadline" name="deadline_date" required><br>

        <input type="radio" id="post" name="posting" value="1">
        <label for="">Post</label>
        
        <input type="radio" id="post" name="posting" value="0">
        <label for="">Don't Post</label><br>

        <button name="submit" type="submit">Add Project</button>
    </form>
</body>
</html>