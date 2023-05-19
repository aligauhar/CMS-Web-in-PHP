<!-- including the header as well as navigation bar same as the main page -->
<?php include 'includes/header.php';?>
<?php include 'includes/navbar.php';?>
<!-- it does the same work as the index.html page -->
<!-- if it does not found the post ID or the podt id is not numeric then sends it to the main page -->
<?php
if (isset($_GET['post'])) {
    $post = $_GET['post'];
    if (!is_numeric($post)) {
      header("location:index.php");
    } 
}
else {
    header('location: index.php');
}
// here the fetching and displaying is been done by the same procedure as done in the main page
$query = "SELECT * FROM posts WHERE id=$post";
$run_query = mysqli_query($conn, $query) or die(mysqli_error($conn)) ;
// if no post availae then redirect it to main 
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
    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <!-- Blog Post Content Column -->
            <div class="col-lg-8">
                <!--First Post -->
                <hr>
	       		<p><h2><a href="#"><?php echo $post_title; ?></a></h2></p>
                <p><h3>by <a href="#"><?php echo $post_author; ?></a></h3></p>
                <p><span class="glyphicon glyphicon-time"></span>Posted on <?php echo $post_date; ?></p>
                <hr>
                <img class="img-responsive img-rounded" src="AllImgOfpost/<?php echo $post_image; ?>" alt="900 * 300">
                <hr>
                <p><?php echo $post_content; ?></p>

                <hr>
                <?php }} else { header("location: index.php"); } ?>
    </div>
            <!-- incuding the side bar and footer same as others -->
            <div class="col-md-4">
               <?php include 'includes/sidebar.php';?>
            </div>
        </div>
        <hr>
       <?php include 'includes/footer.php';?>

    </div>
    <!-- includind plugins as others -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>