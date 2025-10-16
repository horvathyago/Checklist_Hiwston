<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Checklists Model
 *
 * @property \App\Model\Table\MaquinasTable&\Cake\ORM\Association\BelongsTo $Maquinas
 * @property \App\Model\Table\ChecklistEquipamentosTable&\Cake\ORM\Association\HasMany $ChecklistEquipamentos
 *
 * @method \App\Model\Entity\Checklist newEmptyEntity()
 * @method \App\Model\Entity\Checklist newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Checklist> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Checklist get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Checklist findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Checklist patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Checklist> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Checklist|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Checklist saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Checklist>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Checklist>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Checklist>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Checklist> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Checklist>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Checklist>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Checklist>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Checklist> deleteManyOrFail(iterable $entities, array $options = [])
 */
class ChecklistsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('checklists');
        $this->setDisplayField('numero_ordem_producao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Maquinas', [
            'foreignKey' => 'maquina_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('ChecklistEquipamentos', [
            'foreignKey' => 'checklist_id',
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
            ->scalar('numero_ordem_producao')
            ->maxLength('numero_ordem_producao', 255)
            ->requirePresence('numero_ordem_producao', 'create')
            ->notEmptyString('numero_ordem_producao');

        $validator
            ->scalar('cliente')
            ->maxLength('cliente', 255)
            ->allowEmptyString('cliente');

        $validator
            ->date('data_carregamento')
            ->allowEmptyDate('data_carregamento');

        $validator
            ->scalar('destino')
            ->maxLength('destino', 255)
            ->allowEmptyString('destino');

        $validator
            ->integer('maquina_id')
            ->notEmptyString('maquina_id');

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
        $rules->add($rules->existsIn(['maquina_id'], 'Maquinas'), ['errorField' => 'maquina_id']);

        return $rules;
    }
}
