<?php

namespace App\Repositories;

use App\Model\Entity\Address;

abstract class CepData
{
    abstract protected function cep(string $cep, Address $entity): bool;
    abstract protected function preencherDadosEndereco(Address $entity, array $cepData): Address;
}
