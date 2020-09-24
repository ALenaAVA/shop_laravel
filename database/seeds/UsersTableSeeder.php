<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


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
            ['name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => bcrypt('admin'),
               'is_admin' => 1],
//            ['name' => 'User1',
//                'email' => 'user1@example.com',
//                'password' => bcrypt('1qaz2wsx')],
//            ['name' => 'User2',
//                'email' => 'user2@example.com',
//                'password' => bcrypt('1qaz2wsx')],
        ]);
    }
}
