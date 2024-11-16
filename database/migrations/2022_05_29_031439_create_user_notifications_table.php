<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_notifications', function (Blueprint $table) {
            $table->id();

            //If Selected Record On the model
            $table->string('model_type')->nullable();
            $table->unsignedBigInteger('model_id')->nullable();

            //If Selected Template
            $table->foreignId('template_id')->nullable()->constrained('notifications_templates')->onDelete('cascade');

            //Else on public
            $table->text('title');
            $table->text('description')->nullable();
            $table->string('url')->nullable();
            $table->string('icon')->default('heroicon-o-check-circle')->nullable();
            $table->string('type')->default('success')->nullable();
            $table->string('privacy')->default('public')->nullable();
            $table->json('data')->nullable();

            //If Created By
            $table->foreignId('created_by')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_notifications');
    }
};
