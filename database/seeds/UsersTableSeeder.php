<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
            'name' => 'peyman',
            'email' => 'email@example.com',
            'password' => 123456
        ]);
        
        factory(App\User::class, 20)->create();
    }
}
