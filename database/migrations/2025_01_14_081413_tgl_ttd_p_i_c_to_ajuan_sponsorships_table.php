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
        Schema::table('ajuan_sponsorships', function (Blueprint $table) {
            $table->timestamp('picSigned_date')->nullable()->after('signature_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ajuan_sponsorships', function (Blueprint $table) {
            $table->dropColumn('picSigned_date');
        });
    }
};
