<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = [
            [
                'supplier_kode' => 'S001',
                'supplier_nama' => 'UD. Monyet Ijo Banyumas',
                'supplier_alamat' => 'Jl. Diponegoro No. 25, Kabupaten Banyumas',
                'supplier_telepon' => '08111111111',
            ],
            [
                'supplier_kode' => 'S002',
                'supplier_nama' => 'CV. Puding Coklat Pak Hambali',
                'supplier_alamat' => 'Jl. Raya Tlogomas No. 69, Malang',
                'supplier_telepon' => '08222222222',
            ],
            [
                'supplier_kode' => 'S003',
                'supplier_nama' => 'PT. Bayu Silver',
                'supplier_alamat' => 'Jl. Wahidin Sudirohusodo No. 32, Probolinggo',
                'supplier_telepon' => '08333333333',
            ],
        ];

        DB::table('m_supplier')->insert($suppliers);
    }
}