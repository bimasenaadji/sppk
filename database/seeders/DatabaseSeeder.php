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
            TransactionSeeder::class,
            InvoiceSeeder::class,
            TaxInvoiceSeeder::class,
            OrderItemSeeder::class,
        ]);

        // Update tax_id pada customers setelah tax_invoices tersedia
        DB::table('customers')->where('id', 1)->update(['tax_id' => 1]);

        User::create(
            [
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password'),
            ]
        );
    }
}
