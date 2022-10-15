<!DOCTYPE html>
<html>
<!-- 
    To Do:
    Fix style of reply and show response
    Make it so that comment insertions place the text at the correct position i.e make comments displayed where it is supposed to within the post and at the top

    If all is fixed clean code and make it more readible
    Make commenly repeated elements of the code into functions with parameters
    Rearrange files to make this code further easier to access and read our data is getting cluttered
-->
<?php
    // Common Page Elements that are echoed are used in this file
    include "../php/PageSetUp.php";
    
    // Server Connection and vital variables are stored here
    include "../php/ServerConnection.php";

    // javascript for form posting
    include "../js/GetPost.php";

    // backend stuff
    include "../php/GetPost.php";

    // create head file
    headElement();
?>

<body>
    <!--Set up page visual elements-->
    <?php 
        // insert page navigation
        pageNavigation(); 
    
        // print the post
        $displayPost_values = displayPost();
        
        // get post keys
        $post_name = $displayPost_values[0];
        $post_time = $displayPost_values[1];

        displayUserComments($post_name, $post_time);

        // display comments
        displayComments($post_name, $post_time, "null", "null", 0, 5);

        // insert page footer
        pageFooter(); 
    ?>


</body>
</html>