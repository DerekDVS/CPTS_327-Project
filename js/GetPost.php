<script>
    // shows a comment
    function showCommentSubmission(comment_reply_username, comment_reply_timeframe, comment_id)
    {
        // get server request
        var request = new XMLHttpRequest();

        // open post and get relevent data
        request.open("GET", "../AJAX/GetPost.php?Type=showComment&comment_reply_username=" + comment_reply_username +  "&comment_reply_timeframe=" + comment_reply_timeframe);

        // if request is succesful add to html
        request.onreadystatechange = function() {
            if(this.readyState === 4 && this.status === 200) {
                document.getElementById(comment_id).innerHTML = this.responseText;
                document.getElementById(comment_id).style.display = 'block';
            }       
        };
        request.send();

        // hides needed elements
        const elements = document.getElementsByClassName("userInput");
        for(const e of elements)
        {
            e.style.display = 'none';
        }
        
        // shows and hides needed elements
        document.getElementById('make-comment').style.display = 'none';
    }

    // hides a comment
    function endCommentSubmission()
    {            
        // hides all display elements
        const elements = document.getElementsByClassName("userInput");
        for(const e of elements)
        {
            e.style.display = 'none';
        }
        
        // shows and hides needed elements
        document.getElementById('make-comment').style.display = 'block';
    }

    // shows a comment
    function postComment(comment_reply_username, comment_reply_timeframe, comment_id)
    {
        // get server request
        var request = new XMLHttpRequest();

        // open post and get relevent data
        request.open("POST", "../AJAX/GetPost.php?username=<?=$_GET['username']?>&time=<?=$_GET['time']?>&comment_reply_username=" + comment_reply_username + "&comment_reply_timeframe=" + comment_reply_timeframe + "&comment_id=" + comment_id + "&Type=postComment");

        // get the comment list id
        var comment_list_id = "users-posted-comments";
        

        // if request is succesful add to html
        request.onreadystatechange = function() {
            if(this.readyState === 4 && this.status === 200) {
                document.getElementById(comment_list_id).innerHTML = this.responseText;
            }       
        };
        
        // get form data
        var myForm = document.getElementById(comment_id);
        var formData = new FormData(myForm);
        request.send(formData);
        
        // shows and hides needed elements
        endCommentSubmission();
        document.getElementById('comment-empty').style.display = 'none';
    }

    // trigger to show the comment replies (comments of comments)
    function showCommentReplies(comment_reply_name, comment_reply_time, reply_id, comment_view)
    {

        /*
            Replies
        */
        // get server request
        var request = new XMLHttpRequest();
        var file = "../AJAX/GetPost.php?Type=showCommentResponse&post_name=<?=$_GET['username']?>&post_time=<?=$_GET['time']?>&comment_username=" + comment_reply_name + "&comment_timeframe=" + comment_reply_time + "&comment_view=" + comment_view;
        // open post and get relevent data
        request.open("GET", file);
        
        // if request is succesful add to html
        request.onreadystatechange = function() {
            if(this.readyState === 4 && this.status === 200) {
                document.getElementById(reply_id).innerHTML = this.responseText;
            }       
        };

        // send the request
        request.send();

        /*
            Button Adjustments
        */
        var request = new XMLHttpRequest();
        var file = "../AJAX/GetPost.php?Type=adjustButtons&post_name=<?=$_GET['username']?>&post_time=<?=$_GET['time']?>&comment_username=" + comment_reply_name + "&comment_timeframe=" + comment_reply_time + "&reply_id=" + reply_id + "&comment_view=" + comment_view;
        
        // open post and get relevent data
        request.open("GET", file);
        
        // if request is succesful add to html
        request.onreadystatechange = function() {
            if(this.readyState === 4 && this.status === 200) {
                document.getElementById(comment_view).innerHTML = this.responseText;
            }       
        };

        // send the request
        request.send();    
    }

    function closeReplies(comment_reply_name, comment_reply_time, reply_id, comment_view)
    {
        var request = new XMLHttpRequest();
        var file = "../AJAX/GetPost.php?Type=closeReplies&post_name=<?=$_GET['username']?>&post_time=<?=$_GET['time']?>&comment_username=" + comment_reply_name + "&comment_timeframe=" + comment_reply_time  + "&reply_id=" + reply_id +  "&comment_view=" + comment_view;

        // open post and get relevent data
        request.open("GET", file);

        // if request is succesful add to html
        request.onreadystatechange = function() {
            if(this.readyState === 4 && this.status === 200) {
                document.getElementById(reply_id).innerHTML = "";
                document.getElementById(comment_view).innerHTML = this.responseText;
            }       
        };

        // send the request
        request.send();  
    }

    function showMoreComments(comment_reply_name, comment_reply_time, comment_start_index, comment_limit, comment_list_id, button_id)
    {
        var request = new XMLHttpRequest();
        var file = "../AJAX/GetPost.php?Type=showMoreComments&post_name=<?=$_GET['username']?>&post_time=<?=$_GET['time']?>&comment_reply_name=" + comment_reply_name + "&comment_reply_time=" + comment_reply_time + "&comment_start_index=" + comment_start_index + "&comment_limit=" +comment_limit + "&comment_list_id=" + comment_list_id;

        // open post and get relevent data
        request.open("GET", file);

        // if request is succesful add to html
        request.onreadystatechange = function() {
            if(this.readyState === 4 && this.status === 200) {
                document.getElementById(comment_list_id).innerHTML = document.getElementById(comment_list_id).innerHTML + this.responseText;
                document.getElementById(button_id).outerHTML = '';
            }       
        };

        // send the request
        request.send();     
    }
</script>