<?php             
include("connection.php");

if(isset($_SESSION['freelancer_id']))
    $freelancer_id = $_SESSION['freelancer_id'];
else
    header("Location: home.php"); // not really needed here, butt jus to be sure

$display_query = "SELECT * FROM `project` 
join `team_member` on `project`.`project_id`=`team_member`.`project_id`
join `freelancer` on `freelancer`.`freelancer_id`=`team_member`.`freelancer_id`
where `freelancer`.`freelancer_id`= '$freelancer_id' ";
            
$run = mysqli_query($connect, $display_query);   

$subs="SELECT * FROM subscription  
join `plan` on `subscription`.`plan_id`= `plan`.`plan_id`
where freelancer_id= '$freelancer_id'";
$runS = mysqli_query($connect, $subs);   
$fetch=mysqli_fetch_array($runS);
$plan_name= $fetch['plan_name'];
$planEndDate=date("Y-m-d", strtotime($fetch['end_date']));

$count = mysqli_num_rows($run);  

if ($count > 0) {
    $data_arr = array();
    $i = 0;
    foreach($run as $data_row) {	
        $data_arr[$i]['task_name'] = $data_row['project_name'];
        $data_arr[$i]['deadline_date'] = date("Y-m-d", strtotime($data_row['deadline_date']));
        $data_arr[$i]['color'] = '#0A7273'; 
        $data_arr[$i]['project_url'] = 'project_details_freelancer.php?details=' . $data_row['project_id']; 
        $i++;
    }
	$data_arr[]=['task_name'=>$plan_name, 'deadline_date'=>$planEndDate];
    $data = array(
        'status' => true,
        'msg' => 'Successfully retrieved tasks!',
        'data' => $data_arr
    );
} else {
    $data = array(
        'status' => false,
        'msg' => 'No tasks found!'
    );
}

echo json_encode($data);
?>
