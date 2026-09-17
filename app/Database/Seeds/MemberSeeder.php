<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MemberSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        $data = [

            [
                'member_code' => 'AG001',
                'name'        => 'Ahmad Fauzi',
                'email'       => 'ahmad@example.com',
                'phone'       => '081234567801',
                'address'     => 'Bekasi',
                'status'      => 'active',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],

            [
                'member_code' => 'AG002',
                'name'        => 'Siti Nurhaliza',
                'email'       => 'siti@example.com',
                'phone'       => '081234567802',
                'address'     => 'Cibitung',
                'status'      => 'active',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],

            [
                'member_code' => 'AG003',
                'name'        => 'Budi Santoso',
                'email'       => 'budi@example.com',
                'phone'       => '081234567803',
                'address'     => 'Tambun',
                'status'      => 'active',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],

            [
                'member_code' => 'AG004',
                'name'        => 'Dewi Lestari',
                'email'       => 'dewi@example.com',
                'phone'       => '081234567804',
                'address'     => 'Cikarang',
                'status'      => 'active',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],

            [
                'member_code' => 'AG005',
                'name'        => 'Rizky Pratama',
                'email'       => 'rizky@example.com',
                'phone'       => '081234567805',
                'address'     => 'Bekasi',
                'status'      => 'inactive',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
        ];

        $this->db
            ->table('members')
            ->insertBatch($data);
    }
}
