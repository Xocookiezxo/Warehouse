<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Branch;
use App\Models\BranchHaveProduct;
use App\Models\Category;
use App\Models\Gender;
use App\Models\Menu;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\Provider;
use App\Models\SubCategory;
use App\Models\Supply;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Branch::create([
            'name' => 'Төв агуулах',
            'address' => 'агуулах',
            'description' => 'gg'
        ]);
        Branch::create([
            'name' => 'Хорооллол салбар',
            'address' => 'Баян гол дүүрэг 3-р хороолол',
            'description' => '99369989'
        ]);
        Branch::create([
            'name' => 'Засан салбар',
            'address' => 'хан уул дүүрэг 11-р хороо',
            'description' => '99369989'
        ]);
        Branch::create([
            'name' => 'Сансар салбар',
            'address' => 'Баянзүрх дүүрэг 2-р хороо',
            'description' => '99369989'
        ]);

        \App\Models\User::factory()->create([
            'register' => "лл12151215",
            'name' => 'Админ',
            'ovog' => 'Админ',
            'branch_id' => 1,
            'username' => 'admin',
            'phone' => '99161212',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'roles' => 'admin',
        ]);
        \App\Models\User::factory()->create([
            'register' => "хй12151214",
            'name' => 'Менежер',
            'ovog' => 'Менежер',
            'branch_id' => 1,
            'username' => 'manager',
            'phone' => '88151212',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'roles' => 'manager',
        ]);
        \App\Models\User::factory()->create([
            'register' => "хб12151219",
            'name' => 'Ажилтан 1',
            'ovog' => 'Ажилтан 1',
            'branch_id' => 2,
            'username' => 'staff1',
            'phone' => '70651212',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'roles' => 'staff',
        ]);

        \App\Models\User::factory()->create([
            'register' => "хб12151220",
            'name' => 'Ажилтан 2',
            'ovog' => 'Ажилтан 2',
            'branch_id' => 2,
            'username' => 'staff2',
            'phone' => '70651213',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'roles' => 'staff',
        ]);
        \App\Models\User::factory()->create([
            'register' => "хб12151221",
            'name' => 'Ажилтан 3',
            'ovog' => 'Ажилтан 3',
            'branch_id' => 3,
            'username' => 'staff3',
            'phone' => '70651213',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'roles' => 'staff',
        ]);


        ProductCategory::create([
            'name' => 'Цамц'
        ]);
        ProductCategory::create([
            'name' => 'Өмөд'
        ]);
        ProductCategory::create([
            'name' => 'Гутал'
        ]);
        ProductCategory::create([
            'name' => 'Хослол'
        ]);

        Provider::create([
            'name' => 'Шунхлай',
            "contact" => '70015050',
            "address" => 'Хаяг сонгино хайрхан',
        ]);
        Provider::create([
            'name' => 'ЭМСИЭС',
            "contact" => '70015050',
            "address" => 'Хаяг сонгино хайрхан',
        ]);
        Provider::create([
            'name' => 'АПУ',
            "contact" => '70015050',
            "address" => 'Хаяг сонгино хайрхан',
        ]);

        for ($i = 0; $i < 10; $i++) {
            Product::create([
                'name' => 'Цамц  ben ханцуйтай эр PE13/PE' . $i,
                'provider_id' => 1,
                'barcode' => 8031881225826 + $i,
                'price' => 399900,
                'product_category_id' => 1,
                'description' => "Тайлбар yuuch yum" . $i,
            ]);
        }
        for ($i = 0; $i < 10; $i++) {
            Product::create([
                'name' => 'Цамц  V товчтой B2 PE' . $i,
                'provider_id' => 2,
                'barcode' => 8031881225856 + $i,
                'price' => 599900,
                'product_category_id' => 1,
                'description' => "Тайлбар yuuch yum" . $i,
            ]);
        }
        for ($i = 0; $i < 10; $i++) {
            Product::create([
                'name' => 'Поло эмжээртэй  B3 PE' . $i,
                'provider_id' => 3,
                'barcode' => 8031881225956 + $i,
                'price' => 699900,
                'product_category_id' => 1,
                'description' => "Тайлбар yuuch yum" . $i,
            ]);
        }
        for ($i = 0; $i < 10; $i++) {
            Product::create([
                'name' => 'Өмд №' . $i,
                'provider_id' => 3,
                'barcode' => 8031881215856 + $i,
                'price' => 699900,
                'product_category_id' => 2,
                'description' => "Тайлбар yuuch yum" . $i,
            ]);
        }
        for ($i = 0; $i < 10; $i++) {
            Product::create([
                'name' => 'Өмд №' . $i,
                'provider_id' => 3,
                'barcode' => 8031881215856 + $i,
                'price' => 699900,
                'product_category_id' => "2",
                'description' => "Тайлбар yuuch yum" . $i,
            ]);
        }
        $fake = fake();
        Supply::create([
            "name" => "2024-01-01 нийлүүлэлт",
            "status" => "in progress",
        ]);

        for ($i = 0; $i < 50; $i++) {
            BranchHaveProduct::create([
                'branch_id' =>  1,
                'product_id' =>  $i + 1,
                'pcount' =>  $fake->numberBetween(7, 20),
                'user_id' => 1,
                'reg_type' => "Oрлого",
            ]);
        }

        for ($i = 0; $i < 5; $i++) {
            BranchHaveProduct::create([
                'branch_id' => $fake->numberBetween(2, 3),
                'product_id' =>  $fake->numberBetween(1, 50),
                'pcount' => -2,
                'user_id' => 1,
                'reg_type' => "Зарлага",
            ]);
        }
    }
}
