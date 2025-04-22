<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;
    protected $primaryKey = 'AnnouncementID';

    protected $fillable = [
        'Title',
        'Description',
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
}
