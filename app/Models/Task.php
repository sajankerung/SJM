<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    //Fields that can be saved or updated
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'deadline',
        'status',
    ];

    //Convert deadline into a date object
    protected function casts(): array
    {
        return['deadline' => 'date',];
    }
    // A task belongs to one user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
