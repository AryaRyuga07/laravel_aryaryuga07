<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
{
    \App\Models\User::create([
        'username'=>'admin',
        'email' => 'admin@gmail.com',
        'password'=>bcrypt('123456'),

    ]);

    $h1 = \App\Models\Hospital::create([
        'name'=>'RS Harapan',
        'address'=>'Jl. Merdeka',
        'email'=>'rs@harapan.com',
        'telp'=>'081111111'
    ]);

    $h2 = \App\Models\Hospital::create([
        'name'=>'RS Kasih',
        'address'=>'Jl. Sudirman',
        'email'=>'rs@kasih.com',
        'telp'=>'082222222'
    ]);

    \App\Models\Patient::create([
        'name'=>'Budi',
        'address'=>'Bandung',
        'telp'=>'083333333',
        'hospital_id'=>$h1->id
    ]);
}

}
