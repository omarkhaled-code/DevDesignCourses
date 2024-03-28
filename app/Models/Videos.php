<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Videos extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'video',
        'description',
        'course_id'
    ];

    public function course(){
        return $this->belongsTo(Courses::class, 'course_id');
    }
}
