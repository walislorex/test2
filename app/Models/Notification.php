<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $primaryKey = 'NotificationID';

    // Match the case used in migrations (e.g., 'UserID')
    protected $fillable = ['UserID', 'Message', 'ReadStatus']; 

    public function user()
    {
        return $this->belongsTo(User::class, 'UserID'); // Match the foreign key name
    }

}
