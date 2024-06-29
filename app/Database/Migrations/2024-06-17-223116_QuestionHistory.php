<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class QuestionHistory extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'user_id' => [
                'type'       => 'INT',
                'unsigned' => true
            ],
            'question_info_id' => [
                'type' => 'INT',
                'unsigned' => true
            ],
            'range_min' => [
                'type' => 'INT',
            ],
            'range_max' => [
                'type' => 'INT'
            ],
            'result' => [
                'type' => 'INT'
            ],
            'created_at DATETIME DEFAULT CURRENT_TIMESTAMP'
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id');
        $this->forge->addForeignKey('question_info_id', 'question_information', 'id');

        $this->forge->createTable('question_history');
    }

    public function down()
    {
        $this->forge->dropTable('question_history');
    }
}
