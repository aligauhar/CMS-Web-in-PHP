<!-- for establishing the connection to database -->
<?php
$conn = mysqli_connect("localhost","root","","cmsdatabase" ) or die ("error" . mysqli_error($conn));
?>