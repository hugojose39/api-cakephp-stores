<?php

declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\Store;
use Cake\Event\EventInterface;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Stores Model
 *
 * @property \App\Model\Table\AddressesTable&\Cake\ORM\Association\HasMany $Addresses
 *
 * @method \App\Model\Entity\Store newEmptyEntity()
 * @method \App\Model\Entity\Store newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Store[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Store get($primaryKey, $options = [])
 * @method \App\Model\Entity\Store findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Store patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Store[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Store|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Store saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Store[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Store[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Store[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Store[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class StoresTable extends Table
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

        $this->setTable('stores');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Addresses', [
            'foreignKey' => 'store_id',
            'dependent' => true,
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
            ->scalar('name')
            ->maxLength('name', 200, 'O nome deve ter no máximo 200 caracteres.')
            ->requirePresence('name', 'create', 'O nome é obrigatório.')
            ->notEmptyString('name', 'Por favor, preencha o nome.');

        $validator->requirePresence('addresses', 'Por favor, informe o endereço');

        return $validator;
    }

    /**
     * Build rules method.
     *
     * @param \Cake\ORM\RulesChecker $rules Rules object.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['name'], 'Nome em uso.'));

        return $rules;
    }

    /**
     * Before save method.
     *
     * @param \Cake\Event\EventInterface $event Event object.
     * @param \Cake\Datasource\EntityInterface $entity Entity object.
     * @param mixed $options Options array.
     * @return bool
     */
    public function beforeSave(EventInterface $event, Store $entity, mixed $options): bool
    {
        // Verifica se a entidade já existe no banco de dados
        if (!$entity->isNew()) {
            // Verifica se há dados de endereço na requisição
            if ($entity->isDirty('addresses')) {
                // Se o endereço foi alterado, primeiro exclua o endereço existente
                $existingAddresses = $this->Addresses->find()
                    ->find('all')
                    ->where(['store_id' => $entity->id])
                    ->toArray();

                foreach ($existingAddresses as $existingAddress) {
                    if ($existingAddress) {
                        $this->Addresses->delete($existingAddress);
                    }

                    continue;
                }

                // Agora, cria um novo endereço com os dados fornecidos
                $address = $this->Addresses->newEntity($entity->addresses[0]->toArray());
                // Associa o endereço à entidade da loja
                $entity->Addresses = $address;
            }
        }

        return true;
    }
}
