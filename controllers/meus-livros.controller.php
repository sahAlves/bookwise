<?php

if (!auth()) {
    header('Location: /');
    exit();
}

$livros = $database->query("SELECT * FROM livros
                            WHERE usuario_id = :id",
                        class: Livro::class,
                        params: ['id' => auth()->id]);

view('meus-livros', compact('livros'));