<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable; // Include HasApiTokens

    protected $primaryKey = 'UserID';
    public $incrementing = true; // If using auto-increment
    protected $keyType = 'int'; // Match your DB column type

    protected $fillable = [
        'Name', 'Email', 'password', 'Role', 'ClassID', 'PIN' // Lowercase 'password'
    ];

    protected $hidden = [
        'password', 'remember_token', // Lowercase 'password'
    ];

    // Relationships
    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'ClassID');
    }

    public function getAuthPassword() {
        return $this->password;
    }

    public function taughtClasses()
    {
        return $this->hasMany(ClassModel::class, 'TeacherID');
    }


    public function assignments()
    {
        return $this->hasMany(Assignment::class, 'TeacherID');
    }

    public function exams()
    {
        return $this->hasMany(Exam::class, 'TeacherID');
    }

    public function announcements()
    {
        return $this->hasMany(Announcement::class, 'TeacherID');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'UserID');
    }
}