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
        });

        DB::statement("ALTER TABLE `technical_sheets` ADD CONSTRAINT `technical_sheets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `timeit`.`usuarios`(`id`) ON DELETE SET NULL ON UPDATE CASCADE");
    }


    public function down(): void
    {
        DB::statement("ALTER TABLE `technical_sheets` DROP FOREIGN KEY `technical_sheets_user_id_foreign`");
        Schema::dropIfExists('technical_sheets');
    }
};
