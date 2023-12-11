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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->dateTime('deadline');
            $table->foreignId('user_id')->nullable()->index()->constrained('users')->onDelete('cascade');
            $table->foreignId('performer_id')->nullable()->index()->constrained('users')->onDelete('cascade');
            $table->foreignId('project_id')->nullable()->index()->constrained('projects');
            $table->string('file')->nullable();
            $table->unsignedSmallInteger('status')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
