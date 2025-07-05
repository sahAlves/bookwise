<?php

$mensagem = $_REQUEST['mensagem'] ?? '';  

// 1. Receber o formulário com email e senha
if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $validacao = Validacao::validar([
        'email' => ['required', 'email'],
        'senha' => ['required']
    ], $_POST);

    // Verifica se a validação falhou
    if($validacao->naoPassou()) {
        header('Location: /login');
        exit();
    }

// 2. Fazer uma consulta no banco de dados com o email e senha
    $usuario = $database
                    ->query(
                    query: "SELECT * 
                        FROM usuarios
                        WHERE email = :email
                        AND senha = :senha",
                    class: Usuario::class,
                    params: compact('email', 'senha'))
                    ->fetch();
                    
    if($usuario) {
        // 3. Se existir, nós vamos adicionar na sessão que o usuário está autenticado
        $_SESSION['auth'] = $usuario;
        $_SESSION['mensagem'] = 'Seja bem vindo ' . $usuario->nome . '!';
        header('Location: /');
        exit();
    }
}

view('login', compact('mensagem'));