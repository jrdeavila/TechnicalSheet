<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('computer_has_peripherals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('computer_id')
                ->constrained('computers')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignId('peripheral_id')
                ->constrained('peripherals')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        //
    }
};
