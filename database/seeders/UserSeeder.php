<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{

    public function run()
    {
        $user=User::create([
            'name' => 'admin',
            'role' => 'admin',
            'activation' => 1,
            'add_product' => 1,
            'store_name' => 'lady_store',
            'location' => 'riyadh',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin'),
            'phone' => "01025070424",
            'geoLocation' => '1,1',
            'whatsapp' => "01025070424",
        ]);
    }
}
