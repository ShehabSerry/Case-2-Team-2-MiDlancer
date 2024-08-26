<?php  
include "connection.php";

$select = "SELECT 
            `payment`.`payment_id`,
            `user`.`user_name`, 
            `freelancer`.`freelancer_name`, 
            `payment`.`amount`, 
            `payment`.`commission`, 
            (`payment`.`amount` * `payment`.`commission`) AS total_amount, 
            `payment`.`date` FROM `payment`
           JOIN `user` ON `payment`.`user_id` = `user`.`user_id`
           JOIN `freelancer` ON `payment`.`freelancer_id` = `freelancer`.`freelancer_id`
           ORDER BY `payment`.`date` ASC";

$runSelect = mysqli_query($connect, $select);

if (isset($_GET['delete'])) {
    $payment_id = $_GET['delete'];
    $delete = "DELETE FROM `payment` WHERE `payment_id` = $payment_id";
    $run_delete = mysqli_query($connect, $delete);
    header("Location: details.php");
    
}
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
    <!-- css -->
    <link rel="stylesheet" href="">
    <title>Transactions Table</title>
</head>

<body>

    <div class="table_div">

        <table class="table table-striped">
            <thead>
                <tr>
                    <th><h3>User Name</h3></th>
                    <th><h3>Freelancer Name</h3></th>
                    <th><h3>Amount</h3></th>
                    <th><h3>Commission</h3></th>
                    <th><h3>Total Amount</h3></th>
                    <th><h3>Date</h3></th>
                    <th><h3>Action</h3></th>
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
                    <td><?php echo $data['total_amount']; ?></td>
                    <td><?php echo $data['date']; ?></td>
                    <td><a href="details.php?delete=<?php echo $data['payment_id']; ?>">DELETE</a></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</body>
</html>
