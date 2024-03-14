<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <header class="d-flex justify-content-between p-1">
        <img class="hamburguer-round img-fluid" src="Imagens/HamburguerMenu.png" alt="Menu Opções">
        <h1 class="align-self-center text-warp m-1 fs-1">SINALIZE</h1> 
        <img class="logo img-fluid" src="Imagens/Logo_SinalizeV2.png" alt="LogoSinalize">
    </header>
    <main>
        <h2>Registro do Usuario</h2>
        <form action="registro.php" method="post">
            <label>Nome: </label>
            <input type="text" name="nome" required>
            <label>Email: </label>
            <input type="email" name="email" required>
            <label>Senha: </label>
            <input type="password" name="senha" required>
            <input type="submit" value="Cadastrar">
        </form>
    </main>
</body>
</html>