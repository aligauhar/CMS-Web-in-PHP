<!-- adding the header -->
<?php include 'includes/adminheader.php';?>
    <div id="wrapper">
       <?php include 'includes/adminnav.php';?>

        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            PUBLISH Content 
                        </h1>
<?php
// if the post is set to be published
if (isset($_POST['publish'])) {
    // check for validations
require "../gump.class.php";
$gump = new GUMP();
// cleaning and validating the post data
$_POST = $gump->sanitize($_POST); 

$gump->validation_rules(array(
    // title must be of 15 to 120 characters
    'title'    => 'required|max_len,120|min_len,15',
    // tag mist be of 3 to 100 characters
    'tags'   => 'required|max_len,100|min_len,3',
    // content mist be of 150 to 20000 character
    'content' => 'required|max_len,20000|min_len,150',
));
// filtering and validating the errors
$gump->filter_rules(array(
    'title' => 'trim|sanitize_string',
    'tags' => 'trim|sanitize_string',
    ));
$validated_data = $gump->run($_POST);
// show errors for validation failed
if($validated_data === false) {
    ?>
    <center><font color="red" > <?php echo $gump->get_readable_errors(true); ?> </font></center>
    <?php 
    $post_title = $_POST['title'];
      $post_tag = $_POST['tags'];
      $post_content = $_POST['content'];
}
// if validation passed
else {
    $post_title = $validated_data['title'];
      $post_tag = $validated_data['tags'];
      $post_content = $validated_data['content'];
    //   for escaping the special characters
      $post_content = mysqli_real_escape_string($conn, $validated_data['content']);

    //   check if the session is still esablished
if (isset($_SESSION['firstname'])) {
        $post_author = $_SESSION['firstname'];
    }
    // auto fetchig the date
    $post_date = date('Y-m-d');
    // saving it as draft untill the super admin publishes it
    $post_status = 'draft';
    // retriving the image name
    $image = $_FILES['image']['name'];
    // retriving the image type and validating if its formate
    $ext = $_FILES['image']['type'];
    $validExt = array ("image/gif",  "image/jpeg",  "image/pjpeg", "image/png");
    // prompt to add image necessary
    if (empty($image)) {
    echo "<script>alert('Attach an image');</script>";
    }
    // validating the image size less then 1 MB
    else if ($_FILES['image']['size'] <= 0 || $_FILES['image']['size'] > 1024000 )
    {
    echo "<script>alert('Image size is not proper, must be less then 1 MB');</script>";
    }
    else if (!in_array($ext, $validExt)){
        echo "<script>alert('Not a valid image type use: gif, jpeg, pjpeg, png');</script>";

    }
    else {
        // if validated then save in the AllImgOfpost folder
        $folder  = '../AllImgOfpost/';
        // use to retrive the file extension
        $imgext = strtolower(pathinfo($image, PATHINFO_EXTENSION) );
        // generating the id of the image between 1000 to 1000000 to be saved with 
        $picture = rand(1000 , 1000000) .'.'.$imgext;
        // moves the file from the temporary folder to the AllImgOfpost folder with the name and extension specified
        if(move_uploaded_file($_FILES['image']['tmp_name'], $folder.$picture)) {
            // if successfully saved in the folder then update the name of image in the database
            // id and updated on automatically generated in the Database
            $query = "INSERT INTO posts (title,author,postdate,image,content,status,tag) VALUES ('$post_title' , '$post_author' , '$post_date' , '$picture' , '$post_content' , '$post_status', '$post_tag') ";
            // connecting to dattabase
            $result = mysqli_query($conn , $query) or die(mysqli_error($conn));
            // check if the new row has been added then prompt message
            if (mysqli_affected_rows($conn) > 0) {
                echo "<script> alert('News posted successfully.It will be published after admin approves it');
                window.location.href='posts.php';</script>";
            }
            else {
                "<script> alert('Error while posting..try again');</script>";
            }
        }
    }
}
}
?>

<form role="form" action="" method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <!-- fetching the post title -->
        <label for="post_title">Post Title</label>
        <input type="text" name="title" placeholder = "ENTER TITLE " value= "<?php if(isset($_POST['publish'])) { echo $post_title; } ?>"  class="form-control" required>
    </div>
    <!-- fetching the post image -->
    <div class="form-group">
        <label for="post_image">Post Image </label> <font color='brown' > &nbsp;&nbsp;(Allowed image size: 1024 KB) </font> 
        <input type="file" name="image" >
    </div>
    <!-- fetching the post tags -->
    <div class="form-group">
        <label for="post_tag">Post Tags</label>
        <input type="text" name="tags" placeholder = "ENTER SOME TAGS SEPERATED BY COMMA (,)" value= "<?php if(isset($_POST['publish'])) { echo $post_tag; } ?>" class="form-control" >
 
<!-- -------------------------------------------------This code holds the drag and drop technique --------------------------------- -->
<head>
    <script src="https://cdn.jsdelivr.net/npm/dropzone@5.9.3/dist/dropzone.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/dropzone@5.9.3/dist/dropzone.css" />
</head>
<textarea class="form-control" placeholder = file_text name="content"  id="content" cols="30" rows="15" ><?php if(isset($_POST['publish'])) { echo $post_content; } ?></textarea>
   
<div id="drop-zone" style="width: 200px; height: 200px; border: 2px dashed gray;">
    <p >Drag and drop a file here to be added in the text area.</p>
</div>
<script>
   var fileText;
var dropZone = document.getElementById('drop-zone');

dropZone.addEventListener('dragover', function(e) {
    e.preventDefault();
    dropZone.classList.add('dragover');
});

dropZone.addEventListener('dragleave', function() {
    dropZone.classList.remove('dragover');
});

dropZone.addEventListener('drop', function(e) {
    e.preventDefault();
    dropZone.classList.remove('dragover');
    
    var file = e.dataTransfer.files[0];
    var reader = new FileReader();

    reader.onload = function() {
        fileText = reader.result;
        var editor = tinymce.get('content');
        editor.setContent(fileText);
        confirm("You file text will be added in the text area!");
    };

    reader.readAsText(file);
});

</script>

<!-- ---------------------------------------------------------------------------------------------------------------- -->
   </div>
    <!-- publish post button -->
<button type="submit" name="publish" class="btn btn-primary" value="Publish Post">Publish Post</button>
</form>
 </div>
                </div>      
            </div>
        </div>
        <!-- adding footer and plugins -->
   <?php 'includes/admin_footer.php';?> 
    </div>
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
