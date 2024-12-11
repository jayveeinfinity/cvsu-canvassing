<?php
include("config.php");

// Fetch a record from the canvas_history table to test
$id = 18; // Use a valid ID or pass it via URL like $_GET['id']
$query = "SELECT * FROM canvas_history WHERE id = '$id'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

if (!$row) {
    echo "No history found for ID: $id";
    exit;
}

// Display the raw items field (it should be a JSON string)
echo "<h2>Raw 'items' Field:</h2>";
echo "<pre>" . $row['items'] . "</pre>"; // Shows the JSON string stored in the 'items' field

// Decode the JSON data from the 'items' field
$items = json_decode($row['items'], true);

// Check if json_decode was successful
if ($items === null) {
    echo "<p>Error decoding JSON or no items found in the 'items' field.</p>";
} else {
    // Display the decoded items
    echo "<h2>Decoded 'items' Data:</h2>";
    echo "<pre>";
    print_r($items); // Print the decoded items array
    echo "</pre>";
}

?>
