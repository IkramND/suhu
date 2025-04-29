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
            $table->string('id_mesin');
            $table->float('average_temperature');
            $table->float('average_humidity');
            $table->float('lowest_temperature');
            $table->float('highest_temperature');
            $table->float('lowest_humidity');
            $table->float('highest_humidity');
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
