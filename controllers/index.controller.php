<?php 

// Pega o valor do parâmetro 'pesquisar' da URL
// Se não existir, usa uma string vazia como padrão
$pesquisar = $_REQUEST['pesquisar'] ?? '';

/*Instancia o objeto DB, que é responsável por acessar o banco de dados
diz que quer o retorno como objetos da classe Livro
e executa a consulta SQL para buscar os livros
A consulta busca livros cujo título ou autor contenham o termo pesquisado
A partir do PHP 8 é possível nomear os parâmetros
Você pode mudar a ordem dos argumentos.
O código fica mais legível.
Não precisa passar todos os argumentos, só os que quiser.
Parâmetros nomeados permitem que você diga explicitamente qual valor vai para qual parâmetro, deixando o código mais claro e flexível!*/
$livros = $database
    ->query(
        query: "SELECT
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
                WHERE titulo LIKE :pesquisa 
                OR autor LIKE :pesquisa
                GROUP BY
                    l.id,
                    l.titulo,
                    l.autor,
                    l.descricao,
                    l.ano_de_lancamento", 
        class: Livro::class, 
        params: ['pesquisa' => "%$pesquisar%"])
    ->fetchAll();

// a função compact() cria um array associativo
// onde as chaves são os nomes das variáveis e os valores são os valores dessas variáveis
// exemplo: compact('livros') cria um array com a chave 'livros' e o valor da variável $livros
// ['livros' => $livros]
view('index', compact('livros'));