<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Maquinas Model
 *
 * @property \App\Model\Table\ChecklistsTable&\Cake\ORM\Association\HasMany $Checklists
 * @property \App\Model\Table\EquipamentosTable&\Cake\ORM\Association\BelongsToMany $Equipamentos
 *
 * @method \App\Model\Entity\Maquina newEmptyEntity()
 * @method \App\Model\Entity\Maquina newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Maquina> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Maquina get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Maquina findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Maquina patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Maquina> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Maquina|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Maquina saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Maquina>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Maquina>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Maquina>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Maquina> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Maquina>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Maquina>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Maquina>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Maquina> deleteManyOrFail(iterable $entities, array $options = [])
 */
class MaquinasTable extends Table
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

        $this->setTable('maquinas');
        $this->setDisplayField('nome');
        $this->setPrimaryKey('id');

        $this->hasMany('Checklists', [
            'foreignKey' => 'maquina_id',
        ]);
        $this->belongsToMany('Equipamentos', [
            'foreignKey' => 'maquina_id',
            'targetForeignKey' => 'equipamento_id',
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

        return $validator;
    }
}
