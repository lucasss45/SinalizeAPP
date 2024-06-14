<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    http_response_code(403); // Usuário não autorizado
    exit();
}

if (!isset($_POST['comentario_id'])) {
    http_response_code(400); // Requisição inválida
    exit();
}

$comentario_id = $_POST['comentario_id'];

$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'Sinalize';

$conexao = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

if ($conexao->connect_errno) {
    http_response_code(500); // Erro de conexão
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM likes WHERE Usuario_ID = ? AND Comentario_ID = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("ii", $user_id, $comentario_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Já curtiu, então remover curtida
    $sql_delete = "DELETE FROM likes WHERE Usuario_ID = ? AND Comentario_ID = ?";
    $stmt_delete = $conexao->prepare($sql_delete);
    $stmt_delete->bind_param("ii", $user_id, $comentario_id);
    $stmt_delete->execute();

    $sql_update_curtidas = "UPDATE comentarios SET Curtidas = Curtidas - 1 WHERE ID = ?";
    $stmt_update_curtidas = $conexao->prepare($sql_update_curtidas);
    $stmt_update_curtidas->bind_param("i", $comentario_id);
    $stmt_update_curtidas->execute();
} else {
    // Não curtiu ainda, então adicionar curtida
    $sql_insert_like = "INSERT INTO likes (Usuario_ID, Comentario_ID) VALUES (?, ?)";
    $stmt_insert_like = $conexao->prepare($sql_insert_like);
    $stmt_insert_like->bind_param("ii", $user_id, $comentario_id);
    $stmt_insert_like->execute();

    $sql_update_curtidas = "UPDATE comentarios SET Curtidas = Curtidas + 1 WHERE ID = ?";
    $stmt_update_curtidas = $conexao->prepare($sql_update_curtidas);
    $stmt_update_curtidas->bind_param("i", $comentario_id);
    $stmt_update_curtidas->execute();
}

// Recuperar o número atualizado de curtidas
$sql_select_curtidas = "SELECT Curtidas FROM comentarios WHERE ID = ?";
$stmt_select_curtidas = $conexao->prepare($sql_select_curtidas);
$stmt_select_curtidas->bind_param("i", $comentario_id);
$stmt_select_curtidas->execute();
$result_select_curtidas = $stmt_select_curtidas->get_result();
$row = $result_select_curtidas->fetch_assoc();
echo $row['Curtidas'];

$conexao->close();
?>
