<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class QuestionTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null' => false
            ]
        ]);
        $this->forge->addKey('id', true);

        $this->forge->createTable('question');
    }

    public function down()
    {
        $this->forge->dropTable('question');
    }
}
