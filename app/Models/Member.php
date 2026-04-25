<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_number',
        'tanggal_lahir',
        'name',
        'stock',
    ];

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }
}
