<!-- including the libraries as well as the plugins -->
<?php include 'includes/header.php';?>
<!-- including the naviation bar -->
<!-- dashboard navbar is the different one as in the main page -->
   <?php include 'includes/navbar.php';?>
    <div class="container">
        <div class="row">
<!-- this is the page content of the search page -->
	        <div class="col-md-8">
            <h1 class="page-header">SEARCH RESULTS</h1>
            <?php
// check if the submit button is been pressed
if (isset($_POST['submit'])) {

	// removes any special charaters from the string in order to get rid of sql injection and htmlspeialchars for XSS attack
	$search = htmlspecialchars(mysqli_real_escape_string($conn, $_POST["search"]));
	// if there is nothing in the search box then keep it on the main page
	if(empty($search)) {
		header('location: index.php');
	}
	// this queryh is to find the post whose tags are matching the searched text
	$query = "SELECT * FROM posts WHERE tag LIKE '%$search%' AND status='published'";
	// executing the SQL query here
	$search_query = mysqli_query($conn, $query) or die(mysqli_error($conn));
	// finding the no of posts found
	$count = mysqli_num_rows($search_query);
	// if no result found then prompt not found
	if ($count == 0) {
		echo "<h1>Sorry, no result found for your query</h1>";
	} else {
		// showing all the posts found in the query
		while ($row = mysqli_fetch_array($search_query)) {
			$post_title = $row['title'];
			$post_id = $row['id'];
			$post_author = $row['author'];
			$post_date = $row['postdate'];
			$post_image = $row['image'];
			$post_content = $row['content'];
			$post_tags = $row['tag'];
			$post_status = $row['status'];
			?>
	        	<p><h2><a href="#"><?php echo $post_title; ?></a></h2></p>
	        	<p><h3>by <a href="#"><?php echo $post_author; ?></a></h3></p>
	        	<p><span class="glyphicon glyphicon-time"></span>Posted on <?php echo $post_date; ?></p>
	        	<hr>
	        	<img class="img-responsive img-rounded" src="AllImgOfpost/<?php echo $post_image; ?>" alt="900 * 300">
	        	<hr>
	        	<p><?php echo substr($post_content, 0, 300) . '.........'; ?></p>
	        		<a href="post.php?post=<?php echo $post_id; ?>"><button type="button" class="btn btn-primary">Read More<span class="glyphicon glyphicon-chevron-right"></span></button></a>
	        	<hr>
	        	<?php }
	}
}
// end destination is main page
else {
	header("location: index.php");
}
?>
	        	<hr>
				<!-- buttons to the previous and next pages, for further modification -->
	        	<ul class="pager">
				  <li class="previous"><a href="#"><span class="glyphicon glyphicon-arrow-left"></span> Older</a></li>
				  <li class="next"><a href="#">Newer <span class="glyphicon glyphicon-arrow-right"></span></a></li>
				</ul>
	        </div>
	        <div class="col-md-4">
<!-- side bar also included -->
               <?php include 'includes/sidebar.php';?>
	        </div>
        </div>
<!-- including the footer -->
        <?php include 'includes/footer.php';?>
<!-- inluding jquery and bootstrape plugins -->
    </div>
  <script src="js/jquery.js"></script>
  <script src="js/bootstrap.min.js"></script>

</body>
</html>