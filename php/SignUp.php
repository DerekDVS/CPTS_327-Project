<?php
    // init vars
    $account_username_error = $account_password_error = $account_firstname_error = $account_lastname_error = $account_duplicate_error = "";
    $account_username = $account_password = $account_firstname = $account_lastname = "";

    // posting
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(isset($_POST['Submit']))
        {
            // username
            if(empty($_POST["account_username"]))
            {
                $account_username_error = "Username Required";
            }
            else
            {
                $account_username = $_POST["account_username"];
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

            // firstname
            if(empty($_POST["account_firstname"]))
            {
                $account_firstname_error = "Firstname Required";
            }
            elseif(!preg_match("/^[a-zA-Z]*$/", $_POST["account_firstname"]))
            {
                $account_firstname_error = "Only Letters Allowed";
            }
            else
            {
                $account_firstname = $_POST["account_firstname"];
            }

            // lastname
            if(empty($_POST["account_lastname"]))
            {
                $account_lastname_error = "Lastname Required";
            }
            elseif(!preg_match("/^[a-zA-Z]*$/", $_POST["account_lastname"]))
            {
                $account_lastname_error = "Only Letters Allowed";
            }
            else
            {
                $account_lastname = $_POST["account_lastname"];
            }

            // insertion querry
            $sql = "INSERT INTO Users (username, user_password, firstName, lastName) VALUES('$account_username', '$account_password', '$account_firstname', '$account_lastname');";

            // Checks if an error occured
            if($account_username_error == "" and $account_password_error == "" and $account_firstname_error == "" and $account_lastname_error == "")
            {
                // Query to see if the user is unique
                $check= "SELECT * FROM Users WHERE username = '$account_username';";
                $sqlCheck = $_SESSION['conn']->query($check);
                    
                // Add user if the username is unique else inform user to try again
                if($sqlCheck->num_rows == 0)
                {
                    $_SESSION['conn']->query($sql);    
                    $_SESSION['user'] = $account_username;
                    header("Location: ../Pages/MainPage.php");            
                }
                else
                {
                    $account_duplicate_error = "Duplicate Username";
                }
            }
        }
    }

    // Outputs info specified
    function OutputInfo($account_username, $account_password, $account_firstname, $account_lastname)
    {
        echo "<h2>Your Input:</h2>";
        echo $account_username;
        echo "<br>";
        echo $account_password;
        echo "<br>";
        echo $account_firstname;
        echo "<br>";
        echo $account_lastname;
    }
?>