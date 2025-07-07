<?php

/**
 * Representação de 1 Registro do banco de dados
 * em forma de CLASSE
 */
class Livro
{
    public $id;
    public $titulo;
    public $autor;
    public $descricao;
    public $ano_de_lancamento;
    public $usuario_id;
    public $nota_avaliacao;
    public $count_avaliacoes;

    public function query($where, $params) {
        $db = new Database(config('database'));
        return $db->query("SELECT
                            l.id,
                            l.titulo,
                            l.autor,
                            l.descricao,
                            l.ano_de_lancamento,
                            ifnull(round(sum(a.nota) / count(a.id), 1),0) AS nota_avaliacao,
                            ifnull(count(a.id),0) AS count_avaliacoes
                        FROM
                            livros AS l
                        LEFT JOIN avaliacoes AS a ON a.livro_id = l.id
                        WHERE
                            $where
                        GROUP BY
                            l.id,
                            l.titulo,
                            l.autor,
                            l.descricao,
                            l.ano_de_lancamento", self::class, $params);
    }

    public static function get($id)
    {
        return (new self)->query('l.id = :id',['id' => $id])->fetch();
    }

    public static function all($filtro = '') {
        return (new self)->query('titulo LIKE :pesquisa 
                        OR autor LIKE :pesquisa', ['pesquisa' => "%$filtro%"])->fetchAll();
    }

    public static function meus($usuario_id) {
        return (new self)->query('l.usuario_id = :usuario_id',['usuario_id' => $usuario_id])->fetchAll();
    }
}
