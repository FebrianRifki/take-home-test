<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('books')->insert([
            [
                'title' => 'Laravel Basics',
                'publisher' => 'Tech Press',
                'stock' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Clean Code',
                'publisher' => 'Prentice Hall',
                'stock' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Design Patterns',
                'publisher' => 'Addison Wesley',
                'stock' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
