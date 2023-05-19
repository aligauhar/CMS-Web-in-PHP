<!-- adding the connection.php to connect to the sql database -->
<?php include 'includes/connection.php';?>
<!-- containing all the libraries and plugins we gona use throughout the project -->
<?php include 'includes/header.php';?>
<!-- this incldes the upper part of the website -->
<!-- NEWS-BUZZ | About Us | Trending News | Register | Toggle button-->
<?php include 'includes/navbar.php';?>      
<div class="container">
        <div class="row"> 
	      <div class="col-md-8">
<!-- retriving all the published posts -->
<!-- the last one will be on the bottom as descending -->
<?php $query = "SELECT * FROM posts WHERE status='published' ORDER BY updated_on DESC";
// executing the SQL query here
$run_query = mysqli_query($conn, $query) or die(mysqli_error($conn));
// executing the code till al the data has been retrived
if (mysqli_num_rows($run_query) > 0) {
// loop through the resultant set returned by MSQL
while ($row = mysqli_fetch_assoc($run_query)) {
  $post_title = $row['title'];
  $post_id = $row['id'];
  $post_author = $row['author'];
  $post_date = $row['postdate'];
  $post_image = $row['image'];
  $post_content = $row['content'];
  $post_tags = $row['tag'];
  $post_status = $row['status'];
  // if the data has been published then 
  if ($post_status !== 'published') {
    echo "NO POST PLS";
  } else {
    ?>
    <!-- The post's title is displayed as a link that directs to the full post -->
<p><h2><a href="publicposts.php?post=<?php echo $post_id; ?>"><?php echo $post_title; ?></a></h2></p>
            <!-- The author's name is displayed  -->
            <p><h3>by <a href="#"><?php echo $post_author; ?></a></h3></p>
            <!-- posted time -->
            <p><span class="glyphicon glyphicon-time"></span>Posted on <?php echo $post_date; ?></p>
            <hr><a href="publicposts.php?post=<?php echo $post_id; ?>">
            <!-- showing post image -->
            <img class="img-responsive img-rounded" src="AllImgOfpost/<?php echo $post_image; ?>" alt="900 * 300"></a>
            <hr>
            <!-- showing content of the post followed by the read more option -->
            <p><?php echo substr($post_content, 0, 300) . '.........'; ?></p>
            <a href="publicposts.php?post=<?php echo $post_id; ?>"><button type="button" class="btn btn-primary">Read More<span class="glyphicon glyphicon-chevron-right"></span></button></a>
            <hr>
            
            <?php }}}?>

            <hr>
            <!-- these are the button for the moving to the page back and forth but for now they go no where -->
            <ul class="pager">
          <li class="previous"><a href="#"><span class="glyphicon glyphicon-arrow-left"></span> Older</a></li>
          <li class="next"><a href="#">Newer <span class="glyphicon glyphicon-arrow-right"></span></a></li>
        </ul>
          </div>
	        
	        <div class="col-md-4">
              <!-- this is the page to show the right side of the page of the cms -->
              <!-- it includes login and register options -->
               <?php include 'includes/sidebar.php';?>

	        </div>
	        
        </div>

        <!-- contining the footer of copyright and name -->
        <?php include 'includes/footer.php';?>
        
    </div>
    <!-- follows to the plugins of bootstrape , event handling, animation, and Ajax interactions -->
  <script src="js/jquery.js"></script>
  <script src="js/bootstrap.min.js"></script>

</body>
</html>