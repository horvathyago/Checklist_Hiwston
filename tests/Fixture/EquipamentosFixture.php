<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * EquipamentosFixture
 */
class EquipamentosFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'nome' => 'CORPO DA FORMA',
                'quantidade_padrao' => 4,
            ],
            [
                'id' => 2,
                'nome' => 'PARAFUSO DO COPO',
                'quantidade_padrao' => 4,
            ],
        ];
        parent::init();
    }
}