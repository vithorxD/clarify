<?php
    $host = "localhost";
    $username = "root";
    $password = ""; 

    $mysqli = new mysqli($host, $username, $password);

    if ($mysqli->connect_errno) {
        echo "Falha ao conectar ao MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }

    $sql = "CREATE DATABASE IF NOT EXISTS clarify";
    $mysqli->query($sql);

    if (!$mysqli->select_db("clarify")){
        die("Erro ao selecionar o banco de dados: " . $mysqli->error);
    }

    $mysqli->query("CREATE TABLE IF NOT EXISTS teste (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(30) NOT NULL,
        email VARCHAR(50) NOT NULL,
        senha VARCHAR(50) NOT NULL
    )");

    $mysqli->query("CREATE TABLE IF NOT EXISTS email(
        idEmail int NOT NULL AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(100) NOT NULL
    )");

    $mysqli->query("CREATE TABLE IF NOT EXISTS cadastro(
        idCadastro int NOT NULL AUTO_INCREMENT PRIMARY KEY,
        senha VARCHAR(100) NOT NULL,
        csenha VARCHAR(100) NOT NULL,
        usuario VARCHAR(100) NOT NULL,
        idEmail INT NOT NULL,
        nome VARCHAR(100) NOT NULL,
        FOREIGN KEY (idEmail) REFERENCES email(idEmail)
    )");

    $mysqli->query("CREATE TABLE IF NOT EXISTS aluno(
        idAluno INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        nomeAluno VARCHAR(100) NOT NULL,
        idCadastro INT NOT NULL,
        FOREIGN KEY (idCadastro) REFERENCES cadastro(idCadastro)
    )");

    $mysqli->query("CREATE TABLE IF NOT EXISTS professor(
        idProfessor INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        idCadastro INT NOT NULL,
        especializacao VARCHAR(100) NOT NULL,
        nomeProfessor VARCHAR(100) NOT NULL,
        FOREIGN KEY (idCadastro) REFERENCES cadastro(idCadastro)
    )");

    $mysqli->query("CREATE TABLE IF NOT EXISTS exercicio(
        idExercicio INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        idProfessor INT NOT NULL,
        FOREIGN KEY (idProfessor) REFERENCES professor(idProfessor)
    )");

    $mysqli->query("CREATE TABLE IF NOT EXISTS  perguntas(
        idPerguntas INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        idAluno INT NOT NULL,
        materia VARCHAR(100) NOT NULL,
        FOREIGN KEY (idAluno) REFERENCES aluno(idAluno)
    )");

    $mysqli->query("CREATE TABLE IF NOT EXISTS respostas(
        idRespostas INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        idAluno INT NOT NULL,
        idProf INT NOT NULL,
        idPerguntas INT NOT NULL,
        status VARCHAR(50) NOT NULL,
        FOREIGN KEY (idAluno) REFERENCES aluno(idAluno),
        FOREIGN KEY (idProf) REFERENCES professor(idProfessor),
        FOREIGN KEY (idPerguntas) REFERENCES perguntas(idPerguntas)
    )");

    $mysqli->query("CREATE TABLE IF NOT EXISTS admin(
        idAdmin INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        idCadastro INT NOT NULL,
        FOREIGN KEY (idCadastro) REFERENCES cadastro(idCadastro)
    )");


?>