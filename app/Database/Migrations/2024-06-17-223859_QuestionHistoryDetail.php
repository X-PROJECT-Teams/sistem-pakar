<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class QuestionHistoryDetail extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'question_history_id' => [
                'type'       => 'INT',
                'unsigned' => true
            ],
            'question_id' => [
                'type' => 'INT',
                'unsigned' => true
            ],
            'question_detail_id' => [
                'type' => 'INT',
                'unsigned' => true
            ],
            'name_question' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ],
            'index_score' => [
                'type' => 'INT',
                'unsigned' => true
            ],
            'description' => [
                'type' => 'TEXT'
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('question_history_id', 'question_history', 'id');
        $this->forge->addForeignKey('question_id', 'question', 'id');
        $this->forge->addForeignKey('question_detail_id', 'question_detail', 'id');

        $this->forge->createTable('question_history_detail');
    }

    public function down()
    {
        $this->forge->dropTable("question_history_detail");
    }
}
