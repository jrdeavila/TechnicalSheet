<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('technical_sheets', function (Blueprint $table) {
            $table->id();
            $table->morphs('technical_sheetable', 'technical_sheetable_index');
            $table->integer('user_id')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on(env('DB_TIMEIT_DATABASE') . '.usuarios')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('technical_sheets');
    }
};
