<?php 

// Importa a classe DB que é responsável por acessar o banco de dados
// Chama o método query da classe DB
// passando a consulta SQL, o nome da classe Livro e os parâmetros necessários
// que retorna um objeto Livro
// O método fetch() busca o primeiro resultado da consulta
$livro = $database
    ->query("SELECT * FROM livros WHERE id = :id", Livro::class, ['id' => $_GET['id']])
    ->fetch();

view('livro', ['livro' => $livro]);