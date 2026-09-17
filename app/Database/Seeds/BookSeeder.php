<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'book_code' => 'BK001',
                'isbn' => '9786020000001',
                'title' => 'Pemrograman PHP Dasar',
                'author' => 'Andi Saputra',
                'publisher' => 'Informatika',
                'publication_year' => 2025,
                'category' => 'Pemrograman',
                'stock_total' => 10,
                'stock_available' => 10,
                'cover_filename' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'book_code' => 'BK002',
                'isbn' => '9786020000002',
                'title' => 'Dasar Database MySQL',
                'author' => 'Budi Santoso',
                'publisher' => 'Tekno Media',
                'publication_year' => 2024,
                'category' => 'Database',
                'stock_total' => 8,
                'stock_available' => 8,
                'cover_filename' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'book_code' => 'BK003',
                'isbn' => '9786020000003',
                'title' => 'Membangun Web dengan CodeIgniter 4',
                'author' => 'Citra Lestari',
                'publisher' => 'Digital Press',
                'publication_year' => 2026,
                'category' => 'Framework',
                'stock_total' => 5,
                'stock_available' => 5,
                'cover_filename' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            
        ];

        $this->db
            ->table('books')
            ->insertBatch($data);
    }
}
