<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProductTable extends Migration
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
            'name'       => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'slug'       => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'sku'       => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'image'       => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'          => true,
            ],
            'image_list'       => [
                'type'       => 'TEXT',
                'null'          => true,
            ],
            'small_description'       => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'          => true,
            ],
            'large_description'       => [
                'type'       => 'LONGTEXT',
            ],
            'quantity'          => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'cat_id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'brand_id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'null'          => true,
            ],
            'number_buy'          => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'sale'          => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'price'          => [
                'type'           => 'BIGINT',
                'constraint'     => 11,
            ],
            'view'          => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'featured'       => [
                'type'       => 'TINYINT',
                'constraint' => '1',
                'default'    => '0',
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
            ],
            'deleted_at'       => [
                'type'       => 'DATETIME',
                'null'          => true,
            ],
            'meta_title'       => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'          => true,
            ],
            'meta_description'       => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'          => true,
            ],
            'meta_keyword'       => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'          => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('product');
    }

    public function down()
    {
        $this->forge->dropTable('product');
    }
}
