<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- CSS LOCAL -->
    <link rel="stylesheet" href="style.css">

    <!-- SCRIPT LOCAL -->
    <script src="script.js"></script>
   
    <!-- FONTES -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Dela+Gothic+One&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');
    </style>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    <!-- TITULO DA PÁGINA -->
    <title>SINALIZE</title>

</head>
<body>
    <header class="row p-3">
        <div class="col">
            <img class="HamburguerMenu" src="Imagens/Logo_SinalizeV2.png" alt="Logo da Sinalize">
        </div>
        <div class="col col-lg-6">
            <input class="SearchBar" type="text" placeholder="Pesquisar aulas">
        </div>
        <div class="col-lg-3 d-flex justify-content-end align-items-center">
            <?php if (isset($_SESSION['username'])): ?>
                <span class="navbar-text">
                     <?php echo htmlspecialchars($_SESSION['username']); ?>
                </span>
            <?php else: ?>
                <a href="CadastroUsuario/Login.php" class="btn-link">
                    <input type="button" class="btn-header" value="Login" onclick="msg()">
                </a>
                <a href="CadastroUsuario/Cadastro.php" class="btn-link">
                    <input type="button" class="btn-header" value="Cadastro" onclick="msg()">
                </a>
            <?php endif; ?>
        </div>
    </header>
    <aside class="p-3">
        <div class="row mb-3">
            <a href="Aulas.php">
                <img src="Imagens/AulasImg.png" alt="Botão da página das aulas">           
            </a>
        </div>
        <div class="row mb-3">
            <a href="Dicionario.php">
                <img src="Imagens/DicionarioImg.png" alt="Botão da página de dicionário">
            </a>
        </div>
        <div class="row mb-3">
            <a href="Tradutor.php">
                <img class="TradImg" src="Imagens/Tradutor.png" alt="Botão da função de tradutor">
            </a>
        </div>
        <div class="row mb-3">
            
            <a href="chatbot/chatbot.php">
                <img class="TradImg" src="Imagens/ChatBotIcon.png" alt="Botão da função de chatbot">
            </a>
        </div>
        <div class="row mb-3">
            <a href="Comunidade.php">
                <img src="Imagens/Comunittyicon.png" alt="Botão da função de comunidade">
            </a>
        </div>
        <div class="row mb-3">
            <a href="Pesquisa.php">
                <img class="searchicon" src="Imagens/PesquisaIcone.png" alt="Botão da função de pesquisa">
            </a>
        </div>
    </aside>
</body>
</html>
