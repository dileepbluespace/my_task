<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Customer; 

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //demo data
        for ($i = 0; $i < 10000; $i++) {
            $customer = new Customer();
            $customer->name = 'Demo Name ' . ($i + 1);
            $customer->age = rand(18, 65); // Random age between 18 and 65
            $customer->salary = rand(30000, 90000); // Random salary between 30,000 and 90,000
            $customer->phone = '978-' . rand(100, 999) . '-' . rand(1000, 9999);; // Random enrollment_id between 1 and 100
            $customer->save();
        }
        //roles data
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'editor']);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

         // Create an admin role if it doesn't exist
         $role = Role::firstOrCreate(['name' => 'admin']);

         // Create or retrieve the admin user
         $admin = User::firstOrCreate(
             ['email' => 'admin@gmail.com'],
             [
                 'name' => 'Admin User',
                 'password' => bcrypt('123456'), // Replace with a secure password
             ]
         );
 
         // Assign the admin role to the admin user
        // $admin->assignRole($role);
    }
}
