<?php
    // init vars
    $account_username_error = $account_password_error = $account_firstname_error = $account_lastname_error = "";
    $account_username = $account_password = $account_firstname = $account_lastname = "";

    // posting
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // username
        if(empty($_POST["account_username"]))
        {
            $account_username_error = "Username Required";
        }
        else
        {
            $account_username = addslashes($_POST["account_username"]);
        }

        // password
        if(empty($_POST["account_password"]))
        {
            $account_password_error = "Password Required";
        }
        /*
            ^               # start of input
            (?=.*?\d)       # lookahead to make sure at least one digit is there
            (?=.*?[a-zA-Z]) # lookahead to make sure at least one letter is there
            [a-zA-Z\d]      # regex to match 1 or more of digit or letters
            {4,}            # make sure the string is longer than 4 characters
            $               # end of input
        */
        elseif(!preg_match("/^(?=.*?\d)(?=.*?[a-zA-Z])[a-zA-Z\d]{4,}$/", $_POST["account_password"]))
        {
            // if the check fails explain why
            $account_password_error = "Letters and Numbers are required with a length of at least 4";
        }
        else
        {
            $account_password = $_POST["account_password"];
        }

        // Checks if an error occurs
        if($account_username_error == "" and $account_password_error == "")
        {
            // Query to see if the user is unique
            $check= "SELECT * FROM Users WHERE username = '$account_username' and user_password = '$account_password';";
            $sqlCheck = $_SESSION['conn']->query($check);

            // Login if the user exists
            if($sqlCheck->num_rows > 0)
            {
                $sqlCheck = $sqlCheck->fetch_assoc();
                $_SESSION['user'] = $sqlCheck["username"];
                header("Location: ../Pages/MainPage.php");
                
            }                
            else
            {
                echo "Non-existent username";
            }
        }            
    }
?>