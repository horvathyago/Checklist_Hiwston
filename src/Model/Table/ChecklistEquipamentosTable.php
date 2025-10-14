<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ChecklistEquipamentos Model
 *
 * @property \App\Model\Table\ChecklistsTable&\Cake\ORM\Association\BelongsTo $Checklists
 * @property \App\Model\Table\EquipamentosTable&\Cake\ORM\Association\BelongsTo $Equipamentos
 *
 * @method \App\Model\Entity\ChecklistEquipamento newEmptyEntity()
 * @method \App\Model\Entity\ChecklistEquipamento newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\ChecklistEquipamento> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ChecklistEquipamento get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\ChecklistEquipamento findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\ChecklistEquipamento patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\ChecklistEquipamento> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ChecklistEquipamento|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\ChecklistEquipamento saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\ChecklistEquipamento>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ChecklistEquipamento>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ChecklistEquipamento>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ChecklistEquipamento> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ChecklistEquipamento>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ChecklistEquipamento>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ChecklistEquipamento>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ChecklistEquipamento> deleteManyOrFail(iterable $entities, array $options = [])
 */
class ChecklistEquipamentosTable extends Table
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

        $this->setTable('checklist_equipamentos');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Checklists', [
            'foreignKey' => 'checklist_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Equipamentos', [
            'foreignKey' => 'equipamento_id',
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
            ->integer('checklist_id')
            ->notEmptyString('checklist_id');

        $validator
            ->integer('equipamento_id')
            ->notEmptyString('equipamento_id');

        $validator
            ->integer('quantidade')
            ->requirePresence('quantidade', 'create')
            ->notEmptyString('quantidade');

        $validator
            ->scalar('observacao')
            ->maxLength('observacao', 255)
            ->allowEmptyString('observacao');

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
        $rules->add($rules->existsIn(['checklist_id'], 'Checklists'), ['errorField' => 'checklist_id']);
        $rules->add($rules->existsIn(['equipamento_id'], 'Equipamentos'), ['errorField' => 'equipamento_id']);

        return $rules;
    }
}
