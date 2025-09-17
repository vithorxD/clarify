<?php

include('/xampp/htdocs/clarify/php/conexao.php');

if(!isset($_SESSION)){
    session_start();
}

if(!isset($_SESSION['id'])) {
    header("Location: /html/login.php");
    exit;
}

?>