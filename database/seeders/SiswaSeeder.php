<?php

namespace Database\Seeders;

use App\Models\Siswa;
use Illuminate\Database\Seeder;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $siswaData = [
            [
                'nama' => 'Abu Bakar Tsabit Ghufron',
                'nis' => '20388',
                'jenis_kelamin' => 'L',
                'kelas' => 'SIJA A',
                'alamat' => 'Depok',
                'kontak' => '081234567890',
                'email' => 'abubakar@gmail.com',
                'status_lapor_pkl'=> false,
            ],
            [
                'nama' => 'Ade Rafif Daneswara',
                'nis' => '20389',
                'jenis_kelamin' => 'L',
                'kelas' => 'SIJA A',
                'alamat' => 'Jakarta',
                'kontak' => '081345678901',
                'email' => 'aderafif@gmail.com',
                'status_lapor_pkl'=> false,
            ],
            [
                'nama' => 'Ade Zaidan Althaf',
                'nis' => '20390',
                'jenis_kelamin' => 'L',
                'kelas' => 'SIJA A',
                'alamat' => 'Bogor',
                'kontak' => '081456789012',
                'email' => 'adezaidan@gmail.com',
                'status_lapor_pkl'=> false,
            ],
            [
                'nama' => 'Adhwa Khalila Ramadhani',
                'nis' => '20391',
                'jenis_kelamin' => 'P',
                'kelas' => 'SIJA A',
                'alamat' => 'Bandung',
                'kontak' => '081567890123',
                'email' => 'adhwakhalila@gmail.com',
                'status_lapor_pkl'=> false,
            ],
            [
                'nama' => 'Adnan Faris',
                'nis' => '20392',
                'jenis_kelamin' => 'L',
                'kelas' => 'SIJA A',
                'alamat' => 'Semarang',
                'kontak' => '081678901234',
                'email' => 'adnanfaris@gmail.com',
                'status_lapor_pkl'=> false,
            ],
            [
                'nama' => 'Ahmad Hanaffi Rahmadhani',
                'nis' => '20393',
                'jenis_kelamin' => 'L',
                'kelas' => 'SIJA A',
                'alamat' => 'Yogyakarta',
                'kontak' => '081789012345',
                'email' => 'ahmadhanaffi@gmail.com',
                'status_lapor_pkl'=> false,
            ],
            [
                'nama' => 'Akbar Ad\'ha Kusumawardana',
                'nis' => '20394',
                'jenis_kelamin' => 'L',
                'kelas' => 'SIJA A',
                'alamat' => 'Surabaya',
                'kontak' => '081890123456',
                'email' => 'akbaradha@gmail.com',
                'status_lapor_pkl'=> false,
            ],
            [
                'nama' => 'Andhika August Farnaz',
                'nis' => '20395',
                'jenis_kelamin' => 'L',
                'kelas' => 'SIJA A',
                'alamat' => 'Solo',
                'kontak' => '081901234567',
                'email' => 'andhikaaugust@gmail.com',
                'status_lapor_pkl'=> false,
            ],
            [
                'nama' => 'Angelina Thithis Sekar Langit',
                'nis' => '20396',
                'jenis_kelamin' => 'P',
                'kelas' => 'SIJA A',
                'alamat' => 'Malang',
                'kontak' => '081012345678',
                'email' => 'angelinasekar@gmail.com',
                'status_lapor_pkl'=> false,
            ],
            [
                'nama' => 'Arifin Nur Ihsan',
                'nis' => '20397',
                'jenis_kelamin' => 'L',
                'kelas' => 'SIJA A',
                'alamat' => 'Bali',
                'kontak' => '081123456789',
                'email' => 'arifinnurihsan@gmail.com',
                'status_lapor_pkl'=> false,
            ],
        ];

        try {
            foreach ($siswaData as $data) {
                Siswa::create($data);
            }
            $this->command->info('Data Siswa berhasil diisi!');
        } catch (\Exception $e) {
            $this->command->error('Gagal mengisi data Siswa: ' . $e->getMessage());
        }
    }
}