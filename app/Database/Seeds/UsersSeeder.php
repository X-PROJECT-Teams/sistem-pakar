<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id' => null,
                'username' => 'admin',
                'email'    => 'admin@admin.com',
                'name'     => 'Administrator',
                'is_admin' => true,
                'password' => password_hash('ini_admin', PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => null,
                'username' => 'rayyreall',
                'email' => 'rayyreall29@gmail.com',
                'name' => 'Muhammad Rizki Firdaus',
                'password' => password_hash('rayyreall', PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        // Menggunakan Query Builder untuk menyisipkan data
        foreach ($data as $user) {
            // Query SQL untuk INSERT
            $sql = "INSERT INTO users (username, email, name, is_admin, password, created_at, updated_at) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";

            // Eksekusi query dengan parameter
            $this->db->query($sql, [
                $user['username'],
                $user['email'],
                $user['name'],
                $user['is_admin'],
                $user['password'],
                $user['created_at'],
                $user['updated_at']
            ]);
        }
    }
}
