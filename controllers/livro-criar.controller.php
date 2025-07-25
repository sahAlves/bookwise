<?php

if( $_SERVER['REQUEST_METHOD'] != 'POST' ) {
    header('Location: /meus-livros');
    exit;
}

if(!auth()) {
    abort(403);
}

$usuario_id = auth()->id;
$titulo = $_POST['titulo'];
$autor = $_POST['autor'];
$descricao = $_POST['descricao'];
$ano_de_lancamento = $_POST['ano_de_lancamento'];

$validacao = Validacao::validar([
        'titulo' => ['required', 'min:3'],
        'autor' => ['required'],
        'descricao' => ['required'],
        'ano_de_lancamento' =>['required']
    ], $_POST);

// Verifica se a validação falhou
if($validacao->naoPassou()) {
    header('Location: /meus-livros');
    exit();
}

$novoNome = md5(rand());
$extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
$imagem = "images/$novoNome.$extensao";
move_uploaded_file($_FILES['imagem']['tmp_name'], __DIR__ . '/../public/' . $imagem);


$database->query("INSERT INTO livros 
                ( titulo, autor, descricao, ano_de_lancamento, usuario_id, imagem )
                VALUES
                ( :titulo, :autor, :descricao, :ano_de_lancamento, :usuario_id, :imagem )",
                params: compact('titulo', 'autor', 'descricao', 'ano_de_lancamento', 'usuario_id', 'imagem'));

flash()->push('mensagem', 'Livro cadastrado com sucesso!');
header('Location: /meus-livros');
exit();