<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscribe extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function channel()
    {
        return $this->hasOne(Channel::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
