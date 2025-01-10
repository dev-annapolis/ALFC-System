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
                'name' => 'GMA AREA',
            ],
            [
                // 'id' => 2
                'name' => 'NOL AREA',
            ],
            [
                // 'id' => 3
                'name' => 'SAFC-NCR',
            ],
            [
                // 'id' => 4
                'name' => 'SOL AREA',
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
                'name' => 'CAPTIVE - OTHERS',
            ],
            [
                // 'id' => 8
                'name' => 'CAPTIVE - REPLEVIN',
            ],
            [
                // 'id' => 9
                'name' => 'RENEWAL',
            ],
            [
                // 'id' => 10
                'name' => 'CAM MULTIPLIER',
            ],
            [
                // 'id' => 11
                'name' => 'SPECIAL',
            ],
            [
                // 'id' => 12
                'name' => 'Digital Marketer',
            ],
            [
                // 'id' => 13
                'name' => 'CUSTOMER CARE',
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
            [
                // 'id' => 22
                'name' => 'VIP-BOD',
            ],
            [
                // 'id' => 23
                'name' => 'VIP-DIRECT',
            ],
            [
                // 'id' => 24
                'name' => 'VIP-OC',
            ],
            [
                // 'id' => 25
                'name' => 'GLOBAL SME',
            ],
            [
                // 'id' => 26
                'name' => 'AFFI REF',
            ],
            [
                // 'id' => 27
                'name' => 'CAPTIVE REF',
            ],
            [
                // 'id' => 28
                'name' => 'OC REF',
            ],
        ]);

        DB::table('source_branches')->insert([
            [
                'name' => 'ABRA',
            ],
            [
                'name' => 'AGOO',
            ],
            [
                'name' => 'ALAMINOS',
            ],
            [
                'name' => 'AMANG RODRIGUEZ',
            ],
            [
                'name' => 'ANGELES',
            ],
            [
                'name' => 'ANGELES BRAND NEW',
            ],
            [
                'name' => 'ANTIPOLO',
            ],
            [
                'name' => 'ANTIQUE',
            ],
            [
                'name' => 'BACOLOD',
            ],
            [
                'name' => 'BACOLOD EAST',
            ],
            [
                'name' => 'BACOOR',
            ],
            [
                'name' => 'BAGUIO',
            ],
            [
                'name' => 'BAIS',
            ],
            [
                'name' => 'BAJADA',
            ],
            [
                'name' => 'BALANGA',
            ],
            [
                'name' => 'BALAYAN',
            ],
            [
                'name' => 'BALER',
            ],
            [
                'name' => 'BALIUAG',
            ],
            [
                'name' => 'BANILAD',
            ],
            [
                'name' => 'BANSALAN',
            ],
            [
                'name' => 'BASAK LAPU-LAPU',
            ],
            [
                'name' => 'BATAAN',
            ],
            [
                'name' => 'BATAC',
            ],
            [
                'name' => 'BATANGAS',
            ],
            [
                'name' => 'BAUAN',
            ],
            [
                'name' => 'BAYAWAN',
            ],
            [
                'name' => 'BENGUET',
            ],
            [
                'name' => 'BICUTAN',
            ],
            [
                'name' => 'BIÑAN',
            ],
            [
                'name' => 'BISLIG',
            ],
            [
                'name' => 'BOGO',
            ],
            [
                'name' => 'BUHANGIN',
            ],
            [
                'name' => 'BUHANGIN',
            ],
            [
                'name' => 'BULACAO',
            ],
            [
                'name' => 'BUNAO',
            ],
            [
                'name' => 'BUTUAN',
            ],
            [
                'name' => 'BUUG',
            ],
            [
                'name' => 'CABANATUAN',
            ],
            [
                'name' => 'CABUYAO',
            ],
            [
                'name' => 'CADIZ',
            ],
            [
                'name' => 'CAGAYAN DE ORO',
            ],
            [
                'name' => 'CAINTA',
            ],
            [
                'name' => 'CALAMBA',
            ],
            [
                'name' => 'CALAPAN',
            ],
            [
                'name' => 'CALASIAO',
            ],
            [
                'name' => 'CALBAYOG',
            ],
            [
                'name' => 'CALINAN',
            ],
            [
                'name' => 'CALINDAGAN',
            ],
            [
                'name' => 'CALOOCAN',
            ],
            [
                'name' => 'CALUMPANG',
            ],
            [
                'name' => 'CANDELARIA',
            ],
            [
                'name' => 'CANDON',
            ],
            [
                'name' => 'CARCAR',
            ],
            [
                'name' => 'CARMONA',
            ],
            [
                'name' => 'CATARMAN',
            ],
            [
                'name' => 'CATBALOGAN',
            ],
            [
                'name' => 'CATITIPAN',
            ],
            [
                'name' => 'CAUAYAN',
            ],
            [
                'name' => 'CAVITE',
            ],
            [
                'name' => 'CDO',
            ],
            [
                'name' => 'CEBU',
            ],
            [
                'name' => 'CEBU PS 1',
            ],
            [
                'name' => 'CEBU PS 2',
            ],
            [
                'name' => 'CEBU PS 3',
            ],
            [
                'name' => 'CENTRO EAST SANTIAGO',
            ],
            [
                'name' => 'CITY OF HEIGHTS',
            ],
            [
                'name' => 'COMMONWEALTH',
            ],
            [
                'name' => 'CONGRESSIONAL',
            ],
            [
                'name' => 'CONSOLACION',
            ],
            [
                'name' => 'DAET',
            ],
            [
                'name' => 'DAGUPAN',
            ],
            [
                'name' => 'DASMARIÑAS',
            ],
            [
                'name' => 'DAU',
            ],
            [
                'name' => 'DAVAO',
            ],
            [
                'name' => 'DIGOS',
            ],
            [
                'name' => 'DINALUPIHAN',
            ],
            [
                'name' => 'DIPOLOG',
            ],
            [
                'name' => 'DON ANTONIO',
            ],
            [
                'name' => 'DUMAGUETE',
            ],
            [
                'name' => 'E. RODRIGUEZ',
            ],
            [
                'name' => 'ERMITA',
            ],
            [
                'name' => 'FAIRVIEW',
            ],
            [
                'name' => 'GAPAN',
            ],
            [
                'name' => 'GEN. TRIAS',
            ],
            [
                'name' => 'GENERAL SANTOS',
            ],
            [
                'name' => 'GENSAN',
            ],
            [
                'name' => 'GINGOOG',
            ],
            [
                'name' => 'GMA',
            ],
            [
                'name' => 'GUMACA',
            ],
            [
                'name' => 'HEAD OFFICE',
            ],
            [
                'name' => 'IBA ZAMBALES',
            ],
            [
                'name' => 'ILIGAN',
            ],
            [
                'name' => 'ILOILO',
            ],
            [
                'name' => 'ILOILO 2',
            ],
            [
                'name' => 'ILOILO ARMY',
            ],
            [
                'name' => 'IMUS',
            ],
            [
                'name' => 'INTRAMUROS',
            ],
            [
                'name' => 'IPIL',
            ],
            [
                'name' => 'IRIGA',
            ],
            [
                'name' => 'ISABELA',
            ],
            [
                'name' => 'JARO',
            ],
            [
                'name' => 'KABACAN',
            ],
            [
                'name' => 'KABANKALAN',
            ],
            [
                'name' => 'KALIBO',
            ],
            [
                'name' => 'KALIBO 2',
            ],
            [
                'name' => 'KAPASIGAN',
            ],
            [
                'name' => 'KIDAPAWAN',
            ],
            [
                'name' => 'KORONADAL',
            ],
            [
                'name' => 'LA TRINIDAD',
            ],
            [
                'name' => 'LA UNION',
            ],
            [
                'name' => 'LAGAO',
            ],
            [
                'name' => 'LAGRO',
            ],
            [
                'name' => 'LAOAG',
            ],
            [
                'name' => 'LAPAZ',
            ],
            [
                'name' => 'LAPU LAPU',
            ],
            [
                'name' => 'LAS PIÑAS',
            ],
            [
                'name' => 'LAS PIÑAS',
            ],
            [
                'name' => 'LEGASPI',
            ],
            [
                'name' => 'LEMERY',
            ],
            [
                'name' => 'LIBIS',
            ],
            [
                'name' => 'LINGAYEN',
            ],
            [
                'name' => 'LIPA',
            ],
            [
                'name' => 'LOS BAÑOS',
            ],
            [
                'name' => 'LUBAO',
            ],
            [
                'name' => 'LUCENA',
            ],
            [
                'name' => 'MAASIN',
            ],
            [
                'name' => 'MABOLO',
            ],
            [
                'name' => 'MAGUIKAY',
            ],
            [
                'name' => 'MAKATI',
            ],
            [
                'name' => 'MALAYBALAY',
            ],
            [
                'name' => 'MALOLOS',
            ],
            [
                'name' => 'MAMBALING',
            ],
            [
                'name' => 'MAMBALING',
            ],
            [
                'name' => 'MANDALUYONG',
            ],
            [
                'name' => 'MANDAUE',
            ],
            [
                'name' => 'MANILA',
            ],
            [
                'name' => 'MARASBARAS',
            ],
            [
                'name' => 'MARIKINA',
            ],
            [
                'name' => 'MATI',
            ],
            [
                'name' => 'MEYCAUAYAN',
            ],
            [
                'name' => 'MIDSAYAP',
            ],
            [
                'name' => 'MINDANAO NORTH PS',
            ],
            [
                'name' => 'MINDANAO SOUTH PS',
            ],
            [
                'name' => 'MINGLANILLA',
            ],
            [
                'name' => 'MOLAVE',
            ],
            [
                'name' => 'MOLINO',
            ],
            [
                'name' => 'MOLO ILOILO',
            ],
            [
                'name' => 'MONTALBAN',
            ],
            [
                'name' => 'MUNTINLUPA',
            ],
            [
                'name' => 'N/A',
            ],
            [
                'name' => 'NABUNTURAN',
            ],
            [
                'name' => 'NAGA',
            ],
            [
                'name' => 'NARVACAN TM',
            ],
            [
                'name' => 'NGMA BNC',
            ],
            [
                'name' => 'NGMA PS',
            ],
            [
                'name' => 'NOL 1 PS',
            ],
            [
                'name' => 'NOL 1B PS',
            ],
            [
                'name' => 'NOL 2 PS',
            ],
            [
                'name' => 'NOL 3 PS',
            ],
            [
                'name' => 'NOVALICHES',
            ],
            [
                'name' => 'OLONGAPO',
            ],
            [
                'name' => 'ORMOC',
            ],
            [
                'name' => 'OROQUIETA',
            ],
            [
                'name' => 'OZAMIS',
            ],
            [
                'name' => 'OZAMIZ',
            ],
            [
                'name' => 'PAGADIAN',
            ],
            [
                'name' => 'PAGBILAO',
            ],
            [
                'name' => 'PAJO LAPU-LAPU',
            ],
            [
                'name' => 'PALAWAN',
            ],
            [
                'name' => 'PALO',
            ],
            [
                'name' => 'PANABO',
            ],
            [
                'name' => 'PANACAN',
            ],
            [
                'name' => 'PANIQUI',
            ],
            [
                'name' => 'PARAÑAQUE',
            ],
            [
                'name' => 'PASAY',
            ],
            [
                'name' => 'PASAY',
            ],
            [
                'name' => 'PASIG',
            ],
            [
                'name' => 'PATEROS',
            ],
            [
                'name' => 'PILI',
            ],
            [
                'name' => 'PINAMALAYAN',
            ],
            [
                'name' => 'PLARIDEL',
            ],
            [
                'name' => 'POLOMOLOK',
            ],
            [
                'name' => 'QUEZON AVE.',
            ],
            [
                'name' => 'QUEZON CITY',
            ],
            [
                'name' => 'ROSARIO',
            ],
            [
                'name' => 'ROXAS',
            ],
            [
                'name' => 'SAFC SPECIAL ACCOUNTS',
            ],
            [
                'name' => 'SAMPALOC',
            ],
            [
                'name' => 'SAN CARLOS',
            ],
            [
                'name' => 'SAN FERNANDO',
            ],
            [
                'name' => 'SAN FRANCISCO',
            ],
            [
                'name' => 'SAN JOSE DEL MONTE',
            ],
            [
                'name' => 'SAN JUAN',
            ],
            [
                'name' => 'SAN NICOLAS',
            ],
            [
                'name' => 'SAN PABLO',
            ],
            [
                'name' => 'SAN PEDRO',
            ],
            [
                'name' => 'SANTA ROSA',
            ],
            [
                'name' => 'SANTIAGO',
            ],
            [
                'name' => 'SANTIAGO 1',
            ],
            [
                'name' => 'SANTIAGO 2',
            ],
            [
                'name' => 'SARIAYA',
            ],
            [
                'name' => 'SAU - AREA 4',
            ],
            [
                'name' => 'SAU AUTO LOANS - BATANGAS',
            ],
            [
                'name' => 'SAU HO',
            ],
            [
                'name' => 'SAU MEXICO',
            ],
            [
                'name' => 'SAU SME',
            ],
            [
                'name' => 'SAU TRUCK',
            ],
            [
                'name' => 'SBMA',
            ],
            [
                'name' => 'SGMA PS',
            ],
            [
                'name' => 'SGMA PS 2',
            ],
            [
                'name' => 'SGMA PS 3',
            ],
            [
                'name' => 'SGMA PS 4',
            ],
            [
                'name' => 'SINDALAN',
            ],
            [
                'name' => 'Singcang',
            ],
            [
                'name' => 'SOGOD',
            ],
            [
                'name' => 'SOLANO',
            ],
            [
                'name' => 'SORSOGON',
            ],
            [
                'name' => 'SRS CEBU',
            ],
            [
                'name' => 'STA. CRUZ',
            ],
            [
                'name' => 'STA. MARIA',
            ],
            [
                'name' => 'STA. MESA',
            ],
            [
                'name' => 'STA. ROSA',
            ],
            [
                'name' => 'STO TOMAS',
            ],
            [
                'name' => 'SUCAT',
            ],
            [
                'name' => 'SUMULONG',
            ],
            [
                'name' => 'SURALLAH',
            ],
            [
                'name' => 'SURIGAO 2',
            ],
            [
                'name' => 'TABACO',
            ],
            [
                'name' => 'TACLOBAN',
            ],
            [
                'name' => 'TACLOBAN 2',
            ],
            [
                'name' => 'TACLOBAN PS 5',
            ],
            [
                'name' => 'TACURONG',
            ],
            [
                'name' => 'TAGAYTAY',
            ],
            [
                'name' => 'TAGBILARAN',
            ],
            [
                'name' => 'TAGUIG 1',
            ],
            [
                'name' => 'TAGUIG 2',
            ],
            [
                'name' => 'TAGUM',
            ],
            [
                'name' => 'TALAVERA',
            ],
            [
                'name' => 'TANAUAN',
            ],
            [
                'name' => 'TANAY',
            ],
            [
                'name' => 'TANDAG',
            ],
            [
                'name' => 'TANJAY',
            ],
            [
                'name' => 'TANZA CAVITE',
            ],
            [
                'name' => 'TARLAC',
            ],
            [
                'name' => 'TAYTAY',
            ],
            [
                'name' => 'TOLEDO',
            ],
            [
                'name' => 'TORIL',
            ],
            [
                'name' => 'TRECE MARTIREZ CAVITE',
            ],
            [
                'name' => 'TUGUEGARAO',
            ],
            [
                'name' => 'TUNGKO',
            ],
            [
                'name' => 'URDANETA',
            ],
            [
                'name' => 'VALENCIA',
            ],
            [
                'name' => 'VALENZUELA',
            ],
            [
                'name' => 'VIGAN',
            ],
            [
                'name' => 'VIGAN',
            ],
            [
                'name' => 'VISAYAS 1 PS',
            ],
            [
                'name' => 'VISAYAS 2 PS',
            ],
            [
                'name' => 'VISAYAS 3 PS',
            ],
            [
                'name' => 'VISAYAS 4 PS',
            ],
            [
                'name' => 'VISAYAS AVE.',
            ],
            [
                'name' => 'ZAMBOANGA',
            ],
            [
                'name' => 'MAIN',
            ],
            [
                'name' => 'DOWNTOWN',
            ],
            [
                'name' => 'BACOLOD LACSON',
            ],
            [
                'name' => 'BNC',
            ],



        ]);

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
                'product_id' => 1,
                'name' => 'TRUCK',
            ],
            [
                'product_id' => 2,
                'name' => 'TRUCK',
            ],
            [
                'product_id' => 3,
                'name' => 'TRUCK',
            ],
            [
                'product_id' => 4,
                'name' => 'TRUCK',
            ],
            [
                'product_id' => 5,
                'name' => 'TRUCK',
            ],
            [
                'product_id' => 1,
                'name' => 'WAGON',
            ],
            [
                'product_id' => 2,
                'name' => 'WAGON',
            ],
            [
                'product_id' => 3,
                'name' => 'WAGON',
            ],
            [
                'product_id' => 4,
                'name' => 'WAGON',
            ],
            [
                'product_id' => 5,
                'name' => 'WAGON',
            ],
            [
                'product_id' => 1,
                'name' => 'SEDAN',
            ],
            [
                'product_id' => 2,
                'name' => 'SEDAN',
            ],
            [
                'product_id' => 3,
                'name' => 'SEDAN',
            ],
            [
                'product_id' => 4,
                'name' => 'SEDAN',
            ],
            [
                'product_id' => 5,
                'name' => 'SEDAN',
            ],
            [
                'product_id' => 1,
                'name' => 'LUXURY CAR',
            ],
            [
                'product_id' => 2,
                'name' => 'LUXURY CAR',
            ],
            [
                'product_id' => 3,
                'name' => 'LUXURY CAR',
            ],
            [
                'product_id' => 4,
                'name' => 'LUXURY CAR',
            ],
            [
                'product_id' => 5,
                'name' => 'LUXURY CAR',
            ],
            [
                'product_id' => 1,
                'name' => 'MOTORCYCLE',
            ],
            [
                'product_id' => 2,
                'name' => 'MOTORCYCLE',
            ],
            [
                'product_id' => 3,
                'name' => 'MOTORCYCLE',
            ],
            [
                'product_id' => 4,
                'name' => 'MOTORCYCLE',
            ],
            [
                'product_id' => 5,
                'name' => 'MOTORCYCLE',
            ],

        ]);

        DB::table('if_gdfis')->insert([
            [
                // 'id' => 1
                'name' => 'BRANCH DIVISION',
            ],

        ]);
        DB::table('source_divisions')->insert([
            [
                'source_id' => 1,
                'name' => 'AUTO LOANS',
                'status' => 'active'

            ],
            [
                'source_id' => 1,
                'name' => 'TRUCK LOANS',
                'status' => 'active'

            ],
            [
                'source_id' => 1,
                'name' => 'BRAND NEW CARS',
                'status' => 'active'

            ],
            [
                'source_id' => 2,
                'name' => 'BRAND NEW CARS',
                'status' => 'active'

            ],
            [
                'source_id' => 3,
                'name' => 'BRAND NEW CARS',
                'status' => 'active'

            ],
            [
                'source_id' => 2,
                'name' => 'BRANCH DIVISION',
                'status' => 'active'

            ],
            [
                'source_id' => 2,
                'name' => 'CAR FD',
                'status' => 'active'

            ],
            [
                'source_id' => 2,
                'name' => 'TRUCK FD',
                'status' => 'active'

            ],
            [
                'source_id' => 3,
                'name' => 'BRANCH REFINANCING',
                'status' => 'active'

            ],
            [
                'source_id' => 3,
                'name' => 'SAU',
                'status' => 'active'

            ],
            [
                'source_id' => 3,
                'name' => 'TRUCK FINANCING',
                'status' => 'active'

            ],

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
                'name' => 'BACOLOD',
            ],
            [
                'name' => 'BICUTAN',
            ],
            [
                'name' => 'HEAD OFFICE',
            ],
            [
                'name' => 'CDO',
            ],
            [
                'name' => 'CEBU',
            ],
            [
                'name' => 'DAGUPAN',
            ],
            [
                'name' => 'DASMARINAS',
            ],
            [
                'name' => 'DAVAO',
            ],
            [
                'name' => 'GENSAN',
            ],
            [
                'name' => 'LIFEHOMES',
            ],
            [
                'name' => 'LIPA',
            ],
            [
                'name' => 'PAMPANGA',
            ],
            [
                'name' => 'SANTIAGO',
            ],
            [
                'name' => 'BICUTAN',
            ],
            [
                'name' => 'ILOILO',
            ],
            [
                'name' => 'NUEVA ECIJA',
            ],
            [
                'name' => 'BAGUIO',
            ],
            [
                'name' => 'BATANGAS',
            ],

        ]);

        DB::table('mode_of_payments')->insert([
            [
                'name' => 'ADD ON',
            ],
            [
                'name' => 'ADD ON + CASH INSTALLMENT',
            ],
            [
                'name' => 'BILLED',
            ],
            [
                'name' => 'BILLED + CASH INSTALLMENT',
            ],
            [
                'name' => 'CASH INSTALLMENT',
            ],
            [
                'name' => 'DIRECT PAYMENT',
            ],
            [
                'name' => 'FREE INSURANCE',
            ],
            [
                'name' => 'FULL CASH',
            ],
            [
                'name' => 'FULL LTP',
            ],
            [
                'name' => 'LTP + CASH INSTALLMENT',
            ],
            [
                'name' => 'LTP + PDC',
            ],
            [
                'name' => 'PDC',
            ],
            [
                'name' => 'SALARY DEDUCT',
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

        DB::table('commissioners')->insert([
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
            ],
            [
                // 'id' => 17
                'name' => 'Off Setting',
            ],
            [
                // 'id' => 18
                'name' => 'Promo',
            ],
            [
                // 'id' => 18
                'name' => 'Travel Incentives',
            ],
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
            ['username' => 'rexmillan', 'name' => 'REX MILLAN', 'email' => 'rexmillan@email.com'],
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
        $userId = 8;  // Start from user_id 8

        foreach ($users as $index => $user) {
            // Adding additional fields for each user
            $users[$index] = array_merge($user, [
                'password' => Hash::make('ALFCpassword'),
                'viber_number' => '09123456789',  // Example Viber number for all users
                'role_id' => 5,  // Assuming '5' is the role ID for sales associates
                'status' => 'verified',  // Default status as 'verified'
            ]);

            // Prepare the sales associates data
            $salesAssociates[] = [
                'name' => $user['name'],
                'user_id' => $userId++,  // Increment user_id for each sales associate
                'team_id' => 1,  // Assuming all are in team 1
            ];
        }


        // Insert the users with the new fields into the 'users' table
        DB::table('users')->insert($users);

        // Insert the sales associates into the 'sales_associates' table
        DB::table('sales_associates')->insert($salesAssociates);

        DB::table('sales_managers')->insert([
            [
                'user_id' => 1,
                'team_id' => 1,
                'name' => 'Alice Johnson',
                'status' => 'Active',
            ],
            [
                'user_id' => 2,
                'team_id' => 1,
                'name' => 'Bob Smith',
                'status' => 'Inactive',
            ],
            [
                'user_id' => 3,
                'team_id' => 2,
                'name' => 'Catherine Lee',
                'status' => 'Active',
            ],
            [
                'user_id' => 4,
                'team_id' => 3,
                'name' => 'David Martinez',
                'status' => 'Active',
            ],
            [
                'user_id' => 5,
                'team_id' => 2,
                'name' => 'Eleanor Green',
                'status' => 'Inactive',
            ],
        ]);





    }


}
