<?php
include("connection.php");

// Fetch admin data
$select = "SELECT * FROM `user`
JOIN `nationality` ON `user`.`nationality_id`=`nationality`.`nationality_id`";
$run_select = mysqli_query($connect, $select);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clients List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css"
    integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
       <!-- fontaswomn link -->
       <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- bootstrab link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css
    ">

    <link rel="stylesheet" href="css/displayfreelancers.css">
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
            <p class="bold">Malak E.</p>
            <!-- <p>Admin</p> -->
        </div>
    </div>
    <ul>
        <li>
            <a href="">
            <i class='bx bx-log-in'></i>
                <span class="nav-item">Login</span>
            </a>
            <span class="tooltip">Login</span>
        </li>
        <li>
            <a href="">
            <i class='bx bx-user' ></i>
                <span class="nav-item">Profile</span>
            </a>
            <span class="tooltip">Profile</span>
        </li>
        <li>
            <a href="">
             <i class='bx bx-desktop'></i>
                <span class="nav-item">Display Admin</span>
            </a>
            <span class="tooltip">Display Admin</span>
        </li>
        <li>
            <a href="">
             <i class='bx bx-desktop'></i>
                <span class="nav-item">Display Freelancers</span>
            </a>
            <span class="tooltip">Display Freelancers</span>
        </li>
        <li>
            <a href="">
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
              <li><a class="dropdown-item" href="#">Commissions chart</a></li>
              <li><a class="dropdown-item" href="#">Freelancers chart</a></li>
              <li><a class="dropdown-item" href="#">Nationality chart</a></li>
              <li><a class="dropdown-item" href="#">Commissions/nationality</a></li>
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
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                   
                   
                  
                </ul>
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>


    <div class="all">

    
<table id="example" class="table table-striped" style="width:90%; margin:auto;">
    <thead>
        <tr class="head">
            <th>photo</th>
            <th>Client Name</th>
            <th>Client Email</th>
            <th>Nationality</th>
        </tr>
    </thead>
    <tbody>
       
        
      
        <?php foreach($run_select as $row){  ?>
        
        <tr>
        <td><img src="../img/profile/<?php echo $row['user_image']?>" alt="Profile Pic"></td>
            <td><?php echo htmlspecialchars($row['user_name']); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td><?php echo htmlspecialchars($row['nationality']); ?></td>

           
        </tr>
        <?php } ?>
    </tbody>
</table>
</div>
    
    <script src="nav.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
