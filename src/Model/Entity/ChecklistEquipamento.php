<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ChecklistEquipamento Entity
 *
 * @property int $id
 * @property int $checklist_id
 * @property int $equipamento_id
 * @property int $quantidade
 * @property string|null $observacao
 *
 * @property \App\Model\Entity\Checklist $checklist
 * @property \App\Model\Entity\Equipamento $equipamento
 */
class ChecklistEquipamento extends Entity
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
        'checklist_id' => true,
        'equipamento_id' => true,
        'quantidade' => true,
        'observacao' => true,
        'checklist' => true,
        'equipamento' => true,
    ];
}
