<?php
include 'connection.php';
$admin_id=$_SESSION['admin_id'];
$select="SELECT * FROM `admin` WHERE `admin`.`admin_id` = $admin_id";
$run_select=mysqli_query($connect,$select);



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php foreach($run_select as $data){ ?>
    <label for="name">name: <?php echo $data ['name'];?></label>
    <br>
    <label for="name">email: <?php echo $data ['email'];?></label>
    
    <?php } ?>
    <a href="./changepass_admin.php">Change Password</a>
    <form method="POST">
                        <button type="submit" name="logout" id="logout">Logout</button>
                    </form>
    
</body>
</html>