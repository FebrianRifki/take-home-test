<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'publisher',
        'dimensionon',
        'stock',
    ];

    public function borrowings()
    {
        return $this->belongsToMany(Borrowing::class, 'borrowing_details')
            ->withPivot('quantity');
    }
}
