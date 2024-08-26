<?php
include("connection.php");

// Fetch admin data
$select = "SELECT * FROM `admin`";
$run_select = mysqli_query($connect, $select);




if (isset($_GET['delete'])) {
    $admin_id =$_GET['delete']; 

    // Prepare the DELETE query
    $delete = "DELETE FROM `admin` WHERE `admin_id` = $admin_id";
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
</head>
<body>

<table id="example" class="table table-striped" style="width:90%; margin:auto;">
    <thead>
        <tr class="head">
            <th>Admin Name</th>
            <th>Admin Email</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
    <a href="add_admin.php">
                        <button type="button" class="btn btn-danger">add admin</button>
                    </a>
        <?php foreach($run_select as $row){ ?>
            <tr>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td>
                    <!-- Link to delete admin -->
                    <a href="display_admins.php?delete=<?php echo $row['admin_id']; ?>;">
                        <button type="button" class="btn btn-danger">Delete</button>
                    </a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
