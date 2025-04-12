<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokModel extends Model
{
    use HasFactory;
    
    protected $table = 't_stok'; // Nama tabel
    protected $primaryKey = 'stok_id'; // Primary Key
    
    protected $fillable = ['barang_id', 'user_id', 'stok_tanggal', 'stok_jumlah']; // Kolom yang bisa diisi
    
    // Relasi ke tabel barang
    public function barang()
    {
        return $this->belongsTo(BarangModel::class, 'barang_id', 'barang_id');
    }
    
    // Relasi ke tabel user
    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id', 'user_id');
    }
}