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
        Schema::create('archivos', function (Blueprint $table) {
            $table->bigIncrements('arc_id');
            $table->string('arc_nombre')->nullable();
            $table->string('arc_file')->nullable();
            $table->foreignId('env_id')->references('env_id')->on('envios');
            $table->integer('arc_estado')->unsigned()->default(1);
            $table->timestamp('arc_created')->useCurrent();
            $table->timestamp('arc_updated')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archivos');
    }
};
