<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Found extends Model
{
    protected $table = 'found';

    protected $guarded = [
        'id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function matching()
    {
        return $this->hasMany(Matching::class, 'found_id');
    }
}