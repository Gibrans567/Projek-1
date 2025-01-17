<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Akun extends Model
{
    use HasFactory;

    // Menentukan nama tabel (jika tidak sesuai dengan konvensi Laravel)
    protected $table = 'list_akun_it_support';

    // Menentukan kolom yang dapat diisi secara massal (mass assignment)
    protected $fillable = [
        'username',
        'password',
        'shift',
        'nomor_hp',
    ];

    // Menentukan kolom yang harus dienkripsi (untuk keamanan)
    protected $hidden = [
        'password', // Agar password tidak ditampilkan di response JSON
    ];

    // Menambahkan mutator untuk mengenkripsi password secara otomatis
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password); // Hash password
    }
}
