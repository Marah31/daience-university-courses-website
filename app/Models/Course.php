<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'ref_code', 'duration', 'description',
        'about_course', 'image_path', 'category'
    ];
    public function enrolledUsers()
    {
        return $this->belongsToMany(User::class, 'enrollments')->withPivot('status')->withTimestamps();
    }
}
