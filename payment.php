<?php
include "mail.php";
$msg = "";
$done = false;
$disc = false;
// perhaps decent AUTH in the near future

if(isset($_GET['pid'])) // extremely deep nesting
{
  $project_id = htmlspecialchars(strip_tags(mysqli_real_escape_string($connect, $_GET['pid'])));
  $user_id = $_SESSION['user_id'];
  if(isset($_GET['fi']))
  {
    $freelancer_id = htmlspecialchars(strip_tags(mysqli_real_escape_string($connect, $_GET['fi'])));
    $select = "SELECT * FROM `user` WHERE `user_id` = $user_id";
    $runselect = mysqli_query($connect, $select);
    $data = mysqli_fetch_assoc($runselect);

    if(isset($_POST['pay']))
    {
      $card_number = htmlspecialchars(strip_tags($_POST['card_number']));
      $request_id = htmlspecialchars(strip_tags(mysqli_real_escape_string($connect, $_GET['pay'])));
      $total_price = htmlspecialchars(strip_tags(mysqli_real_escape_string($connect, $_SESSION['total_price'])));

      if (strlen($card_number) != 16)
        $error_message = "Invalid Card Number";
      else if (empty($_POST['C-HOLDER']))
        $error_message = "Cardholder can't be left empty";
      else if (empty($_POST['MM']) || $_POST['MM'] > 12 || $_POST['MM'] < 1)
        $error_message = "You must select a valid month";
      else if (empty($_POST['YY']) || $_POST['YY'] > 2035 || $_POST['YY'] < 2024)
        $error_message = "You must select a valid year";
      else if (empty($_POST['cvv']) || strlen($_POST['cvv']) < 3 || strlen($_POST['cvv']) > 3)
        $error_message = "Insert a valid CVV";

      else if(isset($_POST['PC-INPUT']) && !empty($_POST['PC-INPUT']))
      {
        $pc = strtoupper(htmlspecialchars(strip_tags(mysqli_real_escape_string($connect, $_POST['PC-INPUT']))));
        $checkPromo = "SELECT * FROM `promo` WHERE (`user_id` = $user_id OR `user_id` IS NULL) AND `used` != '1' AND `promo_code` = '$pc'";
        $ExecPromo = mysqli_query($connect, $checkPromo);
        $resCount = mysqli_num_rows($ExecPromo);
        if($resCount != 0)
        {
          $row = mysqli_fetch_assoc($ExecPromo);
          if(($_POST['PC-INPUT'] == $row['promo_code']) && ($row['used'] != 1))
          {
            $promo_id = $row['promo_id'];
            $updatePromo = "UPDATE `promo` SET `used`='1' WHERE `promo_id` = $promo_id ";
            if (mysqli_query($connect, $updatePromo))
            {
              $total_price_ad = $total_price * 0.85;
              $msg = "You've received a 15% off <p style='text-decoration-line: line-through; display: inline'>$total_price</p>, Total paid: $total_price_ad ! <br>";
              $total_price = $total_price_ad; // to be used in L55
              $disc = true; $done = true;
            }
          }
        }
        else
            $error_message = "Invalid Promo Code";
      }
      if(empty($error_message))
      {
        $chkDUP = "SELECT * FROM `team_member` WHERE `freelancer_id` = $freelancer_id AND `project_id` = $project_id";
        $chkCount = mysqli_num_rows(mysqli_query($connect, $chkDUP));
        if($chkCount == 0)
        {
          $insert = "INSERT INTO `team_member` VALUES (NULL, 'in progress', $freelancer_id, $project_id)";
          $runinsert = mysqli_query($connect, $insert);

          if($disc)
            $commission = 0;
          else
            $commission=0.15 * $total_price;
          $date=date("Y-m-d");
          $insert2 = "INSERT INTO `payment` VALUES (NULL, $total_price, $commission, '$date','$user_id',  $freelancer_id, $project_id)";
          $runinsert2 = mysqli_query($connect, $insert2);

          if ($runinsert and $runinsert2)
          {
            $countT = "SELECT COUNT(*) as T_count FROM payment WHERE user_id = $user_id";
            $ExecCountT = mysqli_query($connect, $countT);
            $countRow = mysqli_fetch_assoc($ExecCountT);
            $T_count = $countRow['T_count'];
            if ($T_count == 5) // only once for 5th payment
            {
              $promo_code = substr(str_shuffle(str_repeat("23456789ABCDEFGHJKMNPQRSTUVWXY", 5)), 0, 5); // courtesy of Stackoverflow, with a twist, no confusions 0O1ILZ
              $user_email = $data['email'];
              $user_name = $data['user_name'];
              $insert_promo = "INSERT INTO `promo`(`user_id`, `promo_code`, `used`) VALUES ($user_id, '$promo_code', 0)";
              $ExecInsertPromo = mysqli_query($connect, $insert_promo);
              if ($ExecInsertPromo)
              {
                $email_content =
                  "
                    <body>
                    <p>Dear $user_name,</p>
                    <p>Congratulations! You have received a promo code: $promo_code</p>
                    <p>Thank you for your continued support.</p>
                    </body>
                  "; // NEED FRONT STYLING
                global $mail; // addiction, force of habit
                $mail->setFrom('MiDlancerTeam@gmail.com', 'MiDlancer');
                $mail->addAddress($user_email);
                $mail->isHTML(true);
                $mail->Subject = 'You Received a Promo Code!';
                $mail->Body = $email_content;
                $mail->send();
                $msg .= "Check your mail for a Promo Code! <br>";
              }
            }
            $select = "SELECT * FROM `team_member` WHERE `project_id` = '$project_id'";
            $runq = mysqli_query($connect, $select);
            if (mysqli_num_rows($runq) == 2)
            {
              $update = "UPDATE `project` SET `type_id` = 2 where `project_id` = '$project_id' ";
              $runupdate = mysqli_query($connect, $update);
            }
            $delete2 = "DELETE FROM `request` WHERE `request_id` = $request_id AND `freelancer_id` = $freelancer_id";
            mysqli_query($connect, $delete2); // ported from accepted-requests.php
            $msg .= "Transaction Complete!";
            $done = true;
            $delete1 = "DELETE FROM `applicants` WHERE `project_id` = $project_id AND `freelancer_id` = $freelancer_id";
            mysqli_query($connect, $delete1);
          }
        }
        else
            $msg .= "This request was already paid for!";
      }
    }
  }
}
if($done)
{
    $msg .= "<br> You're being redirected to your projects page";
    header("Refresh:6; url=my_projects_client.php");
}

if(isset($_GET['plan'])){
    $plan_id=$_GET['plan'];
    if(isset($_POST['pay'])){
        $id_freelancer=$_SESSION['freelancer_id'];
        $select="SELECT * FROM `plan` WHERE `plan_id` = $plan_id";
        $runq=mysqli_query($connect, $select);
        $fetch=  mysqli_fetch_assoc($runq);
        $price= $fetch['price'];
        $start_date=date("Y-m-d");
        $enddate = date('Y-m-d', strtotime('+30 days'));
        $insertt3= " UPDATE `subscription` SET `plan_id` = '$plan_id',
                                                `status` = 'active',
                                                `start_date` = '$start_date',
                                                `end_date` = '$enddate'
                                            WHERE `freelancer_id` = '$id_freelancer' ";
        $runinsertt3=mysqli_query($connect, $insertt3);
        if($runinsertt3){
            header("location:home.php");
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>

    <!-- css file link  -->
    <link rel="stylesheet" href="css/payment.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>

<body>
<!-- start of visa card -->
    <div class="container">
        <div class="card-container">
           <div class="pic">
            <div class="front">
                <div class="image">
                    <img src="img/chip-card2 (1).png" alt="">
                    <img src="img/visa.png" alt="">
                </div>
                <div class="card-number-box" name="card_number"><?php echo isset($_POST['card_number']) ? htmlspecialchars(strip_tags($_POST['card_number'])) : '################'?></div>
                <div class="flexbox">
                    <div class="box">
                        <span>Card Holder</span>
                        <div class="card-holder-name"><?php echo isset($_POST['C-HOLDER']) ? htmlspecialchars(strip_tags($_POST['C-HOLDER'])) : 'Full Name'?></div>
                    </div>

                    <div class="box">
                        <span>expires</span>
                        <div class="expiration">
                            <span class="exp-month"><?php echo isset($_POST['MM']) ? $_POST['MM'] : 'mm'?></span>
                            <span class="exp-year"><?php echo isset($_POST['YY']) ? $_POST['YY'] : 'yy'?></span>
                        </div>
                    </div>
                </div>
            </div>
            </div>

            <div class="back">
                <div class="stripe"></div>
                <div class="box">
                    <span>cvv</span>
                    <div class="cvv-box"><?php echo isset($_POST['cvv']) ? htmlspecialchars(strip_tags($_POST['cvv'])) : ''?></div>
                    <img src="image/visa.png" alt="">
                </div>
            </div>
        </div>
        
        <!-- <end part of visa card> -->
            
 
 <!-- start work space of inputs -->

 <form action="" method="post">
 <a href="home.php" class="close" id="closeic"><i class="fa-solid fa-x " id="iconx"></i></a>

    <div class="inputBox">
        <?php if (!empty($error_message)) { echo $error_message; } elseif (!empty($msg)) echo $msg ?>
        <span>Card Number</span>
        <input type="text" maxlength="16" name="card_number" class="card-number-input" value="<?php echo isset($_POST['card_number']) ? htmlspecialchars(strip_tags($_POST['card_number'])) : ''; ?>" required>
        </div>
    <div class="inputBox">
        <span>Card Holder</span>
        <input type="text" class="card-holder-input" name="C-HOLDER" value="<?php echo isset($_POST['C-HOLDER']) ? htmlspecialchars(strip_tags($_POST['C-HOLDER'])) : ''; ?>">
    </div>
    <div class="flexbox">
        <div class="inputBox">
            <span>Expiration MM</span>
            <select name="MM" class="month-input">
                <option value="month" selected disabled>Month</option>
                <?php
                for ($i = 1; $i <= 12; $i++) {
                    $selected = (isset($_POST['MM']) && $_POST['MM'] == $i) ? 'selected' : '';
                    if($i < 10)
                        echo "<option value='$i' $selected>0$i</option>";
                    else
                        echo "<option value='$i' $selected>$i</option>";
                }
                ?>
            </select>
        </div>
        <div class="inputBox">
            <span>Expiration YY</span>
            <select name="YY" class="year-input">
                <option value="year" selected disabled>Year</option>
                <?php
                for ($i = 2024; $i <= 2035; $i++) {
                    $selected = (isset($_POST['YY']) && $_POST['YY'] == $i) ? 'selected' : '';
                    echo "<option value='$i' $selected>$i</option>";
                }
                ?>
            </select>
        </div>
        <div class="inputBox">
            <span>CVV</span>
            <input type="text"  class="cvv-input" name="cvv" value="<?php echo isset($_POST['cvv']) ? htmlspecialchars(strip_tags($_POST['cvv'])) : ''; ?>">
        </div>
    </div>
    
    <a class="promocode" id='showPromo'> Promo Code +</a>
    <div class="inputBox d-none" id="promoCode">
        <input type="text" class="card-holder-input" name="PC-INPUT" minlength="5" maxlength="5">
    </div>

    <div class="btns">
        <button type="submit" class="cssbuttons-io-button addto" name="pay">
        Pay
        <div class="icon">
            <svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 0h24v24H0z" fill="none"></path>
                <path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z"
                fill="currentColor"></path>
            </svg>
        </div>
        </button>
    </div>
</form>

    </div>
    
<!-- <WORK space for js> -->


                        <script>

                            document.querySelector('.card-number-input').oninput = () => {
                                document.querySelector('.card-number-box').innerText = document.querySelector('.card-number-input').value;
                            }

                            document.querySelector('.card-holder-input').oninput = () => {
                                document.querySelector('.card-holder-name').innerText = document.querySelector('.card-holder-input').value;
                            }

                            document.querySelector('.month-input').oninput = () => {
                                document.querySelector('.exp-month').innerText = document.querySelector('.month-input').value;
                            }

                            document.querySelector('.year-input').oninput = () => {
                                document.querySelector('.exp-year').innerText = document.querySelector('.year-input').value;
                            }

                            document.querySelector('.cvv-input').onmouseenter = () => {
                                document.querySelector('.front').style.transform = 'perspective(1000px) rotateY(-180deg)';
                                document.querySelector('.back').style.transform = 'perspective(1000px) rotateY(0deg)';
                            }

                            document.querySelector('.cvv-input').onmouseleave = () => {
                                document.querySelector('.front').style.transform = 'perspective(1000px) rotateY(0deg)';
                                document.querySelector('.back').style.transform = 'perspective(1000px) rotateY(180deg)';
                            }

                            document.querySelector('.cvv-input').oninput = () => {
                                document.querySelector('.cvv-box').innerText = document.querySelector('.cvv-input').value;
                            }

                        </script>
                        <script src="./js/payment.js"></script>
                        <script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');

    const errorMessages = {
        card_number: "Card number is required and must be 16 digits",
        C_HOLDER: "Cardholder name is required",
        MM: "Month is required and must be between 1 and 12",
        YY: "Year is required and must be between 2024 and 2035",
        cvv: "CVV is required and must be 3 digits"
    };

    const fields = {
        card_number: 'Card Number',
        C_HOLDER: 'Cardholder Name',
        MM: 'Month',
        YY: 'Year',
        cvv: 'CVV'
    };

    const errorElements = {};

    Object.keys(fields).forEach(field => {
        const inputElement = document.querySelector(`[name="${field.replace('_', '-')}"]`);
        if (inputElement) {
            const errorElement = createErrorElement();
            inputElement.parentNode.appendChild(errorElement);
            errorElements[field] = errorElement;

            // Add event listeners for real-time validation
            inputElement.addEventListener('input', () => validateField(field));
            inputElement.addEventListener('blur', () => validateField(field));
        }
    });

    function createErrorElement() {
        const errorElement = document.createElement('div');
        errorElement.className = 'error-message';
        return errorElement;
    }

    function validateField(field) {
        const inputElement = document.querySelector(`[name="${field.replace('_', '-')}"]`);
        const value = inputElement ? inputElement.value.trim() : '';
        let errorMessage = '';

        switch (field) {
            case 'card_number':
                errorMessage = validateCardNumber(value);
                break;
            case 'C_HOLDER':
                errorMessage = value ? '' : errorMessages.C_HOLDER;
                break;
            case 'MM':
                errorMessage = validateMonth(value);
                break;
            case 'YY':
                errorMessage = validateYear(value);
                break;
            case 'cvv':
                errorMessage = validateCVV(value);
                break;
        }

        errorElements[field].textContent = errorMessage;
        return !errorMessage;
    }

    function validateCardNumber(value) {
        if (!value) return errorMessages.card_number;
        if (value.length !== 16) return "Card number must be 16 digits";
        return '';
    }

    function validateMonth(value) {
        const month = parseInt(value, 10);
        if (!value) return errorMessages.MM;
        if (isNaN(month) || month < 1 || month > 12) return "Month must be between 1 and 12";
        return '';
    }

    function validateYear(value) {
        const year = parseInt(value, 10);
        if (!value) return errorMessages.YY;
        if (isNaN(year) || year < 2024 || year > 2035) return "Year must be between 2024 and 2035";
        return '';
    }

    function validateCVV(value) {
        if (!value) return errorMessages.cvv;
        if (value.length !== 3) return "CVV must be 3 digits";
        return '';
    }

    form.addEventListener('submit', function(event) {
        let isValid = true;
        Object.keys(fields).forEach(field => {
            if (!validateField(field)) {
                isValid = false;
            }
        });

        if (!isValid) {
            event.preventDefault();
        }
    });

    function updateCardInfo(selector, value, defaultText) {
        document.querySelector(selector).textContent = value || defaultText;
    }

    document.querySelector('.card-number-input').addEventListener('input', function() {
        updateCardInfo('.card-number-box', this.value, '################');
    });

    document.querySelector('.card-holder-input').addEventListener('input', function() {
        updateCardInfo('.card-holder-name', this.value, 'Full Name');
    });

    document.querySelector('.month-input').addEventListener('change', function() {
        updateCardInfo('.exp-month', this.value, 'mm');
    });

    document.querySelector('.year-input').addEventListener('change', function() {
        updateCardInfo('.exp-year', this.value, 'yy');
    });

    const cvvInput = document.querySelector('.cvv-input');
    const front = document.querySelector('.front');
    const back = document.querySelector('.back');

    cvvInput.addEventListener('mouseenter', () => {
        front.style.transform = 'perspective(1000px) rotateY(-180deg)';
        back.style.transform = 'perspective(1000px) rotateY(0deg)';
    });

    cvvInput.addEventListener('mouseleave', () => {
        front.style.transform = 'perspective(1000px) rotateY(0deg)';
        back.style.transform = 'perspective(1000px) rotateY(180deg)';
    });

    cvvInput.addEventListener('input', function() {
        updateCardInfo('.cvv-box', this.value, '');
    });
});
</script>


</body>

</html>
