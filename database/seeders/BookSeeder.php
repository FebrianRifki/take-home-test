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
                'dimension' => '14x21 cm',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Clean Code',
                'publisher' => 'Prentice Hall',
                'stock' => 5,
                'dimension' => '14x21 cm',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Design Patterns',
                'publisher' => 'Addison Wesley',
                'stock' => 7,
                'dimension' => '14x21 cm',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
