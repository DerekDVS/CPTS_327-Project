<?php
    function headElement()
    {
        $page = basename($_SERVER['PHP_SELF']);

        echo "
            <head>
                <title>Derek's Website</title>
                <meta charset='UTF-8'/>
                <meta name='viewport' content='width=device-width, initial-scale=1'/>
                <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js\"></script>
                <link rel='stylesheet' type='text/css' href='../css/MainPage.css'/>
                <link rel='icon' type='image/x-icon' href='../images/favicon.ico'/>";

        // get css elements for specific pages
        switch($page)
        {
            case "LoginPage.php":
                echo "<link rel='stylesheet' type='text/css' href='../css/signIn.css'/>";
                break;
            case "SignUpPage.php":
                echo "<link rel='stylesheet' type='text/css' href='../css/signUp.css'/>";
                break;
            case "GetPostPage.php":
                echo "<link rel='stylesheet' type='text/css' href='../css/Post.css'/>";
        }
        
        echo               
        "
            </head>        
        ";
    }

    function pageNavigation()
    {
        echo "
            <div class='navbar'>
                <a href='MainPage.php'>Home</a>
                <a href=''>About Me</a>
                <a href=''>Contact</a>
        ";
        showLoggedUser();    
                
        echo "
            </div>
        ";
    }

    function pageFooter()
    {
        echo "        
            <footer class='background'>
                <p class='text-footer'>
                    
                </p>
            </footer>";
    }

    function showLoggedUser()
    {
        if (isset($_SESSION['user']))
        {
            // show log out button and logged in user
            echo "
                <a href='../php/logout.php'>Logout</a>
                <a id='user'>{$_SESSION['user']}</a>
            ";
        }
        else
        {
            // display login and signup page
            echo "
                <a href='LoginPage.php'>Login</a>
                <a href='SignUpPage.php'>SignUp</a>
            ";
        }
    }
?>