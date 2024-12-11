<?php
// Include necessary files for database connection
include('function.php');
include('config.php');

// Check if the 'id' is set in the URL
if (isset($_GET['id'])) {
  $canvas_history_id = $_GET['id'];

  // Prepare query to fetch details from the canvas_history table
  $query = "
      SELECT canvas_history.id, canvas_history.ref_no, canvas_history.company, canvas_history.address, 
             canvas_history.tin, canvas_history.date, canvas_history.submission_deadline,
             canvas_history.delivery_period, canvas_history.price_validity, canvas_history.approved_budget,
             canvas_history.grand_total
      FROM canvas_history
      WHERE canvas_history.id = ? ";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("i", $canvas_history_id);
  $stmt->execute();
  $result = $stmt->get_result();

  // Check if the canvas history record exists

  
  if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();

      // Prepare query to fetch related items from the canvas_history_items table
      $items_query = "
          SELECT id, description, qty, product_name, total_price
          FROM canvas_history_items
          WHERE history_id = ?";
      $items_stmt = $conn->prepare($items_query);
      $items_stmt->bind_param("i", $canvas_history_id);
      $items_stmt->execute();
      $items_result = $items_stmt->get_result();

      // Fetch all items into an array
      $items = [];
      while ($item_row = $items_result->fetch_assoc()) {
          $items[] = $item_row;
      }
  } else {
      echo "No details found for this canvas history.";
      exit;
  }
} else {
  echo "Canvas history ID not provided!";
  exit;
}

// Check if the form is submitted
if (isset($_POST['save_only'])) {
  // Loop through the updated prices and save them to the database
  if (isset($_POST['unit_price']) && is_array($_POST['unit_price'])) {
      foreach ($_POST['unit_price'] as $item_id => $new_price) {
          $new_price = floatval($new_price); // Ensure the price is a valid number

          $update_query = "
              UPDATE canvas_history_items
              SET total_price = ?
              WHERE id = ?";
          $stmt = $conn->prepare($update_query);
          $stmt->bind_param("di", $new_price, $item_id);
          $stmt->execute();
      }

      // Optional redirect or feedback
      echo "<script>alert('Prices updated successfully!'); window.location.href = window.location.href;</script>";
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

  <!-- DataTables CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
</head>
<body>
<main id="main" class="main">

    <!-- ======= Sidebar ======= -->
  <?php include 'header.php'; ?> 

  <!-- ======= Sidebar ======= -->
   <?php include 'supply_sidebar.php'; ?>

    <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">

            <div style="position: absolute; top: 20px; right: 35px; font-size: 16px; font-weight:">
                ADMIN-QT-10
            </div>

            <div class="header-logo-container">
              <img src="https://myportal.cvsu.edu.ph/assets/img/resized/cvsu-logo.png" class="header-logo">
            </div>
      <header id="printheader">
        <p><center>Republic of the Philippines</center></p>
        <h3>CAVITE STATE UNIVERSITY <br> Don Severino de las Alas Campus <br></h3>
        <p><center>Indang, Cavite, Philippines <br>(046) 889-6373 <br>www.cvsu.edu.ph</center></p>
      </header>

      <div class="center-container">
        <div class="container">
            <h4><center>REQUEST FOR QUOTATION</center></h4>   

            <form method="post" action="save_new_history.php">
                  <div class="form-group" style="overflow: hidden;">
                      <div class="right-section" style="float: right; text-align: right;">
                          <label for="input_three">Date:</label>
                          <input type="date" id="input_three" name="input_three" value="<?php echo date('Y-m-d'); ?>" readonly>
                          <br>
                          <label for="input_one">Ref No.:</label>
                          <input type="text" id="input_one" name="input_one" placeholder="(e.g., -123-456-789)" value="<?php echo !empty($row['ref_no']) ? htmlspecialchars($row['ref_no']) : ''; ?>" readonly>
                      </div>

                      <div class="left-section">
                          <label for="input_two">Company:</label>
                          <input type="text" id="input_two" name="input_two" placeholder="(e.g., Company Name)" value="<?php echo htmlspecialchars($row['company']); ?>" readonly>
                          <br>
                          <label for="input_four">Address:</label>
                          <input type="text" id="input_four" name="input_four" placeholder="(e.g., Company Address)" value="<?php echo htmlspecialchars($row['address']); ?>" readonly>
                          <br>
                          <label for="input_five">TIN:</label>
                          <input type="text" id="input_five" name="input_five" placeholder="(e.g., 123-456-789)" value="<?php echo !empty($row['tin']) ? htmlspecialchars($row['tin']) : ''; ?>" readonly>
                      </div>
                  </div>
              </form>

            <br>

            <p>Sir/Madam:</p>
            <p style="font-size: 16px; text-indent: 40px; text-align: justify; ">
                Please quote your lowest price on the item/s listed below, subject to the Terms and Conditions on the last page, stating the shortest time of delivery. Submit your quotation duly signed by your authorized representative not later than ______
            </p>

            <header>
              <p style="font-size: 16px; text-align: justify;">NOTE:<br></p>
              <p style="font-size: 16px; margin-left: 20px; text-align: justify;">1. All entries must be written legibly or typewritten.<br></p>
              <p style="font-size: 16px; margin-left: 20px; text-align: justify;">2. Delivery Period: _____ calendar days from the receipt of P.O.<br></p>
              <p style="font-size: 16px; margin-left: 20px; text-align: justify;">3. Warranty shall be for a period of six (6) months for supplies and materials. Warranty for equipment must not be less than one (1) year from the date of acceptance and shall be accompanied with Warranty Certificate.<br></p>
              <p style="font-size: 16px; margin-left: 20px; text-align: justify;">4. Price validity shall be for a period of _____ calendar days.<br></p>
              <p style="font-size: 16px; margin-left: 20px; text-align: justify;">5. Bidders shall indicate the brand and model of the items being offered.<br></p>
              <p style="font-size: 16px; margin-left: 20px; text-align: justify;"><b>6. Approved Budget for the Contract (ABC): _______________ </b></p>
            </header>

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
                                            <tbody>
                                              <?php
                                              if (!empty($items)) {
                                                  $item_num = 1;
                                                  foreach ($items as $item) {
                                                      echo "<tr>";
                                                      echo "<td>{$item_num}</td>";
                                                      echo "<td>" . nl2br(htmlspecialchars($item['description'])) . "</td>";
                                                      echo "<td class='qty' style='text-align: center;'>{$item['qty']}</td>";
                                                      echo "<td><input type='number' name='unit_price[{$item['id']}]' class='unit-price' value='{$item['total_price']}' step='0.01' min='0' /></td>";
                                                      echo "<td class='total-price'>₱" . number_format($item['qty'] * $item['total_price'], 2) . "</td>";
                                                      echo "</tr>";
                                                      $item_num++;
                                                  }
                                              } else {
                                                  echo "<tr><td colspan='5'>No items found.</td></tr>";
                                              }
                                              ?>
                                              </tbody>
                                            </table>

                                          <div id="invoice-total" style="text-align: right; margin-top: 20px;">
                                            <strong>Total Amount: </strong> <span id="grand-total">0.00</span>
                                          </div>

            <br><br>

            <div style="margin-top: 40px;">
              <p style="font-size: 14px;">After having carefully read and accepted your Terms and Conditions, I quote you on the item/s at the price noted above:</p>
              <br><br>
              <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 20px;">
                <div style="text-align: center; flex: 1;">
                  <p>_____________________________<br>Signature over Printed Name<br>Canvassed by:</p>
                </div>
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
              </div>
      
            </center>
        </form>
    </section>

  </main><!-- End #main -->


</body>
</html>
<script>
    $(document).ready(function() {
      // Update total price when unit price changes
      $(document).on('input', '.unit-price', function() {
        var row = $(this).closest('tr');
        var qty = row.find('.qty').text();
        var unitPrice = row.find('.unit-price').val();
        var totalPrice = qty * unitPrice;
        row.find('.total-price').text('₱' + totalPrice.toFixed(2));
        updateGrandTotal();
      });

      function updateGrandTotal() {
        var grandTotal = 0;
        $('.total-price').each(function() {
          var price = parseFloat($(this).text().replace('₱', '').replace(',', ''));
          if (!isNaN(price)) {
            grandTotal += price;
          }
        });
        $('#grand-total').text(grandTotal.toFixed(2));
      }

      $(document).on('click', function() {
        // To do here
      });
    });
  </script>