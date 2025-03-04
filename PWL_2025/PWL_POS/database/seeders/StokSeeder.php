<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $stokData = [
            ['1', 100],
            ['2', 50],
            ['3', 75],
            ['4', 30],
            ['5', 90],
            ['6', 60],
            ['7', 40],
            ['8', 85],
            ['9', 20],
            ['10', 110],
        ];

        foreach ($stokData as $barang) {
            DB::table('t_stok')->insert([
                
                'barang_id' => $barang[0],
                'user_id' => rand(1, 3),
                'stok_tanggal' => now(),
                'stok_jumlah' => $barang[1]
            ]);
        }
    }
}
