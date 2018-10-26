<?php

namespace App;

use App\Traits\Orderable;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use Orderable;
    
    public function likeable()
    {
    	return $this->morphTo();
    }
    
    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
