<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTokenSession extends Migration
{
    public function up()
    {
        $this->forge->addColumn('sessions', [
            'access_token' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
                'after' => 'user_id', // Sesuaikan dengan posisi kolom yang diinginkan
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'access_token');
    }
}
