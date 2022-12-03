<!DOCTYPE html>
<html lang="en">

<?php
    // Common Page Elements that are echoed are used in this file
    include "../php/PageSetUp.php";
    // Server Connection and vital variables are stored here
    include '../php/ServerConnection.php';

    // create head file
    headElement();
?>
 
<body>
    
   <!--Insert Page Navigation-->
   <?php pageNavigation(); ?>

    <!--Page Tittle Section--->
    <div class="header">
        <h1>Derek's Website</h1>
        <p>Welcome to my website</p>
    </div>

    <?php

        
        // init vars
        $post_title = $post_desc = "";
        $login_error = "";

        // posting
        if ($_SERVER["REQUEST_METHOD"] == "POST")
        {
            if(isset($_POST["newPost"]))
            {
                if (isset($_SESSION['user']))
                {
                    // get inputed data
                    $post_title = $_POST["title"];
                    $post_desc = addslashes($_POST["desc"]);

                    // get the time
                    $today = date("Y-m-d h:i:s");
                    echo $today;

                    // set the querry
                    $sql = "INSERT INTO Post (username, timeframe, title, post_desc) VALUES('{$_SESSION['user']}', '$today' ,\"$post_title\", \"$post_desc\");";
                   
                    // insert the post to the database
                    $_SESSION["conn"]->query($sql); 
                } 
                else
                {
                    $login_error = "Login";
                }
            }
        }
    ?>

    <!-- Setting Up A Post -->
    <div class="post-form">
        <h1>Make a post</h1>
        <!-- User Input for the form -->
        <form class="userInput" method = "POST">
            <!-- User Creation Text -->
            <div class="content">
                <!-- Title Input -->
                <div class="input-field">
                    <label>Title</label>
                    <textarea type="text" placeholder="Title" name = "title" maxlength="63"></textarea>
                </div>
                <!-- Description Input -->
                <div class="input-field">
                    <label>Description</label>
                    <textarea type="text" placeholder="Description" name = "desc" maxlength="255"></textarea>
                    <span class="error"><?php echo $login_error ?></span>
                </div>
            </div>
            <!-- Submission -->
            <div class="action">
                <input type="submit" value="Submit" name="newPost">
            </div>
        </form>
    </div>


    <!-- Showing Posts -->
    <div class="post-view">
        <h1>Posts</h1>
        <p>
            Click On A Post to view it
        </p>
        <div class="post-list">
            <?php 
                // querry table
                $sql = "SELECT * FROM Post;";
                $result = $_SESSION["conn"]->query($sql);
                    
                // print table
                if($result->num_rows > 0)
                {
                    // Move through every row
                    while($row = $result->fetch_assoc())
                    {
                        echo "
                        <div class='post-form-selection'> 
                            <h1 id='usernameID'>" . htmlspecialchars($row["username"]) . "</h1>
                            <div class='content'>
                                <div class='view-field'> 
                                    <p id='post-title'>" . htmlspecialchars($row["title"]) . "</p>
                                    <hr style='background: #747474; border: none; height: .5px;'>
                                    <p id='post-desc'>" .
                                        htmlspecialchars($row["post_desc"])
                                    .
                                    "</p>
                                </div>
                            </div>
                            <div class='action'>
                                <button onclick=" . "\"window.location.href='GetPostPage.php?username={$row['username']}&time={$row['timeframe']}'\"" . ">View Post</buton>
                            </div>
                        </div>
                        ";
                    }
                } 
                else
                {
                    echo "<p>No posts at the momment</p>";
                }   

            ?>
        </div>
    </div>

    <!--Insert Page Footer-->
    <?php pageFooter(); ?>
</body>
</html>