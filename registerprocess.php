<!-- establishing the connection with the database first -->
<?php include('includes/connection.php');
// <!-- this page ignites when the frm is to be registered
// rechecking if the form is been submmitted
if (isset($_POST['register'])) {
// gump.class.php is used for form validation, a project from the GUMP github
// loading the GUMP file
require "gump.class.php";
// creating the instance
$gump = new GUMP();
// checking for validaiton, retuning with the exception if any
$_POST = $gump->sanitize($_POST); 
// parameters to define the rules of the validation
$gump->validation_rules(array(
	// username must be alphanumeric, max length 20, max length 4
	'username'    => 'required|alpha_numeric|max_len,20|min_len,4',
	// firstname must be alphabetic, max length 30, max length 2
	'firstname'   => 'required|alpha|max_len,30|min_len,2',
	// lastname must be alphabetic, max length 30, max length 1
	'lastname'    => 'required|alpha|max_len,30|min_len,1',
	// username must be a valid email formate
	'email'       => 'required|valid_email',
	// max length 50, min lenght 6
	'password'    => 'required|max_len,50|min_len,6',
));
// setting up the series of more filters
// trim = removes white spaces
// sanitize_string = removes html and php tags
// ensures the email is valid by removing the invalid character and formating orrectly
$gump->filter_rules(array(
	'username' => 'trim|sanitize_string',
	'firstname' => 'trim|sanitize_string',
	'lastname' => 'trim|sanitize_string',
	'password' => 'trim',
	'email'    => 'trim|sanitize_email',
	));
// finally filtering and validating the data with gump and storing it in the validated_data
$validated_data = $gump->run($_POST);
// if any exception has been occured in the validaion then show the errors with the red colors
if($validated_data === false) {
	?>
	<!-- html snippit for making the error in center and in red color -->
	<center><font color="red" > <?php echo $gump->get_readable_errors(true); ?> </font></center>
	<?php 
	// message will be displayed in the resister.php page
	include ('register.php');
}
// validating the password and confirm password is same
else if ($_POST['password'] !== $_POST['cpassword']) 
{
	echo  "<center><font color='red'>Passwords do not match </font></center>";
	include ('register.php');
}
// validation fo username already not exist in the database
else {
      $username = $validated_data['username'];
      $checkusername = "SELECT * FROM users WHERE username = '$username'";
      $run_check = mysqli_query($conn , $checkusername) or die(mysqli_error($conn));
      $count = mysqli_num_rows($run_check); 
      if ($count > 0 ) {
	  echo  "<center><font color='red'>username already taken! try a different one</font></center>";
	  include ('register.php');
	  exit();
}
// again doing the remaining validation
      $firstname = $validated_data['firstname'];
      $lastname = $validated_data['lastname'];
      $email = $validated_data['email'];
      $pass = $validated_data['password'];
	//   making the hast of password so that the middle man attack not occurs
      $password = password_hash("$pass" , PASSWORD_DEFAULT);
	//   saving the data into the database using SQL query
      $query = "INSERT INTO users(username,firstname,lastname,email,password) VALUES ('$username' , '$firstname' , '$lastname' , '$email', '$password')";
    //   checking if the task has been accomplished then show the message on the 
	  $result = mysqli_query($conn , $query) or die(mysqli_error($conn));
	//   showing prompt of successfully registering and reutrnig to the home page
      if (mysqli_affected_rows($conn) > 0) {
      	echo "<script>alert('SUCCESSFULLY REGISTERED');
      	window.location.href='index.php';</script>";
}
// if unable to save data in the sql database then prompt to try again and redirect to the resgistration page again
else {
	echo "<script>alert('An error occured, Try again!');
      	window.location.href='register.php';</script>";
}
}
}
// end destionation is to redirect it on the index page so it not to stay on the validation page
else {
	header('location: register.php');
}
?>
