<!-- destroying the session that was containing the user information -->
<?php session_start();

session_destroy();
// end destination is main page
header('Location: index.php');

?>