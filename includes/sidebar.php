<!-- this page contains the data available on the side bar of the website -->
<div class="well">
<!-- ignites the search page if the submit button is pressed -->
                    <h4>Search</h4>
                    <form method="POST" action="search.php">
                    <div class="input-group">
                        <input name="search" type="text" class="form-control" required>
                        <span class="input-group-btn">
                            <button name="submit" class="btn btn-default" type="submit">
                                <span class="glyphicon glyphicon-search"></span>
                        </button>
                        </span>
                    </div>
                    </form>
                    
                </div>
<!-- ignites the login page if the submit button is pressed -->
<div class="well">
                    <h4>Login</h4>
                    <form method="POST" action="login.php">
                    <div class="">
                         <input name="user_name" type="text" class="form-control" placeholder="Enter Username" required>
                         <br>
                    </div>
                    <div class="input-group">
                        <input name="user_password" type="password" class="form-control" placeholder="Enter Passsword" required>
                        <br>
                        <span class="input-group-btn">
                            <button name="login" class="btn btn-primary" type="submit">
                            Submit
                        </button>
                        </span>
                    </div>
                    </form>
                </div>
<!-- ignites the register page if the submit button is pressed -->
                New to the website |
               <a href="register.php"> Register Here</a>

