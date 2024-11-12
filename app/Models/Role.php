<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    // Specify fillable fields for mass assignment
    protected $fillable = ['name'];

    // Define any relationships here if necessary
    // For example, assuming a User model where each user has a role:
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
