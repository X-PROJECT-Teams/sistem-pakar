<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class QuestionDetail extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'id_question' => [
                'type'       => 'INT',
                'unsigned' => true
            ],
            'index_score' => [
                'type' => 'INT',
                'unsigned' => true
            ],
            'description' => [
                'type' => 'TEXT',
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_question', 'question', 'id');

        $this->forge->createTable('question_detail');
    }

    public function down()
    {
        $this->forge->dropTable("question_detail");
    }
}
