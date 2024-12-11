<?php
include("config.php");

if (isset($_POST['updatedata'])) {
    $id = $_POST['update_id'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $usertype = $_POST['usertype'];

    $query = "UPDATE users SET email='$email', password='$password', usertype='$usertype' WHERE id='$id'";
    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        echo '<script> alert("Data Updated"); </script>';
        header("Location: adminuser.php");
    } else {
        echo '<script> alert("Data Not Updated"); </script>';
    }
}
?>