<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cashes')->insert([
            'code' => 'CP001',
            'alias' => 'Caja principal',
            'cash' => 0,
            'user' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('users')->insert([
            'ci' => '999999999',
            'name' => 'Administrador',
            'lastname' => 'Administrador',
            'email' => 'codebreak@gmail.com',
            'phone' => '00000000',
            'type' => 'root',
            'photo' => 'users/default_user.jpg',
            'login' => 'Administrador',
            'password' => Hash::make('Administrador'),
            'user' => 1,
            'cash' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('categories')->insert([
            'name' => 'Refrescos',
            'user' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('products')->insert([
            'code' => '1000000001',
            'name' => 'Coca Cola',
            'brand' => 'Coca Cola Company',
            'unit' => 'ml',
            'price' => '13',
            'photo' => 'products/default_product.jpg',
            'created_at' => now(),
            'updated_at' => now(),
            'category' => 1,
            'user' => 1
        ]);
        DB::table('products')->insert([
            'code' => '1000000002',
            'name' => 'Fanta',
            'brand' => 'Coca Cola Company',
            'unit' => 'ml',
            'price' => '15',
            'photo' => 'products/default_product.jpg',
            'created_at' => now(),
            'updated_at' => now(),
            'category' => 1,
            'user' => 1
        ]);
        DB::table('clients')->insert([
            'ci' => '4578487',
            'name' => 'Albim',
            'lastname' => 'Rojas Nogales',
            'phone' => '68794885',
            'email' => 'albino@gmail.com',
            'created_at' => now(),
            'updated_at' => now(),
            'user' => 1
        ]);
    }
}
