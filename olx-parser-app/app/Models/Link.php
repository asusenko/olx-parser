<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;

    protected $fillable = ['url_link', 'last_price'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_link');
    }
}