<?php
    include "../php/ServerConnection.php";
    include "../php/GetPost.php";

    // If the action is a form post
    if($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        // checks the type of
        switch($_GET["Type"])
        {
            case "postComment": // posts a comment to the post
                postCommentResponse();
                break;
        }
    }
    else if(isset($_GET["Type"])) // action is not a post and type is set
    {
        // checks the type of response
        switch($_GET["Type"])
        {
            case "showComment": // shows a comment response text (set up for posting a comment)
                createCommentResponse();
                break;
            case "showCommentResponse": // shows comments of comments
                createCommentReplyRespose();
                break;
            case "adjustButtons": // adjusts the input buttons
                adjustButtons();
                break;
            case "closeReplies":
                closeReplies();
                break;
            case "showMoreComments":
                showMoreComments();
                break;
        }
    }

    // creates a response
    function createCommentResponse() {
        // gets the response id
        $id = "post-" . $_GET['comment_reply_username'] . "-" . $_GET['comment_reply_timeframe'];
        $id = preg_replace("/\s+/", "", $id);

        // shows the comment
        echo "    
        <div class='comment-section'>
            <div class='.content'>
            <form class='userInput' id='$id'>
                <div class='content'>
                    <input type='button' value='&#10006' onclick=\"endCommentSubmission()\"/>
                    <input type='text' placeholder='Comment' name = \"comment-submission-text\">
                    <input type='button' value='Submit' onclick=\"postComment('{$_GET['comment_reply_username']}', '{$_GET['comment_reply_timeframe']}', '$id')\">
                </div>
            </form>
            </div>
        </div> 
        ";
    }

    function showMoreComments()
    {
        // get post form vars
        $post_name = $_GET['post_name'];
        $post_time = $_GET['post_time'];
        $comment_reply_name = $_GET['comment_reply_name'];
        $comment_reply_time = $_GET['comment_reply_time'];


        // get post amount and indexs
        $comment_start_index = $_GET['comment_start_index'];
        $comment_limit = $_GET['comment_limit'];

        // update start index
        $comment_start_index=$comment_start_index+$comment_limit;

        // querry
        $sql = "SELECT COUNT(*) OVER() as total_amount, c.*  FROM COMMENT c WHERE post_username " . "= '{$post_name}' and post_timeframe = '{$post_time}' and comment_reply_username = '$comment_reply_name' and comment_reply_timeframe = '$comment_reply_time' ORDER BY comment_timeframe LIMIT $comment_start_index, $comment_limit";
        $result = $_SESSION['conn']->query($sql);

        // Set Comment List Id
        $comment_list_id = "comment_list-" . $post_name . "-" . $post_time . "-" . $comment_reply_name . "-" . $comment_reply_time;
        $comment_list_id = preg_replace("/\s+/", "", $comment_list_id);

        comment_body($post_name, $post_time, $comment_reply_name, $comment_reply_time ,$comment_start_index, $comment_limit, $result, $comment_list_id);
    }

    // fix
    function createCommentReplyRespose()
    {
        // get necessary variables
        $post_name = $_GET['post_name'];
        $post_time = $_GET['post_time'];
        $comment_username = $_GET['comment_username'];
        $comment_timeframe = $_GET['comment_timeframe'];
        
        displayComments($post_name, $post_time, $comment_username, $comment_timeframe, 0, 5);
    }

    
    function adjustButtons()
    {

        $post_name = $_GET['post_name'];
        $post_time = $_GET['post_time'];
        $comment_username = $_GET['comment_username'];
        $comment_timeframe = $_GET['comment_timeframe'];

        // IDs for specific areas in the html
        $comment_reply_id = $_GET['reply_id'];
        $comment_view_options = $_GET['comment_view'];


        echo "<input type='button' value='Close' onclick=\"closeReplies('$comment_username', '$comment_timeframe', '$comment_reply_id', '$comment_view_options')\">";
    }

    function closeReplies()
    {
        $post_name = $_GET['post_name'];
        $post_time = $_GET['post_time'];
        $comment_username = $_GET['comment_username'];
        $comment_timeframe = $_GET['comment_timeframe'];
        $comment_reply_id =  $_GET['reply_id'];
        $comment_view_options = $_GET['comment_view'];

        
        // get amount of replies
        $sql = "SELECT COUNT(comment_reply_timeframe) as amount FROM comment WHERE post_username " . "= '{$post_name}' and post_timeframe = '{$post_time}' and comment_reply_username = '{$comment_username}' and comment_reply_timeframe = '{$comment_timeframe}';";
        $amount = $_SESSION['conn']->query($sql);
        $amount = $amount->fetch_assoc();
        $amount = $amount['amount'];
                        
        // if there are replies
        if ($amount > 0)
        {
            // show replies
            echo "
            <div id='" . $comment_view_options . "'>
                <input type='button' value='View $amount Replies' onclick=\"showCommentReplies('$comment_username', '$comment_timeframe', '$comment_reply_id', '$comment_view_options')\">
            </div>";
        }
    }

    // inserts commnet
    function postCommentResponse()
    {
        // get inputed data
        $comment_desc = addslashes($_POST["comment-submission-text"]);
        $comment_time = date("Y-m-d h:i:s");
        
        $post_name = $_GET['username'];
        $post_time = $_GET['time'];

        $comment_post_id = "comment_post-" . $_SESSION['user'] . "-" . $comment_time;
        $comment_post_id = preg_replace("/\s+/", "", $comment_post_id);

        // set the querry
        $sql = "INSERT INTO comment (post_username, post_timeframe, comment_reply_username, comment_reply_timeframe, comment_username, comment_timeframe, post_desc) VALUES('{$post_name}', '{$post_time}', '{$_GET['comment_reply_username']}' , '{$_GET['comment_reply_timeframe']}', '{$_SESSION['user']}', '{$comment_time}', \"{$comment_desc}\");";   
        
        // insert the post to the database
        $_SESSION['conn']->query($sql); 
        
        // add new comment to the top of the page
        $comment_input_name = "reply-" . $_SESSION['user'] . "-" . $comment_time;
        $comment_input_name = preg_replace("/\s+/", "", $comment_input_name);
        
        echo "
        <h1 style='text-align:center;'>New Comment</h1>
        <p style='text-align:center;'>You can fully interact with your comment upon page refresh</p>
        <div class='comment-post'>
            <label id='comment-username'>" . $_SESSION['user'] . "</label>
            <label id='comment-timeframe'>" . $comment_time  .  "</label>
            <div class='content'>
                <p>" . $comment_desc . "</p>
            </div>
        </div>
        <div id='" . $comment_post_id . "' class='post-display'>
        </div>
        ";
    }
?>