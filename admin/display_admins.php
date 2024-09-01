<?php
include("connection.php");
$isSuper =0;
if(isset($_SESSION['isSuper'])){
    $isSuper=$_SESSION['isSuper'];
}
if(isset($_SESSION['admin_id'])){
    $admin_id = $_SESSION['admin_id'];
}else{
    header("location:login_admin.php");
}


// Fetch admin data
$select = "SELECT * FROM admin";
$run_select = mysqli_query($connect, $select);
$super=$_SESSION['isSuper'];

$admin_id=$_SESSION['admin_id'];
$select1="SELECT * FROM `admin` WHERE `admin`.`admin_id` = $admin_id";
$run_select1=mysqli_query($connect,$select1);


if (isset($_GET['delete'])) {
    $admin_id =$_GET['delete']; 

    // Prepare the DELETE query
    $delete = "DELETE FROM admin WHERE admin_id = $admin_id";
    if (mysqli_query($connect, $delete)) {
        echo "Admin has been removed.";

        header("Location: display_admins.php");

    } else {
        echo "Error: " . mysqli_error($connect);
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin List</title>
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

    <link rel="stylesheet" href="css/displayadmins.css" />
    <style>
        /* Popup styling */
        .popup {
            display: none; /* Hide popups by default */
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            background: white;
            border: 1px solid #ccc;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
            z-index: 1000;
            transform: translate(-50%,-50%);
            text-align: center;
            border-radius: 7px;
             color:#58151c;
        }
        .popup.show {
            display: block; /* Show popup when class 'show' is added */
        }
        .overlay {
            display: none; /* Hide overlay by default */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 999;
        }
        .overlay.show {
            display: block; /* Show overlay when class 'show' is added */
        }
        .lol{
    color:#58151c;

}

    </style>
</head>
<body>
   
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
            <a href="admin_profile.php"><p class="bold"><?php echo $data1 ['name'];?></p></a>
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
        <?php }else {}?>
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
  
<table id="example" class="table table-striped" style="width:90%; margin:auto;">
    <thead>
        <tr class="head">
            <th>Admin Name</th>
            <th>Admin Email</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        <?php if($super == 1){ ?>
        
      
        <?php foreach($run_select as $row){  ?>
        
        <tr>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td>
                <?php if(($super == 1) AND $row['isSuper']!=1){ ?>
                <button type="button" class="btn btn-outline-danger" onclick="openPopup(<?php echo $row['admin_id']; ?>)">
                    <i class="fa-solid fa-trash"></i> 
                </button>
                <form method="get" id="deleteForm-<?php echo $row['admin_id']; ?>" style="display:none;">
                    <input type="hidden" name="delete" value="<?php echo $row['admin_id']; ?>">
                </form>
                <div class="popup alert alert-danger"  id="popup-<?php echo $row['admin_id']; ?>">
                    <h2><i class="fa-solid fa-triangle-exclamation"></i> Are you sure you want to delete this admin?</h2>
                    <button type="button" class="lol btn btn-outline-dark" onclick="confirmDelete()">Yes</button>
                    <button type="button" class="lol btn btn-outline-dark" onclick="closePopup()">No</button>
                </div>
                <div class="overlay" id="overlay-<?php echo $row['admin_id']; ?>"></div>
                <?php } }?>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>
<div class="btns">
<!-- <button class="logbtn" id="lgbtn">logout</button> -->

    <a href="add_admin.php">
            <button type="button" class="btn btn-danger" id="addbtn">Add Admin</button>
        </a>
        </div>
        
    </div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="nav.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> -->
<script>
    let deleteAdminId;

    function openPopup(adminId) {
        deleteAdminId = adminId;
        document.getElementById('popup-' + adminId).classList.add('show');
        document.getElementById('overlay-' + adminId).classList.add('show');
    }

    function closePopup() {
        if (deleteAdminId) {
            document.getElementById('popup-' + deleteAdminId).classList.remove('show');
            document.getElementById('overlay-' + deleteAdminId).classList.remove('show');
        }
    }

    function confirmDelete() {
        if (deleteAdminId) {
            document.getElementById('deleteForm-' + deleteAdminId).submit();
        }
    }
</script>



</body>
</html>
