<?php
require 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

class Conexao{
    public function getConexao() {
        // Dados de Conexão
        $host = getenv('HOST');
        $db = getenv('DB');
        $usuariodb = getenv('USUARIODB');
        $senhadb = getenv('SENHADB');

        // Criando a Conexão
        $conexao = new mysqli($host, $usuariodb, $senhadb, $db);
        
        // Verifica se foi possível conectar com o banco de dados
        if($conexao->connect_error) {
            die("Erro de Conexão com localhost, o seguinte erro ocorreu -> ".$conexao->connect_error);
        }
        
        return $conexao;
    }
}
?>
