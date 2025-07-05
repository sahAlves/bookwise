<?php

function view($view, $data = [])
{
    // $$ é usado para criar variáveis dinâmicas
    // $nome = 'livros';
    // $$nome = ['Senhor dos Anéis', '1984'];
    // Agora, existe uma variável chamada $livros
    // echo $livros[0]; // Vai mostrar: Senhor dos Anéis
    // Assim, podemos usar $livros diretamente na view
    foreach ($data as $key => $value) {
        $$key = $value;
    }
    require "views/template/app.php";
}

function dd(...$dump)
{
    dump($dump);
    die();
}

function dump(...$dump)
{
    echo "<pre>";
    var_dump($dump);
    echo "</pre>";
}

function abort($code)
{
    http_response_code($code);
    view($code);
    die();
}

function flash()
{
    return new Flash();
}
