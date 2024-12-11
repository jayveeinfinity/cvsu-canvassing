<?php
session_start();
require('function.php');
require('config.php');
$user_data = check_login($conn);
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
  <?php include 'header.php'; ?> <!-- Include header -->
  <?php include 'sidebar.php'; ?> <!-- Include sidebar -->

  <main id="main" class="main">
    <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <div style="display:<?php if (isset($_SESSION['showAlert'])) { echo $_SESSION['showAlert']; } else { echo 'none'; } unset($_SESSION['showAlert']); ?>" class="alert alert-success alert-dismissible mt-3">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong><?php if (isset($_SESSION['message'])) { echo $_SESSION['message']; } unset($_SESSION['showAlert']); ?></strong>
              </div>
              <h5 class="card-title">Papers</h5>
              <center>
              <a href="print.php" id="printBtn" class="btn btn-success"><i class="fas fa-print"></i>&nbsp;&nbsp;Generate</a>
              </center>
              <table class="table datatable">
                  <thead>
                    <tr>
                      <th style="width: 10px;">ID</th>
                      <th style="width: 400px;">PRODUCT</th>
                      <th style="width: 100px;">UNIT</th>
                      <th style="width: 100px;">Quantity</th>
                      <th style="width: 50px;">
                          <!-- New icon-only button -->
                          <a href="cartAction.php?clear=all" id="clearAllBtn" class="clear-icon" onclick="return confirm('Are you sure want to clear your cart?');">
                              <i class="bi bi-trash">&nbsp;&nbsp;Clear all</i>
                          </a>
                      </th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    require 'config.php';
                    $stmt = $conn->prepare('SELECT * FROM `cart` WHERE `user_id` = ?');
                    $stmt->bind_param("i", $user_data['user_id']);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    while ($row = $result->fetch_assoc()):
                  ?>
                  <tr>
                    <td><?= $row['id'] ?></td>
                    <input type="hidden" class="pid" value="<?= $row['id'] ?>"> <!-- Ensure pid is correctly assigned -->
                    <td><?= nl2br($row['description']) ?></td>
                    <td><?= $row['product_name'] ?></td>
                    <td>
                      <div class="btn-group">
                        <button type="button" class="btn btn-danger btn-sm minus-btn">-</button>
                        <input type="text" name="qty" class="form-control input-number itemQty" value="<?= $row['qty'] ?>" min="1" max="100" readonly>
                        <button type="button" class="btn btn-success btn-sm plus-btn">+</button>
                      </div>
                    </td>
                    <td>
                      <a href="action.php?remove=<?= $row['id'] ?>" class="text-danger lead" onclick="return confirm('Are you sure want to remove this item?');"><i class="fas fa-trash-alt"></i></a>
                    </td>
                  </tr>
                  <?php endwhile; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script type="text/javascript">

    $(document).ready(function () {
        // Function to update quantity in the database
        function updateQuantity(pid, newQty) {
            $.ajax({
                url: 'cartAction.php', // Ensure the URL is correct
                method: 'POST',
                data: {
                    updateQuantity: true,
                    pid: pid,
                    newQty: newQty
                },
                success: function (response) {
                    console.log(response); // Logs the response from the server
                },
                error: function (xhr, status, error) {
                    console.log("Error:", error); // Log any error for troubleshooting
                }
            });
        }

        // Minus button click (decreases the quantity)
        $(".minus-btn").click(function () {
            var $row = $(this).closest("tr");
            var currentQty = parseInt($row.find(".itemQty").val());

            if (currentQty > 1) {
                var newQty = currentQty - 1;
                $row.find(".itemQty").val(newQty); // Update the quantity in the input field
                var pid = $row.find(".pid").val(); // Get the product ID
                updateQuantity(pid, newQty); // Send the updated quantity to the server
            }
        });

        // Plus button click (increases the quantity)
        $(".plus-btn").click(function () {
            var $row = $(this).closest("tr");
            var currentQty = parseInt($row.find(".itemQty").val());

            var newQty = currentQty + 1;
            $row.find(".itemQty").val(newQty); // Update the quantity in the input field
            var pid = $row.find(".pid").val(); // Get the product ID
            updateQuantity(pid, newQty); // Send the updated quantity to the server
        });
    });
  </script>

</body>
</html>
