<?php

// Função para buscar o endereço pelo CEP
function buscarEnderecoPorCEP($cep) {
    // Remover qualquer caracter não numérico do CEP
    $cep = preg_replace('/[^0-9]/', '', $cep);

    // Validar o CEP
    if (strlen($cep) != 8) {
        return null; // Se o CEP não tiver 8 caracteres numéricos, retorna null
    }

    // URL da API ViaCEP
    $url = "https://viacep.com.br/ws/{$cep}/json/";

    // Chama a API e pega a resposta
    $resposta = file_get_contents($url);
    $dados = json_decode($resposta, true);

    // Se a resposta da API contiver erro, retorna null
    if (isset($dados['erro'])) {
        return null;
    }

    return $dados;
}

// Verifica se o CEP foi enviado por POST
if (isset($_POST['cep']) && !empty($_POST['cep'])) {
    $cep = $_POST['cep'];
    $endereco = buscarEnderecoPorCEP($cep);

    if ($endereco) {
        // Armazenar o endereço na sessão
        session_start();
        $_SESSION['endereco'] = [
            'rua' => $endereco['logradouro'],
            'numero' => '',  // Deixe o campo "Número" em branco, pois o usuário precisa preencher
            'cidade' => $endereco['localidade'],
            'estado' => $endereco['uf']
        ];
        
        // Retorne os dados para o JavaScript
        echo json_encode([
            'rua' => $endereco['logradouro'],
            'cidade' => $endereco['localidade'],
            'estado' => $endereco['uf']
        ]);
    } else {
        echo json_encode(['erro' => 'CEP não encontrado']);
    }

    exit;
}
?>
