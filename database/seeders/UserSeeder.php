<?php

namespace Database\Seeders;

use App\Models\Anak;
use App\Models\User;
use App\Models\OrangTua;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::create([
            'name' => 'Admin Posyandu',
            'email' => 'admin@posyandu.test',
            'password' => Hash::make('password'),
            'role' => 'kordinator',
            'phone' => '081234567890'
        ]);

        // Kader
        User::create([
            'name' => 'Kader Posyandu',
            'email' => 'kader@posyandu.test',
            'password' => Hash::make('password'),
            'role' => 'kader',
            'phone' => '081234567891'
        ]);

        // Orang Tua
        $orangTua = User::create([
            'name' => 'Orang Tua Contoh',
            'email' => 'ortu@posyandu.test',
            'password' => Hash::make('password'),
            'role' => 'orang_tua',
            'phone' => '081234567892'
        ]);

        // Data orang tua
        OrangTua::create([
            'user_id' => $orangTua->id,
            'alamat' => 'Jl. Contoh No. 123',
            'rt' => '001',
            'rw' => '002',
            'desa_kelurahan' => 'Contoh',
            'kecamatan' => 'Contoh',
            'kabupaten_kota' => 'Kota Contoh',
            'provinsi' => 'Provinsi Contoh'
        ]);

        // Data anak
        Anak::create([
            'orang_tua_id' => 1,
            'nama_lengkap' => 'Anak Contoh',
            'jenis_kelamin' => 'L',
            'tanggal_lahir' => now()->subMonths(6),
            'berat_lahir' => 3.2,
            'panjang_lahir' => 48.5,
            'anak_ke' => '1',
            'golongan_darah' => 'A'
        ]);
    }
}
