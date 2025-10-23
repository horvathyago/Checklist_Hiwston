<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Event\EventInterface;
use Cake\ORM\Entity;
use Cake\Validation\Validator;
use Cake\ORM\RulesChecker;
use Authentication\PasswordHasher\DefaultPasswordHasher;

class UsersTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('users');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('name')
            ->maxLength('name', 100)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email')
            ->add('email', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->requirePresence('password', 'create')
            ->notEmptyString('password');

        $validator
            ->scalar('role')
            ->allowEmptyString('role');

        return $validator;
    }

    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['email']), ['errorField' => 'email']);
        return $rules;
    }

    public function beforeSave(EventInterface $event, Entity $entity, \ArrayObject $options)
    {
        if (!empty($entity->password)) {
            $hasher = new DefaultPasswordHasher();
            $entity->password = $hasher->hash($entity->password);
        }
    }
}
