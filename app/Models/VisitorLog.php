<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitorLog extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::creating(function ($log) {
            if (!$log->visit_at) {
                $log->visit_at = now()->toDateString();
            }
        });
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    protected $fillable = [
        'member_id',
        'visit_at'
    ];
}
