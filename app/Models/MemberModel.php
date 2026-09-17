<?php

namespace App\Models;

use CodeIgniter\Model;

class MemberModel extends Model
{
    protected $table = 'members';

    protected $primaryKey = 'id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'member_code',
        'name',
        'email',
        'phone',
        'address',
        'status',
    ];

    protected $useTimestamps = true;

    protected $createdField = 'created_at';

    protected $updatedField = 'updated_at';
}
