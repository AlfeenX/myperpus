<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Borrowing extends Model
{
    use HasFactory;

    public function member():BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
    public function book():BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    protected $fillable =[
        'member_id',
        'book_id',
        'user_id',
        'borrow_date',
        'due_date',
        'return_at',
        'status'
    ];
}
