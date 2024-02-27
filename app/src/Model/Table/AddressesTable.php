<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Addresses Model
 *
 * @property \App\Model\Table\StoresTable&\Cake\ORM\Association\BelongsTo $Stores
 *
 * @method \App\Model\Entity\Address newEmptyEntity()
 * @method \App\Model\Entity\Address newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Address[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Address get($primaryKey, $options = [])
 * @method \App\Model\Entity\Address findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Address patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Address[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Address|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Address saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Address[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Address[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Address[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Address[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AddressesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('addresses');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Stores', [
            'foreignKey' => 'store_id',
            'joinType' => 'INNER',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('store_id')
            ->notEmptyString('store_id');

        $validator
            ->scalar('postal_code')
            ->maxLength('postal_code', 8, 'O CEP deve ter no máximo 8 caracteres.')
            ->requirePresence('postal_code', 'create', 'O CEP é obrigatório.')
            ->notEmptyString('postal_code', 'Por favor, preencha o CEP.');

        $validator
            ->scalar('state')
            ->maxLength('state', 2, 'O estado deve ter no máximo 2 caracteres.')
            ->requirePresence('state', 'create', 'O estado é obrigatório.')
            ->notEmptyString('state', 'Por favor, preencha o estado.');

        $validator
            ->scalar('city')
            ->maxLength('city', 200, 'A cidade deve ter no máximo 200 caracteres.')
            ->requirePresence('city', 'create', 'A cidade é obrigatória.')
            ->notEmptyString('city', 'Por favor, preencha a cidade.');

        $validator
            ->scalar('sublocality')
            ->maxLength('sublocality', 200, 'O bairro deve ter no máximo 200 caracteres.')
            ->requirePresence('sublocality', 'create', 'O bairro é obrigatório.')
            ->notEmptyString('sublocality', 'Por favor, preencha o bairro.');

        $validator
            ->scalar('street')
            ->maxLength('street', 200, 'A rua deve ter no máximo 200 caracteres.')
            ->requirePresence('street', 'create', 'A rua é obrigatória.')
            ->notEmptyString('street', 'Por favor, preencha a rua.');

        $validator
            ->scalar('street_number')
            ->maxLength('street_number', 200, 'O número deve ter no máximo 200 caracteres.')
            ->requirePresence('street_number', 'create', 'O número é obrigatório.')
            ->notEmptyString('street_number', 'Por favor, preencha o número.');

        $validator
            ->scalar('complement')
            ->maxLength('complement', 200, 'O complemento deve ter no máximo 200 caracteres.')
            ->notEmptyString('complement', 'Por favor, preencha o complemento.');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn('store_id', 'Stores'), [
            'errorField' => 'store_id',
            'message' => 'Loja inexistente.'
        ]);

        return $rules;
    }

    public function beforeSave($event, $entity, $options)
    {
        if ($entity->isDirty('postal_code')) {
            // Implemente aqui a lógica de consulta à API de CEP
            $cepData = $this->consultarCep($entity->postal_code);

            if (!$cepData) {
                // Se os dados não forem encontrados na primeira API, consulte na segunda API
                $cepData = $this->consultarOutroCep($entity->postal_code);
            }

            if ($cepData) {
                // Preencha os demais campos do endereço com os dados obtidos
                $entity = $this->preencherDadosEndereco($entity, $cepData);
            } else {
                // Se os dados não forem encontrados em nenhuma API, emita o erro
                $entity->setError('postal_code', 'CEP não encontrado');
                return false;
            }
        }
    }

    // Método para consultar a primeira API de CEP
    private function consultarCep($cep)
    {
        // Implemente aqui a lógica para consultar a primeira API de CEP (por exemplo, CEP Lá)
    }

    // Método para consultar a segunda API de CEP
    private function consultarOutroCep($cep)
    {
        // Implemente aqui a lógica para consultar a segunda API de CEP (por exemplo, Via CEP)
    }

    // Método para preencher os dados do endereço com base nos dados do CEP
    private function preencherDadosEndereco($entity, $cepData)
    {
        // Implemente aqui a lógica para preencher os demais campos do endereço com base nos dados do CEP
        // Por exemplo:
        $entity->city = $cepData['city'];
        $entity->state = $cepData['state'];
        // ... e assim por diante

        return $entity;
    }
}
