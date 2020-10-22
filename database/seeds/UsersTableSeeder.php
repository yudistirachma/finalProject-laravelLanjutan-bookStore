<?php

use Ramsey\Uuid\Uuid;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id' => Uuid::uuid4()->toString(),
            'name' => "Rahma Yidistira",
            'email' => 'yudistira.anaga@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);
    }
}
