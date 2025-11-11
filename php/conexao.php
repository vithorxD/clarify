<?php
    $host = "localhost";
    $username = "root";
    $password = ""; 

    $mysqli = new mysqli($host, $username, $password);

    if ($mysqli->connect_errno) {
        die("Falha ao conectar ao MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
    }

    $sql = "CREATE DATABASE IF NOT EXISTS clarify";
    $mysqli->query($sql);

    if (!$mysqli->select_db("clarify")){
        die("Erro ao selecionar o banco de dados: " . $mysqli->error);
    }

    $mysqli->query("CREATE TABLE IF NOT EXISTS usuario(
        idUsuario int NOT NULL AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(100) NOT NULL,
        email VARCHAR(320) NOT NULL,
        senha VARCHAR(100) NOT NULL,
        ehAdmin tinyint(1) NOT NULL DEFAULT 0
    )");

    $mysqli->query("CREATE TABLE IF NOT EXISTS aluno(
        idAluno INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        serie VARCHAR(100) NOT NULL,
        idUsuario INT NOT NULL,
        FOREIGN KEY (idUsuario) REFERENCES usuario(idUsuario)
    )");

    $mysqli->query("CREATE TABLE IF NOT EXISTS professor(
        idProfessor INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        idUsuario INT NOT NULL,
        especializacao VARCHAR(100) NOT NULL,
        statusConfirmacao VARCHAR(20) NOT NULL DEFAULT 'pendente',
        caminhoDocumento VARCHAR(255),
        FOREIGN KEY (idUsuario) REFERENCES usuario(idUsuario)
    )");

    $mysqli->query("CREATE TABLE IF NOT EXISTS exercicio(
        idExercicio INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        idProfessor INT NOT NULL,
        titulo VARCHAR(255) NOT NULL,
        descricao TEXT NOT NULL,
        materia VARCHAR(100) NOT NULL,
        dataCriacao DATETIME DEFAULT CURRENT_TIMESTAMP,
        resolucao TEXT NOT NULL,
        FOREIGN KEY (idProfessor) REFERENCES professor(idProfessor)
    )");

    $mysqli->query("CREATE TABLE IF NOT EXISTS  perguntas(
        idPerguntas INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        idUsuario INT NOT NULL,
        titulo VARCHAR(255) NOT NULL,
        descricao TEXT NOT NULL,
        materia VARCHAR(100) NOT NULL,
        dataCriacao DATETIME DEFAULT CURRENT_TIMESTAMP,
        status VARCHAR(50) NOT NULL DEFAULT 'aberta',
        FOREIGN KEY (idUsuario) REFERENCES usuario(idUsuario)
    )");

    $mysqli->query("CREATE TABLE IF NOT EXISTS respostas(
        idRespostas INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        idUsuario INT NOT NULL,
        idProfessor INT NOT NULL,
        idPerguntas INT NOT NULL,
        conteudo text NOT NULL,
        dataResposta DATETIME DEFAULT CURRENT_TIMESTAMP,
        ehProfessor tinyint(1) NOT NULL DEFAULT 0,
        FOREIGN KEY (idUsuario) REFERENCES usuario(idUsuario),
        FOREIGN KEY (idPerguntas) REFERENCES perguntas(idPerguntas)
    )");

    $email_admin = 'admin@gmail.com';
    $senha_admin = MD5('admin');

    $check_admin_query = $mysqli->query("SELECT idUsuario FROM usuario WHERE email = '$email_admin' AND ehAdmin = 1");

    if ($check_admin_query && $check_admin_query->num_rows == 0) {
        
        $insert_admin_query = "
            INSERT INTO usuario (nome, email, senha, ehAdmin) 
            VALUES ('admin', '$email_admin', '$senha_admin', 1)
        ";
        
        // sla pq precisa dessa porra mas ta dando errado sem entao ta aqui
        if ($mysqli->query($insert_admin_query)) {
        } else {
        }
    }
?>