<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('printers', function (Blueprint $table) {
            $table->id();
            $table->integer('toner');
            $table->boolean('ink');
            $table->boolean('in_network');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('printers');
    }
};
