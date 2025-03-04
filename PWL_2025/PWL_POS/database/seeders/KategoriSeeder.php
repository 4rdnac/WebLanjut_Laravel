<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoriData = [
            ['Makanan', 'MKN'],
            ['Minuman', 'MNM'],
            ['Buku', 'BK'],
            ['Elektronik', 'ELTNK'],
            ['Pakaian', 'PKN'],
        ];

        foreach ($kategoriData as $item) {
            DB::table('m_kategori')->insert([
                'kategori_nama' => $item[0],
                'kategori_kode' => $item[1],
            ]);
        }
    }
}