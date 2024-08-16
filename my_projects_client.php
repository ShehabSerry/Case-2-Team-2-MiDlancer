<?php
include("connection.php");
$user_id=$_SESSION['user_id'];
// $user_id=1;  // STATIC

//$join="SELECT *, distinct `team_member`.`project_id` FROM `project`
// $join="SELECT * FROM `project`
// right JOIN `user` ON `user`.`user_id`=`project`.`user_id`
// left JOIN `team_member` ON `project`.`project_id`=`team_member`.`project_id`
// left JOIN `freelancer` ON `freelancer`.`freelancer_id`=`team_member`.`freelancer_id`
// WHERE `user`.`user_id` ='$user_id'";
$join = "SELECT *, SUM(`price/hr`) AS 'sumrates', `project`.`project_id` AS `pid` FROM `project`
right JOIN `user` ON `user`.`user_id`=`project`.`user_id`
left JOIN `team_member` ON `project`.`project_id`=`team_member`.`project_id`
left JOIN `freelancer` ON `freelancer`.`freelancer_id`=`team_member`.`freelancer_id`
--  join `type` ON `type`.`project_id`=`project`.`project_id`
WHERE `user`.`user_id` ='$user_id' 
GROUP BY `project`.`project_id`";
$run_join=mysqli_query($connect,$join);

$fetch=mysqli_fetch_assoc($run_join);
$price_per_hr=$fetch['price/hr'];
$price_per_hr = $fetch['sumrates'];
$total_hours=$fetch['total_hours'];



function SUM1($price_per_hr,$total_hours){
    $total_price=$price_per_hr * $total_hours;
    return "$total_price";
}
// // -- WHERE `project_id`='$id' 
// $filter= "";
// if(isset($_GET['filter'])){
//     $filter = mysqli_fitch_assoc($connect, $_GET['filter']);
//     if ($filter == 'individual'){
//         $select_project .= "`type_id` == 1";
//     }elseif ($filter == 'Team'){
//         $select_project .= "`type_id` == 2";
//     }
// }
// $run_project = mysqli_query($connect, $select_project);
// $select="SELECT * FROM `PROJECT` WHERE `type_id` =1";
// $run_select= mysqli_query($connect, $select);
// $filter= "";
// if(isset($_GET['filter'])){
//     $filter=$_GET['$run_select'];
//     $select_project .= "AND `project` BETWEEN 'individual'";

//     $filter=mysqli_fetch_assoc($connect,$run_select);
//     if ($filter == 'individual'){
//                 $select_project .= "AND `project` BETWEEN 'individual'";
//                 if($filter == 'individual'){
//                     // $projects[]=[

//                     // ]
//                 }
// }
// IMPORTANTTTT /////////////
// $select="SELECT * FROM `project`
// JOIN `type` ON `type`.`type_id`=`project`.`type_id`";

// $type_id= "";
// if(isset($_GET['type_id']))  {
//     $type_id = mysqli_real_escape_string($connect, $_GET['type_id']);
//     // $filter = mysqli_real_escape_string($connect, $_GET['filter']);
//     if ($type_id == 1) {
//         $type_id = "SELECT * FROM `project` WHERE `type_id` = 1";
//     } elseif ($type_id == 2) {
//         $type_id = "SELECT * FROM `project` WHERE `type_id` = 2";
//     } else {
//         $type_id = "SELECT * FROM `project`";
//     }
// }


//     $run_select = mysqli_query($connect, $select);
//IMPORTANTTTT ///////////////

// Prepare the SQL query based on the filter


// Execute the query
// $stmt = $pdo->prepare($sql);
// $stmt->execute();

// // Fetch all projects
// $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);


// $filter_query = "";
// if (isset($_GET['type_id'])) {
//     $type_id = (int)$_GET['type_id'];  // Ensure it's an integer
//     if ($type_id == 1) {
//         $filter_query = " WHERE `type_id` = 1";
//     } elseif ($type_id == 2) {
//         $filter_query = " WHERE `type_id` = 2";
//     }
// }

// // If there is a filter, modify the query accordingly
// $select = "SELECT * FROM `project` JOIN `type` ON `type`.`type_id` = `project`.`type_id`" . $filter_query;
// $run_select = mysqli_query($connect, $select);

$type_id = "";

if (isset($_GET['type_id'])) {
    $type_id = mysqli_real_escape_string($connect, $_GET['type_id']);

    if ($type_id == 1){
        $select1="SELECT *, SUM(`price/hr`) AS 'sumrates', `project`.`project_id` AS `pid` FROM `project`
        right JOIN `user` ON `user`.`user_id`=`project`.`user_id`
        left JOIN `team_member` ON `project`.`project_id`=`team_member`.`project_id`
        left JOIN `freelancer` ON `freelancer`.`freelancer_id`=`team_member`.`freelancer_id`
        JOIN `type` ON `type`.`type_id`=`project`.`type_id` WHERE `type`.`type_id` = 1 AND `user`.`user_id` ='$user_id' 
        GROUP BY `project`.`project_id`";
        
        $run_select1= mysqli_query($connect, $select1);
        

        SUM1($price_per_hr,$total_hours);
        if ($run_select1) {
            // echo 2;  
            $fetch_project = mysqli_fetch_assoc($run_select1);
        } else {
            echo "Error: " . mysqli_error($connect);
        }
    }
    elseif ($type_id == 2){
        // echo 3;
        $select2="SELECT *, SUM(`price/hr`) AS 'sumrates', `project`.`project_id` AS `pid` FROM `project`
        right JOIN `user` ON `user`.`user_id`=`project`.`user_id`
        left JOIN `team_member` ON `project`.`project_id`=`team_member`.`project_id`
        left JOIN `freelancer` ON `freelancer`.`freelancer_id`=`team_member`.`freelancer_id`
        JOIN `type` ON `type`.`type_id`=`project`.`type_id` WHERE `type`.`type_id` = 2 AND
        `user`.`user_id` ='$user_id' 
        GROUP BY `project`.`project_id`";
        $run_select2= mysqli_query($connect, $select2);
        

         SUM1($price_per_hr,$total_hours);

        if ($run_select2) {  
            $fetch_project = mysqli_fetch_assoc($run_select2);
        } else {
            echo "Error: " . mysqli_error($connect);
        }
    }
} 
// if(isset($_GET['details'])){ 
//     $select3="SELECT *, SUM(`price/hr`) AS 'sumrates', `project`.`project_id` AS `pid` FROM `project`
//     right JOIN `user` ON `user`.`user_id`=`project`.`user_id`
//     left JOIN `team_member` ON `project`.`project_id`=`team_member`.`project_id`
//     left JOIN `freelancer` ON `freelancer`.`freelancer_id`=`team_member`.`freelancer_id`
//     JOIN `type` ON `type`.`type_id`=`project`.`type_id` WHERE  `user`.`user_id` ='$user_id' 
//     GROUP BY `project`.`project_id`";
    
//     $run_select3= mysqli_query($connect, $select3);
    

//     SUM1($price_per_hr,$total_hours);
//     if ($run_select3) {
//         echo 3;  
//         $fetch_project = mysqli_fetch_assoc($run_select3);
//     } else {
//         echo "Error: " . mysqli_error($connect);
//     }
// }
?>




<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="css/index.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
<div class="main">
    <h1 class="title">MY PROJECTS</h1>
    <form method="GET">
    <button><a href="add_project.php">Add Project</a></button>
    <button><a href="my_projects_client.php<?php echo $data['pid']?>">All</a></button>
    <button type="submit"><a href="my_projects_client.php?type_id=1">Individual</a></button>
    <button type="submit"><a href="my_projects_client.php?type_id=2">Teams</a></button>
    
    </form>
</div>
<div class="ag-format-container">
    <div class="ag-courses_box">
        <?php if ($type_id ==1 ){ ?>
            <?php foreach($run_select1 as $data) { ?>
        <div class="ag-courses_item">
                <a href="#" class="ag-courses-item_link">
            <div class="ag-courses-item_bg"></div>
            <div class="ag-courses-item_title">
                <div class="ag-courses-item_title">
                    <h4 class="teams"><?php echo $data ['project_name']?></h4>
                    <p class="para"><?php echo $data ['description']?>
                    </p>
                </div>
            </div>

            <div class="ag-courses-item_date-box">
                <i class="fa-regular fa-clock"></i> Total Hours:
                <span class="ag-courses-item_date">
                <?php echo $data ['total_hours']?> Hour
                </span>
            </div>

            <div class="ag-courses-item_date-box">
                <i class="fa-solid fa-money-bills"></i>
                Total Price:
                <span class="ag-courses-item_date">
                <!-- <?php //echo SUM($fetch['price/hr'], $fetch['total_hours'])?> EGP -->
                <?php echo SUM1($data['sumrates'], $data['total_hours']);?> EGP
                </span>
            </div>
                <a href="project_details_client.php?details=<?php echo $data['pid']?>" class="ag-courses-item_anchor">project details</a>
            </a>
            
        </div>
        <?php } } elseif($type_id == 2){ ?>
        <div class="ag-format-container">
        <div class="ag-courses_box">
            <?php foreach($run_select2 as $key) { ?>
            <div class="ag-courses_item">
                    <a href="#" class="ag-courses-item_link">
                <div class="ag-courses-item_bg"></div>
                <div class="ag-courses-item_title">
                    <div class="ag-courses-item_title">
                        <h4 class="teams"><?php echo $key ['project_name']?></h4>
                        <p class="para"><?php echo $key ['description']?>
                        </p>
                    </div>
                </div>

                <div class="ag-courses-item_date-box">
                    <i class="fa-regular fa-clock"></i> Total Hours:
                    <span class="ag-courses-item_date">
                    <?php echo $key ['total_hours']?> Hour
                    </span>
                </div>

                <div class="ag-courses-item_date-box">
                    <i class="fa-solid fa-money-bills"></i>
                    Total Price:
                    <span class="ag-courses-item_date">
                    <!-- <?php //echo SUM($fetch['price/hr'], $fetch['total_hours'])?> EGP -->
                    <?php echo SUM1($key['sumrates'], $key['total_hours'])?> EGP
                    </span>
                </div>
                    <a href="project_details_client.php?details=<?php echo $key['pid']?>" class="ag-courses-item_anchor">project details</a>
                </a>
                
            </div>
        <?php } } elseif ($run_join ){?>
        <div class="ag-format-container">
        <div class="ag-courses_box">
        <?php foreach($run_join as $keyy) { ?>
        <div class="ag-courses_item">
                <a href="#" class="ag-courses-item_link">
            <div class="ag-courses-item_bg"></div>
            <div class="ag-courses-item_title">
                <div class="ag-courses-item_title">
                    <h4 class="teams"><?php echo $keyy ['project_name']?></h4>
                    <p class="para"><?php echo $keyy ['description']?>
                    </p>
                </div>
            </div>

            <div class="ag-courses-item_date-box">
                <i class="fa-regular fa-clock"></i> Total Hours:
                <span class="ag-courses-item_date">
                <?php echo $keyy ['total_hours']?> Hour
                </span>
            </div>

            <div class="ag-courses-item_date-box">
                <i class="fa-solid fa-money-bills"></i>
                Total Price:
                <span class="ag-courses-item_date">
                <!-- <?php //echo SUM($fetch['price/hr'], $fetch['total_hours'])?> EGP -->
                <?php echo SUM1($keyy['sumrates'], $keyy['total_hours'])?> EGP
                </span>
            </div>
                <a href="project_details_client.php?details=<?php echo $keyy['pid']?>" class="ag-courses-item_anchor">project details</a>
            </a>
            
        </div>
        <?php } } ?>

    </div>
</div>
</body>

</html>