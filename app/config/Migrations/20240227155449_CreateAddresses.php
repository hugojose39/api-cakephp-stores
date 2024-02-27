<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateAddresses extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change(): void
    {
        $table = $this->table('addresses');

        $table->addColumn('store_id', 'integer', [
            'null' => false,
        ]);

        $table->addColumn('postal_code', 'string', [
            'limit' => 8,
            'null' => false,
        ]);

        $table->addColumn('state', 'string', [
            'limit' => 2,
            'null' => false,
        ]);

        $table->addColumn('city', 'string', [
            'limit' => 200,
            'null' => false,
        ]);

        $table->addColumn('sublocality', 'string', [
            'limit' => 200,
            'null' => false,
        ]);

        $table->addColumn('street', 'string', [
            'limit' => 200,
            'null' => false,
        ]);

        $table->addColumn('street_number', 'string', [
            'limit' => 200,
            'null' => false,
        ]);

        $table->addColumn('complement', 'string', [
            'limit' => 200,
            'null' => false,
            'default' => '',
        ]);

        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => true,
        ]);

        $table->addColumn('modified', 'datetime', [
            'default' => null,
            'null' => true,
        ]);

        $table->addPrimaryKey('id');

        $table->addForeignKey('store_id', 'stores', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE']);

        $table->create();
    }
}
