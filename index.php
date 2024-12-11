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

  <!-- ======= Sidebar ======= -->
  <?php include 'header.php'; ?> 

  <!-- ======= Sidebar ======= -->
  <?php include 'sidebar.php'; ?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Available Products</h1>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title"></h5>
              <header>
                        <div id="message"></div>
                          <div class="dropdown-container">
                        <?php
                        $selectedCategory = isset($_GET['category']) ? $_GET['category'] : 'all';
                        $escapedCategory = mysqli_real_escape_string($conn, $selectedCategory);
                        ?>
                        <label for="categoryFilter" class="category-label">Filter by Category:</label>
                        <select id="categoryFilter" name="categoryFilter" class="category-dropdown">
                            <option value="all" <?php echo ($selectedCategory === 'all') ? 'selected' : ''; ?>>All Categories</option>
                            <?php
                            $categoryQuery = "SELECT DISTINCT category FROM product";
                            $categoryResult = mysqli_query($conn, $categoryQuery);

                            while ($categoryRow = mysqli_fetch_assoc($categoryResult)) {
                                $category = $categoryRow['category'];
                                echo "<option value=\"$category\" " . (($selectedCategory === $category) ? 'selected' : '') . ">$category</option>";
                            
                            }
                            ?>
                        </select>
                        </div>
                    </header>

              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Unit</th>
                        <th>Add</th>
                    </tr>
                </thead>
                            <tbody>
                    <?php
                    $max_description_length = 100; // Max length before truncating

                    $selectedCategory = isset($_GET['category']) ? $_GET['category'] : 'all';

                    $query = "SELECT * FROM product";

                    if ($selectedCategory !== 'all') {
                        // Escape the category value to prevent SQL injection
                        $escapedCategory = mysqli_real_escape_string($conn, $selectedCategory);
                        $query .= " WHERE category = '$escapedCategory'";
                    }

                    $result = mysqli_query($conn, $query);

                    while ($row = mysqli_fetch_assoc($result)) {
                        $description = $row['description'];
                        $description_with_breaks = nl2br($description);
                        $truncated_description = (strlen($description) > $max_description_length) ? substr($description, 0, $max_description_length) . '...' : $description;
                        $show_full_description = strlen($description) > $max_description_length;
                        
                        echo "<tr>";
                        echo "<td class='product-description'>";
                        echo "<span class='truncated' id='desc_{$row['id']}'>" . $truncated_description . "</span>";
                        if ($show_full_description) {
                            echo " <span class='expandable' onclick='toggleDescription({$row['id']})'>Read more</span>";
                        }
                        echo "<span class='full-description' id='full_desc_{$row['id']}' style='display: none;'>{$description_with_breaks}</span>";
                        echo "</td>";
                        echo "<td>{$row['product_name']}</td>";
                       // echo "<td>₱" . number_format($row['product_price'], 2) . "</td>";
                        echo "<td>";
                       // echo "<input type='hidden' class='pqty' value='1' min='1'>";
                        echo "<button class='btn btn-success addItemBtn' data-action='addItemToList' data-id='{$row['product_code']}'>";
                        echo "<i class='' data-action='addItemToList' data-id='{$row['product_code']}'></i> Add</button>";
                        echo "</td>";                                      
                        echo "<input type='hidden' class='pid' value='{$row['id']}'>";
                        echo "<input type='hidden' class='pname' value='{$row['product_name']}'>";
                        echo "<input type='hidden' class='pprice' value='{$row['product_price']}'>";
                        echo "<input type='hidden' class='description' value='{$row['description']}'>";
                        echo "<input type='hidden' class='pimage' value='{$row['product_image']}'>";
                        echo "<input type='hidden' class='pcode' value='{$row['product_code']}'>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
              <!-- End Table with stripped rows -->

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
