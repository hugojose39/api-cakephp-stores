<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\StoresController Test Case
 *
 * @uses \App\Controller\StoresController
 */
class StoresControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Stores',
    ];

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\StoresController::index()
     */
    public function testIndex(): void
    {
        $this->get('/stores/index');
        $this->assertResponseOk();
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\StoresController::view()
     */
    public function testShow(): void
    {
        $this->get('/stores/show/1');
        $this->assertResponseOk();
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\StoresController::add()
     */
    public function testCreate(): void
    {
        $data = [
            'name' => 'Test Store',
            'addresses' => [
                [
                    'postal_code' => '01001000',
                    'street_number' => '123',
                    'complement' => 'Test Complement'
                ]
            ]
        ];

        $this->post('/stores/create', $data);
        $this->assertResponseSuccess();
    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\StoresController::edit()
     */
    public function testUpdate(): void
    {
        $data = [
            'name' => 'Updated Store Name'
        ];

        $this->put('/stores/update/1', $data);
        $this->assertResponseSuccess();
    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\StoresController::delete()
     */
    public function testDelete(): void
    {
        $this->delete('/stores/delete/1');
        $this->assertResponseSuccess();
        $this->assertResponseCode(204);
    }

    public function tearDown(): void
    {
        parent::tearDown();

        // Limpar os dados do banco de dados após os testes
        $this->clearDatabase();
    }

    /**
     * Limpar os dados do banco de dados
     *
     * @return void
     */
    private function clearDatabase(): void
    {
        // Obtém uma instância do TableRegistry para a tabela de Stores
        $storesTable = TableRegistry::getTableLocator()->get('Stores');

        // Deleta todos os registros da tabela de Stores
        $storesTable->deleteAll([]);
    }
}
