<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait likeable
{
    public function likes():MorPhMany{
        
        return $this->morphMany('App\Models\Like','likeable');

        }
    
}