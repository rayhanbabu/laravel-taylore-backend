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
        Schema::create('buttomcuts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dept_id');
            $table->foreign('dept_id')->references('id')->on('depts');
            $table->string('image')->nullable();
            $table->string('buttomcut_name');
            $table->string('buttomcut_des')->nullable();
            $table->string('buttomcut_status')->default(1);
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buttomcuts');
    }
};
