<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'category_id',
        'title',
        'writer',
        'release_date',
    ];

    // release_date otomatis jadi objek Carbon (tanggal)
    protected $casts = [
        'release_date' => 'date',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function borrow()
    {
        return $this->hasMany(Borrow::class);
    }
}
