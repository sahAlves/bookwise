<?php 

class DB {

    private $db;

    /**
     * Construtor da classe DB
     * Inicializa a conexão com o banco de dados SQLite
     */
    public function __construct($config) {
        $this->db = new PDO($this->getDsn($config));
    }

    // Constrói o DSN (Data Source Name) para a conexão
    private function getDsn($config) {
        $driver = $config['driver'];
        unset($config['driver']);
    
        // a função http_build_query() cria uma string concatenando os parâmetros do array $config
        // com o formato 'key1=value1;key2=value2;...'
        $dsn = $driver . ':' . http_build_query($config, '', ';'); 
        if ($driver == 'sqlite') {
            $dsn = $driver . ':' . $config['database'];
        }

        return $dsn;
    }

    /**
     * Executa uma consulta SQL e retorna o resultado
     *
     * @param string $query A consulta SQL a ser executada
     * @param string|null $class O nome da classe para mapear o resultado
     * @param array $params Parâmetros opcionais para a consulta
     * @return PDOStatement O resultado da consulta
     */
    public function query($query, $class = null, $params = []) {
        // Prepara a consulta SQL
        $prepare = $this->db->prepare($query);

        if ($class) {
            // Define o modo de busca para retornar uma instância da classe especificada
            $prepare->setFetchMode(PDO::FETCH_CLASS, $class);
        }
        
        // Executa a consulta
        // Utiliza bindValue para evitar SQL Injection
        // Se houver parâmetros, eles são passados para a consulta
        $prepare->execute($params);
        
        // Retorna o resultado da consulta
        return $prepare;
    }
}

$database = new DB($config['database']);