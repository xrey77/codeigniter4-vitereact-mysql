<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProducts extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'category'       => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null' => true,                
            ],
            'descriptions'      => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'unique'     => true,
            ],
            'qty'       => [
                'type'       => 'INT',
                'constraint' => '5',
            ],
            'unit'       => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'null' => true,                
            ],
            'costprice'       => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'        => '0.00',                
            ],
            'sellprice'       => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'        => '0.00',                
            ],
            'saleprice'       => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'        => '0.00',                
            ],
            'productpicture'       => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null' => true,                
            ],
            'alertstocks'       => [
                'type'       => 'INT',
                'constraint' => '5',
                'unsigned'       => true,                
                'default'        => '0',                 
            ],
            'criticalstocks'       => [
                'type'       => 'INT',
                'constraint' => '5',
                'unsigned'       => true,                
                'default'        => '0',                 
            ],


            'created_at' => [
                'type' => 'datetime',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'datetime',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('products');        
    }

    public function down()
    {
        $this->forge->dropTable('products');                
    }
}
