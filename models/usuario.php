<?php 

$path = $_SERVER["DOCUMENT_ROOT"].'/ecommerce';
include_once($path."/conexao.php");

class Usuario{
    private $id;
    private $nome;
    private $email;
    private $senha;
    private $endereco;
    private $usuarioLogged;

    public function getNome(){
        return $this->nome;
    }

    public function setNome($nome){
        $this->nome = $nome;   
    }

    public function getEmail(){
        return $this->email;
    }

    public function setEmail($email){
        $this->email = $email;
    }

    public function getSenha(){
        return $this->senha;
    }

    public function setSenha($senha){
        $this->senha = $senha;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function setUsuarioLogged($usuarioLogged){
        $this->usuarioLogged = $usuarioLogged;
    }

    public function Login(){
        $objconexao = new Conexao();
        $conexao = $objconexao->getConexao();

        $sql = "SELECT ID, Nome, Email, Senha FROM Usuarios WHERE email = '".$this->getEmail()."'";

        $resposta = $conexao->query($sql);
        $usuario = $resposta->fetch_assoc();

        if(!$usuario){
            return "Email não cadastrado";
        } 
        else if($usuario['Senha'] != $this->getSenha()){
            return "Senha Incorreta";
        }
        else{
            $this->setId($usuario["ID"]);
            return true; // Retorna true se login for bem-sucedido
        }
    }

    public function Cadastrar(){
        $objconexao = new Conexao();
        $conexao = $objconexao->getConexao();

        $sql = "INSERT INTO Usuarios (Nome, Email, Senha) VALUES('$this->nome', '$this->email', '$this->senha')";

        if(mysqli_query($conexao, $sql)){
            return "Sucesso"; // Não alterei o fluxo de sucesso
        } else{
            return "Erro"; // Fluxo de erro para caso o cadastro falhe
        }
        mysqli_close($conexao);
    }
}
?>
