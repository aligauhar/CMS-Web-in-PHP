<!-- establishing connection to database and including the header -->
<?php include 'includes/connection.php';?>
<?php include 'includes/adminheader.php';?>
<?php
// check of the id has been set
if (isset($_GET['id'])) {
	$id = mysqli_real_escape_string($conn, $_GET['id']);  
}
else {
	header('location:posts.php');
}
// setting the enviornment according to user caliber
$currentuser = $_SESSION['username'];
if ($_SESSION['role'] == 'superadmin') {
    // if its edmin, he can edit all the posts
$query = "SELECT * FROM posts WHERE id='$id'";
}
else {
    // if not the superadmin then can edit only his posts
    $query = "SELECT * FROM posts WHERE id='$id' AND author = '$currentuser'" ;
}
$run_query = mysqli_query($conn, $query) or die(mysqli_error($conn));
if (mysqli_num_rows($run_query) > 0 ) {
// getting the file to be editted
while ($row = mysqli_fetch_array($run_query)) {
	$post_title = $row['title'];
	$post_id = $row['id'];
	$post_author = $row['author'];
	$post_date = $row['postdate'];
	$post_image = $row['image'];
	$post_content = $row['content'];
	$post_tags = $row['tag'];
	$post_status = $row['status'];
// check if the update parameter is  been set
if (isset($_POST['update'])) {
require "../gump.class.php";
$gump = new GUMP();
$_POST = $gump->sanitize($_POST); 
// vlidating the parameters
$gump->validation_rules(array(
    'title'    => 'required|max_len,120|min_len,15',
    'tags'   => 'required|max_len,100|min_len,3',
    'content' => 'required|max_len,10000|min_len,150',
));
$gump->filter_rules(array(
    'title' => 'trim|sanitize_string',
    'tags' => 'trim|sanitize_string',
    ));
$validated_data = $gump->run($_POST);
// if not validated show error
if($validated_data === false) {
    ?>
    <center><font color="red" > <?php echo $gump->get_readable_errors(true); ?> </font></center>
    <?php 
}
// if validated then update the data
else {
    $post_title = $validated_data['title'];
      $post_tag = $validated_data['tags'];
      $post_content = $validated_data['content'];
    $post_date = date('Y-m-d');
    if ($_SESSION['role'] == 'user') {
    	$post_status = 'draft';
    } else {
    $post_status = $_POST['status'];
}
// validating the image
    $image = $_FILES['image']['name'];
    $ext = $_FILES['image']['type'];
    $validExt = array ("image/gif",  "image/jpeg",  "image/pjpeg", "image/png");
    if (empty($image)) {
    	$picture = $post_image;
    }
    else if ($_FILES['image']['size'] <= 0 || $_FILES['image']['size'] > 1024000 )
    {
echo "<script>alert('Image size is not proper: max 1 MB alowed');
window.location.href = 'editposts.php?id=$id';</script>";
    
    }
    else if (!in_array($ext, $validExt)){
        echo "<script>alert('Not a valid image: file formate not supported');
        window.location.href = 'editposts.php?id=$id';</script>";
    exit();
    }
    else {
        $folder  = '../AllImgOfpost/';
        $imgext = strtolower(pathinfo($image, PATHINFO_EXTENSION) );
        $picture = rand(1000 , 1000000) .'.'.$imgext;
        move_uploaded_file($_FILES['image']['tmp_name'], $folder.$picture);
    }
        // saving the image in the directory and the data base
                // Assume that $post_content contains the string with apostrophes
        $post_content_escaped = mysqli_real_escape_string($conn, $post_content);
        // Construct the SQL query using the escaped string
        $queryupdate = "UPDATE posts SET title = '$post_title', tag = '$post_tag', content='$post_content_escaped', status = '$post_status', image = '$picture', postdate = '$post_date' WHERE id = '$post_id'";
        // Execute the query and check for errors
        $result = mysqli_query($conn, $queryupdate) or die(mysqli_error($conn));
        if (mysqli_affected_rows($conn) > 0) {
        	echo "<script>alert('POST SUCCESSFULLY UPDATED');
        	window.location.href= 'posts.php';</script>";
        }
        else {
        	echo "<script>alert('Error! ..try again');</script>";
}
}
}
}
}
?>
<div id="wrapper">
    <!-- including the navigation bar -->
       <?php include 'includes/adminnav.php';?>
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            UPDATE Content 
                        </h1>
                        <!-- action to the same form -->
                        <form role="form" action="" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="post_title">Post Title</label>
                            <!-- fetching the title from the database to show for the edit part -->
                            <input type="text" name="title" class="form-control" value="<?php echo $post_title;  ?>">
                        </div>
                            <!-- fetching the Tags from the database to show for the edit part -->
                        <div class="form-group">
                            <label for="post_tags">Post Tags</label>
                            <input type="text" name="tags" class="form-control" value="<?php echo  $post_tags; ?>">
                        </div>
                            <!--if the role is user then showing the status option only as draft-->
                            <!--if the admin is user then showing the status option only as the status already is-->
                        <div class="input-group">
                            <label for="post_status">Post Status</label>
                                <select name="status" class="form-control">
                                <?php if($_SESSION['role'] == 'user') { echo "<option value='draft' >draft</option>"; } else { ?> 
                            <option value="<?php  echo $post_status; ?>"><?php  echo  $post_status;  ?></option>>
                                <?php
                                // here showing the remaining one against used one
                            if ($post_status == 'published') {
                                echo "<option value='draft'>Draft</option>";
                            } else {
                                echo "<option value='published'>Publish</option>";
                            }
                            ?>
                            <?php
                            }
                            ?>
                            </select>
                                </div>
                            <!-- fetching the image -->
                            <div class="form-group">
                                <label for="post_image">Post Image</label>
                                <img class="img-responsive" width="200" src="../AllImgOfpost/<?php echo $post_image; ?>" alt="Photo">
                                <input type="file" name="image"> 
                            </div>
                            <div class="form-group">
                                <!-- Feching the content -->
                                <label for="post_content">Post Content</label>
                                <textarea  class="form-control" name="content" id="" cols="30" rows="10"><?php  echo $post_content;  ?>
                                </textarea>
                            </div>
                            <!-- button to upate the posts by passing POST["update"] -->
                            <button type="submit" name="update" class="btn btn-primary" value="Update Post">Update Post</button>
                            </form>
                    </div>
                </div>
            </div>
        </div>
</div>
<!-- adding plugins -->
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>

</body>

</html>

