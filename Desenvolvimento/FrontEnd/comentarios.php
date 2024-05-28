<?php
$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'Sinalize';

$conexao = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

if ($conexao->connect_errno) {
    echo "Erro na conexão: ". $conexao->connect_error;
    exit();
}

// Create comments table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS comentarios (
    ID int(11) NOT NULL AUTO_INCREMENT,
    Usuario_ID int(11) NOT NULL,
    Comentario text NOT NULL,
    Submit_Date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (ID),
    FOREIGN KEY (Usuario_ID) REFERENCES usuarios(ID)
)";
if (!$conexao->query($sql)) {
    echo "Erro ao criar tabela de comentários: ". $conexao->error;
    exit();
}

// Insert new comment
if (isset($_POST['submit'])) {
    $usuario_id = $_SESSION['user_id'];
    $comentario = $_POST['comentario'];
    $sql = "INSERT INTO comentarios (Usuario_ID, Comentario) VALUES ('$usuario_id', '$comentario')";
    if (!$conexao->query($sql)) {
        echo "Erro ao inserir comentário: ". $conexao->error;
        exit();
    }
}

// Display all comments
$sql = "SELECT c.ID, c.Usuario_ID, c.Comentario, c.Submit_Date, u.Nome FROM comentarios c INNER JOIN usuarios u ON c.Usuario_ID = u.ID ORDER BY c.Submit_Date DESC";
$result = $conexao->query($sql);
if (!$result) {
    echo "Erro ao buscar comentários: ". $conexao->error;
    exit();
}

while ($row = $result->fetch_assoc()) {
    echo "<p><strong>". $row['Nome']. "</strong> - ". $row['Submit_Date']. "</p>";
    echo "<p>". $row['Comentario']. "</p>";
    echo "<hr>";
}

$conexao->close();
?>