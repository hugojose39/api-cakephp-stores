<?php

namespace App\Repositories;

use App\Model\Entity\Address;

class ViaCep extends CepData
{
    public function cep(string $cep, Address $entity): bool
    {
        $url ="https://viacep.com.br/ws/{$cep}/json/";
        // Realiza a requisição HTTP para obter os dados do CEP
        $jsonResponse = @file_get_contents($url);
        // Verifica se a requisição foi bem-sucedida e se há dados retornados
        if ($jsonResponse !== false) {
            // Decodifica os dados JSON em um array associativo
            $cepData = json_decode($jsonResponse, true);
            // Verifica se os dados retornados contêm informações válidas
            if (is_array($cepData) && !isset($cepData['erro'])) {
                $this->preencherDadosEndereco($entity, $cepData);
                // Retorna os dados do CEP

                return true;
            }
        }
        // Retorna falso se a requisição falhou ou se os dados do CEP não forem válidos
        return false;
    }

    protected function preencherDadosEndereco(Address $entity, array $cepData): Address
    {
        $entity->city = $cepData['localidade'];
        $entity->state = $cepData['uf'];
        $entity->sublocality = $cepData['bairro'];
        $entity->street = $cepData['logradouro'];
        $entity->complement = $cepData['complemento'];

        return $entity;
    }
}
