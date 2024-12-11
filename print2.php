<?php
include("config.php");
include("navbar.php");
include("printfunction.php");

// Retrieve data for dropdowns
$result_name = $conn->query("SELECT * FROM signatories");
$result_role = $conn->query("SELECT * FROM signatories");

// Query to select items where the total price is less than ₱50,000
$query = "SELECT * FROM cart WHERE total_price < 50000";
$result = mysqli_query($conn, $query);

// Calculate grand total for items less than ₱50,000
$grand_total = 0;
while ($row = mysqli_fetch_assoc($result)) {
    $grand_total += $row['total_price'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="CSS/print.css">

  <title>CvSU ONLINE CANVASSING</title>
  
  <link rel="icon" href="https://myportal.cvsu.edu.ph/assets/img/resized/cvsu-logo.png" type="image/gif" sizes="18x16">

  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css' />
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css' />

  <style>
    @media print {
      nav {
        display: none;
      }
    }
    .form-control {
      width: 550px;
    }
    .form-two, .form-three {
      width: 250px;
    }
    label {
      text-align: left;
    }
    
  </style>



</head>
<body>

<div class="center-container">
  <div class="row justify-content-center;">
    <div class="col-lg-12 px-20" id="order">

      <div class="receipt-left">
        <img src="https://myportal.cvsu.edu.ph/assets/img/resized/cvsu-logo.png" style="width: 120px; border-radius: 70px;">
      </div>
      <header>
        <p><center>Republic of the Philippines</center></p>
        <h3>CAVITE STATE UNIVERSITY <br> Don Severino de las Alas Campus <br></h3>
        <p><center>Indang, Cavite, Philippines <br>(046) 889-6373 <br>www.cvsu.edu.ph</center></p>
      </header> 

      <div class="center-container">
    <div class="container">
        <h4><center>REQUEST FOR QOUTATION</center></h4>   
        

        <form method="post">
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
        </form>
        </div> 
        <br>

        <p>Sir/Madam:</p>
    <p style="font-size: 16px; text-indent: 40px; text-align: justify; ">Please quote your lowest price on the item/s listed below, subject to the Terms and Conditions on the last page, stating the shortest time of delivery. Submit your quotation duly signed by your authorized representative not later than __________________</p>
        
        <br>
        <p style="font-size: 16px; margin-left: 500px; margin-bottom: 1px;text-align: justify;">__________________________<br></p>
        <p style="font-size: 16px; margin-left: 600px; text-align: justify;">Supply Officer<br></p>
        <header>
          <p style="font-size: 16px; text-align: justify;">NOTE:<br></p>
          <p style="font-size: 16px; margin-left: 20px; text-align: justify;">1. All entries must be written legibly or typewritten.<br></p>
          <p style="font-size: 16px; margin-left: 20px; text-align: justify;">2. Delivery Period: ____ calendar days from the receipt of P.O.<br></p>
          <p style="font-size: 16px; margin-left: 20px; text-align: justify;">3. Warranty shall be for a period of six (6) months for supplies and materials. Warranty for equipment must not be less than one (1) year from the date of acceptance and shall be accompanied with Warranty Certificate.<br></p>
          <p style="font-size: 16px; margin-left: 20px; text-align: justify;">4. Price validity shall be for a period of _______ calendar days.<br></p>
          <p style="font-size: 16px; margin-left: 20px; text-align: justify;">5. Bidders shall indicate the brand and model of the items being offered.<br></p>
          <p style="font-size: 16px; margin-left: 20px; text-align: justify;"><b>6. Approved Budget for the Contract (ABC):</b><br></p>

          <br>

          
        </header>

        <!-- Table Section -->
        <table id="invoice-items">
          <thead>
            <tr>
              <th style="width: 5%;"><center>Item No.</center></th>
              <th style="width: 10%;"><center>Quantity</center></th>
              <th style="width: 10%;"><center>Unit</center></th>
              <th style="width: 40%;"><center>Description</center></th>
              <th style="width: 10%;"><center>Unit Cost</center></th>
              <th style="width: 10%;"><center>Total Cost</center></th>
            </tr>
          </thead>
          <tbody>
            <?php
            $item_num = 1;
            $result = mysqli_query($conn, $query); // Reset the result set
            while ($row = mysqli_fetch_assoc($result)) {
              echo "<tr>";
              echo "<td>{$item_num}</td>";
              echo "<td>{$row['qty']}</td>";
              echo "<td>{$row['product_name']}</td>";
              echo "<td>" . nl2br($row['description']) . "</td>";
              echo "<td>₱" . number_format($row['product_price'], 2) . "</td>";
              echo "<td>₱" . number_format($row['total_price'], 2) . "</td>";
              echo "</tr>";
              $item_num++;
            }
            ?>
          </tbody>
        </table>

        <!-- Total Section -->
        <div id="invoice-total">
          <td>Total Amount</td>
          <td><b>₱<?= number_format($grand_total, 2); ?></b></td>
        </div>
        <br><br><br><br>
        <header>
        <div style="width: 100%; display: flex; flex-direction: row; justify-content: space-between;">
            <div></div>
            <div style="display: flex; flex-direction: column; justify-content: center;">
              <div style="position: relative; height: 30px;">
                <img style="position: absolute; height: 60px; left: 50%; transform: translate(-50%, 0);" src="img/65b651efcb2c7.png">
              </div>
              <p class="mb-0 fw-bold">ROSELYN M. MARANAN</p>
              <p>BAC Secretary, Goods and Consulting Services</p>
            </div>
          </div>
          </header>

        <center>
            <div class="print-btn">
              <button type="button" class="btn btn-success" onclick="printAndDownload()">Print and Download</button>
            </div>
        </center>

    </div>
  </div>
</div>
</body>
</html>
<script>
    function printAndDownload() {
        var inputOne = document.getElementById('input_one').value;
        var inputTwo = document.getElementById('input_two').value;
        var inputThree = document.getElementById('input_three').value;
        var inputFour = document.getElementById('input_four').value;
        var inputFive = document.getElementById('input_five').value;
        
        if (!inputOne || !inputTwo || !inputThree || !inputFour || !inputFive) {
            alert("Please fill in all the required fields before proceeding.");
            return;
        }

        var date = new Date(inputThree);
        var options = { year: 'numeric', month: 'long', day: 'numeric' };
        var dateString = date.toLocaleDateString(undefined, options);

        var filename = prompt("Please enter a filename for your PDF:", "Quotation");
        if (filename) {
            var data = {
                input_one: inputOne,
                input_two: inputTwo,
                input_three: dateString,
                input_four: inputFour,
                input_five: inputFive,
                grand_total: '<?= number_format($grand_total, 2); ?>',
                filename: filename
            };
            
            fetch('generate_pdfless50k.php', {
                method: 'POST',
                body: JSON.stringify(data),
                headers: {
                    'Content-Type': 'application/json'
                }
            }).then(response => response.blob())
            .then(blob => {
                var url = window.URL.createObjectURL(blob);
                var a = document.createElement('a');
                a.href = url;
                a.download = filename + '.pdf';
                document.body.appendChild(a);
                a.click(); 
                a.remove();         
            });
        }
    }
</script>
