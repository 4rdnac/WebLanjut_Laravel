<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LevelModel extends Model
{
    use HasFactory;

    protected $table = 'm_level'; // Nama tabel
    protected $primaryKey = 'level_id'; // Primary Key

    protected $fillable = ['level_nama']; // Sesuaikan dengan kolom yang ada di tabel m_level
}