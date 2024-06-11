<!DOCTYPE html:5>
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
        <div class="col">
            <a href="CadastroUsuario/Login.php">
                <img class="ProfileButton" src="Imagens/ExPictureHere.png" alt="Botão de perfil do usuário">
            </a>
            <a href = "CadastroUsuario/Cadastro.php">
                <img class="ProfileButton" src="Imagens/ExPictureHere.png" alt="Botão de perfil do usuário">
            </a>
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
        <div class="row">
            <a href="Tradutor.php">
                <img class="TradImg" src="Imagens/Tradutor.png" alt="Botão da função de tradutor">
            </a>
        </div>
        <div class="row">
            <a href="Comunidade.php">
                <img class="TradImg" src="Imagens/Tradutor.png" alt="Botão da função de tradutor">
            </a>
        </div>
        <div class="row">
            <a href="Pesquisa.php">
                <img class="TradImg" src="Imagens/Tradutor.png" alt="Botão da função de tradutor">
            </a>
        </div>
</aside>