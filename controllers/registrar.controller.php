<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   $database
        ->query(
            query: "INSERT INTO usuarios ( nome, email, senha ) values ( :nome, :email, :senha )",
            params: [
                'nome' => $_POST['nome'],
                'email' => $_POST['email'],
                'senha' => $_POST['senha']
            ]);

    header('Location: /login?mensagem=Registrado com sucesso!');
    exit();
}