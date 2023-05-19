<!-- connection to the database -->
<?php
// whenever new login occurs a session is been generated
include('connection.php');
session_start();
// if the role of the session is been set then proceed
if (isset($_SESSION['role'])) {
	
}
else {
    echo "<script>alert('you need to login first');
    window.location.href='../index';</script>";	
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- giving the title -->
    <title>Dashboard - <?php echo $_SESSION['username']; ?></title>
    <!-- adding the plugins -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/tinymce/tinymce.min.js"></script>
    <script src="js/tinymce/script.js"></script>
    <!-- adding bootstrap css for admin-->
    <link href="css/sb-admin.css" rel="stylesheet">

</head>

<body>
