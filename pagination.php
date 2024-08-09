<?php 
include("connection.php");
$limit = 5;
if(isset($_GET['page'])){
    $page=$_GET['page'];
}
$num= "SELECT * FROM `user` ";
$run_count= mysqli_query($connect,$num);
$numRows=mysqli_num_rows($run_count);
echo $numRows."<br>";

 $num2=ceil($numRows / $limit);
 echo $num2."<br>";
$offset= ($page - 1) *$limit;
$select="SELECT * FROM `user` limit $limit offset $offset";
$run_select= mysqli_query($connect,$select);

foreach($run_select as $data){
    echo $data['email']."<br>";
}

for($pn = 1; $pn <= $num2; $pn++){
    echo "<a href='test.php?page=$pn'>$pn</a>"."<br>";
}


?>