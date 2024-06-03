<?php
session_start();

if(isset($_POST['comentario_id'])) {
    $comentario_id = $_POST['comentario_id'];

    $dbHost = 'localhost';
    $dbUsername = 'root';
    $dbPassword = '';
    $dbName = 'Sinalize';

    $conexao = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

    if ($conexao->connect_errno) {
        echo "Erro na conexão: ". $conexao->connect_error;
        exit();
    }

    // Atualizar o contador de curtidas no banco de dados
    $sql = "UPDATE comentarios SET Curtidas = Curtidas + 1 WHERE ID = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $comentario_id);
    $stmt->execute();

    // Verificar se a atualização foi bem-sucedida e retornar o número atualizado de curtidas
    if ($stmt->affected_rows > 0) {
        // Obter o número atualizado de curtidas
        $sql = "SELECT Curtidas FROM comentarios WHERE ID = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("i", $comentario_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $curtidas = $row['Curtidas'];

        echo $curtidas; // Retornar o número atualizado de curtidas
    } else {
        echo "Erro ao registrar a curtida.";
    }

    $conexao->close();
} else {
    echo "ID do comentário não recebido.";
}
?>
