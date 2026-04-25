<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'borrow_date',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function books()
    {
        return $this->belongsToMany(Book::class, 'borrowing_details')
            ->withPivot('quantity');
    }

    public function bookReturn()
    {
        return $this->hasOne(BookReturn::class, 'borrowing_id');
    }
}
