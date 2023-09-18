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
        Schema::create('t_tasks', function (Blueprint $table) {
            $table->bigIncrements('task_id');
            $table->integer('user_id');
            $table->string('type')->default('normal');
            $table->text('title');
            $table->longText('description');
            $table->integer('status')->default(0);
            $table->timestamp('due_date')->nullable();
            $table->longText('labels')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_tasks');
    }
};
