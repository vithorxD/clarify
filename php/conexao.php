<?php
$servidor = "localhost";
$usuario = "root";
$senha = "";

$conexao = new mysqli($servidor, $usuario, $senha);

if ($conexao->connect_error) {
    die ("Conexão falhou: " . $conexao->connect_error)
}

$sql = "CREATE DATABASE IF NOT EXISTS dbtasty";
$conexao->query($sql);

if (!$conexao->select_db("dbtasty")) {
    die("Erro ao selecionar o banco de dados: " . $conexao->error);    
}

$conexao->query("CREATE TABLE IF NOT EXISTS cadastro (
    codCadastro INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    email VARCHAR(100) NOT NULL,
    senha VARCHAR(100) NOT NULL,
    usuario VARCHAR(100) NOT NULL
)");

$conexao->query("CREATE TABLE IF NOT EXISTS aluno (
    codAluno INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    CodCadastro INT NOT NULL, 
    nomeAluno VARCHAR(100) NOT NULL,
    FOREIGN KEY (codCadastro) REFERENCES codCadastro(cadastro)
)");

$conexao->query("CREATE TABLE IF NOT EXISTS professor (
    codProfessor INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    codCadastro INT NOT NULL,
    especializacao VARCHAR(50) NOT NULL,
    nomeProf VARCHAR(100),
    FOREIGN KEY (codCadastro) REFERENCES codCadastro(cadastro)
)");

$conexao->query("CREATE TABLE IF NOT EXISTS materia (
    codMateria INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    nomeMateria VARCHAR(100)
)");

$conexao->query("CREATE TABLE IF NOT EXISTS perguntas (
    codPerguntas INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    codAluno INT NOT NULL,
    codMateria INT NOT NULL,
    historico INT NOT NULL,
    FOREIGN KEY (codAluno) REFERENCES codAluno(aluno),
    FOREIGN KEY (codMateria) REFERENCES codMateria(materia)
)");

$conexao->query("CREATE TABLE IF NOT EXISTS respostas (
    codResposta INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    codAluno INT NOT NULL,
    codProf INT NOT NULL,
    codPerguntas INT NOT NULL,
    estado TEXT NOT NULL,
    respostas TEXT NOT NULL,
    FOREIGN KEY (codAluno) REFERENCES codAluno(aluno),
    FOREIGN KEY (codProf) REFERENCES codProf(professor),
    FOREIGN KEY (codPerguntas) REFERENCES codPerguntas(perguntas)
)");

$conexao->query("CREATE TABLE IF NOT EXISTS exercicio (
    codExercicio INT PRIMARY KEY NOT NULL,
    codProf INT NOT NULL,
    exercicios INT NOT NULL,
    FOREIGN KEY (codProf) REFERENCES codProf(professor)
)");

?>