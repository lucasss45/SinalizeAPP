<?php
if(isset($_POST['submit'])){
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);

    $dbHost = 'localhost';
    $dbUsername = 'root';
    $dbPassword = '';
    $dbName = 'sinalize';

    $conexao = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

    if ($conexao->connect_errno){
        echo "Erro na conexão: " . $conexao->connect_error;
    } else {
        $sql = "INSERT INTO usuarios (Nome, Email, Senha) VALUES (?, ?, ?)";
        $stmt = $conexao->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("sss", $nome, $email, $senhaCriptografada);
            $stmt->execute();
            echo "Usuário cadastrado com sucesso!";
            $stmt->close();
        } else {
            echo "Erro ao cadastrar usuário: " . $conexao->error;
        }

        $conexao->close();
    }
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
    <title>SINALIZE - CADASTRO</title>

</head>
<body>
    <div class="d-flex justify-content-center m-5">
        <img class="logo-login" src="Imagens/Logo_SinalizeV2.png" alt="LogoSinalize">
        <h1 class="logo-login-title">SINALIZE</h1>
    </div>
    <form action="cadastro.php" method="post">
        <h2> Cadastro Usuário</h2>
        <div class="inputBox">
            <label for="nome" class="labelInput">Nome:</label>
            <input type="text" name="nome" id="nome" class="inputUser" required>
        </div>
        <div class="inputBox">
            <label for="email" class="labelInput">Email</label>
            <input type="text" name="email" id="email" class="inputUser" required>
        </div>
        <div class="inputBox">
            <label for="senha" class="labelInput">Senha</label>
            <input type="password" name="senha" id="senha" class="inputUser" required>
        </div>
        <input type="submit" name="submit" id="submit" value="Enviar">
    </form>
    <footer class="d-flex justify-content-between position-fixed bottom-0">
        <img class="placeholder" src="Imagens/placeholder.png" alt="placeholder">
        <img class="placeholder" src="Imagens/placeholder.png" alt="placeholder">
        <img class="placeholder" src="Imagens/placeholder.png" alt="placeholder">
    </footer>
</body>
</html>
