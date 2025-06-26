<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Stat extends Model
{
    /** @use HasFactory<\Database\Factories\StatFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id', 'score', 'start_time', 'end_time',
    ];

    protected $casts = [
        'start_time' => 'datetime:d-M-Y H:i:s',
        'end_time' => 'datetime:d-M-Y H:i:s',
        'created_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
