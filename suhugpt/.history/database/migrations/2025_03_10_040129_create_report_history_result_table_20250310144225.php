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
        Schema::create('report_history_result', function (Blueprint $table) {
            $table->id();
            $table->string('id_mesin')->uniqie();
            $table->float('rata_rata_suhu');
            $table->float('rata_rata_kelembaban');
            $table->dateTime('waktu');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_history_result');
    }
};
