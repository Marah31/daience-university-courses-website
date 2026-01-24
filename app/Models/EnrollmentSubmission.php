<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnrollmentSubmission extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'hear_about',
        'course_id',
        'status',
    ];
}