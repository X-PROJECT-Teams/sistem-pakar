<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class QuestionDetailPart2 extends Migration
{
    public function up()
    {
        $this->forge->addColumn('question', [
            'created_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'after' => "id"
            ],
        ]);
        $this->forge->addForeignKey('created_by', 'users', 'id');
    }

    public function down()
    {
        //
    }
}
