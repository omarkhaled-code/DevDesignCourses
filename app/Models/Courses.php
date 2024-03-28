<?php

namespace App\Models;

use App\Models\Traits\Likeable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Courses extends Model
{
    use HasFactory;
    use Likeable;

    protected $fillable = [
        'title',
        'description',
        'image',
        'created_by',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // public function students()
    // {
    //     return $this->belongsToMany(User::class, 'student_courses', 'course_id','student_id');

    // }

    public function CourseVideos()
    {
        return $this->hasMany(Videos::class, 'course_id');
    }

    protected static function boot()
    {
        parent::boot();


        static::deleting(function ($courses) {
            $courses->likes()->each(function ($like) {
                $like->delete();
            });
        });
    }
}
