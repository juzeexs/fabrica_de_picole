<?php
include 'db_config.php';

// Verifica se a conexão foi bem-sucedida (já feito em db_config.php)

// verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    // Validação básica
    if (empty($_POST['nome']) || empty($_POST['email']) || empty($_POST['senha']) || empty($_POST['colaborador'])) {
        echo "Erro: Todos os campos são obrigatórios.";
        exit();
    }

    $nome  = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];
    $tipodecolaborador = trim($_POST['colaborador']);

    // criptografa a senha
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    // data e hora atuais
    $data = date('Y-m-d');
    $hora = date('H:i:s');

    // prepara o comando SQL
    $stmt = $conn->prepare(
        'INSERT INTO cadastros (nome, email, senha, tipodecolaborador, `data`, `hora`) 
        VALUES (?, ?, ?, ?, ?, ?)'
    );

    $stmt->bind_param("ssssss", $nome, $email, $senhaHash, $tipodecolaborador, $data, $hora);

    if ($stmt->execute()) {

        // Redireciona após cadastrar com sucesso
        // Adiciona um parâmetro de sucesso para evitar reenvio do formulário
        header("Location: obrigado.html?status=success");
        exit();
    } else {
        echo "Erro ao cadastrar: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>