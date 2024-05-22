<?php
session_start();

if(isset($_SESSION['login_message'])) {
    echo $_SESSION['login_message'];
    unset($_SESSION['login_message']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- CSS LOCAL -->
    <link rel="stylesheet" href="../style.css">

    <!-- SCRIPT LOCAL -->
    <script src="script.js"></script>

    <!-- FONTE -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Dela+Gothic+One&display=swap');
    </style>
    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    <!-- TITULO DA PÁGINA -->
    <title>SINALIZE - LOGIN</title>
</head>
<body>
    <div class="d-flex flex-column justify-content-center m-5">
        <img class="logo-login align-self-center m-2" src="../Imagens/Logo_SinalizeV2.png" alt="LogoSinalize">
        <h1 class="logo-login-title align-self-center">SINALIZE</h1>
        <p class="welcome-message align-self-center">Bem vindo de volta!<br>Por favor insira suas informações</p>
    </div>
    <form action="autenticacao.php" method="post" class="d-flex flex-column">
        <input class="campoLogin w-50 m-2 align-self-center" type="text" name="nome" id="nome" placeholder="Nome..." required>
        <input class="campoLogin w-50 m-2 align-self-center" type="password" name="senha" id="senha" placeholder="Senha..." required>
        <a href="#" class="forgot-link align-self-center mb-3">Esqueci meu nome/senha</a>
        <input class="btnSend w-25 m-5 align-self-center btn-login" type="submit" name="submit" value="Entrar">
    </form>
</body>
</html>
