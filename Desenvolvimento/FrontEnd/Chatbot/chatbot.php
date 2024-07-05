<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChatPlus</title>
    <!-- Adicionando Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/_reset.css">
    <link rel="stylesheet" href="../css/chat.css">
    <style>
        /* Estilos adicionais, se necessário */
        .sidebar {
            position: -webkit-sticky;
            position: sticky;
            top: 0;
            height: calc(100vh - 70px); /* Ajuste conforme o cabeçalho */
            overflow-y: auto; /* Scroll apenas na sidebar se necessário */
        }
        .sidebar__item {
            margin-bottom: 15px; /* Espaçamento entre os itens da sidebar */
        }
    </style>
</head>
<body>
    <header class="cabecalho container">
        <img src="../img/logo-chatbot.svg" alt="Logo Chatbot">
        <div class="cabecalho__acoes">
            <a href="#" onclick="limparConversa()">Limpar Conversa</a>
        </div>
    </header>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <aside class="col-md-1 sidebar">
                <div class="sidebar__item" >
                    <a href="../Aulas.php">
                        <img src="../Imagens/AulasImg.png" alt="Botão da página das aulas" width="50" height="50">           
                    </a>
                </div>
                <div class="sidebar__item">
                    <a href="../Dicionario.php">
                        <img src="../Imagens/DicionarioImg.png" alt="Botão da página de dicionário" width="50" height="50">
                    </a>
                </div>
                <div class="sidebar__item">
                    <a href="../Tradutor.php">
                        <img class="TradImg" src="../Imagens/Tradutor.png" alt="Botão da função de tradutor" width="50" height="50">
                    </a>
                </div>
                <div class="sidebar__item">
                    <a href="chatbot.php">
                        <img class="TradImg" src="../Imagens/ChatBotIcon.png" alt="Botão da função de chatbot" width="50" height="50">
                    </a>
                </div>
                <div class="sidebar__item">
                    <a href="../Comunidade.php">
                        <img src="../Imagens/Comunittyicon.png" alt="Botão da função de comunidade" width="50" height="50">
                    </a>
                </div>
                <div class="sidebar__item">
                    <a href="../Pesquisa.php">
                        <img class="searchicon" src="../Imagens/PesquisaIcone.png" alt="Botão da função de pesquisa" width="50" height="50">
                    </a>
                </div>
            </aside>
            <!-- Conteúdo principal -->
            <main class="col-md-11 main">
                <section class="content">
                    <div class="chat" id="chat">
                        <p class="chat__bolha chat__bolha--bot">
                            Olá! Eu sou o assistente educacional de Libras<br/>
                            Meu Nome é Jarvis<br/>
                            Como posso te ajudar?
                            <br/>
                        </p>
                    </div>
                    <div class="entrada">
                        <div class="entrada__container">
                            <input type="text" class="entrada__input" placeholder="Enviar uma mensagem" id="input">
                            <button aria-label="Botão de enviar" id="botao-enviar"><img src="../img/enviar.png" alt="" style="height: 28px;"></button>
                        </div>
                    </div>
                </section>
            </main>
        </div>
    </div>
    <!-- Adicionando Bootstrap JS (opcional) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="index.js"></script>
</body>
</html>



<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $mensagem = $_POST['mensagem'];

    // Configurações da requisição
    $url = 'http://localhost:8080/SinalizeAPP/Desenvolvimento/FrontEnd/Chatbot/process.php';
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
