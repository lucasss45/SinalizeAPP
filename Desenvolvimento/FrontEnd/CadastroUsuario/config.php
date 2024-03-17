<?php
    $dbHost = 'localhost';
    $dbUsername = 'root';
    $dbPassword = '';
    $dbName = 'sinalize';

    $conexao = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

    if ($conexao-connect_errno){
        echo "ERRO";
    } else {
        echo "Conexão bem sucedida";
    }
?>