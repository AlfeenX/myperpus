<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Member extends Model
{
    use HasFactory;

    public function borrowings():HasMany
    {
        return $this->hasMany(Borrowing::class);
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function visitorLogs()
    {
        return $this->hasMany(VisitorLog::class);
    }

    protected $fillable =[
        'name',
        'email',
        'address',
        'phone'
    ];
}
