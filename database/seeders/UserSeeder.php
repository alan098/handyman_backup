<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('handyman_users_app')->insert([
        //     'name' => 'Francisco Noceda',
        //     'email' => 'admin@demo.com',
        //     'short_description' => 'short_description',
        //     'qualification' => 4.0,
        //     'profession' => 'profession',
        //     'price' => 24.00,
        //     'profile_photo_path' => 'worker1.png',
        //     'password' => bcrypt('secret')
        // ]);
        $item=2;
        for ($i=0; $i < 100; $i++) { 
            DB::table('handyman_users_app')->insert([
                'name' => 'Cajero'.$item,
                'email' => 'caja'.$item.'@demo.com',
                'short_description' => 'short_description',
                'qualification' => 4.0,
                'profession' => 'profession',
                'price' => 24.00,
                'profile_photo_path' => 'worker2.png',
                'password' => bcrypt('secret'),
            ]);
            $item++;
        }
           
        
       

        // DB::table('handyman_users_app')->insert([
        //     'name' => 'Alexandra Vera',
        //     'email' => 'ale@demo.com',
        //     'short_description' => 'short_description',
        //     'qualification' => 4.0,
        //     'profession' => 'profession',
        //     'price' => 24.00,
        //     'profile_photo_path' => 'worker3.png',
        //     'password' => bcrypt('secret'),
        // ]);

        // DB::table('handyman_users_app')->insert([
        //     'name' => 'Monica Ortiz',
        //     'email' => 'monica@demo.com',
        //     'short_description' => 'short_description',
        //     'qualification' => 4.0,
        //     'profession' => 'profession',
        //     'price' => 24.00,
        //     'profile_photo_path' => 'worker1.png',
        //     'password' => bcrypt('secret'),
        // ]);

        // DB::table('handyman_users_app')->insert([
        //     'name' => 'Thalia Benitez',
        //     'email' => 'thalia@demo.com',
        //     'short_description' => 'short_description',
        //     'qualification' => 4.0,
        //     'profession' => 'profession',
        //     'price' => 24.00,
        //     'profile_photo_path' => 'worker1.png',
        //     'password' => bcrypt('secret'),
        // ]);


    }
}
