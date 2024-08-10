<?php
include("connection.php");
if(isset($_SESSION['freelancer_id'])){
    echo " Welcome ". $_SESSION['freelancer_name'];
}
elseif(isset($_SESSION['user_id'])){
    echo " Welcome ". $_SESSION['user_name'];
}


    ?>
<title>home</title>
<form method="post">
    <button type="submit" name="logout">Logout</button>
</form>
