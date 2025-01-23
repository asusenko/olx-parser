<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;

    protected $table = 'links'; // Explicitly specify the table name if needed

    protected $fillable = ['user_id', 'url_link', 'last_price'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}