<?php
include("connection.php");
if(isset($_SESSION['freelancer_id'])){
    echo " Welcome". $_SESSION['freelancer_name'];
}else{
    header("location: login_freelancer.php");
}
?>
<title>home</title>
<form method="post">
    <button type="submit" name="logout">Logout</button>
</form>
