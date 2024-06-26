<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {




        Schema::create('product_categories', function (Blueprint $table) {
            $table->comment('Бүтгээгдэхүүны төрөл');
            $table->id();
            $table->string('name', 1000)->comment('Код');
            $table->text('description')->nullable()->comment('Тайлбар');
            $table->timestamps();
        });

        Schema::create('providers', function (Blueprint $table) {
            $table->comment('Нийлүүлэгч');
            $table->id();
            $table->string('name', 1000)->comment('Нэр');
            $table->string('contact', 1000)->comment('Холбоо барих');
            $table->string('address', 1000)->comment('Хаяг');
            $table->text('description')->nullable()->comment('Тайлбар');
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->comment('Бүтгээгдэхүүн');
            $table->id();
            $table->string('name', 1000)->comment('Нэр');
            $table->foreignId('provider_id')->comment("Нийлүүлэгч")->constrained('providers');
            $table->string('barcode', 1000)->comment('Баркод');
            $table->decimal('price', 10, 2)->comment('Үнэ');
            $table->foreignId('product_category_id')->comment("Бүтгээгдэхүүны төрөл")->constrained('product_categories');
            $table->text('description')->nullable()->comment('Тайлбар');
            $table->timestamps();
        });

        Schema::create('supplies', function (Blueprint $table) {
            $table->comment('Нийлүүлэлт');
            $table->id();
            $table->string('name')->comment('нийлүүлэлтийн нэр');
            $table->string('status')->comment('төрөв');
            $table->text('description')->nullable()->comment('Тайлбар');
            $table->timestamps();
        });

        Schema::create('supply_products', function (Blueprint $table) {
            $table->comment('Нийлүүлэлт бүртээгдэхүүн');
            $table->id();
            $table->foreignId('supply_id')->comment("Нийлүүлэлт")->constrained('supplies');
            $table->foreignId('product_id')->comment("Бүтээгдэхүүн")->constrained('products');
            $table->integer('expected_count')->comment('тоо');
            $table->integer('pcount')->nullable()->comment('тоо');
            $table->text('description')->nullable()->comment('Тайлбар');
            $table->timestamps();
        });

        Schema::create('branche_have_products', function (Blueprint $table) {
            $table->comment('Дансны түүх');
            $table->id();
            $table->foreignId('branch_id')->comment("Салбар")->constrained('branches');
            $table->foreignId('product_id')->comment("Бүтээгдэхүүн")->constrained('products');
            $table->integer('pcount')->comment('тоо');
            $table->string('reg_type')->comment('Зарлага эсэх');
            $table->foreignId('user_id')->comment("Бүтээгдэхүүн")->constrained('users');
            $table->text('description')->nullable()->comment('Тайлбар');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branche_have_products');
        Schema::dropIfExists('products');
        Schema::dropIfExists('providers');
        Schema::dropIfExists('product_categories');
        Schema::dropIfExists('branches');
    }
};
