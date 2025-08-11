<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    use HasFactory;

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return  $this->belongsTo(Author::class);
    }

    protected $fillable = [
        'title',
        'author_id',
        'publisher',
        'year',
        'stock',
        'category_id',
        'created_at',
        'updated_at,'
    ];
}
