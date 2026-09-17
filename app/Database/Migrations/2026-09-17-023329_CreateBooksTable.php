<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBooksTable extends Migration
{
    public function up()
    {
    $this->forge->addField([
    'id' => [
        'type'           => 'BIGINT',
        'constraint'     => 20,
        'unsigned'       => true,
        'auto_increment' => true,
    ],

    'book_code' => [
        'type'       => 'VARCHAR',
        'constraint' => 20,
    ],

    'isbn' => [
        'type'       => 'VARCHAR',
        'constraint' => 20,
        'null'       => true,
    ],

    'title' => [
        'type'       => 'VARCHAR',
        'constraint' => 200,
    ],

    'author' => [
        'type'       => 'VARCHAR',
        'constraint' => 150,
    ],

    'publisher' => [
        'type'       => 'VARCHAR',
        'constraint' => 150,
        'null'       => true,
    ],

    'publication_year' => [
        'type'       => 'INT',
        'constraint' => 4,
        'unsigned'   => true,
        'null'       => true,
    ],

    'category' => [
        'type'       => 'VARCHAR',
        'constraint' => 100,
    ],

    'stock_total' => [
        'type'     => 'INT',
        'unsigned' => true,
        'default'  => 0,
    ],

    'stock_available' => [
        'type'     => 'INT',
        'unsigned' => true,
        'default'  => 0,
    ],

    'cover_filename' => [
        'type'       => 'VARCHAR',
        'constraint' => 255,
        'null'       => true,
    ],

    'created_at' => [
        'type' => 'DATETIME',
        'null' => true,
    ],

    'updated_at' => [
        'type' => 'DATETIME',
        'null' => true,
    ],
]);
$this->forge->addKey('id', true);
$this->forge->addUniqueKey('book_code');
$this->forge->createTable('books');

    }

    public function down()
    {
        $this->forge->dropTable('books');
    }
}
