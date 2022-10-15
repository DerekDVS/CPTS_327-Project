<?php

    // credentials
    $servername = "localhost";
    $username = "postgres";
    $password = "Sadler2022";
    $database = "WebsiteDB";

    // create connection

    $conn =  pg_connect("pgsql:host= $servername port=5432 dbname=$database user=$username password=$password");
?>