<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MemberSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('members')->insert([
            [
                'member_number' => 'MBR001',
                'name' => 'Andi Saputra',
                'tanggal_lahir' => '1998-01-01',
                'stock' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'member_number' => 'MBR002',
                'name' => 'Budi Santoso',
                'tanggal_lahir' => '1998-01-01',
                'stock' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'member_number' => 'MBR003',
                'name' => 'Citra Lestari',
                'tanggal_lahir' => '1998-01-01',
                'stock' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
