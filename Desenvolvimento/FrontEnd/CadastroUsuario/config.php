<?php
    $dbHost = 'localhost';
    $dbUsername = 'root';
    $dbPassword = '';
    $dbName = 'sinalize';

    $conexao = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

    if ($conexao->connect_errno){
        echo "Erro na conexão: " . $conexao->connect_error;
    } else {
        echo "Conexão bem sucedida";
    }

    $conexao->close();
?>