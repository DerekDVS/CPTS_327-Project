<?php
    // If the session isn't active
    if(session_status() == PHP_SESSION_NONE)
    {
        // connect to session
        $_SESSION['conn'] = connect();
    }

    // connects to session and returns the connection variable
    function connect()
    {
        // starts session
        session_start();

        // sets timezone
        date_default_timezone_set('America/Los_Angeles');

        // important variables needed to connect to my database
        $servername = "localhost";
        $username = "DerekSadler";
        $password = "Sadler2022";
        $dbname = "websitedb";
        
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        
        // Check connection
        if ($conn->connect_error) 
        {
            die("Connection failed: " . $conn->connect_error);
        }

        // return the connection database
        return $conn;
    }

    // Display users (Temp placement)
    function displayUsers($conn)
    {
        // querry table
        $sql = "SELECT * FROM Users;";
        $result = $conn->query($sql);
        
        // print table
        if($result->num_rows > 0)
        {
            // Set Up Base row
            echo "<table class='user-table'>" . "<tr>" . "<th>Username</th>" . "<th>Firstname</th>" . "<th>Lastname</th>" . "</tr>";
            
            // Move through every row
            while($row = $result->fetch_assoc())
            {
                echo "<tr><td>" . htmlspecialchars($row["username"]) . "</td><td>" . htmlspecialchars($row["firstName"]) . "</td><td>" .  htmlspecialchars($row["lastName"]) . "</td></tr>";
            }

            // end table
            echo "</table>";
        }
    }
?>