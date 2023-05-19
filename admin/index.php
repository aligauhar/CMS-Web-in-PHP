<!-- conecting the page tp the SQL server -->
<?php include 'includes/adminheader.php';?>
    <div id="wrapper">  
           <!-- including the navigation page of admin panel -->
       <?php include 'includes/adminnav.php';?>
        <div id="page-wrapper">
            <div class="container-fluid">             
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to Content Management System ---
                             <!-- showing the users first name -->
                            <?php echo $_SESSION['firstname']; ?>
                        </h1>
                    </div>
                </div>       
                <div class="row">
                    <div class="col-md-6 col-lg-3">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-file-text fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9">
                                    <?php
                                    // finding the total no of posts in the table
                                        $query = "SELECT * FROM posts";
                                        // connecting to database
                                        $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
                                        // counting no of rows
                                        $post_num = mysqli_num_rows($result);
                                        // showing total posts
                                        echo "<div class='text-right huge'>{$post_num}</div>";
                                        ?>
                                        <div class="text-right">Posts</div>

                                    </div>
                                </div>
                            </div>
                            <!-- link, to view all the posts youposted -->
                            <a href="posts.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View All Posts</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-users fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9">
                                        <?php
                                        // finding total no of users
                                        $query = "SELECT * FROM users";
                                        // connecting to database
                                        $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
                                        // counting no of users
                                        $user_num = mysqli_num_rows($result);
                                        echo "<div class='text-right huge'>{$user_num}</div>";
                                        ?>
                                        <div class="text-right">Users</div>

                                    </div>
                                </div>
                            </div>
                            <!-- showing all the users in user.php -->
                            <a href="users.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View All Users</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                   
            </div>
            
        </div>
    <!-- footer and extenions are included -->
   <?php 'includes/adminfooter.php';?>
    </div>
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
