<?php

include ('conexao.php'); 
session_start();

$message = [];

// 1. Verifica se o usuário é um professor logado
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'professor') {
    header('Location: ../html/aguardoprof.php'); exit();
}

$idUsuario = $_SESSION['user_id'];

if (isset($_POST['submit_upload']) && isset($_FILES['documento'])) {
    
    $file_name = $_FILES['documento']['name'];
    $file_tmp = $_FILES['documento']['tmp_name'];
    $file_error = $_FILES['documento']['error'];
    
    //define o diretorio onde os arquivos serao salvos
    $diretorio_upload = '/xampp/htdocs/clarify/upload/documentosprofs/';
    
    //garante que o diretorio existe
    if (!is_dir($diretorio_upload)) {
        mkdir($diretorio_upload, 0777, true);
    }

    if ($file_error === 0) {
        
        //gera um nome unico para o arquivo para evitar conflitos
        $extensao = pathinfo($file_name, PATHINFO_EXTENSION);
        $novo_nome_arquivo = 'prof_' . $idUsuario . '_' . time() . '.' . $extensao;
        $caminho_destino = $diretorio_upload . $novo_nome_arquivo;
        
        //tenta mover o arquivo para o diretorio de upload
        if (move_uploaded_file($file_tmp, $caminho_destino)) {
            
            //atualiza o caminho do documento no banco de dados
            $caminho_db = mysqli_real_escape_string($mysqli, $caminho_destino);
            
            $update_query = "
                UPDATE professor 
                SET caminhoDocumento = '$caminho_db' 
                WHERE idUsuario = '$idUsuario'
            ";
            
            if (mysqli_query($mysqli, $update_query)) {
                header('Location: ../html/aguardoprof.php');
                exit();
                
            } else {
                $message[] = 'Erro ao atualizar o banco de dados: ' . mysqli_error($mysqli);
                //apaga o arquivo do bd se houver falha no update
                unlink($caminho_destino); 
            }
            
        } else {
            $message[] = 'Erro ao fazer upload do arquivo. Verifique as permissões da pasta.';
        }
        
    } else {
        $message[] = 'Erro no envio do arquivo: Código ' . $file_error . '. O arquivo pode ser muito grande.';
    }
}
if (!empty($message)) {
    echo "<h1>Erro no Upload</h1>";
    foreach ($message as $msg) {
        echo "<p style='color: red;'>$msg</p>";
    }
    echo "<p><a href='../html/confirmacao.html'>Tentar novamente</a></p>";
}

?>