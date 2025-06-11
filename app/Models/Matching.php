<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matching extends Model
{
    protected $table = 'matching';

    protected $guarded = [
        'id',
    ];

    public function lostItem()
    {
        return $this->belongsTo(Lost::class, 'lost_id');
    }

    public function foundItem()
    {
        return $this->belongsTo(Found::class, 'found_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
