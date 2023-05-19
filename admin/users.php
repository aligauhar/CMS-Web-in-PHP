<!-- followed from the user dashboard -->
<!-- connecting the database and plugins -->
<?php include ('includes/connection.php'); 
include "includes/adminheader.php";
// finding the role fo the user
if (isset($_SESSION['role'])) {
$currentrole = $_SESSION['role'];
}
// the users can be see by the Admins only
if ( $currentrole == 'user') {
echo "<script> alert('ONLY ADMIN CAN VIEW USERS');
window.location.href='./index.php'; </script>";
}
// if it is supper user then show all the user with the rights of making them admin and also removing them
else if ($currentrole == 'superadmin') {
    ?>
    <div id="wrapper">
        <!-- adding the navigation bar -->
    <?php include "includes/adminnav.php"; ?>
        <div id="page-wrapper">
            <div class="container-fluid"> 
                <div class="row">
                    <div class="col-lg-12"> 
                        <h1 class="page-header">
                            All Users
                        </h1>
    <table class="table table-bordered table-hover">
    <thead>
        <!-- making the table to show the users data in the table form -->
        <tr>
            <th>Id</th>
            <th>Username</th>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Email</th>
            <th>Role</th>
            <th>Change Role</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody> 
        <?php 
            // fetching the all users data from the database and showing it in the table
            $query = "SELECT * FROM users";
            $select_users = mysqli_query($conn, $query) or die(mysqli_error($conn));
            if (mysqli_num_rows($select_users) > 0 ) {
            while ($row = mysqli_fetch_array($select_users)) {
                $user_id = $row['id'];
                $username = $row['username'];
                $user_firstname = $row['firstname'];
                $user_lastname = $row['lastname'];
                $user_email = $row['email'];
                $user_role = $row['role'];
                echo "<tr>";
                echo "<td>$user_id</td>";
                echo "<td>$username</td>";
                echo "<td>$user_firstname</td>";
                echo "<td>$user_lastname</td>";
                echo "<td>$user_email</td>";
                echo "<td>$user_role</td>";
                // a query to make a user to admin level
                echo "<td><a href='users.php?change_to_admin=$user_id''>MAKE Admin</a></td>";
            // here the delete parameter will be pass by using redirecting to the same page with the user i and delete method
                echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete this user?')\" href='users.php?delete=$user_id'><i class='fa fa-times fa-lg'></i>delete</a></td>";
                echo "</tr>";
             }
        ?>

    </tbody>
 </table>

<?php 
}
// if the delete variable has been bassed in the form them delete the row with the user id
    if (isset($_GET['delete'])) {
        $the_user_id = $_GET['delete'];
        $query0 = "SELECT role FROM users WHERE id = '$the_user_id'";
        $result = mysqli_query($conn , $query0) or die(mysqli_error($conn));
        if (mysqli_num_rows($result) > 0 ) {
            $row = mysqli_fetch_array($result);
            $id1 = $row['role'];
        }
        // checking if the user to be deleted is a super admin then prompt error
        if ($id1 == 'superadmin') {
            echo "<script>alert('super-admin cannot be deleted');</script>";
        }
        else {
            // else delete the user or admin
        $query = "DELETE FROM users WHERE id = '$the_user_id'";
        $delete_query = mysqli_query($conn, $query) or die (mysqli_error($conn));
        if (mysqli_affected_rows($conn) > 0 ) {
            echo "<script>alert('user deleted successfully');
            window.location.href= 'users.php';</script>";
        }
    }
}
//  see if the page is been redirected by the change to admin role parameter 
    if (isset($_GET['change_to_admin'])) {
        $the_user_id = $_GET['change_to_admin'];
        // find the user that is been said to hange the role
        $query0 = "SELECT role FROM users WHERE id = '$the_user_id'";
        $result = mysqli_query($conn , $query0) or die(mysqli_error($conn));
        if (mysqli_num_rows($result) > 0 ) {
            $row = mysqli_fetch_array($result);
            $id1 = $row['role'];
        }
        // check if the user is aready admin
        if ($id1 == 'admin') {
            echo "<script>alert('USER IS ALREADY ADMIN');</script>";
        }
        // check the user is a super admin
        else if ($id1 == 'superadmin') {
            echo "<script>alert('Cannot change role for super-admin');</script>";
        }
        // if not of the above 2 then make it admin
        else {
        $query = "UPDATE users SET role = 'admin' WHERE id = '$the_user_id'";
        $change_to_admin_query = mysqli_query($conn, $query) or die (mysqli_error($conn));
         if (mysqli_affected_rows($conn) > 0 ) {
            echo "<script>alert('changed to admin successfully');
            window.location.href= 'users.php'; </script>";
        }
    }
}
    ?>
    </div>
 </div>
 </div>
 </div>
 </div>
 <?php 
}
// check if the user is an Admin then he would be able to see the users only
else {
    ?>
    <div id="wrapper">
    <?php include "includes/adminnav.php"; ?>
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            All Users
                        </h1>
    <table class="table table-bordered table-hover">
    <!-- making the table to be shown in the table formate -->
    <thead>
        <tr>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Email</th>
            <th>Role</th>
        </tr>
    </thead>
    <tbody> 
        <!-- fetching the data and showing it  -->
        <?php    
            $query = "SELECT * FROM users";
            $select_users = mysqli_query($conn, $query) or die(mysqli_error($conn));
            if (mysqli_num_rows($select_users) > 0 ) {
            while ($row = mysqli_fetch_array($select_users)) {
                $user_id = $row['id'];
                $username = $row['username'];
                $user_firstname = $row['firstname'];
                $user_lastname = $row['lastname'];
                $user_email = $row['email'];
                $user_role = $row['role'];
                echo "<tr>";
                echo "<td>$user_firstname</td>";
                echo "<td>$user_lastname</td>";
                echo "<td>$user_email</td>";
                echo "<td>$user_role</td>";
                echo "</tr>";
             }
        ?>

    </tbody>
 </table>

<?php 
}
    ?>
    </div>
 </div>
 </div>
 </div>
 </div>

<?php
// adding the footer
}
?>
    <?php include ('includes/adminfooter.php');
    ?>
