<?php
include("connection.php");
$freelancer_id=$_SESSION['freelancer_id'];
// $freelancer_id=15;
$select_views="SELECT * FROM `views` WHERE `freelancer_id`= $freelancer_id";
$run_select_views=mysqli_query($connect, $select_views);
// COUNT VIEWS
$view_count_query = "SELECT COUNT(*) as view_count FROM `views` WHERE `freelancer_id` = $freelancer_id ";
$view_result_result = mysqli_query($connect,$view_count_query);
$view_count = mysqli_fetch_assoc($view_result_result)['view_count'];
echo "Views:" , $view_count;

echo "<br>" ;

$select_project="SELECT * FROM `team_member` WHERE `freelancer_id`= $freelancer_id";
$run_select_project=mysqli_query($connect, $select_project);
// COUNT VIEWS
$project_query = "SELECT COUNT(*) as project_count FROM `team_member` WHERE `freelancer_id` = $freelancer_id ";
$project_result = mysqli_query($connect,$project_query);
$project_count = mysqli_fetch_assoc($project_result)['project_count'];
echo "Projects:" , $project_count;

echo "<br>" ;

$select_comment="SELECT * FROM `comment` WHERE `freelancer_id`= $freelancer_id";
$run_select_comment=mysqli_query($connect, $select_project);
// COUNT VIEWS
$comment_query = "SELECT COUNT(*) as comment_count FROM `comment` WHERE `freelancer_id` = $freelancer_id ";
$comment_result = mysqli_query($connect,$comment_query);
$comment_count = mysqli_fetch_assoc($comment_result)['comment_count'];
echo "Comments:" , $comment_count;
?>
