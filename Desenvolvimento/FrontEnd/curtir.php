<?php
session_start();

if (isset($_POST['comentario_id'])) {
    $comentario_id = $_POST['comentario_id'];
    $usuario_id = $_SESSION['user_id'];

    $dbHost = 'localhost';
    $dbUsername = 'root';
    $dbPassword = '';
    $dbName = 'Sinalize';

    $conexao = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

    if ($conexao->connect_errno) {
        echo "Erro na conexão: " . $conexao->connect_error;
        exit();
    }

    // Verificar se o usuário já curtiu o comentário
    $sql = "SELECT * FROM likes WHERE Comentario_ID = ? AND Usuario_ID = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("ii", $comentario_id, $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Usuário já curtiu, então remove a curtida
        $sql = "DELETE FROM likes WHERE Comentario_ID = ? AND Usuario_ID = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("ii", $comentario_id, $usuario_id);
        $stmt->execute();

        $sql = "UPDATE comentarios SET Curtidas = Curtidas - 1 WHERE ID = ? AND Curtidas > 0";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("i", $comentario_id);
        $stmt->execute();
    } else {
        // Usuário ainda não curtiu, então adiciona a curtida
        $sql = "INSERT INTO likes (Comentario_ID, Usuario_ID) VALUES (?, ?)";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("ii", $comentario_id, $usuario_id);
        $stmt->execute();

        $sql = "UPDATE comentarios SET Curtidas = Curtidas + 1 WHERE ID = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("i", $comentario_id);
        $stmt->execute();
    }

    // Obter o número atualizado de curtidas
    $sql = "SELECT Curtidas FROM comentarios WHERE ID = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $comentario_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $curtidas = $row['Curtidas'];

    echo $curtidas;

    $conexao->close();
} else {
    echo "ID do comentário não recebido.";
}
?>
