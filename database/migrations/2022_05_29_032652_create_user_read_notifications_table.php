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
        Schema::create('user_read_notifications', function (Blueprint $table) {
            $table->id();

            //If Selected Record On the model
            $table->string('model_type');
            $table->unsignedBigInteger('model_id');

            $table->foreignId('notification_id')->constrained('user_notifications')->onDelete('cascade');

            $table->boolean('read')->default(false);
            $table->boolean('open')->default(false);

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
        Schema::dropIfExists('user_read_notifications');
    }
};
