<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLoansTable extends Migration
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

            'loan_code' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
            ],

            'member_id' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
            ],

            'loan_date' => [
                'type' => 'DATE',
            ],

            'due_date' => [
                'type' => 'DATE',
            ],

            'returned_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],

            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'default'    => 'borrowed',
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


        // PRIMARY KEY
        $this->forge->addKey(
            'id',
            true
        );


        // Kode transaksi harus unik
        $this->forge->addUniqueKey(
            'loan_code'
        );


        // Index untuk member
        $this->forge->addKey(
            'member_id'
        );


        // Foreign Key
        $this->forge->addForeignKey(
            'member_id',
            'members',
            'id',
            'RESTRICT',
            'CASCADE'
        );


        $this->forge->createTable(
            'loans'
        );
    }


    public function down()
    {
        $this->forge->dropTable(
            'loans'
        );
    }
}
