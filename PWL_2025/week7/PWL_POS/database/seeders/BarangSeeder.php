<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $barangData = [
            ['1', 'BRG001', 'Khong Guan Biscuits', 90000],
            ['2', 'BRG002', 'Teh Botol Sosro', 4000],
            ['3', 'BRG003', 'Buku Novel "Laskar Pelangi"', 50000],
            ['4', 'BRG004', 'Smart TV Samsung', 7000000],
            ['5', 'BRG005', 'Jaket Kulit', 300000],
            ['1', 'BRG006', 'indomie', 3000],
            ['2', 'BRG007', 'Le Minerale 600 ml', 2500],
            ['3', 'BRG008', 'Buku Pelajaran Matematika SMA', 70000],
            ['4', 'BRG009', 'Samsung A55 ', 5000000],
            ['5', 'BRG010', 'Celana Jeans Levis', 400000],
        ];

        foreach ($barangData as $item) {
            DB::table('m_barang')->insert([
                'kategori_id' => $item[0],
                'barang_kode' => $item[1],
                'barang_nama' => $item[2],
                'harga_beli' => $item[3],
                'harga_jual' => $item[3] * 1.2,
            ]);
        }
    }
}
