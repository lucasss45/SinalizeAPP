<?php
session_start();
$mysqli = new mysqli("localhost", "usuario", "senha", "nome_do_banco_de_dados");

if ($mysqli->connect_errno) {
    echo "Falha ao conectar ao MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

$email = $_POST['email'];
$senha = $_POST['senha'];

$sql = "SELECT id, nome, senha FROM usuarios WHERE email = '$email'";
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($senha, $row['senha'])) {
        $_SESSION['id'] = $row['id'];
        $_SESSION['nome'] = $row['nome'];
        header("Location: perfil.php");
    } else {
        echo "Senha incorreta";
    }
} else {
    echo "Usuário não encontrado";
}

$mysqli->close();
?>