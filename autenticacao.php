<?php
$server = "localhost";
$usuario = "root";
$senha = "";
$banco = "login";

// cria a conexão
$conn = new mysqli($server, $usuario, $senha, $banco);

// verifica conexão
if ($conn->connect_error) {
    die("Falha ao se comunicar com o banco de dados: " . $conn->connect_error);
}

// verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // evita erro caso algum campo não venha preenchido
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $tipodecolaborador = $_POST['colaborador'] ?? '';
    $data = date('d/m/Y');
    $hora = date('H:i:s');

    // prepara o comando SQL
    $stmt = $conn->prepare('INSERT INTO cadastros (nome, email, tipodecolaborador, data, hora) VALUES (?, ?, ?, ?, ?)');
    $stmt->bind_param("sssss", $nome, $email, $tipodecolaborador, $data, $hora);

    // executa e verifica resultado
    if ($stmt->execute()) {
       header("Location: index.html"); 
        exit();
        
    } else {
        echo "Erro ao cadastrar: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
