<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkRecord extends Model
{
    protected $fillable = [
        'user_id',
        'work_date',
        'start_time',
        'end_time',
        'hourly_wage',
    ];

    protected function casts(): array
    {
        return [
            'work_date' => 'date',
            'hourly_wage' => 'decimal:2',
        ];
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
