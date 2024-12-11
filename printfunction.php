<?php 
include("config.php");

if(isset($_POST['save'])) {
    $input_one = $_POST['input_one'];
    $input_two = $_POST['input_two'];
    $input_three = $_POST['input_three'];
    $input_four = $_POST['input_four'];
    $input_five = $_POST['input_five'];
    $selectedName = $_POST['selected_name'];
    $selectedRole = $_POST['selected_role'];

    $query = "INSERT INTO comments(`input_one`, `input_two`, `input_three`,`input_four`,`input_five`, `selected_name`, `selected_role`) 
    VALUES ('$input_one', '$input_two', '$input_three','$input_four','$input_five','$selectedName','$selectedRole')";
    $query_run = mysqli_query($conn, $query);

    if($query_run) {
        echo '<script> alert("Data Saved"); </script>';
        header('Location: print.php');
    } else {
        echo '<script> alert("Data Not Saved"); </script>';
    }
}
?>
