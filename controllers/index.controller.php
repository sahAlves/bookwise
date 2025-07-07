<?php 

$livros = Livro::all($_REQUEST['pesquisar'] ?? '');

// a função compact() cria um array associativo
// onde as chaves são os nomes das variáveis e os valores são os valores dessas variáveis
// exemplo: compact('livros') cria um array com a chave 'livros' e o valor da variável $livros
// ['livros' => $livros]
view('index', compact('livros'));