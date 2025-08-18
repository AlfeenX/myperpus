<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory;

    public function member()
    {
        return $this->hasMany(Member::class);
    }

    protected $fillable = [
        'name'
    ];
}
