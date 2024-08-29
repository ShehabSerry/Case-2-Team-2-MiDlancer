<?php
include 'nav+bm.php';
$freelancer_id=$_SESSION['freelancer_id'];
$error="";

$join = "SELECT *, SUM(`price/hr`) AS 'sumrates', `project`.`project_id` AS `pid` FROM `project`
right JOIN `user` ON `user`.`user_id`=`project`.`user_id`
left JOIN `team_member` ON `project`.`project_id`=`team_member`.`project_id`
left JOIN `freelancer` ON `freelancer`.`freelancer_id`=`team_member`.`freelancer_id`
WHERE `freelancer`.`freelancer_id` ='$freelancer_id'
GROUP BY `project`.`project_id`";
$run_join=mysqli_query($connect,$join);
$num=mysqli_num_rows($run_join);
if($num==0){
    $error= "you don't have any current projects";
}else{

$fetch=mysqli_fetch_assoc($run_join);
$price_per_hr=$fetch['price/hr'];
$price_per_hr = $fetch['sumrates'];
$total_hours=$fetch['total_hours'];

function SUM1($price_per_hr,$total_hours){
    $total_price=$price_per_hr * $total_hours;
    return "$total_price";
}

$type_id = "";

if (isset($_GET['type_id'])) {
    $type_id = mysqli_real_escape_string($connect, $_GET['type_id']);


    if ($type_id == 1){
        $select1="SELECT *, SUM(`price/hr`) AS 'sumrates', `project`.`project_id` AS `pid` FROM `project`
        right JOIN `user` ON `user`.`user_id`=`project`.`user_id`
        left JOIN `team_member` ON `project`.`project_id`=`team_member`.`project_id`
        left JOIN `freelancer` ON `freelancer`.`freelancer_id`=`team_member`.`freelancer_id`
        JOIN `type` ON `type`.`type_id`=`project`.`type_id` WHERE `type`.`type_id` = 1 AND `freelancer`.`freelancer_id` ='$freelancer_id'
        GROUP BY `project`.`project_id`";
        
        $run_select1= mysqli_query($connect, $select1);
        

        SUM1($price_per_hr,$total_hours);
        if ($run_select1) {
              
            $fetch_project = mysqli_fetch_assoc($run_select1);
        } else {
            echo "Error: " . mysqli_error($connect);
        }
    }
    elseif ($type_id == 2){
        
        $select2="SELECT *, SUM(`price/hr`) AS 'sumrates', `project`.`project_id` AS `pid` FROM `project`
        right JOIN `user` ON `user`.`user_id`=`project`.`user_id`
        left JOIN `team_member` ON `project`.`project_id`=`team_member`.`project_id`
        left JOIN `freelancer` ON `freelancer`.`freelancer_id`=`team_member`.`freelancer_id`
        JOIN `type` ON `type`.`type_id`=`project`.`type_id` WHERE `type`.`type_id` = 2 AND
        `freelancer`.`freelancer_id` ='$freelancer_id' 
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
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="css/myprojectfreelancer.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    
</head>

<body>
  
<div class="main">
    <h1 class="title">MY PROJECTS</h1>
    <form method="GET">
    <button><a href="my_projects_freelancer.php">All</a></button>
    <button type="submit" ><a href="my_projects_freelancer.php?type_id=1">Individual</a></button>
    <button type="submit" ><a href="my_projects_freelancer.php?type_id=2">Teams</a></button>
    
    </form>
</div>
<?php if($num==0){
  $error = "you don't have any current projects";
  if(!empty($error)) { ?>
    <div class="cards">
        <?php echo $error ?>
    </div>
 <?php } } else { ?>

<div class="ag-format-container">
    <div class="ag-courses_box">
    <?php if ($type_id ==1 ){ ?>
      <?php foreach($run_select1 as $data) { ?>
        <?php 
        $details="";
        $p_id=$data['pid'];
      $freelancer_count = "SELECT COUNT(freelancer_id) as freelancer_count FROM team_member WHERE `project_id`=$p_id";
  $freelancer_count_result = mysqli_query($connect,$freelancer_count);
  $f_count = mysqli_fetch_assoc($freelancer_count_result)['freelancer_count'];
  if($f_count>1){
    $update="UPDATE `project` SET `type_id` = 2 WHERE `project_id`=$p_id";
    $run_update=mysqli_query($connect,$update);
    header("refresh:1;url=my_projects_freelancer.php?type_id=1");
  }
        ?>
                <div class="ag-courses_item">
                <a href="#" class="ag-courses-item_link">
            <div class="ag-courses-item_bg"></div>
            <div class="ag-courses-item_title">
                <div class="ag-courses-item_title">
                    <h4 class="teams"><?php echo htmlspecialchars ($data ['project_name'],ENT_QUOTES,'UTF-8')?></h4>
                    <p class="para"><?php echo htmlspecialchars ($data ['description'],ENT_QUOTES,'UTF-8')?>
                    </p>
                </div>
            </div>

            <div class="ag-courses-item_date-box">
                <i class="fa-regular fa-clock"></i> Total Hours:
                <span class="ag-courses-item_date">
                <?php echo htmlspecialchars ( $data ['total_hours'],ENT_QUOTES,'UTF-8')?> Hour
                </span>
            </div>

            <div class="ag-courses-item_date-box">
                <i class="fa-solid fa-money-bills"></i>
                Total Price:
                <span class="ag-courses-item_date">
                <?php echo htmlspecialchars (SUM1($data['sumrates'], $data['total_hours']));?> EGP
                </span>
            </div>
                <a href="project_details_freelancer.php?details=<?php echo htmlspecialchars($data ['pid'],ENT_QUOTES,'UTF-8')?>" class="ag-courses-item_anchor">project details</a>
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
                        <h4 class="teams"><?php echo htmlspecialchars ($key ['project_name'],ENT_QUOTES,'UTF-8')?></h4>
                        <p class="para"><?php echo htmlspecialchars ($key ['description'],ENT_QUOTES,'UTF-8')?>
                        </p>
                    </div>
                </div>

                <div class="ag-courses-item_date-box">
                    <i class="fa-regular fa-clock"></i> Total Hours:
                    <span class="ag-courses-item_date">
                    <?php echo htmlspecialchars ( $key ['total_hours'],ENT_QUOTES,'UTF-8')?> Hour
                    </span>
                </div>

                <div class="ag-courses-item_date-box">
                    <i class="fa-solid fa-money-bills"></i>
                    Total Price:
                    <span class="ag-courses-item_date">
                    <?php echo SUM1($key['sumrates'], $key['total_hours'])?> EGP
                    </span>
                </div>
                    <a href="project_details_freelancer.php?details=<?php echo htmlspecialchars ($key['pid'],ENT_QUOTES,'UTF-8')?>" class="ag-courses-item_anchor">project details</a>
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
                    <h4 class="teams"><?php echo htmlspecialchars ($keyy ['project_name'],ENT_QUOTES,'UTF-8')?></h4>
                    <p class="para"><?php echo htmlspecialchars ($keyy ['description'],ENT_QUOTES,'UTF-8')?>
                    </p>
                </div>
            </div>

            <div class="ag-courses-item_date-box">
                <i class="fa-regular fa-clock"></i> Total Hours:
                <span class="ag-courses-item_date">
                <?php echo htmlspecialchars ($keyy ['total_hours'],ENT_QUOTES,'UTF-8')?> Hour
                </span>
            </div>

            <div class="ag-courses-item_date-box">
                <i class="fa-solid fa-money-bills"></i>
                Total Price:
                <span class="ag-courses-item_date">
                <?php echo htmlspecialchars (SUM1($keyy['sumrates'], $keyy['total_hours']))?> EGP
                </span>
            </div>
                <a href="project_details_freelancer.php?details=<?php echo htmlspecialchars ($keyy['pid'],ENT_QUOTES,'UTF-8')?>" class="ag-courses-item_anchor">project details</a>
            </a>
            
        </div>
        <?php } } }?>

    </div>
</div>
<style>
    button {
    --color: #2124b1;
    font-family: inherit;
    display: inline-block;
    width: 11em;
    height: 2.6em;
    line-height: 2.5em;
    margin: 20px;
    position: relative;
    cursor: pointer;
    overflow: hidden;
    border: 2px solid var(--color);
    transition: color 0.5s;
    z-index: 1;
    font-size: 15px;
    border-radius: 6px;
    font-weight: 500;
    color: var(--color);
    background-color: transparent;
}

button:before {
    content: "";
    position: absolute;
    z-index: -1;
    background: var(--color);
    height: 150px;
    width: 200px;
    border-radius: 50%;
}

button:hover a {
    color: #fff;
}
.navbar-toggler {
    /* padding: 9px; */
    font-size: 1.25rem;
    line-height: 1;
    background-color: transparent;
    border: 1px solid transparent;
    border-radius: 10px;
    transition: box-shadow 0.15s ease-in-out;
    width: 43px;
    text-align: center;
}
h4{
    color:white;
}

button:before {
    top: 100%;
    left: 100%;
    transition: all 0.7s;
}

button:hover:before {
    top: -30px;
    left: -30px;
}

button:active:before {
    background: #3a0ca3;
    transition: background 0s;
}
</style>
</body>

</html>
