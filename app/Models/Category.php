<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';
    

    protected $guarded = ['id'];

    public function lostItem()
    {
        return $this->hasMany(Lost::class, 'category_id');
    }

    public function foundItem()
    {
        return $this->hasMany(Found::class, 'category_id');
    }
}