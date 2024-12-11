<?php
include("config.php");
require('function.php');

$id = $_GET['id']; // Get the history ID passed via the URL

// Fetch the history details from canvas_history
$query = "SELECT * FROM canvas_history WHERE id = '$id'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

if (!$row) {
    echo "No history found.";
    exit;
}

// Fetch the related items from canvas_history_items
$item_query = "SELECT * FROM canvas_history_items WHERE history_id = '$id'";
$item_result = mysqli_query($conn, $item_query);

// Check if there are items
if (mysqli_num_rows($item_result) == 0) {
    $items = [];
} else {
    $items = mysqli_fetch_all($item_result, MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>CvSU Canvassing</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/cvsu.png" rel="icon">

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.0/css/all.min.css" integrity="sha512-9xKTRVabjVeZmc+GUW8GgSmcREDunMM+Dt/GrzchfN8tkwHizc5RP4Ok/MXFFy5rIjJjzhndFScTceq5e6GvVQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">

 <!-- Template Main CSS File -->
 <link href="assets/css/style.css" rel="stylesheet">

<main id="main" class="main">
    <!-- Sidebar and other includes -->
    <?php include 'header.php'; ?> 
    <?php include 'adminnav.php'; ?>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="header-logo-container">
                            <img src="https://myportal.cvsu.edu.ph/assets/img/resized/cvsu-logo.png" class="header-logo">
                        </div>
                        <div style="position: absolute; top: 20px; right: 35px; font-size: 16px; font-weight: ">
                            ADMIN-QT-10
                        </div>


                        <header id="printheader">
                            <p><center>Republic of the Philippines</center></p>
                            <h3>CAVITE STATE UNIVERSITY <br> Don Severino de las Alas Campus <br></h3>
                            <p><center>Indang, Cavite, Philippines <br>(046) 889-6373 <br>www.cvsu.edu.ph</center></p>
                        </header> 

                        <div class="center-container">
                            <div class="container">
                                <h4><center>REQUEST FOR QUOTATION</center></h4>   

                                <form>
                                    <!-- Upper right section -->
                                    <div class="form-group" style="overflow: hidden;">
                                        <div class="right-section" style="float: right; text-align: right;">
                                            <label for="input_three">Date:</label>
                                            <?php echo $row['date']; ?>
                                            <br>
                                            <label for="input_one">Ref No. :</label>
                                            <?php echo $row['ref_no']; ?>
                                        </div>

                                        <!-- Left section -->
                                        <div class="left-section">
                                            <label for="input_two">Company:</label>
                                            <?php echo $row['company']; ?>
                                            <br>
                                            <label for="input_four">Address:</label>
                                            <?php echo $row['address']; ?>
                                            <br>
                                            <label for="input_five">TIN:</label>
                                            <?php echo $row['tin']; ?>
                                        </div>
                                    </div>
                                    <br>

                                    <p>Sir/Madam:</p>
                                        <p style="font-size: 16px; text-indent: 40px; text-align: justify; ">Please quote your lowest price on the item/s listed below, subject to the Terms and Conditions on the last page, stating the shortest time of delivery. Submit your quotation duly signed by your authorized representative not later than <?php echo $row['submission_deadline']; ?>
                                            
                                            <br>
                                            <p style="font-size: 16px; margin-left: 500px; margin-bottom: 1px;text-align: justify;">__________________________<br></p>
                                            <p style="font-size: 16px; margin-left: 600px; text-align: justify;">Supply Officer<br></p>
                                            <header>
                                            <p style="font-size: 16px; text-align: justify;">NOTE:<br></p>
                                            <p style="font-size: 16px; margin-left: 20px; text-align: justify;">1. All entries must be written legibly or typewritten.<br></p>
                                            <p style="font-size: 16px; margin-left: 20px; text-align: justify;">2. Delivery Period: <?php echo $row['delivery_period']; ?>calendar days from the receipt of P.O.<br></p>
                                            <p style="font-size: 16px; margin-left: 20px; text-align: justify;">3. Warranty shall be for a period of six (6) months for supplies and materials. Warranty for equipment must not be less than one (1) year from the date of acceptance and shall be accompanied with Warranty Certificate.<br></p>
                                            <p style="font-size: 16px; margin-left: 20px; text-align: justify;">4. Price validity shall be for a period of <?php echo $row['price_validity']; ?> calendar days.<br></p>
                                            <p style="font-size: 16px; margin-left: 20px; text-align: justify;">5. Bidders shall indicate the brand and model of the items being offered.<br></p>
                                            <p style="font-size: 16px; margin-left: 20px; text-align: justify;"><b>6. Approved Budget for the Contract (ABC): <?php echo $row['approved_budget']; ?></b><br></p>
                                            
                                            
                                            <br>

                                    <!-- Table Section -->
                                    <table id="invoice-items">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%;"><center>ITEM</center></th>
                                                <th style="width: 40%;"><center>ITEM & DESCRIPTION</center></th>
                                                <th style="width: 15%;"><center>QTY</center></th>
                                                <th style="width: 10%;"><center>UNIT PRICE</center></th>
                                                <th style="width: 10%;"><center>TOTAL PRICE</center></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // Ensure that items exist and loop through them
                                            if (!empty($items)) {
                                                $item_num = 1;
                                                foreach ($items as $item) {
                                                    echo "<tr>";
                                                    echo "<td>{$item_num}</td>";
                                                    echo "<td>" . nl2br($item['description']) . "</td>";
                                                    echo "<td style='text-align: center;'>{$item['qty']}</td>";
                                                    echo "<td></td>";
                                                    echo "<td></td>"; 
                                                    echo "</tr>";
                                                    $item_num++;
                                                }
                                            } else {
                                                echo "<tr><td colspan='5'>No items found.</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>

                                     <!-- Total Section -->
                                        <div id="invoice-total">
                                        <td>Total Amount</td>
                                        <td>_________</td>
                                        </div>
                                        <br><br>

                                        <div style="margin-top: 40px;">
                                        <p style="font-size: 14px;">After having carefully read and accepted your Terms and Conditions, I quote you on the item/s at the price noted above:</p>
                                        <br><br>
                                        <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 20px;">
                                            <!-- Canvassed by -->
                                            <div style="text-align: center; flex: 1;">
                                            <p>_____________________________<br>Signature over Printed Name<br>Canvassed by:</p>
                                            </div>

                                            <!-- Printed Name, Tel No, and Date -->
                                            <div style="text-align: center; flex: 1;">  
                                            <p>_____________________________<br><br>Printed Name</p><br>
                                            <p>_____________________________<br><br>Tel No./Email Address</p><br>
                                            <p>_____________________________<br><br>Date</p>
                                            </div>
                                        </div>
                                        </div>

                                    <center>
                                        <button type="button" class="btn btn-success" onclick="window.print()">Print and Download</button>
                                        <button type="button" class="btn btn-success" onclick="">Send to Supplier</button>
                                    </center>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
</body>

</html>

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
