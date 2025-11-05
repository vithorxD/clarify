<?php

include ('../php/conexao.php');
session_start();

$idUsuario = $_SESSION['user_id'];
$messages = [];
$target_dir = "../uploads/documentos_professores/"; //onde vao ficar os arquivos
//ve se os arquivos foram enviados
if(isset($_POST['upload_submit']) && isset($_FILES['documento'])){
    
    $file = $_FILES['documento'];
    $file_name = $file['name'];
    $file_tmp_name = $file['tmp_name'];
    $file_error = $file['error'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    // valida os arquivos
    $allowed_extensions = array('pdf', 'jpg', 'jpeg', 'png');
    
    if(!in_array($file_ext, $allowed_extensions)) {
        $messages[] = "Tipo de arquivo não permitido. Use PDF, JPG ou PNG.";
    } elseif ($file_error !== 0) {
        $messages[] = "Ocorreu um erro no upload do arquivo.";
    } else {
        
        // poe um unico nome nos arquivos pra nao fuder tudo
        $new_file_name = "prof_" . $idUsuario . "_" . uniqid() . "." . $file_ext;
        $target_file = $target_dir . $new_file_name;
        
        if (move_uploaded_file($file_tmp_name, $target_file)) {
            
            // atualiza o bd
            $caminho_db = mysqli_real_escape_string($mysqli, $target_file);
            
            $update_query = "
                UPDATE cadastroprofessor 
                SET statusConfirmacao = 'pendente', 
                    caminhoDocumento = '$caminho_db' 
                WHERE idUsuario = '$idUsuario'
            ";
            
            if(mysqli_query($mysqli, $update_query)){
                $messages[] = "Documento enviado com sucesso! Aguarde a confirmação do administrador.";
                // manda o prof pra uma tela de aguardo de confirmação
                header("Location: ../html/aguardando_confirmacao.php");
                exit();
            } else {
                $messages[] = "Erro ao registrar o documento no banco de dados: " . mysqli_error($mysqli);
                // remove arquivo se deu erro no banco
                unlink($target_file);
            }
        } else {
            $messages[] = "Erro ao mover o arquivo para o servidor.";
        }
    }
} else {
    $messages[] = "Nenhum arquivo enviado.";
}

// mostra erros se tiver
if (!empty($messages)) {
    echo "<h1>Erro no Envio</h1>";
    echo "<ul>";
    foreach ($messages as $msg) {
        echo "<li>$msg</li>";
    }
    echo "</ul>";
    echo "<a href='../html/confirmacao.php'>Voltar ao formulário</a>";
}
?>