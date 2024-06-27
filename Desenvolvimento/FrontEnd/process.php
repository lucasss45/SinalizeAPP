<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mensagem = $_POST['mensagem'];

    // Execute o chatbot.py com a mensagem como argumento
    $command = escapeshellcmd("py chat2.py \"$mensagem\"");
    $output = shell_exec($command);

    // Envie a resposta de volta para o cliente
    header('Content-Type: application/json');
    echo json_encode(['resposta' => $output]);
    exit;
}
?>
//tirar header dar resposta stringzona sem json