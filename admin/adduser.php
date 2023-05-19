<!-- including the files and header plugins -->
<?php
include('includes/connection.php');
include('includes/adminheader.php');
// finding the user role
if (isset($_SESSION['role'])) {
$currentrole = $_SESSION['role'];
}
// restricting the user status to add new user
if ( $currentrole == 'user') {
echo "<script> alert('ONLY ADMIN CAN ADD USER');
window.location.href='./index.php'; </script>";
}
else {// allowing the admins to add the users
if (isset($_POST['add'])) {
require "../gump.class.php";
$gump = new GUMP();
$_POST = $gump->sanitize($_POST); 
// doing validation work when registering the user
$gump->validation_rules(array(
	'username'    => 'required|alpha_numeric|max_len,20|min_len,4',
	'firstname'   => 'required|alpha|max_len,30|min_len,2',
	'lastname'    => 'required|alpha|max_len,30|min_len,1',
	'email'       => 'required|valid_email',
	'password'    => 'required|max_len,50|min_len,6',
));
$gump->filter_rules(array(
	'username' => 'trim|sanitize_string',
	'firstname' => 'trim|sanitize_string',
	'lastname' => 'trim|sanitize_string',
	'password' => 'trim',
	'email'    => 'trim|sanitize_email',
	));
$validated_data = $gump->run($_POST);
// showing error if any in the validation
if($validated_data === false) {
	?>
	<center><font color="red" > <?php echo $gump->get_readable_errors(true); ?> </font></center>
	<?php 
}
else if ($_POST['password'] !== $_POST['cpassword']) 
{
	echo  "<center><font color='red'>Passwords do not match </font></center>";
}
else { // dumping the data in the database
      $username = $validated_data['username'];
      $firstname = $validated_data['firstname'];
      $lastname = $validated_data['lastname'];
      $email = $validated_data['email'];
      $role = $_POST['role'];
      $pass = $validated_data['password'];
      $password = password_hash("$pass" , PASSWORD_DEFAULT);
      $query = "INSERT INTO users(username,firstname,lastname,email,password,role) VALUES ('$username' , '$firstname' , '$lastname' , '$email', '$password' , '$role')";
      $result = mysqli_query($conn , $query) or die(mysqli_error($conn));
      if (mysqli_affected_rows($conn) > 0) {
      	echo "<script>alert('NEW USER SUCCESSFULLY ADDED');
      	window.location.href='index.php';</script>";
}
else {
	echo "<script>alert('An error occured, Try again!');</script>";
}
	}
}
}
?>
<!-- making the ineterface for add user, same as the register new user -->
<!-- this form makes the above logics to be runned when the submit button is been pressed and post method with the name add is been ignite -->
<div id="wrapper">
       <?php include 'includes/adminnav.php';?>
        <div id="page-wrapper">
        <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Add a new user
                        </h1>
<form role="form" action="" method="POST" enctype="multipart/form-data">
	<div class="form-group">
		<label for="user_title">User Name</label>
		<input type="text" name="username" class="form-control" required>
	</div>
	<div class="form-group">
		<label for="user_author">FirstName</label>
		<input type="text" name="firstname" class="form-control" required>
	</div>
	<div class="form-group">
		<label for="user_status">LastName</label>
		<input type="text" name="lastname" class="form-control" required>
	</div>
	<div class="input-group">
		<select class="form-control" name="role" id="">
		    <label for="user_role">Role</label>
			<!-- dropddown same as select -->
		   <?php
			echo "<option value='admin'>Admin</option>";
			echo "<option value='user'>User</option>";
			?>
	    </select>
	</div>
	<br>
	<div class="form-group">
		<label for="user_tag">Email</label>
		<input type="email" name="email" class="form-control" required>
	</div>
	<div class="form-group">
		<label for="user_tag">Password</label>
		<input type="password" name="password" class="form-control" required>
	</div>
	<div class="form-group">
		<label for="user_tag">Confirm Password</label>
		<input type="password" name="cpassword" class="form-control" required>
	</div>
<button type="submit" name="add" class="btn btn-primary" value="Add User">Add User</button>
</form>
</div>
</div>
<!-- including the footer -->
<?php
include('includes/adminfooter.php');
?>
