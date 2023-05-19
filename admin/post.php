<!-- connecting to datbase -->
<?php include 'includes/connection.php';?>
<!-- adding the header and navigation-->
<?php include 'includes/adminheader.php';?>
<?php include 'includes/adminnav.php';?>
<?php
// checking if the post button has been pressed
if (isset($_GET['post'])) {
    // removing the special characters
	$post = mysqli_real_escape_string($conn, $_GET['post']);  
}
else {
    header('location:posts.php');
}


// here the data is been showed according to the author caliber
// fetching the user name from session
$currentuser = $_SESSION['username'];
// if the author is superadmin then he can see all the posts 
// show the post with the id of post clicked
if ($_SESSION['role'] == 'superadmin') {
$query = "SELECT * FROM posts WHERE id='$post'";
}
// if author is not a superadmin then only show the posts agains its firstname
// post will be shown for the id whose show details buttonis been pressed
else {
    $query = "SELECT * FROM posts WHERE id='$post' AND author = '$currentuser'" ;
}
// connecting to the database
$run_query = mysqli_query($conn, $query) or die(mysqli_error($conn));
// getting all the data of the user and showing it 
if (mysqli_num_rows($run_query) > 0 ) {
while ($row = mysqli_fetch_array($run_query)) {
	$post_title = $row['title'];
	$post_id = $row['id'];
	$post_author = $row['author'];
	$post_date = $row['postdate'];
	$post_image = $row['image'];
	$post_content = $row['content'];
	$post_tags = $row['tag'];
	$post_status = $row['status'];
	?>  
    <div id="wrapper">
    <div id="page-wrapper">
    <div class="container-fluid">
    <div class="container">
        <div class="row"> 
            <div class="col-lg-8">  
                <hr>
	       		<p><h2><a href="#"><?php echo $post_title; ?></a></h2></p>
                <p><h3>by <a href="#"><?php echo $post_author; ?></a></h3></p>
                <p><span class="glyphicon glyphicon-time"></span>Posted on <?php echo $post_date; ?></p>
                <hr>
                <!-- getting the image from allpostpicsfolder =-->
                <!-- getting the post image been saved againt the pic number.jpeg defined by post_image -->
                <img class="img-responsive img-rounded" src="../AllImgOfpost/<?php echo $post_image; ?>" alt="900 * 300">
                <hr>
                <p><?php echo $post_content; ?></p>
                <hr>
                <?php } }
                else { echo"<script>alert('error');</script>"; } ?>       	
  </div>
        </div>
        </div>
        </div>
        </div>
        </div>
         <!--adding plugins  -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>