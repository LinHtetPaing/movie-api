<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movie extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'summary',
        'cover_image',
        'genres',
        'author',
        'tags',
        'imdb_rating',
        'pdf_download_link',
        'related_movies',
    ];

    // protected $appends = ['relatedMovies'];
    public function comment(): HasMany {
        return $this->hasMany(Comment::class);
    }
}
