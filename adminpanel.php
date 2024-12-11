<?php
session_start();
include('function.php');
include('config.php');
include('adminnav.php');
$user_data = check_login($conn);

if($user_data['usertype'] !== 'admin') {
    header("Location: login.php");
    die;
}

$pending_users = mysqli_query($conn, "SELECT * FROM users WHERE is_approved = FALSE");
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

  <!-- ======= Sidebar ======= -->
  <?php include 'header.php'; ?> 

  <!-- ======= Sidebar ======= -->
  <?php include 'adminnav.php'; ?>

  <main id="main" class="main">

  <div class="pagetitle">
      <h1>Dashboard</h1>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="row">

            <!-- TOTAL USER -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card sales-card">

                <div class="card-body">
                  <h5 class="card-title">TOTAL USER</h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-people"></i>
                    </div>
                    <div class="ps-3">
                                <?php

                                require 'config.php';
                                $user_counts = "SELECT id From users ORDER BY id";
                                $user_counts_run = mysqli_query($conn,$user_counts);
                                
                                $row = mysqli_num_rows($user_counts_run);

                                echo '<h1>'.$row.'</h1>';
                                ?>
                            </span>
                            <span class="text-muted small pt-2 ps-1">Total Users!</span>
                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Sales Card -->

            <!-- TOTAL PRODUCT -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card revenue-card">
                <div class="card-body">
                  <h5 class="card-title">TOTAL PRODUCT</h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-book"></i>
                    </div>
                    <div class="ps-3">
                      <?php

                          require 'config.php';
                          $product_counts = "SELECT id From product ORDER BY id";
                          $product_counts_run = mysqli_query($conn,$product_counts);
                          
                          $row1 = mysqli_num_rows($product_counts_run);

                          echo '<h1>'.$row1.'</h1>';
                          ?>
                        </span>
                        <span class="text-muted small pt-2 ps-1">Total Products!</span>

                    </div>
                  </div>
                </div>

              </div>
            </div>

            <!-- TOTAL GENERATED -->
              <div class="col-xxl-4 col-md-6">
                  <div class="card info-card revenue-card">
                      <div class="card-body">
                          <h5 class="card-title">TOTAL GENERATED</h5>

                          <div class="d-flex align-items-center">
                              <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                  <i class="bi bi-envelope-paper"></i>
                              </div>
                              <div class="ps-3">
                                  <?php
                                  require 'config.php';

                                  
                                  $history_counts = "SELECT id FROM canvas_history ORDER BY id";
                                  $history_counts_run = mysqli_query($conn, $history_counts);

                                 
                                  $total_history = mysqli_num_rows($history_counts_run);

                                  
                                  echo '<h1>' . number_format($total_history) . '</h1>';
                                  ?>
                                  <span class="text-muted small pt-2 ps-1">Total Canvas History!</span>
                              </div>
                          </div>
                      </div>
                  </div>
              </div><!-- END TOTAL GENERATED -->


            <!-- Recent Sales -->
            <div class="col-12">
              <div class="card recent-sales overflow-auto">
                <div class="card-body">
                  <h5 class="card-title">Approve Users <span>| Today</span></h5>
                  <table class="table table-bordered">
                                <thead >
                                    <tr>
                                        <th>Email</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($user = mysqli_fetch_assoc($pending_users)): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                                            <td>
                                                <a href="approve_user.php?id=<?php echo $user['user_id']; ?>" class="btn btn-success btn-sm">Approve</a>
                                                <a href="decline_user.php?id=<?php echo $user['user_id']; ?>" class="btn btn-danger btn-sm">Decline</a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                  </div>
                </div>
            </div><!-- End Recent Sales -->

            <!-- Top Selling -->
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <br><br>
                        <h4><center>History of All Canvas Requests</center></h4>
                        <br>
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>User</th>
                                    <th>Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include("config.php");

                                // Query to fetch canvas history with user details
                                $query = "
                                    SELECT ch.date, ch.id, 
                                           u.Full_name AS user_name 
                                    FROM canvas_history ch
                                    LEFT JOIN users u ON ch.user_id = u.user_id
                                    ORDER BY ch.date DESC
                                ";
                                $result = mysqli_query($conn, $query);

                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $date = date('M d, Y', strtotime($row['date'])); // Format the date
                                        
                                        $fullName = !empty($row['user_name']) ? htmlspecialchars($row['user_name']) : 'Unknown User';
                                       

                                        echo "
                                            <tr>
                                                <td>{$date}</td>
                                                
                                                <td>{$fullName}</td>
                                                <td>
                                                    <a href='view_history_detail_admin.php?id={$row['id']}' class='btn btn-primary btn-sm'>View Details</a>
                                                </td>
                                            </tr>
                                        ";
                                    }
                                } else {
                                    echo "
                                        <tr>
                                            <td colspan='5' class='text-center'>No canvas history found.</td>
                                        </tr>
                                    ";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <!-- Right side columns -->
          <div class="col-lg-4">

          <!-- Total Unit and Add New Unit -->
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">TOTAL UNIT </h5>
              <div class="activity">

                <!-- Display the Total Units -->
                <div class="activity-item d-flex">
                  <div class="activite-label">Now</div>
                  <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                  <div class="activity-content">
                    <?php
                      require 'config.php';
                      $unit_counts = "SELECT id FROM units ORDER BY id";
                      $unit_counts_run = mysqli_query($conn, $unit_counts);
                      
                      $row1 = mysqli_num_rows($unit_counts_run);

                      echo '<h1>' . $row1 . '</h1>';
                    ?>
                    <span class="text-muted small pt-2 ps-1">Total Units!</span>
                  </div>
                </div><!-- End activity item -->

              </div>

              <!-- Add New Unit -->
              <h5 class="card-title mt-4">Add New Unit</h5>

              <!-- Form to Add New Unit -->
              <form action="add_unit.php" method="POST">
                <div class="mb-3">
                  <label for="unit_name" class="form-label">Unit Name</label>
                  <input type="text" class="form-control" id="unit_name" name="unit_name" required>
                </div>
                <button type="submit" class="btn btn-primary">Add Unit</button>
              </form>

            </div>
          </div><!-- End Total Unit and Add New Unit -->
          <div class="col-lg-12">

  <!-- Total Categories and Add New Category -->
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">TOTAL CATEGORIES</h5>
      <div class="activity">

        <!-- Display the Total Categories -->
        <div class="activity-item d-flex">
          <div class="activite-label">Now</div>
          <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
          <div class="activity-content">
            <?php
              require 'config.php';
              $category_counts = "SELECT id FROM categories ORDER BY id";
              $category_counts_run = mysqli_query($conn, $category_counts);
              
              $row1 = mysqli_num_rows($category_counts_run);

              echo '<h1>' . $row1 . '</h1>';
            ?>
            <span class="text-muted small pt-2 ps-1">Total Categories!</span>
          </div>
        </div><!-- End activity item -->

      </div>

      <!-- Add New Category -->
      <h5 class="card-title mt-4">Add New Category</h5>

      <!-- Form to Add New Category -->
      <form action="add_category.php" method="POST">
        <div class="mb-3">
          <label for="category_name" class="form-label">Category Name</label>
          <input type="text" class="form-control" id="category_name" name="category_name" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Category</button>
      </form>

    </div>
  </div><!-- End Total Categories and Add New Category -->

          
          

          </div><!-- End Right side columns -->



      </div>
    </section>

  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

 

</body>

</html>

 <!-- Vendor JS Files -->
 <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.js"></script>
  
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <script>
    $(document).ready(function () {
        $('.datatable').DataTable(); // Initialize the DataTable
    });
</script>



  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>