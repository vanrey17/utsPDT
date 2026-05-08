<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model // atau 'book' tergantung penamaanmu
{
    use HasFactory;

    // Tambahkan properti fillable ini
    protected $fillable = [
        'title',
        'author',
        'isbn',
        'publish_year',
        'publisher',
        'category_id'
    ];
}
