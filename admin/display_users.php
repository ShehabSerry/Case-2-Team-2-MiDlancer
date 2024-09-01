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
$select = "SELECT * FROM `user`
JOIN `nationality` ON `user`.`nationality_id`=`nationality`.`nationality_id`";
$run_select = mysqli_query($connect, $select);

$search_results = [];
if (isset($_POST['search_btn'])) {
    $text = mysqli_real_escape_string($connect, $_POST['text']);
    $sql = "SELECT * FROM `user`
    JOIN `nationality` ON `user`.`nationality_id` = `nationality`.`nationality_id`
    WHERE (`user_name` LIKE '%$text%' OR SOUNDEX(`user`.`user_name`) = SOUNDEX('$text')) OR (`email` LIKE '%$text%') OR (`nationality` LIKE '%$text%')";
    $run_select_search = mysqli_query($connect, $sql);
    if (mysqli_num_rows($run_select_search) > 0) {
        $search_results = mysqli_fetch_all($run_select_search, MYSQLI_ASSOC);
    }
}

$admin_id=$_SESSION['admin_id'];
$select1="SELECT * FROM `admin` WHERE `admin`.`admin_id` = $admin_id";
$run_select1=mysqli_query($connect,$select1);

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
               
                <form class="d-flex" role="search" method="POST" action="display_users.php">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="text" id="searchText">
                    <button class="btn btn-outline-success" type="submit" name="search_btn">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <?php if (isset($_POST['search_btn']) && !empty($search_results)) { ?>
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
       
        
      
    <?php foreach ($search_results as $roww) { ?>
        
        <tr>
        <td><img src="../img/profile/<?php echo $roww['user_image']?>" alt="Profile Pic"></td>
            <td><?php echo htmlspecialchars($roww['user_name']); ?></td>
            <td><?php echo htmlspecialchars($roww['email']); ?></td>
            <td><?php echo htmlspecialchars($roww['nationality']); ?></td>

           
        </tr>
        <?php } ?>
    </tbody>
</table>
</div> 
<?php } else if (isset($_POST['search_btn']) && empty($search_results) && isset($text)) { ?>

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
    <tr>
                        <td colspan="6"><p style="text-align: center">Nothing matches your search keyword</p></td>
                    </tr>
            </tbody>
        </table>
    <?php } else { ?>



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
       
        
      
        <?php while ($row = mysqli_fetch_assoc($run_select)) {   ?>
        
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
<?php } ?>
    
    <script src="nav.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
    $(document).ready(function(){
        $("#searchText").on("input", function(){
            var searchText = $(this).val();
            if(searchText === "") {
                location.reload();
                return;
            }
            $.post('', { text: searchText, search_btn: 'Go' }, function(data){
                var rows = $(data).find('table tbody tr');
                $('#example tbody').html(rows);
            });
        });
    });
</script>
</div>
</body>
</html>
