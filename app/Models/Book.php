<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    /** @use HasFactory<\Database\Factories\BookFactory> */
    use HasFactory;

    protected $fillable = ['title', 'description', 'published_date', 'status'];

    public function authors()
    {
        return $this->belongsToMany(Author::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function issues()
    {
        return $this->hasMany(Issue::class);
    }

    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }
    
    public function isIssued(): bool
    {
        return $this->status === 'issued';
    }
}
