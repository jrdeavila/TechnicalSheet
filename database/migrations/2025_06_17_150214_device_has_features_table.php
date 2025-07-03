<?php

use App\Models\Computer;
use App\Models\Device;
use App\Models\Feature;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('device_has_features', function (Blueprint $table) {
            $table->id();
            $table->foreignId('device_id')
                ->constrained('devices')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignId('feature_id')
                ->constrained('features')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unique(['device_id', 'feature_id']);
            $table->text('value');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        //
    }
};
