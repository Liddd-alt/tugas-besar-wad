<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Lost extends Model
{
    protected $table = 'lost';

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
        return $this->hasMany(Matching::class, 'lost_id');
    }
}
