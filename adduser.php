<?php 

include ("config.php");

if(isset($_POST['insertdata']))
{
    $email = $_POST['email'];
    $password = $_POST['password'];
    $usertype = $_POST['usertype'];
    

    $query = "INSERT INTO users(`email`,`password`,`usertype`) VALUES ('$email','$password','$usertype')";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        echo '<script> alert("Data Saved"); </script>';
        header('Location: adminuser.php');
    }
    else
    {
        echo '<script> alert("Data Not Saved"); </script>';
    }
}

?>