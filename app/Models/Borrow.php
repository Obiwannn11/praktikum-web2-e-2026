<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    protected $fillable = [
        'user_id',
        'book_id',
        'date_start',
        'date_end',
    ];

    // tanggal pinjam & kembali otomatis jadi objek Carbon
    protected $casts = [
        'date_start' => 'date',
        'date_end' => 'date',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
