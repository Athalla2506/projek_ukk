<?php

namespace Database\Seeders;

use App\Models\Guru;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            Guru::insert([
            [
                'nama' => 'Sugiarto, ST',
                'nip' => '197203172005011012',
                'jenis_kelamin' => 'L',
                'alamat' => 'Klaten',
                'kontak' => '085643188811',
                'email' => 'mrantazy68@gmail.com'
            ],
            [
                'nama' => 'Yunianto Hermawan, S.Kom',
                'nip' => '197306202006041005',
                'jenis_kelamin' => 'L',
                'alamat' => 'Klaten',
                'kontak' => '081548734649',
                'email' => 'yuniantohermawan@gmail.com'
            ],
            [
                'nama' => 'Eka Nur Ahmad Romadhoni, S.Pd.',
                'nip' => '199303012019031011',
                'jenis_kelamin' => 'L',
                'alamat' => 'Klaten',
                'kontak' => '085895780078',
                'email' => 'eka.html@gmail.com'
            ],
            [
                'nama' => 'M. Endah Titisari, ST',
                'nip' => '197403022006042008',
                'jenis_kelamin' => 'P',
                'alamat' => 'Pokoh, Maguwo',
                'kontak' => '085608990027',
                'email' => 'mareta.susend@gmail.com'
            ],
            [
                'nama' => 'Rr. Retna Trimantaraningsih, ST',
                'nip' => '197006272021212002',
                'jenis_kelamin' => 'P',
                'alamat' => 'Denggung',
                'kontak' => '0856436402427',
                'email' => 'rereningsihlarose@gmail.com'
            ],
            [
                'nama' => 'Ratna Yunita Sari, ST',
                'nip' => '197107082022211003',
                'jenis_kelamin' => 'P',
                'alamat' => 'Gendeng Kidul',
                'kontak' => '085228771506',
                'email' => 'ratnayu2014@gmail.com'
            ],
        ]);


    }
}
