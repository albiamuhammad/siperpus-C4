<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLoanDetailsTable extends Migration
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

            'loan_id' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
            ],

            'book_id' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
            ],

            'quantity' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
                'default'    => 1,
            ],

            'returned_quantity' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
                'default'    => 0,
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


        $this->forge->addKey(
            'id',
            true
        );


        $this->forge->addKey(
            'loan_id'
        );


        $this->forge->addKey(
            'book_id'
        );


        // loan_details.loan_id → loans.id
        $this->forge->addForeignKey(
            'loan_id',
            'loans',
            'id',
            'CASCADE',
            'CASCADE'
        );


        // loan_details.book_id → books.id
        $this->forge->addForeignKey(
            'book_id',
            'books',
            'id',
            'RESTRICT',
            'CASCADE'
        );


        $this->forge->createTable(
            'loan_details'
        );
    }


    public function down()
    {
        $this->forge->dropTable(
            'loan_details'
        );
    }
}
