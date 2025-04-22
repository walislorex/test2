<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;
    protected $primaryKey = 'AssignmentID';

    protected $fillable = [
        'Title',
        'Description',
        'FilePath',
        'DueDate',
        'TeacherID',
        'ClassID',
    ];


    public function teacher()
    {
        return $this->belongsTo(User::class, 'TeacherID');
    }

    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'ClassID');
    }
    public function scopeActive($query) {
        return $query->where('DueDate', '>', now());
    }
}
