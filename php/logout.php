<?php
        // Sets session id to empty
        $_SESSION = array();

        // Removes the session cookies if they exist
        if(ini_get("session.use_cookies"))
        {
            $params = session_get_cookie_params();
            setcookie(
                session_name(), '', time() - 42000,
                $params['path'], $params['domain'], $params["secure"], $params["httponly"]            
            );
        }

        // end the session and redirect to the login page
        session_destroy();
        header("Location: ../Pages/LoginPage.php");
        
?>