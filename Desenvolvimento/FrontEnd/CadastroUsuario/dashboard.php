<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html:5>
<html lang="en">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- CSS LOCAL -->
    <link rel="stylesheet" href="style.css">

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
    <title>SINALIZE - DASHBOARD</title>
<body>
    <div class="d-flex justify-content-center m-5">
        <img class="logo-login" src="Imagens/Logo_SinalizeV2.png" alt="LogoSinalize">
        <h1 class="logo-login-title">SINALIZE</h1>
    </div>
    <h1>Bem-vindo novamente, <?php echo $_SESSION['username']; ?>!</h1>
    <p>Aqui você pode acessar informações e funcionalidades exclusivas para usuários autenticados.</p>

    <a href="logout.php">Sair</a>
    <footer class="d-flex justify-content-between position-fixed bottom-0">
        <img class="placeholder" src="Imagens/placeholder.png" alt="placeholder">
        <img class="placeholder" src="Imagens/placeholder.png" alt="placeholder">
        <img class="placeholder" src="Imagens/placeholder.png" alt="placeholder">
    </footer>
</body>
  
</html>
