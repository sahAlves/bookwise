<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $validacoes = [];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $email_confirmacao = $_POST['email_confirmacao'];
    $senha = $_POST['senha'];

    // A função strlen verifica o tamanho da string
    // e retorna 0 se a string estiver vazia
    if (strlen($nome) == 0) {
        $validacoes[] = 'O nome é obrigatório.';
    }

    // A função filter_var valida o email
    // e retorna false se o email for inválido
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $validacoes[] = 'O email é inválido.';
    }

    if ($email != $email_confirmacao) {
        $validacoes[] = 'O email de confirmação está diferente.';
    }

    if (strlen($senha) == 0) {
        $validacoes[] = 'A senha é obrigatório.';
    }

    if (strlen($senha) < 8 || strlen($senha) > 30) {
        $validacoes[] = 'A senha precisa ter entre 8 e 30 caracteres.';
    }

    if (!str_contains($senha, '*')) {
        $validacoes[] = 'A senha precisa ter um * nela.';
    }

    if (sizeof($validacoes) > 0) {
        $_SESSION['validacoes'] = $validacoes;
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

    header('Location: /login?mensagem=Registrado com sucesso!');
    exit();
}