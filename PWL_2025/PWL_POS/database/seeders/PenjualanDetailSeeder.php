<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $penjualanIds = DB::table('t_penjualan')->pluck('penjualan_id')->toArray();
        $barang = DB::table('m_barang')->select('barang_id', 'harga_jual')->get();

        if (empty($penjualanIds) || $barang->isEmpty()) {
            echo "Seeder gagal: Pastikan tabel t_penjualan dan m_barang sudah memiliki data.\n";
            return;
        }

        $totalEntries = 0;
        
        foreach ($penjualanIds as $penjualanId) {
            $barangRandom = $barang->random(3); // Ambil 3 barang acak untuk setiap transaksi
            
            foreach ($barangRandom as $item) {
                DB::table('t_penjualan_detail')->insert([
                    'penjualan_id' => $penjualanId,
                    'barang_id' => $item->barang_id,
                    'harga' => $item->harga_jual,
                    'jumlah' => rand(1, 5), // Jumlah random antara 1-5
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                
                $totalEntries++;
                if ($totalEntries >= 30) break 2; // Hentikan jika sudah mencapai 30 baris
            }
        }
    }
}
