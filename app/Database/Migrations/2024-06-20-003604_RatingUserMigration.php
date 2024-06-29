<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RatingUserMigration extends Migration
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
            'rating' => [
                'type' => 'INT'
            ],
            'komentar' => [
                'type' => 'TEXT'
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('user_id');
        $this->forge->addForeignKey('user_id', 'users', 'id');
        $this->forge->createTable('rating');
    }

    public function down()
    {
        $this->forge->dropTable('rating');
    }
}
