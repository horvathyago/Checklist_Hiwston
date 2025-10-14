<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Checklist Entity
 *
 * @property int $id
 * @property string $numero_ordem_producao
 * @property string|null $cliente
 * @property \Cake\I18n\Date|null $data_carregamento
 * @property string|null $destino
 * @property int $maquina_id
 *
 * @property \App\Model\Entity\Maquina $maquina
 * @property \App\Model\Entity\ChecklistEquipamento[] $checklist_equipamentos
 */
class Checklist extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'numero_ordem_producao' => true,
        'cliente' => true,
        'data_carregamento' => true,
        'destino' => true,
        'maquina_id' => true,
        'maquina' => true,
        'checklist_equipamentos' => true,
    ];
}
