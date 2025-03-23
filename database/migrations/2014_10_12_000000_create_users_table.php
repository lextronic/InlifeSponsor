<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('address');
            $table->string('role');
            $table->string('level')->nullable(); // Allows null values for level
            $table->timestamp('email_verified_at')->nullable(); // Untuk verifikasi email jika dibutuhkan
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            
            // Menambahkan kolom OTP
            $table->string('otp')->nullable();
            $table->timestamp('otp_expires_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Menghapus tabel users dan kolom tambahan
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('otp');
            $table->dropColumn('otp_expires_at');
        });

        Schema::dropIfExists('users');
    }
};
