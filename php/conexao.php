<?php
    $host = "localhost";
    $dbname = "clarify";
    $username = "root";
    $password = ""; 
    $conn;

    $mysqli = new mysqli($host, $username, $password, $dbname);

    if ($mysqli->connect_errno) {
        echo "Falha ao conectar ao MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }
?>