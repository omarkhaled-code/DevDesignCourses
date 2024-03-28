<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;
    public function likeable(){
        return $this->morphTo();
    }

    protected $fillable = [
        'user_id',
        'likeable_type',
        'likeable_id'
    ];
}
