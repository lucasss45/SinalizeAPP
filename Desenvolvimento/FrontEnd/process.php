<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mensagem = $_POST['mensagem'];

    // Execute o chatbot.py com a mensagem como argumento
    $command = escapeshellcmd("python3 chatbot.py " . escapeshellarg($mensagem));
    $output = shell_exec($command);

    // Envie a resposta de volta para o cliente
    echo json_encode(['resposta' => $output]);
}
?>
