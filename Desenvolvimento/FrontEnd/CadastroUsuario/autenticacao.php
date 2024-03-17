<?php
session_start();

if(isset($_POST['submit'])){
    $nome = $_POST['nome'];
    $senha = $_POST['senha'];

    $dbHost = 'localhost';
    $dbUsername = 'root';
    $dbPassword = '';
    $dbName = 'sinalize';

    $conexao = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

    if ($conexao->connect_errno){
        echo "Erro na conexão: " . $conexao->connect_error;
    } else {
        $sql = "SELECT * FROM usuarios WHERE Nome=?";
        $stmt = $conexao->prepare($sql);
        
        if ($stmt) {
            $stmt->bind_param("s", $nome);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                if (password_verify($senha, $row['Senha'])) {
                    $_SESSION['user_id'] = $row['ID'];
                    $_SESSION['username'] = $row['Nome'];
                    $_SESSION['login_message'] = "Bem-vindo de volta, " . $row['Nome'] . "!";
                    header("Location: dashboard.php");
                    exit();
                } else {
                    echo "Senha incorreta";
                }
            } elseif ($result->num_rows == 0) {
                echo "Usuário não encontrado";
            } else {
                echo "Erro: Mais de um usuário encontrado";
            }

            $stmt->close();
        } else {
            echo "Erro na preparação da consulta";
        }

        $conexao->close();
    }
}
?>
