<?php
    // Displays the user post
    function displayPost()
    {
        // get post info
        $post_name = $_GET['username'];
        $post_time = $_GET['time'];
        
        // Set Comment List Id
        $comment_list_id = "comment_list-" . $post_name . "-" . $post_time . "-null-null";
        $comment_list_id = preg_replace("/\s+/", "", $comment_list_id);

        // set the query
        $sql = "SELECT * FROM Post WHERE username " . "= '{$post_name}' and timeframe = '{$post_time}';";
        $result = $_SESSION["conn"]->query($sql);
        

        // SHOWING THE POST
        $row = $result->fetch_assoc();
        echo "
        <div class='post'>
            <div class='label-display'>
                <label id='post-username'>" . htmlspecialchars($row["username"]) . "</label>
                <label id='post-timeframe'>" . htmlspecialchars($row["timeframe"]) . "</label>
            </div>
            <form id=>
                <div class='content'>
                    <h1>" . htmlspecialchars($row["title"]) . "</td><td>" . "</h1>
                    <p>" . htmlspecialchars($row["post_desc"]) . "</p>
                </div>
                <div class='action'>
                    <input type='button' name='create-comment' value='MAKE COMMENT' id=\"make-comment\" onclick=\"showCommentSubmission(null, null, 'response', '$comment_list_id')\">
                </div>
        </div>
        <div id=\"response\" class='post-display'>
        </div>

        ";

        // return needed values
        $return = array($post_name, $post_time);
        return $return;
    
    }

    function displayUserComments($post_name, $post_time)
    {
        echo "
        <div class='comment-list' id='users-posted-comments'>
        </div>";
    }

    // Add recursive behavior
    function displayComments($post_name, $post_time, $comment_reply_name, $comment_reply_time, $comment_start_index, $comment_limit)
    {
        // querry
        $sql = "
        SELECT COUNT(*) OVER() as total_amount, c.*  FROM COMMENT c WHERE post_username " . "= '{$post_name}' and post_timeframe = '{$post_time}' and comment_reply_username = '$comment_reply_name' and comment_reply_timeframe = '$comment_reply_time' ORDER BY comment_timeframe LIMIT $comment_start_index, $comment_limit";
        $result = $_SESSION['conn']->query($sql);

        // Set Comment List Id
        $comment_list_id = "comment_list-" . $post_name . "-" . $post_time . "-" . $comment_reply_name . "-" . $comment_reply_time;
        $comment_list_id = preg_replace("/\s+/", "", $comment_list_id);

        // print comments
        if($result->num_rows > 0)
        {
            echo "<div class='comment-list' id='$comment_list_id'>";
            comment_body($post_name, $post_time, $comment_reply_name, $comment_reply_time, $comment_start_index, $comment_limit, $result, $comment_list_id);
            // set the next amount of comments to be seen
           
            echo "</div>";
        }
        else
        {
            echo "
            <div class='comment-list' id='comments'>
                <p style='text-align: center' id='comment-empty'>No comments at the momment</p>
            </div>
            ";
            echo "</div>";
        }
    }

    function comment_body($post_name, $post_time, $comment_reply_name, $comment_reply_time, $comment_start_index, $comment_limit, $result, $comment_list_id)
    {
        // Move through every row
        while($row = $result->fetch_assoc())
        {
            // set unique ids

            // used to show the post panel under the comment
            $comment_post_id = "comment_post-" . $row["comment_username"] . "-" . $row["comment_timeframe"];
            $comment_post_id = preg_replace("/\s+/", "", $comment_post_id);

            // used to show the replies to this comment
            $comment_reply_id = "comment_reply-" . $row["comment_username"] . "-" . $row["comment_timeframe"];
            $comment_reply_id = preg_replace("/\s+/", "", $comment_reply_id);

            // used to show the view options of the post (show replies/hide replies)
            $comment_view_options ="comment_view-" . $row["comment_username"] . "-" . $row["comment_timeframe"];
            $comment_view_options = preg_replace("/\s+/", "", $comment_view_options);
            
            // Set up comment display
            echo "
            <div class='comment-post'>
                <label id='comment-username'>" . htmlspecialchars($row["comment_username"]) . "</label>
                <label id='comment-timeframe'>" . htmlspecialchars($row["comment_timeframe"]) .  "</label>
                <div class='content'>
                    <p>" . htmlspecialchars($row["post_desc"]) . "</p>
                    <div class='action'>
                        <form id='comment-response-form' class='give_reply'>
                            <input type='button' id='post-comment' value='Reply' onclick=\"showCommentSubmission('{$row['comment_username']}', '{$row['comment_timeframe']}', '$comment_post_id')\">  
            ";
            
            // get amount of replies
            $sql = "SELECT COUNT(comment_reply_timeframe) as amount FROM comment WHERE post_username " . "= '{$post_name}' and post_timeframe = '{$post_time}' and comment_reply_username = '{$row['comment_username']}' and comment_reply_timeframe = '{$row['comment_timeframe']}';";
            $reply_amount = $_SESSION['conn']->query($sql);
            $reply_amount = $reply_amount->fetch_assoc();
            $reply_amount = $reply_amount['amount'];
            
            // if there are replies
            if ($reply_amount > 0)
            {
                // show replies
                echo "
                <div id='" . $comment_view_options . "' class='show_replies'>
                    <input type='button' value='View $reply_amount Replies' onclick=\"showCommentReplies('{$row['comment_username']}', '{$row['comment_timeframe']}', '$comment_reply_id', '$comment_view_options')\">
                </div>";
            }
            

            echo "          
                        </form>
                    </div>
                </div>
            </div>
            <div id='" . $comment_post_id . "' class='post-display'>
            </div>
            <div id=" . $comment_reply_id . ">
            </div>
            ";

            // sets the amount of rows for our comment
            if(isset($comment_amount)===false)
            {
                $comment_amount = $row['total_amount'];
                $comment_amount -= ($comment_start_index+$comment_limit);
            }
        }
        
        
        if ($comment_amount > 0)
        {
            if ($comment_amount > $comment_limit)
            {
                $comment_amount = $comment_limit;
            }
            $button_id = "button_" . $comment_list_id;
            //echo $comment_reply_name;
            //echo $comment_reply_time;
            echo "
            <div id='$button_id' class='show_more'>
                <input type='button' Value='Show $comment_amount More Comments' onclick=\"showMoreComments('$comment_reply_name','$comment_reply_time', '$comment_start_index','$comment_limit','$comment_list_id', '$button_id')\">
            </div>
            ";                   
        }
    }

?>