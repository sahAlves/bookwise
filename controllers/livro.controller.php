<?php

// Importa a classe DB que é responsável por acessar o banco de dados
// Chama o método query da classe DB
// passando a consulta SQL, o nome da classe Livro e os parâmetros necessários
// que retorna um objeto Livro
// O método fetch() busca o primeiro resultado da consulta
$livro = $database
    ->query("SELECT
                l.id,
                l.titulo,
                l.autor,
                l.descricao,
                l.ano_de_lancamento,
                round(sum(a.nota) / count(a.id), 1) AS nota_avaliacao,
                count(a.id) AS count_avaliacoes
            FROM
                livros AS l
            LEFT JOIN avaliacoes AS a ON a.livro_id = l.id
            WHERE
                l.id = :id
            GROUP BY
                l.id,
                l.titulo,
                l.autor,
                l.descricao,
                l.ano_de_lancamento", Livro::class, ['id' => $_GET['id']])
    ->fetch();

$avaliacoes = $database
    ->query("SELECT * FROM avaliacoes WHERE livro_id = :id", Avaliacao::class, ['id' => $_GET['id']])
    ->fetchAll();

view('livro', ['livro' => $livro, 'avaliacoes' => $avaliacoes]);
