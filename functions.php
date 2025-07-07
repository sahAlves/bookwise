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
function config($key = null)
{
    $config = require 'config.php';
    if (strlen($key) > 0) {
        return $config[$key];
    }
    return $config;
}

// Função para verificar se o usuário está autenticado
// Retorna o usuário autenticado ou null se não estiver autenticado
function auth()
{
    if (!isset($_SESSION['auth'])) {
        return null;
    }
    return $_SESSION['auth'];
}

// Calcula a média de notas (de 1 a 5 estrelas) ou retorna quantas estrelas a pessoa avaliou.
// Garante que o valor máximo seja 5 com min($media, 5).
// Define quantas estrelas serão cheias, meia ou vazias.
// Sempre exibe exatamente 5 estrelas no total.
function gerarEstrelas($data, $object = false, $media = false)
{
    // Função interna para gerar o span com o ícone
    $estrela = function ($icone) {
        $classe = $icone === 'star_outline' ? '' : 'text-yellow-500';
        return '<span class="material-icons ' . $classe . '" style="font-size:16px;">' . $icone . '</span>';
    };

    if ($media) {

        if ($object) {
            $totalAvaliacoes = count($data);

            // array_reduce percorre o array de avaliações somando o campo 'nota'.
            // $carry armazena a soma acumulada a cada iteração.
            // Usa ($carry ?? 0) para garantir que a soma comece de 0.
            $sumNotas = array_reduce($data, function ($carry, $a) {
                return ($carry ?? 0) + $a->nota;
            }) ?? 0;

            $media = $totalAvaliacoes > 0 ? $sumNotas / $totalAvaliacoes : 0;
        } else {
            $media = $data == 0 || null ? 0 : $data;
        }

        $media = min($media, 5);
        // pega apenas a parte inteira da média (ex: 4.7 vira 4)
        $cheias = floor($media);
        // Se a parte decimal for ≥ 0.5 → coloca 1 meia estrela;
        $meia = ($media - $cheias) >= 0.5 ? 1 : 0;
        // Subtrai para saber quantas estrelas vazias faltam até completar 5.
        $vazias = 5 - $cheias - $meia;
        $notaFinal = str_repeat($estrela('star'), $cheias)
            . str_repeat($estrela('star_half'), $meia)
            . str_repeat($estrela('star_outline'), $vazias);

        return $notaFinal;
    } else {
        // Considera que $avaliacoes é um objeto com a nota
        return str_repeat($estrela('star'), $data->nota);
    }
}
