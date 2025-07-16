<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ekg_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->string('result_file_path');
            $table->timestamp('examination_date');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ekg_results');
    }
};