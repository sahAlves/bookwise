<?php

// Função que carrega uma view específica com os dados fornecidos
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

// Função que chama a função dump() e encerra a execução do script
function dd(...$dump)
{
    dump($dump);
    die();
}

// Função que exibe o conteúdo de uma variável de forma legível
// Útil para depuração, semelhante ao var_dump, mas com formatação HTML
function dump(...$dump)
{
    echo "<pre>";
    var_dump($dump);
    echo "</pre>";
}

// Função que envia para o navegador um código de erro HTTP específico
// e exibe uma view correspondente ao erro
function abort($code)
{
    http_response_code($code);
    view($code);
    die();
}

// Função que retorna uma instância da classe Flash
function flash()
{
    return new Flash();
}

// Função para carregar a configuração do sistema
// Se um parâmetro for passado, retorna apenas o valor da chave especificada
function config($key = null) {
    $config = require 'config.php';
    if (strlen($key) > 0) {
        return $config[$key];
    }
    return $config;
}

// Função para verificar se o usuário está autenticado
// Retorna o usuário autenticado ou null se não estiver autenticado
function auth() {
    if (!isset($_SESSION['auth'])){
        return null;
    }
    return $_SESSION['auth'];
}
