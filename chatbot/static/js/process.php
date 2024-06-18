<?php
    $mensagem = $_REQUEST['mensagem'];

    // Execute o chatbot.py com a mensagem como argumento
    $command = escapeshellcmd("python3 chatbot.py " . escapeshellarg($mensagem));
    $output = shell_exec($command);
    // http://localhost:8080/SinalizeAPP/chatbot/static/js/process.php?mensagem=ola%20mundo
    // Envie a resposta de volta para o cliente
    echo json_encode(['resposta' => $output]);
?>
// http://localhost:8080/SinalizeAPP/chatbot/static/js/process.php?mensagem=ola%20mundo