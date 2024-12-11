<?php
session_start(); // Ensure session is started

// Include database connection
require 'config.php';
require 'function.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate the user inputs
    $user_id = $_SESSION['user_id'];
    $full_name = mysqli_real_escape_string($conn, $_POST['Full_Name']);
    $department = mysqli_real_escape_string($conn, $_POST['Department']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    
    // Validate phone number to ensure it contains only numbers
    if (preg_match('/^\d+$/', $_POST['Phone'])) {
        $phone = mysqli_real_escape_string($conn, $_POST['Phone']);
    } else {
        echo "Invalid phone number. Please enter only numbers.";
        exit;
    }

    // Handle profile image upload
    $profile_image = $_FILES['profile_image'];
    $new_image_name = '';
    if ($profile_image['error'] === 0) {
        $upload_dir = 'assets/img/';
        $new_image_name = time() . '_' . $profile_image['name']; // Generate a unique name for the image
        $upload_path = $upload_dir . $new_image_name;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($profile_image['tmp_name'], $upload_path)) {
            // Successfully uploaded the file
        } else {
            echo "Error uploading image.";
        }
    }

    // Update the database with new values
    $update_query = "UPDATE users SET Full_name = '$full_name', Department = '$department', Phone_number = '$phone', Email = '$email'";

    // If a new image was uploaded, update the profile image field as well
    if ($new_image_name) {
        $update_query .= ", profile_image = '$new_image_name'";
    }

    $update_query .= " WHERE user_id = '$user_id'";

    if (mysqli_query($conn, $update_query)) {
        header("Location: userprofile.php");
    } else {
        echo "Error updating profile: " . mysqli_error($conn);
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

  <!-- ======= Sidebar ======= -->
  <?php include 'header.php'; ?> 

  <!-- ======= Sidebar ======= -->
  <?php include 'supply_sidebar.php'; ?>

  <main id="main" class="main">
    <br> <br>

<section class="section profile">
  <div class="row">
    <div class="col-xl-4">

      <div class="card">
        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

    
          <h2><?php echo $Full_name; ?></h2>
          <h3><?php echo $user_type; ?></h3>
          
        </div>
      </div>

    </div>

    <div class="col-xl-8">

      <div class="card">
        <div class="card-body pt-3">
          <!-- Bordered Tabs -->
          <ul class="nav nav-tabs nav-tabs-bordered">

            <li class="nav-item">
              <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
            </li>

            <li class="nav-item">
              <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
            </li>

            <li class="nav-item">
              <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
            </li>

          </ul>
          <div class="tab-content pt-2">

            <div class="tab-pane fade show active profile-overview" id="profile-overview">

              <br>

              <div class="row">
                <div class="col-lg-3 col-md-4 label ">Full Name</div>
                <div class="col-lg-9 col-md-8"><?php echo $Full_name; ?></div>
              </div>

              <div class="row">
                <div class="col-lg-3 col-md-4 label">Department</div>
                <div class="col-lg-9 col-md-8"><?php echo $Department; ?></div>
              </div>

              <div class="row">
                <div class="col-lg-3 col-md-4 label">Phone</div>
                <div class="col-lg-9 col-md-8"><?php echo $Phone_number; ?></div>
              </div>

              <div class="row">
                <div class="col-lg-3 col-md-4 label">Email</div>
                <div class="col-lg-9 col-md-8"><?php echo $user_email; ?></div>
              </div>

            </div>

                     <!-- Profile Edit -->
                     <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                    <form action="update_profile.php" method="POST" enctype="multipart/form-data">
                        

                        <!-- Full Name -->
                        <div class="row mb-3">
                            <label for="Full_Name" class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="Full_Name" type="text" class="form-control" id="Full_Name" value="<?php echo htmlspecialchars($Full_name); ?>">
                            </div>
                        </div>

                        <!-- Department -->
                        <div class="row mb-3">
                            <label for="Department" class="col-md-4 col-lg-3 col-form-label">Department</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="Department" type="text" class="form-control" id="Department" value="<?php echo htmlspecialchars($Department); ?>">
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="row mb-3">
                            <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Phone</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="Phone" type="text" class="form-control" id="Phone" 
                                    value="<?php echo htmlspecialchars($Phone_number); ?>" 
                                    pattern="\d*" title="Only numbers are allowed" maxlength="15" 
                                    required>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="row mb-3">
                            <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="email" type="email" class="form-control" id="Email" value="<?php echo htmlspecialchars($user_email); ?>">
                            </div>
                        </div>

                        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($_SESSION['user_id']); ?>">

                        <!-- Submit Button -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>

            <div class="tab-pane fade pt-3" id="profile-change-password">
              <!-- Change Password Form -->
              <form>

                <div class="row mb-3">
                  <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                  <div class="col-md-8 col-lg-9">
                    <input name="password" type="password" class="form-control" id="currentPassword">
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                  <div class="col-md-8 col-lg-9">
                    <input name="newpassword" type="password" class="form-control" id="newPassword">
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                  <div class="col-md-8 col-lg-9">
                    <input name="renewpassword" type="password" class="form-control" id="renewPassword">
                  </div>
                </div>

                <div class="text-center">
                  <button type="submit" class="btn btn-primary">Change Password</button>
                </div>
              </form><!-- End Change Password Form -->

            </div>

          </div><!-- End Bordered Tabs -->

        </div>
      </div>

    </div>
  </div>
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
  
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <script>
    $(document).ready(function () {
        $('.datatable').DataTable(); // Initialize the DataTable
    });
</script>



  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

  <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js'></script>
                                
                                <script type="text/javascript">
                                    document.addEventListener('click', function(e) {
                                        e = e || window.event;
                                        var target = e.target || e.srcElement;
                            
                                        if(target.dataset.action == "addItemToList") {
                                            e.preventDefault();
                                            
                                            $.ajax({
                                                url: 'action.php',
                                                method: 'POST',
                                                data: {
                                                    action: "addItemToList",
                                                    code: target.dataset.id
                                                },
                                                success: function (response) {
                                                    $("#message").html(response);
                                                    window.scrollTo(0, 0);
                                                    load_cart_item_number();
                                                }
                                            });
                                            return;
                                        }
                                    });
                                $(document).ready(function () {
                                    // Send product details to the server
                                    $(".addItemBtn").click(function (e) {
                                        e.preventDefault();
                                        var $form = $(this).closest("tr");
                                        var pid = $form.find(".pid").val();
                                        var pname = $form.find(".pname").val();
                                        var pprice = $form.find(".pprice").val();
                                        var description = $form.find(".description").val();
                                        var pimage = $form.find(".pimage").val();
                                        var pcode = $form.find(".pcode").val();
                                        var pqty = $form.find(".pqty").val();
                            
                                        // $.ajax({
                                        //     url: 'action.php',
                                        //     method: 'post',
                                        //     data: {
                                        //         pid: pid,
                                        //         pname: pname,
                                        //         pprice: pprice,
                                        //         description: description,
                                        //         pqty: pqty,
                                        //         pimage: pimage,
                                        //         pcode: pcode
                                        //     },
                                        //     success: function (response) {
                                        //         $("#message").html(response);
                                        //         window.scrollTo(0, 0);
                                        //         load_cart_item_number();
                                        //     }
                                        // });
                                    });
                                });
                            
                                // Load total number of items added to the cart and display in the navbar
                                load_cart_item_number();
                            
                                function load_cart_item_number() {
                                    $.ajax({
                                        url: 'action.php',
                                        method: 'get',
                                        data: {
                                            cartItem: "cart_item"
                                        },
                                        success: function (response) {
                                            $("#cart-item").html(response);
                                        }
                                    });
                                }
                            </script>
                            
                            <script>
                                // Add an event listener to the category filter dropdown
                                document.getElementById('categoryFilter').addEventListener('change', function () {
                                    // Get the selected category value
                                    var selectedCategory = this.value;
                            
                                    // Update the page with the selected category
                                    window.location.href = 'index.php?category=' + selectedCategory;
                                });

                                function toggleDescription(id) {
                                    var fullDesc = document.getElementById('full_desc_' + id);
                                    var truncatedDesc = document.getElementById('desc_' + id);
                                    var readMoreLink = document.querySelector('[onclick="toggleDescription(' + id + ')"]');

                                    if (fullDesc.style.display === 'none') {
                                        fullDesc.style.display = 'block';  // Show the full description
                                        truncatedDesc.style.display = 'none';  // Hide the truncated description
                                        readMoreLink.textContent = 'Read less';  // Change text to "Read less"
                                    } else {
                                        fullDesc.style.display = 'none';  // Hide the full description
                                        truncatedDesc.style.display = 'inline';  // Show the truncated description
                                        readMoreLink.textContent = 'Read more';  // Change text to "Read more"
                                    }
                                }

                            </script>

                            <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                const addItemButtons = document.querySelectorAll('.addItemBtn');

                                addItemButtons.forEach(button => {
                                button.addEventListener('click', function () {
                                    const itemId = this.dataset.id; // Retrieve the product ID from the button's dataset
                                    
                                    // Simulate adding the item (replace with your actual AJAX or backend request code)
                                    console.log(`Adding item with ID: ${itemId}`);

                                    // Update the button text to "Added" and disable it
                                    this.textContent = 'Added';
                                    this.classList.remove('btn-primary');
                                    this.classList.add('btn-danger');
                                    this.disabled = true;
                                });
                                });
                            });
                            </script>
<script>
    document.getElementById('Phone').addEventListener('input', function (e) {
        var value = e.target.value;
        // Allow only numeric input
        e.target.value = value.replace(/[^0-9]/g, '');
    });
</script>