<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsers extends Migration
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
            'firstname'       => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null' => true,                
            ],
            'lastname'       => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null' => true,                
            ],
            'email'      => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'unique'     => true,
            ],
            'mobile'      => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'username'       => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'unique'     => true,
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'roles' => [
                'type' => 'json'
            ],
            'userpic' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,                
            ],
            'isblocked' => [
                'type' => 'INT',
                'constraint' => '5',
                'default'        => '0',                
            ],
            'isactivated' => [
                'type' => 'INT',
                'constraint' => '5',
                'default'        => '0',                
            ],
            'mailtoken' => [
                'type' => 'INT',
                'constraint' => '5',
                'default'        => '0',                
            ],
            'secret' => [
                'type' => 'text',
                'null' => true,                
            ],
            'qrcodeurl' => [
                'type' => 'text',
                'null' => true,                
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
        $this->forge->createTable('users');        
    }

    public function down()
    {
        $this->forge->dropTable('users');        
    }
}
