<?php
// Arquivo: ../php/deletar_conta.php
// Script de exclusão de conta com deleção em cascata manual (Foreign Keys)

include ('conexao.php'); 
session_start();

// 1. Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header('Location: ../html/login.php');
    exit();
}

$idUsuario = $_SESSION['user_id'];
$delecaoSucesso = true;

// 2. Determina o tipo de usuário (aluno ou professor) para a exclusão específica
$queryTipo = "
    SELECT 
        CASE 
            WHEN EXISTS (SELECT 1 FROM aluno WHERE idUsuario = '$idUsuario') THEN 'aluno'
            WHEN EXISTS (SELECT 1 FROM professor WHERE idUsuario = '$idUsuario') THEN 'professor'
            ELSE NULL 
        END AS tipo
";
$resultadoTipo = mysqli_query($mysqli, $queryTipo);
$tipoUsuario = mysqli_fetch_assoc($resultadoTipo)['tipo'];


// =========================================================================
// 3. DELEÇÃO CASCATA: COMEÇA PELOS REGISTROS MAIS PROFUNDOS (FILHOS)
// =========================================================================

// A. DELEÇÃO ESPECÍFICA DE PROFESSOR (se for o caso)
if ($tipoUsuario === 'professor') {
    
    // O professor tem dependência com exercícios, que é um nível mais profundo.
    
    // A.1. Excluir EXERCÍCIOS (depende de idProfessor)
    // O JOIN é necessário para encontrar o idProfessor usando o idUsuario.
    $deleteExercicios = "
        DELETE e FROM exercicio e 
        JOIN professor p ON e.idProfessor = p.idProfessor
        WHERE p.idUsuario = '$idUsuario'
    ";
    if (!mysqli_query($mysqli, $deleteExercicios)) {
        $delecaoSucesso = false;
    }

    // A.2. Excluir o registro PROFESSOR
    if ($delecaoSucesso) {
        $deleteFilha = "DELETE FROM professor WHERE idUsuario = '$idUsuario'";
        if (!mysqli_query($mysqli, $deleteFilha)) {
            $delecaoSucesso = false;
        }
    }
} 
// B. DELEÇÃO ESPECÍFICA DE ALUNO (se for o caso)
elseif ($tipoUsuario === 'aluno') {
    // O aluno não tem dependência profunda conhecida, apenas a tabela 'aluno'
    $deleteFilha = "DELETE FROM aluno WHERE idUsuario = '$idUsuario'";
    if (!mysqli_query($mysqli, $deleteFilha)) {
        $delecaoSucesso = false;
    }
}


// C. DELEÇÃO GERAL DE REGISTROS DEPENDENTES DO IDUSUARIO
if ($delecaoSucesso) {
    
    // C.1. Excluir RESPOSTAS (depende de idUsuario)
    $deleteRespostas = "DELETE FROM respostas WHERE idUsuario = '$idUsuario'";
    if (!mysqli_query($mysqli, $deleteRespostas)) {
        $delecaoSucesso = false;
    }
}

if ($delecaoSucesso) {
    
    // C.2. Excluir PERGUNTAS (depende de idUsuario)
    $deletePerguntas = "DELETE FROM perguntas WHERE idUsuario = '$idUsuario'";
    if (!mysqli_query($mysqli, $deletePerguntas)) {
        $delecaoSucesso = false;
    }
}


// =========================================================================
// 4. DELEÇÃO FINAL: TABELA PAI ('usuario')
// =========================================================================
if ($delecaoSucesso) {
    // Exclui o registro principal (USUARIO)
    $deletePai = "DELETE FROM usuario WHERE idUsuario = '$idUsuario'";
    if (mysqli_query($mysqli, $deletePai)) {
        
        // 5. Sucesso: Destrói a sessão e redireciona
        session_destroy();
        // Pode usar $_SESSION['admin_message'] se quiser exibir na página de login
        header('Location: ../html/login.php?message=Sua conta foi deletada com sucesso.'); 
        exit();
    } else {
        $delecaoSucesso = false;
    }
}

// =========================================================================
// 6. TRATAMENTO DE ERRO
// =========================================================================
if (!$delecaoSucesso) {
    // Loga o erro no servidor para o administrador (opcional)
    error_log("Erro crítico ao deletar conta do usuário $idUsuario: " . mysqli_error($mysqli));
    
    // Redireciona o usuário de volta para o perfil com uma mensagem de erro
    $_SESSION['error_message'] = "Erro crítico. Não foi possível deletar a conta. Tente novamente mais tarde.";
    header('Location: ../html/perfil.php'); 
    exit();
}