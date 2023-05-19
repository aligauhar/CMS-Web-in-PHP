<!--  this page is to valiate the login credintials and generating the session with the user info agains the crediantials -->
<?php
// generating the session key so as when the user login the same crediantials may be used for all the accesses
session_start();
// making the database connection
include('includes/connection.php');
// if login button is pressed
if (isset($_POST['login'])) {
	// fetch the user name and password
	$username  = $_POST['user_name'];
	$password = $_POST['user_password'];
	// application of security pratice to avoide the sql injection
	mysqli_real_escape_string($conn, $username);
	mysqli_real_escape_string($conn, $password);
// finding if any username exist with the asked one
$query = "SELECT * FROM users WHERE username = '$username'";
// passing the query
$result = mysqli_query($conn , $query) or die (mysqli_error($conn));
//  if query passed successfully then fething all the related data
if (mysqli_num_rows($result) > 0) {
	while ($row = mysqli_fetch_array($result)) {
		$id = $row['id'];
		$user = $row['username'];
		$pass = $row['password'];
		$firstname = $row['firstname'];
		$lastname = $row['lastname'];
		$email = $row['email'];
		// finding the user position
		$role= $row['role'];
		// for now image is not been used 
		$image = $row['image'];
		// after that verifying the passwords
		if (password_verify($password, $pass )) {
			// generating the session with the user crediantials
			$_SESSION['id'] = $id;
			$_SESSION['username'] = $user;
			$_SESSION['firstname'] = $firstname;
			$_SESSION['lastname'] = $lastname;
			$_SESSION['email']  = $email;
			$_SESSION['role'] = $role;
			$_SESSION['image'] = $image;
			// redirecting the user to the admin directory inorder to further managing the user personal settings and data as well as rights
			header('location: admin/index.php');
		}
		else {
			// if pasword is not been found in the database then it will generate the error on the main page
			echo "<script>alert('invalid username/password');
			window.location.href= 'index.php';</script>";

		}
	}
}
// if user name is not been found in the database then it will generate the error on the main page
else {
			echo "<script>alert('invalid username/password');
			window.location.href= 'index.php';</script>";

		}
}
// end destination is main page
else {
	header('location: index.php');
}
?>