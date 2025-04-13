<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable; // implementasi class Authenticatable

class UserModel extends Authenticatable
{
    use HasFactory;

    protected $table = 'm_user'; //Mendefinisikan nama tabel yang digunakan oleh model
    protected $primaryKey = 'user_id'; //Mendefinisikan primary key dari tabel yang digunakan

    protected $fillable = ['username', 'nama', 'password', 'level_id', 'foto'];

    protected $hidden = ['password']; // jangan ditampilkan saat di select
    protected $casts = ['password' => 'hashed']; // casting password agar otomatis di hash

    public function level(): BelongsTo
    {
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }

    // Mendapatkan nama role
    public function getRoleName(): string
    {
        return $this->level->level_nama;
    }

    // cek apakah user memiliki role tertentu
    public function hasRole($role): bool
    {
        return $this->level->level_kode == $role;
    }

    // mendapatkan kode role
    public function getRole()
    {
        return $this->level->level_kode;
    }
}