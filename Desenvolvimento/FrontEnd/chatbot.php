
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChatPlus</title>
    <link rel="stylesheet" href="./css/chat.css">
</head>
<body>
    <header class="cabecalho container">
        <img src="./img/logo-chatbot.svg" alt="Logo Chatbot">
        <div class="cabecalho__acoes">
            <a href="#" onclick="limparConversa()">Limpar Conversa</a>
        </div>
    </header> 
    <main class="main">
        <section class="chat container" id="chat">
            <p class="chat__bolha chat__bolha--bot">
                Olá! Eu sou o assistente virtual do Time 001
                Criado por Lucas Vizeu ~<br/><br/>
                Como posso te ajudar?
            </p>
        </section>
        <section class="entrada container">
            <div class="entrada__container">
                <input type="text" class="entrada__input" placeholder="Enviar uma mensagem" id="input">
                <button aria-label="Botão de enviar" id="botao-enviar"><img src="./img/enviar.png" alt="" style="height: 28px;"></button>
            </div>
        </section>
    </main>
    <script src="index.js"></script>
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $mensagem = $_POST['mensagem'];

    // Configurações da requisição
    $url = 'http://127.0.0.1:5000/chat';
    $data = array('mensagem' => $mensagem);

    // Inicializa o cURL
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    // Executa a requisição e captura a resposta
    $response = curl_exec($ch);
    curl_close($ch);

    // Retorna a resposta como JSON
    header('Content-Type: application/json');
    echo $response;
}
