<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class QuestionInformation extends Migration
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
                'constraint' => '255'
            ],
            'description' => [
                'type' => 'TEXT',
            ]
        ]);
        $this->forge->addKey('id', true);

        $this->forge->createTable('question_information');
    }

    public function down()
    {
        $this->forge->dropTable('question_information');
    }
}
