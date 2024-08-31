<?php
include "connection.php"; 

$admin_id = $_SESSION['admin_id'];

// Correct the SQL query to group by nationality

$select = "SELECT `nationality`.`nationality`, COUNT(`user`.`user_id`) as client_count
            FROM `user`
            JOIN `nationality` ON `user`.`nationality_id` = `nationality`.`nationality_id`
            GROUP BY `nationality`.`nationality`";


$run = mysqli_query($connect, $select);

if (!$run) {
    // Handle query error
    die("Query failed: " . mysqli_error($connect));
}

$data = [];

while ($row = mysqli_fetch_assoc($run)) {
    $data[] = $row;
}

$json = json_encode($data);

// Optionally, you can return or echo the JSON
// echo $json;

// Free result set and close the connection
mysqli_free_result($run);
// mysqli_close($connect);



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nationality Distribution Chart</title>
     <!-- fontaswomn link -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- bootstrab link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css
    ">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        #chartContainer {
            width: 80%;  /* Adjust the width as needed */
            max-width: 800px;  /* Maximum width */
            padding: 20px;
            /* box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);  Subtle shadow */
            background-color: #fff;  /* White background for the chart container */
            border-radius: 8px;  /* Rounded corners */
            box-shadow: rgba(0, 0, 0, 0.25) 0px 25px 30px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 9px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px;
            margin-top: 7%;      
        }
        canvas {
            width: 100% !important;  /* Ensure the canvas takes full width of container */
            height: auto !important;  /* Maintain aspect ratio */
        }
        .all a{
            /* background-color:#ffc107; */
            border:solid 2px #ffc107;
            padding:12px 30px;
            border-radius:8px;
            margin-top:5%;
            text-decoration:none;
            color:#ffc107;
            transition:all 0.5s;
        }
        .all a:hover{
            color:white;
            background-color:#ffc107;
        }

        :root {
    --primary-color: #080a74;
    --secondary-color: #f6d673;
    --Thirdly-color: #d6d9e0;
    --fourthly-color: #1d1d27;
}







* {
    padding: 0;
    margin: 0;
    box-sizing: border-box;
    list-style: none;
    text-decoration: none !important;
}

.user-img {
    width: 72px;
    border-radius: 100%;
    border: 1px solid #eee;
    height: 72px;
    /* margin-left: 5px; */
}

.sidebar {
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    width: 190px;
    /* width: 250px; */
    background-color: var(--primary-color);
    padding: .4rem .8rem;
    transition: all 0.5s ease;


}








.sidebar #btn {
    position: absolute;
    color: white;
    top: .4rem;
    left: 90%;
    font-size: 1.2red;
    line-height: 50px;
    transform: translateX(-50%);
    cursor: pointer;
}



.sidebar .top .logo {
    color: white;
    display: flex;
    height: 50px;
    width: 100%;
    align-items: center;
    pointer-events: none;
    opacity: 1;
}


.top .logo i {
    font-size: 2rem;
    margin-right: 5px;
}

.user {
    display: flex;
    align-items: center;
    margin: 1rem 0;
}

.user p {
    color: #fff;
    opacity: 1;
    margin-left: 1rem;

}
.top .logo .h1, h1 {
    font-size: 23px;
    margin-left: -12%;
    margin-top: 13%;
}

.top .logo h1 span {
    font-size: 13px;
    margin-left: -6%;
}

.bold {
    font-weight: 600;
    color: var(--secondary-color) !important;
}

.sidebar p {
    opacity: 1;
}
.sidebar .logo img {
    width: 70%;
    height: 181%;
    border-radius: 100%;
    margin-left: -17%;
    margin-top: 5%;
}
.sidebar ul {
    margin-left: -31%;
    margin-top: -10%;
}

.sidebar ul li {
    position: relative;
    list-style-type: none;
    height: 50px;
    width: 90%;
    margin: 0.8rem auto;
    line-height: 50px;

}


.sidebar ul li a {
    color: white;
    display: flex;
    align-items: center;
    text-decoration: none;
    border-radius: 0.8rem;

}


.sidebar ul li a:hover {
    background-color: white;
    color: #12171e;


}

.sidebar ul li a i {
    min-width: 50px;
    text-align: center;
    height: 50px;
    border-radius: 12px;
    line-height: 50px;
}


.sidebar .nav-item {
    opacity: 1;
    font-size: 13px !important;

}
.dropdown-menu.show {
    position: absolute;
    inset: 0px auto auto 0px;
    margin: 0px;
    transform: translate3d(17.8px, 177.4px, 0px) !important;
    background-color: rgba(0, 0, 0, 0.429);
    border: none;

}
/* [type=button]:not(:disabled), [type=reset]:not(:disabled), [type=submit]:not(:disabled), button:not(:disabled) {
    cursor: pointer;
    position: absolute;
    top: 10px;
    right: 50px;
} */

.dropdown-toggle::after {
    display: inline-block;
    margin-left: .255em;
    vertical-align: .255em;
    content: "";
    border-top: .3em solid;
    border-right: .3em solid transparent;
    border-bottom: 0;
    border-left: .3em solid transparent;
    position: absolute;
    top: 23px;
    right: 60px;
    font-size: 28px;
}
.dropdown-toggle:hover{
    color: black;
}
.btn-secondary {
    --bs-btn-color: #fff;
    --bs-btn-bg: none;
    --bs-btn-border-color: none;
    --bs-btn-hover-color: #fff;
    --bs-btn-hover-bg:none;
    --bs-btn-hover-border-color: none;
    --bs-btn-focus-shadow-rgb: 130, 138, 145;
    --bs-btn-active-color: #fff;
    --bs-btn-active-bg:none;
    --bs-btn-active-border-color: none;
    --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
    --bs-btn-disabled-color: #fff;
    --bs-btn-disabled-bg: #6c757d;
    --bs-btn-disabled-border-color: #6c757d;
    margin-left: 9%;
    /* display: flex; */
    flex-direction: row;
    /* gap: 4%; */
    
}
.dropdown ul li a {
    color:var(--secondary-color);
    margin-top: -16px;
    font-size: 12px;
}




.navbar-expand-lg .navbar-nav .nav-link {
    color: white;
    padding-right: var(--bs-navbar-nav-link-padding-x);
    padding-left: var(--bs-navbar-nav-link-padding-x);
}
.btn-outline-success {
    --bs-btn-color: var(--secondary-color);
    --bs-btn-border-color: var(--secondary-color);
    --bs-btn-hover-color: #fff;
    --bs-btn-hover-bg: var(--secondary-color);
    --bs-btn-hover-border-color: var(--secondary-color);
    --bs-btn-focus-shadow-rgb: 25, 135, 84;
    --bs-btn-active-color: #fff;
    --bs-btn-active-bg: var(--secondary-color);
    --bs-btn-active-border-color: var(--secondary-color);
    --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
    --bs-btn-disabled-color: var(--secondary-color);
    --bs-btn-disabled-bg: transparent;
    --bs-btn-disabled-border-color: var(--secondary-color);
    --bs-gradient: none;
    border: solid 2px;
}



.main-content {
    position: relative;
    /* background-color: red; */
    min-height: 100vh;
    top: 0;
    left: 190px;
    transition: all 0.5 ease;
    width: calc(100% - 190px);
    padding: 1rem;
}

.container-fluid {
    margin: 0;
}


nav.navbar.navbar-expand-lg.bg-body-tertiary {
    background-color: var(--primary-color)!important;
    margin: -16px !important;

}

.all {
    /* margin-top: 5%; */
   
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction:column-reverse;
    /* height: 100vh; */
    margin: 0;
   
    font-family: Arial, sans-serif;  /* Clean font */
}




@media(max-width:750px) {
    .sidebar {
        width: 90px;
        height: 120vh;
        z-index: 1000;

    }

    .sidebar~.main-content {
        left: 90px;
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .sidebar .nav-item {
        display: none;
    }

    .sidebar p {
        opacity: 0;
        display: none;
    }

    .sidebar .top .logo {
        opacity: 1;
        flex-direction: column;
    }

    .sidebar #btn {
        left: 50%;

    }

    .sidebar ul {
        margin-left: -47%;
    }

    .sidebar ul li .tooltip {
        position: absolute;
        left: 125px;
        top: 50%;
        transform: translate(-50%, -50%);
        box-shadow: 0 0.5rem 0.8rem rgba(0, 0, 0, 0.2);
        border-radius: .6rem;
        padding: .4rem 1.2rem;
        line-height: 1.8rem;
        z-index: 20;
        opacity: 0;

    }

    .sidebar ul li:hover .tooltip {
        opacity: 1;

    }

    nav.navbar.navbar-expand-lg.bg-body-tertiary {
        display: none;
    }

    th h3 {
        font-size: 13px;
        color: var(--primary-color);
        text-align: center;
    }

  
    .table-striped>tbody>tr:nth-of-type(odd)>* {
        --bs-table-color-type: var(--bs-table-striped-color);
        --bs-table-bg-type: var(--bs-table-striped-bg);
        font-size: 13px;
    }

    .user-img {
        width: 50px;
        border-radius: 100%;
        border: 1px solid #eee;
        height: 50px;
        margin-left: 5px;
    }
    
    .sidebar .logo span{
        display: none;
    }
    .sidebar .logo img {
        width: 137%;
        height: 186%;
        border-radius: 100%;
        margin-top: -16%;
    }
    .dropdown-toggle::after {
        position: absolute;
        top: 25px;
        right: 8px;
    }
    .top .logo h1{
        display: none;
    }

    .dropdown-menu.show {
        position: absolute;
        inset: 0px auto auto 0px;
        margin: 0px;
        transform: translate3d(-9.2px, 43.4px, 0px) !important;
        background-color: rgba(0, 0, 0, 0.94) !important;
        border: none;
    }

}
    </style>
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
                <!-- <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form> -->
            </div>
        </div>
    </nav>


    <div class="all">
    <a href="display_users.php">View Details</a>
    <div id="chartContainer">
        <canvas id="nationalityChart"></canvas>
    </div>
        
    </div>
   
    <script>
        // JSON data directly embedded from PHP
        const data = <?php echo $json; ?>;

        // Extract labels (nationalities) and counts
        const labels = data.map(item => item.nationality);
        const counts = data.map(item => parseInt(item.client_count, 10)); // Convert to integer

        // Initialize the chart
        const ctx = document.getElementById('nationalityChart').getContext('2d');
        const nationalityChart = new Chart(ctx, {
            type: 'doughnut',  // Pie chart type
            data: {
                labels: labels,
                datasets: [{
                    label: 'User Distribution by Nationality',
                    data: counts,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                }
            }
        });
    </script>
     <script src="nav.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
