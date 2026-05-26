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
        Schema::create('assessments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignUuid('teacher_id')->constrained('teachers')->onDelete('cascade');
            $table->integer('discipline');          // Nilai kedisiplinan (misal: skala 1-100)
            $table->integer('performance');         // Nilai performa/kinerja (misal: skala 1-100)
            $table->decimal('final_score', 5, 2);   // Nilai akhir (bisa desimal, contoh: 95.50)
            $table->text('note')->nullable();       // Kesimpulan/evaluasi tertulis dari guru
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assesments');
    }
};
