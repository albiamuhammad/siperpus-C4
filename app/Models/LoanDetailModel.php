<?php

namespace App\Models;

use CodeIgniter\Model;

class LoanDetailModel extends Model
{
    protected $table = 'loan_details';

    protected $primaryKey = 'id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'loan_id',
        'book_id',
        'quantity',
        'returned_quantity',
    ];

    protected $useTimestamps = true;

    protected $createdField = 'created_at';

    protected $updatedField = 'updated_at';
}