<?php
include('config.php');

if (isset($_POST['save_only'])) {
    if (isset($_POST['unit_price']) && is_array($_POST['unit_price'])) {
        foreach ($_POST['unit_price'] as $item_id => $new_price) {
            $new_price = floatval($new_price); // Validate input

            $update_query = "
                UPDATE canvas_history_items
                SET total_price = ?
                WHERE id = ?";
            $stmt = $conn->prepare($update_query);
            $stmt->bind_param("di", $new_price, $item_id);
            $stmt->execute();
        }
        echo "Prices updated successfully.";
    } else {
        echo "No data to save.";
    }
} else {
    echo "Invalid request.";
}
?>
