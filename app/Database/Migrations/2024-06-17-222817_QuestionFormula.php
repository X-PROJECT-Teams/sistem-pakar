<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class QuestionFormula extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'question_info_id' => [
                'type'       => 'INT',
                'unsigned' => true
            ],
            'range_min' => [
                'type' => 'INT',
            ],
            'range_max' => [
                'type' => 'INT',
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('question_info_id', 'question_information', 'id');

        $this->forge->createTable('question_formula');
    }

    public function down()
    {
        $this->forge->dropTable("question_formula");
    }
}
