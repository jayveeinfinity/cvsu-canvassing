<?php
include("config.php");
include("printfunction.php");
require_once("function.php");


// Retrieve data for dropdowns
$result_name = $conn->query("SELECT * FROM signatories");
$result_role = $conn->query("SELECT * FROM signatories");

$query = "select * from cart";
$result = mysqli_query($conn, $query);

// Calculate grand total
$grand_total = 0;
while ($row = mysqli_fetch_assoc($result)) {
    $grand_total += $row['total_price'];

}

// Handle "Save Only" button click
if (isset($_POST['save_only'])) {
  // Retrieve form data
  $date = $_POST['input_three'];
  $ref_no = $_POST['input_one'];
  $company = $_POST['input_two'];
  $address = $_POST['input_four'];
  $tin = $_POST['input_five'];
  $delivery_period = $_POST['input_seven'];
  $price_validity = $_POST['input_eight'];
  $approved_budget = $_POST['input_nine']; 
  

  // SQL query to insert data into the database
  $query = "INSERT INTO canvas_history (date, ref_no, company, address, tin, delivery_period, price_validity, approved_budget) 
            VALUES ('$date', '$ref_no', '$company', '$address', '$tin', '$delivery_period', '$price_validity', '$approved_budget')";

  // Execute the query
  if (mysqli_query($conn, $query)) {
      echo "<script>alert('Data saved successfully!');</script>";
  } else {
      echo "<script>alert('Error saving data: " . mysqli_error($conn) . "');</script>";
  }
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

  <style>
    /* Media query for print styles */
    @media print {
      nav {
        display: none;
      }
    }
    .form-control {
      width: 550px; /* Adjust the width as needed */
    }
    .form-two {
      width: 250px; /* Adjust the width as needed */
    }
    .form-three {
      width: 250px; /* Adjust the width as needed */
    }
    label {
      text-align: left;
    }
  </style>



</head>
<body>
<main id="main" class="main">

    <!-- ======= Sidebar ======= -->
  <?php include 'header.php'; ?> 

  <!-- ======= Sidebar ======= -->
   <?php include 'sidebar.php'; ?>

    <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">

            <div style="position: absolute; top: 20px; right: 35px; font-size: 16px; font-weight: ">
                ADMIN-QT-10
            </div>

            <div class="header-logo-container">
              <img src="https://myportal.cvsu.edu.ph/assets/img/resized/cvsu-logo.png" class="header-logo">
            </div>
      <header id = "printheader" >
        <p><center>Republic of the Philippines</center></p>
        <h3>CAVITE STATE UNIVERSITY <br> Don Severino de las Alas Campus <br></h3>
        <p><center>Indang, Cavite, Philippines <br>(046) 889-6373 <br>www.cvsu.edu.ph</center></p>
      </header> 

      <div class="center-container">
    <div class="container">
        <h4><center>REQUEST FOR QUOTATION</center></h4>   
        

        <form method="post" action="save_history.php">
            <!-- Upper right section -->
            <div class="form-group" style="overflow: hidden;">
                <div class="right-section" style="float: right; text-align: right;">
                    <label for="input_three">Date:</label>
                    <input type="date" id="input_three" name="input_three">
                    <br>
                    <label for="input_one" >Ref No.:</label>
                    <input type="text" id="input_one" name="input_one" placeholder="(e.g., -123-456-789)">
                </div>
                
                <!-- Left section -->
                <div class="left-section">
                    <label for="input_two">Company:</label>
                    <input type="text" id="input_two" name="input_two" placeholder="(e.g., Company Name)">
                    <br>
                    <label for="input_four">Address:</label>
                    <input type="text" id="input_four" name="input_four" placeholder="(e.g., Company Address)">
                    <br>
                    <label for="input_five">TIN:</label>
                    <input type="text" id="input_five" name="input_five" placeholder="(e.g., 123-456-789)">
                </div>
            </div>
        </div> 
        <br>

        <p>Sir/Madam:</p>
    <p style="font-size: 16px; text-indent: 40px; text-align: justify; ">Please quote your lowest price on the item/s listed below, subject to the Terms and Conditions on the last page, stating the shortest time of delivery. Submit your quotation duly signed by your authorized representative not later than ______
        
        <br>
        <p style="font-size: 16px; margin-left: 500px; margin-bottom: 1px;text-align: justify;">__________________________<br></p>
        <p style="font-size: 16px; margin-left: 600px; text-align: justify;">Supply Officer<br></p>
        <header>
          <p style="font-size: 16px; text-align: justify;">NOTE:<br></p>
          <p style="font-size: 16px; margin-left: 20px; text-align: justify;">1. All entries must be written legibly or typewritten.<br></p>
          <p style="font-size: 16px; margin-left: 20px; text-align: justify;">2. Delivery Period: _____ calendar days from the receipt of P.O.<br></p>
          <p style="font-size: 16px; margin-left: 20px; text-align: justify;">3. Warranty shall be for a period of six (6) months for supplies and materials. Warranty for equipment must not be less than one (1) year from the date of acceptance and shall be accompanied with Warranty Certificate.<br></p>
          <p style="font-size: 16px; margin-left: 20px; text-align: justify;">4. Price validity shall be for a period of _____ calendar days.<br></p>
          <p style="font-size: 16px; margin-left: 20px; text-align: justify;">5. Bidders shall indicate the brand and model of the items being offered.<br></p>
          <p style="font-size: 16px; margin-left: 20px; text-align: justify;"><b>6. Approved Budget for the Contract (ABC): _______________ </b></p>
          
        
          <br>
          
          
        </header>

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
            $user_id = $_SESSION['user_id']; // Get the logged-in user's ID
            $item_num = 1;
            $query = "SELECT * FROM cart WHERE user_id = '$user_id'"; // Only items belonging to the logged-in user
            $result = mysqli_query($conn, $query); // Execute the query
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>{$item_num}</td>";
                echo "<td>" . nl2br($row['description']) . "</td>";
                echo "<td style='text-align: center;'>
                        <span>{$row['qty']}</span>
                      </td>";
                echo "<td>
                        <input type='number' class='unit-price' data-id='{$row['product_code']}' data-qty='{$row['qty']}' value='0' min='0' step='0.01' style='width: 80px;'>
                      </td>";
                echo "<td class='total-price'>0.00</td>";
                echo "</tr>";
                $item_num++;
            }
            ?>
          </tbody>
        </table>

        <!-- Total Section -->
        <div id="invoice-total" style="text-align: right; margin-top: 20px;">
          <strong>Total Amount: </strong> <span id="grand-total">0.00</span>
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
            <div class="print-btn">
            <button type="submit" name="save_only" class="btn btn-primary">Save Only</button>
              <button type="button" class="btn btn-success" onclick="printAndDownload()">Print and Download</button>
            </div>
        </center>
        </form>
    </section>

  </main><!-- End #main -->
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

  <script>
    function printAndDownload() {
        // Get values from input fields
        var inputOne = document.getElementById('input_one').value;
        var inputTwo = document.getElementById('input_two').value;
        var inputThree = document.getElementById('input_three').value;
        var inputFour = document.getElementById('input_four').value;
        var inputFive = document.getElementById('input_five').value;
        // var inputSix = document.getElementById('input_six').value;
        // var inputSeven = document.getElementById('input_seven').value;
        // var inputEight = document.getElementById('input_eight').value;
        // var inputNine = document.getElementById('input_nine').value;
        
        // Check if any of the inputs are empty
        if (!inputOne || !inputTwo || !inputThree) {
            alert("Please fill in all the required fields before proceeding.");
            return; // Stop the function if any input is empty
        }

        // Convert the date to a readable string format
        var date = new Date(inputThree);
        var options = { year: 'numeric', month: 'long', day: 'numeric' };
        var dateString = date.toLocaleDateString(undefined, options);

        // Ask user for a filename
        var filename = prompt("Please enter a filename for your PDF:", "Quotation");
        if (filename) {
            const unitPriceInputs = document.querySelectorAll(".unit-price");
            unitPriceInputs.forEach((input) => {
              const qty = parseFloat(input.dataset.qty) || 0;
              const unitPrice = parseFloat(input.value) || 0;
              const code = parseInt(input.dataset.id);

              pushObject(code, qty, unitPrice);
            });

            var data = {
                input_one: inputOne,
                input_two: inputTwo,
                input_three: dateString,
                input_four: inputFour,
                input_five: inputFive,
                // unitPrices: inputSix,
                // input_seven: dateString,
                // input_eight: dateString,
                // input_nine: inputNine,
                products: objectList,
                grand_total: '<?= number_format($grand_total, 2); ?>',
                filename: filename
            };
            
            // Use fetch API to send the data to 'generate_pdf.php'
            fetch('generate_pdf.php', {
                method: 'POST',
                body: JSON.stringify(data),
                headers: {
                    'Content-Type': 'application/json'
                }
            }).then(response => response.blob())
            .then(blob => {
                // Create a URL for the blob object
                var url = window.URL.createObjectURL(blob);
                var a = document.createElement('a');
                a.href = url;
                a.download = filename + '.pdf';
                document.body.appendChild(a); // We need to append the element to the dom -> this makes it possible to click it
                a.click(); 
                a.remove();  //afterwards we remove the element again         
            });
        }
    }

    const templateObject = {
      id: null,
      qty: 0,
      unitPrice: 0
    };

    let objectList = [];

    function pushObject(id, qty, unitPrice) {
      const newObject = Object.assign({}, templateObject, { id, qty, unitPrice });
      objectList.push(newObject);
  }

  document.addEventListener("DOMContentLoaded", function () {
    const unitPriceInputs = document.querySelectorAll(".unit-price");
    const grandTotalElement = document.getElementById("grand-total");

    function calculateTotals() {
      let grandTotal = 0;

      unitPriceInputs.forEach((input) => {
        const qty = parseFloat(input.dataset.qty) || 0;
        const unitPrice = parseFloat(input.value) || 0;
        const totalPrice = qty * unitPrice;

        // Update the total price for the row
        const totalPriceElement = input.closest("tr").querySelector(".total-price");
        totalPriceElement.textContent = totalPrice.toFixed(2);

        // Add to grand total
        grandTotal += totalPrice;
      });

      // Update the grand total
      grandTotalElement.textContent = grandTotal.toFixed(2);
    }

    // Add event listener to all unit price inputs
    unitPriceInputs.forEach((input) => {
      input.addEventListener("input", calculateTotals);
    });
  });
</script>