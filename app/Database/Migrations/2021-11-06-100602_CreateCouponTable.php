<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCouponTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'code'       => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'price_discount'       => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'code_limit'       => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'user_used'       => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'expiration_date'       => [
                'type'       => 'DATETIME',
            ],
            'price_payment_limit'       => [
                'type'       => 'BIGINT',
                'constraint' => 11,
            ],
            'code_description'       => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'status'       => [
                'type'       => 'TINYINT',
                'constraint' => '1',
                'default'    => '1',
            ],
            'created_at'       => [
                'type'       => 'DATETIME',
                'null' => true
            ],
            'updated_at'       => [
                'type'       => 'DATETIME',
                'null' => true
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('coupon');
    }

    public function down()
    {
        $this->forge->dropTable('coupon');
    }
}
