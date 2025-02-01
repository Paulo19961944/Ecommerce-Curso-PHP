<?php 

$path = $_SERVER["DOCUMENT_ROOT"].'/ecommerce'; // Define o caminho principal da página
include_once($path."/conexao.php"); // Importa a Classe Conexão

class Usuario{
    private $id;
    private $nome;
    private $email;
    private $senha;
    private $endereco;
    private $usuarioLogged;
    private $key; // Adicionada a propriedade $key

    private $iv_length = 16;  // Tamanho do vetor de inicialização (IV) para AES-256-CBC

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

    // Método para criptografar a senha antes de armazená-la
    public function setSenha($senha){
        // Gera uma chave aleatória para cada usuário
        $this->key = openssl_random_pseudo_bytes(32);  // Gerando uma chave de 256 bits (32 bytes)

        // Gera um IV aleatório para a criptografia
        $iv = openssl_random_pseudo_bytes($this->iv_length);

        // Criptografa a senha
        $encrypted_password = openssl_encrypt($senha, 'AES-256-CBC', $this->key, 0, $iv);

        // Armazena a senha criptografada, o IV e a chave gerada (codificados em base64)
        $this->senha = base64_encode($encrypted_password . "::" . base64_encode($iv));
        $this->key = base64_encode($this->key);  // Armazena a chave em base64
    }

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function setUsuarioLogged($usuarioLogged){
        $this->usuarioLogged = $usuarioLogged;
    }

    // Método para verificar se a senha fornecida pelo usuário é correta
    public function verificarSenha($senha, $userKey){
        // Decodifica a senha armazenada em uma variável
        $decodedSenha = base64_decode($this->senha);

        // Separa a senha criptografada e o IV armazenado, usando uma variável intermediária
        $parts = explode("::", $decodedSenha); // Aqui usamos uma variável intermediária

        // Verifica se o explode retornou o número correto de partes
        if (count($parts) !== 2) {
            return "Formato inválido da senha armazenada.";
        }

        // Agora, podemos usar o list() com a variável intermediária
        list($encrypted_password, $encrypted_iv) = $parts;
        $iv = base64_decode($encrypted_iv);

        // Descriptografa a senha usando a chave do usuário
        $key = base64_decode($userKey);  // A chave gerada e armazenada no banco
        $decrypted_password = openssl_decrypt($encrypted_password, 'AES-256-CBC', $key, 0, $iv);

        // Compara a senha fornecida com a senha descriptografada
        return $decrypted_password === $senha;
    }

    // Método de Login
    public function Login(){
        $objconexao = new Conexao(); // Instância do Objeto Conexão
        $conexao = $objconexao->getConexao(); // Conexão com o DB

        // Certifique-se de que o email foi corretamente atribuído
        $email = $this->getEmail();
        if (empty($email)) {
            return "Email não informado";
        }

        // Prepara a consulta com um placeholder para o email
        $sql = "SELECT ID, Nome, Email, Senha, Chave FROM Usuarios WHERE email = ?";
        $stmt = $conexao->prepare($sql);

        // Vincula o parâmetro (s = string) para o email
        $stmt->bind_param("s", $email);

        // Executa a consulta
        $stmt->execute();

        // Obtém o resultado
        $resposta = $stmt->get_result();
        $usuario = $resposta->fetch_assoc(); // Busca a Resposta do Usuário

        // Validação do usuário
        if(!$usuario){
            return "Email não cadastrado";
        } 
        else if(!$this->verificarSenha($this->getSenha(), $usuario['Chave'])){
            return "Senha Incorreta";
        }
        else{
            $this->setId($usuario["ID"]);
            return true; // Retorna true se login for bem-sucedido
        }

        // Fecha a declaração e a conexão
        $stmt->close();
        $conexao->close();
    }

    // Cadastra o Usuário
    public function Cadastrar(){
        $objconexao = new Conexao(); // Instância da Classe Conexão
        $conexao = $objconexao->getConexao(); // Conecta com o DB

        // Certifique-se de que o email foi corretamente atribuído
        $email = $this->getEmail();
        if (empty($email)) {
            return "Email não informado";
        }

        // Prepara a consulta com placeholders para os valores a serem inseridos
        $sql = "INSERT INTO Usuarios (Nome, Email, Senha, Chave) VALUES (?, ?, ?, ?)";
        $stmt = $conexao->prepare($sql);

        // Vincula os parâmetros (ssss = string, string, string, string)
        $stmt->bind_param("ssss", $this->nome, $this->email, $this->senha, $this->key);

        // Executa a consulta
        if($stmt->execute()){
            return "Sucesso";
        } else{
            return "Erro";
        }

        // Fecha a declaração e a conexão
        $stmt->close();
        $conexao->close();
    }
}
?>
