<?php

// 1. Receber o formulário com email e senha
if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $validacao = Validacao::validar([
        'email' => ['required', 'email'],
        'senha' => ['required']
    ], $_POST);

    // Verifica se a validação falhou
    if($validacao->naoPassou('login')) {
        header('Location: /login');
        exit();
    }

    // 2. Fazer uma consulta no banco de dados com o email e senha
    $usuario = $database
                    ->query(
                    query: "SELECT * 
                        FROM usuarios
                        WHERE email = :email",
                    class: Usuario::class,
                    params: compact('email'))
                    ->fetch();
                    
    if($usuario) {

        //Validar a senha
        if(!password_verify($senha, $usuario->senha)) {
            flash()->push('validacoes_login', ['Usuário ou senha estão incorretos!']);
            header('Location: /login');
            exit();
        }

        $_SESSION['auth'] = $usuario;
        flash()->push('mensagem', 'Seja bem vindo ' . $usuario->nome . '!');
        header('Location: /');
        exit();
    }
}

view('login');