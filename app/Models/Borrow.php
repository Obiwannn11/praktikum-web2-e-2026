<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    
    protected $fillable = [
        'user_id',
        'bnook_id',
        'date_start',
        'date_end'
    ];

    public function book(){
        return $this->belongsTo(Book::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
