<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',  // Add role_id to mass assignment if it is managed directly
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    // Check if user has specific role
    public function hasRole($roleName)
    {
        return $this->role && $this->role->name === $roleName;
    }

    // Check if user is an admin
    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    // Check if user is a librarian
    public function isLibrarian()
    {
        return $this->hasRole('librarian');
    }

    // Check if user is a student
    public function isStudent()
    {
        return $this->hasRole('student');
    }
    
}
