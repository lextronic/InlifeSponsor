<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('ajuan_sponsorships', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pengaju')->nullable();
            $table->string('event_name');
            $table->text('description');
            $table->date('event_date');
            $table->date('end_date');
            $table->string('location');
            $table->string('organizer_name');
            $table->string('pic_name');
            $table->string('phone_number');
            $table->string('proposal')->nullable();  // Menyimpan path file proposal
            $table->boolean('is_approved')->default(false);
            $table->boolean('is_rejected')->default(false);
            $table->boolean('is_banding')->default(false);
            $table->boolean('is_review')->default(false);
            $table->boolean('is_aktif')->default(false);
            $table->boolean('is_done')->default(false);
            $table->unsignedBigInteger('id_pr')->nullable();
            $table->date('meeting_date')->nullable();
            $table->time('meeting_time')->nullable();
            $table->string('meeting_location')->nullable();
            $table->text('catatan_meeting')->nullable();
            $table->string('dokumen_tambahan')->nullable();
            $table->json('benefit')->nullable();
            $table->json('dokumentasi_distribusi')->nullable()->comment('Dokumen dokumentasi terkait benefit');
            $table->text('alasan_banding')->nullable();
            $table->string('signature_path')->nullable();
            $table->string('pic_barcode')->nullable();
            $table->string('signature_PR')->nullable();
            $table->string('pr_barcode')->nullable();
            $table->string('mou_path')->nullable();
            $table->string('pic_email')->nullable(); // Add pic_email field
            $table->integer('estimated_participants')->nullable(); // Add estimated_participants field
            $table->timestamps();

            $table->foreign('id_pengaju')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_pr')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ajuan_sponsorships');
    }
};
