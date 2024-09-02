<?php  
include "connection.php";
$isSuper =0;
if(isset($_SESSION['isSuper'])){
    $isSuper=$_SESSION['isSuper'];
}
if(isset($_SESSION['admin_id'])){
    $admin_id = $_SESSION['admin_id'];
}else{
    header("location:login_admin.php");
}
$select1="SELECT * FROM `admin` WHERE `admin`.`admin_id` = $admin_id";
$run_select1=mysqli_query($connect,$select1);
// AUTH uncomment when DONE
//if(!isset($_SESSION['admin_id']))
//    header("Location: login_admin.php");

$select = "SELECT 
            `payment`.`payment_id`,
            `user`.`user_name`, 
            `freelancer`.`freelancer_name`, 
            `payment`.`amount`, 
            `payment`.`commission`, 
            (`payment`.`amount` - `payment`.`commission`) AS free_net, 
            `payment`.`date` FROM `payment`
           JOIN `user` ON `payment`.`user_id` = `user`.`user_id`
           JOIN `freelancer` ON `payment`.`freelancer_id` = `freelancer`.`freelancer_id`
           ORDER BY `payment`.`date` ASC";

$runSelect = mysqli_query($connect, $select);

// if (isset($_GET['delete'])) {
//     $payment_id = $_GET['delete'];
//     $delete = "DELETE FROM `payment` WHERE `payment_id` = $payment_id";
//     $run_delete = mysqli_query($connect, $delete);
//     header("Location: details.php");
    
// }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
     <!-- fontaswomn link -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- bootstrab link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css
    ">
    <!-- css -->
    <link rel="stylesheet" href="css/details.css">
    <title>Transactions Table</title>
</head>

<body>
<!-- start side nav -->


<div class="sidebar">
    <div class="top">
        <div class="logo">
            <!-- <i class="bx bxl-codepen"></i> -->
             <img src="img/MiDlancer (2).png" alt="">
             <h1>MiD <span>LANCER</span></h1>
            <!-- <span>MidLancer</span> -->
        </div>
        <!-- <i class="bx bx-menu" id="btn"></i> -->
    </div>
    <div class="user">
        <!-- <img src="img/WhatsApp Image 2023-09-14 at 22.53.42.jpg" alt="error" class="user-img"> -->
        <div>
        <?php foreach($run_select1 as $data1){ ?>
            <a href="admin_profile.php"><p class="bold"><?php echo $data1['name']?></p></a>
            <!-- <p>Admin</p> -->
             <?php } ?>
        </div>
    </div>
    <ul>
        <!-- <li>
            <a href="login_admin.php">
            <i class='bx bx-log-in'></i>
                <span class="nav-item">Login</span>
            </a>
            <span class="tooltip">Login</span>
        </li> -->
        <li>
            <a href="admin_profile.php">
            <i class='bx bx-user' ></i>
                <span class="nav-item">Profile</span>
            </a>
            <span class="tooltip">Profile</span>
        </li>
        <?php if($isSuper == '1'){ ?>
        <li>
            <a href="display_admins.php">
             <i class='bx bx-desktop'></i>
                <span class="nav-item">Display Admin</span>
            </a>
            <span class="tooltip">Display Admin</span>
        </li>
        <?php }else{} ?>
        <li>
            <a href="display_freelancers.php">
             <i class='bx bx-desktop'></i>
                <span class="nav-item">Display Freelancers</span>
            </a>
            <span class="tooltip">Display Freelancers</span>
        </li>
        <li>
            <a href="display_users.php">
            <i class='bx bx-desktop'></i>
                <span class="nav-item">Display Users</span>
            </a>
            <span class="tooltip">Display Users</span>
        </li>
      
        <div class="dropdown">
         <li>
            <a href="">
            <i class='bx bxs-bar-chart-alt-2'></i>
                <span class="nav-item">chart</span>
            </a>
            <span class="tooltip">chart</span>
         </li>
            
          <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
           </button>
           <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="chart.php">Commissions chart</a></li>
              <li><a class="dropdown-item" href="chart_freelancer.php">Freelancers chart</a></li>
              <li><a class="dropdown-item" href="nationality_chart.php">Nationality chart</a></li>
              <li><a class="dropdown-item" href="nationality_commision.php">Commissions/nationality</a></li>
           </ul>
        </div>
        
    </ul>

</div>


<div class="main-content">

    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <!-- <a class="navbar-brand" href="#">Navbar</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button> -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <!-- <a class="nav-link active" aria-current="page" href="#">Home</a> -->
                         <img src="profile/defaultprofile.png" alt="admin profile" class="profilepic">
                    </li>
                   
                   
                  
                </ul>
                <!-- <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form> -->
            </div>
        </div>
    </nav>

    <div class="all">
    <div class="table_div">

<table class="table table-striped">
    <thead>
        <tr>
            <th><h3>User Name</h3></th>
            <th><h3>Freelancer Name</h3></th>
            <th><h3>Amount Paid</h3></th>
            <th><h3>Commission</h3></th>
            <th><h3>Freelancer's Net</h3></th>
            <th><h3>Date</h3></th>
            <!-- <th><h3>Action</h3></th> -->
        </tr>
    </thead>
    <tbody>
        <?php
        foreach($runSelect as $data) {
        ?> 
        <tr>
            <td><?php echo $data['user_name']; ?></td>
            <td><?php echo $data['freelancer_name']; ?></td>
            <td><?php echo $data['amount']; ?></td>
            <td><?php echo $data['commission']; ?></td>
            <td><?php echo $data['free_net']; ?></td>
            <td><?php echo $data['date']; ?></td>
            <!-- <td><a href="details.php?delete=<?php // echo $data['payment_id']; ?>">DELETE</a></td> -->
        </tr>
        <?php } ?>
    </tbody>
</table>
</div>

        
    </div>
    <script src="nav.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
</body>
</html>
