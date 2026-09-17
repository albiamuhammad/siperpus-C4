<?php

namespace App\Models;

use CodeIgniter\Model;

class BookModel extends Model
{
    protected $table = 'books';

    protected $primaryKey = 'id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'book_code',
        'isbn',
        'title',
        'author',
        'publisher',
        'publication_year',
        'category',
        'stock_total',
        'stock_available',
        'cover_filename',
    ];

    protected $useTimestamps = true;

    protected $createdField = 'created_at';

    protected $updatedField = 'updated_at';
}
