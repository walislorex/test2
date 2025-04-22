<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    // use HasFactory;
    // protected $table = 'classes'; // Explicit table name
    // protected $primaryKey = 'ClassID'; // Custom primary key

    // protected $fillable = [
    //     'Name'
    // ];


    protected $primaryKey = 'ClassID';
    protected $table = 'classes';
    protected $fillable = ['Name', 'TeacherID', 'Subjects'];
    protected $casts = ['Subjects' => 'array'];
    // Relationships
    // public function users()
    // {
    //     return $this->hasMany(User::class, 'ClassID');
    // }

    // public function students()
    // {
    //     return $this->hasMany(User::class, 'ClassID');
    // }

    // // Relationship: A class has one teacher (via Role)
    // public function teacher()
    // {
    //     return $this->students()->where('Role', 'teacher')->first();
    // }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'TeacherID', 'UserID');
    }

    // Relationship: Class has many Students
    public function students()
    {
        return $this->hasMany(User::class, 'ClassID');
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class, 'ClassID');
    }

    public function exams()
    {
        return $this->hasMany(Exam::class, 'ClassID');
    }

    public function announcements()
    {
        return $this->hasMany(Announcement::class, 'ClassID');
    }
}
