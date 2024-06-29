<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddQuestionCreateBy extends Migration
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
        $this->forge->dropForeignKey('question', 'question_detail_created_by_foreign');

        // Menghapus kolom created_by dari tabel question_detail
        $this->forge->dropColumn('question', 'created_by');
    }
}
