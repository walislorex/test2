<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;
    protected $primaryKey = 'ExamID';

    protected $fillable = [
        'Title',
        'Description',
        'Date',
        'Location',
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
    public function scopeUpcoming($query) {
        return $query->where('Date', '>', now());
    }
}
