<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'Sinalize';

$conexao = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

if ($conexao->connect_errno) {
    echo "Erro na conexão: " . $conexao->connect_error;
    exit();
}

$sql = "DESCRIBE comentarios";
if (!$conexao->query($sql)) {
    $sql = "CREATE TABLE IF NOT EXISTS comentarios (
        ID int(11) NOT NULL AUTO_INCREMENT,
        Usuario_ID int(11) NOT NULL,
        Comentario text NOT NULL,
        Submit_Date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
        Curtidas int DEFAULT 0,
        Topico ENUM('Avaliações', 'Sugestões', 'Dúvidas'),
        PRIMARY KEY (ID),
        FOREIGN KEY (Usuario_ID) REFERENCES usuarios(ID)
    ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

    if (!$conexao->query($sql)) {
        echo "Erro ao criar tabela de comentários: " . $conexao->error;
        exit();
    }
} else {
    $sql = "SHOW COLUMNS FROM comentarios LIKE 'Curtidas'";
    $result = $conexao->query($sql);
    if ($result->num_rows == 0) {
        $sql = "ALTER TABLE comentarios ADD COLUMN Curtidas int DEFAULT 0";
        if (!$conexao->query($sql)) {
            echo "Erro ao adicionar coluna Curtidas: " . $conexao->error;
            exit();
        }
    }
}

if (isset($_POST['submit'])) {
    $usuario_id = $_SESSION['user_id'];
    $comentario = $_POST['comentario'];
    $topico = $_POST['topico'];
    $sql = "INSERT INTO comentarios (Usuario_ID, Comentario, Topico) VALUES (?,?,?)";
    $stmt = $conexao->prepare($sql);
    if (!$stmt) {
        echo "Erro ao preparar consulta: " . $conexao->error;
        exit();
    }
    $stmt->bind_param("iss", $usuario_id, $comentario, $topico);
    $stmt->execute();
}

$sql = "SELECT c.ID, c.Usuario_ID, c.Comentario, c.Submit_Date, c.Curtidas, c.Topico, u.Nome 
        FROM comentarios c 
        INNER JOIN usuarios u ON c.Usuario_ID = u.ID 
        ORDER BY c.Submit_Date DESC";
$result = $conexao->query($sql);
if (!$result) {
    echo "Erro ao buscar comentários: " . $conexao->error;
    exit();
}

$topicos = array(
    'Avaliações' => array(),
    'Sugestões' => array(),
    'Dúvidas' => array()
);

while ($row = $result->fetch_assoc()) {
    $topicos[$row['Topico']][] = $row;
}

echo "<div class='comentarios-section'>";
foreach ($topicos as $topico => $comentarios) {
    echo "<h4>$topico</h4>";
    foreach ($comentarios as $comentario) {
        $data = date('d/m/Y', strtotime($comentario['Submit_Date']));
        echo "<div class='comentario'>";
        echo "<p class='info'><span><strong>" . $comentario['Nome'] . " - " . $data . "</strong></span></p>";
        echo "<p class='comentario-texto'>". $comentario['Comentario']. "</p>";
        echo "<button class='curtir-btn' data-comentario-id='".$comentario['ID']."'>Curtir</button>";
        echo "<span class='curtidas'>";
        echo isset($comentario['Curtidas']) ? $comentario['Curtidas'] : '0'; 
        echo " curtidas</span>";
        echo "</div><hr>";
    }
}
echo "</div>";

$conexao->close();
?>