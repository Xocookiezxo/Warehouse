<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('genders', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable()->comment('Нийгмийн даатгалын дугаар');
            $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->comment('Хэрэглэгч');
            $table->id();
            $table->string('name')->comment('Нэр');;
            $table->string('phone')->nullable()->unique()->comment('Утас');
            $table->string('username')->nullable()->comment('Нэр');
            $table->string('password')->comment('Нууц үг');
            $table->string('roles')->comment('Эрхийн түвшин');
            $table->rememberToken();
            $table->string('push_token')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('genders');
    }
};
