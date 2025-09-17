<?php
{
    $host = "localhost";
    $dbname = "clarify";
    $username = "root";
    $password = ""; 
    $conn;

    $mysqli = new mysqli($host, $username, $password, $dbname);

    if ($mysqli->connect_error) {
        die("Falha na conexão: " . $mysqli->connect_error);
    }

}
?>