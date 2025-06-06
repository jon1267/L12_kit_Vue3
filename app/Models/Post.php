<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    protected $table = 'posts';
    protected $fillable = [
        'user_id', 'title', 'slug', 'content', 'image',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
