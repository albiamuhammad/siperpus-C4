<?php

namespace App\Models;

use CodeIgniter\Model;

class LoanModel extends Model
{
    protected $table = 'loans';

    protected $primaryKey = 'id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'loan_code',
        'member_id',
        'loan_date',
        'due_date',
        'returned_at',
        'status',
    ];

    protected $useTimestamps = true;

    protected $createdField = 'created_at';

    protected $updatedField = 'updated_at';
}
