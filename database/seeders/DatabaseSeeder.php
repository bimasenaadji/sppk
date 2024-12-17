<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            TaxCategorySeeder::class,
            ServiceSeeder::class,
            CustomerSeeder::class,
            OrderSeeder::class,
            OrderItemSeeder::class,
            OrderSeeder::class,

            //     TransactionSeeder::class,
            //     InvoiceSeeder::class,
            //     TaxInvoiceSeeder::class,
            //     OrderItemSeeder::class,
        ]);

        // // Update tax_id pada customers setelah tax_invoices tersedia
        // DB::table('customers')->where('id', 1)->update(['tax_id' => 1]);
        // DB::table('customers')->where('id', 2)->update(['tax_id' => 2]);
        // DB::table('customers')->where('id', 3)->update(['tax_id' => 3]);
        // DB::table('customers')->where('id', 4)->update(['tax_id' => 1]);
        // DB::table('customers')->where('id', 5)->update(['tax_id' => 2]);
        // DB::table('customers')->where('id', 6)->update(['tax_id' => 3]);
        // DB::table('customers')->where('id', 7)->update(['tax_id' => 1]);
        // DB::table('customers')->where('id', 8)->update(['tax_id' => 2]);
        // DB::table('customers')->where('id', 9)->update(['tax_id' => 3]);
        // DB::table('customers')->where('id', 10)->update(['tax_id' => 1]);
        // DB::table('customers')->where('id', 11)->update(['tax_id' => 2]);
        // DB::table('customers')->where('id', 12)->update(['tax_id' => 3]);

        User::create(
            [
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password'),
            ]
        );
    }
}
