<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Codex extends Model
{
    protected $fillable = [
        'title',
        'link',
        'slug',
    ];
}
