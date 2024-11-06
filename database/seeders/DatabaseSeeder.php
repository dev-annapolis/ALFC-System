<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Hash;
use DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        DB::table('roles')->insert([
            [
                // 'id' => 1
                'name' => 'superadmin',
                'view_name' => 'Super Admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                // 'id' => 2
                'name' => 'admin',
                'view_name' => 'Admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                // 'id' => 3
                'name' => 'sales_processor',
                'view_name' => 'Sales Processor',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                // 'id' => 4
                'name' => 'revenue_assistant',
                'view_name' => 'Revenue Assistant',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                // 'id' => 5
                'name' => 'collection',
                'view_name' => 'Collection',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                // 'id' => 6
                'name' => 'customer_care',
                'view_name' => 'Customer Care',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                // 'id' => 7
                'name' => 'accounting',
                'view_name' => 'Accounting',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                // 'id' => 8
                'name' => 'sales_associate',
                'view_name' => 'Sales Associate',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                // 'id' => 9
                'name' => 'sales_manager',
                'view_name' => 'Sales Manager',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('users')->insert([
            [
                // 'id' => 1
                'username' => 'superadmin',
                'password' => Hash::make('ALFCpassword'),
                'name' => 'SUPERADMIN',
                'email' => 'superadmin@email.com',
                'viber_number' => '09123456789',
                'role_id' => 1,
                'status' => 'verified',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                // 'id' => 2
                'username' => 'admin',
                'password' => Hash::make('ALFCpassword'),
                'name' => 'ADMIN',
                'email' => 'admin@email.com',
                'viber_number' => '09123456789',
                'role_id' => 2,
                'status' => 'verified',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                // 'id' => 3
                'username' => 'sales_processor',
                'password' => Hash::make('ALFCpassword'),
                'name' => 'SALES PROCESSOR',
                'email' => 'sales_processor@email.com',
                'viber_number' => '09123456789',
                'role_id' => 3,
                'status' => 'verified',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                // 'id' => 4
                'username' => 'revenue_assistant',
                'password' => Hash::make('ALFCpassword'),
                'name' => 'REVENUE ASSISTANT',
                'email' => 'revenue_assistant@email.com',
                'viber_number' => '09123456789',
                'role_id' => 4,
                'status' => 'verified',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                // 'id' => 5
                'username' => 'collection',
                'password' => Hash::make('ALFCpassword'),
                'name' => 'COLLECTION',
                'email' => 'collection@email.com',
                'viber_number' => '09123456789',
                'role_id' => 5,
                'status' => 'verified',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                // 'id' => 6
                'username' => 'customer_care',
                'password' => Hash::make('ALFCpassword'),
                'name' => 'CUSTOMER CARE',
                'email' => 'customer_care@email.com',
                'viber_number' => '09123456789',
                'role_id' => 6,
                'status' => 'verified',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                // 'id' => 7
                'username' => 'accounting',
                'password' => Hash::make('ALFCpassword'),
                'name' => 'ACCOUNTING',
                'email' => 'accounting@email.com',
                'viber_number' => '09123456789',
                'role_id' => 7,
                'status' => 'verified',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

    }
}
