<?php

include ('../php/conexao.php'); 
session_start();

if(!isset($_SESSION['user_id'])){
    header('Location: login.php');
    exit();
}

$idUsuario = $_SESSION['user_id'];

// ve os dados dos usuarios nao importa de que tipo
$query = "
    SELECT 
        u.nome, 
        u.email,
        a.serie,
        p.especializacao
    FROM 
        usuario u
    LEFT JOIN 
        aluno a ON u.idUsuario = a.idUsuario
    LEFT JOIN 
        professor p ON u.idUsuario = p.idUsuario
    WHERE 
        u.idUsuario = '$idUsuario'
";

$resultado = mysqli_query($mysqli, $query) or die('Erro ao buscar dados para edição: ' . mysqli_error($mysqli));
$usuario = mysqli_fetch_assoc($resultado);

// determina o tipo de usuário para exibir campos específicos
$tipoUsuario = '';
if ($usuario['serie'] !== null) {
    $tipoUsuario = 'aluno';
} elseif ($usuario['especializacao'] !== null) {
    $tipoUsuario = 'professor';
}

$opcoes_series = [ "6° Ano", "7° Ano", "8° Ano", "9° Ano", "1° Ano do Ensino Medio", "2° Ano do Ensino Medio", "3° Ano do Ensino Medio" ];
$opcoes_especializacoes = [ "Matemática", "Português", "Física", "Química", "Biologia", "História", "Filosofia", "Sociologia", "Geografia", "Artes", "Inglês" ];

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/editar_perfil.css">
    <title>Clarify</title>
    <link rel="shortcut icon" type="imagex/png" href="/images/clarifyv1.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body style="background-color: #EDF3F8;">
    
    <?php include '../php/navbar.php'; ?>

    <form action="../php/salvar.php" method="POST">
        
        <h2 class="titulo" style="font-size: 60px;">Editar Perfil de <?php echo htmlspecialchars($usuario['nome']); ?></h2>
        <h3 style="font-size: 40px;">Dados Gerais</h3>
        <label style="font-size: 20px;" for="nome">Nome:</label>
        <div style="background-color: #e8e8e8; padding: 5px; border-radius: 10px; max-width: 300px;">
        <input style="border: none; background-color: transparent; width: 360px; align-items: center; align-self: center; font-size: 17px;" type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($usuario['nome']); ?>" required>
        </div>
        <br>
        
        <label style="font-size: 20px;" for="email">Email:</label>
        <div style="background-color: #e8e8e8; padding: 5px; border-radius: 10px; max-width: 300px;">
        <input style="border: none; background-color: transparent; width: 360px; align-items: center; align-self: center; font-size: 17px;" type="email" id="email" name="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" required>
        </div>
        <br>
        <?php if ($tipoUsuario == 'aluno'): ?>
            <h3 style="font-size: 40px;">Dados do Aluno</h3>
            <label for="serie">Série:</label>
            <div style="background-color: #e8e8e8; padding: 5px; border-radius: 10px; max-width: 300px;">
            <select style="background-color: transparent; outline: none;" id="serie" name="serie" required>
                <?php foreach ($opcoes_series as $serie): ?>
                    <option 
                        value="<?php echo htmlspecialchars($serie); ?>" 
                        <?php echo ($usuario['serie'] === $serie) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($serie); ?>
                </option>
            <?php endforeach; ?>
            </select>
            </div>
        <br>
        <?php elseif ($tipoUsuario == 'professor'): ?>
            <h3 style="font-size: 40px;">Dados do Professor</h3>
            <label style="font-size: 20px;" for="especializacao">Especialização:</label>
            <select id="especializacao" name="especializacao" required>
                <?php foreach ($opcoes_especializacoes as $especializacao): ?>
                    <option 
                        value="<?php echo htmlspecialchars($especializacao); ?>" 
                        <?php echo ($usuario['especializacao'] === $especializacao) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($especializacao); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <br>
        <?php endif; ?>
        <h3>Alterar Senha (Opcional)</h3>
        <label style="font-size: 20px;" for="nova_senha">Nova Senha:</label>
        <div style="background-color: #e8e8e8; padding: 5px; border-radius: 10px; max-width: 300px;">
        <input style="border: none; background-color: transparent; width: 360px; align-items: center; align-self: center; font-size: 17px;" type="password" id="nova_senha" name="nova_senha">
        </div>
        <br>
        <label style="font-size: 20px;" for="confirma_senha">Confirme a Nova Senha:</label>
        <div style="background-color: #e8e8e8; padding: 5px; border-radius: 10px; max-width: 300px;">
        <input style="border: none; background-color: transparent; width: 360px; align-items: center; align-self: center; font-size: 17px;" type="password" id="confirma_senha" name="confirma_senha">
        </div>
        <br>

        <button type="submit" name="submit" style="border-radius: 15px;">Salvar Alterações</button>
    </form>
    
    <a href="perfil.php">Cancelar e Voltar</a>

</body>
</html>