<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * MaquinasFixture
 */
class MaquinasFixture extends TestFixture
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
                'nome' => 'VIBRO PRENSA AUTOMÁTICA DE BLOCO HTX 900',
            ],
        ];
        parent::init();
    }
}