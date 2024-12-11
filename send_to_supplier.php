<?php
include('config.php');

if (isset($_GET['ref_no'])) {
    $query = "SELECT * FROM quotations WHERE ref_no = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $_GET['ref_no']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    
    if (!$row) {
        echo "Quotation not found.";
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $supplier_id = $_POST['supplier_id'];
        $ref_no = $row['ref_no'];
        $submission_deadline = $row['submission_deadline'];
        $delivery_period = $row['delivery_period'];
        $approved_budget = $row['approved_budget'];

        if (!empty($supplier_id)) {
            // Check if the supplier exists
            $supplier_check_query = "SELECT * FROM suppliers WHERE id = ?";
            $stmt = mysqli_prepare($conn, $supplier_check_query);
            mysqli_stmt_bind_param($stmt, "i", $supplier_id);
            mysqli_stmt_execute($stmt);
            $supplier_result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($supplier_result) == 0) {
                echo "Invalid supplier ID.";
                exit;
            }

            // Insert the sent quotation data
            $query = "INSERT INTO sent_quotations (user_id, ref_no, submission_deadline, delivery_period, approved_budget)
                      VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "issss", $supplier_id, $ref_no, $submission_deadline, $delivery_period, $approved_budget);

            if (mysqli_stmt_execute($stmt)) {
                echo "Quotation successfully sent to supplier!";
            } else {
                echo "Error sending quotation: " . mysqli_error($conn);
            }
        } else {
            echo "Please select a supplier.";
        }
    }
} else {
    echo "No quotation reference number provided.";
}
?>
