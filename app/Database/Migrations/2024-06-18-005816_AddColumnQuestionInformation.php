<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnQuestionInformation extends Migration
{
    public function up()
    {
        $this->forge->addColumn('question_information', [
            'tingkat' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'dampak' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'pelaksanaan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'pencegahan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('question_information', ['tingkat', 'dampak', 'pelaksanaan', 'pencegahan']);
    }
}
