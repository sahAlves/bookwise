<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Retorna um objeto de validação
    // Validacao::validar() recebe um array de regras e os dados do formulário
    $validacao = Validacao::validar([
        'nome' => ['required'],
        'email' => ['required', 'email', 'confirmed'],
        'senha' => ['required', 'min:8', 'max:30', 'strong']
    ], $_POST);

    // Verifica se a validação falhou
    if($validacao->naoPassou('registrar')) {
        header('Location: /login');
        exit();
    }

   $database
        ->query(
            query: "INSERT INTO usuarios ( nome, email, senha ) values ( :nome, :email, :senha )",
            params: [
                'nome' => $_POST['nome'],
                'email' => $_POST['email'],
                'senha' => $_POST['senha']
            ]);

    flash()->push('mensagem', 'Registrado com sucesso! 👍🏻');
    header('Location: /login');
    exit();
}