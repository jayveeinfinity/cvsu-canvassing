<?php
session_start();
include('function.php');
include('config.php');
include('adminnav.php');

$user_data = check_login($conn);
$query = "SELECT * FROM product";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>CvSU Canvassing</title>


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
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

   <!-- DataTables CSS -->
   <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>

        <!-- Bootstrap JS -->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        



    <style>
    .actions {
        display: flex;
        gap: 10px; /* Space between buttons */
    }
 
</style>
</head>

<body>

  <!-- ======= Sidebar ======= -->
  <?php include 'header.php'; ?> 


  <main id="main" class="main">


  <section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"></h5>

                    <header>
                        <h1 class="text-center">All Product List</h1>
                    </header>

                    <!-- Add new product button -->
                    <div>
                        <button class="btn btn-success" data-toggle="modal" data-target="#addModal">
                            <i class="bi bi-plus"></i> Add new
                        </button>
                    </div>

                    <!-- Table starts here -->
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th>Item Number</th>
                                <th>Category</th>
                                <th>Unit</th>
                                <th>Description</th>
                                
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
    <?php
    $max_description_length = 100; // Maximum characters before truncation

    while ($row = mysqli_fetch_assoc($result)) {
        $description = $row['description'];
        $truncated_description = (strlen($description) > $max_description_length) 
            ? substr($description, 0, $max_description_length) . '...' 
            : $description;
        $has_more = strlen($description) > $max_description_length;
        ?>
        <tr data-id="<?php echo $row['id']; ?>" 
            data-product-code="<?php echo $row['product_code']; ?>" 
            data-description="<?php echo htmlspecialchars($row['description'], ENT_QUOTES); ?>" 
            data-unit="<?php echo $row['product_name']; ?>" 
            data-category="<?php echo $row['category']; ?>">
            <td><?php echo $row['product_code']; ?></td>
            <td><?php echo $row['category']; ?></td>
            <td><?php echo $row['product_name']; ?></td>
            <td>
                <span id="desc_<?php echo $row['id']; ?>">
                    <?php echo $truncated_description; ?>
                </span>
                <?php if ($has_more): ?>
    <span id="full_desc_<?php echo $row['id']; ?>" style="display:none;">
        <?php echo nl2br($description); ?>
    </span>
    <a href="javascript:void(0);" onclick="toggleDescription(<?php echo $row['id']; ?>)" style="text-decoration: underline;">Read more</a>
<?php endif; ?>

            </td>
            <td class="actions">
                <button class="btn btn-warning editbtn" data-toggle="modal" data-target="#updateModal">
                    <i class="fas fa-pencil-alt"></i> Update
                </button>
                <button class="btn btn-danger deletebtn" data-id="<?php echo $row['id']; ?>" data-toggle="modal" data-target="#deleteModal">
                    <i class="fas fa-trash"></i> Delete
                </button>

            </td>
        </tr>
    <?php
    }
    ?>
</tbody>

                    </table> <!-- Table ends here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

   <!-- Add Modal -->
   <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Add Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="addproduct.php" method="POST">
                        
                    <div class="form-group">
                            <label>Product Item Number</label>
                            <input type="product_code" class="form-control" name="product_code" required>
                    </div>
                    <div class="form-group">
                            <label>Description</label>
                            <textarea type="description"class="form-control" name="description" required rows="5"></textarea>
                            
                     </div>
                     <div class="form-group">
                            <label>Unit</label>
                            <select class="form-control" name="product_name" required>
                                <option selected>Select unit</option>
                                <?php
                                    $query_units = "SELECT * FROM units";
                                    $units_result = mysqli_query($conn, $query_units);  
                                    while($unit = mysqli_fetch_assoc($units_result)) {
                                        echo "<option value='" . $unit['unit_name'] . "'>" . $unit['unit_name'] . "</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        
                        
                        <div class="form-group">
                            <label>Category</label>
                            <select class="form-control" name="category" required>
                                <option selected>Select Category</option>
                                <?php
                                    $query_categories = "SELECT * FROM categories";
                                    $categories_result = mysqli_query($conn, $query_categories); 
                                    while($category = mysqli_fetch_assoc($categories_result)) {
                                        echo "<option value='" . $category['category_name'] . "'>" . $category['category_name'] . "</option>";
                                    }
                                ?>
                            </select>
                            </div>
                            <button type="submit" class="btn btn-primary" name="insertdata">Save Data</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this product?
                <form method="POST" action="deleteproduct.php">
                    <input type="hidden" name="delete_id" id="delete_id" value="">
                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                </form>

            </div>
        </div>
    </div>
</div>

<!-- Update Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="updateproduct.php" method="POST">
                <div class="modal-body">
                    <!-- Hidden input for update id -->
                    <input type="hidden" name="update_id" id="update_id">

                    <div class="form-group">
                        <label>Product Item Number</label>
                        <input type="text" class="form-control" name="product_code" id="product_code" required>
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" name="description" id="description" required rows="5"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Unit</label>
                        <select class="form-control" name="product_name" id="product_name" required>
                            <option selected>Select Unit</option>
                            <!-- Add your units dynamically -->
                            <option value="pcs">pcs/pc</option>
                            <option value="unit">unit</option>
                            <option value="liters">liters</option>
                            <option value="sets">sets</option>
                            <option value="gal">gallon</option>
                            <option value="roll">roll</option>
                            <option value="btls">btls</option>
                            <option value="months">months</option>
                            <option value="cart">cart</option>
                            <option value="box">box</option>
                            <option value="bundle">bundle</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Category</label>
                        <select class="form-control" name="category" id="category" required>
                            <option selected>Select Category</option>
                            <!-- Add your categories dynamically -->
                            <option value="food">Food</option>
                            <option value="electronics">Electronics</option>
                            <option value="materials">Materials</option>
                            <option value="equipments">Equipments</option>
                            <option value="others">Others</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="update_product" class="btn btn-primary">Update Data</button>
                </div>
            </form>
        </div>
    </div>
</div>


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
  
    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

  <script>
    $(document).ready(function () {
        $('.datatable').DataTable(); // Initialize the DataTable
    });
</script>


<script>
function toggleDescription(id) {
    var fullDesc = document.getElementById('full_desc_' + id);
    var truncatedDesc = document.getElementById('desc_' + id);
    var toggleLink = document.querySelector(`[onclick="toggleDescription(${id})"]`);

    if (fullDesc.style.display === 'none') {
        fullDesc.style.display = 'inline'; // Show the full description
        truncatedDesc.style.display = 'none'; // Hide the truncated description
        toggleLink.textContent = 'Read less'; // Update link text
    } else {
        fullDesc.style.display = 'none'; // Hide the full description
        truncatedDesc.style.display = 'inline'; // Show the truncated description
        toggleLink.textContent = 'Read more'; // Update link text
    }
}


</script>

<script>
$(document).ready(function () {
    var table = $('.datatable').DataTable(); // Initialize DataTable

    // Event delegation for Delete button
    $(document).on('click', '.deletebtn', function () {
    $('#deleteModal').modal('show');
    var deleteId = $(this).data('id');
    $('#delete_id').val(deleteId);
});


    // Event delegation for Edit button
        $(document).on('click', '.editbtn', function () {
        $('#updateModal').modal('show'); // Show the modal

        // Get data attributes from the row
        var row = $(this).closest('tr');
        var updateId = row.data('id');
        var productCode = row.data('product-code');
        var description = row.data('description');
        var unit = row.data('unit');
        var category = row.data('category');

        // Set the modal fields
        $('#update_id').val(updateId);
        $('#product_code').val(productCode);
        $('#description').val(description);
        $('#product_name').val(unit);
        $('#category').val(category);
    });


        // Get the product ID from the data-id attribute of the clicked button
        var updateId = $(this).data('id');
        $('#update_id').val(updateId); // Set the hidden input with the product ID

        // Get the product details from the current row
        var productCode = $(this).closest('tr').find('td:eq(0)').text(); // Product code
        var description = $(this).closest('tr').find('td:eq(3)').text(); // Description
        var unit = $(this).closest('tr').find('td:eq(2)').text(); // Unit
        var category = $(this).closest('tr').find('td:eq(1)').text(); // Category

        // Clean up the description to avoid unwanted line breaks or extra spaces
        description = description.replace(/\s+/g, ' ').trim(); // Remove extra spaces and trim leading/trailing spaces

        // Convert <br> tags to newlines for the description
        description = description.replace(/<br\s*\/?>/gi, '\n');

        // Set the modal fields with the current row's data
        $('#product_code').val(productCode); // Set product code
        $('#description').val(description); // Set description
        $('#product_name').val(unit); // Set unit
        $('#category').val(category); // Set category
    });

    // Handle modal close to ensure backdrop disappears properly
    $('#updateModal').on('hidden.bs.modal', function () {
        // Manually remove the modal-open class and the backdrop when the modal is hidden
        $('body').removeClass('modal-open');  // Remove the modal open class
        $('.modal-backdrop').remove();       // Remove the backdrop
    });
    
    // Optionally, manually trigger the modal hide if the close button is clicked:
    $(document).on('click', '.close', function() {
        $('#updateModal').modal('hide');  // Hide the modal when the close button is clicked
    });

    // Rebind the events when the table is redrawn (e.g., after pagination)
    table.on('draw', function () {
        // Rebind Edit and Delete button events after pagination
        $(document).on('click', '.deletebtn', function () {
            $('#deleteModal').modal('show');
            var deleteId = $(this).data('id');
            $('#delete_id').val(deleteId);
        });

        $(document).on('click', '.editbtn', function () {
            $('#updateModal').modal('show');
            var updateId = $(this).data('id');
            $('#update_id').val(updateId);

            var productCode = $(this).closest('tr').find('td:eq(0)').text();
            var description = $(this).closest('tr').find('td:eq(3)').html(); // Get HTML (preserve line breaks)
            var unit = $(this).closest('tr').find('td:eq(2)').text();
            var category = $(this).closest('tr').find('td:eq(1)').text();

            $('#product_code').val(productCode);
            $('#description').val(description); // Use .val() to set description properly
            $('#product_name').val(unit);
            $('#category').val(category);
        });
    });

</script>



</script>