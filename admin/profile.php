<!-- from the Dashboard here -->
<!-- establishing DataBase connection and plugins -->
<?php
include ('includes/connection.php');
include ('includes/adminheader.php');
// getting the data against the user profile
if (isset($_SESSION['username'])) {
	$username = $_SESSION['username'];
	$query = "SELECT * FROM users WHERE username = '$username'" ; 
	$result= mysqli_query($conn , $query) or die (mysqli_error($conn));
	if (mysqli_num_rows($result) > 0 ) {
		$row = mysqli_fetch_array($result);
		$userid = $row['id'];
		$usernm = $row['username'];
		$userpassword = $row['password'];
		$useremail = $row['email'];
		$userfirstname = $row['firstname'];
		$userlastname = $row['lastname'];
	}
	// see when the update parameter has been passed
if (isset($_POST['update'])){
require "../gump.class.php";
$gump = new GUMP();
$_POST = $gump->sanitize($_POST); 
// validating the inputs
$gump->validation_rules(array(
	'firstname'   => 'required|alpha|max_len,30|min_len,2',
	'lastname'    => 'required|alpha|max_len,30|min_len,1',
	'email'       => 'required|valid_email',
	'currentpassword' => 'required|max_len,50|min_len,6',
	'newpassword'    => 'max_len,50|min_len,6',
));
$gump->filter_rules(array(
	'firstname' => 'trim|sanitize_string',
	'lastname' => 'trim|sanitize_string',
	'currentpassword' => 'trim',
	'newpassword' => 'trim',
	'email'    => 'trim|sanitize_email',
	));
	// showing error if any
$validated_data = $gump->run($_POST);
if($validated_data === false) {
	?>
	<center><font color="red" > <?php echo $gump->get_readable_errors(true); ?> </font></center>
	<?php
}
// validating passwords matches the esisting one
else if (!password_verify($validated_data['currentpassword'] ,  $userpassword))   
{
	echo  "<center><font color='red'>Current password is wrong! </font></center>";
}
// if password field is empty then update the rets because password changing is not necessary
else if (empty($_POST['newpassword'])) {
	$userfirstname = $validated_data['firstname'];
      $userlastname = $validated_data['lastname'];
      $useremail = $validated_data['email'];
      $updatequery1 = "UPDATE users SET firstname = '$userfirstname' , lastname='$userlastname' , email='$useremail' WHERE id = '$userid' " ;
      $result2 = mysqli_query($conn , $updatequery1) or die(mysqli_error($conn));
if (mysqli_affected_rows($conn) > 0) {
	echo "<script>alert('PROFILE UPDATED SUCCESSFULLY');</script>";
}
else {
	echo "<script>alert('An error occured, Try again!');</script>";
}
}
else if (isset($_POST['newpassword']) &&  ($_POST['newpassword'] !== $_POST['confirmnewpassword'])) 
{
	echo  "<center><font color='red'>New password and Confirm New password do not match </font></center>";
	
}
else { // else if the passsword is also been set to updated then also update the password
      $userfirstname = $validated_data['firstname'];
      $userlastname = $validated_data['lastname'];
      $useremail = $validated_data['email'];
      $pass = $validated_data['newpassword'];
      $userpassword = password_hash("$pass" , PASSWORD_DEFAULT);
$updatequery = "UPDATE users SET password = '$userpassword', firstname='$userfirstname' , lastname= '$userlastname' , email= '$useremail' WHERE id='$userid'";
$result1 = mysqli_query($conn , $updatequery) or die(mysqli_error($conn));
if (mysqli_affected_rows($conn) > 0) {
	echo "<script>alert('PROFILE UPDATED SUCCESSFULLY');</script>";
}
else {
	echo "<script>alert('An error occured, Try again!');</script>";
}
}
}
}
?>
<div id="wrapper">

<!-- generating the form to update the user profile -->
<?php include 'includes/adminnav.php';?>
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to your Profile | 
                            <?php echo $_SESSION['firstname']; ?>
                        </h1>
<form role="form" action="" method="POST" enctype="multipart/form-data">
<div class="form-group">
	<!-- fetching user name and display -->
		<label for="user_title">User Name</label>
		<input type="text" name="username" class="form-control" value="<?php echo $username; ?>" readonly>
	</div>
	<!-- fetching first name and display -->
	<div class="form-group">
		<label for="user_author">FirstName</label>
		<input type="text" name="firstname" class="form-control" value="<?php echo $userfirstname; ?>" required>
	</div>
	<!-- fetching last name and display -->
	<div class="form-group">
		<label for="user_status">LastName</label>
		<input type="text" name="lastname" class="form-control" value="<?php echo $userlastname; ?>" required>
	</div>
	<!-- fetching email name and display -->
	<div class="form-group">
		<label for="user_tag">Email</label>
		<input type="email" name="email" class="form-control" value="<?php echo $useremail; ?>" required>
	</div>
	<!-- not displaying the password -->
	<div class="form-group">
		<label for="usertag">Current Password</label>
		<input type="password" name="currentpassword" class="form-control" placeholder="Enter Current password" required>
	</div>
	<div class="form-group">
		<label for="usertag">New Password <font color='brown'> (changing password is optional)</font></label>
		<input type="password" name="newpassword" class="form-control" placeholder="Enter New Password">
	</div>
	<div class="form-group">
		<label for="usertag">Confirm New Password</label>
		<input type="password" name="confirmnewpassword" class="form-control" placeholder="Re-Enter New Password" >
	</div>
<hr>
<!-- when pressing the button of the updaate user then it will validate the input and update it in the database -->
<button type="submit" name="update" class="btn btn-primary" value="Update User">Update User</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- including the footer and plugins -->
   <?php 'includes/admin_footer.php';?> 
    </div> 
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>

</html>







