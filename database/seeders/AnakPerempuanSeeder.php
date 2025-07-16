<?php

namespace Database\Seeders;

use App\Models\Anak;
use App\Models\User;
use App\Models\OrangTua;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AnakPerempuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $orangTua = User::create([
            'name' => 'Ibu Contoh',
            'email' => 'ibu@posyandu.test',
            'password' => Hash::make('password'),
            'role' => 'orang_tua',
            'phone' => '081234567899'
        ]);

        // Buat data orang tua
        $dataOrangTua = OrangTua::create([
            'user_id' => $orangTua->id,
            'alamat' => 'Jl. Mawar No. 45',
            'rt' => '005',
            'rw' => '006',
            'desa_kelurahan' => 'Kelurahan Bunga',
            'kecamatan' => 'Kecamatan Harapan',
            'kabupaten_kota' => 'Kota Sejahtera',
            'provinsi' => 'Provinsi Aman'
        ]);

        // Buat data anak perempuan
        Anak::create([
            'orang_tua_id' => $dataOrangTua->id,
            'nama_lengkap' => 'Siti Aisyah',
            'jenis_kelamin' => 'P', // Perempuan
            'tanggal_lahir' => now()->subMonths(10),
            'berat_lahir' => 3.0,
            'panjang_lahir' => 47.0,
            'anak_ke' => '2',
            'golongan_darah' => 'B'
        ]);
    }
}
