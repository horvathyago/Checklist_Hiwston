<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Equipamentos Model
 *
 * @property \App\Model\Table\ChecklistEquipamentosTable&\Cake\ORM\Association\HasMany $ChecklistEquipamentos
 * @property \App\Model\Table\MaquinasTable&\Cake\ORM\Association\BelongsToMany $Maquinas
 *
 * @method \App\Model\Entity\Equipamento newEmptyEntity()
 * @method \App\Model\Entity\Equipamento newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Equipamento> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Equipamento get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Equipamento findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Equipamento patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Equipamento> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Equipamento|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Equipamento saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Equipamento>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Equipamento>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Equipamento>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Equipamento> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Equipamento>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Equipamento>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Equipamento>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Equipamento> deleteManyOrFail(iterable $entities, array $options = [])
 */
class EquipamentosTable extends Table
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

        $this->setTable('equipamentos');
        $this->setDisplayField('nome');
        $this->setPrimaryKey('id');

        $this->hasMany('ChecklistEquipamentos', [
            'foreignKey' => 'equipamento_id',
        ]);
        $this->belongsToMany('Maquinas', [
            'foreignKey' => 'equipamento_id',
            'targetForeignKey' => 'maquina_id',
            'joinTable' => 'maquinas_equipamentos',
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
            ->scalar('nome')
            ->maxLength('nome', 255)
            ->requirePresence('nome', 'create')
            ->notEmptyString('nome');

        $validator
            ->integer('quantidade_padrao')
            ->requirePresence('quantidade_padrao', 'create')
            ->notEmptyString('quantidade_padrao');

        return $validator;
    }
}
