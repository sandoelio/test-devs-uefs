<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    /**
     * Relacionamento: Uma tag pode estar associada a vários posts.
     */
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'posts_tags');
    }
}
