<?php
include("connection.php");
// if the user is not logged in 
// uncomment when done
// if(empty($_SESSION['freelancer_id'])){
//     header("location:home.php");
// }

if(isset($_SESSION['user_id'])){
    $user_id=$_SESSION['user_id'];
}
// SELECT USER INFO
$select_user = "SELECT * FROM `user` 
                JOIN `nationality` ON `nationality`.`nationality_id` = `user`.`nationality_id`
                WHERE `user_id` = '$user_id'";
$run_user = mysqli_query($connect,$select_user);
// select posted projects
$select_posted_projects = "SELECT * FROM `project`
                            JOIN `user` ON `user`.`user_id` = `project`.`user_id`
                            JOIN `type` ON `type`.`type_id` = `project`.`type_id`
                            WHERE `project`.`user_id` = '$user_id' AND `project`.`posting` = 1";
$run_posted_projects = mysqli_query($connect,$select_posted_projects);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
</head>
<body>
    <div>
        <div>
            <?php foreach($run_user as $data){ ?>
                <img src="<?php echo "img/profile/". $data['user_image'] ?>" alt="User Image">
                <h2><?php echo $data['user_name'] ?></h2>
                <p><strong>Phone:</strong> <?php echo $data['phone_number'] ?></p>
                <p><strong>Email:</strong> <?php echo $data['email'] ?></p>
                <p><strong>Nationality:</strong> <?php echo $data['nationality']?></p>
                <p><strong>Bio:</strong><?php echo $data['bio'] ?>.</p>
                <a href="./editPROFILEclient.php">Edit Profile</a>
                <form method="POST">
                    <button type="submit" name="logout">Logout</button>
                </form>
            <?php } ?> 
        </div>

        <div>
            <h3>Posted Projects</h3>
            <?php  if(mysqli_num_rows($run_posted_projects) > 0) { ?>
            <?php foreach($run_posted_projects as $project){ ?>
                <div>
                    <h4><strong>Project:</strong> <?php echo $project['project_name'] ?></h4>
                    <p><strong>Description:</strong> <?php echo $project['description'] ?>.</p>
                    <p><strong>Total Hours:</strong> <?php echo $project['total_hours'] ?> hours</p>
                    <p><strong>Deadline Date:</strong> <?php echo $project['deadline_date']?></p>
                </div>
            <?php }}else{ ?>
            <h3>NO POSTS YET.</h3>
            <?php } ?> 
        </div>
    </div>
</body>
</html>
