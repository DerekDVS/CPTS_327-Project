<?php
    $account_security_error = "";
    $account_security = "";
    
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {   

        // password
        if(empty($_POST["account_security"]))
        {
            $account_security_error = "Code Required";
        }
        /*
            ^               # start of input
            (?=.*?\d)       # lookahead to make sure at least one digit is there
            {8,}            # make sure the string is longer than 4 characters
            $               # end of input
        */
        elseif(!preg_match("/^(?=.*?\d){7,}/", $_POST["account_security"]))
        {
            // if the check fails explain why
            $account_security_error = "Only numbers of a length of 8 are required";
        }
        else
        {          
            $account_security = $_POST["account_security"];
        }

        // Checks if an error occurs
        if($account_security_error == "" and $_SESSION['code'] == $_POST["account_security"])
        {
            $var_value = $_GET['user'];
            $_SESSION['user'] = $var_value;
            header("Location: ../Pages/MainPage.php");
        }  
    }
?>