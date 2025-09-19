<?php
session_start( );

//print_r($_REQUEST  );

    if(isset($_POST['submit']) && !empty($_POST['email']) && !empty($_POST['senha']))
    {
        include_once('conexao.php');
        $email = $_POST['email'];  
        $senha = $_POST['senha'];

        //print_r('Email: ' . $email);
        //print_r('<br>');
        //print_r('Senha: ' . $senha);    

        $sql = "SELECT * FROM teste WHERE email = '$email' and senha = '$senha'";
        $result = $mysqli->query($sql);

        //print_r($result);
        //print_r($sql);

        if(mysqli_num_rows($result) < 1)
        {
            unset($_SESSION['email']);
            unset($_SESSION['senha']);
            header('Location: ../html/login.php');
        }
        else
        {
            $_SESSION['email'] = $email;
            $_SESSION['senha'] = $senha;
            header('Location: ../html/telaprincipal.php');
        }

    }
    else 
    {
        header('Location: ..//html/login.php'); 
    }

?> 
