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

        DB::table('teams')->insert([
            [
                // 'id' => 1
                'name' => 'AFC LUZON',
            ],
            [
                // 'id' => 2
                'name' => 'GDFI LUZON',
            ],
            [
                // 'id' => 3
                'name' => 'SAFC',
            ],
            [
                // 'id' => 4
                'name' => 'OC/DEALER',
            ],
            [
                // 'id' => 5
                'name' => 'VISAYAS',
            ],
            [
                // 'id' => 6
                'name' => 'MINDANAO',
            ],
            [
                // 'id' => 7
                'name' => 'CAPTIVE',
            ],
            [
                // 'id' => 8
                'name' => 'RENEWAL',
            ],
            [
                // 'id' => 9
                'name' => 'SPECIAL',
            ],
            [
                // 'id' => 10
                'name' => 'SOL AREA',
            ],
            [
                // 'id' => 11
                'name' => 'NOL AREA',
            ],
            [
                // 'id' => 12
                'name' => 'CAPTIVE - REPLEVIN',
            ],
            [
                // 'id' => 13
                'name' => 'GMA AREA',
            ],
        ]);
        
        DB::table('branch_managers')->insert([
            [
                // 'id' => 1
                'name' => 'BM1',
            ],
            [
                // 'id' => 2
                'name' => 'BM2',
            ],
        ]);

        // DB::table('assured_details')->insert([
            
        // ]);

        DB::table('products')->insert([
            [
                // 'id' => 1
                'name' => 'MOTORCAR',
            ],
            [
                // 'id' => 2
                'name' => 'LRI',
            ],
            [
                // 'id' => 3
                'name' => 'REPLEVIN',
            ],
            [
                // 'id' => 4
                'name' => 'PROPERTY',
            ],
            [
                // 'id' => 5
                'name' => 'TRAVEL/PA/GPA',
            ],
            [
                // 'id' => 6
                'name' => 'OTHERS',
            ],
        ]);

        DB::table('subproducts')->insert([
            [
                // 'id' => 1
                'name' => 'TRUCK',
            ],
            [
                // 'id' => 2
                'name' => 'WAGON',
            ],
            [
                // 'id' => 3
                'name' => 'SEDAN',
            ],
            [
                // 'id' => 4
                'name' => 'LUXURY CAR',
            ],
            [
                // 'id' => 5
                'name' => 'MOTORCYCLE',
            ],
            [
                // 'id' => 6
                'name' => 'CTPL',
            ],
            [
                // 'id' => 7
                'name' => 'CARI',
            ],
            [
                // 'id' => 8
                'name' => 'CGL',
            ],
            [
                // 'id' => 9
                'name' => 'FIRE',
            ],
            [
                // 'id' => 10
                'name' => 'FLOATER',
            ],
            [
                // 'id' => 11
                'name' => 'FPA',
            ],
            [
                // 'id' => 12
                'name' => 'GPA',
            ],
            [
                // 'id' => 13
                'name' => 'INLAND MARINE',
            ],
            [
                // 'id' => 14
                'name' => 'LRI',
            ],
            [
                // 'id' => 15
                'name' => 'FIDELITY GUARANTEE',
            ],
            [
                // 'id' => 16
                'name' => 'PERFORMANCE BOND',
            ],
            [
                // 'id' => 17
                'name' => 'REPLEVIN BOND',
            ],
            [
                // 'id' => 18
                'name' => 'SURETY BOND',
            ],
            [
                // 'id' => 19
                'name' => 'TRAVEL',
            ],
            [
                // 'id' => 20
                'name' => 'OTHERS',
            ],
        ]);       
        
        DB::table('sources')->insert([
            [
                // 'id' => 1
                'name' => 'AFC',
            ],
            [
                // 'id' => 2
                'name' => 'GDFI',
            ],
            [
                // 'id' => 3
                'name' => 'SAFC',
            ],
            [
                // 'id' => 4
                'name' => 'FLSC',
            ],
            [
                // 'id' => 5
                'name' => 'OTHERS',
            ],
            [
                // 'id' => 6
                'name' => 'AFC AGENT',
            ],
            [
                // 'id' => 7
                'name' => 'GDFI AGENT',
            ],
            [
                // 'id' => 8
                'name' => 'SAFC AGENT',
            ],
            [
                // 'id' => 9
                'name' => 'AFC DEALER',
            ],
            [
                // 'id' => 10
                'name' => 'GDFI DEALER',
            ],
            [
                // 'id' => 11
                'name' => 'SAFC DEALER',
            ],
            [
                // 'id' => 12
                'name' => 'OC',
            ],
            [
                // 'id' => 13
                'name' => 'CAPTIVE',
            ],
            [
                // 'id' => 14
                'name' => 'AFFI RENEWAL',
            ],
            [
                // 'id' => 15
                'name' => 'OC RENEWAL',
            ],
            [
                // 'id' => 16
                'name' => 'CAR DEALER',
            ],
            [
                // 'id' => 17
                'name' => 'TRUCK DEALER',
            ],
            [
                // 'id' => 18
                'name' => 'AFI',
            ],
            [
                // 'id' => 19
                'name' => 'RENEWAL',
            ],
            [
                // 'id' => 20
                'name' => 'AGENT',
            ],
            [
                // 'id' => 21
                'name' => 'VIP-EXECOM',
            ],
        ]);

        DB::table('source_branches')->insert([
            [
                // 'id' => 1
                'name' => 'ANTIPOLO',
            ],
            [
                // 'id' => 2
                'name' => 'ANTIQUE',
            ],
            [
                // 'id' => 3
                'name' => 'BACOLOD',
            ],
            [
                // 'id' => 4
                'name' => 'BACOOR',
            ],
            [
                // 'id' => 5
                'name' => 'BAGUIO',
            ],
            [
                // 'id' => 6
                'name' => 'BALANGA',
            ],
            [
                // 'id' => 7
                'name' => 'BALAYAN',
            ],
            [
                // 'id' => 8
                'name' => 'BALER',
            ],
            [
                // 'id' => 9
                'name' => 'BALIUAG',
            ],
            [
                // 'id' => 10
                'name' => 'BANILAD',
            ],
            [
                // 'id' => 11
                'name' => 'BATAAN',
            ],
            [
                // 'id' => 12
                'name' => 'BATANGAS',
            ],
            [
                // 'id' => 13
                'name' => 'BAUAN',
            ],
            [
                // 'id' => 14
                'name' => 'BAYAWAN',
            ],
            [
                // 'id' => 15
                'name' => 'BENGUET',
            ],
            [
                // 'id' => 16
                'name' => 'BICUTAN',
            ],
            [
                // 'id' => 17
                'name' => 'BIÑAN',
            ],
            [
                // 'id' => 18
                'name' => 'BUHANGIN',
            ],
            [
                // 'id' => 19
                'name' => 'BUTUAN',
            ],
            [
                // 'id' => 20
                'name' => 'CABANATUAN',
            ],
            [
                // 'id' => 21
                'name' => 'CABUYAO',
            ],
            [
                // 'id' => 22
                'name' => 'CAGAYAN DE ORO',
            ],
            [
                // 'id' => 23
                'name' => 'CAINTA',
            ],
            [
                // 'id' => 24
                'name' => 'CALAMBA',
            ],
            [
                // 'id' => 25
                'name' => 'CALAPAN',
            ],
            [
                // 'id' => 26
                'name' => 'CALBAYOG',
            ],
            [
                // 'id' => 27
                'name' => 'CALINAN',
            ],
            [
                // 'id' => 28
                'name' => 'CALOOCAN',
            ],
            [
                // 'id' => 29
                'name' => 'CANDELARIA',
            ],
            [
                // 'id' => 30
                'name' => 'CANDON',
            ],
            [
                // 'id' => 31
                'name' => 'CARMONA',
            ],
            [
                // 'id' => 32
                'name' => 'CATBALOGAN',
            ],
            [
                // 'id' => 33
                'name' => 'CAUAYAN',
            ],
            [
                // 'id' => 34
                'name' => 'CAVITE',
            ],
            [
                // 'id' => 35
                'name' => 'CEBU',
            ],
            [
                // 'id' => 36
                'name' => 'CONSOLACION',
            ],
            [
                // 'id' => 37
                'name' => 'DAET',
            ],
            [
                // 'id' => 38
                'name' => 'DAGUPAN',
            ],
            [
                // 'id' => 39
                'name' => 'DASMARIÑAS',
            ],
            [
                // 'id' => 40
                'name' => 'DAU',
            ],
            [
                // 'id' => 41
                'name' => 'DAVAO',
            ],
            [
                // 'id' => 42
                'name' => 'DIGOS',
            ],
            [
                // 'id' => 43
                'name' => 'DIPOLOG',
            ],
            [
                // 'id' => 44
                'name' => 'DUMAGUETE',
            ],
            [
                // 'id' => 45
                'name' => 'E. RODRIGUEZ',
            ],
            [
                // 'id' => 46
                'name' => 'ERMITA',
            ],
            [
                // 'id' => 47
                'name' => 'FAIRVIEW',
            ],
            [
                // 'id' => 48
                'name' => 'GAPAN',
            ],
            [
                // 'id' => 49
                'name' => 'GENERAL SANTOS',
            ],
            [
                // 'id' => 50
                'name' => 'GINGOOG',
            ],
            [
                // 'id' => 51
                'name' => 'HEAD OFFICE',
            ],
            [
                // 'id' => 52
                'name' => 'ILIGAN',
            ],
            [
                // 'id' => 53
                'name' => 'ILOILO',
            ],
            [
                // 'id' => 54
                'name' => 'IMUS',
            ],
            [
                // 'id' => 55
                'name' => 'INTRAMUROS',
            ],
            [
                // 'id' => 56
                'name' => 'IRIGA',
            ],
            [
                // 'id' => 57
                'name' => 'ISABELA',
            ],
            [
                // 'id' => 58
                'name' => 'KABANKALAN',
            ],
            [
                // 'id' => 59
                'name' => 'KALIBO 2',
            ],
            [
                // 'id' => 60
                'name' => 'KAPASIGAN',
            ],
            [
                // 'id' => 61
                'name' => 'KIDAPAWAN',
            ],
            [
                // 'id' => 62
                'name' => 'KORONADAL',
            ],
            [
                // 'id' => 63
                'name' => 'LA UNION',
            ],
            [
                // 'id' => 64
                'name' => 'LAGRO',
            ],
            [
                // 'id' => 65
                'name' => 'LAOAG',
            ],
            [
                // 'id' => 66
                'name' => 'LAPU LAPU',
            ],
            [
                // 'id' => 67
                'name' => 'LAS PIÑAS',
            ],
            [
                // 'id' => 68
                'name' => 'LAS PIÑAS',
            ],
            [
                // 'id' => 69
                'name' => 'LEGASPI',
            ],
            [
                // 'id' => 70
                'name' => 'LEMERY',
            ],
            [
                // 'id' => 71
                'name' => 'LINGAYEN',
            ],
            [
                // 'id' => 72
                'name' => 'LIPA',
            ],
            [
                // 'id' => 73
                'name' => 'LUBAO',
            ],
            [
                // 'id' => 74
                'name' => 'LUCENA',
            ],
            [
                // 'id' => 75
                'name' => 'MAASIN',
            ],
            [
                // 'id' => 76
                'name' => 'MAKATI',
            ],
            [
                // 'id' => 77
                'name' => 'MALAYBALAY',
            ],
            [
                // 'id' => 78
                'name' => 'MALOLOS',
            ],
            [
                // 'id' => 79
                'name' => 'MANDAUE',
            ],
            [
                // 'id' => 80
                'name' => 'MANILA',
            ],
            [
                // 'id' => 81
                'name' => 'MARIKINA',
            ],
            [
                // 'id' => 82
                'name' => 'MATI',
            ],
            [
                // 'id' => 83
                'name' => 'MEYCAUAYAN',
            ],
            [
                // 'id' => 84
                'name' => 'MINDANAO NORTH PS',
            ],
            [
                // 'id' => 85
                'name' => 'MINDANAO SOUTH PS',
            ],
            [
                // 'id' => 86
                'name' => 'MONTALBAN',
            ],
            [
                // 'id' => 87
                'name' => 'MORONG',
            ],
            [
                // 'id' => 88
                'name' => 'MUÑOZ',
            ],
            [
                // 'id' => 89
                'name' => 'MUNTINLUPA',
            ],
            [
                // 'id' => 90
                'name' => 'NAGA',
            ],
            [
                // 'id' => 91
                'name' => 'NUEVA ECIJA',
            ],
            [
                // 'id' => 92
                'name' => 'OCCIDENTAL MINDORO',
            ],
            [
                // 'id' => 93
                'name' => 'OLONGAPO',
            ],
            [
                // 'id' => 94
                'name' => 'OROQUIETA',
            ],
            [
                // 'id' => 95
                'name' => 'OROQUIETA',
            ],
            [
                // 'id' => 96
                'name' => 'ORION',
            ],
            [
                // 'id' => 97
                'name' => 'PAGADIAN',
            ],
            [
                // 'id' => 98
                'name' => 'PAGUIO',
            ],
            [
                // 'id' => 99
                'name' => 'PALAWAN',
            ],
            [
                // 'id' => 100
                'name' => 'PANGASINAN',
            ],
        ]);

        DB::table('if_gdfis')->insert([
            [
                // 'id' => 1
                'branch_division' => 'BRANCH DIVISION',
            ],
            [
                // 'id' => 2
                'branch_division' => 'TFD',
            ],
            [
                // 'id' => 3
                'branch_division' => 'CFD',
            ]
        ]);

        DB::table('areas')->insert([
            [
                // 'id' => 1
                'name' => 'GMA AREA',
            ],
            [
                // 'id' => 2
                'name' => 'SOL AREA',
            ],
            [
                // 'id' => 3
                'name' => 'NOL AREA',
            ],
            [
                // 'id' => 4
                'name' => 'VIS AREA',
            ],
            [
                // 'id' => 5
                'name' => 'MIN AREA',
            ],
            [
                // 'id' => 6
                'name' => 'HEAD OFFICE',
            ]
        ]);        

        DB::table('alfc_branches')->insert([
            [
                // 'id' => 1
                'name' => 'BACOLOD',
            ],
            [
                // 'id' => 2
                'name' => 'BICUTAN',
            ],
            [
                // 'id' => 3
                'name' => 'HEAD OFFICE',
            ],
            [
                // 'id' => 4
                'name' => 'CDO',
            ],
            [
                // 'id' => 5
                'name' => 'CEBU',
            ],
            [
                // 'id' => 6
                'name' => 'DAGUPAN',
            ],
            [
                // 'id' => 7
                'name' => 'DASMARINAS',
            ],
            [
                // 'id' => 8
                'name' => 'DAVAO',
            ],
            [
                // 'id' => 9
                'name' => 'GENSAN',
            ],
            [
                // 'id' => 10
                'name' => 'LIFEHOMES',
            ],
            [
                // 'id' => 11
                'name' => 'LIPA',
            ],
            [
                // 'id' => 12
                'name' => 'PAMPANGA',
            ],
            [
                // 'id' => 13
                'name' => 'SANTIAGO',
            ],
            [
                // 'id' => 14
                'name' => 'ILOILO',
            ],
            [
                // 'id' => 15
                'name' => 'NUEVA ECIJA',
            ],
            [
                // 'id' => 16
                'name' => 'BAGUIO',
            ]
        ]);        
        
        DB::table('mode_of_payments')->insert([
            [
                // 'id' => 1
                'name' => 'CASH',
            ],
            [
                // 'id' => 2
                'name' => 'GCASH',
            ],
        ]);

        DB::table('providers')->insert([
            [
                // 'id' => 1
                'name' => 'FGEN',
            ],
            [
                // 'id' => 2
                'name' => 'PIONEER',
            ],
            [
                // 'id' => 3
                'name' => 'OAC',
            ],
            [
                // 'id' => 4
                'name' => 'STRONGHOLD',
            ],
            [
                // 'id' => 5
                'name' => 'STANDARD',
            ],
            [
                // 'id' => 6
                'name' => 'PHILFIRST',
            ],
            [
                // 'id' => 7
                'name' => 'ALPHA',
            ],
            [
                // 'id' => 8
                'name' => 'COCOGEN',
            ],
            [
                // 'id' => 9
                'name' => 'FIRST LIFE',
            ],
            [
                // 'id' => 10
                'name' => 'MERCANTILE',
            ],
            [
                // 'id' => 11
                'name' => 'STERLING',
            ],
            [
                // 'id' => 12
                'name' => 'LIBERTY',
            ],
            [
                // 'id' => 13
                'name' => 'PACIFIC CROSS',
            ],
            [
                // 'id' => 14
                'name' => 'BETHEL',
            ],
            [
                // 'id' => 15
                'name' => 'MALAYAN',
            ],
            [
                // 'id' => 16
                'name' => 'FORTUNELIFE',
            ]
        ]);

        DB::table('commisioners')->insert([
            [
                // 'id' => 1
                'name' => 'Agent Dealer',
            ],
            [
                // 'id' => 2
                'name' => 'BM Emp',
            ],
            [
                // 'id' => 3
                'name' => 'PM Adh',
            ],
            [
                // 'id' => 4
                'name' => 'Financing',
            ],
            [
                // 'id' => 5
                'name' => 'Marketing Head',
            ],
            [
                // 'id' => 6
                'name' => 'AM',
            ],
            [
                // 'id' => 7
                'name' => 'GM',
            ],
            [
                // 'id' => 8
                'name' => 'RM',
            ],
            [
                // 'id' => 9
                'name' => 'Legal Representative',
            ],
            [
                // 'id' => 10
                'name' => 'Legal Supervisor',
            ],
            [
                // 'id' => 11
                'name' => 'Assigned Atty One',
            ],
            [
                // 'id' => 12
                'name' => 'Assigned Atty Two',
            ],
            [
                // 'id' => 13
                'name' => 'Collection GM',
            ],
            [
                // 'id' => 14
                'name' => 'AFC ATL GM',
            ],
            [
                // 'id' => 15
                'name' => 'New Incentive Program',
            ],
            [
                // 'id' => 16
                'name' => 'Referral Fee Program',
            ]
        ]);        

        DB::table('teles')->insert([
            [
                // 'id' => 1
                'name' => 'TELE1',
            ],
            [
                // 'id' => 2
                'name' => 'TELE2',
            ],
        ]);

        $users = [
            ['username' => 'aeralindayag', 'name' => 'AERA LINDAYAG', 'email' => 'aeralindayag@email.com'],
            ['username' => 'alianamariellecruz', 'name' => 'ALIANA MARIELLE CRUZ', 'email' => 'alianamariellecruz@email.com'],
            ['username' => 'allanjamesantimero', 'name' => 'ALLAN JAMES ANTINERO', 'email' => 'allanjamesantimero@email.com'],
            ['username' => 'almashahara', 'name' => 'ALMA SHAHARA MICHAELA MAMARI', 'email' => 'almashahara@email.com'],
            ['username' => 'alyssamaecollantes', 'name' => 'ALYSSA MAE COLLANTES', 'email' => 'alyssamaecollantes@email.com'],
            ['username' => 'angelvanalipio', 'name' => 'ANGEL VAN ALIPIO', 'email' => 'angelvanalipio@email.com'],
            ['username' => 'arnelbernaldez', 'name' => 'ARNEL BERNALDEZ', 'email' => 'arnelbernaldez@email.com'],
            ['username' => 'ceasarryandeleon', 'name' => 'CEASAR RYAN DE LEON', 'email' => 'ceasarryandeleon@email.com'],
            ['username' => 'christineaniban', 'name' => 'CHRISTINE ANIBAN', 'email' => 'christineaniban@email.com'],
            ['username' => 'heinzdeocampo', 'name' => 'HEINZ DE OCAMPO', 'email' => 'heinzdeocampo@email.com'],
            ['username' => 'janellepuno', 'name' => 'JANELLE PUNO', 'email' => 'janellepuno@email.com'],
            ['username' => 'jasminmeamo', 'name' => 'JASMIN MEAMO', 'email' => 'jasminmeamo@email.com'],
            ['username' => 'jeannierosedelfin', 'name' => 'JEANNIE ROSE DELFIN', 'email' => 'jeannierosedelfin@email.com'],
            ['username' => 'jerlynmacaraeg', 'name' => 'JERLYN MACARAEG', 'email' => 'jerlynmacaraeg@email.com'],
            ['username' => 'joferpacol', 'name' => 'JOFERSON PACOL', 'email' => 'joferpacol@email.com'],
            ['username' => 'josephbosque', 'name' => 'JOSEPH BOSQUE', 'email' => 'josephbosque@email.com'],
            ['username' => 'kiaramayluar', 'name' => 'KIARA MAE LUAR', 'email' => 'kiaramayluar@email.com'],
            ['username' => 'kristelcepe', 'name' => 'KRISTEL CEPE', 'email' => 'kristelcepe@email.com'],
            ['username' => 'mikerenzosantiago', 'name' => 'MIKE RENZO SANTIAGO', 'email' => 'mikerenzosantiago@email.com'],
            ['username' => 'pauldominicursonal', 'name' => 'PAUL DOMINIC URSONAL', 'email' => 'pauldominicursonal@email.com'],
            ['username' => 'rachelguibao', 'name' => 'RACHEL GUIBAO', 'email' => 'rachelguibao@email.com'],
            ['username' => 'ramsensumcad', 'name' => 'RAMSEN SUMCAD', 'email' => 'ramsensumcad@email.com'],
            ['username' => 'rheaabrenio', 'name' => 'RHEA ABRENIO', 'email' => 'rheaabrenio@email.com'],
            ['username' => 'ricamaeestabillo', 'name' => 'RICA MAE ESTABILLO', 'email' => 'ricamaeestabillo@email.com'],
            ['username' => 'rickyandrade', 'name' => 'RICKY ANDRADE', 'email' => 'rickyandrade@email.com'],
            ['username' => 'rosenicellefollero', 'name' => 'ROSE NICELLE FOLLERO', 'email' => 'rosenicellefollero@email.com'],
            ['username' => 'rubyshienbalagtas', 'name' => 'RUBY SHIEN BALAGTAS', 'email' => 'rubyshienbalagtas@email.com'],
            ['username' => 'sherwinvaldoz', 'name' => 'SHERWIN VALDOZ', 'email' => 'sherwinvaldoz@email.com'],
            ['username' => 'tesalonica', 'name' => 'TESALONICA BALUYUT', 'email' => 'tesalonica@email.com'],
            ['username' => 'catherineangeladejesus', 'name' => 'CATHERINE ANGELA DE JESUS', 'email' => 'catherineangeladejesus@email.com'],
            ['username' => 'lyzajillparalejas', 'name' => 'LYZA JILL PARALEJAS', 'email' => 'lyzajillparalejas@email.com'],
            ['username' => 'maryrosepanorel', 'name' => 'MARY ROSE PANOREL', 'email' => 'maryrosepanorel@email.com'],
            ['username' => 'mariebethruiz', 'name' => 'MARIEBETH RUIZ', 'email' => 'mariebethruiz@email.com'],
            ['username' => 'vanessacabarios', 'name' => 'VANESSA CABARIOS', 'email' => 'vanessacabarios@email.com'],
            ['username' => 'aizatumaob', 'name' => 'AIZA TUMAOB', 'email' => 'aizatumaob@email.com'],
            ['username' => 'darnellauro', 'name' => 'DARNELL AURO', 'email' => 'darnellauro@email.com'],
            ['username' => 'rochellemorta', 'name' => 'ROCHELLE MORTA', 'email' => 'rochellemorta@email.com'],
            ['username' => 'josephmagracia', 'name' => 'JOSEPH MAGRACIA', 'email' => 'josephmagracia@email.com'],
            ['username' => 'rhearefamonte', 'name' => 'RHEA REFAMONTE', 'email' => 'rhearefamonte@email.com'],
            ['username' => 'maginnelchavez', 'name' => 'MA GINNEL CHAVEZ', 'email' => 'maginnelchavez@email.com'],
            ['username' => 'kennedyMarabe', 'name' => 'KENNEDY MARABE', 'email' => 'kennedyMarabe@email.com'],
            ['username' => 'artcheyap', 'name' => 'ARTCHE YAP', 'email' => 'artcheyap@email.com'],
            ['username' => 'ryankevinberlos', 'name' => 'RYAN KEVIN BERLOS', 'email' => 'ryankevinberlos@email.com'],
            ['username' => 'jonnalynnocossingcuenco', 'name' => 'JONNALYN NOCOS SINGCUENCO', 'email' => 'jonnalynnocossingcuenco@email.com'],
            ['username' => 'mariaangelaperalta', 'name' => 'MARIA ANGELA PERALTA', 'email' => 'mariaangelaperalta@email.com'],
            ['username' => 'alexanderaparejado', 'name' => 'ALEXANDER APAREJADO', 'email' => 'alexanderaparejado@email.com'],
            ['username' => 'leonitoarroyo', 'name' => 'LEONITO ARROYO', 'email' => 'leonitoarroyo@email.com'],
            ['username' => 'rexmillan', 'name' => 'REX MILLAN', 'email' => 'rexmillan@email.com'],
            ['username' => 'rylanjaycadalso', 'name' => 'RYLAN JAY CADALSO', 'email' => 'rylanjaycadalso@email.com'],
            ['username' => 'alexanderaparejado2', 'name' => 'ALEXANDER APAREJADO', 'email' => 'alexanderaparejado2@email.com'],
            ['username' => 'leonitoarroyo', 'name' => 'LEONITO ARROYO', 'email' => 'leonitoarroyo@email.com'],
            ['username' => 'rylanjaycadalso', 'name' => 'RYLAN JAY CADALSO', 'email' => 'rylanjaycadalso@email.com'],
            ['username' => 'jimboyguno', 'name' => 'JIMBOY GUNO', 'email' => 'jimboyguno@email.com'],
            ['username' => 'altaniebantassaed', 'name' => 'ALTANIE BANTAS SAED', 'email' => 'altaniebantassaed@email.com'],
            ['username' => 'julieannyangco', 'name' => 'JULIE ANN YANGCO', 'email' => 'julieannyangco@email.com'],
            ['username' => 'levindantescanlas', 'name' => 'LEVIN DANTES CANLAS', 'email' => 'levindantescanlas@email.com'],
            ['username' => 'angeliacamilledelacruz', 'name' => 'ANGELIE CAMILLE DELA CRUZ', 'email' => 'angeliacamilledelacruz@email.com'],
            ['username' => 'vincentreysales', 'name' => 'VINCENT REY REVILLAS', 'email' => 'vincentreysales@email.com'],
            ['username' => 'azeleaozar', 'name' => 'AZE LEA OZAR', 'email' => 'azeleaozar@email.com'],
            ['username' => 'niczc', 'name' => 'c/o Nicz', 'email' => 'niczc@email.com'],
            ['username' => 'romelflores', 'name' => 'ROMEL FLORES', 'email' => 'romelflores@email.com'],
            ['username' => 'marygracebangoy', 'name' => 'MARY GRACE BANGOY', 'email' => 'marygracebangoy@email.com'],
            ['username' => 'romualdoejercito', 'name' => 'ROMUALDO EJERCITO', 'email' => 'romualdoejercito@email.com'],
            ['username' => 'patricksenara', 'name' => 'PATRICK SEÑARA', 'email' => 'patricksenara@email.com'],
            ['username' => 'davepayo', 'name' => 'DAVE PAYO', 'email' => 'davepayo@email.com'],
            ['username' => 'miralunavicentino', 'name' => 'MIRALUNA VICENTINO', 'email' => 'miralunavicentino@email.com'],
            ['username' => 'geraldcoleta', 'name' => 'GERALD COLETA', 'email' => 'geraldcoleta@email.com'],
            ['username' => 'alizaalberto', 'name' => 'ALIZA ALBERTO', 'email' => 'alizaalberto@email.com'],
            ['username' => 'vincendriz', 'name' => 'VINCENT DRIZ', 'email' => 'vincendriz@email.com'],
            ['username' => 'ruelpelagio', 'name' => 'RUEL PELAGIO', 'email' => 'ruelpelagio@email.com'],
            ['username' => 'maelezabethgeraldeso', 'name' => 'MA. ELEZABETH R. GERALDESO', 'email' => 'maelezabethgeraldeso@email.com'],
            ['username' => 'allaizabaez', 'name' => 'ALLAIZA BAEZ', 'email' => 'allaizabaez@email.com'],
            ['username' => 'alizamaealberto', 'name' => 'ALIZA MAE ALBERTO', 'email' => 'alizamaealberto@email.com'],
            ['username' => 'roanprinceabarra', 'name' => 'ROAN PRINCESS ABARRA', 'email' => 'roanprinceabarra@email.com'],
            ['username' => 'junelynmorcoso', 'name' => 'JUNELYN MORCOSO', 'email' => 'junelynmorcoso@email.com'],
            ['username' => 'rodjenasan', 'name' => 'RODJEN ASAN', 'email' => 'rodjenasan@email.com'],
            ['username' => 'angelicalingad', 'name' => 'ANGELICA LINGAD', 'email' => 'angelicalingad@email.com'],
            ['username' => 'applealfornon', 'name' => 'APPLE ALFORNON', 'email' => 'applealfornon@email.com'],
            ['username' => 'jastinelegara', 'name' => 'JASTINE LEGARA', 'email' => 'jastinelegara@email.com'],
            ['username' => 'sheindylantonino', 'name' => 'SHEINDY L. ANTONINO', 'email' => 'sheindylantonino@email.com'],
            ['username' => 'johnlesterlicu', 'name' => 'JOHN LESTER LICU', 'email' => 'johnlesterlicu@email.com'],
            ['username' => 'lycajoybarriga', 'name' => 'LYCA JOY BARRIGA', 'email' => 'lycajoybarriga@email.com'],
            ['username' => 'kylacaamic', 'name' => 'KYLA CAAMIC', 'email' => 'kylacaamic@email.com'],
            ['username' => 'angelineowarren', 'name' => 'ANGELINE O. WARREN', 'email' => 'angelineowarren@email.com'],
            ['username' => 'williencordovajr', 'name' => 'WILLIE N. CORDOVA JR.', 'email' => 'williencordovajr@email.com'],
            ['username' => 'gwenflores', 'name' => 'GWEN FLORES', 'email' => 'gwenflores@email.com'],
            ['username' => 'angelabaluyot', 'name' => 'ANGELA BALUYOT', 'email' => 'angelabaluyot@email.com'],
            ['username' => 'markwencyanago', 'name' => 'MARK WENCY AÑAGO', 'email' => 'markwencyanago@email.com'],
            ['username' => 'jhonsarmiento', 'name' => 'JHON SARMIENTO', 'email' => 'jhonsarmiento@email.com'],
            ['username' => 'michaelsantos', 'name' => 'MICHAEL SANTOS', 'email' => 'michaelsantos@email.com'],
            ['username' => 'kentarvypabon', 'name' => 'KENT ARVY PABON', 'email' => 'kentarvypabon@email.com'],
            ['username' => 'elgeneiancatarig', 'name' => 'ELGENE IAN CATARIG', 'email' => 'elgeneiancatarig@email.com'],
            ['username' => 'erikaedillo', 'name' => 'ERIKA EDILLO', 'email' => 'erikaedillo@email.com'],
            ['username' => 'hannaong', 'name' => 'HANNA ONG', 'email' => 'hannaong@email.com'],
            ['username' => 'giljrosario', 'name' => 'GILJ ROSARIO', 'email' => 'giljrosario@email.com'],
            ['username' => 'euginestevencolorado', 'name' => 'EUGINE STEVEN COLORADO', 'email' => 'euginestevencolorado@email.com'],
            ['username' => 'aljohnmariveles', 'name' => 'ALJOHN MARIVELES', 'email' => 'aljohnmariveles@email.com'],
            ['username' => 'angelopoquiz', 'name' => 'ANGELO POQUIZ', 'email' => 'angelopoquiz@email.com'],
            ['username' => 'roselledevera', 'name' => 'ROSELLE DE VERA', 'email' => 'roselledevera@email.com'],
            ['username' => 'chrisdominguez', 'name' => 'CHRIS DOMINGUEZ', 'email' => 'chrisdominguez@email.com'],
            ['username' => 'kareenpascua', 'name' => 'KAREEN PASCUA', 'email' => 'kareenpascua@email.com'],
            ['username' => 'mariaelzabethgillo', 'name' => 'MARIA ELZABETH GILLO', 'email' => 'mariaelzabethgillo@email.com'],
            ['username' => 'jessaruedas', 'name' => 'JESSA RUEDAS', 'email' => 'jessaruedas@email.com'],
            ['username' => 'michaeljrdemesa', 'name' => 'MICHAEL JR DE MESA', 'email' => 'michaeljrdemesa@email.com'],
            ['username' => 'marvinlyson', 'name' => 'MARVIN LYSON', 'email' => 'marvinlyson@email.com'],
            ['username' => 'fritziejimenez', 'name' => 'FRITZIE JIMENEZ', 'email' => 'fritziejimenez@email.com'],
            ['username' => 'gerlynanasco', 'name' => 'GERLYN AÑASCO', 'email' => 'gerlynanasco@email.com'],
            ['username' => 'jessasuarez', 'name' => 'JESSA SUAREZ', 'email' => 'jessasuarez@email.com'],
            ['username' => 'micoleludovice', 'name' => 'MICOLE LUDOVICE', 'email' => 'micoleludovice@email.com'],
            ['username' => 'laramaeatona', 'name' => 'LARA MAE ATON', 'email' => 'laramaeatona@email.com'],
            ['username' => 'fulgenciojosejarina', 'name' => 'FULGENCIO JOSE JARINA', 'email' => 'fulgenciojosejarina@email.com'],
            ['username' => 'benedickmanuel', 'name' => 'BENEDICK MANUEL', 'email' => 'benedickmanuel@email.com'],
            ['username' => 'luisadrianruz', 'name' => 'LUIS ADRIAN RUZ', 'email' => 'luisadrianruz@email.com'],
            ['username' => 'markangelobassig', 'name' => 'MARK ANGELO BASSIG', 'email' => 'markangelobassig@email.com'],
            ['username' => 'elvinjohnbioco', 'name' => 'ELVIN JOHN BIOCO', 'email' => 'elvinjohnbioco@email.com'],
            ['username' => 'annacebu', 'name' => 'ANN ACEBU', 'email' => 'annacebu@email.com'],
            ['username' => 'quenceldorado', 'name' => 'QUENCEL DORADO', 'email' => 'quenceldorado@email.com'],
            ['username' => 'beallosala', 'name' => 'BEA LLOSALA', 'email' => 'beallosala@email.com'],
            ['username' => 'johnlloydolid', 'name' => 'JOHN LLOYD OLID', 'email' => 'johnlloydolid@email.com'],
            ['username' => 'erentroydemesa', 'name' => 'EREN TROY DE MESA', 'email' => 'erentroydemesa@email.com'],
            ['username' => 'sebastianamador', 'name' => 'SEBASTIAN AMADOR', 'email' => 'sebastianamador@email.com'],
            ['username' => 'marmainejanecandelario', 'name' => 'MARMAINE JANE CANDELARIO', 'email' => 'marmainejanecandelario@email.com'],
            ['username' => 'jonascordovilla', 'name' => 'JONAS CORDOVILLA', 'email' => 'jonascordovilla@email.com'],
            ['username' => 'mikehernando', 'name' => 'MIKE HERNANDO', 'email' => 'mikehernando@email.com'],
            ['username' => 'marianneayno', 'name' => 'MARIANNE SAYNO', 'email' => 'marianneayno@email.com'],
            ['username' => 'nicolemaereponte', 'name' => 'NICOLE MAE REPONTE', 'email' => 'nicolemaereponte@email.com'],
            ['username' => 'jayvillanueva', 'name' => 'JAY VILLANUEVA', 'email' => 'jayvillanueva@email.com'],
            ['username' => 'voyielbutaya', 'name' => 'VOYIEL BUTAYA', 'email' => 'voyielbutaya@email.com'],
            ['username' => 'renzoncaluag', 'name' => 'RENZON CALUAG', 'email' => 'renzoncaluag@email.com'],
            ['username' => 'arjayaguilar', 'name' => 'ARJAY AGUILAR', 'email' => 'arjayaguilar@email.com'],
            ['username' => 'erikajoyparas', 'name' => 'ERIKA JOY PARAS', 'email' => 'erikajoyparas@email.com'],
            ['username' => 'edsonisidro', 'name' => 'EDSON ISIDRO', 'email' => 'edsonisidro@email.com'],
            ['username' => 'marcilao', 'name' => 'MARC ILAO', 'email' => 'marcilao@email.com'],
            ['username' => 'aubreymission', 'name' => 'AUBREY MISSION', 'email' => 'aubreymission@email.com'],
            ['username' => 'kimberlypadilla', 'name' => 'KIMBERLY PADILLA', 'email' => 'kimberlypadilla@email.com'],
            ['username' => 'marvicnagrampa', 'name' => 'MARVIC NAGRAMPA', 'email' => 'marvicnagrampa@email.com'],
            ['username' => 'kimberlymatranas', 'name' => 'KIMBERLY MATRANAS', 'email' => 'kimberlymatranas@email.com'],
            ['username' => 'benziermendez', 'name' => 'BENZIER MENDEZ', 'email' => 'benziermendez@email.com'],
            ['username' => 'gerardbenedictorilla', 'name' => 'GERARD BENEDICT ORILLA', 'email' => 'gerardbenedictorilla@email.com'],
            ['username' => 'joannenicoleoro', 'name' => 'JOANNE NICOLE ORO', 'email' => 'joannenicoleoro@email.com'],
            ['username' => 'maestelitorres', 'name' => 'MA. ESTELITA TORRES', 'email' => 'maestelitorres@email.com'],
            ['username' => 'annafesaquilabon', 'name' => 'ANNA FE SAQUILABON', 'email' => 'annafesaquilabon@email.com'],
            ['username' => 'maannalandong', 'name' => 'MA. ANNA LANDONG', 'email' => 'maannalandong@email.com'],
            ['username' => 'seandejesus', 'name' => 'SEAN DE JESUS', 'email' => 'seandejesus@email.com'],
            ['username' => 'krisrubooca', 'name' => 'KRIS RUBOCCA', 'email' => 'krisrubooca@email.com'],
            ['username' => 'reymarkmacasling', 'name' => 'REY MARK MACASLING', 'email' => 'reymarkmacasling@email.com'],
            ['username' => 'adryllermitchrilloraza', 'name' => 'ADRYLLE MITCH RILLORAZA', 'email' => 'adryllermitchrilloraza@email.com'],
            ['username' => 'johnderrickmoratalla', 'name' => 'JOHN DERRICK MORATALLA', 'email' => 'johnderrickmoratalla@email.com'],
            ['username' => 'jenickaranton', 'name' => 'JENICK ARANTON', 'email' => 'jenickaranton@email.com'],
            ['username' => 'zaarasarno', 'name' => 'ZAARA SARNO', 'email' => 'zaarasarno@email.com'],
            ['username' => 'aundreybataller', 'name' => 'AUNDREY BATALLER', 'email' => 'aundreybataller@email.com'],
            ['username' => 'chrisjanrhaigoperaña', 'name' => 'CHRISJAN RHAI G. OPERAÑA', 'email' => 'chrisjanrhaigoperaña@email.com']
        ];

        $salesAssociates = [];
        $userId = 8;
        foreach ($users as $index => $user) {
            $salesAssociates[] = [
                'name' => $user['name'],
                'user_id' => $userId++, // Start from user_id 8
                'team_id' => 1, // Assuming all are in team 1
            ];
        }

        DB::table('users')->insert($users);
        DB::table('sales_associates')->insert($salesAssociates);
        
    }
}
