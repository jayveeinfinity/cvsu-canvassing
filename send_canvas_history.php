<?php
session_start();  // Start the session to access session variables
include('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $supplier_id = $_POST['supplier_id'];
    $canvas_history_id = $_POST['canvas_history_id'];
    $user_id = $_SESSION['user_id']; // Assuming you're storing the logged-in user's ID in session

    // Debugging to check if all variables are set
    var_dump($supplier_id, $canvas_history_id, $user_id);  // Uncomment for debugging

    // Ensure all fields are provided
    if (!empty($supplier_id) && !empty($canvas_history_id) && !empty($user_id)) {
        // Insert canvas history to the send_to_supply table
        $query = "INSERT INTO send_to_supply (canvas_history_id, supplier_id, canvasser_user_id) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        
        // Check for query preparation error
        if (!$stmt) {
            echo "Error preparing statement: " . $conn->error;
            exit();
        }

        $stmt->bind_param('iii', $canvas_history_id, $supplier_id, $user_id);

        if ($stmt->execute()) {
            echo "Canvas history sent successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "All fields are required.";
    }
}

$conn->close();
?>
