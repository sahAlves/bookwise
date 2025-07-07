<?php

$livro = Livro::get($_GET['id']);

$avaliacoes = $database
    ->query("SELECT * FROM avaliacoes WHERE livro_id = :id", Avaliacao::class, ['id' => $_GET['id']])
    ->fetchAll();

view('livro', ['livro' => $livro, 'avaliacoes' => $avaliacoes]);
